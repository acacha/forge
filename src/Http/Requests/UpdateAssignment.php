<?php

namespace Acacha\Forge\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DestroyAssignment.
 *
 * @package Acacha\Forge\Http\Requests
 */
class UpdateAssignment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can('update-assignment')) return true;
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