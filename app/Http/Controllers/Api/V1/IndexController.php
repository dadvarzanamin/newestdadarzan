<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Emploee;
use App\Models\Invoice;
use App\Models\Law;
use App\Models\MediaFile;
use App\Models\Offer;
use App\Models\City;
use App\Models\Product;
use App\Models\State;
use App\Models\Version;
use Evryn\LaravelToman\Facades\Toman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function getState()
    {
        $states = State::select('id', 'title')->get();
        if ($states) {
            return response()->json(
                ['isSuccess' => true,
                    'message' => 'مقادیر رکورد دریافت شد',
                    'errors' => null,
                    'status_code' => 200,
                    'result' => $states
                ], 200);
        } else {
            return response()->json(
                ['isSuccess' => null,
                    'message' => 'مقداری یافت نشد.',
                    'errors' => true,
                    'status_code' => 500,
                ], 500);
        }
    }

    public function getCity(Request $request)
    {
        $cities = City::select('id', 'title')->whereState_id($request->input('id'))->get();
        if ($cities) {
            return response()->json(
                ['isSuccess' => true,
                    'message' => 'مقادیر رکورد دریافت شد',
                    'errors' => null,
                    'status_code' => 200,
                    'result' => $cities
                ], 200);
        } else {
            return response()->json(
                ['isSuccess' => null,
                    'message' => 'مقداری یافت نشد.',
                    'errors' => true,
                    'status_code' => 500,
                ], 500);
        }
    }

    public function version(){
        $response = [
            'version'    => Version::latest('id')->first() ,
        ];
        return Response::json(['ok' =>true ,'message' => 'success','response'=>$response]);
    }

    public function index(){
        $emploees       = Emploee::select('id' , 'priority' , 'fullname' , 'image' , 'side' , 'status')->whereStatus(4)->orderBy('priority')->get();
        return response()->json(
            ['isSuccess' => true,
                'message' => 'مقادیر رکورد دریافت شد',
                'errors' => null,
                'status_code' => 200,
                'result' => $emploees
            ], 200);
    }

    public function court(){
        $courts       = Court::whereStatus(4)->get();
        return response()->json(
            ['isSuccess' => true,
                'message' => 'مقادیر رکورد دریافت شد',
                'errors' => null,
                'status_code' => 200,
                'result' => $courts
            ], 200);
    }

    public function discountcheck(Request $request){

        $offer = Invoice::leftJoin('offers', 'offers.product_id', '=', 'invoices.product_id')
            ->select('invoices.id', 'invoices.price', 'offers.discount', 'offers.percentage')
            ->where([
                ['offers.status'         , '=', 4],
                ['invoices.user_id'      , '=', Auth::id()],
                ['invoices.product_type' , '=', $request->input('product_type')],
                ['offers.offercode'      , '=', $request->input('discountcode')],
            ])
            ->where(function ($q) {
                $q->whereNull('offers.user_offer')
                ->orWhere('offers.user_offer', Auth::id());
            })
            ->first();

        if (!$offer) {
            return response()->json(
                ['isSuccess' => null,
                    'message' => 'کد وارد شده معتبر نمی باشد',
                    'errors' => true,
                    'status_code' => 500,
                    'result' => ''
                ], 500);
        }

            $invoice = Invoice::where('user_id', Auth::id())
                ->where('product_id', $request->input('product_id'))
                ->where('product_type', $request->input('product_type'))
                ->whereNull('price_status')
                ->first();

        if ($offer->percentage <> null){
            $invoice->offer_percentage  = $offer->percentage;
            $invoice->final_price       = $invoice->price - ($invoice->price * (intval(str_replace('%', '', $offer->percentage)))/100);
        }elseif ($offer->discount <> null) {
            $invoice->offer_discount    = $offer->discount;
            $invoice->final_price       = $invoice->price - (int)$offer->discount;
        }else {
            $invoice->final_price       = $invoice->price;
            $invoice->offer_percentage  = 0;
            $invoice->final_price       = 0;
        }
        $invoice->update();

        return response()->json(
            ['isSuccess' => true,
                'message' => 'عملیات با موفقیت انجام شد.',
                'errors' => false,
                'status_code' => 200,
                'result' => $invoice->final_price,
            ], 200);
    }

    public function pay(Request $request)
    {
        if ($request->input('certificate') == 1){
            $user = Auth::user();
            if ($request->input('birthday') == null || $request->input('national_id') == null ||  $request->input('father_name') == null ) {
                $response = [
                    'error' => 'نام پدر یا تاریخ تولد یا کد ملی خالی می باشد'
                ];
                return Response::json(['ok' =>false ,'message' => 'failed','response'=>$response]);
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
        }
         $workshopsigns = DB::table('workshops as w')
                ->join('workshopsigns as ws', 'w.id', '=', 'ws.workshop_id')
                ->select( 'ws.id', 'w.certificate_price as c_price' , 'ws.price' , 'w.price as wprice')
                ->where('w.id', '=', $request->input('workshop_id'))
                ->where('ws.user_id', '=', Auth::user()->id )
                ->where('ws.pricestatus', '=', null )
                ->first();
            $Workshopsigne = Workshopsign::whereId($workshopsigns->id)->first();
            $Workshopsigne->certificate  = $request->input('certificate');
            $Workshopsigne->certif_price = $workshopsigns->c_price;
            $Workshopsigne->typeuse      = $request->input('typeuse');
            if ($workshopsigns->price == 0 && $request->input('certificate') == 1) {
                $Workshopsigne->price = $workshopsigns->c_price + $workshopsigns->wprice;
            }elseif($workshopsigns->price == 0 && $request->input('certificate') == 0){
                $Workshopsigne->price = $workshopsigns->wprice;
            }elseif($workshopsigns->price > 0 && $request->input('certificate') == 1){
                $Workshopsigne->price = $workshopsigns->c_price + $workshopsigns->price;
            }elseif($workshopsigns->price > 0 && $request->input('certificate') == 0){
                $Workshopsigne->price =  $workshopsigns->price;
            }
            $Workshopsigne->update();

        //Session::put('workshopid'.Auth::user()->id, $workshopid);
        //Session::put('finalprice'.Auth::user()->id, $finalprice);

        if (Auth::user()->email == null){
            return Response::json(['ok' =>false ,'message' => 'failed' , 'response' => 'ادرس ایمیل خالی می باشد']);
        }elseif(Auth::user()->phone == null){
            return Response::json(['ok' =>false ,'message' => 'failed' , 'response' => 'شماره موبایل خالی می باشد']);
        }else{
            $workshopsigns = DB::table('workshops as w')
                ->join('workshopsigns as ws', 'w.id', '=', 'ws.workshop_id')
                ->select('w.title' , 'ws.price', 'ws.pricestatus')
                ->where('w.id', '=', $request->input('workshop_id'))
                ->where('ws.user_id', '=', Auth::user()->id )
                ->first();
            if($workshopsigns->pricestatus == null){
                $workshopsigns = DB::table('workshops as w')
                    ->join('workshopsigns as ws', 'w.id', '=', 'ws.workshop_id')
                    ->select('ws.id','w.title' , 'ws.price', 'ws.pricestatus' , 'ws.transactionId')
                    ->where('w.id', '=', $request->input('workshop_id'))
                    ->where('ws.user_id', '=', Auth::user()->id )
                    ->first();

                $request = Toman::amount($workshopsigns->price)
                    ->description($workshopsigns->title)
                    ->callback(url('https://dadvarzanamin.ir/api/v1/backtoapp'))
//                    ->orderId($workshopsigns->transactionId)
                    ->mobile(Auth::user()->phone)
                    ->email(Auth::user()->email)
                    ->request();

            }else{
                $response = [
                    'error'  => 'َشما قبلا در این دوره ثبت نام کرده اید',
                ];
                return Response::json(['ok' =>false ,'message' => 'failed','response'=>$response]);
            }
            if ($request->successful()) {
                    DB::table('workshopsigns as w')->whereId($workshopsigns->id)
                    ->update([
                        'transactionId' => $request->transactionId()
                    ]);
                return response()->json([
                    "ok" => true,
                    "message" => "لینک پرداخت ایجاد شد.",
                    "response" => [
                        "url" => "https://www.zarinpal.com/pg/StartPay/" . $request->transactionId(),
                        "authority" => $request->transactionId(),
                    ],
                ]);
            } else {
                return response()->json([
                    "ok" => false,
                    "message" => "خطا در ایجاد پرداخت.",
                    "errors" => $request->messages(),
                ], 500);
            }
        }
    }

    public function callbackpay(Request $request)
    {
        $authority = $request->query('Authority');
        $status = $request->query('Status');

        if ($status == "OK") {
            $workshopsign = DB::table('workshops as w')
                ->join('workshopsigns as ws', 'w.id', '=', 'ws.workshop_id')
                ->join('users as u', 'ws.user_id', '=', 'u.id')
                ->select( 'u.name as user_name','u.phone', 'ws.id','w.title', 'w.price', 'w.date', 'ws.typeuse', 'ws.price as totalprice')
                ->where('ws.transactionId', '=', $authority)
                //->where('ws.user_id', '=', Auth::user()->id)
                ->where('ws.pricestatus', '=', null)
                ->first();

            $payment = Toman::amount($workshopsign->totalprice)->transactionId($authority)->verify();

            if ($payment->successful()) {
                Workshopsign::whereId($workshopsign->id)->wherePricestatus(null)->update([
                    'referenceId'       => $payment->referenceId(),
                    'pricestatus'       => 4,
                ]);
                if ($workshopsign->typeuse == 1) {
                    $workshoptype = 'حضوری';

                } elseif ($workshopsign->typeuse == 2) {
                    $workshoptype = 'آنلاین';
                }
                try {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "http://api.ghasedaksms.com/v2/send/verify",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => http_build_query([
                            'type' => '1',
                            'param1' => $workshopsign->user_name,
                            'param2' => $workshopsign->title,
                            'param3' => 1,
                            'receptor' => $workshopsign->phone,
                            'template' => 'workshop',
                        ]),
                        CURLOPT_HTTPHEADER => array(
                            "apikey: ilvYYKKVEXlM+BAmel+hepqt8fliIow1g0Br06rP4ko",
                            "cache-control: no-cache",
                            "content-type: application/x-www-form-urlencoded",
                        ),
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                } catch (Exception $exception) {
                }
                return view('Api.payment-success');
                //return redirect("yourapp://payment-success?transaction_id=" . $payment->referenceId());
            } else {
                return view('Api.payment-failed');
                //return redirect("yourapp://payment-failed?message=" . urlencode("پرداخت ناموفق بود"));
            }
        } else {
            return view('Api.payment-failed');
            //return redirect("yourapp://payment-failed?message=" . urlencode("پرداخت لغو شد"));
        }
    }

    public function getarticle(Request $request)
    {
        $articles = Article::whereUser_id(Auth::user()->id);
        if ($articles) {
            return response()->json(
                ['isSuccess' => true,
                    'message' => 'مقادیر رکورد دریافت شد',
                    'errors' => null,
                    'status_code' => 200,
                    'result' => $articles
                ], 200);
        } else {
            return response()->json(
                ['isSuccess' => null,
                    'message' => 'مقداری یافت نشد.',
                    'errors' => true,
                    'status_code' => 500,
                ], 500);
        }
    }

    public function laws(){

        $laws          = Law::all();

        return response()->json(
            ['isSuccess' => true,
                'message' => 'مقادیر رکورد دریافت شد',
                'errors' => null,
                'status_code' => 200,
                'result' => $laws
            ], 200);
    }

    public function demands(){

        $types = ['contractDrafting','documentDrafting','judgement','lawsuit','legalAdvice' , 'tokil'];

        $result          = Invoice::whereIn('Product_type' , $types)->whereUser_id(Auth::id())->get();

        return response()->json(
            ['isSuccess' => true,
                'message' => 'مقادیر رکورد دریافت شد',
                'errors' => null,
                'status_code' => 200,
                'result' => $result
            ], 200);
    }

    public function upload_file(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:102400|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,mp4,mp3',
        ]);

        $file           = $request->file('file');
        $subject_id     = $request->input('subject_id');
        $originalName   = $file->getClientOriginalName();
        $extension      = $file->getClientOriginalExtension();
        $size           = $file->getSize();
        $project_id     = $request->input('record_id');
        $mime           = $file->getMimeType();

        $type = match (true) {
            Str::contains($mime, 'image')                            => 'images',
            Str::contains($mime, 'video')                            => 'videos',
            Str::contains($mime, 'audio')                            => 'audios',
            $mime === 'application/pdf'                                     => 'documents',
            Str::contains($mime, 'msword')                           => 'documents', // doc
            Str::contains($mime, 'officedocument.wordprocessingml')  => 'documents', // docx
            Str::contains($mime, 'ms-excel')                         => 'spreadsheets', // xls
            Str::contains($mime, 'officedocument.spreadsheetml')     => 'spreadsheets', // xlsx
            Str::contains($mime, 'ms-powerpoint')                    => 'presentations', // ppt
            Str::contains($mime, 'officedocument.presentationml')    => 'presentations', // pptx
            Str::contains($mime, 'zip') || $mime === 'application/zip'              => 'archives', // zip
            Str::contains($mime, 'rar') || $mime === 'application/x-rar-compressed' => 'archives', // rar
            default                                                  => 'others',
        };
        $fileName = (string) Str::uuid() . '.' . $extension;
        try {
        if ($request->input('record_id')){
            $path = $file->storeAs("uploads/".$request->input('record_id').'/'.$type, $fileName, 'public');

        }else {
            $path = $file->storeAs("uploads/" . $type, $fileName, 'public');
        }

        MediaFile::create([
            'subject_id'    => $subject_id,
            'name'          => $fileName,
            'original_name' => $originalName,
            'type'          => rtrim($type, 's'),
            'file_path'     => $path,
            'size'          => $size,
            'project_id'    => $project_id,
            'mime'          => $mime,
            'user_id'       => Auth::user()->id,
        ]);
            return response()->json([
                'isSuccess'   => true,
                'message'     => 'اطلاعات با موفقیت ثبت شد',
                'errors'      => null,
                'status_code' => 200,
                'result'      => ''
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'isSuccess'   => false,
                'message'     => 'خطا در آپلود فایل',
                'errors'      => null,
                'status_code' => 500,
            ], 200);
        }
    }

}

