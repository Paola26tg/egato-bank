<?php

namespace App\Http\Controllers;

use App\Models\AccountCompany;
use App\Models\AccountCustomer;
use App\Models\Agency;
use App\Models\AgencyUser;
use App\Models\AppLog;
use App\Models\AppSetting;
use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\WithdrawalFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class rootController extends Controller
{
    // CRUD AccountCustomer
    public function createAccountCustomer(Request $request){
        $validator = Validator::make($request->all(), [
            'accountNumber' => 'bail|required|unique:account_customers|max:255',
            'accountAmount' => 'required',
            'idCustomer' => 'required|integer',
            'idAgency' => 'required|integer' ,
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();


        $accountCustomer = new AccountCustomer();
        $accountCustomer->accountNumber = $request->accountNumber;
        $accountCustomer->accountAmount = $request->accountAmount;
        $accountCustomer->idCustomer = $request->idCustomer;
        $accountCustomer->idAgency = $request->idAgency;
        return json_encode([
            'status' => $accountCustomer->save() ? 200 : 404 ,]);

    }

    public function getAccountCustomers(){
        $accountCustomers = AccountCustomer::all();
        return view('')->withAccountCustomers($accountCustomers);

    }

    public function deleteAccountCustomer(Request $request){
        $accountCustomer = Customer::findOrFail($request->idAccountCustomer);
        $accountCustomer->delete();
        return view('');
    }

    public function updateAccountCustomer(Request $request){
        $validator = Validator::make($request->all(), [
            'accountNumber' => 'bail|required|unique:account_customers|max:255',
            'accountAmount' => 'required',
            'idCustomer' => 'required|integer',
            'idAgency' => 'required|integer' ,
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();

        AccountCustomer::where('idAccountCustomer', $request->idAccountCustomer)->update($request);

        return view('');
    }


    // CRUD AccountCompany
    public function createAccountCompany(Request $request){
        $validator = Validator::make($request->all(), [
            'idAccountCustomer' => 'required|integer',
            'generateAmount' => 'required',

        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();

        $accountCompany = new AccountCompany();
        $accountCompany->idAccountCustomer = $request->idAccountCustomer;
        $accountCompany->generateAmount = $request->generateAmount;
        $accountCompany->save();
        return json_encode([
            'status' => $accountCompany->save() ? 200 : 404 ,]);
    }

    public function getAccountCompanies(){
        $accountCompanies = AccountCompany::all();
        return view('')->withAccontCompanies($accountCompanies);
    }

    public function updateAccountCompany(Request $request){
        $validator = Validator::make($request->all(), [
            'accountNumber' => 'required|unique:account_customers|max:255',
            'accountAmount' => 'required',
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors())->withInput();

        AccountCustomer::where('idAccountCompany', $request->idAccountCompany)->update($request);

        return view('');
    }

    public function deleteAccountCompany(Request $request){

        $accountCompany = AccountCompany::findOrFail($request->idAccountCompany);
        $accountCompany->delete();

        return view('');
    }

    // CRUD Agency
    public function createAgency(Request $request){
        $validator = Validator::make($request->all(), [
            'nameAgency' => 'bail|required|unique:agencies|max:255',
            'codeAgency' => 'required|unique:agencies|max:255',
            'idCountry' => 'required|integer',
            'idCity' => 'required|integer' ,
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->first())->withInput();
        }

        $agency = new Agency();
        $agency->nameAgency = $request->nameAgency;
        $agency->codeAgency = $request->codeAgency;
        $agency->idCountry = $request->idCountry;
        $agency->idCity = $request->idCity;
        $agency->save() ;
        return json_encode([
            'status' => $agency->save() ? 200 : 404 ,]);
    }

    public function updateAgency(Request $request){
        $validator = Validator::make($request->all(), [
            'nameAgency' => 'required|unique:agencies|max:255',
            'codeAgency' => 'required|unique:agencies|max:255',
            'idCountry' => 'required',
            'idCity' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->first())->withInput();
        }
        Agency::where('idAgency', $request->idAgency)->update($request);

        return view('');
    }

    public function getAgencies(){
        $agencies = Agency::all();
        return view('')->withAgencies($agencies);

    }

    public function deleteAgency(Request $request){
        $agency = Agency::findOrFail($request->idAgency);
        $agency->delete();

        return view('');

    }

    // CRUD AgencyUser
    public function createAgencyUser(Request $request){
        $validator = Validator::make($request->all(), [
            'idAgency' => 'required|integer',
            'idUser' => 'required|integer' ,
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();

        $agencyUser = new AgencyUser();
        $agencyUser->idAgency = $request->idAgency;
        $agencyUser->idUser = $request->idUser;
        $agencyUser->save() ;
        return json_encode([
            'status' => $agencyUser->save() ? 200 : 404 ,]);
    }

    public function updateAgencyUser(Request $request){
        $validator = Validator::make($request->all(), [
            'idAgency' => 'required',
            'idUser' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('agencyUser/update')
                ->withErrors($validator)
                ->withInput();
        }
        AgencyUser::where('idAgencyUser', $request->idAgencyUser)->update($request);

        return view('');
    }

    public function getAgencyUser(){
        $agencyUsers = AgencyUser::all();
        return view('')->withAgencyUsers($agencyUsers);
    }

    public function deleteAgencyUser(Request $request){
        $agencyUser = AgencyUser::findOrFail($request->idAgencyUser);
        $agencyUser->delete();

        return view('');
    }

    // CRUD Country
    public function createCountry(Request $request){
        $validator = Validator::make($request->all(), [
            'nameCountry' => 'required|unique:countries|max:255',
            'codeNameCountry' => 'required|unique:countries|max:255',
            'countryCode' => 'required|max:10',
        ]);
        if ($validator->fails()) {
            return redirect('country/create')
                ->withErrors($validator)
                ->withInput();
        }

        $country = new Country();
        $country->nameCountry = $request->nameCountry;
        $country->codeNameCountry = $request->codeNameCountry;
        $country->countryCode = $request->countryCode;
        $country->save() ;
        return view('');
    }
    public function getCountries(){
    $countries = Country::all();
    return view('')->withCountries($countries);
    }

    public function updateCountry(Request $request){
        $validator = Validator::make($request->all(), [
            'nameCountry' => 'required|unique:countries|max:255',
            'codeNameCountry' => 'required|unique:countries|max:255',
            'countryCode' => 'required|max:10',
        ]);
        if ($validator->fails()) {
            return redirect('country/update')
                ->withErrors($validator)
                ->withInput();
        }
        Country::where('idCountry', $request->idCountry)->update($request);

        return view('');
    }
    public function deleteCountry(Request $request){
     $country = Country::where('idCountry', $request->idCountry)->get();
     $country->delete();
    }

    // CRUD City
    public function createCity(Request $request){
        $validator = Validator::make($request->all(), [
            'nameCity' => 'required|unique:cities|max:255',
            'latitude' => 'required|unique:cities|max:255',
            'longitude' => 'required|unique:cities|max:255',
            'idCountry' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('city/create')
                ->withErrors($validator)
                ->withInput();
        }

        $city = new City();
        $city->nameCity = $request->nameCity;
        $city->latitude = $request->latitude;
        $city->longitude = $request->longitude;
        $city->idCountry = $request->idCountry;
        $city->save() ;
        return view('');
    }
    public function getCities(){
        $cities = City::all();
        return view('')->withCities($cities);

    }

    public function updateCity(Request $request){
        $validator = Validator::make($request->all(), [
            'nameCity' => 'required|unique:cities|max:255',
            'latitude' => 'required|unique:cities|max:255',
            'longitude' => 'required|unique:cities|max:255',
            'idCountry' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('city/update')
                ->withErrors($validator)
                ->withInput();
        }
        City::where('idCity', $request->idCity)->update($request);

        return view('');
    }

    public function deleteCity(Request $request){
      $city = City::where('idCity', $request->idCity)->get();
      $city->delete();
    }

 // CRUD AppLog
    public function createAppLog(Request $request){
        $validator = Validator::make($request->all(), [
            'logName' => 'required|max:255',
            'logContent' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('appLog/create')
                ->withErrors($validator)
                ->withInput();
        }

        $appLog = new AppLog();
        $appLog->logName = $request->logName;
        $appLog->logContent = $request->logContent;
        $appLog->save() ;
        return view('');
    }

    public function getAppLogs(){
    $appLogs = AppLog::all();
    return view('')->withAppLogs($appLogs);
    }

    public function updateAppLog(Request $request){
        $validator = Validator::make($request->all(), [
            'logName' => 'required|max:255',
            'logContent' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('appLog/update')
                ->withErrors($validator)
                ->withInput();
        }
        AppLog::where('idAppLog', $request->idAppLog)->update($request);

        return view('');
    }

    public function deleteAppLog(Request $request){
        $appLog = AppLog::findOrFail($request->idAppLog);
        $appLog->delete();

        return view('');

    }

    // CRUD AppSetting
    public function createAppSetting(Request $request){
        $validator = Validator::make($request->all(), [
            'settingName' => 'required|max:255',
            'nbTransactionMaxJr' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return redirect('appSetting/create')
                ->withErrors($validator)
                ->withInput();
        }

        $appSetting = new AppSetting();
        $appSetting->settingName = $request->settingName;
        $appSetting->nbTransactionMaxJr = $request->nbTransactionMaxJr;
        $appSetting->save() ;
        return view('');
    }

    public function getAppSettings(){
        $appSettings = AppSetting::all();
        return view('')->withAppSettings($appSettings);
    }

    public function updateAppSetting(Request $request){
        $validator = Validator::make($request->all(), [
            'settingName' => 'required|max:255',
            'nbTransactionMaxJr' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return redirect('appSetting/update')
                ->withErrors($validator)
                ->withInput();
        }
        AppSetting::where('idAppSetting', $request->idAppSetting)->update($request);

        return view('');
    }

    public function deleteAppSetting(Request $request){
        $appSetting = AppSetting::findOrFail($request->idAppSetting);
        $appSetting->delete();

        return view('');
    }

   // CRUD WithdrawalFees
    public function createWithdrawalFee(Request $request){
        $validator = Validator::make($request->all(), [
            'amountMin' => 'required',
            'amountMax' => 'required',
            'fee' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('withdrawalFee/create')
                ->withErrors($validator)
                ->withInput();
        }

        $withdrawalFee = new WithdrawalFee();
        $withdrawalFee->amountMin = $request->amountMin;
        $withdrawalFee->amountMax = $request->amountMax;
        $withdrawalFee->fee = $request->fee;
        $withdrawalFee->save() ;
        return view('');
    }

    public function getWithdrawalFees(){
        $withdrawalFees = WithdrawalFee::all();
        return view('')->withWithdrawalFees($withdrawalFees);
    }

    public function updateWithdrawalFee(Request $request){
        $validator = Validator::make($request->all(), [
            'amountMin' => 'required',
            'amountMax' => 'required',
            'fee' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('withdrawalFee/update')
                ->withErrors($validator)
                ->withInput();
        }
        WithdrawalFee::where('idWithdrawalFee', $request->idWithdrawalFee)->update($request);

        return view('');
    }
    public function deleteWithdrawalFee(Request $request){
        $withdrawalFee = WithdrawalFee::findOrFail($request->idWithdrawalFee);
        $withdrawalFee->delete();

        return view('');
    }
   //CRUD Roles
    public function createRole(Request $request){
        $validator = Validator::make($request->all(), [
            'roleName' => 'required|unique:roles|255',
            'roleLevel' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('role/create')
                ->withErrors($validator)
                ->withInput();
        }

        $role = new Role();
        $role->roleName = $request->roleName;
        $role->roleLevel = $request->roleLevel;
        $role->save() ;
        return view('');
    }

    public function getRoles(){
        $roles = Role::all();
        return view('')->withroles($roles);
    }

    public function updateRole(Request $request){
        $validator = Validator::make($request->all(), [
            'roleName' => 'bail|required|unique:roles|255',
            'roleLevel' => 'required',
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->errors()->first())->withInput();

        Role::where('idRole', $request->idRole)->update($request);

        return view('');
    }
    public function deleteRole(Request $request){
        $role = Role::findOrFail($request->idRole);
        $role->delete();

        return view('');
    }


}
