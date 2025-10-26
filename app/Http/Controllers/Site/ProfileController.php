<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Models\Company;
use App\Models\Dashboard\Estelam;
use App\Models\Dashboard\Learnfile;
use App\Models\Dashboard\notif_user;
use App\Models\Dashboard\Subestelam;
use App\Models\Invoice;
use App\Models\Menu;
use App\Models\message;
use App\Models\Payment;
use App\Models\Profile\Bank;
use App\Models\Profile\EstelamToken;
use App\Models\Profile\Log_estelam;
use App\Models\Profile\Notif;
use App\Models\Profile\WalletTransaction;
use App\Models\Profile\Workshop;
use App\Models\Profile\Workshopsign;
use App\Models\User;
use App\Notifications\ActiveCode as ActiveCodeNotification;
use Evryn\LaravelToman\CallbackRequest;
use Evryn\LaravelToman\Facades\Toman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{

    public static function convertPersianToEnglish($string)
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($persianNumbers, $englishNumbers, $string);
    }

    public function profile()
    {
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $companies = Company::first();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();
        return view('Site.Dashboard.profile')->with(compact('companies', 'dashboardmenus', 'notifs'));

    }

    public function withdraw()
    {
        $user               = Auth::user();
        $notifs             = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $companies          = Company::first();
        $dashboardmenus     = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();

        return view('Site.Dashboard.withdraw')->with(compact('companies', 'dashboardmenus', 'notifs'));

    }

    public function queries(Request $request)
    {
        $token = EstelamToken::select('token', 'appname')->first();

        $headers = [
            'token:' . $token->token,
            'appname:' . $token->appname,
            'Content-Type: application/json',
        ];

        if ($request->input('formId') == 11) {
            try {

                $estelam = Estelam::whereId(1)->first();
                $url     = $estelam->action_route;
                $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

                $postalCode = [
                    "postalCode" => str_replace($persianNumbers, $englishNumbers, $request->input('postCode'))
                ];

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $estelam->method);
                if ($estelam->method == 'POST') {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postalCode));
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch);

                curl_close($ch);
                $responseData = json_decode($response, true);

                $logs = new Log_estelam();
                $logs->title        = $estelam->title_fa;
                $logs->request      = json_encode($postalCode);
                $logs->response     = json_encode($responseData);
                $logs->action_route = $estelam->action_route;
                $logs->date         = jdate()->format('Y/m/d');
                $logs->user_id      = Auth::user()->id;
                $logs->save();

                $address = $responseData['data']['result']['city']
                    .'-'.$responseData['data']['result']['province']
                    .'-'.$responseData['data']['result']['township']
                    .'-'.$responseData['data']['result']['locality']
                    .'-'.$responseData['data']['result']['avenue']
                    .'-'.$responseData['data']['result']['stopStreet']
                    .'-'.$responseData['data']['result']['no']
                    .'-'.$responseData['data']['result']['floor'];

                $estelam = Estelam::whereId(2)->first();
                $url     = $estelam->action_route;
                $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

                $national = [
                    "nationalCode"  => str_replace($persianNumbers, $englishNumbers, $request->input('nationalID')),
                    "birthDate"     => str_replace($persianNumbers, $englishNumbers, $request->input('birthDate'))
                ];

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $estelam->method);
                if ($estelam->method == 'POST') {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($national));
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch);

                curl_close($ch);
                $responseData = json_decode($response, true);

                $logs = new Log_estelam();
                $logs->title        = $estelam->title_fa;
                $logs->request      = json_encode($national);
                $logs->response     = json_encode($responseData);
                $logs->action_route = $estelam->action_route;
                $logs->date         = jdate()->format('Y/m/d');
                $logs->user_id      = Auth::user()->id;
                $logs->save();

                $firstName  = $responseData['data']['result']['firstName'];
                $lastName   = $responseData['data']['result']['lastName'];
                $fatherName = $responseData['data']['result']['fatherName'];
                $gender     = $responseData['data']['result']['gender'];
                $alive      = $responseData['data']['result']['liveStatus'];

                if ($gender == 1) {
                    $gender = 'مرد';
                } elseif ($gender == 2) {
                    $gender = 'زن';
                }
                if ($alive == 1) {
                    $alive = 'در قید حیات';
                } elseif ($alive == 0) {
                    $alive = 'فوت شده';
                }

                $estelam = Estelam::whereId(7)->first();
                $url = $estelam->action_route;
                $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

                $imagedata = [
                    "nationalCode"  => str_replace($persianNumbers, $englishNumbers, $request->input('nationalID')),
                    "birthDate"     => str_replace($persianNumbers, $englishNumbers, $request->input('birthDate'))
                ];

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $estelam->method);
                if ($estelam->method == 'POST') {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($imagedata));
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch);

                curl_close($ch);
                $responseData = json_decode($response, true);

                $logs = new Log_estelam();
                $logs->title        = $estelam->title_fa;
                $logs->request      = json_encode($imagedata);
                $logs->response     = json_encode($responseData);
                $logs->action_route = $estelam->action_route;
                $logs->date         = jdate()->format('Y/m/d');
                $logs->user_id      = Auth::user()->id;
                $logs->save();

                $image = $responseData['data']['result']['image'];

                $image = '<img src="data:image/jpeg;base64,' . $image . '">';

                $result = [
                    'کد ملی'        => $request->input('nationalID'),
                    'نام'           => $firstName,
                    'نام خانوادگی'  => $lastName,
                    'نام پدر'       => $fatherName,
                    'تاریخ تولد'    => $request->input('birthDate'),
                    'جنسیت'         => $gender,
                    'وضعیت حیات'    => $alive,
                    'تصویر'         => $image,
                    'آدرس'          => $address,
                ];
                return response()->json(['response' => $result]);
            } catch (Exception $e) {

                $message = 'خطای سیستم،لطفا بعدا مجدد تلاش نمایید ';
                return response()->json(['error' => $message], 500);
            }
        }
