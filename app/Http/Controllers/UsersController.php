<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UsersController extends Controller
{
    public function insertUser(Request $request){
        if(!User::where('firstNameUser', $request->firstNameUser)->count()){
            $user= new User();
            $user->firstNameUser = $request->firstNameUser;
            $user->lastNameUser = $request->firstNameUser;
            $user->idRole = $request->idRole;
            return $user->save() ? 1 : 0;
        }
        return -1;
}
    public function getUser()
    {
        $users = User::all();
        return view('')->withUsers($users);
    }

    public function deleteUser(Request $request){
        $user = User::findOrFail($request->idUser);
        $user->delete();

        return view('');
    }

    public function updateUser(Request $request){
        $user = User::where('idUser',$request->idUser);
        $user->update($request);
        return view('');
    }
}
