<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepetUrun extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sepet_urun";

    protected $guarded = [];

    //created_at ve updated_at guncellediğimiz için ayarlama
    const CREATED_AT = 'olusturulma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    //Soft Delete Düzenleme(deleted_at yerine silinme_tarihi)
    const DELETED_AT = 'silinme_tarihi';


    public function urun(){
        return $this->belongsTo('App\Models\Urun');
    }


}