//////////////////////////////////////////////
        $estelam = Estelam::whereId($request->input('formId'))->first();

        try {
            if ($estelam->method == 'GET') {
                $url = $estelam->action_route . '?companyNationalCode=' . $request->input('companyNationalCode');

            } elseif ($estelam->method == 'POST') {
                $url = $estelam->action_route;
            }


            if ($request->input('formId') == 1) {

                $data = [
                    "postalCode" => $request->input('postalCode')
                ];
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $estelam->method);
                if ($estelam->method == 'POST') {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch);

                curl_close($ch);
                $responseData = json_decode($response, true);

                $logs = new Log_estelam();
                $logs->title = $estelam->title_fa;
                $logs->request = json_encode($data);
                $logs->response = json_encode($responseData);
                $logs->action_route = $estelam->action_route;
                $logs->date = jdate()->format('Y/m/d');
                $logs->user_id = Auth::user()->id;
                $logs->save();

                $address = $responseData['data']['result']['city']
                    .'-'.$responseData['data']['result']['province']
                    .'-'.$responseData['data']['result']['township']
                    .'-'.$responseData['data']['result']['locality']
                    .'-'.$responseData['data']['result']['avenue']
                    .'-'.$responseData['data']['result']['stopStreet']
                    .'-'.$responseData['data']['result']['no']
                    .'-'.$responseData['data']['result']['floor'];

                $status     = $responseData['isSuccess'];
                $message    = $responseData['message'];

                $result = [
                    'آدرس' => $address
                ];

            } elseif ($request->input('formId') == 2) {

                $data = [
                    "nationalCode"  => $request->input('nationalID'),
                    "birthDate"     => $request->input('birthDate')
                ];

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $estelam->method);
                if ($estelam->method == 'POST') {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch);

                curl_close($ch);
                $responseData = json_decode($response, true);

                $logs = new Log_estelam();
                $logs->title = $estelam->title_fa;
                $logs->request = json_encode($data);
                $logs->response = json_encode($responseData);
                $logs->action_route = $estelam->action_route;
                $logs->date = jdate()->format('Y/m/d');
                $logs->user_id = Auth::user()->id;
                $logs->save();


                $firstName  = $responseData['data']['result']['firstName'];
                $lastName   = $responseData['data']['result']['lastName'];
                $fatherName = $responseData['data']['result']['fatherName'];
                $gender     = $responseData['data']['result']['gender'];
                $alive      = $responseData['data']['result']['liveStatus'];

                if ($gender == 1) {
                    $gender = 'مرد';
                } elseif ($gender == 2) {
                    $gender = 'زن';
                }
                if ($alive == 1) {
                    $alive = 'در قید حیات';
                } elseif ($alive == 0) {
                    $alive = 'فوت شده';
                }

                $result = [
                    'کد ملی'        => $request->input('nationalID'),
                    'نام'           => $firstName,
                    'نام خانوادگی'  => $lastName,
                    'نام پدر'       => $fatherName,
                    'تاریخ تولد'    => $request->input('birthDate'),
                    'جنسیت'         => $gender,
                    'وضعیت حیات'    => $alive,
                ];
                //dd($nationalCode , $firstName , $lastName , $fatherName , $birthDate , $alive , $gender);
            } elseif ($request->input('formId') == 3) {

                $data = [
                    "number"  => $request->input('cardNumber'),
                ];

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $estelam->method);
                if ($estelam->method == 'POST') {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch);

                curl_close($ch);
                $responseData = json_decode($response, true);

                $logs = new Log_estelam();
                $logs->title = $estelam->title_fa;
                $logs->request = json_encode($data);
                $logs->response = json_encode($responseData);
                $logs->action_route = $estelam->action_route;
                $logs->date = jdate()->format('Y/m/d');
                $logs->user_id = Auth::user()->id;
                $logs->save();

                $ownerName     = $responseData['data']['result']['firstName'].' '.$responseData['data']['result']['lastName'];
                $depositNumber = $responseData['data']['result']['depositNumber'];
                $iban          = $responseData['data']['result']['iban'];
                $bank          = $responseData['data']['result']['bankName'];
                $status        = $responseData['data']['result']['status'];

                if ($status == 'ACTIVE') {
                    $status = 'فعال';
                } else {
                    $status = 'غیر فعال';
                }

                $result = [
                    'نام مالک کارت' => $ownerName,
                    'شماره حساب'    => $depositNumber,
                    'شماره شبا'     => $iban,
                    'نام بانک'      => $bank,
                    'وضعیت کارت'    => $status,
                ];
            } elseif ($request->input('formId') == 4) {

                $ownerName = $responseData['description']['inquiryCard']['cardInfo']['ownerName'];
                $depositNumber = $responseData['description']['inquiryCard']['cardInfo']['depositNumber'];
                $bank = $responseData['description']['inquiryCard']['cardInfo']['bank'];
                $type = $responseData['description']['inquiryCard']['cardInfo']['type'];

                $result = [
                    'نام مالک کارت' => $ownerName,
                    'شماره حساب' => $depositNumber,
                    'نام بانک' => $bank,
                    'نوع حساب' => $type,
                ];
            } elseif ($request->input('formId') == 5) {

                $ownerName = $responseData['description']['inquiryCard']['cardInfo']['ownerName'];
                $depositNumber = $responseData['description']['inquiryCard']['cardInfo']['depositNumber'];
                $bank = $responseData['description']['inquiryCard']['cardInfo']['bank'];
                $type = $responseData['description']['inquiryCard']['cardInfo']['type'];

                $result = [
                    'نام مالک کارت' => $ownerName,
                    'شماره حساب' => $depositNumber,
                    'نام بانک' => $bank,
                    'نوع حساب' => $type,
                ];
            } elseif ($request->input('formId') == 6) {

                $ibanCheckResult = $responseData['description']['ibanIdentityInquiry']['respObject']['ibanCheckResult'];

                $result = [
                    ' وضعیت حساب ' => $ibanCheckResult,
                ];
            } elseif ($request->input('formId') == 7) {

                $data = [
                    "nationalCode"  => $request->input('nationalID'),
                    "birthDate"     => $request->input('birthDate'),
                ];

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $estelam->method);
                if ($estelam->method == 'POST') {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch);

                curl_close($ch);
                $responseData = json_decode($response, true);

                $logs = new Log_estelam();
                $logs->title = $estelam->title_fa;
                $logs->request = json_encode($data);
                $logs->response = json_encode($responseData);
                $logs->action_route = $estelam->action_route;
                $logs->date = jdate()->format('Y/m/d');
                $logs->user_id = Auth::user()->id;
                $logs->save();

                $image = $responseData['data']['result']['image'];

                $image = '<img src="data:image/jpeg;base64,' . $image . '">';
                $result = [
                    '  تصویر ' => $image,
                ];
            } elseif ($request->input('formId') == 8) {

                $message = $responseData['description']['details']['message'];
                $result = [
                    '  مانده حساب ' => $message,
                ];
            } elseif ($request->input('formId') == 9) {

                $message = $responseData['description']['details']['message'];
                $result = [
                    '  مانده حساب ' => $message,
                ];
            } elseif ($request->input('formId') == 12) {


                $title = $responseData['description']['companyInfo']['news'][0]['title'];
                $description = $responseData['description']['companyInfo']['news'][0]['description'];
                $companyId = $responseData['description']['companyInfo']['news'][0]['companyId'];
                $capitalTo = $responseData['description']['companyInfo']['news'][0]['capitalTo'];


                $result = [
                    ' عنوان ' => $title,
                    ' توضیحات ' => $description,
                    ' شماره ثبت ' => $companyId,
                    ' سرمایه اولیه ' => $capitalTo,
                ];

            }
            return response()->json(['response' => $result]);

        } catch (Exception $e) {

            $message = 'اطلاعات پاک نشد،لطفا بعدا مجدد تلاش نمایید ';
            return response()->json(['error' => $message], 500);
        }
    }

    public function estelam()
    {
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $estelams = Estelam::whereStatus(4)->get();
        $subestelams = Subestelam::whereStatus(4)->get();
        $companies = Company::first();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();

        return view('Site.Dashboard.estelam')->with(compact('companies', 'dashboardmenus', 'notifs', 'estelams', 'subestelams'));

    }

    public function usernotif()
    {
        $user = Auth::user();
        $notifs = $user->notifs()->orderBy('id', 'DESC')->get();
        $usernotifs = notif_user::whereUser_id($user->id)->get();
        $companies = Company::first();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();

        return view('Site.Dashboard.usernotif')->with(compact('companies', 'dashboardmenus', 'notifs', 'usernotifs'));

    }

    public function message()
    {

        $companies = Company::first();
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();
        $messages = message::leftjoin('users', 'users.id', '=', 'messages.sender_id')
            ->select('messages.description', 'messages.active', 'users.name', 'users.image', 'messages.created_at as date')
            ->whereUser_id(Auth::user()->id)
            ->whereActive(1)
            ->orderBy('messages.id', 'DESC')
            ->groupBy('messages.sender_id', 'messages.description', 'messages.active', 'users.name', 'users.image', 'date')
            ->get();

        return view('Site.Dashboard.message')->with(compact('companies', 'messages', 'dashboardmenus', 'notifs'));

    }

    public function learnbook()
    {

        $companies = Company::first();
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();
        $learnfiles = Learnfile::whereStatus(4)->get();

        return view('Site.Dashboard.learnbook')->with(compact('companies', 'learnfiles', 'dashboardmenus', 'notifs'));

    }

    public function setting()
    {

        $companies = Company::first();
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();
        $banks = Bank::whereUser_id(Auth::user()->id)->get();
        $payments = Payment::whereUser_id(Auth::user()->id)->get();

        return view('Site.Dashboard.settings')->with(compact('companies', 'dashboardmenus', 'banks', 'notifs', 'payments'));

    }

    public function profilewallet()
    {

        $companies      = Company::first();
        $user           = Auth::user();
        $notifs         = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();
        $banks          = Bank::whereUser_id(Auth::user()->id)->get();
        $payments       = WalletTransaction::whereUser_id(Auth::user()->id)->get();

        return view('Site.Dashboard.wallet')->with(compact('companies', 'dashboardmenus', 'banks', 'notifs', 'payments'));

    }

    public function workshop()
    {

        $companies = Company::first();
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();
        $payments = Payment::whereUser_id(Auth::user()->id)->get();
        $workshops = Workshop::whereStatus(4)->get();
        $workshopsigns = DB::table('workshops')
            ->join('workshopsigns', 'workshops.id', '=', 'workshopsigns.workshop_id')
            ->select('workshops.title', 'workshops.price', 'workshops.date', 'workshopsigns.typeuse', 'workshopsigns.pricestatus')
            ->where('workshopsigns.user_id', '=', Auth::user()->id)
            ->where('workshopsigns.pricestatus', '!=', null)
            ->get();
        $workshoppays = DB::table('workshops')
            ->join('workshopsigns', 'workshops.id', '=', 'workshopsigns.workshop_id')
            ->select('workshops.title', 'workshops.price', 'workshops.date', 'workshopsigns.typeuse', 'workshopsigns.pricestatus')
            ->where('workshopsigns.user_id', '=', Auth::user()->id)
            ->get();

        return view('Site.Dashboard.workshop')->with(compact('companies', 'dashboardmenus', 'workshoppays', 'workshopsigns', 'notifs', 'workshops', 'payments'));

    }

    public function userrequest()
    {

        $companies = Company::first();
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();

        return view('Site.Dashboard.userrequest')->with(compact('companies', 'dashboardmenus', 'notifs'));

    }

    public function creatbankaccount(Request $request)
    {
        $request->validate([
            'name' => ['string'],
            'bank_account' => ['numeric'],
            'bank_card' => ['numeric'],
            'bank_sheba' => ['string', 'min:10'],
        ]);

        $bank = new Bank();

        $bank->bank_name = $request->input('bank_name');
        $bank->bank_account = $request->input('bank_account');
        $bank->bank_card = $request->input('bank_card');
        $bank->bank_sheba = $request->input('bank_sheba');
        $bank->user_id = Auth::user()->id;

        $bank->save();

        return Redirect::back();
    }

    public function workshopsign(Request $request)
    {

        $companies = Company::first();
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')
            ->MenuDashboard()
            ->orderBy('priority')
            ->get();
        if ($request->input('certificate') == 1) {
            $request->validate([
                'workshopid'  => 'required|numeric',
                'typeuse'     => 'required|numeric',
                'certificate' => 'required|numeric',
                'national_id' => 'required|string',
                'father_name' => 'required|string',
                'birthday'    => 'required|string',
            ]);
        }else{
            $request->validate([
                'workshopid'    => 'required|numeric',
                'typeuse'       => 'required|numeric',
                'certificate'   => 'required|numeric',
            ]);
        }
        if ($request->input('birthday')) {
            $user->birthday = $request->input('birthday');
        }
        if ($request->input('national_id')) {
            $user->national_id = $request->input('national_id');
        }
        if ($request->input('father_name')) {
            $user->father_name = $request->input('father_name');
        }
        $user->update();

        if (Auth::user()->email==null || Auth::user()->phone==null){
            alert()->error('', ' شماره تلفن یا آدرس ایمیل وارد نشده است! لطفا از طریق تنظیمات حساب کاربری اطلاعات مربوطه را ثبت کنید.');
            return Redirect::back();
        }
        else {

        }

        $workshopid     = $request->input('workshopid');
        $typeuse        = $request->input('typeuse');
        $certificate    = $request->input('certificate');


        $workshopsigns = DB::table('workshops')
            ->join('workshopsigns', 'workshops.id', '=', 'workshopsigns.workshop_id')
            ->select('workshops.title' , 'workshops.certificate_price', 'workshops.price', 'workshops.date', 'workshopsigns.typeuse', 'workshopsigns.pricestatus', 'workshopsigns.id')
            ->where('workshopsigns.user_id', '=', Auth::user()->id)
            ->where('workshops.id', '=', $request->input('workshopid'))
            ->first();

        //dd($workshopsigns);

        $workshops = Workshop::whereId($workshopid)->first();

        if ($workshopsigns == null){

            $Workshopsign = new Workshopsign();
            $Workshopsign->workshop_id      = $request->input('workshopid');
            $Workshopsign->typeuse          = $request->input('typeuse');
            $Workshopsign->certificate      = $request->input('certificate');
            $Workshopsign->certif_price     = $workshops->certificate_price;
            $Workshopsign->workshop_price   = $workshops->price;
            $Workshopsign->price            = $workshops->price;
            $Workshopsign->user_id          = Auth::user()->id;
            $Workshopsign->save();

            $invoice = new Invoice();
            $invoice->user_id           = Auth::user()->id;
            $invoice->product_id        = $request->input('workshopid');
            $invoice->product_type      = 'workshop';
            $invoice->product_price     = $workshops->price;
            $invoice->type_use          = $request->input('typeuse');
            $invoice->certificate_price = $workshops->certificate_price;
            $invoice->price     = $workshops->certificate_price + $workshops->price;
            $invoice->save();

            $invoices = Invoice::whereId($invoice->id)->first();

            return view('Site.Dashboard.paymentpage')->with(compact('companies', 'dashboardmenus','invoices' , 'notifs', 'workshops', 'workshopid', 'typeuse', 'certificate'));
        }elseif ($workshopsigns->pricestatus == 4) {
            alert()->error('', 'شما قبلا در این دوره ثبت نام کرده اید');
            return Redirect::back();
        } elseif ($workshopsigns->pricestatus == null) {

            Workshopsign::whereWorkshop_id($workshopid)->whereUser_id(Auth::user()->id)->wherePricestatus(null)->update([
                'certificate'       => $request->input('certificate'),
                'typeuse'           => $request->input('typeuse'),
                'certif_price'      => $workshops->certificate_price,
                'workshop_price'    => $workshops->price,
                'price'             => $workshops->price,
                'user_id'           => Auth::user()->id,
            ]);

            $existing = Invoice::
                  where('user_id', Auth::user()->id)
                ->where('product_id', $workshopid)
                ->where('product_type','workshop')
                ->first();

            if ($existing->price_status == 4) {
                alert()->error('', 'شما قبلا این دوره را ثبت نام کرده اید.');
                return Redirect::back();

            }elseif(!$existing) {

                $invoice = new Invoice();
                $invoice->user_id = Auth::user()->id;
                $invoice->product_id = $workshopid;
                $invoice->product_type = 'workshop';
                $invoice->product_price = $workshops->price;
                $invoice->type_use = $request->input('typeuse');
                $invoice->certificate_price = $workshops->certificate_price;
                $invoice->price = $workshops->certificate_price + $workshops->price;
                $invoice->save();
                $invoices = Invoice::whereId($invoice->id)->first();

            }elseif($existing->price_status == null){
                $invoices = Invoice::whereId($existing->id)->first();
            }

            return view('Site.Dashboard.paymentpage')->with(compact('companies', 'dashboardmenus','invoices' , 'notifs', 'workshops', 'workshopid', 'typeuse', 'certificate'));
        }

    }

    public function discountcheck(Request $request){

        $workshopsigns = DB::table('workshops')
            ->join('offers', 'workshops.id', '=', 'offers.workshop_id')
            ->join('workshopsigns', 'workshops.id', '=', 'workshopsigns.workshop_id')
            ->select('offers.discount','workshops.price as wprice', 'offers.percentage', 'workshopsigns.id', 'workshopsigns.workshop_price')
            ->where('offers.status', '=', 4)
            ->where('workshopsigns.user_id', '=', Auth::user()->id)
            ->where('offers.offercode', '=', $request->input('discountcode'))
            ->when(
                DB::table('offers')
                    ->where('status', '=', 4)
                    ->where('offercode', '=', $request->input('discountcode'))
                    ->whereNotNull('user_offer')
                    ->exists(),
                function ($query) {
                    $query->where('offers.user_offer', '=', Auth::user()->id);
                }
            )
            ->first();
        $Workshopsignee = Workshopsign::whereId($workshopsigns->id)->first();

        if ($workshopsigns->percentage <> null){
            $Workshopsignee->offer_percentage  = intval(str_replace('%', '', $workshopsigns->percentage));
            $Workshopsignee->price = $workshopsigns->workshop_price - ($workshopsigns->workshop_price * (intval(str_replace('%', '', $workshopsigns->percentage)))/100);
        }elseif ($workshopsigns->discount <> null) {
            $Workshopsignee->offer_discount = (int)$workshopsigns->discount;
            $Workshopsignee->price = $workshopsigns->workshop_price - (int)$workshopsigns->discount;
        }else {
            $Workshopsignee->price = $workshopsigns->wprice;
        }
        $Workshopsignee->update();

        if($workshopsigns == null){
            $discount   = 0;
            $percentage = 0;
        }else{
            $percentage = $workshopsigns->percentage ;
            $discount   = (int)$workshopsigns->discount   ;
        }
        $response = [
            'percentage'  => $percentage,
            'discount'    => $discount  ,
        ];

        return Response::json(['ok' =>true ,'message' => 'success','response'=>$response]);

    }

    public function paymentpage(Request $request)
    {
        $companies = Company::first();
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')
            ->MenuDashboard()
            ->orderBy('priority')
            ->get();

        $workshopid = $request->query('workshopid');

        $workshopsigns = DB::table('workshops')
            ->join('workshopsigns', 'workshops.id', '=', 'workshopsigns.workshop_id')
            ->select('workshops.title', 'workshops.price','workshops.offer','workshops.date', 'workshopsigns.typeuse', 'workshopsigns.workshop_id')
            ->where('workshopsigns.user_id', '=', $user->id)
            ->where('workshopsigns.workshop_id', '=', $workshopid)
            ->where('workshopsigns.pricestatus', '<>', null)
            ->first();

        //dd($workshopsigns);

        return view('Site.Dashboard.paymentpage')->with(compact('companies', 'dashboardmenus', 'notifs', 'workshopsigns'));
    }

