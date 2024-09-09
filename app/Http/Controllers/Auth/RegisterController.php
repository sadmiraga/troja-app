<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/onboarding';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        // Fetch the invitation based on the token
        $invite_token = $data['invite_token'];

        $invitation = DB::table('invitations')->where('token', $data['invite_token'])->first();

        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'], // Use the email from the invitation to ensure it matches
            'password' => Hash::make($data['password']),
        ]);

        // If the invitation does not exist, throw an error
        if (!$invitation) {
            return $user;
        }

        // Assign the permissions to the user based on the invitation
        $permissionsData = json_decode($invitation->permissions, true);
        
        foreach ($permissionsData as $permissionName => $hasPermission) {
            if ($hasPermission) {
                $permission = DB::table('permissions')->where('name', $permissionName)->first();
                if ($permission) {
                    
                    DB::table('user_permissions')->insert([
                        'user_id' => $user->id,
                        'permission_id' => $permission->id
                    ]);
                }
            }
        }

        // Optionally, delete the invitation from the database so it can't be used again
        //DB::table('invitations')->where('token', $data['invite_token'])->delete();

        return $user;
    }
}
