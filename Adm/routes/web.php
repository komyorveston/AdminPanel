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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

	/*Admin part*/
	Route::group(['middleware' => ['status', 'auth']], function(){
			$groupData = [
				'namespace' => 'Blog\Admin',
				'prefix' => 'admin',
			];

			/**Main Controller*/
			Route::group($groupData, function(){
			Route::resource('index', 'MainController')
				->names('blog.admin.index');

			/* Order Controller*/
			Route::resource('orders', 'OrderController')
				->names('blog.admin.orders');
			Route::get('/orders/change/{id}', 'OrderController@change')
				->name('blog.admin.orders.change');
			Route::post('/orders/save/{id}', 'OrderController@save')
				->name('blog.admin.orders.save');
			Route::get('/orders/forcedestroy/{id}', 'OrderController@forcedestroy')
				->name('blog.admin.orders.forcedestroy');

			/*Category Controller*/
			Route::get('/categories/mydel', 'CategoryController@mydel')
				->name('blog.admin.categories.mydel');
			Route::resource('categories', 'CategoryController')
				->names('blog.admin.categories');

			/*User Controller*/
			Route::resource('users', 'UserController')
				->names('blog.admin.users');

			/*Product Controller*/
			Route::get('/products/related', 'ProductController@related');
			Route::match(['get','post'], '/products/ajax-image-upload', 'ProductController@ajaxImage');
			Route::delete('/products/ajax-remove-image/{filename}', 'ProductController@deleteImage');
			Route::post('/products/gallery', 'ProductController@gallery')
				->name('blog.admin.products.gallery');
			Route::post('/products/delete-gallery', 'ProductController@deleteGallery')
				->name('blog.admin.products.deletegallery');
			Route::get('/products/return-status/{id}', 'ProductController@returnStatus')
				->name('blog.admin.products.returnstatus');
			Route::get('/product/delete-status/{id}', 'ProductController@deleteStatus')
				->name('blog.admin.products.deletestatus');
			Route::get('/products/delete-product/{id}', 'ProductController@deleteProduct')
				->name('blog.admin.products.deleteproduct');
			Route::resource('products', 'ProductController')
				->names('blog.admin.products');

			/**News Controller*/
			Route::match(['get','post'], '/news/ajax-image-upload', 'NewsController@ajaxImage');
			Route::delete('/news/ajax-remove-image/{filename}', 'NewsController@deleteImage');
			Route::post('/news/gallery', 'NewsController@gallery')
				->name('blog.admin.news.gallery');
			Route::post('/news/delete-gallery', 'NewsController@deleteGallery')
				->name('blog.admin.news.deletegallery');
			Route::get('/news/return-status/{id}', 'NewsController@returnStatus')
				->name('blog.admin.news.returnstatus');
			Route::get('/news/delete-status/{id}', 'NewsController@deleteStatus')
				->name('blog.admin.news.deletestatus');
			Route::get('/news/delete-news/{id}', 'NewsController@deleteNews')
				->name('blog.admin.news.deletenews');
			Route::resource('news', 'NewsController')
				->names('blog.admin.news');

			/*TopGallery Controller*/
			Route::match(['get','post'], '/topgalleries/ajax-image-upload', 'TopGalleryController@ajaxImage');
			Route::delete('/topgalleries/ajax-remove-image/{filename}', 'TopGalleryController@deleteImage');
			Route::get('/topgalleries/return-status/{id}', 'TopGalleryController@returnStatus')
				->name('blog.admin.topgalleries.returnstatus');
			Route::get('/topgalleries/delete-status/{id}', 'TopGalleryController@deleteStatus')
				->name('blog.admin.topgalleries.deletestatus');
			Route::get('/topgalleries/delete-topgallery/{id}', 'TopGalleryController@deleteTopGallery')
				->name('blog.admin.topgalleries.deletetopgallery');
			Route::resource('topgalleries', 'TopGalleryController')
				->names('blog.admin.topgalleries');

			/**Partner Controller*/
			Route::match(['get','post'], '/partners/ajax-image-upload', 'PartnerController@ajaxImage');
			Route::delete('/partners/ajax-remove-image/{filename}', 'PartnerController@deleteImage');
			Route::get('/partners/return-status/{id}', 'PartnerController@returnStatus')
				->name('blog.admin.partners.returnstatus');
			Route::get('/partners/delete-status/{id}', 'PartnerController@deleteStatus')
				->name('blog.admin.partners.deletestatus');
			Route::get('/partners/delete-partner/{id}', 'PartnerController@deletePartner')
				->name('blog.admin.partners.deletepartner');
			Route::resource('partners', 'PartnerController')
				->names('blog.admin.partners');

			/*Service Controller*/
			Route::match(['get','post'], '/services/ajax-image-upload', 'ServiceController@ajaxImage');
			Route::delete('/services/ajax-remove-image/{filename}', 'ServiceController@deleteImage');
			Route::post('/services/gallery', 'ServiceController@gallery')
				->name('blog.admin.services.gallery');
			Route::post('/services/delete-gallery', 'ServiceController@deleteGallery')
				->name('blog.admin.services.deletegallery');
			Route::get('/services/return-status/{id}', 'ServiceController@returnStatus')
				->name('blog.admin.services.returnstatus');
			Route::get('/services/delete-status/{id}', 'ServiceController@deleteStatus')
				->name('blog.admin.services.deletestatus');
			Route::get('/services/delete-service/{id}', 'ServiceController@deleteService')
				->name('blog.admin.services.deleteservice');
			Route::resource('services', 'ServiceController')
				->names('blog.admin.services');

			/*Team Controller**/
			Route::match(['get','post'], '/teams/ajax-image-upload', 'TeamController@ajaxImage');
			Route::delete('/teams/ajax-remove-image/{filename}', 'TeamController@deleteImage');
			Route::get('/teams/return-status/{id}', 'TeamController@returnStatus')
				->name('blog.admin.teams.returnstatus');
			Route::get('/teams/delete-status/{id}', 'TeamController@deleteStatus')
				->name('blog.admin.teams.deletestatus');
			Route::get('/teams/delete-team/{id}', 'TeamController@deleteTeam')
				->name('blog.admin.teams.deleteteam');
			Route::resource('teams', 'TeamController')
				->names('blog.admin.teams');

			/**Vacancy Controller*/
			Route::match(['get','post'], '/vacancies/ajax-image-upload', 'VacancyController@ajaxImage');
			Route::delete('/vacancies/ajax-remove-image/{filename}', 'VacancyController@deleteImage');
			Route::get('/vacancies/return-status/{id}', 'VacancyController@returnStatus')
				->name('blog.admin.vacancies.returnstatus');
			Route::get('/vacancies/delete-status/{id}', 'VacancyController@deleteStatus')
				->name('blog.admin.vacancies.deletestatus');
			Route::get('/vacancies/delete-vacancy/{id}', 'VacancyController@deleteVacancy')
				->name('blog.admin.vacancies.deletevacancy');
			Route::resource('vacancies', 'VacancyController')
				->names('blog.admin.vacancies');

			/**StaticPage Controller*/
			Route::match(['get','post'], '/staticpages/ajax-image-upload', 'StaticPageController@ajaxImage');
			Route::delete('/staticpages/ajax-remove-image/{filename}', 'StaticPageController@deleteImage');
			Route::post('/staticpages/gallery', 'StaticPageController@gallery')
				->name('blog.admin.staticpages.gallery');
			Route::post('/staticpages/delete-gallery', 'StaticPageController@deleteGallery')
				->name('blog.admin.staticpages.deletegallery');
			Route::get('/staticpages/return-status/{id}', 'StaticPageController@returnStatus')
				->name('blog.admin.staticpages.returnstatus');
			Route::get('/staticpages/delete-status/{id}', 'StaticPageController@deleteStatus')
				->name('blog.admin.staticpages.deletestatus');
			Route::get('/staticpages/delete-staticpage/{id}', 'StaticPageController@deleteStaticPage')
				->name('blog.admin.staticpages.deletestaticpage');
			Route::resource('staticpages', 'StaticPageController')
				->names('blog.admin.staticpages');


			/* Filter Controller*/
			Route::get('/filter/group-filter', 'FilterController@attributeGroup');
			Route::match(['get', 'post'], '/filter/group-add-group', 'FilterController@groupAdd');
			Route::match(['get', 'post'], '/filter/group-edit/{id}', 'FilterController@groupEdit');
			Route::get('/filter/group-delete/{id}', 'FilterController@groupDelete');
			Route::get('/filter/attributes-filter', 'FilterController@attributeFilter');
			Route::match(['get', 'post'], '/filter/attrs-add', 'FilterController@attributeAdd');
			Route::match(['get', 'post'], '/filter/attrs-edit/{id}', 'FilterController@attrEdit');
			Route::get('/filter/attrs-delete/{id}', 'FilterController@attrDelete');

			/**Currency Controller*/
			Route::get('/currency/index', 'CurrencyController@index');
			Route::match(['get', 'post'], '/currency/add', 'CurrencyController@add');
			Route::match(['get', 'post'], '/currency/edit/{id}', 'CurrencyController@edit');
			Route::get('/currency/delete/{id}', 'CurrencyController@delete');

			/*Search Controller*/
			Route::get('/search/result', 'SearchController@index');
			Route::get('/autocomplete', 'SearchController@search');


		});
	});

			Route::get('user/index', 'Blog\User\MainController@index');