<?php
defined('BASEPATH') or exit('No direct script access allowed');

function generate_cookie()
{
    $random = bin2hex(random_bytes(16));
    $token = base64_encode($random);
    $cookie = [
        'name'   => 'auth_token',
        'value'  => $token,
        'expire' => '30000',
    ];
    return $cookie;
}
