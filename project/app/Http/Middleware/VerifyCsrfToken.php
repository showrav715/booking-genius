<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/hotel/room/ajax/search/',
        '/hotel/rezorpay/checkout/notify',
        '/car/rezorpay/checkout/notify',
        '/space/rezorpay/checkout/notify',
        '/tour/rezorpay/checkout/notify',
    ];
}
