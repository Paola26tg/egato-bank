<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function  storeCustomer(Request $request){
        $validator = Validator::make($request->all(), [
            'firstName' => 'bail|required|unique:customers|max:255',
            'lastName' => 'required|unique:customers|max:255',
            'password' => 'required|max:255',
            'phoneCustomer' => 'required|numeric',
            'email' => 'required|email',
            'addressCustomer' => 'required',
            'idCountry' => 'required|integer',
            'idCity' => 'required|integer'
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();
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
            'status' => $customer->save() ? 200 : 404 ,]);

    }

    public function  getCustomers(){
     $customers = Customer::where('isValidated', true)->orderByDesc('created_at')
         ->get()->first();
     return view('')->withCustomers('customers');
    }

    public function findCustomer(Request $request){
        $customer = Customer::where('idCustomer', $request->idCustomer)->get();

        return view('')->withCustomer($customer);
    }

    public function updateCustomer(Request $request){
        $validator = Validator::make($request->all(), [
            'firstName' => 'bail|required|unique:customers|max:255',
            'lastName' => 'required|unique:customers|max:255',
            'password' => 'required|max:255',
            'phoneCustomer' => 'required|numeric',
            'email' => 'required|email',
            'addressCustomer' => 'required',
        ]);
        if ($validator->fails()) return back()->withErrors($validator->errors()->first())->withInput();

        Customer::where('idCustomer', $request->idCustomer)->update($request);

        return view('');
    }

    public function deleteCustomer(Request $request){
        $customer = Customer::findOrFail($request->idCustomer);
        $customer->delete();

        return view('');
    }
  public function getAccess(Request $request){

  }

}
