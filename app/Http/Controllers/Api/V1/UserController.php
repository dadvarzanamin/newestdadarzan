<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\SendImageInquiryJob;
use App\Jobs\SendNameInquiryJob;
use App\Models\ActiveCode;
use App\Models\APP\contractDrafting;
use App\Models\APP\documentDrafting;
use App\Models\APP\judgement;
use App\Models\APP\Law;
use App\Models\APP\lawsuit;
use App\Models\APP\legalAdvice;
use App\Models\APP\tokil;
use App\Models\Dashboard\Estelam;
use App\Models\Profile\City;
use App\Models\Profile\EstelamToken;
use App\Models\Profile\State;
use App\Models\TypeUser;
use App\Models\User;
use App\Notifications\ActiveCode as ActiveCodeNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    protected function convertPersianToEnglishNumbers($string) {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($persianNumbers, $englishNumbers, $string);
    }

    public function login(Request $request){
        $phone      = $this->convertPersianToEnglishNumbers($request->input('phone'));
        $password   = $this->convertPersianToEnglishNumbers($request->input('password'));
        $validData = $this->validate($request, [
            'phone' => 'required|exists:users',
            'password' => 'required'
        ]);
        $user = User::wherePhone($phone)->first();
        if ($user != null) {
            if (Hash::check($password, $user->password)) {
                Auth::loginUsingId($user->id);
                if(Auth::check()){
                    auth()->user()->update([
                        'api_token' => Str::random(100)
                    ]);
                    $response = [
                        'token'=>auth()->user()->api_token,
                    ];
                    return Response::json(['ok' =>true ,'message' => 'success','response'=>$response]);
                }
            }
        }elseif (! auth()->attempt($validData)){
            $response = [
                'error' => 'شماره موبایل و یا رمز عبور نادرست است',
            ];
            return Response::json(['ok' => false,'message' => 'failed','response' => $response]);

        }

//        $date = auth::user()->updated_at;
//        if ($date <= Carbon::today()->subDays( 1 )){
//            auth()->user()->update([
//                'api_token' => ''
//            ]);
//        }

        auth()->user()->update([
            'api_token' => Str::random(100)
        ]);

        $response = [
            'token'=>auth()->user()->api_token,
        ];
        return Response::json(['ok' =>true ,'message' => 'success','response'=>$response]);

    }

    public function getregister(){
        $typeuser           = TypeUser::select('id','title_fa as title')->where('id','>','3')->get()->toArray();

        //$citis              = City::select('id as city_id','title as city' , 'state_id')->get()->toArray();
        //$state              = State::select('id as state_id','title as state')->get()->toArray();
        $response = [
            'city' => $typeuser,

        ];

        return Response::json(['ok' =>true ,'message' => 'success','response'=>$response]);

    }

    public function register(Request $request)
    {
        // نرمال‌سازی ورودی‌ها
        $phoneRaw    = $request->input('phone');
        $nidRaw      = $request->input('national_id');
        $birthRaw    = $request->input('birthday');

        $phone    = $this->convertPersianToEnglishNumbers($phoneRaw);
        $nid      = $this->convertPersianToEnglishNumbers($nidRaw);
        $birthday = $this->convertPersianToEnglishNumbers($birthRaw);
        $birthday = str_replace('/', '', $birthday);

        // ولیدیشن
        $validData = $this->validate($request, [
            'phone'       => 'required|string',
            'national_id' => 'required|string',
            'birthday'    => 'required|string',
            'type_id'     => 'required|string',
        ]);

        // بررسی کاربر موجود
        $user = User::where('phone', $phone)->first();
        if ($user !== null) {
            return response()->json([
                'isSuccess'   => false,
                'message'     => 'شماره موبایل قبلا ثبت شده است',
                'errors'      => true,
                'status_code' => 409,
            ], 409);
        }

        // دریافت توکن سرویس
        $tokenRow = EstelamToken::select('token', 'appname')->first();
        if (!$tokenRow) {
            return response()->json([
                'isSuccess'   => false,
                'message'     => 'تنظیمات سرویس در دسترس نیست',
                'errors'      => true,
                'status_code' => 500,
            ], 500);
        }

        $shahkar = Estelam::find(17);
        if (!$shahkar) {
            return response()->json([
                'isSuccess'   => false,
                'message'     => 'تنظیمات سرویس شاهکار یافت نشد',
                'errors'      => true,
                'status_code' => 500,
            ], 500);
        }

        $headers = [
            'token:' . $tokenRow->token,
            'appname:' . $tokenRow->appname,
            'Content-Type: application/json',
        ];

        // درخواست به شاهکار
        $responseShahkar = $this->sendCurlRequest($shahkar->action_route, $shahkar->method, $headers, [
            "mobileNumber" => $phone,
            "nationalCode" => $nid,
        ]);

        if (!isset($responseShahkar['isSuccess']) || $responseShahkar['isSuccess'] === false) {
            return response()->json([
                'isSuccess'   => false,
                'message'     => 'در حال حاضر ارتباط با سرور شاهکار برقرار نشد، لطفا بعدا تلاش کنید',
                'errors'      => true,
                'status_code' => 503,
            ], 503);
        }

        $isMatched = $responseShahkar['data']['result']['isMatched'] ?? null;
        if ($isMatched === false) {
            return response()->json([
                'isSuccess'   => false,
                'message'     => 'شماره موبایل وارد شده برای این کد ملی نمی‌باشد، لطفا شماره موبایل درست وارد نمایید',
                'errors'      => true,
                'status_code' => 422,
            ], 422);
        }

        if ($isMatched === true) {
            // فرمت تاریخ YYYY/MM/DD
            $birthdayFormatted = substr_replace(substr_replace($birthday, '/', 4, 0), '/', 7, 0);

            $user = User::create([
                'phone'       => $phone,
                'national_id' => $nid,
                'birthday'    => $birthdayFormatted,
                'type_id'     => $validData['type_id'],
            ]);

            $user->update([
                'api_token' => Str::random(100), // یا JWT/Sanctum جایگزین شود
            ]);

            $user->wallet()->create(['balance' => 0]);

            $code = ActiveCode::generateCode($user);
            $user->notify(new ActiveCodeNotification($code, $phone));

            // ارسال Jobها
            SendNameInquiryJob::dispatch($user->id, $nid, $birthday, $headers);
            SendImageInquiryJob::dispatch($user->id, $nid, $birthday, $headers);

            return response()->json([
                'isSuccess'   => true,
                'message'     => 'کاربر با موفقیت ایجاد شد. اطلاعات تکمیلی در حال دریافت می‌باشد.',
                'errors'      => null,
                'status_code' => 200,
                'token'       => $user->api_token,
            ], 200);
        }

        // اگر ساختار پاسخ غیرمنتظره بود
        return response()->json([
            'isSuccess'   => false,
            'message'     => 'پاسخ نامعتبر از سرور شاهکار دریافت شد',
            'errors'      => true,
            'status_code' => 500,
        ], 500);
    }

    function sendCurlRequest($url, $method, $headers, $data = [])
    {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if (strtoupper($method) === 'POST') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Exception(curl_error($ch));
            }

            curl_close($ch);
            return json_decode($response, true);
        } catch (\Exception $e) {
            \Log::error("CURL Request Failed: " . $e->getMessage(), [
                'url' => $url,
                'method' => $method,
                'data' => $data
            ]);
            return null;
        }
    }
    public function token(Request $request){

        $token= (int)$request->input('token');

        $status = activeCode::whereCode($token)->where('expired_at' , '>' , now())->first();

        if(! $status) {
            return response()->json(
                ['isSuccess'       => false,
                    'message'      => 'کد فعال سازی نادرست',
                    'errors'       => true,
                    'status_code'  => 500,
                ], 500);

        }else{
            $user = User::whereId($status->user_id)->first();
            $user->activeCode()->delete();
            $user->phone_verify = 1;
            $user->api_token = Str::random(100);
            $user->update();

            return response()->json(
                ['isSuccess'       => true,
                    'token'        => $user->api_token,
                    'message'      => 'کاربر با موفقیت ایجاد شد. اطلاعات تکمیلی در حال دریافت می‌باشد.',
                    'errors'       => null,
                    'status_code'  => 200,
                ], 200);

        }
    }

    public function remember(Request $request){

        $validData = $request->validate([
            'phone' => ['required', 'exists:users,phone']
        ]);

        $user = User::wherePhone($validData['phone'])->first();

        $code = ActiveCode::generateCode($user);

        $user->notify(new ActiveCodeNotification($code , $user->phone));

        $response = 'ارسال موفق ، کد مد نظر را وارد نمایید' ;

        return Response::json(['ok' => true , 'message' => 'success' , 'response' => $response]);

    }

    public function recoverpass(Request $request)
    {
        $user = User::findOrfail(auth::user()->id);
        if ($request->input('password_old') != null){
            if (auth::user()->password = Hash::make($request->input('password_old'))) {
                $request->validate(['password' => 'required|string|min:8|confirmed']);
                $user->password = Hash::make($request->input('password'));
                $user->update();

                $response = 'رمز جدید با موفقیت ثبت شد' ;
            }else{
                $response = 'رمز وارد شده اشتباه است' ;
            }
        }else {
            $request->validate(['password' => 'required|string|min:8|confirmed']);
            $user->password = Hash::make($request->input('password'));
            $user->update();
            $response = 'رمز جدید با موفقیت ثبت شد' ;
        }


        return Response::json(['ok' => true , 'message' => 'success' , 'response' => $response]);
    }

    public function profile(){

        if (Auth::check()) {

            $users = DB::table('users')
                ->leftjoin('states', 'users.state_id', '=', 'states.id')
                ->leftjoin('cities', 'users.city_id', '=', 'cities.id')
                ->select('users.email' , 'users.name',  'users.phone', 'users.national_id', 'users.father_name', 'users.birthday', 'users.gender', 'users.age'
                    , 'users.originality', 'users.marital_status', 'users.telphone', 'users.address', 'users.postalcode', 'users.image', 'users.imagedata'
                    , 'users.birth_certificate', 'states.title as state', 'cities.title as city', 'users.api_token' , 'users.type_id as type', 'users.created_at as timeset' )
                ->where('users.id', '=', Auth::user()->id)
                ->first();

            $states = State::all();
            $citis = City::all();
            $wallet_balance = number_format(auth()->user()->wallet->balance);
            $response = [
                'user'          => $users,
                'wallet_balance'=> $wallet_balance,
                'state'         => $states,
                'city'          => $citis,
            ];
            return Response::json(['ok' => true , 'message' => 'success' , 'response' => $response]);
        }else{
            $response = [
                'user' => 'شما هنوز به حساب خود وارد نشده اید'
            ];
            return Response::json(['ok' => false , 'message' => 'faild' , 'response' => $response]);
        }

    }

    public function editprofile(Request $request){

        $user = auth::user();

        if ($request->input('type_id')) {
            $user->type_id = $request->input('type_id');
        }elseif ($request->input('phone')) {
            $user->phone            = $request->input('phone');
        }elseif ($request->input('national_id')) {
            $user->national_id      = $request->input('national_id');
        }elseif ($request->input('name')) {
            $user->name             = $request->input('name');
        }elseif ($request->input('nationality')) {
            $user->nationality      = $request->input('nationality');
        }elseif ($request->input('gender')) {
            $user->gender           = $request->input('gender');
        }elseif ($request->input('birthday')) {
            $user->birthday         = $request->input('birthday');
        }elseif ($request->input('marital_status')) {
            $user->marital_status   = $request->input('marital_status');
        }elseif ($request->input('father_name')) {
            $user->father_name      = $request->input('father_name');
        }elseif ($request->input('postalcode')) {
            $user->postalcode       = $request->input('postalcode');
        }elseif ($request->input('telphone')) {
            $user->telphone         = $request->input('telphone');
        }elseif ($request->input('state_id')) {
            $user->state_id         = $request->input('state_id');
        }elseif ($request->input('city_id')) {
            $user->city_id          = $request->input('city_id');
        }elseif ($request->input('address')) {
            $user->address          = $request->input('address');
        }elseif ($request->input('place_id')) {
            $user->place_id = $request->input('place_id');
        }

        $user->update();
        $response = 'تغییرات با موفقیت انجام شد' ;

        return Response::json(['ok' => true , 'message' => 'success' , 'response' => $response]);
    }

    public function demands(){

        if (Auth::check()) {

            $judgement          = judgement::whereUser_id(Auth::user()->id)->get();
            $documentDrafting   = documentDrafting::whereUser_id(Auth::user()->id)->get();
            $contractDrafting   = contractDrafting::whereUser_id(Auth::user()->id)->get();
            $legalAdvice        = legalAdvice::whereUser_id(Auth::user()->id)->get();
            $lawsuit            = lawsuit::whereUser_id(Auth::user()->id)->get();
            $tokil              = tokil::whereUser_id(Auth::user()->id)->get();

            $response = [
                'judgement'         => $judgement,
                'documentDrafting'  => $documentDrafting,
                'contractDrafting'  => $contractDrafting,
                'legalAdvice'       => $legalAdvice,
                'lawsuit'           => $lawsuit,
                'tokil'             => $tokil,
            ];
            return Response::json(['ok' => true , 'message' => 'success' , 'response' => $response]);
        }else{
            $response = [
                'user' => 'شما هنوز به حساب خود وارد نشده اید'
            ];
            return Response::json(['ok' => false , 'message' => 'faild' , 'response' => $response]);
        }

    }

    public function laws(){

        if (Auth::check()) {

            $laws          = Law::all();


            $response = [
                'laws'         => $laws,

            ];
            return Response::json(['ok' => true , 'message' => 'success' , 'response' => $response]);
        }else{
            $response = [
                'user' => 'شما هنوز به حساب خود وارد نشده اید'
            ];
            return Response::json(['ok' => false , 'message' => 'faild' , 'response' => $response]);
        }

    }

    public function addpass(Request $request){

        $user = User::findOrfail(auth::user()->id);
        $request->validate(['password' => 'required|min:6|confirmed']);
        $user->password = Hash::make($request->input('password'));
        $user->update();

        $response = 'رمز جدید با موفقیت ثبت شد' ;
        return Response::json(['ok' => true , 'message' => 'success' , 'response' => $response]);

    }

    public function addmail(Request $request){

        $user = User::findOrfail(auth::user()->id);
        $request->validate(['email' => 'required|min:6|email']);
        $user->email = $request->input('email');
        $user->update();

        $response = 'آدرس ایمیل با موفقیت ثبت شد' ;
        return Response::json(['ok' => true , 'message' => 'success' , 'response' => $response]);

    }
}
