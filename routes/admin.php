<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\AdminControllers\ThemeController;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\AdminControllers\CustomersController;
use App\Http\Controllers\AdminControllers\AddressController;
use App\Http\Controllers\AdminControllers\AdminSlidersController;
use App\Http\Controllers\AdminControllers\AdminConstantController;
use App\Http\Controllers\AdminControllers\LanguageController;
use App\Http\Controllers\AdminControllers\MediaController;
use App\Http\Controllers\AdminControllers\ManufacturerController;
use App\Http\Controllers\AdminControllers\NewsCategoriesController;
use App\Http\Controllers\AdminControllers\NewsController;
use App\Http\Controllers\AdminControllers\CategoriesController;
use App\Http\Controllers\AdminControllers\CurrencyController;
use App\Http\Controllers\AdminControllers\ProductController;
use App\Http\Controllers\AdminControllers\ProductAttributesController;
use App\Http\Controllers\AdminControllers\DeliveryBoyController;
use App\Http\Controllers\AdminControllers\CountriesController;
use App\Http\Controllers\AdminControllers\ZonesController;
use App\Http\Controllers\AdminControllers\TaxController;
use App\Http\Controllers\AdminControllers\ShippingByWeightController;
use App\Http\Controllers\AdminControllers\ShippingMethodsController;
use App\Http\Controllers\AdminControllers\PaymentMethodsController;
use App\Http\Controllers\AdminControllers\CouponsController;
use App\Http\Controllers\AdminControllers\NotificationController;
use App\Http\Controllers\AdminControllers\OrdersController;
use App\Http\Controllers\AdminControllers\OrdersDeliveryMappingController;
use App\Http\Controllers\AdminControllers\BannersController;
use App\Http\Controllers\AdminControllers\ReportsController;
use App\Http\Controllers\AdminControllers\PagesController;
use App\Http\Controllers\AdminControllers\AppLabelsController;
use App\Http\Controllers\AdminControllers\HomeBannersController;
use App\Http\Controllers\AdminControllers\MenusController;
use App\Http\Controllers\AdminControllers\ClientController;
use App\Http\Controllers\AdminControllers\ProjectController;

use App\Http\Controllers\AdminControllers\ReedemController;
use App\Http\Controllers\AdminControllers\RewardPointsController;
use App\Http\Controllers\AdminControllers\LocationController;
use App\Http\Controllers\AdminControllers\ConstructionResourcesController;
use App\Http\Controllers\AdminControllers\PromotionalBannerController;

use App\Http\Controllers\AdminControllers\WithdrawCashbackController;
use App\Http\Controllers\AdminControllers\WalletController;
use App\Http\Controllers\AdminControllers\JobController;
use App\Http\Controllers\AdminControllers\DistributorController;

use App\Http\Controllers\AdminControllers\PurchaseOrderItemStatusController;
use App\Http\Controllers\AdminControllers\PurchaseOrderMainStatusController;
use App\Http\Controllers\AdminControllers\DistributorBannersController;
use App\Http\Controllers\AdminControllers\PurchaseOrdersController;

use App\Http\Controllers\AdminControllers\DistributorWalletController;

use App\Http\Controllers\AdminControllers\ProductOrderItemStatusController;

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
Route::get('/clear-cache', function () {
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('config:clear');
	// $exitCode = Artisan::call('config:cache');
});

