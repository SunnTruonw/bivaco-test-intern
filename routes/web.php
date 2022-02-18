<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Artisan::call('storage:link');
Route::get('test', function () {
    // $a = bcrypt('1234567890');
    // echo $a;
    $data = App\Models\District::find(1)->communes()->get();
    $countView = new \App\Helper\CountView();
    $model = new \App\Models\Product();
    $countView->countView($model, 'view', 'product', 5);
});

Route::group(
    [
        'prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']
    ],
    function () {
        UniSharp\LaravelFilemanager\Lfm::routes();
    }
);
Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
    Route::group(['prefix' => 'address'], function () {
        Route::get('district', 'AddressController@getDistricts')->name('ajax.address.districts');
        Route::get('communes', 'AddressController@getCommunes')->name('ajax.address.communes');
    });
});
// 'middleware' => ['auth', 'cartToggle']
Route::group(['prefix' => 'cart'], function () {
    Route::get('list', 'ShoppingCartController@list')->name('cart.list');
    Route::get('add/{id}', 'ShoppingCartController@add')->name('cart.add');
    Route::get('buy/{id}', 'ShoppingCartController@buy')->name('cart.buy');
    Route::get('remove/{id}', 'ShoppingCartController@remove')->name('cart.remove');
    Route::get('update/{id}', 'ShoppingCartController@update')->name('cart.update');
    Route::get('clear', 'ShoppingCartController@clear')->name('cart.clear');
    Route::post('order', 'ShoppingCartController@postOrder')->name('cart.order.submit');
    Route::get('order/sucess/{id}', 'ShoppingCartController@getOrderSuccess')->name('cart.order.sucess');
    Route::get('order/error', 'ShoppingCartController@getOrderError')->name('cart.order.error');
});
// compare product
Route::group(['prefix' => 'compare'], function () {
    Route::get('/', 'CompareController@list')->name('compare.list');
    Route::get('add/{id}', 'CompareController@add')->name('compare.add');
    Route::get('add-redirect/{id}', 'CompareController@addAndRedirect')->name('compare.addAndRedirect');
    Route::get('remove/{id}', 'CompareController@remove')->name('compare.remove');
    Route::get('update/{id}', 'CompareController@update')->name('compare.update');
    Route::get('clear', 'CompareController@clear')->name('compare.clear');
});


Route::group(['prefix' => 'san-pham'], function () {
    Route::get('/', 'ProductController@index')->name('product.index');
    Route::get('{slug}', 'ProductController@detail')->name('product.detail');
});
Route::get('/danh-muc/{slug}', 'ProductController@productByCategory')->name('product.productByCategory');
Route::get('product-sale', 'ProductController@sale')->name('product.sale');

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', 'ProfileController@index')->name('profile.index');
    Route::get('/history', 'ProfileController@history')->name('profile.history');
    Route::get('/transaction-detail/{id}', "ProfileController@loadTransactionDetail")->name("profile.transaction.detail");
    Route::get('/list-rose', 'ProfileController@listRose')->name('profile.listRose');
    Route::get('/list-member', 'ProfileController@listMember')->name('profile.listMember');
    Route::get('/create-member', 'ProfileController@createMember')->name('profile.createMember');
    Route::post('/store-member', 'ProfileController@storeMember')->name('profile.storeMember');
    Route::post('/draw_point', 'ProfileController@drawPoint')->name('profile.drawPoint');

    Route::get('/edit-info', 'ProfileController@editInfo')->name('profile.editInfo');
    Route::post('/update-info/{id}', 'ProfileController@updateInfo')->name('profile.updateInfo')->middleware('profileOwnUser');

    //  Route::get('{id}-{slug}', 'ProductController@detail')->name('product.detail');
    //  Route::get('/category-product/{id}-{slug}', 'ProductController@productByCategory')->name('product.productByCategory');
});

Route::group(['prefix' => 'tin-tuc'], function () {
    Route::get('/', 'PostController@index')->name('post.index');
    Route::get('{slug}', 'PostController@detail')->name('post.detail');
});

Route::get('/danh-muc-tin-tuc/{slug}', 'PostController@postByCategory')->name('post.postByCategory');


// auth
Auth::routes();

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/change-language/{language}', 'LanguageController@index')->name('language.index');

// giới thiệu
Route::get('/gioi-thieu', 'HomeController@aboutUs')->name('about-us');
Route::get('/about-us', 'HomeController@aboutUs')->name('about-us.en');
Route::get('/설명하다', 'HomeController@aboutUs')->name('about-us.ko');

// báo giá
Route::get('/cam-nhan-cua-khach-hang', 'HomeController@camnhan')->name('camnhan');
Route::get('/quote', 'HomeController@bao_gia')->name('bao-gia.en');
Route::get('/인용문', 'HomeController@bao_gia')->name('bao-gia.ko');

// tuyển dụng
Route::get('/tuyen-dung', 'HomeController@tuyen_dung')->name('tuyen-dung');
Route::get('/recruitment', 'HomeController@tuyen_dung')->name('tuyen-dung.en');
Route::get('/신병-모집', 'HomeController@tuyen_dung')->name('tuyen-dung.ko');

// chi tiết tuyển dụng
Route::get('/tuyen-dung/{slug}', 'HomeController@tuyendungDetail')->name('tuyendung_link');
Route::get('/recruitment/{slug}', 'HomeController@tuyendungDetail')->name('tuyendung_link.en');
Route::get('/신병-모집/{slug}', 'HomeController@tuyendungDetail')->name('tuyendung_link.ko');



// thông tin liên hệ
Route::post('contact/store-ajax', 'ContactController@storeAjax')->name('contact.storeAjax');
Route::post('contact/store-ajax1', 'ContactController@storeAjax1')->name('contact.storeAjax1');
Route::post('contact/store-ajax2', 'ContactController@storeAjax2')->name('contact.storeAjax2');
Route::get('/lien-he', 'ContactController@index')->name('contact.index');
Route::get('/contact', 'ContactController@index')->name('contact.index.en');
Route::get('/접촉', 'ContactController@index')->name('contact.index.ko');

// tìm kiếm đại lý

Route::get('/tim-kiem-dai-ly', 'HomeController@search_daily')->name('search-daily');
Route::get('/search-agent', 'HomeController@search_daily')->name('search-daily.en');
Route::get('/에이전트-검색', 'HomeController@search_daily')->name('search-daily.ko');

Route::group(['prefix' => 'comment'], function () {
    Route::post('/{type}/{id}', 'CommentController@store')->name('comment.store');
});

Route::group(['prefix' => 'search'], function () {
    Route::get('/', 'HomeController@search')->name('home.search');
});

// Đánh giá sản phẩm

Route::post('product/rating/{id}', 'ProductController@rating')->name('product.rating');