<?php

namespace Acacha\Forge\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DestroyUserServers.
 *
 * @package Acacha\Forge\Http\Requests
 */
class DestroyUserServers extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( Auth::user()->id === $this->user->id ) return true;
        if (Auth::user()->can('store-user-servers')) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}