/*	Route::get('/phpinfo', function () {
		phpinfo();
	});*/
	
		Route::group(['middleware' => ['installer']], function () {
			Route::get('/not_allowed', function () {
				return view('errors.not_found');
			});	
Route::group(['namespace' => 'AdminControllers', 'prefix' => 'admin'], function () {
Route::get('/login',[AdminController::class, 'login']);
Route::post('/checkLogin',[AdminController::class, 'checkLogin']);
});

	Route::get('/home', function () {
		return redirect('/admin/languages/display');
	});

Route::group(['namespace' => 'AdminControllers', 'middleware' => 'auth', 'prefix' => 'admin'], function () {
			Route::post('webPagesSettings/changestatus',[ThemeController::class, 'changestatus']);
			Route::post('webPagesSettings/setting/set', [ThemeController::class, 'set']);
			Route::post('webPagesSettings/reorder',[ThemeController::class, 'reorder']);
			Route::get('/home', function () {
				return redirect('/dashboard/{reportBase}');
			});
				Route::get('/generateKey', [SiteSettingController::class, 'generateKey']);
				
				Route::get('/logout',[AdminController::class, 'logout']);
				Route::get('/webPagesSettings/{id}',[ThemeController::class, 'index2']);
				
				Route::get('/topoffer/display',[ThemeController::class, 'topoffer']);
				Route::post('/topoffer/update',[ThemeController::class, 'updateTopOffer']);
				
				Route::get('/dashboard/{reportBase}',[AdminController::class, 'dashboard']);
				
								Route::get('/locationdashboard/{reportBase}',[AdminController::class, 'locationdashboard']);



				//add adddresses against customers
				Route::get('/addaddress/{id}/',[CustomersController::class, 'addaddress'])->middleware('add_customer');
				Route::post('/addNewCustomerAddress',[CustomersController::class, 'addNewCustomerAddress'])->middleware('add_customer');
				Route::post('/editAddress',[CustomersController::class, 'editAddress'])->middleware('edit_customer');
				Route::post('/updateAddress',[CustomersController::class, 'updateAddress'])->middleware('edit_customer');
				Route::post('/deleteAddress',[CustomersController::class, 'deleteAddress'])->middleware('delete_customer');
				Route::post('/getZones',[AddressController::class, 'getzones']);
				
				//sliders
				Route::get('/sliders',[AdminSlidersController::class, 'sliders'])->middleware('website_routes');
				Route::get('/addsliderimage', [AdminSlidersController::class, 'addsliderimage'])->middleware('website_routes');
				Route::post('/addNewSlide', [AdminSlidersController::class, 'addNewSlide'])->middleware('website_routes');
				Route::get('/editslide/{id}',[AdminSlidersController::class, 'editslide'])->middleware('website_routes');
				Route::post('/updateSlide', [AdminSlidersController::class, 'updateSlide'])->middleware('website_routes');
				Route::post('/deleteSlider/', [AdminSlidersController::class, 'deleteSlider'])->middleware('website_routes');
				
				//constant banners
				Route::get('/constantbanners',[AdminConstantController::class, 'constantBanners'])->middleware('website_routes');
				Route::get('/addconstantbanner', [AdminConstantController::class, 'addconstantBanner'])->middleware('website_routes');
				Route::post('/addNewConstantBanner',[AdminConstantController::class, 'addNewconstantBanner'])->middleware('website_routes');
				Route::get('/editconstantbanner/{id}', [AdminConstantController::class, 'editconstantbanner'])->middleware('website_routes');
				Route::post('/updateconstantBanner', [AdminConstantController::class, 'updateconstantBanner'])->middleware('website_routes');
				Route::post('/deleteconstantBanner/', [AdminConstantController::class, 'deleteconstantBanner'])->middleware('website_routes');
				
				
					Route::get('/banners',[BannersController::class, 'banners'])->middleware('website_routes');
				Route::get('/banners/add', [BannersController::class, 'addbanner'])->middleware('website_routes');
				Route::post('/banners/insert', [BannersController::class, 'addNewBanner'])->middleware('website_routes');
				Route::get('/banners/edit/{id}', [BannersController::class, 'editbanner'])->middleware('website_routes');
				Route::post('/banners/update', [BannersController::class, 'updateBanner'])->middleware('website_routes');
				Route::post('/banners/delete', [BannersController::class, 'deleteBanner'])->middleware('website_routes');
				Route::get('/banners/filter', [BannersController::class, 'filterbanners'])->middleware('website_routes');
				
				
				
					
				Route::get('/distributorbanners',[DistributorBannersController::class, 'distributorbanners'])->middleware('website_routes');
				Route::get('/distributorbanners/add', [DistributorBannersController::class, 'adddistributorbanner'])->middleware('website_routes');
				Route::post('/distributorbanners/insert', [DistributorBannersController::class, 'addNewDistributorBanner'])->middleware('website_routes');
				Route::get('/distributorbanners/edit/{id}', [DistributorBannersController::class, 'editdistributorbanner'])->middleware('website_routes');
				Route::post('/distributorbanners/update', [DistributorBannersController::class, 'updatedistributorBanner'])->middleware('website_routes');
				Route::post('/distributorbanners/delete', [DistributorBannersController::class, 'deletedistributorBanner'])->middleware('website_routes');
				
			Route::get('/distributorbanners/youtubevideolink/{id}', [DistributorBannersController::class, 'youtubevideolink'])->middleware('website_routes');
			Route::post('/distributorbanners/updateyoutubevideolink', [DistributorBannersController::class, 'updateyoutubevideolink'])->middleware('website_routes');		
				
});

	Route::group(['prefix' => 'admin/languages', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
		Route::get('/display', [LanguageController::class, 'display'])->middleware('view_language');
		Route::post('/default', [LanguageController::class, 'default'])->middleware('edit_language');
		Route::get('/add', [LanguageController::class, 'add'])->middleware('add_language');
		Route::post('/add', [LanguageController::class, 'insert'])->middleware('add_language');
		Route::get('/edit/{id}', [LanguageController::class, 'edit'])->middleware('edit_language');
		Route::post('/update', [LanguageController::class, 'update'])->middleware('edit_language');
		Route::post('/delete',[LanguageController::class, 'delete'])->middleware('delete_language');
		Route::get('/filter', [LanguageController::class, 'filter'])->middleware('view_language');
	
	});
	
	
		Route::group(['prefix' => 'admin/media', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
			Route::get('/display',[MediaController::class, 'display'])->middleware('view_media');
			Route::get('/add', [MediaController::class, 'add'])->middleware('add_media');
			Route::post('/updatemediasetting', [MediaController::class, 'updatemediasetting'])->middleware('edit_media');
			Route::post('/uploadimage', [MediaController::class, 'fileUpload'])->middleware('add_media');
			Route::post('/delete', [MediaController::class, 'deleteimage'])->middleware('delete_media');
			Route::get('/detail/{id}', [MediaController::class, 'detailimage'])->middleware('view_media');
			Route::get('/refresh', [MediaController::class, 'refresh']);
			Route::post('/regenerateimage', [MediaController::class, 'regenerateimage'])->middleware('add_media');
		});
		
			Route::group(['prefix' => 'admin/theme', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
				Route::get('/setting',[ThemeController::class, 'index']);
				Route::get('/setting/{id}', [ThemeController::class, 'moveToBanners']);
				Route::get('/setting/carousals/{id}', [ThemeController::class, 'moveToSliders']);
				Route::post('setting/set',[ThemeController::class, 'set']);
				Route::post('setting/setPages', [ThemeController::class, 'setPages']);
				Route::post('/setting/updatebanner', [ThemeController::class, 'updatebanner']);
				Route::post('/setting/carousals/updateslider', [ThemeController::class, 'updateslider']);
				Route::post('/setting/addbanner', [ThemeController::class, 'addbanner']);
				Route::post('/reorder', [ThemeController::class, 'reorder']);
				Route::post('/setting/changestatus', [ThemeController::class, 'changestatus']);
				Route::post('/setting/fetchlanguages',[LanguageController::class, 'fetchlanguages'])->middleware('view_language');
			
			});
			
				Route::group(['prefix' => 'admin/manufacturers', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
					Route::get('/display', [ManufacturerController::class, 'display'])->middleware('view_manufacturer');
					Route::get('/add',[ManufacturerController::class, 'add'])->middleware('add_manufacturer');
					Route::post('/add',[ManufacturerController::class, 'insert'])->middleware('add_manufacturer');
					Route::get('/edit/{id}',[ManufacturerController::class, 'edit'])->middleware('edit_manufacturer');
					Route::post('/update',[ManufacturerController::class, 'update'])->middleware('edit_manufacturer');
					Route::post('/delete',[ManufacturerController::class, 'delete'])->middleware('delete_manufacturer');
					Route::get('/filter',[ManufacturerController::class, 'filter'])->middleware('view_manufacturer');
				});
				
					Route::group(['prefix' => 'admin/newscategories', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
						Route::get('/display',[NewsCategoriesController::class, 'display'])->middleware('view_news');
						Route::get('/add',[NewsCategoriesController::class, 'add'])->middleware('add_news');
						Route::post('/add',[NewsCategoriesController::class, 'insert'])->middleware('add_news');
						Route::get('/edit/{id}',[NewsCategoriesController::class, 'edit'])->middleware('edit_news');
						Route::post('/update',[NewsCategoriesController::class, 'update'])->middleware('edit_news');
						Route::post('/delete',[NewsCategoriesController::class, 'delete'])->middleware('delete_news');
						Route::get('/filter', [NewsCategoriesController::class, 'filter'])->middleware('view_news');
					});
					
						Route::group(['prefix' => 'admin/news', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
							Route::get('/display', [NewsController::class, 'display'])->middleware('view_news');
							Route::get('/add', [NewsController::class, 'add'])->middleware('add_news');
							Route::post('/add', [NewsController::class, 'insert'])->middleware('add_news');
							Route::get('/edit/{id}',[NewsController::class, 'edit'])->middleware('edit_news');
							Route::post('/update',[NewsController::class, 'update'])->middleware('edit_news');
							Route::post('/delete',[NewsController::class, 'delete'])->middleware('delete_news');
							Route::get('/filter', [NewsController::class, 'filter'])->middleware('view_news');
						});
						
							Route::group(['prefix' => 'admin/categories', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
								Route::get('/display', [CategoriesController::class, 'display'])->middleware('view_categories');
								Route::get('/add',  [CategoriesController::class, 'add'])->middleware('add_categories');
								Route::post('/add',  [CategoriesController::class, 'insert'])->middleware('add_categories');
								Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->middleware('edit_categories');
								Route::post('/update', [CategoriesController::class, 'update'])->middleware('edit_categories');
								Route::post('/delete',  [CategoriesController::class, 'delete'])->middleware('delete_categories');
								Route::get('/filter',  [CategoriesController::class, 'filter'])->middleware('view_categories');
							});
							
								Route::group(['prefix' => 'admin/currencies', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
									Route::get('/display',[CurrencyController::class, 'display'])->middleware('view_general_setting');
									Route::get('/add', [CurrencyController::class, 'add'])->middleware('edit_general_setting');
									Route::post('/add', [CurrencyController::class, 'insert'])->middleware('edit_general_setting');
									Route::get('/edit/{id}', [CurrencyController::class, 'edit'])->middleware('edit_general_setting');
									Route::get('/edit/warning/{id}',[CurrencyController::class, 'warningedit'])->middleware('edit_general_setting');
									Route::post('/update', [CurrencyController::class, 'update'])->middleware('edit_general_setting');
									Route::post('/delete', [CurrencyController::class, 'delete'])->middleware('edit_general_setting');
								
								
								});
								
								
									Route::group(['prefix' => 'admin/products', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
										Route::get('/display', [ProductController::class, 'display'])->middleware('view_product');
										Route::get('/add', [ProductController::class, 'add'])->middleware('add_product');;
										Route::post('/add',[ProductController::class, 'insert'])->middleware('add_product');
										Route::get('/edit/{id}', [ProductController::class, 'edit'])->middleware('edit_product');
										Route::post('/update',[ProductController::class, 'update'])->middleware('edit_product');
										Route::post('/delete', [ProductController::class, 'delete'])->middleware('delete_product');
										Route::get('/filter', [ProductController::class, 'filter'])->middleware('view_product');
									
									
										Route::get('/inactive_products', [ProductController::class, 'inactive_products'])->middleware('view_product');
									//for new location ....
									Route::get('/addfornewlocation/{id}', [ProductController::class, 'addfornewlocation'])->middleware('edit_product');

//ajax call for changing price and special price...
                                        Route::post('/productpriceupdate', [ProductController::class, 'productpriceupdate'])->middleware('edit_customer');
										Route::post('/productspecialpriceupdate', [ProductController::class, 'productspecialpriceupdate'])->middleware('edit_customer');
									 Route::post('/loadmore/load_data',[MediaController::class, 'load_images'])->middleware('add_product');
										Route::post('/imageloadmore/image_load_data',[MediaController::class, 'media_load_images'])->middleware('add_product');

									 	//bhart
										Route::post('/addfornewlocation',[ProductController::class, 'addtonewlocationinsert'])->middleware('add_product');
											
											
											
											
	Route::post('/addwalletdate', [PurchaseOrdersController::class, 'addwalletdate'])->middleware('add_product');
																		
                                            Route::post('/discountacceptreject', [PurchaseOrdersController::class, 'discountacceptreject'])->middleware('add_product');

									
									
										/*  Route::group(['prefix' => 'inventory'], function () {
										 Route::get('/display', 'ProductController@addinventoryfromsidebar')->middleware('view_product');
										 // Route::post('/addnewstock', 'ProductController@addinventory')->middleware('view_product');
										 Route::get('/ajax_min_max/{id}/', 'ProductController@ajax_min_max')->middleware('view_product');
										 Route::get('/ajax_attr/{id}/', 'ProductController@ajax_attr')->middleware('view_product');
										 Route::post('/addnewstock', 'ProductController@addnewstock')->middleware('add_product');
										 Route::post('/addminmax', 'ProductController@addminmax')->middleware('add_product');
										 Route::get('/addproductimages/{id}/', 'ProductController@addproductimages')->middleware('add_product');
										 });*/
									
									
									
										//Bharath 20-10-2020 Inventory Permissions
										Route::group(['prefix' => 'inventory'], function () {
											Route::get('/display',[ProductController::class, 'addinventoryfromsidebar'])->middleware('inventory_view');
											//  Route::get('/displays', 'ProductController@addinventoryfromsidebar')->middleware('view_product');
									
											// Route::post('/addnewstock', 'ProductController@addinventory')->middleware('view_product');
											Route::get('/ajax_min_max/{id}/', [ProductController::class, 'ajax_min_max'])->middleware('inventory_view');
											Route::get('/ajax_attr/{id}/', [ProductController::class, 'ajax_attr'])->middleware('inventory_view');
											Route::post('/addnewstock', [ProductController::class, 'addnewstock'])->middleware('inventory_view');
											Route::post('/addminmax', [ProductController::class, 'addminmax'])->middleware('inventory_view');
											Route::get('/addproductimages/{id}/', [ProductController::class, 'addproductimages'])->middleware('add_product');
									
									
																				Route::post('/getinventoryproducts', [ProductController::class, 'getinventoryproducts'])->middleware('inventory_view');

										});
									
									
											Route::group(['prefix' => 'images'], function () {
												Route::get('/display/{id}/', [ProductController::class, 'displayProductImages'])->middleware('view_product');
												Route::get('/add/{id}/',[ProductController::class, 'addProductImages'])->middleware('add_product');
												Route::post('/insertproductimage', [ProductController::class, 'insertProductImages'])->middleware('add_product');
												Route::get('/editproductimage/{id}',[ProductController::class, 'editProductImages'])->middleware('edit_product');
												Route::post('/updateproductimage',[ProductController::class, 'updateproductimage'])->middleware('edit_product');
												Route::post('/deleteproductimagemodal',[ProductController::class, 'deleteproductimagemodal'])->middleware('edit_product');
												Route::post('/deleteproductimage', [ProductController::class, 'deleteproductimage'])->middleware('edit_product');
											});
												Route::group(['prefix' => 'attach/attribute'], function () {
													Route::get('/display/{id}',[ProductController::class, 'addproductattribute'])->middleware('view_product');
													Route::group(['prefix' => '/default'], function () {
														Route::post('/',[ProductController::class, 'addnewdefaultattribute'])->middleware('view_product');
														Route::post('/edit',[ProductController::class, 'editdefaultattribute'])->middleware('edit_product');
														Route::post('/update',[ProductController::class, 'updatedefaultattribute'])->middleware('edit_product');
														Route::post('/deletedefaultattributemodal', [ProductController::class, 'deletedefaultattributemodal'])->middleware('edit_product');
														Route::post('/delete', [ProductController::class, 'deletedefaultattribute'])->middleware('edit_product');
														Route::group(['prefix' => '/options'], function () {
															Route::post('/add', [ProductController::class, 'showoptions'])->middleware('view_product');
															Route::post('/edit',[ProductController::class, 'editoptionform'])->middleware('edit_product');
															Route::post('/update',[ProductController::class, 'updateoption'])->middleware('edit_product');
															Route::post('/showdeletemodal',[ProductController::class, 'showdeletemodal'])->middleware('edit_product');
															Route::post('/delete', [ProductController::class, 'deleteoption'])->middleware('edit_product');
															Route::post('/getOptionsValue', [ProductController::class, 'getOptionsValue'])->middleware('edit_product');
															// Route::post('/currentstock', 'ProductController@currentstock')->middleware('view_product');
															//Bharath 20-10-2020 Inventory Permissions
															Route::post('/currentstock',[ProductController::class, 'currentstock'])->middleware('inventory_view');
									
														});
									
													});
									
												});
									
									});
									
									
										Route::group(['prefix' => 'admin/products/attributes', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
											Route::get('/display',[ProductAttributesController::class, 'display'])->middleware('view_product');
											Route::get('/add',[ProductAttributesController::class, 'add'])->middleware('view_product');
											Route::post('/insert', [ProductAttributesController::class, 'insert'])->middleware('view_product');
											Route::get('/edit/{id}', [ProductAttributesController::class, 'edit'])->middleware('view_product');
											Route::post('/update', [ProductAttributesController::class, 'update'])->middleware('view_product');
											Route::post('/delete', [ProductAttributesController::class, 'delete'])->middleware('view_product');
										
											Route::group(['prefix' => 'options/values'], function () {
												Route::get('/display/{id}',[ProductAttributesController::class, 'displayoptionsvalues'])->middleware('view_product');
												Route::post('/insert', [ProductAttributesController::class, 'insertoptionsvalues'])->middleware('edit_product');
												Route::get('/edit/{id}',[ProductAttributesController::class, 'editoptionsvalues'])->middleware('edit_product');
												Route::post('/update',[ProductAttributesController::class, 'updateoptionsvalues'])->middleware('edit_product');
												Route::post('/delete',[ProductAttributesController::class, 'deleteoptionsvalues'])->middleware('edit_product');
												Route::post('/addattributevalue',[ProductAttributesController::class, 'addattributevalue'])->middleware('edit_product');
												Route::post('/updateattributevalue', [ProductAttributesController::class, 'updateattributevalue'])->middleware('edit_product');
												Route::post('/checkattributeassociate', [ProductAttributesController::class, 'checkattributeassociate'])->middleware('edit_product');
												Route::post('/checkvalueassociate', [ProductAttributesController::class, 'checkvalueassociate'])->middleware('edit_product');
											});
										});
										
										
											Route::group(['prefix' => 'admin/admin', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
												Route::get('/profile',[AdminController::class, 'profile']);
												Route::post('/update',[AdminController::class, 'update']);
												Route::post('/updatepassword',[AdminController::class, 'updatepassword']);
											});
											
												Route::group(['prefix' => 'admin/reviews', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
													Route::get('/display',[ProductController::class, 'reviews'])->middleware('view_reviews');
													Route::get('/edit/{id}/{status}',[ProductController::class, 'editreviews'])->middleware('edit_reviews');
												
												});
												
													//customers
													Route::group(['prefix' => 'admin/customers', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
														Route::get('/display',[CustomersController::class, 'display'])->middleware('view_customer');
														Route::get('/add',[CustomersController::class, 'add'])->middleware('add_customer');
														Route::post('/add',[CustomersController::class, 'insert'])->middleware('add_customer');
														Route::get('/edit/{id}',[CustomersController::class, 'edit'])->middleware('edit_customer');
														Route::post('/update',[CustomersController::class, 'update'])->middleware('edit_customer');
														Route::post('/delete', [CustomersController::class, 'delete'])->middleware('delete_customer');
														Route::get('/filter', [CustomersController::class, 'filter'])->middleware('view_customer');
														//add adddresses against customers
														Route::get('/address/display/{id}/',[CustomersController::class, 'diplayaddress'])->middleware('add_customer');
														Route::post('/addcustomeraddress',[CustomersController::class, 'addcustomeraddress'])->middleware('add_customer');
														Route::post('/editaddress', [CustomersController::class, 'editaddress'])->middleware('edit_customer');
														Route::post('/updateaddress', [CustomersController::class, 'updateaddress'])->middleware('edit_customer');
														Route::post('/deleteAddress', [CustomersController::class, 'deleteAddress'])->middleware('edit_customer');
													});
													
													
														//Delivery Boy
														Route::group(['prefix' => 'admin/deliveryboy', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
															Route::get('/display', [DeliveryBoyController::class, 'display'])->middleware('view_customer');
															Route::get('/add', [DeliveryBoyController::class, 'add'])->middleware('add_customer');
															Route::post('/add',[DeliveryBoyController::class, 'insert'])->middleware('add_customer');
															Route::get('/edit/{id}',[DeliveryBoyController::class, 'edit'])->middleware('edit_customer');
															Route::post('/update', [DeliveryBoyController::class, 'update'])->middleware('edit_customer');
															Route::post('/delete', [DeliveryBoyController::class, 'delete'])->middleware('delete_customer');
															Route::get('/filter', [DeliveryBoyController::class, 'filter'])->middleware('view_customer');
															//add adddresses against customers
															Route::get('/address/display/{id}/',[DeliveryBoyController::class, 'diplayaddress'])->middleware('add_customer');
															Route::post('/addcustomeraddress',[DeliveryBoyController::class, 'addcustomeraddress'])->middleware('add_customer');
															Route::post('/editaddress', [DeliveryBoyController::class, 'editaddress'])->middleware('edit_customer');
															Route::post('/updateaddress', [DeliveryBoyController::class, 'updateaddress'])->middleware('edit_customer');
															Route::post('/deleteAddress', [DeliveryBoyController::class, 'deleteAddress'])->middleware('edit_customer');
														});
														
															Route::group(['prefix' => 'admin/countries', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																Route::get('/filter', [CountriesController::class, 'filter'])->middleware('view_tax');
																Route::get('/display',[CountriesController::class, 'index'])->middleware('view_tax');
																Route::get('/add',[CountriesController::class, 'add'])->middleware('add_tax');
																Route::post('/add', [CountriesController::class, 'insert'])->middleware('add_tax');
																Route::get('/edit/{id}', [CountriesController::class, 'edit'])->middleware('edit_tax');
																Route::post('/update', [CountriesController::class, 'update'])->middleware('edit_tax');
																Route::post('/delete', [CountriesController::class, 'delete'])->middleware('delete_tax');
															});
															
																Route::group(['prefix' => 'admin/zones', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																	Route::get('/display',[ZonesController::class, 'index'])->middleware('view_tax');
																	Route::get('/filter',[ZonesController::class, 'filter'])->middleware('view_tax');
																	Route::get('/add',[ZonesController::class, 'add'])->middleware('add_tax');
																	Route::post('/add', [ZonesController::class, 'insert'])->middleware('add_tax');
																	Route::get('/edit/{id}', [ZonesController::class, 'edit'])->middleware('edit_tax');
																	Route::post('/update', [ZonesController::class, 'update'])->middleware('edit_tax');
																	Route::post('/delete',[ZonesController::class, 'delete'])->middleware('delete_tax');
																});
																
																	Route::group(['prefix' => 'admin/tax', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																	
																		Route::group(['prefix' => '/taxclass'], function () {
																			Route::get('/filter', [TaxController::class, 'filtertaxclass'])->middleware('view_tax');
																			Route::get('/display', [TaxController::class, 'taxindex'])->middleware('view_tax');
																			Route::get('/add',[TaxController::class, 'addtaxclass'])->middleware('add_tax');
																			Route::post('/add',[TaxController::class, 'inserttaxclass'])->middleware('add_tax');
																			Route::get('/edit/{id}',[TaxController::class, 'edittaxclass'])->middleware('edit_tax');
																			Route::post('/update',[TaxController::class, 'updatetaxclass'])->middleware('edit_tax');
																			Route::post('/delete', [TaxController::class, 'deletetaxclass'])->middleware('delete_tax');
																		});
																	
																			Route::group(['prefix' => '/taxrates'], function () {
																				Route::get('/display',[TaxController::class, 'displaytaxrates'])->middleware('view_tax');
																				Route::get('/filter', [TaxController::class, 'filtertaxrates'])->middleware('view_tax');
																				Route::get('/add', [TaxController::class, 'addtaxrate'])->middleware('add_tax');
																				Route::post('/add', [TaxController::class, 'inserttaxrate'])->middleware('add_tax');
																				Route::get('/edit/{id}', [TaxController::class, 'edittaxrate'])->middleware('edit_tax');
																				Route::post('/update', [TaxController::class, 'updatetaxrate'])->middleware('edit_tax');
																				Route::post('/delete', [TaxController::class, 'deletetaxrate'])->middleware('delete_tax');
																			});
																	
																	});
																	
																		Route::group(['prefix' => 'admin/shippingmethods', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																			//shipping setting
																			Route::get('/display',[ShippingMethodsController::class, 'display'])->middleware('view_shipping');
																			Route::get('/upsShipping', [ShippingMethodsController::class, 'upsShipping'])->middleware('view_shipping');
																			Route::post('/updateupsshipping', [ShippingMethodsController::class, 'updateupsshipping'])->middleware('edit_shipping');
																			Route::get('/flateRate',[ShippingMethodsController::class, 'flateRate'])->middleware('view_shipping');
																			Route::post('/updateflaterate',[ShippingMethodsController::class, 'updateflaterate'])->middleware('edit_shipping');
																			Route::post('/defaultShippingMethod',[ShippingMethodsController::class, 'defaultShippingMethod'])->middleware('edit_shipping');
																			Route::get('/detail/{table_name}', [ShippingMethodsController::class, 'detail'])->middleware('edit_shipping');
																			Route::post('/update',[ShippingMethodsController::class, 'update'])->middleware('edit_shipping');
																		
																			Route::get('/shppingbyweight', [ShippingByWeightController::class, 'shppingbyweight'])->middleware('view_shipping');
																			Route::post('/updateShppingWeightPrice', [ShippingByWeightController::class, 'updateShppingWeightPrice'])->middleware('edit_shipping');
																		
																		});
																		
																			Route::group(['prefix' => 'admin/paymentmethods', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																				Route::get('/index',[PaymentMethodsController::class, 'index'])->middleware('view_payment');
																				Route::get('/display/{id}',[PaymentMethodsController::class, 'display'])->middleware('view_payment');
																				Route::post('/update',[PaymentMethodsController::class, 'update'])->middleware('edit_payment');
																				Route::post('/active',[PaymentMethodsController::class, 'active'])->middleware('edit_payment');
																			});
																			
																			
																				Route::group(['prefix' => 'admin/coupons', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																					Route::get('/display',[CouponsController::class, 'display'])->middleware('view_coupon');
																					Route::get('/add', [CouponsController::class, 'add'])->middleware('add_coupon');
																					Route::post('/insert',[CouponsController::class, 'insert'])->middleware('add_coupon');
																					Route::get('/edit/{id}',[CouponsController::class, 'edit'])->middleware('edit_coupon');
																					Route::post('/update',[CouponsController::class, 'update'])->middleware('edit_coupon');
																					Route::post('/delete',[CouponsController::class, 'delete'])->middleware('delete_coupon');
																					Route::get('/filter',[CouponsController::class, 'filter'])->middleware('view_coupon');
																					Route::post('/getcouponproducts', [CouponsController::class, 'getcouponproducts'])->middleware('add_coupon');
																					Route::post('/getcouponexcludeproducts', [CouponsController::class, 'getcouponexcludeproducts'])->middleware('add_coupon');
																				
																					
																				});
																
																					Route::group(['prefix' => 'admin/devices', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																						Route::get('/display', [NotificationController::class, 'devices'])->middleware('view_notification');
																						Route::get('/viewdevices/{id}', [NotificationController::class, 'viewdevices'])->middleware('view_notification');
																						Route::post('/notifyUser/', [NotificationController::class, 'notifyUser'])->middleware('edit_notification');
																						Route::get('/notifications/', [NotificationController::class, 'notifications'])->middleware('view_notification');
																						Route::post('/sendNotifications/',[NotificationController::class, 'sendNotifications'])->middleware('edit_notification');
																						Route::post('/customerNotification/',[NotificationController::class, 'customerNotification'])->middleware('view_notification');
																						Route::post('/singleUserNotification/',[NotificationController::class, 'singleUserNotification'])->middleware('edit_notification');
																						Route::post('/deletedevice/', [NotificationController::class, 'deletedevice'])->middleware('view_notification');
																					});
																					
																					
																						Route::group(['prefix' => 'admin/devices', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																							Route::get('/', [NotificationController::class, 'devices'])->middleware('view_notification');
																							Route::get('/viewdevices/{id}',[NotificationController::class, 'viewdevices'])->middleware('view_notification');
																							Route::post('/notifyUser/', [NotificationController::class, 'notifyUser'])->middleware('edit_notification');
																							Route::get('/notifications/', [NotificationController::class, 'notifications'])->middleware('view_notification');
																							Route::post('/sendNotifications/', [NotificationController::class, 'sendNotifications'])->middleware('edit_notification');
																							Route::post('/customerNotification/',[NotificationController::class, 'customerNotification'])->middleware('view_notification');
																							Route::post('/singleUserNotification/', [NotificationController::class, 'singleUserNotification'])->middleware('edit_notification');
																							Route::post('/deletedevice/', [NotificationController::class, 'deletedevice'])->middleware('view_notification');
																						});
																						
																							Route::group(['prefix' => 'admin/orders', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																								Route::get('/display',[OrdersController::class, 'display'])->middleware('view_order');
																								Route::get('/vieworder/{id}', [OrdersController::class, 'vieworder'])->middleware('edit_order');
																								Route::post('/updateOrder', [OrdersController::class, 'updateOrder'])->middleware('edit_order');
																								Route::post('/deleteOrder', [OrdersController::class, 'deleteOrder'])->middleware('edit_order');
																								Route::get('/invoiceprint/{id}',[OrdersController::class, 'invoiceprint'])->middleware('edit_order');
																								Route::get('/orderstatus', [SiteSettingController::class, 'orderstatus'])->middleware('view_order');
																								Route::get('/addorderstatus', [SiteSettingController::class, 'addorderstatus'])->middleware('edit_order');
																								Route::post('/addNewOrderStatus', [SiteSettingController::class, 'addNewOrderStatus'])->middleware('edit_order');
																								Route::get('/editorderstatus/{id}',[SiteSettingController::class, 'editorderstatus'])->middleware('edit_order');
																								Route::post('/updateOrderStatus', [SiteSettingController::class, 'updateOrderStatus'])->middleware('edit_order');
																								Route::post('/deleteOrderStatus', [SiteSettingController::class, 'deleteOrderStatus'])->middleware('edit_order');
																							
																								Route::post('/getorderstatus_comments', [OrdersController::class, 'getorderstatus_comments'])->middleware('edit_order');
																							Route::get('/filter', [OrdersController::class, 'filterbycustomerorders'])->middleware('view_order');
																							Route::get('/locationorderdisplay',[OrdersController::class, 'locationorderdisplay'])->middleware('location_view_order');
																				 
																				 
																				 	Route::post('/product_order_status_update', [OrdersController::class, 'product_order_status_update'])->middleware('edit_order');
																							Route::post('/consignment_number_update', [OrdersController::class, 'consignment_number_update'])->middleware('edit_order');
																							Route::post('/consignmentinvoiceprint',[OrdersController::class, 'consignmentinvoiceprint'])->middleware('edit_order');
																								

                                                                                	//Bharath 04-03-2022 Location Based Orders Filter 

																								Route::get('/locationfilter', [OrdersController::class, 'locationfilterbycustomerorders'])->middleware('edit_order');
																							
																							
																							Route::get('/generate_prucahse_order/{id}',[PurchaseOrdersController::class, 'generate_purchase_order'])->middleware('edit_order');
																							
																								Route::get('/purchase_orders/{id}',[PurchaseOrdersController::class, 'purchase_orders'])->middleware('edit_order');
																								Route::get('/purchase_orders/view_purchase_order/{id}', [PurchaseOrdersController::class, 'purchaseorder_detail'])->middleware('edit_order');
																							
																								Route::get('/purchase_order_invoiceprint/{id}',[PurchaseOrdersController::class, 'invoiceprint_purchaseorder'])->middleware('edit_order');
																								
																								Route::post('/purchase_order_status_update', [PurchaseOrdersController::class, 'purchase_order_status_update'])->middleware('edit_order');
																								Route::post('/updatepurchaseorderrecord', [PurchaseOrdersController::class, 'updatepurchaseorderrecord'])->middleware('edit_order');
							                                                            Route::post('/regenerate_purchase_order',[PurchaseOrdersController::class, 'regenerate_purchase_order'])->middleware('edit_order');

																							
																							
                                             												
                                            Route::get('purchase_orders/distributorwallet/{id}',[PurchaseOrdersController::class, 'distributorwallet'])->middleware('edit_order');	
                                            
                                            //Distributor Wallet
                                            Route::get('purchase_orders/distributorwallet/editdistributorwallet/{id}',[PurchaseOrdersController::class, 'editdistributorwallet'])->middleware('edit_general_setting');
                                            Route::post('purchase_orders/distributorwallet/updatedistributorwallet', [PurchaseOrdersController::class, 'updatedistributorwallet'])->middleware('edit_general_setting');
                                            	
                                            							    
																							    
																							    
																							});
																							
																							
																								// For Assigning Delivery Boy Bharath 16-09-2020
																								Route::group(['prefix' => 'admin/ordersdeliverymapping', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																									Route::get('/displaydeliverymapping',[OrdersDeliveryMappingController::class, 'displaydeliverymapping'])->middleware('delivery_view_order');
																									Route::get('/vieworderdeliverymapping/{id}', [OrdersDeliveryMappingController::class, 'vieworderdeliverymapping'])->middleware('delivery_view_order');
																									Route::post('/updateOrderdeliverymapping', [OrdersDeliveryMappingController::class, 'updateOrderdeliverymapping'])->middleware('delivery_view_order');
																									Route::post('/deleteOrderdeliverymapping',[OrdersDeliveryMappingController::class, 'deleteOrderdeliverymapping'])->middleware('delivery_view_order');
																									Route::get('/invoiceprint/{id}',[OrdersDeliveryMappingController::class, 'invoiceprint'])->middleware('delivery_view_order');
																									Route::post('/getorderstatus_comments', [OrdersDeliveryMappingController::class, 'getorderstatus_comments'])->middleware('delivery_view_order');
																								
																									Route::post('/assigndeliveryboy',[OrdersDeliveryMappingController::class, 'assigndeliveryboy'])->middleware('delivery_view_order');
																								
																								});
																								
																								
																								 
																									
																										Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																										
																											Route::get('/customers-orders-report',[ReportsController::class, 'statsCustomers'])->middleware('report');
																											Route::get('/customer-orders-print',[ReportsController::class, 'customerOrdersPrint'])->middleware('report');
																										
																											Route::get('/statsproductspurchased', [ReportsController::class, 'statsProductsPurchased'])->middleware('report');
																											Route::get('/statsproductsliked', [ReportsController::class, 'statsProductsLiked'])->middleware('report');
																											Route::get('/outofstock',[ReportsController::class, 'outofstock'])->middleware('report');
																											Route::get('/outofstockprint',[ReportsController::class, 'outofstockprint'])->middleware('report');
																											Route::get('/lowinstock', [ReportsController::class, 'lowinstock'])->middleware('report');
																											Route::get('/stockin', [ReportsController::class, 'stockin'])->middleware('edit_order');
																											Route::post('/productSaleReport',[ReportsController::class, 'productSaleReport'])->middleware('report');
																											Route::get('/couponreport', [ReportsController::class, 'couponReport'])->middleware('report');
																											Route::get('/couponreport-print', [ReportsController::class, 'couponReportPrint'])->middleware('report');
																										
																										
																											Route::get('/stockreport', [ReportsController::class, 'stockreport'])->middleware('report');
																											Route::get('/stockreportprint', [ReportsController::class, 'stockreportprint'])->middleware('report');
																										
																											Route::get('/salesreports', [ReportsController::class, 'salesreports'])->middleware('report');
																										
																											Route::get('/salesreport',[ReportsController::class, 'salesreport'])->middleware('report');
																											// Route::get('/customer-orders-print', 'ReportsController@customerOrdersPrint')->middleware('report');
																										
																											Route::get('/inventoryreport', [ReportsController::class, 'inventoryreport'])->middleware('report');
																											Route::get('/inventoryreportprint',[ReportsController::class, 'inventoryreportprint'])->middleware('report');
																										
																										
																											Route::get('/minstock',[ReportsController::class, 'minstock'])->middleware('report');
																											Route::get('/minstockprint',[ReportsController::class, 'minstockprint'])->middleware('report');
																										
																											Route::get('/maxstock', [ReportsController::class, 'maxstock'])->middleware('report');
																											Route::get('/maxstockprint', [ReportsController::class, 'maxstockprint'])->middleware('report');
																											
																											 
																											
																												Route::get('/locationlowinstock', [ReportsController::class, 'locationlowinstock'])->middleware('locationreport');
																											
																											Route::get('/locationoutofstock', [ReportsController::class, 'locationoutofstock'])->middleware('locationreport');
																											Route::get('/locationoutofstockprint',[ReportsController::class, 'locationoutofstockprint'])->middleware('locationreport');
																												
																											Route::get('/locationstockreport', [ReportsController::class, 'locationstockreport'])->middleware('locationreport');
																											Route::get('/locationstockreportprint', [ReportsController::class, 'locationstockreportprint'])->middleware('locationreport');
																											
																											Route::get('/locationsalesreports', [ReportsController::class, 'locationsalesreports'])->middleware('locationreport');
																											
																											
																											
															
																											////////////////////////////////////////////////////////////////////////////////////
																											//////////////     APP ROUTES
																											////////////////////////////////////////////////////////////////////////////////////
																											//app pages controller
																											Route::get('/pages', [PagesController::class, 'pages'])->middleware('view_app_setting', 'application_routes');
																											Route::get('/addpage', [PagesController::class, 'addpage'])->middleware('edit_app_setting', 'application_routes');
																											Route::post('/addnewpage', [PagesController::class, 'addnewpage'])->middleware('edit_app_setting', 'application_routes');
																											Route::get('/editpage/{id}', [PagesController::class, 'editpage'])->middleware('edit_app_setting', 'application_routes');
																											Route::post('/updatepage', [PagesController::class, 'updatepage'])->middleware('edit_app_setting', 'application_routes');
																											Route::get('/pageStatus', [PagesController::class, 'pageStatus'])->middleware('edit_app_setting', 'application_routes');
																											Route::get('/filterpages', [PagesController::class, 'filterpages'])->middleware('view_app_setting', 'application_routes');
																											//manageAppLabel
																											Route::get('/listingAppLabels', [AppLabelsController::class, 'listingAppLabels'])->middleware('view_app_setting', 'application_routes');
																											Route::get('/addappkey', [AppLabelsController::class, 'addappkey'])->middleware('edit_app_setting', 'application_routes');
																											Route::post('/addNewAppLabel', [AppLabelsController::class, 'addNewAppLabel'])->middleware('edit_app_setting', 'application_routes');
																											Route::get('/editAppLabel/{id}', [AppLabelsController::class, 'editAppLabel'])->middleware('edit_app_setting', 'application_routes');
																											Route::post('/updateAppLabel/',[AppLabelsController::class, 'updateAppLabel'])->middleware('edit_app_setting', 'application_routes');
																											Route::get('/applabel', [AppLabelsController::class, 'manageAppLabel'])->middleware('view_app_setting', 'application_routes');
																											
																											Route::get('/admobSettings', [SiteSettingController::class, 'admobSettings'])->middleware('view_app_setting', 'application_routes');
																											Route::get('/applicationapi',[SiteSettingController::class, 'applicationApi'])->middleware('view_app_setting', 'application_routes');
																											Route::get('/appsettings', [SiteSettingController::class, 'appSettings'])->middleware('view_app_setting', 'application_routes');
																											//login
																											Route::get('/loginsetting', [SiteSettingController::class, 'loginsetting'])->middleware('view_general_setting');
																											
																											
																											////////////////////////////////////////////////////////////////////////////////////
																											//////////////     SITE ROUTES
																											////////////////////////////////////////////////////////////////////////////////////
																											
																											// home page banners
																											Route::get('/homebanners', [HomeBannersController::class, 'display'])->middleware('view_web_setting', 'website_routes');
																											Route::post('/homebanners/insert',[HomeBannersController::class, 'insert'])->middleware('view_web_setting', 'website_routes');
																											
																											Route::get('/menus',[MenusController::class, 'menus'])->middleware('view_web_setting', 'website_routes');
																											Route::get('/addmenus', [MenusController::class, 'addmenus'])->middleware('edit_web_setting', 'website_routes');
																											Route::post('/addnewmenu', [MenusController::class, 'addnewmenu'])->middleware('edit_web_setting', 'website_routes');
																											Route::get('/editmenu/{id}',[MenusController::class, 'editmenu'])->middleware('edit_web_setting', 'website_routes');
																											Route::post('/updatemenu',[MenusController::class, 'updatemenu'])->middleware('edit_web_setting', 'website_routes');
																											Route::get('/deletemenu/{id}',[MenusController::class, 'deletemenu'])->middleware('edit_web_setting', 'website_routes');
																											Route::post('/deletemenu', [MenusController::class, 'deletemenu'])->middleware('edit_web_setting', 'website_routes');
																											Route::post('/menuposition', [MenusController::class, 'menuposition'])->middleware('edit_web_setting', 'website_routes');
																											Route::get('/catalogmenu', [MenusController::class, 'catalogmenu'])->middleware('edit_web_setting', 'website_routes');
																											
																											
																											
																											//site pages controller
																											Route::get('/webpages',[PagesController::class, 'webpages'])->middleware('view_web_setting', 'website_routes');
																											Route::get('/addwebpage',[PagesController::class, 'addwebpage'] )->middleware('edit_web_setting', 'website_routes');
																											Route::post('/addnewwebpage', [PagesController::class, 'addnewwebpage'])->middleware('edit_web_setting', 'website_routes');
																											Route::get('/editwebpage/{id}',[PagesController::class, 'editwebpage'])->middleware('edit_web_setting', 'website_routes');
																											Route::post('/updatewebpage',[PagesController::class, 'updatewebpage'])->middleware('edit_web_setting', 'website_routes');
																											Route::get('/pageWebStatus',[PagesController::class, 'pageWebStatus'])->middleware('view_web_setting', 'website_routes');
																											
																											Route::get('/webthemes', [SiteSettingController::class, 'webThemes'])->middleware('view_web_setting', 'website_routes');
																											Route::get('/themeSettings', [SiteSettingController::class, 'themeSettings'])->middleware('edit_web_setting', 'website_routes');
																											
																											Route::get('/seo', [SiteSettingController::class, 'seo'])->middleware('view_web_setting', 'website_routes');
																											Route::get('/customstyle', [SiteSettingController::class, 'customstyle'])->middleware('view_web_setting', 'website_routes');
																											Route::post('/updateWebTheme', [SiteSettingController::class, 'updateWebTheme'])->middleware('edit_web_setting', 'website_routes');
																											Route::get('/websettings', [SiteSettingController::class, 'webSettings'])->middleware('view_web_setting', 'website_routes');
																											Route::get('/instafeed', [SiteSettingController::class, 'instafeed'])->middleware('view_web_setting', 'website_routes');
																											Route::get('/newsletter', [SiteSettingController::class, 'newsletter'])->middleware('view_web_setting', 'website_routes');
																											
																											/////////////////////////////////////////////////////////////////////////////////
																											////////////////////////////////////////////////////////////////////////////////////
																											//////////////     GENERAL ROUTES
																											////////////////////////////////////////////////////////////////////////////////////
																											
																											
																											////reedem points
																											
																																																					//Reedem Values
																											Route::get('/reedems', [ReedemController::class, 'reedems'])->middleware('view_general_setting');
																										//	Route::get('/addclient', [ClientController::class, 'addclient'])->middleware('edit_general_setting');
																										//	Route::post('/addnewclient',[ClientController::class, 'addnewclient'] )->middleware('edit_general_setting');
																											Route::get('/editreedem/{id}',[ReedemController::class, 'editreedem'])->middleware('edit_general_setting');
																											Route::post('/updatereedem', [ReedemController::class, 'updatereedem'])->middleware('edit_general_setting');
																											//Route::post('/deleteclient',[ClientController::class, 'deleteclient'])->middleware('edit_general_setting');
																												
																											
																											//Reward Points
																											Route::get('/rewardpoints', [RewardPointsController::class, 'rewardpoints'])->middleware('view_general_setting');
																											Route::get('/addrewardpoint', [RewardPointsController::class, 'addrewardpoint'])->middleware('edit_general_setting');
																											Route::post('/addnewrewardpoint',[RewardPointsController::class, 'addnewrewardpoint'] )->middleware('edit_general_setting');
																											Route::get('/editrewardpoint/{id}',[RewardPointsController::class, 'editrewardpoint'])->middleware('edit_general_setting');
																											Route::post('/updaterewardpoint', [RewardPointsController::class, 'updaterewardpoint'])->middleware('edit_general_setting');
																											Route::post('/deleterewardpoint',[RewardPointsController::class, 'deleterewardpoint'])->middleware('edit_general_setting');
																												
		
																											
																											/// reedem points
																									
	//Wallet
Route::get('/wallets', [WalletController::class, 'wallets'])->middleware('view_general_setting');
Route::get('/addwallet', [WalletController::class, 'addwallet'])->middleware('edit_general_setting');
Route::post('/addnewwallet',[WalletController::class, 'addnewwallet'] )->middleware('edit_general_setting');
Route::get('/editwallet/{id}',[WalletController::class, 'editwallet'])->middleware('edit_general_setting');
Route::post('/updatewallet', [WalletController::class, 'updatewallet'])->middleware('edit_general_setting');
Route::post('/deletewallet',[WalletController::class, 'deletewallet'])->middleware('edit_general_setting');

	 	Route::get('/wallet_customers', [WalletController::class, 'filter'])->middleware('view_general_setting');


//Wallet																								
																											// start of locations ....																								//locations
																											Route::get('/locations', [LocationController::class, 'locations'])->middleware('view_general_setting');
																											Route::get('/addlocation', [LocationController::class, 'addlocation'])->middleware('edit_general_setting');
																											Route::post('/addnewlocation',[LocationController::class, 'addnewlocation'] )->middleware('edit_general_setting');
																											Route::get('/editlocation/{id}',[LocationController::class, 'editlocation'])->middleware('edit_general_setting');
																											Route::post('/updatelocation', [LocationController::class, 'updatelocation'])->middleware('edit_general_setting');
																											Route::post('/deletelocation',[LocationController::class, 'deletelocation'])->middleware('edit_general_setting');
																											//end locations
																											
																											//main  master purchase order status
																											
																											
																											Route::get('/purchaseordermainstatus', [PurchaseOrderMainStatusController::class, 'purchaseordermainstatus'])->middleware('view_general_setting');
																											Route::get('/addpurchaseordermainstatus', [PurchaseOrderMainStatusController::class, 'addpurchaseordermainstatus'])->middleware('edit_general_setting');
																											Route::post('/addnewpurchaseordermainstatus',[PurchaseOrderMainStatusController::class, 'addnewpurchaseordermainstatus'] )->middleware('edit_general_setting');
																											Route::get('/editpurchaseordermainstatus/{id}',[PurchaseOrderMainStatusController::class, 'editpurchaseordermainstatus'])->middleware('edit_general_setting');
																											Route::post('/updatepurchaseordermainstatus', [PurchaseOrderMainStatusController::class, 'updatepurchaseordermainstatus'])->middleware('edit_general_setting');
																											Route::post('/deletepurchaseordermainstatus',[PurchaseOrderMainStatusController::class, 'deletepurchaseordermainstatus'])->middleware('edit_general_setting');
																											//end Purchase Order Status
																											
																						
																									// start of Product Order Status ....																								//locations
																											Route::get('/productorderstatus', [ProductOrderItemStatusController::class, 'productorderstatus'])->middleware('view_general_setting');
																											Route::get('/addproductorderstatus', [ProductOrderItemStatusController::class, 'addproductorderstatus'])->middleware('edit_general_setting');
																											Route::post('/addnewproductorderstatus',[ProductOrderItemStatusController::class, 'addnewproductorderstatus'] )->middleware('edit_general_setting');
																											Route::get('/editproductorderstatus/{id}',[ProductOrderItemStatusController::class, 'editproductorderstatus'])->middleware('edit_general_setting');
																											Route::post('/updateproductorderstatus', [ProductOrderItemStatusController::class, 'updateproductorderstatus'])->middleware('edit_general_setting');
																											Route::post('/deleteproductorderstatus',[ProductOrderItemStatusController::class, 'deleteproductorderstatus'])->middleware('edit_general_setting');
																											// end of Product Order Status
																						 
																											
																											// start of Purchase Order Status ....																								//locations
																											Route::get('/purchaseorderstatus', [PurchaseOrderItemStatusController::class, 'purchaseorderstatus'])->middleware('view_general_setting');
																											Route::get('/addpurchaseorderstatus', [PurchaseOrderItemStatusController::class, 'addpurchaseorderstatus'])->middleware('edit_general_setting');
																											Route::post('/addnewpurchaseorderstatus',[PurchaseOrderItemStatusController::class, 'addnewpurchaseorderstatus'] )->middleware('edit_general_setting');
																											Route::get('/editpurchaseorderstatus/{id}',[PurchaseOrderItemStatusController::class, 'editpurchaseorderstatus'])->middleware('edit_general_setting');
																											Route::post('/updatepurchaseorderstatus', [PurchaseOrderItemStatusController::class, 'updatepurchaseorderstatus'])->middleware('edit_general_setting');
																											Route::post('/deletepurchaseorderstatus',[PurchaseOrderItemStatusController::class, 'deletepurchaseorderstatus'])->middleware('edit_general_setting');
																											//end Purchase Order Status
																											

																											//Construction Resources
																											Route::get('/constructionresources', [ConstructionResourcesController::class, 'constructionresources'])->middleware('view_general_setting');
																											Route::get('/addconstructionresource', [ConstructionResourcesController::class, 'addconstructionresource'])->middleware('edit_general_setting');
																											Route::post('/addnewconstructionresource',[ConstructionResourcesController::class, 'addnewconstructionresource'] )->middleware('edit_general_setting');
																											Route::get('/editconstructionresource/{id}',[ConstructionResourcesController::class, 'editconstructionresource'])->middleware('edit_general_setting');
																											Route::post('/updateconstructionresource', [ConstructionResourcesController::class, 'updateconstructionresource'])->middleware('edit_general_setting');
																											Route::post('/deleteconstructionresource',[ConstructionResourcesController::class, 'deleteconstructionresource'])->middleware('edit_general_setting');
																												
																					
																					
																					
																					
																						// Promotional Banners
																											Route::get('/promotionalbanners', [PromotionalBannerController::class, 'promotionalbanners'])->middleware('view_general_setting');
																											Route::get('/addpromotionalbannerimage', [PromotionalBannerController::class, 'addpromotionalbannerimage'])->middleware('edit_general_setting');
																											Route::post('/addNewpromotionalbanner',[PromotionalBannerController::class, 'addNewpromotionalbanner'] )->middleware('edit_general_setting');
																											Route::get('/editpromotionalbanner/{id}',[PromotionalBannerController::class, 'editpromotionalbanner'])->middleware('edit_general_setting');
																											Route::post('/updatepromotionalbanner', [PromotionalBannerController::class, 'updatepromotionalbanner'])->middleware('edit_general_setting');
																											Route::post('/deletepromotionalbanner',[PromotionalBannerController::class, 'deletepromotionalbanner'])->middleware('edit_general_setting');
																	
																	
																		// widthdraw CashBacks Requests
																											Route::get('/widthdrawcashbacks', [WithdrawCashbackController::class, 'widthdrawcashbacks'])->middleware('view_general_setting');
																											Route::get('/editwidthdrawcashback/{id}',[WithdrawCashbackController::class, 'editwidthdrawcashbacks'])->middleware('edit_general_setting');
																											Route::post('/updatewidthdrawcashback', [WithdrawCashbackController::class, 'updatewidthdrawcashback'])->middleware('edit_general_setting');
																																					
																												
																											
																											
																										        //Clients
																											Route::get('/clients', [ClientController::class, 'clients'])->middleware('view_general_setting');
																											Route::get('/addclient', [ClientController::class, 'addclient'])->middleware('edit_general_setting');
																											Route::post('/addnewclient',[ClientController::class, 'addnewclient'] )->middleware('edit_general_setting');
																											Route::get('/editclient/{id}',[ClientController::class, 'editclient'])->middleware('edit_general_setting');
																											Route::post('/updateclient', [ClientController::class, 'updateclient'])->middleware('edit_general_setting');
																											Route::post('/deleteclient',[ClientController::class, 'deleteclient'])->middleware('edit_general_setting');
																											
																										
																										
																										
																													
																											//Distributors
																											Route::get('/distributors', [DistributorController::class, 'distributors'])->middleware('view_general_setting');
																											Route::get('/adddistributor', [DistributorController::class, 'adddistributor'])->middleware('edit_general_setting');
																											Route::post('/addnewdistributor',[DistributorController::class, 'addnewdistributor'] )->middleware('edit_general_setting');
																											Route::get('/editdistributor/{id}',[DistributorController::class, 'editdistributor'])->middleware('edit_general_setting');
																											Route::post('/updatedistributor', [DistributorController::class, 'updatedistributor'])->middleware('edit_general_setting');
																											Route::post('/deletedistributor',[DistributorController::class, 'deletedistributor'])->middleware('edit_general_setting');
																												
																											
																										
																											
																											//Projects
																											Route::get('/projects', [ProjectController::class, 'projects'])->middleware('view_general_setting');
																											Route::get('/addproject', [ProjectController::class, 'addproject'])->middleware('edit_general_setting');
																											Route::post('/addnewproject',[ProjectController::class, 'addnewproject'])->middleware('edit_general_setting');
																											Route::get('/editproject/{id}',[ProjectController::class, 'editproject'])->middleware('edit_general_setting');
																											Route::post('/updateproject',[ProjectController::class, 'updateproject'])->middleware('edit_general_setting');
																											Route::post('/deleteproject',[ProjectController::class, 'deleteproject'])->middleware('edit_general_setting');
																											Route::post('/addprojectdoc', [ProjectController::class, 'addprojectdoc'])->middleware('edit_general_setting');
																											Route::post('/addprojectfollowup', [ProjectController::class, 'addprojectfollowup'])->middleware('edit_general_setting');
																											Route::get('/editproject/downloaddocument/{id}', [ProjectController::class, 'downloaddocument'])->middleware('edit_general_setting');
																											Route::get('/editproject/downloadfollowupdocument/{id}', [ProjectController::class, 'downloadfollowupdocument'])->middleware('edit_general_setting');
																											
																											
																											
																												//Jobs
																											Route::get('/jobs', [JobController::class, 'jobs'])->middleware('view_general_setting');
																											Route::get('/addjob', [JobController::class, 'addjob'])->middleware('edit_general_setting');
																											Route::post('/addnewjob',[JobController::class, 'addnewjob'] )->middleware('edit_general_setting');
																											Route::get('/editjob/{id}',[JobController::class, 'editjob'])->middleware('edit_general_setting');
																											Route::post('/updatejob', [JobController::class, 'updatejob'])->middleware('edit_general_setting');
																											Route::post('/deletejob',[JobController::class, 'deletejob'])->middleware('edit_general_setting');
																											Route::get('/jobapplicants', [JobController::class, 'job_applicants'])->middleware('view_general_setting');
	
																											
																											
																											
																											//units
																											Route::get('/units',[SiteSettingController::class, 'units'])->middleware('view_general_setting');
																											Route::get('/addunit', [SiteSettingController::class, 'addunit'])->middleware('edit_general_setting');
																											Route::post('/addnewunit',[SiteSettingController::class, 'addnewunit'])->middleware('edit_general_setting');
																											Route::get('/editunit/{id}', [SiteSettingController::class, 'editunit'])->middleware('edit_general_setting');
																											Route::post('/updateunit',[SiteSettingController::class, 'updateunit'] )->middleware('edit_general_setting');
																											Route::post('/deleteunit',[SiteSettingController::class, 'deleteunit'])->middleware('edit_general_setting');
																											
																											
																											
																											
																											
																											
																											Route::get('/orderstatus', [SiteSettingController::class, 'orderstatus'])->middleware('view_general_setting');
																											Route::get('/addorderstatus', [SiteSettingController::class, 'addorderstatus'])->middleware('edit_general_setting');
																											Route::post('/addNewOrderStatus',[SiteSettingController::class, 'addNewOrderStatus'])->middleware('edit_general_setting');
																											Route::get('/editorderstatus/{id}',[SiteSettingController::class, 'editorderstatus'])->middleware('edit_general_setting');
																											Route::post('/updateOrderStatus',[SiteSettingController::class, 'updateOrderStatus'])->middleware('edit_general_setting');
																											Route::post('/deleteOrderStatus',[SiteSettingController::class, 'deleteOrderStatus'])->middleware('edit_general_setting');
																											
																											Route::get('/facebooksettings', [SiteSettingController::class, 'facebookSettings'])->middleware('view_general_setting');
																											Route::get('/instasettings',[SiteSettingController::class, 'instasettings'])->middleware('view_general_setting');
																											Route::get('/googlesettings', [SiteSettingController::class, 'googleSettings'])->middleware('view_general_setting');
																											//pushNotification
																											Route::get('/pushnotification', [SiteSettingController::class, 'pushNotification'])->middleware('view_general_setting');
																											Route::get('/alertsetting',[SiteSettingController::class, 'alertSetting'])->middleware('view_general_setting');
																											Route::post('/updateAlertSetting',[SiteSettingController::class, 'updateAlertSetting']);
																											Route::get('/setting', [SiteSettingController::class, 'setting'])->middleware('edit_general_setting');
																											Route::post('/updateSetting',[SiteSettingController::class, 'updateSetting'])->middleware('edit_general_setting');
																											
																											//admin managements
																											Route::get('/admins', [AdminController::class, 'admins'])->middleware('view_manage_admin');
																											Route::get('/addadmins',[AdminController::class, 'addadmins'])->middleware('add_manage_admin');
																											Route::post('/addnewadmin', [AdminController::class, 'addnewadmin'])->middleware('add_manage_admin');
																											Route::get('/editadmin/{id}',[AdminController::class, 'editadmin'])->middleware('edit_manage_admin');
																											Route::post('/updateadmin',[AdminController::class, 'updateadmin'])->middleware('edit_manage_admin');
																											Route::post('/deleteadmin',[AdminController::class, 'deleteadmin'])->middleware('delete_manage_admin');
																											
																											//admin managements
																											Route::get('/manageroles', [AdminController::class, 'manageroles'])->middleware('manage_role');
																											Route::get('/addrole/{id}',[AdminController::class, 'addrole'])->middleware('manage_role');
																											Route::post('/addnewroles', [AdminController::class, 'addnewroles'])->middleware('manage_role');
																											Route::get('/addadmintype',[AdminController::class, 'addadmintype'])->middleware('add_admin_type');
																											Route::post('/addnewtype', [AdminController::class, 'addnewtype'])->middleware('add_admin_type');
																											Route::get('/editadmintype/{id}', [AdminController::class, 'editadmintype'])->middleware('edit_admin_type');
																											Route::post('/updatetype', [AdminController::class, 'updatetype'])->middleware('edit_admin_type');
																											Route::post('/deleteadmintype',[AdminController::class, 'deleteadmintype'])->middleware('delete_admin_type');
																											
																											
																											Route::get('logout', [LoginController::class, 'logout']);
																											
																											
																												Route::get('/blockips', [AdminController::class, 'blockips'])->middleware('view_manage_admin');
																											Route::post('/deleteips',[AdminController::class, 'deleteips'])->middleware('edit_general_setting');
																												
																											Route::get('/productsforalllocations',[AdminController::class, 'productsforalllocations'])->middleware('edit_general_setting');
																												
																											//Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
		
																										});

																											/*  Route::group(['prefix' => 'admin/managements', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
																											 Route::get('/merge', 'ManagementsController@merge')->middleware('edit_management');
																											 Route::get('/backup', 'ManagementsController@backup')->middleware('edit_management');
																											 Route::post('/take_backup', 'ManagementsController@take_backup')->middleware('edit_management');
																											 Route::get('/import', 'ManagementsController@import')->middleware('edit_management');
																											 Route::post('/importdata', 'ManagementsController@importdata')->middleware('edit_management');
																											 Route::post('/mergecontent', 'ManagementsController@mergecontent')->middleware('edit_management');
																											 Route::get('/updater', 'ManagementsController@updater')->middleware('edit_management');
																											 Route::post('/checkpassword', 'ManagementsController@checkpassword')->middleware('edit_management');
																											 Route::post('/updatercontent', 'ManagementsController@updatercontent')->middleware('edit_management');
																											 });*/
		
		});
