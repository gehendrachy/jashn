<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
		    'order_id', 'return_request_no', 'customer_id', 'total_price', 'status', 'remarks'
		];

	protected $hidden = [
        'customer_id', 'created_at', 'updated_at'
    ];

    public function return_request_products()
    {
    	return $this->hasMany(ReturnRequestProduct::class, 'return_request_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public static function return_status()
    {
        $return_status = [   
        					'0' => ['Requested', 'warning'],
                            '1' => ['Accepted', 'success'],
                            '2' => ['Rejected', 'danger']
                        ];

        return $return_status;
    }

}
