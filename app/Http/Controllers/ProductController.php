<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\CategoryPost;

use App\Models\Setting;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\ProductStar;
use App\Models\ProductTranslation;
use App\Models\CategoryProductTranslation;

class ProductController extends Controller
{
    //

    private $product;
    private $productStar;
    private $header;
    private $unit = 'đ';
    private $categoryProduct;
    private $categoryPost;
    private $productTranslation;
    private $categoryProductTranslation;
    private $attribute;
    private $productAttribute;
    private $limitProduct = 20;
    private $limitProductRelate = 10;
    private $idCategoryProductRoot = 2;
    private $breadcrumbFirst = [
        // 'name'=>'Sản phẩm',
        //  'slug'=>'san-pham',
    ];
    public $priceSearch;
    public function __construct(
        Product $product,
        ProductStar $productStar,
        CategoryProduct $categoryProduct,
        CategoryPost $categoryPost,
        Setting $setting,
        ProductTranslation $productTranslation,
        CategoryProductTranslation $categoryProductTranslation,
        Attribute $attribute,
        ProductAttribute $productAttribute
    ) {
        $this->product = $product;
        $this->productStar = $productStar;
        $this->categoryProduct = $categoryProduct;
        $this->categoryPost = $categoryPost;
        $this->setting = $setting;
        $this->productTranslation = $productTranslation;
        $this->categoryProductTranslation = $categoryProductTranslation;
        $this->attribute = $attribute;
        $this->productAttribute = $productAttribute;
        $this->priceSearch = config('web_default.priceSearch');
    }
    // danh sách toàn bộ product
    public function index(Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryProduct->where([
            ['id', $this->idCategoryProductRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {

                if ($request->ajax()) {
                    return $this->filter($category, $request);
                }


                $categoryId = $category->id;
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
                $countProduct = $data =  $this->product->where('active','1')->whereIn('category_id', $listIdChildren)->count();
                $data =  $this->product->where('active','1')->whereIn('category_id', $listIdChildren)->paginate($this->limitProduct);
                $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);
                $listIdActive = $listIdParent;
                foreach ($listIdParent as $parent) {
                    $breadcrumbs[] = $this->categoryProduct->select('id')->find($parent)->toArray();
                }

                return view('frontend.pages.product-by-category', [
                    'data' => $data,
                    'countProduct' => $countProduct,
                    'unit' => $this->unit,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'category_products',
                    'category' => $category,
                    'categoryProductActive' => $listIdActive,
                    'seo' => [
                        'title' =>  $category->title_seo ?? "",
                        'keywords' =>  $category->keywords_seo ?? "",
                        'description' =>  $category->description_seo ?? "",
                        'image' => $category->avatar_path ?? "",
                        'abstract' =>  $category->description_seo ?? "",
                    ]
                ]);
            }
        }
    }
    public function detail($slug, Request $request)
    {
        //   $data= $this->categoryProduct->setAppends(['breadcrumb'])->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);

        $breadcrumbs = [];
        $data = [];
        $translation = $this->productTranslation->where([
            ["slug", $slug],
        ])->first();
        if ($translation) {
            $data = $translation->product;
            if (checkRouteLanguage($slug, $data)) {
                return checkRouteLanguage($slug, $data);
            }
            $categoryId = $data->category_id;
            $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

            $dataRelate =  $this->product->where('active','1')->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $data->id],
            ])->limit($this->limitProductRelate)->get();
            $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);

            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryProduct->select('id')->find($parent)->toArray();
            }

            // Lấy danh sản các tất cả sản phẩm cùng danh mục sản phẩm được chọn
            $categoryAll = $this->product->where('active','1')->where('category_id', $categoryId)->get();

            $diachi = $this->setting->find(19);
			$giaohang = $this->setting->find(130);
            $chinhSach = $this->setting->find(171);
            $huongDan = $this->setting->find(172);
            $vanchuyen = $this->setting->find(274);

            return view('frontend.pages.product-detail', [
                'data' => $data,
                'categoryAll' => $categoryAll,
                'unit' => $this->unit,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_products',
                'title' => $data ? $data->name : "",
                'category' => $data->category ?? null,
                'giaohang' => $giaohang,
                'chinhSach' => $chinhSach,
                'huongDan' => $huongDan,
                'vanchuyen' => $vanchuyen,
				'diachi' => $diachi,
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

    // danh sách product theo category
    public function productByCategory($slug, Request $request)
    {
        //
        $breadcrumbs = [];
		
        // get category
        $translation = $this->categoryProductTranslation->where([
            ['slug', $slug],
        ])->first();
        if ($translation) {
            if ($translation->count()) {
                // $request->ajax()
                $category = $translation->category;
                if ($request->ajax()) {
                    return $this->filter($category, $request);
                }

                $category = $translation->category;
                if (checkRouteLanguage($slug, $category)) {
                    return checkRouteLanguage($slug, $category);
                }
                $categoryId = $category->id;
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
                $countProduct = $data =  $this->product->where('active','1')->whereIn('category_id', $listIdChildren)->count();
                $data =  $this->product->where('active','1')->whereIn('category_id', $listIdChildren)->orderBy('order')->orderByDesc('created_at')->paginate($this->limitProduct);
                $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);
                $listIdActive = $listIdParent;
                foreach ($listIdParent as $parent) {
                    $breadcrumbs[] = $this->categoryProduct->select('id')->find($parent)->toArray();
                }

                return view('frontend.pages.product-by-category', [
                    'data' => $data,
                    'countProduct' => $countProduct,
                    'unit' => $this->unit,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'category_products',
                    'category' => $category,
                    'categoryProductActive' => $listIdActive,
                    'seo' => [
                        'title' =>  $category->title_seo ?? "",
                        'keywords' =>  $category->keywords_seo ?? "",
                        'description' =>  $category->description_seo ?? "",
                        'image' => $category->avatar_path ?? "",
                        'abstract' =>  $category->description_seo ?? "",
                    ]
                ]);
            }
        }
    }

    // danh sách toàn bộ product
    public function sale(Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryProduct->where([
            ['id', $this->idCategoryProductRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {

                if ($request->ajax()) {
                    return $this->filter($category, $request);
                }

                $categoryId = $category->id;
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
                $countProduct = $data =  $this->product->whereIn('category_id', $listIdChildren)->count();
                $data =  $this->product->where('sale', '>', 0)->whereIn('category_id', $listIdChildren)->orderby('sale')->latest()->paginate($this->limitProduct);
                $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);
                $listIdActive = $listIdParent;
                foreach ($listIdParent as $parent) {
                    $breadcrumbs[] = $this->categoryProduct->select('id')->find($parent)->toArray();
                }

                return view('frontend.pages.product-by-category', [
                    'data' => $data,
                    'countProduct' => $countProduct,
                    'unit' => $this->unit,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'category_products',
                    'category' => $category,
                    'categoryProductActive' => $listIdActive,
                    'seo' => [
                        'title' =>  $category->title_seo ?? "",
                        'keywords' =>  $category->keywords_seo ?? "",
                        'description' =>  $category->description_seo ?? "",
                        'image' => $category->avatar_path ?? "",
                        'abstract' =>  $category->description_seo ?? "",
                    ]
                ]);
            }
        }
    }
    public function filter($category, $request)
    {
        $categoryId = $category->id;
        $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
        $data =  $this->product->where('active','1');
        if ($request->has('supplier_id') && $request->input('supplier_id')) {
            $data = $data->whereIn('supplier_id', $request->input('supplier_id'));
            // dd($data->get());
        }

        if ($request->has('price') && $request->input('price')) {
            $key = $request->input('price');
            //  dd($this->priceSearch[$key]);
            $start = $this->priceSearch[$key]['start'];
            $end = $this->priceSearch[$key]['end'];
            //   dd($start);

            if ($start == 0 && $end) {
                $data = $data->where('price', '<=', $end);
            } elseif ($start && $end) {

                $data = $data->whereBetween('price', [$start, $end]);
            } elseif ($start && $end == null) {
                // dd($end);
                $data = $data->where('price', '>=', $start);
            }
            //  dd($end);
            // dd($data->get());
        }
        // dd($request->input('attribute_id'));
        if ($request->has('attribute_id') && $request->input('attribute_id')) {
            $productAttr =  $this->productAttribute;
            foreach ($request->input('attribute_id') as $key => $value) {
                // dd($request->input('attribute_id')[$key]);
                if ($value) {

                    $value = collect($value)->filter(function ($value, $key) {
                        return $value > 0;
                    });
                    if ($value->count()) {
                        $listIdPro = $productAttr->whereIn('attribute_id', $request->input('attribute_id')[$key])->pluck('product_id');
                        // dd($productAttr->get());
                        // dd($listIdPro);
                        $data = $data->whereIn('id', $listIdPro);
                    }
                }
            }
            // dd($listIdPro);
            // dd($data->get());
        }
        // dd($data->whereIn('category_id', $listIdChildren)->get());


        if ($request->has('orderby') && $request->input('orderby')) {
            if ($request->input('orderby') == 1) {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderby('price');
            } elseif ($request->input('orderby') == 2) {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderByDesc('price');
            } elseif ($request->input('orderby') == 3) {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderby('sale');
            } elseif ($request->input('orderby') == 4) {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderByDesc('price');
            } else {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderByDesc('price');
            }
        } else {
            $data =  $data->whereIn('category_id', $listIdChildren)->orderBy('order');
        }

        $countProduct = $data->count();

        $data = $data->latest()->paginate($this->limitProduct);

        // dd($data);
        return response()->json([
            "code" => 200,
            "html" => view('frontend.components.load-product-search', [
                'data' => $data,
                'unit' => $this->unit,
                'countProduct' => $countProduct
            ])->render(),
            "message" => "success"
        ], 200);
    }

    public function rating($id, Request $request){
        if ($id) {
            try {
                DB::beginTransaction();
                $title='Đánh giá sản phẩm';
                $dataRatingCreate = [
                    'name' => $request->input('name')??"",
                    'phone' => $request->input('phone')??"",
                    'email' => $request->input('email')??"",
                    'title' => $request->input('title')??"",
                    'star' => $request->input('rating')??"",
                    'product_id' => $id,
                    'active' => 0,
                    'content'=> $request->input('content')??"",
                ];

                $ratingUdate = $this->productStar->create($dataRatingCreate);

                DB::commit();
                return redirect()->back()->with('msg', 'Gửi đánh giá thành công');
                //return response()->json([
                //"code" => 200,
                //"html" => 'Gửi đánh giá thành công',
                //"message" => "success"
                //], 200);

            } catch (\Exception $exception) {
                return redirect()->back()->with('msg', 'Gửi đánh giá không thành công');
                 //throw $th;
                // DB::rollBack();
                // Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                // return response()->json([
                //    "code" => 500,
                //    'html'=>'Gửi đánh giá không thành công',
                //    "message" => "fail"
                //], 500);

            }
        }
        
    }
}
