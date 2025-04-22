<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Car;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use App\Models\Driver;

require_once(app_path('Libraries/fpdf186/fpdf.php'));
use FPDF;

class AdminReportController extends Controller
{
    public function exportPDF(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = Booking::with(['client', 'car'])
            ->whereIn('status', ['Paid', 'Returned']);

        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }

        $bookings = $query->latest()->get();
        $totalRevenue = $bookings->sum('amount');

        $pdf = Pdf::loadView('admin.reports.sales-pdf', compact('bookings', 'totalRevenue', 'from', 'to'));
        $filename = 'ARKILA_Sales_Report_' . now()->format('Y_m_d_Hi') . '.pdf';

        return $pdf->download($filename);
    }




    public function exportBookingsPdf(Request $request)
    {
        $bookings = Booking::with(['client', 'car'])
            ->when($request->status, fn($query) => $query->where('status', $request->status))
            ->when($request->pickup_date, fn($query) => $query->whereDate('pickup_date', $request->pickup_date))
            ->when($request->car_id, fn($query) => $query->where('car_id', $request->car_id))
            ->whereNotIn('status', ['Pending', 'Partially Paid']) // Exclude both
            ->orderBy('created_at', 'desc')
            ->get();

        $date = now()->format('Y-m-d_H-i');
        $pdf = PDF::loadView('admin.reports.bookings-pdf', compact('bookings'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("bookings-report_$date.pdf");
    }

    public function exportClientsPDF(Request $request)
    {
        $query = Client::with('bookings')->whereHas('bookings');

        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $clients = $query->get()->map(function ($client) {
            $client->total_bookings = $client->bookings->count();
            $client->total_spent = $client->bookings->sum('amount');
            return $client;
        });

        $date = now()->format('Y-m-d_H-i');
        $pdf = PDF::loadView('admin.reports.clients_pdf', compact('clients'));

        return $pdf->download("clients_report_$date.pdf");
    }
    public function exportSpecificClientPDF(Request $request)
    {
        $email = $request->query('email');

        $client = Client::with([
            'bookings' => function ($query) {
                $query->where('status', 'paid')->orderBy('created_at', 'desc');
            }
        ])->where('email', $email)->firstOrFail();

        $bookings = $client->bookings;

        $date = now()->format('Y-m-d_H-i');
        $pdf = PDF::loadView('admin.reports.client_bookings_pdf', compact('client', 'bookings'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("{$client->first_name}_bookings_report_$date.pdf");
    }

    public function exportSpecificCarPDF($id)
    {
        $car = Car::with([
            'bookings' => function ($query) {
                $query->latest();
            }
        ])->findOrFail($id);

        $carData = [
            'id' => $car->id,
            'type' => $car->type,
            'brand' => $car->brand,
            'platenum' => $car->platenum,
            'last_booking' => optional($car->bookings->first())->created_at,
            'total_bookings' => $car->bookings->count(),
        ];

        $bookings = $car->bookings;

        $pdf = PDF::loadView('admin.reports.pdf.single-car', [
            'car' => $carData,
            'bookings' => $bookings,
            'dateNow' => Carbon::now()->format('F d, Y'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download("car-{$car->id}-report.pdf");
    }



    public function exportAllCarsPDF(Request $request)
    {
        $search = $request->input('search');
        $dateNow = Carbon::now()->format('F d, Y');
        $dateFilename = Carbon::now()->format('Y-m-d');

        $cars = Car::with([
            'bookings' => function ($query) {
                $query->latest();
            }
        ])
            ->when($search, function ($query, $search) {
                $query->where('type', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            })
            ->get()
            ->map(function ($car) {
                return [
                    'id' => $car->id,
                    'type' => $car->type,
                    'brand' => $car->brand,
                    'platenum' => $car->platenum,
                    'last_booking' => optional($car->bookings->first())->created_at,
                    'total_bookings' => $car->bookings->count(),
                ];
            });

        $pdf = PDF::loadView('admin.reports.pdf.all-cars', [
            'cars' => $cars,
            'dateNow' => $dateNow
        ])->setPaper('a4', 'landscape');

        return $pdf->download("car-report-{$dateFilename}.pdf");
    }

    public function exportArkilaReport(Request $request)
    {
        $year = $request->input('year', now()->year);

        $bookings = Booking::where('status', 'paid')
            ->whereYear('created_at', $year)
            ->with(['client', 'car'])
            ->orderBy('created_at', 'desc')
            ->get();

        $arkilaShare = $bookings->sum(function ($booking) {
            return $booking->amount * 0.20;
        });

        $pdf = Pdf::loadView('admin.reports.arkila_pdf', [
            'bookings' => $bookings,
            'year' => $year,
            'arkilaShare' => $arkilaShare,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('arkila_earnings_report_' . $year . '.pdf');
    }
    public function exportDriverReportPdf(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $company = $request->input('company');

        $query = Driver::with(['driverBookings', 'partner'])->whereHas('driverBookings');

        if ($company) {
            $query->where('partner_id', $company);
        }

        $drivers = $query->get()->map(function ($driver) use ($from, $to) {
            $filteredBookings = $driver->driverBookings;

            if ($from && $to) {
                $filteredBookings = $filteredBookings->filter(function ($booking) use ($from, $to) {
                    return $booking->created_at >= $from && $booking->created_at <= $to;
                });
            }

            $lastBooking = $filteredBookings->sortByDesc('created_at')->first();

            return [
                'name' => $driver->name,
                'company_name' => optional($driver->partner)->company_name ?? 'N/A',
                'total_bookings' => $filteredBookings->count(),
                'total_earnings' => $filteredBookings->sum('total_driver_fee'),
                'last_booking' => optional($lastBooking)->created_at,
            ];
        });

        return PDF::loadView('admin.reports.pdf.driver-report', compact('drivers', 'from', 'to', 'company'))
            ->download('driver_report_' . now()->format('Ymd_His') . '.pdf');
    }





}
