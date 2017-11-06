<?php

use Acacha\Forge\Models\Server;
use Acacha\Forge\Notifications\ServerPermissionRequested;
use App\User;
use NotificationChannels\Telegram\Telegram;
use NotificationChannels\Telegram\TelegramMessage;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Themsaid\Forge\Forge;
use GuzzleHttp\Client as HttpClient;

if (! function_exists('initialize_forge_management_permissions')) {

    /**
     * Initialize staff management permissions and roles.
     */
    function initialize_forge_management_permissions()
    {
        //ROLES
        $manageForge = role_first_or_create('manage-forge');
        $student = role_first_or_create('student');

        //MANAGE FORGE ROLE
        permission_first_or_create('list-user-servers');
        permission_first_or_create('store-user-servers');
        permission_first_or_create('ask-server-permissions');
        permission_first_or_create('validate-server-permissions');
        permission_first_or_create('create-server-sites');

        give_permission_to_role($manageForge,'list-user-servers');
        give_permission_to_role($manageForge,'store-user-servers');
        give_permission_to_role($manageForge,'ask-server-permissions');
        give_permission_to_role($manageForge,'validate-server-permissions');
        give_permission_to_role($manageForge,'create-server-sites');

        //STUDENT ROLE
        permission_first_or_create('todo');
        give_permission_to_role($student,'todo');

        app(PermissionRegistrar::class)->registerPermissions();

    }
}

if (! function_exists('first_user_as_forge_manager')) {
    /**
     * Seed teachers.
     */
    function first_user_as_forge_manager()
    {
        initialize_forge_management_permissions();
        $user = User::all()->first();
        $user->assignRole('manage-forge');
    }
}

if (! function_exists('role_first_or_create')) {
    /**
     * Create  role by name or retrieve role if already exists.
     * @param $role
     * @return \Illuminate\Database\Eloquent\Model|\Spatie\Permission\Contracts\Role|Role
     */
    function role_first_or_create($role)
    {
        try {
            return Role::create(['name' => $role]);
        } catch (RoleAlreadyExists $e) {
            return Role::findByName($role);
        }
    }
}

if (! function_exists('permission_first_or_create')) {
    /**
     * Create permission by name or retrieve permission if already exists.
     *
     * @param $permission
     * @return \Illuminate\Database\Eloquent\Model|\Spatie\Permission\Contracts\Permission
     */
    function permission_first_or_create($permission)
    {
        try {
            return Permission::create(['name' => $permission]);
        } catch (PermissionAlreadyExists $e) {
            return Permission::findByName($permission);
        }
    }
}

if (! function_exists('give_permission_to_role')) {
    /**
     * @param $role
     * @param $permission
     */
    function give_permission_to_role($role, $permission)
    {
        try {
            $role->givePermissionTo($permission);
        } catch (Illuminate\Database\QueryException $e) {
            info('Permissions ' . $permission . ' already assigned to role ' . $role->name);
        }
    }
}

if (! function_exists('forge_servers')) {
    /**
     * Get forge servers
     */
    function forge_servers()
    {
        return resolve(Forge::class)->servers();
    }
}


if (! function_exists('random_forge_server')) {
    /**
     * Get forge servers
     */
    function random_forge_server()
    {
        return collect(forge_servers())->random();
    }
}

if (! function_exists('notify_test')) {
    /**
     * Get forge servers
     */
    function notify_test($to,$text)
    {

        $telegram = new Telegram(
            config('services.telegram-bot-api.token'),
            new HttpClient());

        $telegram->sendMessage([
            'chat_id' => $to,
            'text' => $text,
            'parse_mode' => 'Markdown',
        ]);
    }
}

if (! function_exists('notify_server_permission_requested_alt')) {
    /**
     * Notify server permission requested alt.
     */
    function notify_server_permission_requested_alt($user,$server)
    {
        $telegram = new Telegram(
            config('services.telegram-bot-api.token'),
            new HttpClient());

        $message = TelegramMessage::create()
            ->to(env('TELEGRAM_ACACHA_FORGE_MANAGERS_CHAT_ID')) // Optional.
            ->content("A new permission has been requested\n User: $user \n Server: $server ") // Markdown supported.
            ->button('Accept', 'http://acacha.org/accept'); // Inline Button

        $telegram->sendMessage($message->toArray());
    }
}

if (! function_exists('notify_server_permission_requested')) {
    /**
     *
     * Notify server permission requested.
     */
    function notify_server_permission_requested( $server = null)
    {
        if ( ! $server ) $server = factory(Server::class)->create();
        resolve(Illuminate\Notifications\ChannelManager::class)->send(null, new ServerPermissionRequested($server));
    }
}


