<?php

namespace Acacha\Forge\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreGitRepository.
 *
 * @package Acacha\Forge\Http\Requests
 */
class StoreGitRepository extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Servers is a valid server for the user
        if (in_array($this->serverId,Auth::user()->servers()->valid()->get()->pluck('forge_id')->toArray())) return true;
        if (Auth::user()->can('install-git-repositories')) return true;
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