<?php
defined('BASEPATH') or exit('No direct script access allowed');

function passwordhasher($input)
{
    return md5($input);
}
