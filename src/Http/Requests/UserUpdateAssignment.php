<?php

namespace Acacha\Forge\Http\Requests;

use Acacha\Forge\Http\Requests\Traits\ChecksPermissions;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserUpdateAssignment.
 *
 * @package Acacha\Forge\Http\Requests
 */
class UserUpdateAssignment extends FormRequest
{
    use ChecksPermissions;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->can('update-assignment')) return true;
        if (Auth::user()->hasRole('student'))
            if ($this->owns('assignment')) return true;
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