<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;
    protected $table = 'bonus';
    protected $guarded = [];

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
    public function partners()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }
    
}
