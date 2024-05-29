<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\NICPayment;
use App\Models\Order;

class PaymentController extends Controller
{

	public function custom(Request $request)
	{
		// dd(Auth::user());
		$order_no = session()->get('order_no_for_nic');
        // dd($order_no);
		return redirect()->route('nic.payment-status', ['order_no' => base64_encode($order_no), 'status' => 'canceled']);
		// return redirect()->route('checkout-confirmation')->with('error', 'Payment Canceled!');
	}

    public function thank_you(Request $request)
    {

		// dd(Auth::check());
        // dd($request);

        $access = "db5ff28911b9380e88d8745d5ad3acab";
        $profile_id = "24278DDF-212B-4A9E-B5C9-EA233FADBF5A";

        $user = auth()->user();
        // dd($user);
        $res = $request->all();
        
        
        $order = Order::where('order_no', $res['req_reference_number'])->first();
        
        if($res['decision'] === "ACCEPT" && $res['reason_code'] === "100" && $res['req_access_key'] === $access && $res['req_profile_id'] === $profile_id){

            $fieldValues = array();

            foreach(explode(',', $res['signed_field_names']) as $test){
                $text = $test . "=" . $res[$test];
                array_push($fieldValues, $text);
            }

            $joinedValue = join(',', $fieldValues);


            
            $hash = base64_encode(hash_hmac('sha256', $joinedValue, '59a829a47af34eacb304ec884b669665f6d358e66d1246d69f2cdbc038d90779147bd6c5fabd4f6d9f63a6133a1a701f97eff1cb4ad548c3b34b55ec702d006010ecce1630eb40b3bde0adbe914c38e9c74931a73a224216bc38d05ec5e4a2d6ee4ea2089be6480cb8d23e77191c0bb6107f7725f79245888f74c322dad0729f', true));
            $order = Order::where('order_no', $res['req_reference_number'])->first();
            // dd($hash === $res['signature']);
            if($hash === $res['signature']){

                
                $order->payment_status = 1;
                $order->save();

                if($order != null && $order){

                	$paymentArray = [
				                		'order_id' => $order->id,
				                		'total_price' => $order->total_price,
				                		'response' => json_encode($res),
				                		'created_at' => date('Y-m-d H:i:s'),
				                		'updated_at' => NULL
				                	];

                    NICPayment::create($paymentArray);

                    return redirect()->route('nic.payment-status', ['order_no' => base64_encode($order->order_no), 'status' => 'success']);
                }
            }
        }

        // dd('imhere');
        return redirect()->route('nic.payment-status', ['order_no' => base64_encode($order->order_no), 'status' => 'failed']);
    }

    public function payment_status($order_no, $status)
    {

    	// dd(Auth::check());

    	$order_no = base64_decode($order_no);

    	if (Auth::check()) {
    	    
    	    $order = Order::where([['customer_id', Auth::user()->id],['order_no', $order_no]])->first();
    	}else{

    	    $order = Order::where('order_no', $order_no)->first();
    	}
    	
    	// dd($order);
    	if (!$order) {
    	    return redirect()->route('home')->with('error','Order Detail Not Found.');
    	}

    	$order_status = Order::order_status();
    	$payment_method = Order::payment_method();
    	$canceled_reasons = Order::canceled_reasons();
    	$billing_details = json_decode($order->billing_details);
    	$shipping_details = json_decode($order->shipping_details);
    	
    	return view('checkout-success', compact('order', 'order_status', 'payment_method', 'canceled_reasons', 'billing_details', 'shipping_details', 'status'));

    }
}
