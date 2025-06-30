<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companys';
    protected $guarded = [];

   
    public function partners()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }
}
