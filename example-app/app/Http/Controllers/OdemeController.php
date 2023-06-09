<?php

namespace App\Http\Controllers;

use App\Models\Siparis;
use Illuminate\Http\Request;
use Cart;

class OdemeController extends Controller
{
    public function index(){
        if(!auth()->check()){
            return redirect()->route('kullanici.oturumac')
                ->with('mesaj_tur','info')
                ->with('mesaj','Ödeme işlemi için oturum açmanız veya kayıt olmanız gerekmektedir.');
        }else if(count(Cart::content())==0){
            return redirect()->route('anasayfa')
                ->with('mesaj_tur','danger')
                ->with('mesaj','Ödeme işlemi için sepetinizde bir ürün bulunması gerekmektedir.');
        }
        // Kullanıcı ad soyad adres telefon bilgilerini çekme

        $kullanici_detay = auth()->user()->detay;

        return view('layouts.odeme',compact('kullanici_detay'));
    }

    public function odemeyap(){

        $siparis = \request()->all();
        $siparis['sepet_id'] = session('aktif_sepet_id');
        $siparis['banka'] = "Maximum";
        $siparis['taksit_sayisi'] = 6;
        $siparis['durum'] = "Siparişiniz Alındı.";
        $siparis['siparis_tutari'] = Cart::subtotal();


        Siparis::create($siparis);
        Cart::destroy();
        session()->forget('aktif_sepet_id');

        return redirect()->route('siparisler')->with('mesaj_tur','success')->with('mesaj','Ödemeniz Başarılı bir şekilde gerçekleştirildi.');


    }
}
