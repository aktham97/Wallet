<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
      'wallet_balance','total_income','total_expenses','user_id'
    ];
}
