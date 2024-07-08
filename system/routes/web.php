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

// use App\MenuTranslation;
// use App\PostTranslation;

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::group([
    'prefix' => 'cp',
    'namespace' => 'Cp',
    'middleware' => 'auth',
    'as' => 'cp.'
], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::resource('contacts', 'ContactController')->only([
        'index', 'show', 'destroy'
    ]);
    Route::resource('social-media', 'SocialMediaController');
    Route::resource('sliders', 'SliderController');
    Route::post('/move-slider', 'MoveSliderController@update')->name('move-slider');
    Route::group(['prefix' => 'settings'], function () {
        Route::get('', 'SettingController@edit')->name('settings.edit');
        Route::put('', 'SettingController@update')->name('settings.update');
    });
    Route::post('/upload', 'UploadController@store')->name('upload');
    Route::get('posts/to-slider/{id}', 'PostController@toSlider')->name('posts.to-slider');
    Route::resource('main-menus', 'MainMenuController');
    Route::resource('main-menus.submenus', 'MainMenuSubmenuController');
    Route::resource('main-menus.posts', 'MainMenuPostController');
    Route::resource('secondary-menus', 'SecondaryMenuController');
    Route::resource('secondary-menus.submenus', 'SecondaryMenuSubmenuController');
    Route::resource('secondary-menus.posts', 'SecondaryMenuPostController');
    Route::resource('home-menus', 'HomeMenuController');
    Route::resource('home-menus.submenus', 'HomeMenuSubmenuController');
    Route::resource('home-menus.posts', 'HomeMenuPostController');
    Route::resource('external-apps', 'ExternalAppController');
    Route::get('/move-menu', 'MoveController@menu')->name('move-menu');
    // Route::resource('menus', 'MenuController');
    // Route::resource('menus.submenus', 'MenuSubmenuController');
    // Route::resource('menus.posts', 'MenuPostController');
    Route::delete('/delete-file', 'FileController@destroy')->name('delete-file');
    Route::post('/move-file', 'FileController@update')->name('move-file');
    Route::post('/change-downloadable-file', 'FileController@downloadable')->name('change-downloadable-file');
    // Route::resource('areas', 'AreaController');
    // Route::resource('locations', 'LocationController');
    // Route::resource('exchanges', 'ExchangeController');
    // Route::resource('rates', 'RateController');
    // Route::group(['prefix' => 'interest-rates'], function() {
    //     Route::get('', 'InterestRateController@edit')->name('interest-rates.edit');
    //     Route::put('', 'InterestRateController@update')->name('interest-rates.update');
    //     Route::delete('', 'InterestRateController@destroy')->name('interest-rates.destroy');
    //     Route::post('', 'InterestRateController@store')->name('interest-rates.store');
    // });
    Route::get('passwords', 'PasswordController@edit')->name('passwords.edit');
    Route::put('passwords/update', 'PasswordController@update')->name('passwords.update');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('privilege-codes', 'PrivilegeCodeController');
    Route::resource('permissions', 'PermissionController');
    Route::group(['prefix' => 'retirement-settings'], function () {
        Route::get('', 'RetirementSettingController@edit')->name('retirement-settings.edit');
        Route::put('', 'RetirementSettingController@update')->name('retirement-settings.update');
    });
    Route::get('retirement-calculations/export-csv', 'RetirementCalculationController@exportCsv')->name('retirement-calculations.export');
    Route::resource('retirement-calculations', 'RetirementCalculationController');
    Route::resource('retirement-inbox', 'RetirementInboxController');
});

// Route::get('/sitemap', function () {
//     $site = App::make('sitemap');

//     $site->add(URL::to('/'), date("Y-m-d h:i:s"), 1, 'daily');

//     $post = PostTranslation::all();
//     $menu = MenuTranslation::all();

//     foreach ($menu as $key => $mn) {
//         $site->add(URL::to($mn->slug), 1, 'daily');
//     }

//     foreach ($post as $key => $pt) {
//         $site->add(URL::to($pt->slug), 1, 'daily');
//     }

//     $site->store('xml', 'sitemap2');
// });

Route::get('/', function () {
    // dd(Location::get(request()->ip()));
    if (session()->has('locale')) {
        return redirect(session('locale'));
    }
    return redirect(app()->getLocale());
});

foreach (config('app.locales') as $locale) {
    Route::group([
        'prefix' => $locale,
        'middleware' => 'locale'
    ], function () use ($locale) {

        Route::get('/', 'HomeController@index')->name('home');
        Route::get(trans('route.search', [], $locale), 'SearchController@index');
        Route::get('{any}', 'PostController@show')->where('any', '.*');
        // Route::post('/contact', 'ContactController@store')->name('contact.store');
        // Route::post('search-location', 'LocationController@search');
        // Route::post('/inbox', 'InboxController@store')->name('inbox.store');
        // Route::post('/calculate', 'CalculateController@store')->name('calculate.store');
    });
}

// Route::model('social_sedium', 'App\SocialMedia');

Route::get('/ajax-datatable', 'AjaxController@datatable')->name('ajax-datatable');