//    public function pay(Request $request)
//    {
//
//        $workshopid     = $request->input('workshopid');
//        $finalprice     = $request->input('finalprice');
//
//        Session::put('workshopid'.Auth::user()->id, $workshopid);
//        Session::put('finalprice'.Auth::user()->id, $finalprice);
//
//
//        if (Auth::user()->email == null)
//        {
//            alert()->error('', 'اطلاعات ادرس ایمیل وارد نشده است، به قسمت تنظیمات حساب مراجعه کنید');
//            return Redirect::back();
//
//        }elseif (Auth::user()->phone == null){
//            alert()->error('', 'اطلاعات شماره همراه وارد نشده است، به قسمت تنظیمات حساب مراجعه کنید');
//            return Redirect::back();
//
//        }else {
//            $workshopsigns = DB::table('workshops as w')
//                ->join('workshopsigns as ws', 'w.id', '=', 'ws.workshop_id')
//                ->select('ws.id','w.title', 'w.price', 'w.date', 'ws.typeuse', 'ws.pricestatus', 'ws.price')
//                ->where('w.id', '=', $workshopid)
//                ->where('ws.user_id', '=', Auth::user()->id)
//                ->first();
//            if($workshopsigns->pricestatus == null){
//
//                $request = Toman::amount($workshopsigns->price)
//                    ->description($workshopsigns->title)
//                    ->callback(route('payment.callback'))
//                    ->mobile(Auth::user()->phone)
//                    ->email(Auth::user()->email)
//                    ->request();
//            }else{
//                alert()->error('', 'َشما قبلا در این دوره ثبت نام کرده اید');
//                return Redirect::back();
//            }
//            if ($request->successful()) {
//                DB::table('workshopsigns as w')->whereId($workshopsigns->id)
//                    ->update([
//                        'transactionId' => $request->transactionId()
//                    ]);
//                return $request->pay();
//            }
//
//            if ($request->failed()) {
//                // Handle transaction request failure.
//            }
//        }
//    }

