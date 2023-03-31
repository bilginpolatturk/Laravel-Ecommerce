<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(){

        if (\request()->filled('aranan') || \request()->filled('ust_id')){
            \request()->flash();
            $aranan = \request('aranan');
            $ust_id = \request('ust_id');
            $list = Kategori::where('kategori_adi','like',"%$aranan%")
                ->where('ust_id',$ust_id)
                ->orderByDesc('id')
                ->paginate(8)
                ->appends(['aranan'=>$aranan,'ust_id'=>$ust_id]);
        }else {
            \request()->flush();
            $list = Kategori::orderByDesc('id')->paginate(8);
        }


        $ustkategoriler = Kategori::whereRaw('ust_id is null')->get();
        return view('yonetim.kategori.index',compact('list','ustkategoriler'));

    }

    public function form($id = 0){
        $entry = new Kategori;
        if($id>0){
            $entry = Kategori::find($id);
        }

        $kategoriler = Kategori::all();

        return view('yonetim.kategori.form',compact('entry','kategoriler'));
    }

    public function kaydet($id = 0){


        $data = \request()->only('kategori_adi','slug','ust_id');
        if(!\request()->filled('slug')){
            $data['slug'] = Str::slug(\request('kategori_adi'));
            \request()->merge(['slug'=> $data['slug']]);
        }

        $this->validate(\request(),[
            'kategori_adi' => 'required',
            'slug' => (\request('original_slug') != \request('slug') ? 'unique:kategori,slug' : '')

        ]);

        if($id>0){ //guncelle
            $entry = Kategori::where('id',$id)->firstOrFail();

            $entry->update($data);

        }else{ //kaydet
            $entry = Kategori::create($data);
        }



        return redirect()->route('yonetim.kategori.duzenle',$entry->id)->with('mesaj_tur','success')->with('mesaj',($id>0 ? 'Güncellendi.' : 'Kaydedildi.'));

    }

    public function sil($id){

        $kategori = Kategori::find($id);
        $kategori->urunler()->detach(); //many to many silinen kategori ürünlerini kaldır

        Kategori::destroy($id);

        return redirect()->route('yonetim.kategori')->with('mesaj_tur','success')->with('mesaj','Kategori Silindi.');
    }
}
