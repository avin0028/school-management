<?php
defined('BASEPATH') or exit('No direct script access allowed');

function generate_auth_cookie($cookie)
{
    $token = base64_encode($cookie);
    $cookie = [
        'name'   => 'auth_token',
        'value'  => $token,
        'expire' => '30000',
    ];
    return $cookie;
}
