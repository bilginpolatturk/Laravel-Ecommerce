<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use App\Models\Urun;
use App\Models\UrunDetay;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Siparis;

class SiparisController extends Controller
{

    public function index(){

        if (\request()->filled('aranan')){
            \request()->flash();
            $aranan = \request('aranan');
            // eager nested loading
            $list = Siparis::with('sepet.kullanici')->where('adsoyad','like',"%$aranan%")
                ->orWhere('banka','like',"%$aranan%")
                ->orderByDesc('id')
                ->paginate(1);
        }else {
            // eager nested loading
            $list = Siparis::with('sepet.kullanici')->orderByDesc('id')->paginate(8);
        }
        return view('yonetim.siparis.index',compact('list'));

    }

    public function form($id = 0){

        if($id>0){
            $entry = Siparis::with('sepet.sepet_urunler.urun')->find($id);

        }



        return view('yonetim.siparis.form',compact('entry'));
    }

    public function kaydet($id = 0){



        $this->validate(\request(),[
            'adsoyad' => 'required',
            'adres' => 'required',
            'telefon' => 'required',
            'durum' => 'required'

        ]);

        $data = \request()->only('adsoyad','adres','telefon','ceptelefonu','durum');


        if($id>0){ //guncelle
            $entry = Siparis::where('id',$id)->firstOrFail();

            $entry->update($data);

        }



        return redirect()->route('yonetim.siparis.duzenle',$entry->id)->with('mesaj_tur','success')->with('mesaj',($id>0 ? 'Güncellendi.' : 'Kaydedildi.'));

    }

    public function sil($id){
        $urun = Siparis::find($id);
        $urun->delete();

        return redirect()->route('yonetim.siparis')->with('mesaj_tur','success')->with('mesaj','Sipariş Silindi.');
    }
}
