<?php

namespace Acacha\Forge\Http\Controllers;

/**
 * Class ApiCheckTokenController.
 *
 * @package Acacha\Forge\Http\Controllers
 */
class APICheckTokenController extends Controller
{
    /**
     * Check tokne is valid
     * @return array
     */
    protected function index()
    {
        return [
            'message' => 'Token is valid'
        ];
    }
}
