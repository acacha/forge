<?php

namespace Acacha\Forge\Http\Requests;

use Acacha\Forge\Http\Requests\Traits\ServerIsAssignedToUserAndValid;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreSSHKey.
 *
 * @package Acacha\Forge\Http\Requests
 */
class StoreSSHKey extends FormRequest
{
    use ServerIsAssignedToUserAndValid;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->isServerAssignedToUserAndValid($this->serverId)) {
            return true;
        }
        if (Auth::user()->can('install-ssh-keys')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'key' => 'required',
        ];
    }
}
