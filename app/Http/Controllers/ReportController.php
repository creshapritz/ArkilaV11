<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function sales(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $year = $request->input('year') ?? Carbon::now()->year;

        // Get list of available years for dropdown
        $availableYears = Booking::selectRaw('YEAR(created_at) as year')
            ->whereIn('status', ['Paid', 'Returned'])
            ->distinct()
            ->pluck('year')
            ->sortDesc();

        $query = Booking::with(['client', 'car'])
            ->whereIn('status', ['Paid', 'Returned'])
            ->whereYear('created_at', $year);

        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }

        $bookings = $query->latest()->paginate(10);
        $totalRevenue = $bookings->sum('amount');

        // Start of time frames for the selected year
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfQuarter = Carbon::now()->firstOfQuarter();
        $startOfYear = Carbon::createFromDate($year, 1, 1);
        $endOfYear = Carbon::createFromDate($year, 12, 31)->endOfDay();

        $dailyIncome = Booking::whereDate('created_at', $today)
            ->whereYear('created_at', $year)
            ->whereIn('status', ['Paid', 'Returned'])
            ->sum('amount');

        $weeklyIncome = Booking::whereBetween('created_at', [$startOfWeek, now()])
            ->whereYear('created_at', $year)
            ->whereIn('status', ['Paid', 'Returned'])
            ->sum('amount');

        $monthlyIncome = Booking::whereBetween('created_at', [$startOfMonth, now()])
            ->whereYear('created_at', $year)
            ->whereIn('status', ['Paid', 'Returned'])
            ->sum('amount');

        $quarterlyIncome = Booking::whereBetween('created_at', [$startOfQuarter, now()])
            ->whereYear('created_at', $year)
            ->whereIn('status', ['Paid', 'Returned'])
            ->sum('amount');

        $annualIncome = Booking::whereBetween('created_at', [$startOfYear, $endOfYear])
            ->whereIn('status', ['Paid', 'Returned'])
            ->sum('amount');

        return view('admin.reports.sales', compact(
            'bookings',
            'totalRevenue',
            'from',
            'to',
            'year',
            'availableYears',
            'dailyIncome',
            'weeklyIncome',
            'monthlyIncome',
            'quarterlyIncome',
            'annualIncome'
        ));
    }


    public function bookings(Request $request)
    {
        $query = Booking::with(['client', 'car'])->latest();


        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('pickup_date')) {
            $query->whereDate('pickup_date', $request->pickup_date);
        }

        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        $bookings = Booking::with(['client', 'car'])
            ->whereIn('status', ['Paid', 'Returned', 'Cancelled'])
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(request('pickup_date'), function ($query) {
                $query->whereDate('pickup_date', request('pickup_date'));
            })
            ->when(request('car_id'), function ($query) {
                $query->where('car_id', request('car_id'));
            })
            ->paginate(10);

        $cars = Car::all();

        return view('admin.reports.bookings', compact('bookings', 'cars'));
    }


    public function arkilaEarnings(Request $request)
    {
        $year = $request->input('year', now()->year);

        $bookings = Booking::with(['car.partner'])
            ->whereIn('status', ['paid', 'returned'])
            ->whereYear('created_at', $year)
            ->paginate(10);

        $arkilaShare = $bookings->sum(fn($booking) => $booking->amount * 0.20);

        $monthlyEarnings = [];
        foreach (range(1, 12) as $month) {
            $monthlyEarnings[date('F', mktime(0, 0, 0, $month, 10))] = $bookings->filter(
                fn($booking) => $booking->created_at->month == $month
            )->sum(fn($booking) => $booking->amount * 0.20);
        }

        $availableYears = Booking::selectRaw('YEAR(created_at) as year')
            ->whereIn('status', ['paid', 'returned'])
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.reports.arkila_earnings', compact(
            'bookings',
            'arkilaShare',
            'monthlyEarnings',
            'year',
            'availableYears'
        ));
    }


    public function clients(Request $request)
    {
        $query = Client::with('bookings')->whereHas('bookings');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $clients = $query->paginate(10);

        $clients->getCollection()->transform(function ($client) {
            $lastBooking = $client->bookings->sortByDesc('created_at')->first();
            return [
                'id' => $client->id,
                'name' => $client->first_name . ' ' . $client->last_name,
                'email' => $client->email,
                'total_bookings' => $client->bookings->count(),
                'total_spent' => $client->bookings->sum('amount'),
                'last_booking' => $lastBooking ? $lastBooking->created_at : null,
            ];
        });

        return view('admin.reports.clients', compact('clients'));
    }




    public function drivers(Request $request)
    {
        $driversQuery = \App\Models\Driver::with(['driverBookings', 'partner'])
            ->whereHas('driverBookings');

        // Filter by company name if provided
        if ($request->has('company_name') && $request->company_name != 'all') {
            $driversQuery->whereHas('partner', function ($query) use ($request) {
                $query->where('company_name', $request->company_name);
            });
        }

        // Paginate the drivers (10 per page for example)
        $drivers = $driversQuery->paginate(10)->through(function ($driver) {
            $lastBooking = $driver->driverBookings->sortByDesc('created_at')->first();

            return [
                'name' => $driver->name,
                'company_name' => optional($driver->partner)->company_name ?? 'N/A',
                'total_bookings' => $driver->driverBookings->count(),
                'total_earnings' => $driver->driverBookings->sum('total_driver_fee'),
                'last_booking' => optional($lastBooking)->created_at,
            ];
        });

        $companies = \App\Models\Partner::all()->pluck('company_name');

        return view('admin.reports.drivers', compact('drivers', 'companies'));
    }








    public function cars(Request $request)
    {
        $search = $request->input('search');

        $query = Car::withCount('bookings') // Add this to count bookings
            ->with([
                'bookings' => function ($query) {
                    $query->latest();
                }
            ])
            ->when($search, function ($query, $search) {
                $query->where('type', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            })
            ->orderByDesc('bookings_count'); // Sort from most to least booked

        $paginatedCars = $query->paginate(10)->withQueryString();

        $cars = $paginatedCars->getCollection()->map(function ($car) {
            return [
                'id' => $car->id,
                'type' => $car->type,
                'brand' => $car->brand,
                'platenum' => $car->platenum,
                'last_booking' => optional($car->bookings->first())->created_at,
                'total_bookings' => $car->bookings_count,
            ];
        });

        $carsPaginated = new LengthAwarePaginator(
            $cars,
            $paginatedCars->total(),
            $paginatedCars->perPage(),
            $paginatedCars->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.reports.cars', ['cars' => $carsPaginated]);
    }


}
