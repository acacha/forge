<?php

namespace Acacha\Forge\Http\Requests;

use Acacha\Forge\Http\Requests\Traits\ServerIsAssignedToUserAndValid;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreGitRepository.
 *
 * @package Acacha\Forge\Http\Requests
 */
class StoreGitRepository extends FormRequest
{
    use ServerIsAssignedToUserAndValid;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        if ($this->isServerAssignedToUserAndValid($this->serverId)) {
            return true;
        }
        if (Auth::user()->can('install-git-repositories')) {
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
            'repository' => 'required'
        ];
    }
}
