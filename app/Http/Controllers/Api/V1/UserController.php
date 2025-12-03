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
use App\Models\City;
use App\Models\Role;
use App\Models\State;
use App\Models\Dashboard\Estelam;
use App\Models\Profile\EstelamToken;
use App\Models\TypeUser;
use App\Models\User;
use App\Models\User_logs;
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
    public function getregister(){
        $role_user      = Role::select('id','title_fa as title')->where('id','>','3')->get()->toArray();
        $response = [
            'role' => $role_user,
        ];
        return Response::json(['ok' =>true ,'message' => 'success','response'=>$response]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'birthday'          => 'required|string|max:12',
            'role_id'           => 'required',
            'national_id'       => 'required|string|max:12',
            'phone'             => 'required|string|max:20|unique:users,phone',
        ]);

        DB::beginTransaction();

        $phone       = $this->convertPersianToEnglishNumbers($request->phone);
        $national_id = $this->convertPersianToEnglishNumbers($request->national_id);
        $birthday    = $this->convertPersianToEnglishNumbers($request->birthday);
        $birthday    = str_replace('/', '', $birthday);
        $birthday    = substr_replace(substr_replace($birthday, '/', 4, 0), '/', 7, 0);

        // ایجاد کاربر
        $user = User::create([
            'phone'             => $phone,
            'national_id'       => $national_id,
            'birthday'          => $birthday,
            'level'             => 'site',
            'status'            => 4,
            'role_id'           => $request->role_id,
        ]);

        // تولید توکن JWT
        $token = auth('api')->login($user);

        $code = ActiveCode::generateCode($user);

        $user->notify(new ActiveCodeNotification($code , $user->phone));

        // ثبت لاگ
        User_logs::create([
            'user_id'    => $user->id,
            'action'     => 'register',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status'     => true,
            'description'=> 'ثبت‌نام موفق همراه با ورود',
        ]);


        DB::commit();

        return response()->json(
            ['isSuccess' => true,
                'message' => 'ثبت نام با موفقیت انجام شد',
                'errors' => null,
                'status_code' => 200,
                'result' => $token
            ], 200);
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
            $credentials = $request->only(['phone', 'password']);

            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);

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

//        auth()->user()->update([
//            'api_token' => Str::random(100)
//        ]);
//
//        $response = [
//            'token'=>auth()->user()->api_token,
//        ];
//        return Response::json(['ok' =>true ,'message' => 'success','response'=>$response]);

    }

    public function profile(){

        $user = auth()->user();

        $userData = $user->load([
            'state:id,title',
            'city:id,title',
            'wallet:id,user_id,balance'
        ]);

        $response = [
            'user' => [
                'email'            => $userData->email,
                'name'             => $userData->name,
                'phone'            => $userData->phone,
                'national_id'      => $userData->national_id,
                'father_name'      => $userData->father_name,
                'birthday'         => $userData->birthday,
                'gender'           => $userData->gender,
                'age'              => $userData->age,
                'marital_status'   => $userData->marital_status,
                'telphone'         => $userData->telphone,
                'address'          => $userData->address,
                'postalcode'       => $userData->postalcode,
                'image'            => $userData->image,
                'birth_certificate'=> $userData->birth_certificate,
                'state'            => optional($userData->state)->title,
                'city'             => optional($userData->city)->title,
                'type'             => $userData->role_id,
                'timeset'          => $userData->created_at,
            ],

            'wallet_balance' => number_format(optional($userData->wallet)->balance ?? 0),

            'state' => State::select('id', 'title')->get(),
            'city'  => City::select('id', 'title')->get(),
        ];

        return response()->json(['isSuccess' => true,
            'message' => 'مقادیر رکورد دریافت شد',
            'errors' => null,
            'status_code' => 200,
            'result' => $response
        ], 200);
    }

    public function editprofile(Request $request)
    {
        $user = auth()->user();

        // لیست فیلدهای مجاز برای ویرایش
        $updatable = [
            'role_id',
            'national_id',
            'name',
            'gender',
            'birthday',
            'marital_status',
            'father_name',
            'postalcode',
            'telphone',
            'state_id',
            'city_id',
            'address',
            'place_id'
        ];

        // فقط فیلدهایی که ارسال شده و در لیست مجاز هستند گرفته می‌شود
        $data = $request->only($updatable);

        // اگر هیچ فیلدی ارسال نشده باشد
        if (empty($data)) {
            return response()->json([
                'ok' => false,
                'message' => 'هیچ فیلدی برای تغییر ارسال نشده است.'
            ], 400);
        }

        // آپدیت یکجا
        $user->update($data);

        return Response::json(
            ['isSuccess' => true,
                'message' => 'مقادیر ارسالی بروز شد',
                'errors' => null,
                'status_code' => 200,
                'result' => $data
            ], 200);
    }

    public function addpass(Request $request){

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();
        return Response::json(['ok' => true , 'message' => 'success' , 'response' => 'رمز جدید با موفقیت ثبت شد']);
    }

    public function addmail(Request $request){

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        $user = auth()->user();
        $user->email = $request->input('email');
        $user->save();
        return Response::json(['ok' => true , 'message' => 'success' , 'response' => 'آدرس ایمیل با موفقیت ثبت شد']);

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


    protected function convertPersianToEnglishNumbers($string) {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($persianNumbers, $englishNumbers, $string);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth('api')->factory()->getTTL()
        ]);
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


}
