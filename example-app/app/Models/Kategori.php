<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory;
    use SoftDeletes;
    // Laravel tablo sonuna s koymasını engelle
    protected $table = "kategori"; // Tablo Adı
    // Eloquent create hangi tablo eklenecek ayarla
    // protected $fillable = ['kategori_adi','slug'];
    //Tüm verilere izin ver
    protected $guarded=[];
    //created_at ve updated_at guncellediğimiz için ayarlama
    const CREATED_AT = 'olusturulma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    //Soft Delete Düzenleme(deleted_at yerine silinme_tarihi)
    const DELETED_AT = 'silinme_tarihi';

    public function urunler(){
        return $this->belongsToMany('App\Models\Urun','kategori_urun');
    }

    public function ust_kategori(){
        return $this->belongsTo('App\Models\Kategori','ust_id')->withDefault([
            'kategori_adi' => 'Üst Kategori Yok'
        ]);
    }


}
