<?php

function presentPrice($price) {
    return '$' . number_format($price, 2); 
}

function setActiveCategory($category, $output='active') {
    return request()->category == $category ? $output : '';
}


function getNumbers() {
    $tax = config('cart.tax') / 100;
    $discount = session()->get('coupon')['discount'] ?? 0;
    $code = session()->get('coupon')['name'] ?? null;
    $newSubtotal = (Cart::subtotal() - $discount);
    $newTax = $newSubtotal * $tax;
    $newTotal = $newSubtotal * (1 + $tax);

    return collect([
        'tax' => $tax,
        'discount' => $discount,
        'newSubtotal' => $newSubtotal,
        'newTax' =>$newTax,
        'code' => $code,
        'newTotal' => $newTotal
    ]);
}

function productImage($path) {
    return  $path && file_exists('storage/' . $path) ? asset('storage/' . $path) : asset('img/not-found.jpg');
}