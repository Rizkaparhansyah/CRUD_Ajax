<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBiaya extends Model
{
    use HasFactory;
    protected $fillable = ['data_id', 'nama', 'nominal'];

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
