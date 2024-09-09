<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;

class usersController extends Controller
{
    public function index(){

        // Eager load user_type with users
        $users = User::with('userType')->select('id', 'name', 'user_type_id')->get();
    
        // Map the user type name to the results
        $users = $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'user_type_name' => $user->userType->name
            ];
        });

        $translations = json_encode([
            'Delete' => trans('Delete'),
            'Edit' => trans('Edit'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'Search_by_users' => trans('Search by users'),
            'Are_you_sure_you_want_to_delete_this_user' => trans('Are you sure you want to delete this user?'),
            "Delete_user_result_error" => trans('Deleting this user will result deleting all the work he has done here (stocktaking and develieries)'),
        ]);
    
        return view('admin.users.index', compact('users','translations'));
    }

    public function search(Request $request){

        $query = $request->input('query');

        // Eager load user_type with users
        $users = User::with('userType')->select('id', 'name', 'user_type_id')->where('name','LIKE','%'.$query.'%')->get();

    
        // Map the user type name to the results
        $users = $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'user_type_name' => $user->userType->name
            ];
        });

        
        return response($users);
    }

    public function edit($user_id){

        $user = User::find($user_id);
        $user_types = UserType::all();

        $allPermissions = DB::table('permissions')->pluck('name')->toArray();

        // Fetch the permission names associated with the user
        $userPermissionNames = DB::table('user_permissions')
            ->join('permissions', 'user_permissions.permission_id', '=', 'permissions.id')
            ->where('user_permissions.user_id', $user_id)
            ->pluck('permissions.name')->toArray();

        // Construct the desired data structure
        $permissions = [];
        foreach ($allPermissions as $permissionName) {
            $permissions[$permissionName] = in_array($permissionName, $userPermissionNames);
        }

        $translations = json_encode([
            'Choose_user_type' => trans('Choose user type'),
            'Manage_products' => trans('Manage products'),
            'Manage_deliveries' => trans('Manage deliveries'),
            'Manage_stocktaking' => trans('Manage stocktaking'),
            'Manage_stocktaking_archive' => trans('Manage stocktaking archive'),
            'Manage_users' => trans('Manage users'),
            'Manage_categories' => trans('Manage categories'),
            'Save' => trans('Save'),
            'Manage_needing_lists' => trans('Manage needing lists'),
        ]);

        return view('admin.users.edit',compact('user','translations','user_types','permissions'));
    }

    public function update(Request $request)
    {

        $user_id = $request->input('user_id');

        // 1. Update user_type_id
        $user = User::find($user_id);
        $user->user_type_id = $request->user_type_id;
        $user->save();
    
        // 2. Update permissions
    
        // First, remove all existing permissions for the user
        DB::table('user_permissions')->where('user_id', $user_id)->delete();
    
        // Fetch all permission names and IDs
        $allPermissions = DB::table('permissions')->pluck('id', 'name')->toArray();

    
        // Check each permission from the form and add it if it's set to true
        foreach ($allPermissions as $permissionName => $permissionId) {
            // Convert permission name like "mystocktaking" to "stocktaking" to match the database column
            //$adjustedName = str_replace('my', '', $permissionName);
            if ($request->has($permissionName) && $request->$permissionName) {
                DB::table('user_permissions')->insert([
                    'user_id' => $user_id,
                    'permission_id' => $permissionId
                ]);
            }
        }
    
        // Redirect or return a response
        return response('success');
    }
    

    public function delete($user_id){
        $user = User::find($user_id);
        $user->delete();
        return redirect()->back()->with('success', trans(''));
    }

    public function invite(){
        $user_types = UserType::all();

        $translations = json_encode([
            'Enter_email' => trans('Enter email'),
            'Choose_user_type' => trans('Choose user type'),
            'Manage_products' => trans('Manage products'),
            'Manage_deliveries' => trans('Manage deliveries'),
            'Manage_stocktaking' => trans('Manage stocktaking'),
            'Manage_stocktaking_archive' => trans('Manage stocktaking archive'),
            'Manage_users' => trans('Manage users'),
            'Manage_needing_lists' => trans('Manage needing lists'),
            'Manage_categories' => trans('Manage categories'),
            'Invite' => trans('Invite'),
            'User_with_this_email_is_already_invited_for_registration' => trans('User with this email is already invited for registration'),
            'Choose_user_type_before_inviting_user' => trans('Choose user type before inviting user'),
            'You_successfully_invite_for_registration_to' => trans('You successfully invite for registration to'),

        ]);

        return view('admin.users.invite',compact('user_types','translations'));
    }

    public function sendInvite(Request $request){

        //check invitation 
        $invitation = Invitation::where('email',$request->input('email'))->count();
        
        if($invitation > 0){
            return response('error');
        }


        $token = Str::random(40);
    
        DB::table('invitations')->insert([
            'email' => $request->email,
            'token' => $token,
            'permissions' => json_encode([
                'product' => $request->products_access,
                'delivery' => $request->deliveries_access,
                'needing' => $request->needings_access,
                'mystocktaking' => $request->stocktaking_access,
                'stocktaking' => $request->stocktaking_archive_access,
                'user' => $request->users_access,
                'category' => $request->categories_access,
            ]),
        ]);

        $invite_link = url('/register?invite_token=' . $token);

        $locale = App::getLocale();

        Mail::send('emails.invite', ["invite_link" => $invite_link,"locale" => $locale], function ($message) use ($request) {
            $message->to($request->email)->subject('Your Invitation to Register');
        });

        return response('success');

    
        // Now send the invite email with the link containing the token
        // for example: http://yourapp.com/register?run sentoken=$token
    }
}
