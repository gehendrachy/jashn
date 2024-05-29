<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NICPayment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'total_price', 'response', 'created_at', 'updated_at'];
}
