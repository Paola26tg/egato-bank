<?php

namespace App\Http\Controllers;

use App\Models\DepositTransaction;
use App\Models\InnerTransaction;
use App\Models\OuterTransaction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function insertUser(Request $request){
      $messages = [
          'firstNameUser.required' => 'le prénom d\'utilisateur est invalide',
          'lastNameUser.required' =>'le nom d\'utilisateur est invalide',
          'telUser.required' => 'Numéro de telephone est invalide',
          'telUser.unique' =>  'Numéro de telephone est existant',
          'userPassword.required' => 'Mot de passe invalide',
          'userPassword.unique' =>  'Mot de passe existant',
          'userEmail.required' => 'Email est invalide',
          'userEmail.unique' =>  'Email est existant',
          'userSerialNumber.required' => 'Numéro de série est invalide',
          'userSerialNumber.unique' =>  'Numéro de série existant',
      ];
        $validator = Validator::make($request->all(), [
            'firstNameUser' => 'bail|required|max:255',
            'lastNameUser' => 'required|max:255',
            'telUser' => 'required|unique:users|numeric',
            'userPassword' => 'required|unique:users',
            'userEmail' => 'required|unique:users',
            'userSerialNumber' => 'required|unique:users',
            'idRole' => 'required' ,
        ],$messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        $user = new User();
            $user->firstNameUser = $request->firstNameUser;
            $user->lastNameUser = $request->firstNameUser;
            $user->telUser = $request->telUser;
            $user->userPassword = $request->userPassword;
            $user->userEmail = $request->userEmail;
            $user->userSerialNumber = $request->userSerialNumber;
            $user->idRole = $request->idRole;

        return json_encode([
            'status' =>200,
             'utilisateur enrégistré' =>  $user->save()]);

}
    public function getUsers()
    {
        $users = User::all();
        return $users;
    }

    public function deleteUser($id){

        $user = User::findOrFail($id);
        $user->delete();
        echo 'Utilisateur supprimé';
    }

    public function updateUser(Request $request, $id){
        $messages = [
          'telUser.unique' =>  'Numéro de telephone est existant',
            'userPassword.unique' => 'Mot de passe existant',
            'userEmail.unique' =>  'Email existant',
            'userSerialNumber.unique' => 'Numéro de série est existant',
            ];
        $validator = Validator::make($request->all(), [
            'telUser' => 'unique:users|numeric',
            'userPassword' => 'unique:users',
            'userEmail' => 'unique:users',
            'userSerialNumber' => 'unique:users',

        ],$messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);
        return json_encode([
            'status' => 200,
            'utilisateur modifié'=>   User::where('idUser', $id)->update($request->all())
        ]);
    }

    // CRUD OuterTransaction
    public function createOuterTransaction(Request $request){
        $messages = [
            'transactionAmount.required' => 'Montant invalide',
            'transactionFee.required' => 'Frais invalide'

        ];

        $validator = Validator::make($request->all(), [
            'idAccountCustomer' => 'required',
            'idUser' => 'required',
            'transactionAmount' =>'required',
            'transactionFee' => 'required'
        ]);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        $outerTransaction = new OuterTransaction();
        $outerTransaction->idAccountCustomer = $request->idAccountCustomer;
        $outerTransaction->idUser = $request->idUser;
        $outerTransaction->transactionAmount = $request->transactionAmount;
        $outerTransaction->transactionFee = $request->transactionFee;
        return json_encode([
            'status' =>200,
            'success'=>$outerTransaction ]);

    }
    public function getOuterTransactions()
    {
        $outerTransaction = OuterTransaction::orderByDesc('created_at')->get();
        return $outerTransaction;
    }

    public function getOuterTransactionById($id)
    {
        $outerTransaction = OuterTransaction::find($id);
        if(is_null($outerTransaction))
            return json_encode([
                'status' => 404,
                'error' => 'transaction introuvable '
            ]);
        return $outerTransaction;
    }

    public function deleteOuterTransaction($id){

        $outerTransaction = OuterTransaction::find($id);
        $outerTransaction->delete();
        echo'Transaction supprimé';
    }

    // CRUD InnerTransaction
    public function createInnerTransaction(Request $request){
        $messages = [
            'transactionAmount.required' => 'Montant invalide',

        ];
        $validator = Validator::make($request->all(), [
            'idAccountDepart' => 'required',
            'idAccountArrive' => 'required',
            'transactionAmount' => 'required'
        ],$messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);


        $innerTransaction = new InnerTransaction();
        $innerTransaction->idAccountDepart = $request->idAccountDepart;
        $innerTransaction->idAccountArrive = $request->idAccountArrive;
        $innerTransaction->transactionAmount = $request->transactionAmount;


         return json_encode([
            'status' => 200,
             'success' => $innerTransaction->save() ]);

    }
    public function getInnerTransaction()
    {
        $innerTransaction = InnerTransaction::orderByDesc('created_at')->get();
        return $innerTransaction;
    }
    public function getInnerTransactionById($id)
    {
        $innerTransactions = InnerTransaction::find($id);
        if(is_null($innerTransactions))
        return json_encode([
            'status' => 404,
            'error' => 'le compte est introuvable '
        ]);
        return $innerTransactions;
    }

    public function deleteInnerTransaction($id){

        $innerTransaction = InnerTransaction::find($id);
        $innerTransaction->delete();

        echo 'Transaction supprimée';
    }


    //CRUD depositTransaction


    public function createDepositTransaction(Request $request){
        $messages = [
            'transactionAmount.required' => 'Montant invalide',

        ];

        $validator = Validator::make($request->all(), [
            'idAccountCustomer' => 'required',
            'idUser' => 'required',
            'transactionAmount' => 'required'
        ],$messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        $depositTransaction = new DepositTransaction();
        $depositTransaction->idAccountCustomer = $request->idAccountCustomer;
        $depositTransaction->idUser = $request->idUser;
        $depositTransaction->transactionAmount = $request->transactionAmount;

        return json_encode([
            'status' =>200,
            'success'=>$depositTransaction ]);

    }
    public function getDepositTransactions()
    {
        $depositTransaction = DepositTransaction::orderByDesc('created_at')->get();
        return $depositTransaction;
    }

    public function getDepositTransactionById($id)
    {
        $depositTransaction = DepositTransaction::find($id);
        if(is_null($depositTransaction))
            return json_encode([
                'status' => 404,
                'error' => 'transaction introuvable '
            ]);
        return $depositTransaction;
    }

    public function deleteDepositTransaction($id){

        $depositTransaction = DepositTransaction::find($id);
        $depositTransaction->delete();
        echo'Transaction supprimé';
    }

}
