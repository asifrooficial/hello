<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function administrate() 
    {
        $searchQuery = User::where('username', '')->get();

        return view('admins', ['users'=> $searchQuery]); 
    }


    public function searchPlayers(Request $request)
    {  
        $incomingFields = $request->validate([
            'gmName' => 'required'
        ]);

        $incomingFields['gmName'] = strip_tags($incomingFields['gmName']);     
         
        $users = DB::table('roles')
            ->join('users', 'roles.id', '=', 'users.role_id')
            ->where('username', $incomingFields['gmName'])
            ->get();

        return view('admins', ['users'=> $users]);  
        
    }

    public function giveThemRole(Request $request)
    {
        $incomingFields = $request->validate([
            'userId' => 'required',
            'role_id' => 'required',
        ]);

        User::where('id', $incomingFields['userId'])->update(['role_id' => $incomingFields['role_id']]);

        return back()->with('success', 'Role updated');
    }

}
