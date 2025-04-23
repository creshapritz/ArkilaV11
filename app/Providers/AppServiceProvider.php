<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Share logo with all views
        View::composer('*', function ($view) {
            $currentLogo = Setting::where('key', 'site_logo')->value('value');
            $view->with('currentLogo', $currentLogo);
        });

        View::composer('*', function ($view) {
            $primaryColor = getSetting('theme_color', '#F07324');
            $secondaryColor = getSetting('secondary_color', '#2E8B57');

            $view->with('primaryColor', $primaryColor);
            $view->with('secondaryColor', $secondaryColor);
            $view->with('primaryColorDark', adjustColorBrightness($primaryColor, -0.2));
            $view->with('secondaryColorDark', adjustColorBrightness($secondaryColor, -0.2));
        });

        $companyName = Setting::where('key', 'company_name')->value('value') ?? 'YourCompany';
        View::share('companyName', $companyName);

        $videoPath = Setting::where('key', 'welcome_video')->value('value') ?? 'assets/img/car2.mp4';
        $bannerPath = Setting::where('key', 'ads_banner')->value('value') ?? 'assets/img/adver.png';
        $footervideoPath = Setting::where('key', 'footer_video')->value('value') ?? 'assets/img/output.mp4';


        // Share to all Blade views
        View::share('videoPath', $videoPath);
        View::share('bannerPath', $bannerPath);
        View::share('footervideoPath', $footervideoPath);



    }


}
