<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Setting;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class ContactController extends Controller
{
    //
    private $setting;
    private $contact;
    public function __construct(Setting $setting, Contact $contact)
    {
        $this->middleware('auth');
        $this->setting=$setting;
        $this->contact=$contact;
    }
    public function index(){
        $dataAddress=$this->setting->find(28);
        $map=$this->setting->find(33);
        $breadcrumbs= [
            [

                'name'=>"Liên hệ",
                'slug'=>makeLink('contact'),
            ],
        ];
        return view("frontend.pages.contact",[

            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'contact',
            'title' =>  "Thông tin liên hệ",

            'seo' => [
                'title' => "Thông tin liên hệ",
                'keywords' =>  "Thông tin liên hệ",
                'description' =>   "Thông tin liên hệ",
                'image' =>  "",
                'abstract' =>  "Thông tin liên hệ",
            ],

            "dataAddress"=>$dataAddress,
            "map"=>$map,
        ]);
    }
    public function storeAjax(Request $request){
     //   dd($request->name);
    // dd($request->ajax());
         try {
             DB::beginTransaction();

            $dataContactCreate = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone')??"",
                'email' => $request->input('email')??"",
                'active' => $request->input('active')??1,
                'status' => 1,
                'city_id' => $request->input('city_id')??null,
                'district_id' => $request->input('district_id')??null,
                'commune_id' => $request->input('commune_id')??null,
                'address_detail' => $request->input('address_detail')??null,
                'content' => $request->input('content')??null,
                'admin_id' => 0,
                'user_id' => Auth::check() ? Auth::user()->id : 0,
            ];
            //  dd($dataContactCreate);
            $contact = $this->contact->create($dataContactCreate);
          //  dd($contact);
            DB::commit();
            return response()->json([
            "code" => 200,
            "html" => 'Gửi thông tin thành công',
            "message" => "success"
            ], 200);
         } catch (\Exception $exception) {
             //throw $th;
             DB::rollBack();
             Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
             return response()->json([
                "code" => 500,
                'html'=>'Gửi thông tin không thành công',
                "message" => "fail"
            ], 500);
         }
    }
}
