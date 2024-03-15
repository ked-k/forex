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


// Update buying and selling rates based on new transaction rate
public function updateRates($newBuyingRate)
{
    // Get the current buying rate and profit percentage
    $currentBuyingRate = $this->buying_rate;
    $profitPercentage = $this->profit_percentage;

    // Calculate the new average buying rate
    $newAverageBuyingRate = ($currentBuyingRate + $newBuyingRate) / 2;

    // Calculate the new selling rate based on profit percentage
    $newSellingRate = $newAverageBuyingRate + ($newAverageBuyingRate * $profitPercentage / 100);

    // Update the rates
    $this->buying_rate = $newAverageBuyingRate;
    $this->selling_rate = $newSellingRate;
    $this->save();

    return [
        'new_average_buying_rate' => $newAverageBuyingRate,
        'new_selling_rate' => $newSellingRate,
    ];
}
}
