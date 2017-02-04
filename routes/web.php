<?php

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

/*
 * Маршруты без префиксов - главная
 */
Route::group([], function () {     //убрал из-за того,что этот посредник прописан в RouteServiceProvider,иначе не будет отправляться почта
    //Маршруты для пользовательской части
    Route::match(['get', 'post'], '/', ['uses' => 'IndexController@execute', 'as' => 'home']);  //главная
    Route::get('/page/{alias}', ['uses' => 'PageController@execute', 'as' => 'page']);  //подробная
    //Маршрту для аутентификации
    Route::auth();
});

/*
 * Маршруты с префиксом - админка,
 * например,admin/services и т.д.
 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    //admin
    Route::get('/', function () {
        if(view()->exists('admin.index')) {
            $data = ['title' => 'Панель администратора'];

            return view('admin.index',$data);
        }
    });

    //admin/pages
    Route::group(['prefix' => 'pages'], function () {
        //admin/pages  маршрут раздела главной страницы по управлению страницами
        Route::get('/', ['uses' => 'PagesController@execute', 'as' => 'pages']);

        //admin/pages/add добавление контента
        Route::match(['get', 'post'], '/add', ['uses' => 'PagesAddController@execute', 'as' => 'pagesAdd']);

        //admin/pages/edit/2 получение контента из бд,редактирование,удаление
        Route::match(['get', 'post', 'delete'], '/edit{page}', ['uses' => 'PagesEditController@execute', 'as' => 'pagesEdit']);
    });

    //admin/portfolios
    Route::group(['prefix' => 'portfolios'], function () {

        Route::get('/', ['uses' => 'PortfolioController@execute', 'as' => 'portfolio']);

        Route::match(['get', 'post'], '/add', ['uses' => 'PortfolioAddController@execute', 'as' => 'portfolioAdd']);

        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', ['uses' => 'PortfolioEditController@execute', 'as' => 'portfolioEdit']);

    });

    //admin/services
    Route::group(['prefix' => 'services'], function () {

        Route::get('/', ['uses' => 'ServiceController@execute', 'as' => 'services']);

        Route::match(['get', 'post'], '/add', ['uses' => 'ServiceAddController@execute', 'as' => 'serviceAdd']);

        Route::match(['get', 'post', 'delete'], '/edit/{service}', ['uses' => 'ServiceEditController@execute', 'as' => 'serviceEdit']);

    });


});



Route::auth();
Route::get('/home', 'HomeController@index');
