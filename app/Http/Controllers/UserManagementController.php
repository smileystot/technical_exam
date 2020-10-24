<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\UserRole;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    

    public function AddUser(Request $req){
        $user = new User;
        $user->FirstName = $req->FirstName;
        $user->LastName = $req->LastName;
        $user->Email = $req->Email;
        $user->AccessRights = $req->AccessRights;
        $user->Password = Hash::make('user');
        $user->save();

    }
    
    public function DeleteUser(Request $req){
        $user = User::find($req->id);
        $user->deleted_at = date('Y-m-d H:i:s');
        $user->save();
    } 

    public function UpdateUser(Request $req){
        $user = User::find($req->id);
        $user->FirstName = $req->FirstName;
        $user->LastName = $req->LastName;
        $user->Email = $req->Email;
        $user->AccessRights = $req->AccessRights;
        $user->save();

    }

    public function GetUsers(){
        return User::select('users.*','roles.id as RoleID','roles.RoleName')->join('roles','roles.id','users.AccessRights')
        ->where('users.deleted_at', null)->get();
    }

    public function DeleteRole(Request $req){
        $role = Role::find($req->id);
        $role->deleted_at = date('Y-m-d H:i:s');
        $role->save();
    }

    public function AddRole(Request $req){
        $role = new Role;
        $role->RoleName = $req->RoleName;
        $role->RoleDescription = $req->RoleDescription;
        $role->save();
    }
    public function GetRoles(){
        return Role::where('deleted_at',null)->get();
    }

    public function UpdateRole(Request $req){

    $role =  Role::find($req->id);
    $role->RoleName = $req->RoleName;
    $role->RoleDescription = $req->RoleDescription;
    $role->save();

    }
}
