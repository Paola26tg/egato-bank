<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function  storeCustomer(Request $request){
        $messages = [
            'firstName.required' => 'le prénom est invalide',
            'lastName.required' => 'le nom est invalide',
            'password.required' => 'le mot de passe est invalide',
            'password.unique' => 'ce mot de passe existe déja',
            'email.required' => 'Email invalide',
            'email.unique' => 'Email existant',
            'phoneCustomer.required' => 'numéro invalide',
            'phoneCustomer.unique' => 'numéro existant',
            'idCountry.required' => 'renseignez le pays',
            'idCity.required' => 'renseignez la ville',
        ];
        $validator = Validator::make($request->all(), [
            'firstName' => 'bail|required|max:255',
            'lastName' => 'required|max:255',
            'password' => 'required|unique:customers|max:255',
            'phoneCustomer' => 'required|numeric',
            'email' => 'required|unique:customers|email',
            'addressCustomer' => 'required',
            'idCountry' => 'required|integer',
            'idCity' => 'required|integer'
        ], $messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        $customer = new Customer();
            $customer->firstName = $request->firstName;
            $customer->lastName = $request->lastName;
            $customer->password = $request->password;
            $customer->phoneCustomer = $request->phoneCustomer;
            $customer->email = $request->email;
            $customer->addressCustomer = $request->addressCustomer;
            $customer->idCountry = $request->idCountry;
            $customer->idCity = $request->idCity;


        return json_encode([
            'status' => 200,
              'success' =>  $customer->save()]);

    }

    public function  getCustomers(){
     $customers = Customer::where('isValidated', true)->orderByDesc('created_at')
         ->get()->first();
     return $customers;
    }

    public function findCustomer($id){
        $customer = Customer::where('idCustomer', $id)->get();

        return $customer;
    }

    public function updateCustomer(Request $request, $id){
        $messages = [
            'password.unique' => 'ce mot de passe existe déja',
            'email.unique' => 'Email existant',
            'phoneCustomer.unique' => 'numéro existant'
        ];
        $validator = Validator::make($request->all(), [
            'firstName' => '|max:255',
            'lastName' => '|max:255',
            'password' => 'unique:customers|max:255',
            'phoneCustomer' => 'unique:customers|numeric',
            'email' => 'unique:customers|email',

        ],$messages);
        if ($validator->fails()) return json_encode([
            'status' => 500,
            'error' => $validator->errors()->first()
        ]);

        return json_encode([
            'status' => 200,
            'success' =>  Customer::where('idCustomer', $id)->update($request->all())
        ]);
    }

    public function deleteCustomer($id){
        $customer = Customer::find($id);
        $customer->delete();
        echo 'client supprimé';
    }
  public function getAccess(Request $request){

  }

}
