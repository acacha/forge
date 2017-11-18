<?php

namespace Acacha\Forge\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ServerSitesStore.
 *
 * @package Acacha\Forge\Http\Requests
 */
class ServerSitesStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( $this->serverIsOwnedByUser() ) return true;
        if ( Auth::user()->can('create-server-sites')) return true;
        return false;
    }

    /**
     * Servers is owned by user.
     *
     * @return bool
     */
    protected function serverIsOwnedByUser()
    {
        return in_array($this->forgeserver, Auth::user()->servers()->pluck('forge_id')->toArray());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'domain' => 'required',
            'project_type' => 'required',
            'directory' => 'required'
        ];
    }
}
