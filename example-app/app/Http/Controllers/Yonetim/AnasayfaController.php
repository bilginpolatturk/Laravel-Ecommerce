<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Siparis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnasayfaController extends Controller
{
    public function index(){

            // View Share İle Aldık App Service Provider

       /* if(!Cache::has('istatistikler')) {
            $istatistikler = [
                'asd' => Siparis::where('durum', 'Siparişiniz Alındı')->count()];

          //  $bitisZamani = now()->addMinutes(10);
           // Cache::put('istatistikler', $istatistikler, $bitisZamani);
            Cache::put('istatistikler', $istatistikler, now()->addMinutes(10));

        }else{

            $istatistikler = Cache::get('istatistikler');

        }*/

           // Cache::forget('istatistikler');
            // Cache::flush(); Tüm cacheleri sil

        $cok_satan_urunler = DB::select("SELECT u.urun_adi,sum(adet) adet FROM siparis si INNER JOIN sepet s ON s.id = si.sepet_id
        INNER JOIN sepet_urun su ON s.id = su.sepet_id
        INNER JOIN urun u ON u.id = su.urun_id
        GROUP BY u.urun_adi
        ORDER BY SUM(su.adet) DESC
        ");

        $aylara_gore_satislar = DB::select("
        SELECT
        DATE_FORMAT(si.olusturulma_tarihi,'%Y-%m') ay, sum(su.adet) adet
        FROM siparis si
        INNER JOIN sepet s ON s.id = si.sepet_id
        INNER JOIN sepet_urun su ON s.id = su.sepet_id
        GROUP BY DATE_FORMAT(si.olusturulma_tarihi,'%Y-%m')
        ORDER BY DATE_FORMAT(si.olusturulma_tarihi,'%Y-%m')
        ");

        return view('yonetim.anasayfa',compact('cok_satan_urunler','aylara_gore_satislar'));
    }
}
