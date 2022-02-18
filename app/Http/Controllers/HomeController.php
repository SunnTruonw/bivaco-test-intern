<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Post;
use App\Models\Slider;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Models\PostTranslation;
use App\Models\ProductTranslation;
use App\Models\CategoryPostTranslation;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $product;
    private $setting;
    private $slider;
    private $post;
    private $categoryPost;
    private $categoryProduct;
    private $postTranslation;
    private $categoryPostTranslation;
    private $productTranslation;
    private $productSearchLimit  = 12;
    private $postSearchLimit     = 6;

    private $productHotLimit     = 10;
    private $productNgocLimit     = 10;
    private $productSaleLimit     = 10;
    private $productNewLimit     = 10;
    private $productViewLimit    = 10;
    private $productPayLimit     = 10;
    private $sliderLimit         = 10;
    private $postsHotLimit       = 10;
    private $unit                = 'đ';
    public function __construct(
        Product $product,
        Setting $setting,
        Slider $slider,
        Post $post,
        CategoryPost $categoryPost,
        CategoryProduct $categoryProduct,
        PostTranslation $postTranslation,
        CategoryPostTranslation $categoryPostTranslation,
        ProductTranslation $productTranslation
    ) {
        /*$this->middleware('auth');*/
        $this->product = $product;
        $this->setting = $setting;
        $this->slider = $slider;
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
        $this->postTranslation = $postTranslation;
        $this->categoryPostTranslation = $categoryPostTranslation;
        $this->productTranslation = $productTranslation;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }
    public function index(Request $request)
    {
        // dd(session()->has('cart'));
        //  $cart=[1=>'test 1'];
        //  $request->session()->put('cart',  $cart);
        //   dd($request->session()->get('cart'));

        //  dd($this->categoryPost->setAppends(['slug_full'])->find(15)->slug_full);

        //    dd(menuRecusive($this->categoryPost,13));
        //  dd($this->categoryPost->find(18)->breadcrumb);
        // $dataSettings = $this->setting->get();
        $categoryProductHome = $this->categoryProduct->find(2);
        $categoryProductHome2 = $this->categoryProduct->whereIn('id', [30, 39])->where('active', 1)->orderby('order')->get();
        // sản phẩm nổi bật
        //   $productsHot = $this->product->where([
        //       ['active', 1],
        //       ['hot', 1],
        //   ])->latest()->limit($this->productHotLimit)->get();
        // sản phẩm sale
        $productsSale = $this->product->where([
            ['active', 1],
            ['sale', '>', 0],
        ])->latest()->limit($this->productSaleLimit)->get();
        // sản phẩm mới
        $productsNew = $this->product->where([
            ['active', 1],
        ])->latest()->limit($this->productNewLimit)->get();
        $productsBest = $this->product->where([
            ['active', 1],
            ['hot', 1],
        ])->latest()->limit($this->productHotLimit)->get();

        //  $productsNgoc = $this->product->where([
        //      ['active', 1],
        //      ['sp_ngoc', 1],
        //  ])->latest()->limit($this->productNgocLimit)->get();
        $camket = $this->setting->find(277);
        $camnhan = $this->setting->find(278);
        $thongtin_danhmucsp = $this->setting->find(239);
        $dichvu = $this->setting->find(152);
        $banner = $this->setting->find(173);
        $titleSMMoi = $this->setting->find(174);
        $titleSPBanchay = $this->setting->find(175);
        $titlePostNew = $this->setting->find(176);
        // // sản phẩm xem nhiều
        // $productsView = $this->product->where([
        //     ['active', 1],
        // ])->orderByDesc('view')->limit($this->productViewLimit)->get();
        // // sản phẩm mua nhiều
        // $productsPay = $this->product->where([
        //     ['active', 1],
        // ])->orderByDesc('pay')->limit($this->productPayLimit)->get();
        // // lấy slider
        $sliders = $this->slider->where([
            ['active', 1],
        ])->orderBy('order')->orderByDesc('created_at')->limit($this->sliderLimit)->get();
        // slidersMob
        $slidersM = $this->setting->where([
            ['active', 1],
            ['parent_id', 224],
        ])->orderBy('order')->orderByDesc('created_at')->limit($this->sliderLimit)->get();
        $bosuutapM = $this->setting->find(228);
        $khuyenMaiM = $this->setting->find(229);
        $dichvuM = $this->setting->find(222);
        $popM = $this->setting->find(230);
        // // bài viết nổi bật
        // $postsHot = $this->post->where([
        //     ['active', 1],
        //     ['hot', 1],
        // ])->orderby('order')->orderByDesc('created_at')->limit($this->postsHotLimit)->get();

        // $bannerHome = $this->setting->find(18);

        $cate = $this->categoryPost->getALlCategoryChildrenAndSelf(54);
        // // dd($cate);
        $postNew = $this->post->whereIn('category_id', $cate)->where('active', '1')->where('hot', '1')->orderByDesc('created_at')->limit(6)->get();
        $listCateHot = $this->categoryProduct->where('active', 1)->where('parent_id', 2)->orderBy('order')->orderByDesc('created_at')->get();
        $collection = $this->setting->find(167);
        $modalHome = $this->setting->where('active', 1)->find(177);
        // $video = $this->post->where('category_id', '33')->orderByDesc('created_at')->get();
        // $video_one = $this->post->where('category_id', '33')->orderByDesc('created_at')->first();
        // // dd($postNew);
        // $supportHome = $this->setting->find(90);
        // $banner2Home = $this->setting->find(93);
        // $menuHome=$this->categoryProduct->where([
        //     'active'=>1,
        //     'parent_id'=>2
        // ])->orderby('order')->get();

        return view('frontend.pages.home', [
            'categoryProductHome' => $categoryProductHome,
            'categoryProductHome2' => $categoryProductHome2,
            // 'productHot' => $productsHot,
            'productsSale' => $productsSale,
            'thongtin_danhmucsp' => $thongtin_danhmucsp,
            'modalHome' => $modalHome,
            'productsBest' => $productsBest,
            // 'productsNgoc' => $productsNgoc,
            'productNew' => $productsNew,
            'listCateHot' => $listCateHot,
            'camnhan' => $camnhan,
            'camket' => $camket,
            'collection' => $collection,
            'dichvu' => $dichvu,
            // 'productView' => $productsView,
            // 'productPay' => $productsPay,
            // 'postsHot'  => $postsHot,
            // // 'dataSettings' => $dataSettings,
            // 'video' => $video,
            // 'video_one' => $video_one,
            'postNew' => $postNew,
            "slider" => $sliders,
            "unit" => $this->unit,
            "banner" => $banner,
            "titleSMMoi" => $titleSMMoi,
            "titleSPBanchay" => $titleSPBanchay,
            "titlePostNew" => $titlePostNew,
            "slidersM" => $slidersM,
            "bosuutapM" => $bosuutapM,
            "khuyenMaiM" => $khuyenMaiM,
            "dichvuM" => $dichvuM,
            "popM" => $popM,
        ]);
    }

    public function aboutUs(Request $request)
    {
        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }
        $data = $this->categoryPost->find(14);
        $breadcrumbs = [[
            'id' => $data->id,
            'name' => $data->name,
            'slug' => makeLinkToLanguage('about-us', null, null, \App::getLocale()),
        ]];

        //Về chúng tôi
        $about_us = $this->categoryPost->where('id', '32')->orderByDesc('created_at')->first();

        $tamnhin = $this->categoryPost->where('parent_id', '30')->orderBy('created_at', 'ASC')->limit(4)->get();

        $bgtamnhin = $this->categoryPost->where('id', '30')->orderBy('created_at', 'ASC')->first();

        $history = $this->categoryPost->where('id', '31')->orderBy('created_at', 'ASC')->first();

        $historyList = $this->post->where('category_id', '31')->orderBy('created_at', 'ASC')->limit(20)->get();

        $partner = $this->setting->where('parent_id', '70')->orderBy('created_at', 'ASC')->limit(10)->get();

        return view("frontend.pages.about-us", [
            "data" => $data,
            'breadcrumbs' => $breadcrumbs,
            'about_us' => $about_us,
            'bgtamnhin' => $bgtamnhin,
            'history' => $history,
            'tamnhin' => $tamnhin,
            'historyList' => $historyList,
            'partner' => $partner,
            'typeBreadcrumb' => 'about-us',
            'title' => $data ? $data->name : "",
            'category' => $data->category ?? null,
            'seo' => [
                'title' =>  $data->title_seo ?? "",
                'keywords' =>  $data->keywords_seo ?? "",
                'description' =>  $data->description_seo ?? "",
                'image' => $data->avatar_path ?? "",
                'abstract' =>  $data->description_seo ?? "",
            ]
        ]);
    }

    public function tuyen_dung(Request $request)
    {
        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }
        $data = $this->categoryPost->find(39);

        $breadcrumbs = [[
            'id' => $data->id,
            'name' => $data->name,
            'slug' => makeLinkToLanguage('tuyen-dung', null, null, \App::getLocale()),
        ]];

        $categoryAll =  $this->post->where('category_id', $data->id)->paginate(9);

        $post_hot =  $this->post->where('category_id', $data->id)->where('hot', 1)->limit(4)->get();

        return view("frontend.pages.tuyendung", [
            "data" => $data,
            "categoryAll" => $categoryAll,
            "post_hot" => $post_hot,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'tuyen-dung',
            'title' => $data ? $data->name : "",
            'category' => $data->category ?? null,
            'seo' => [
                'title' =>  $data->title_seo ?? "",
                'keywords' =>  $data->keywords_seo ?? "",
                'description' =>  $data->description_seo ?? "",
                'image' => $data->avatar_path ?? "",
                'abstract' =>  $data->description_seo ?? "",
            ]
        ]);
    }

    public function tuyendungDetail($slug)
    {
        $resultCheckLang = checkRouteLanguage2($slug);
        if ($resultCheckLang) {
            return $resultCheckLang;
        }

        $breadcrumbs = [];
        $data = [];

        $translation = $this->postTranslation->where([
            ["slug", $slug],
        ])->first();

        if ($translation) {
            $data = $translation->post;
            if (checkRouteLanguage($slug, $data)) {
                return checkRouteLanguage($slug, $data);
            }

            $categoryId = $data->category_id;
            $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);
            $dataRelate =  $this->post->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $data->id],
            ])->limit(5)->get();
            $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($parent)->toArray();
            }
            //Tin noi bat
            $post_hot =  $this->post->where('hot', 1)->orderByDesc('created_at')->limit(4)->get();

            return view('frontend.pages.tuyendung-detail', [
                'data' => $data,
                'post_hot' => $post_hot,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'tuyen-dung',
                'title' => $data ? $data->name : "",
                'category' => $data->category ?? null,
                'seo' => [
                    'title' =>  $data->title_seo ?? "",
                    'keywords' =>  $data->keywords_seo ?? "",
                    'description' =>  $data->description_seo ?? "",
                    'image' => $data->avatar_path ?? "",
                    'abstract' =>  $data->description_seo ?? "",
                ]
            ]);
        }
    }

    public function camnhan(Request $request)
    {
        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }
        $camnhan = $this->setting->find(93);
        $breadcrumbs = [[
            'name' => 'Cảm nhận của khách hàng',
            'slug' => makeLinkToLanguage('camnhan', null, null, \App::getLocale()),
        ]];

        $listCategoryHome = $this->categoryProduct->where('parent_id', '76')->where('active', 1)->orderBy('created_at', 'ASC')->limit(4)->get();

        return view("frontend.pages.camnhan", [
            "data" => $camnhan,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'camnhan',
            'seo' => [
                'title' =>  "Cảm nhận của khách hàng",
                'keywords' =>   "Cảm nhận của khách hàng",
                'description' =>    "Cảm nhận của khách hàng",
                'image' =>   "Cảm nhận của khách hàng",
                'abstract' =>   "Cảm nhận của khách hàng",
            ]
        ]);
    }

    public function storeAjax(Request $request)
    {
        //   dd($request->name);
        // dd($request->ajax());
        try {
            DB::beginTransaction();

            $dataContactCreate = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone') ?? "",
                'email' => $request->input('email') ?? "",
                'sex' => $request->input('sex') ?? 1,
                'from' => $request->input('from') ?? "",
                'to' => $request->input('to') ?? "",
                'service' => $request->input('service') ?? "",
                'content' => $request->input('content') ?? null,
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
                'html' => 'Gửi thông tin không thành công',
                "message" => "fail"
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $dataProduct = $this->product;
        $dataPost = $this->post;
        $where = [];
        $req = [];
        if ($request->has('category_id')) {
            $categoryId = $request->category_id;
            $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
            $dataProduct =  $this->product->whereIn('category_id', $listIdChildren);
        }
        //  dd($dataProduct->get());
        if ($request->input('keyword')) {

            $dataProduct = $dataProduct->where(function ($query) {
                $idProTran = $this->productTranslation->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->pluck('product_id');
                // dd($idProTran);
                $query->whereIn('id', $idProTran)->orWhere([
                    ['masp', 'like', '%' . request()->input('keyword') . '%']
                ]);
            });
        }
        // if ($where) {
        //     $dataProduct = $dataProduct->where($where)->orderBy("created_at", "DESC");
        //     $dataPost = $dataPost->where($where)->orderBy("created_at", "DESC");
        // }
        $dataProduct = $dataProduct->orderBy("order", "ASC")->orderBy("created_at", "DESC")->paginate($this->productSearchLimit);
        //   $dataPost = $dataPost->paginate($this->postSearchLimit);
        $breadcrumbs = [[
            'id' => null,
            'name' => 'Tìm kiếm',
            //'slug' => makeLink('search', null, null, $req),
            'slug' => "",
        ]];
        // dd($dataProduct);
        return view("frontend.pages.search", [
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'search',
            'dataProduct' => $dataProduct,
            // 'dataPost' => $dataPost,
            'unit' => $this->unit,
            'seo' => [
                'title' =>  "Kết quả tìm kiếm",
                'keywords' =>  "Kết quả tìm kiếm",
                'description' =>  "Kết quả tìm kiếm",
                'image' =>  "Kết quả tìm kiếm",
                'abstract' =>   "Kết quả tìm kiếm",
            ]
        ]);
    }

    public function search_daily(Request $request)
    {

        $dataAddress = $this->setting->find(28);
        $map = $this->setting->find(33);
        $breadcrumbs = [
            [

                'name' => "Liên hệ",
                'slug' => makeLink('contact'),
            ],
        ];

        // Thông tin mục hệ thống
        $system = $this->setting->where('id', '57')->where('active', 1)->orderByDesc('created_at')->first();

        // Thông tin item mục hệ thống
        $systemChilds = $this->setting->where('parent_id', '57')->where('active', 1)->orderByDesc('created_at')->limit(2)->get();

        $data = $request->all();
        $key = $request->input('keyword');
        if ($key) {
            $listAddress = $this->setting->where('parent_id', '28')->where('name', 'LIKE', '%' . $key . '%')->get();
        }


        return view("frontend.pages.contact", [

            'breadcrumbs' => $breadcrumbs,
            'systemChilds' => $systemChilds,
            'system' => $system,
            'listAddress' => $listAddress,
            'typeBreadcrumb' => 'contact',
            'title' =>  "Thông tin liên hệ",

            'seo' => [
                'title' => "Thông tin liên hệ",
                'keywords' =>  "Thông tin liên hệ",
                'description' =>   "Thông tin liên hệ",
                'image' =>  "",
                'abstract' =>  "Thông tin liên hệ",
            ],

            "dataAddress" => $dataAddress,
            "map" => $map,
        ]);
    }
}
