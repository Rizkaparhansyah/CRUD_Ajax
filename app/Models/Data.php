<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $table = 'data';
    protected $guarded = [];

     public function fotos()
    {
        return $this->hasMany(\App\Models\DataFoto::class);
    }

    public function tipe()
    {
        return $this->belongsTo(Types::class, 'type_id');
    }

     public function biayas()
    {
        return $this->hasMany(\App\Models\DataBiaya::class);
    }
}
