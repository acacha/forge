<?php

namespace Acacha\Forge\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AskServerPermission.
 *
 * @package Acacha\Forge\Http\Requests
 */
class AskServerPermission extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->id === $this->user->id && $this->userHasServerAssigned()) {
            return true;
        }
        if (Auth::user()->can('ask-server-permissions')) {
            return true;
        }
        return false;
    }

    /**
     * Check if server is assigned to user.
     *
     * @return bool
     */
    protected function userHasServerAssigned()
    {
        return in_array($this->forgeserver->id, $this->user->servers->pluck('id')->toArray());
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
