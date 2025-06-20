<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataFoto extends Model
{
    protected $fillable = ['data_id', 'path'];

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
