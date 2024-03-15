<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    public  $fillable = [
    'account_name',
    'account_number',
    'default_currency',
    'account_type',
    'available_balance',
    'user_id',
    'is_active'
    ];
}
