<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "urun";
    protected $guarded=[];
    //created_at ve updated_at guncellediğimiz için ayarlama
    const CREATED_AT = 'olusturulma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    //Soft Delete Düzenleme(deleted_at yerine silinme_tarihi)
    const DELETED_AT = 'silinme_tarihi';

    public function kategoriler(){
        return $this->belongsToMany('App\Models\Kategori','kategori_urun');
    }

    public function detay(){
        return $this->hasOne('App\Models\UrunDetay')->withDefault();
    }
}
