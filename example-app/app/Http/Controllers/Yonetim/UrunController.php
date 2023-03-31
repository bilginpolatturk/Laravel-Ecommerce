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

class UrunController extends Controller
{

    public function index(){

        if (\request()->filled('aranan')){
            \request()->flash();
            $aranan = \request('aranan');
            $list = Urun::where('urun_adi','like',"%$aranan%")
                ->orWhere('aciklama','like',"%$aranan%")
                ->orderByDesc('olusturulma_tarihi')
                ->paginate(1);
        }else {
            $list = Urun::orderByDesc('olusturulma_tarihi')->paginate(8);
        }
        return view('yonetim.urun.index',compact('list'));

    }

    public function form($id = 0){
        $entry = new Urun;
        $urun_kategoriler = [];
        if($id>0){
            $entry = Urun::find($id);
            $urun_kategoriler = $entry->kategoriler()->pluck('kategori_id')->all();
        }

        $kategoriler = Kategori::all();

        return view('yonetim.urun.form',compact('entry','kategoriler','urun_kategoriler'));
    }

    public function kaydet($id = 0){
        $data = \request()->only('urun_adi','slug','aciklama','fiyati');
        if(!\request()->filled('slug')){
            $data['slug'] = Str::slug(\request('urun_adi'));
            \request()->merge(['slug'=> $data['slug']]);
        }

        $this->validate(\request(),[
            'urun_adi' => 'required',
            'fiyati' => 'required',
            'slug' => (\request('original_slug') != \request('slug') ? 'unique:urun,slug' : '')

        ]);

        $data_detay = \request()->only('goster_slider','goster_gunun_firsati','goster_one_cikan','goster_cok_satan','goster_indirimli');

        $kategoriler = \request('kategoriler');
        if($id>0){ //guncelle
            $entry = Urun::where('id',$id)->firstOrFail();

            $entry->update($data);
            $entry->detay()->update($data_detay);
            $entry->kategoriler()->sync($kategoriler);

        }else{ //kaydet
            $entry = Urun::create($data);
            $entry->detay()->create($data_detay);
            $entry->kategoriler()->attach($kategoriler);
        }

        if(\request()->hasFile('urun_resmi')){
            $this->validate(\request(),[
               'urun_resmi' => 'image|mimes:jpg,png,jpeg,gif|max:2048'

            ]);

            $urun_resmi = \request()->file('urun_resmi');
          //  $urun_resmi = \request()->urun_resmi;

            $dosyaadi = $entry->id . "-" . time() . "." . $urun_resmi->extension();

            if($urun_resmi->isValid()){
                File::delete('uploads/urunler/' . $entry->detay->urun_resmi);
                $urun_resmi->move('uploads/urunler',$dosyaadi);
                //db kayıt

                UrunDetay::updateOrCreate(
                    ['urun_id'=> $entry->id],
                    ['urun_resmi'=>$dosyaadi]
                );


            }
        }

        return redirect()->route('yonetim.urun.duzenle',$entry->id)->with('mesaj_tur','success')->with('mesaj',($id>0 ? 'Güncellendi.' : 'Kaydedildi.'));

    }

    public function sil($id){
        $urun = Urun::find($id);
        $urun->kategoriler()->detach();
    //    $urun->detay()->delete();
        $urun->delete();

        return redirect()->route('yonetim.urun')->with('mesaj_tur','success')->with('mesaj','Ürün Silindi.');
    }
}
