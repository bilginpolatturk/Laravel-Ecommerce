<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siparis extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "siparis";

    protected $fillable = ['sepet_id','siparis_tutari', 'adsoyad','adres','telefon','ceptelefonu','banka','taksit_sayisi','durum'];


    //created_at ve updated_at guncellediğimiz için ayarlama
    const CREATED_AT = 'olusturulma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    //Soft Delete Düzenleme(deleted_at yerine silinme_tarihi)
    const DELETED_AT = 'silinme_tarihi';

    public function sepet(){
        return $this->belongsTo('App\Models\Sepet');
    }


}
