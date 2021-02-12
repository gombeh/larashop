<?php

namespace App\Listeners;

use App\Coupon;
use App\Jobs\UpdateCoupon;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $couponCode = optional(session()->get('coupon'))['name'];
        if($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            
            dispatch_now(new UpdateCoupon($coupon)); 
        }
    }
}
