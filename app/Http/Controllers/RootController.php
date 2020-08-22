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
        $messages = [
            'accountNumber.required' => 'le numéro de compte est invalide',
            'accountNumber.unique' => 'le numéro de compte existe déja',
            'accountAmount.required' => 'le montant  est invalide'
        ];
        $validator = Validator::make($request->all(), [
            'accountNumber' => 'bail|required|unique:account_customers|max:255',
            'accountAmount' => 'required',
            'idCustomer' => 'required|integer',
            'idAgency' => 'required|integer' ,
        ], $messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        $accountCustomer = new AccountCustomer();
        $accountCustomer->accountNumber = $request->accountNumber;
        $accountCustomer->accountAmount = $request->accountAmount;
        $accountCustomer->idCustomer = $request->idCustomer;
        $accountCustomer->idAgency = $request->idAgency;
        return json_encode([
            'status' => 200,
            'success' => $accountCustomer->save()]);

    }

    public function getAccountCustomers(){
        $accountCustomers = AccountCustomer::orderByDesc('created_at')->get();
        return $accountCustomers;

    }
    public function getAccountCustomerById($id){
        $accountCustomer = AccountCustomer::find($id);
        if(is_null($accountCustomer))
            return json_encode([
                'status' => 404,
                'error' => 'le compte est introuvable '
                ]);
        return $accountCustomer;

    }
    public function deleteAccountCustomer($id){
        $accountCustomer = AccountCustomer::find($id);
        $accountCustomer->delete();
        echo 'le compte client a été supprimé';
    }

    public function updateAccountCustomer(Request $request, $id)
    {
        $messages = [
            'accountNumber.unique' => 'le numéro de compte existe déja',
        ];

        $validator = Validator::make($request->all(), [
            'accountNumber' => 'unique:account_customers|max:255',
        ]);
        if ($validator->fails())
            return json_encode(['status' => 500,
                'error' => $validator->errors()->first()
            ]);
        return json_encode([
            'status' => 200,
            'success' => AccountCustomer::where('idAccountCustomer', $id)->update($request->all())
        ]);

    }

    // CRUD AccountCompany
   public function createAccountCompany(Request $request){
       $messages = [
           'generateAmount.required' => 'le montant géneré est invalide'
       ];

        $validator = Validator::make($request->all(), [
            'idAccountCustomer' => 'required|integer',
            'generateAmount' => 'required',

        ],$messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        $accountCompany = new AccountCompany();
        $accountCompany->idAccountCustomer = $request->idAccountCustomer;
        $accountCompany->generateAmount = $request->generateAmount;
        return json_encode([
            'status' => 200,
             'success' => $accountCompany->save() ]);
    }

    public function getAccountCompanies(){
        $accountCompanies = AccountCompany::all();
        return $accountCompanies;
    }

    public function updateAccountCompany(Request $request, $id){
        $messages = [
            'generateAmount.required' => 'le montant géneré est invalide'
        ];
        $validator = Validator::make($request->all(), [
            'generateAmount' => 'required',
        ], $messages);
        if ($validator->fails())
             return json_encode(['status' => 500,
            'error' => $validator->errors()->first()
                 ]);

        return json_encode([
            'status' => 200,
            'success' => AccountCompany::where('idAccountCompany', $id)->update($request->all())
            ]);
    }

    public function deleteAccountCompany($id){

        $accountCompany = AccountCompany::find($id);
        $accountCompany->delete();
        echo 'le compte compagnie  a été supprimé';
    }

    // CRUD Agency
    public function createAgency(Request $request){
        $messages = [
        'nameAgency.required' => 'le nom de l\' agence est invalide',
            'nameAgency.unique' => 'le nom de l\' agence est existe déja',
        'codeAgency.required' => 'le code de l\' agence est invalide',
        'codeAgency.unique' => 'le code de l\' agence est existe déja'
    ];

        $validator = Validator::make($request->all(), [
            'nameAgency' => 'bail|required|unique:agencies|max:255',
            'codeAgency' => 'required|unique:agencies|max:255',
            'idCountry' => 'required|integer',
            'idCity' => 'required|integer' ,
        ],$messages);
        if ($validator->fails()) {
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
              ]);
        }

        $agency = new Agency();
        $agency->nameAgency = $request->nameAgency;
        $agency->codeAgency = $request->codeAgency;
        $agency->idCountry = $request->idCountry;
        $agency->idCity = $request->idCity;
        return json_encode([
            'status' => 200,
            'success' => $agency->save()]);
    }

    public function updateAgency(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nameAgency' => 'required|unique:agencies|max:255',
            'codeAgency' => 'required|unique:agencies|max:255',
            'idCountry' => 'required',
            'idCity' => 'required',
        ]);
        if ($validator->fails()) {
            return json_encode(['status' => 500,
                'error' => $validator->errors()->first()
                ]);
        }

        return json_encode([
            'status' => 200,
            'success' => Agency::where('idAgency', $id)->update($request->all())
        ]);
    }

    public function getAgencies(){
        $agencies = Agency::all();
        return $agencies;

    }

    public function deleteAgency($id){
        $agency = Agency::find($id);
        $agency->delete();
       echo 'l\'agence a été supprimé';
    }

    // CRUD AgencyUser
    public function createAgencyUser(Request $request){
        $validator = Validator::make($request->all(), [
            'idAgency' => 'required|integer',
            'idUser' => 'required|integer' ,
        ]);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
      ]);
        $agencyUser = new AgencyUser();
        $agencyUser->idAgency = $request->idAgency;
        $agencyUser->idUser = $request->idUser;
        return json_encode([
            'status' => 200,
               'success' => $agencyUser->save() ]);
    }

    public function updateAgencyUser(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'idAgency' => 'required',
            'idUser' => 'required',
        ]);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        return json_encode([
            'status' => 200,
            'success' =>  AgencyUser::where('idAgencyUser', $id)->update($request->all())
        ]);
    }

    public function getAgencyUser(){
        $agencyUsers = AgencyUser::all();
        return $agencyUsers;
    }

    public function deleteAgencyUser(Request $request,$id){
        $agencyUser = AgencyUser::find($id);
        $agencyUser->delete();
    }

    // CRUD Country
    public function createCountry(Request $request){
        $messages = [
           'countryName.required' => 'le nom du pays est invalide',
            'countryName.unique' => 'le nom du pays existe déja',
            'codeNameCountry.required' => 'le nom de code du pays est invalide',
            'codeNameCountry.unique' => 'le nom de code du pays existe déjà',
            'countryCode.required' => 'le code pays est invalide'

        ];
        $validator = Validator::make($request->all(), [
            'countryName' => 'bail|required|unique:countries|max:255',
            'codeNameCountry' => 'required|unique:countries|max:255',
            'countryCode' => 'required|max:10',
        ], $messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        $country = new Country();
        $country->countryName = $request->input('countryName');
        $country->codeNameCountry = $request->input('codeNameCountry');
        $country->countryCode = $request->input('countryCode');
        return json_encode([
            'status' => 200 ,
            'success' => $country->save()
            ]);
    }

    public function getCountries(){
    $countries = Country::all();
    return $countries;
    }

    public function findCountry($id){
        $country = Country::where('idCountry', $id)->get()->first();
        return $country;
    }

    public function updateCountry(Request $request, $id){
        $messages = [
            'countryName.unique' => 'le nom du pays existe déja',
            'codeNameCountry.unique' => 'le nom de code du pays existe déjà',
        ];
        $validator = Validator::make($request->all(), [
            'countryName' => 'unique:countries|max:255',
            'codeNameCountry' => 'unique:countries|max:255',
            'countryCode' => 'max:10',
        ], $messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

            return json_encode([
                'status' => 200,
                'success' => Country::where('idCountry', $id)->update($request->all())
            ]) ;
    }
    public function deleteCountry(Country $country){
     $country->delete();
    }

    // CRUD City
    public function createCity(Request $request){
        $messages = [
            'nameCity.required' => 'le nom de la ville est invalide',
            'nameCity.unique' => 'le nom de la ville existe déja',
            'latitude.required' => 'la latitude de la ville est invalide',
            'latitude.unique' => 'la latitude de la ville existe déjà',
            'longitude.required' => 'la longitude de la ville est invalide',
            'longitude.unique' => 'la longitude de la ville  existe déjà'

        ];

        $validator = Validator::make($request->all(), [
            'nameCity' => 'bail|required|unique:cities|max:255',
            'latitude' => 'required|unique:cities|max:255',
            'longitude' => 'required|unique:cities|max:255',
            'idCountry' => 'required'
        ], $messages );
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        $city = new City();
        $city->nameCity = $request->nameCity;
        $city->latitude = $request->latitude;
        $city->longitude = $request->longitude;
        $city->idCountry = $request->idCountry;
        return json_encode([
            'status' => 200,
            'success' => $city->save()
        ]) ;
    }
    public function getCities(){
        $cities = City::all();
        return $cities;

    }

    public function updateCity(Request $request, $id){
        $messages = [
            'nameCity.unique' => 'le nom de la ville existe déja',
            'latitude.unique' => 'cette latitude a été déja enrégistrée',
            'longitude.unique' => 'cette longitude a été déja enrégistrée'
        ];
        $validator = Validator::make($request->all(), [
            'nameCity' => 'unique:cities|max:255',
            'latitude' => 'unique:cities|max:255',
            'longitude' => 'unique:cities|max:255',
        ],$messages);
        if ($validator->fails()) {
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);
        }

        return json_encode([
            'status' =>200,
            'ville modifiée' => City::where('idCity', $id)->update($request->all())
        ]);
    }

    public function deleteCity($id){
        $citty = City::find($id);
        $citty->delete();
        echo 'la ville a été supprimée';
    }

 // CRUD AppLog
    public function createAppLog(Request $request){
        $messages = [
            'logName.required' => 'le nom de l\'historique est invalide',
             'logContent.required' => 'le contenu de l\'historique est invalide'

        ];
        $validator = Validator::make($request->all(), [
            'logName' => 'required|max:255',
            'logContent' => 'required',
        ], $messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);


        $appLog = new AppLog();
        $appLog->logName = $request->logName;
        $appLog->logContent = $request->logContent;
        return json_encode([
            'status' => 200,
               'success' => $appLog->save() ]);
    }

    public function getAppLogs(){
    $appLogs = AppLog::all();
    return $appLogs;
    }

    public function deleteAppLog($id){
        $appLog = AppLog::find($id);
        $appLog->delete();
        echo 'l\'historique est supprimée';

    }

    // CRUD AppSetting
    public function createAppSetting(Request $request){
        $messages = [
            'settingName.required' => 'le nom du paramètre est invalide',
            'settingName.unique' => 'ce paramètre existe déjà'
        ];
        $validator = Validator::make($request->all(), [
            'settingName' => 'required|unique:app_setting|max:255',
        ],$messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);


        $appSetting = new AppSetting();
        $appSetting->settingName = $request->settingName;
        $appSetting->nbTransactionMaxJr = $request->nbTransactionMaxJr;
        return json_encode([
            'status' => 200,
                'success' => $appSetting->save()]);
    }

    public function getAppSettings(){
        $appSettings = AppSetting::all();
        return $appSettings;
    }

    public function updateAppSetting(Request $request,$id){
        $messages = [
            'settingName.unique' => 'ce paramètre existe déja'
        ];
        $validator = Validator::make($request->all(), [
            'settingName' => 'unique:app_setting|max:255',

        ],$messages);
        if ($validator->fails()) {
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);
        }
        return json_encode([
            'status' => 200,
            'paramètre modifié' =>  AppSetting::where('idAppSetting',$id)->update($request->all())
        ]);
    }

    public function deleteAppSetting($id){
        $appSetting = AppSetting::find($id);
        $appSetting->delete();
        echo 'Paramètre supprimée';
    }

   // CRUD WithdrawalFees
    public function createWithdrawalFee(Request $request){
        $messages = [
            'amountMin.required' => 'le montant minimum est invalide',
            'amountMax.required' => 'le montant maximum est invalide',
            'fee.required' => 'les frais de transaction est invalide',
            'amountMin.unique' => 'ce montant est déja enregistré comme minimum',
            'amountMax.unique' => 'ce montant est déja enregistré comme maximum ',
            'fee.unique' => 'frais de retrait déja existant'
        ];
        $validator = Validator::make($request->all(), [
            'amountMin' => 'required|unique:withdrawal_fees',
            'amountMax' => 'required|unique:withdrawal_fees',
            'fee' => 'required|unique',
        ],$messages);
        if ($validator->fails()) {
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);
        }

        $withdrawalFee = new WithdrawalFee();
        $withdrawalFee->amountMin = $request->amountMin;
        $withdrawalFee->amountMax = $request->amountMax;
        $withdrawalFee->fee = $request->fee;
        return json_encode([
            'status' => 200,
             'success' => $withdrawalFee->save() ]);
    }

    public function getWithdrawalFees(){
        $withdrawalFees = WithdrawalFee::all();
        return $withdrawalFees;
    }

    public function updateWithdrawalFee(Request $request,$id){
      $messages = [
          'amountMin.unique' => 'ce montant est déja enregistré comme minimum',
          'amountMax.unique' => 'ce montant est déja enregistré comme maximum ',
          'fee.unique' => 'frais de retrait déja existant'

      ];
        $validator = Validator::make($request->all(), [
            'amountMin' => 'unique:withdrawal_fees',
            'amountMax' => 'unique:withdrawal_fees',
            'fee' => 'unique',
        ], $messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);



        return json_encode([
            'status' => 200,
            'success' =>  WithdrawalFee::where('idWithdrawalFee', $id)->update($request->all())
        ]);
    }
    public function deleteWithdrawalFee($id){
        $withdrawalFee = WithdrawalFee::find($id);
        $withdrawalFee->delete();
        echo'frais supprimé';
    }
   //CRUD Roles
    public function createRole(Request $request){
        $messages = [
            'roleName.required' => 'le nom du rôle est invalide',
            'roleLevel.required' => 'le niveau est invalide',
            'roleName.unique' => 'ce nom existe déja pour un rôle',
            'roleLevel.unique' => 'ce niveau existe pour un rôle ',

        ];
        $validator = Validator::make($request->all(), [
            'roleName' => 'required|unique:roles|255',
            'roleLevel' => 'required|unique:roles',
        ],$messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        $role = new Role();
        $role->roleName = $request->roleName;
        $role->roleLevel = $request->roleLevel;
        return json_encode([
            'status' => 200,
             'enregistrement effectué' =>  $role->save()  ]);
    }

    public function getRoles(){
        $roles = Role::all();
        return $roles;
    }

    public function updateRole(Request $request,$id){
        $messages =[
            'roleName.unique' => 'ce nom existe déja pour un rôle',
            'roleLevel.unique' => 'ce niveau existe pour un rôle ',
        ];
        $validator = Validator::make($request->all(), [
            'roleName' => 'unique:roles|255',
            'roleLevel' => '|unique',
        ], $messages);
        if ($validator->fails())
            return json_encode([
                'status' => 500,
                'error' => $validator->errors()->first()
            ]);

        return json_encode([
            'status' => 200,
            'role modifié' => Role::where('idRole', $id)->update($request->all())
        ]);
    }
    public function deleteRole($id){
        $role = Role::find($id);
        $role->delete();
        echo'Rôle supprimé';
    }


}
