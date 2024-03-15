<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
    'currency_name',
    'currency_country',
    'buying_rate',
    'selling_rate',
    'usd_exrate',
    'is_active',

];
}
