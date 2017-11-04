<?php

namespace Acacha\Forge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ListUsers.
 *
 * @package Acacha\Forge\Http\Requests
 */
class ListUsers extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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