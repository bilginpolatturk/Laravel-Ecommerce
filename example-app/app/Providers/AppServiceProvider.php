<?php

namespace App\Providers;

use App\Models\Kategori;
use App\Models\Siparis;
use App\Models\Urun;
use App\Models\Kullanici;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       /* $istatistikler = Cache::remember('istatistikler',now()->addMinutes(1),function (){

            return [
                'asd' => Siparis::where('durum', 'Siparişiniz Alındı')->count(),
                'odeme_alinan' => Siparis::where('durum', 'Ödeme Onaylandı')->count(),
                'kargo_verilen' => Siparis::where('durum', 'Kargoya Verildi')->count(),
                'teslim_edilen' => Siparis::where('durum', 'Teslim Edildi')->count()

            ];

        });

        View::share('istatistikler',$istatistikler);*/

        View::composer(['yonetim.*'],function ($view){
            $istatistikler = Cache::remember('istatistikler',now()->addMinutes(1),function (){

                return [
                    'asd' => Siparis::where('durum', 'Siparişiniz Alındı')->count(),
                    'odeme_alinan' => Siparis::where('durum', 'Ödeme Onaylandı')->count(),
                    'kargo_verilen' => Siparis::where('durum', 'Kargoya Verildi')->count(),
                    'teslim_edilen' => Siparis::where('durum', 'Teslim Edildi')->count(),
                    'toplam_urun' => Urun::count(),
                    'toplam_kullanici' => Kullanici::count(),
                    'toplam_kategori' => Kategori::count()

                ];

            });

            $view->with('istatistikler',$istatistikler);


        });

    }
}
