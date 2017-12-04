<?php

namespace Acacha\Forge\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ListSites.
 *
 * @package Acacha\Forge\Http\Requests
 */
class ListSites extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $servers = Auth::user()->servers()->valid()->get();
        if (count($servers) === 0) {
            return false;
        }
        return in_array($this->server_id, $servers->pluck('forge_id')->toArray());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