//    public function callbackpay(Request $request)
//    {
//        $authority = $request->query('Authority');
//        $status = $request->query('Status');
//
//        if ($status == "OK") {
//            $workshopsign = DB::table('workshops as w')
//                ->join('workshopsigns as ws', 'w.id', '=', 'ws.workshop_id')
//                ->select('w.id','w.title', 'w.price', 'w.date', 'ws.typeuse', 'ws.price as totalprice')
//                ->where('ws.transactionId', '=', $authority)
//                ->where('ws.user_id', '=', Auth::user()->id)
//                ->where('ws.pricestatus', '=', null)
//                ->first();
//
//            $payment = Toman::amount($workshopsign->totalprice)->transactionId($authority)->verify();
//
//            if ($payment->successful()) {
//                Workshopsign::whereWorkshop_id($workshopsign->id)->whereUser_id(Auth::user()->id)->wherePricestatus(null)->update([
//                    'referenceId'       => $payment->referenceId(),
//                    'pricestatus'       => 4,
//                ]);
//            if ($workshopsign->typeuse == 1) {
//                $workshoptype = 'حضوری';
//
//            } elseif ($workshopsign->typeuse == 2) {
//                $workshoptype = 'آنلاین';
//            }
//            try {
//                $curl = curl_init();
//                curl_setopt_array($curl, array(
//                    CURLOPT_URL => "http://api.ghasedaksms.com/v2/send/verify",
//                    CURLOPT_RETURNTRANSFER => true,
//                    CURLOPT_ENCODING => "",
//                    CURLOPT_MAXREDIRS => 10,
//                    CURLOPT_TIMEOUT => 30,
//                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                    CURLOPT_CUSTOMREQUEST => "POST",
//                    CURLOPT_POSTFIELDS => http_build_query([
//                        'type' => '1',
//                        'param1' => Auth::user()->name,
//                        'param2' => $workshopsign->title,
//                        'param3' => $workshoptype,
//                        'receptor' => Auth::user()->phone,
//                        'template' => 'workshop',
//                    ]),
//                    CURLOPT_HTTPHEADER => array(
//                        "apikey: ilvYYKKVEXlM+BAmel+hepqt8fliIow1g0Br06rP4ko",
//                        "cache-control: no-cache",
//                        "content-type: application/x-www-form-urlencoded",
//                    ),
//                ));
//                $response = curl_exec($curl);
//                $err = curl_error($curl);
//                curl_close($curl);
//            } catch (Exception $exception) {
//            }
//                return view('Site.Dashboard.payment-success');
//            } else {
//                return view('Site.Dashboard.payment-failed');
//            }
//        } else {
//            return view('Site.Dashboard.payment-failed');
//        }
//    }

    public function edituserprofile(Request $request)
    {

        $user = User::whereId(Auth::user()->id)->select('id')->first();

        if ($request->input('email') === Auth::user()->email && $request->input('phone') === Auth::user()->phone) {
            $request->validate([
                'name' => ['required', 'string', 'min:3'],
                'email' => ['required', 'string', 'email'],
                'phone' => ['required', 'numeric', 'min:10'],
                'image' => ['image', 'mimes:jpeg,jpg,png,gif', 'max:50000', 'dimensions:width=200,height=200'],

            ]);
            $user->name = $request->input('name');
            $user->gender = $request->input('gender');
            $user->father_name = $request->input('father_name');
            $user->birthday = $request->input('birthday');
            $user->marital_status = $request->input('marital_status');
            $user->national_id = $request->input('national_id');
            $user->national_id = $request->input('national_id');
            $user->user_job = $request->input('user_job');
            $user->nationality = $request->input('nationality');
            $user->personality_type = $request->input('personality_type');
            $user->job_title = $request->input('job_title');
            $user->birth_certificate = $request->input('birth_certificate');
            $user->education_id = $request->input('education_id');
            $user->place_id = $request->input('place_id');
            $user->folder_id = $request->input('folder_id');
            $user->folder_base = $request->input('folder_base');
            $user->folder_validity = $request->input('folder_validity');
            $user->telphone = $request->input('telphone');
            $user->state_id = $request->input('state_id');
            $user->city_id = $request->input('city_id');
            $user->address = $request->input('address');
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $imagePath = public_path("users");
                $imagelink = "users";
                $filename = Str::random(30) . "." . $file->clientExtension();
                $newImage = Image::make($file);
                $newImage->fit(480, 320);
                $user->image = $imagelink . '/' . $filename;
                $newImage->save($imagePath . '/' . $filename);
            }
            $user->save();
        } elseif ($request->input('email') === Auth::user()->email && $request->input('phone') != Auth::user()->phone) {
            $request->validate([
                'name' => ['required', 'string', 'min:3'],
                'email' => ['required', 'string', 'email'],
                'phone' => ['required', 'numeric', 'min:10', 'unique:users,phone'],
                'image' => ['image', 'mimes:jpeg,jpg,png,gif', 'max:50000', 'dimensions:width=200,height=200'],

            ]);
            $user->name = $request->input('name');
            $user->gender = $request->input('gender');
            $user->father_name = $request->input('father_name');
            $user->birthday = $request->input('birthday');
            $user->national_id = $request->input('national_id');
            $user->job_title = $request->input('job_title');
            $user->birth_certificate = $request->input('birth_certificate');
            $user->education_id = $request->input('education_id');
            $user->place_id = $request->input('place_id');
            $user->folder_id = $request->input('folder_id');
            $user->folder_base = $request->input('folder_base');
            $user->folder_validity = $request->input('folder_validity');
            $user->telphone = $request->input('telphone');
            $user->state_id = $request->input('state_id');
            $user->city_id = $request->input('city_id');
            $user->address = $request->input('address');
            $user->phone = $request->input('phone');
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $imagePath = public_path("users");
                $imagelink = "users";
                $filename = Str::random(30) . "." . $file->clientExtension();
                $newImage = Image::make($file);
                $newImage->fit(480, 320);
                $user->image = $imagelink . '/' . $filename;
                $newImage->save($imagePath . '/' . $filename);
            }
            $user->save();

        } elseif ($request->input('phone') === Auth::user()->phone && $request->input('email') != Auth::user()->email) {
            $request->validate([
                'name' => ['required', 'string', 'min:3'],
                'email' => ['required', 'string', 'email', 'unique:users,email'],
                'phone' => ['required', 'numeric', 'min:10'],
                'image' => ['image', 'mimes:jpeg,jpg,png,gif', 'max:50000', 'dimensions:width=200,height=200'],

            ]);
            $user->name = $request->input('name');
            $user->gender = $request->input('gender');
            $user->father_name = $request->input('father_name');
            $user->birthday = $request->input('birthday');
            $user->national_id = $request->input('national_id');
            $user->job_title = $request->input('job_title');
            $user->birth_certificate = $request->input('birth_certificate');
            $user->education_id = $request->input('education_id');
            $user->place_id = $request->input('place_id');
            $user->folder_id = $request->input('folder_id');
            $user->folder_base = $request->input('folder_base');
            $user->folder_validity = $request->input('folder_validity');
            $user->telphone = $request->input('telphone');
            $user->state_id = $request->input('state_id');
            $user->city_id = $request->input('city_id');
            $user->address = $request->input('address');
            $user->email = $request->input('email');
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $imagePath = public_path("users");
                $imagelink = "users";
                $filename = Str::random(30) . "." . $file->clientExtension();
                $newImage = Image::make($file);
                $newImage->fit(480, 320);
                $user->image = $imagelink . '/' . $filename;
                $newImage->save($imagePath . '/' . $filename);
            }
            $user->save();
        } elseif ($request->input('phone') != Auth::user()->phone && $request->input('email') != Auth::user()->email) {
            $request->validate([
                'name' => ['required', 'string', 'min:3'],
                'email' => ['required', 'string', 'email', 'unique:users,email'],
                'phone' => ['required', 'numeric', 'min:10', 'unique:users,phone'],
                'image' => ['image', 'mimes:jpeg,jpg,png,gif', 'max:50000', 'dimensions:width=200,height=200'],

            ]);
            $user->name = $request->input('name');
            $user->gender = $request->input('gender');
            $user->father_name = $request->input('father_name');
            $user->birthday = $request->input('birthday');
            $user->national_id = $request->input('national_id');
            $user->job_title = $request->input('job_title');
            $user->birth_certificate = $request->input('birth_certificate');
            $user->education_id = $request->input('education_id');
            $user->place_id = $request->input('place_id');
            $user->folder_id = $request->input('folder_id');
            $user->folder_base = $request->input('folder_base');
            $user->folder_validity = $request->input('folder_validity');
            $user->telphone = $request->input('telphone');
            $user->state_id = $request->input('state_id');
            $user->city_id = $request->input('city_id');
            $user->address = $request->input('address');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $imagePath = public_path("users");
                $imagelink = "users";
                $filename = Str::random(30) . "." . $file->clientExtension();
                $newImage = Image::make($file);
                $newImage->fit(480, 320);
                $user->image = $imagelink . '/' . $filename;
                $newImage->save($imagePath . '/' . $filename);
            }
            $user->save();
        }
        return Redirect::back();
    }

    public function editusermobile(Request $request)
    {
        $user = User::whereId(Auth::user()->id)->select('id')->first();
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'string', 'email'],
            'phone' => ['required', 'numeric', 'min:10'],
            'image' => ['image', 'mimes:jpeg,jpg,png,gif', 'max:50000'],
        ]);
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->national_id = $request->input('national_id');
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $imagePath = public_path("users");
            $imagelink = "users";
            $filename = Str::random(30) . "." . $file->clientExtension();
            $newImage = Image::make($file);
            $newImage->fit(480, 320);
            $user->image = $imagelink . '/' . $filename;
            $newImage->save($imagePath . '/' . $filename);
        }
        $user->save();

        $request->session()->flash('auth', [
            'user_id' => $user->id,
            'reg' => 1
        ]);

        $code = ActiveCode::generateCode($user);

        $user->notify(new ActiveCodeNotification($code, $request->input('phone')));
        $phone = $request->input('phone');
        return redirect(route('phone.token'))->with(['phone' => $phone]);
    }

    public function changepassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if (Hash::check($request->input('old_password'), Auth::user()->password)) {
            $user = User::whereId(Auth::user()->id)->first();
            $user->password = $request->input('password');
            $user->save();
            alert()->success('عملیات موفق', 'رمز عبور با موفقیت تغییر کرد');
        } else {
            alert()->error('عملیات ناموفق', 'رمز عبور فعلی نادرست وارد شده است');
        }
        return Redirect::back();

    }

    public function folders(Request $request)
    {
        $user = Auth::user();
        $notifs = $user->notifs()->whereActive(1)->orderBy('id', 'DESC')->get();
        $companies = Company::first();
        $dashboardmenus = Menu::select('id', 'title', 'slug', 'class', 'priority')->MenuDashboard()->orderBy('priority')->get();

        return view('Site.Dashboard.folders')->with(compact('companies', 'dashboardmenus', 'notifs'));

    }

    public function creatbankpayment(Request $request)
    {

        $request->validate([
            'bank_card' => ['required', 'string'],
            'date' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'description' => ['required', 'string', 'min:3'],
        ]);

        $payment = new Payment();

        $payment->card_number = $request->input('bank_card');
        $payment->date = $request->input('date');
        $payment->amount = $request->input('amount');
        $payment->description = $request->input('description');
        $payment->user_id = Auth::user()->id;

        $payment->save();

        return Redirect::back();
    }

    public function changeemail(Request $request)
    {
        $request->validate([
            'old_email' => ['required', 'string', 'min:8'],
            'new_email' => ['required', 'string', 'min:8'],
        ]);
        if (($request->input('old_email') == Auth::user()->email) && ($request->input('old_email') != $request->input('new_email'))) {
            $user = User::whereId(Auth::user()->id)->first();
            $user->email = $request->input('new_email');
            $user->save();
            alert()->success('عملیات موفق', 'ایمیل با موفقیت تغییر کرد');
        } else {
            alert()->error('عملیات ناموفق', 'ایمیل فعلی نادرست وارد شده است');
        }
        return Redirect::back();

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
