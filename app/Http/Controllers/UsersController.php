<?php

namespace App\Http\Controllers;

use App\Models\InnerTransaction;
use App\Models\OuterTransaction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function insertUser(Request $request){

        $validator = Validator::make($request->all(), [
            'firstNameUser' => 'bail|required|unique:users|max:255',
            'lastNameUser' => 'required|unique:users|max:255',
            'telUser' => 'required|numeric',
            'idRole' => 'required' ,
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();


            $user = new User();
            $user->firstNameUser = $request->firstNameUser;
            $user->lastNameUser = $request->firstNameUser;
            $user->telUser = $request->telUser;
            $user->idRole = $request->idRole;

        return json_encode([
            'status' => $user->save() ? 200 : 404 ,]);

}
    public function getUsers()
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
        $validator = Validator::make($request->all(), [
            'firstNameUser' => 'required|unique:users|max:255',
            'lastNameUser' => 'required|unique:users|max:255',
            'telUser' => 'required|numeric',
            'idRole' => 'required' ,
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();

        User::where('idUser', $request->idUser)->update($request);
        return view('');
    }

    // CRUD OuterTransaction
    public function createOuterTransaction(Request $request){

        $validator = Validator::make($request->all(), [
            'idAccountCustomer' => 'required',
            'idUser' => 'required',
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();


        $outerTransaction = new OuterTransaction();
        $outerTransaction->idAccountCustomer = $request->idAccountCustomer;
        $outerTransaction->idUser = $request->idUser;


        return json_encode([
            'status' => $outerTransaction->save() ? 200 : 404 ,]);

    }
    public function getOuterTransaction()
    {
        $outerTransaction = OuterTransaction::all();
        return view('')->withOuterTransaction($outerTransaction);
    }

    public function deleteOuterTransaction(Request $request){

        $outerTransaction = OuterTransaction::findOrFail($request->idOuterTransaction);
        $outerTransaction->delete();

        return view('');
    }

    public function updateOuterTransaction(Request $request){
        $validator = Validator::make($request->all(), [
            'idAccountCustomer' => 'required',
            'idUser' => 'required',
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();

        OuterTransaction::where('idOuterTransaction', $request->idOuterTransaction)->update($request);
        return view('');
    }

    // CRUD InnerTransaction
    public function createInnerTransaction(Request $request){

        $validator = Validator::make($request->all(), [
            'idAccountDepart' => 'required',
            'idAccountArrive' => 'required',
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();

        $innerTransaction = new InnerTransaction();
        $innerTransaction->idAccountDepart = $request->idAccountDepart;
        $innerTransaction->idAccountArrive = $request->idAccountArrive;

         return json_encode([
            'status' => $innerTransaction->save() ? 200 : 404 ,]);

    }
    public function getInnerTransactions()
    {
        $innerTransactions = InnerTransaction::all();
        return view('')->withInnerTransactions($innerTransactions);
    }

    public function deleteInnerTransaction(Request $request){

        $innerTransaction = InnerTransaction::findOrFail($request->idInnerTransaction);
        $innerTransaction->delete();

        return view('');
    }

    public function updateInnerTransaction(Request $request){
        $validator = Validator::make($request->all(), [
            'idAccountDepart' => 'required',
            'idAccountArrive' => 'required',
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();

        InnerTransaction::where('idInnerTransaction', $request->idInnerTransaction)->update($request);
        return view('');
    }

}
