<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'api'], function() {
//Route::middleware(['api', 'CenterMiddleware'])->group(function () {
		Route::middleware('auth:center')->get('/admin-test', function (Request $request) {
		    return $request->user();
		});
	Route::group(["prefix" => "auth"], function() {
		Route::post("/login", \App\Store\Actions\Auth\LoginCenterAction::class);
		Route::post("/forget-password", \App\Store\Actions\Auth\ForgetPasswordAction::class);
		Route::post("/reset-password", \App\Store\Actions\Auth\ResetPasswordAction::class);
	});

	//Route::group(['middleware' => ['auth:center']], function () {
	Route::middleware(['auth:center', 'CenterMiddleware', 'IsActiveAdmin'])->group(function () {
		Route::get("/statistics", \App\AppContent\Actions\Statistics\GetStatisticsAction::class)->name("statistics.index");
		Route::post("/auth/logout", \App\Store\Actions\Auth\LogoutCenterAction::class);

		Route::group(["prefix" => "auth/profile"], function() {
			Route::put("/", \App\Store\Actions\Auth\UpdateProfileAction::class)->name("admins.update_profile");
			Route::put("/change-password", \App\Store\Actions\Auth\ChangePasswordAction::class)->name("admins.update_password");
		});

		Route::group(["prefix" => "uploader"], function() {
		    Route::post("/", \App\Uploader\Actions\API\UploadFileAction::class)->name("uploader.store");
		    Route::post("/multiple-files", \App\Uploader\Actions\API\UploadMultipleFilesAction::class)->name("uploader.multiple_files");
		    Route::post("/delete", \App\Uploader\Actions\API\DeleteFileAction::class)->name("uploader.destroy");
		});
		
		Route::get("/settings", \App\AppContent\Actions\Setting\GetSettingsAction::class)->name("settings.index");

		//location
		Route::group(["prefix" => "location"], function() {
			//countries
			Route::group(["prefix" => "/countries"], function() {
			    Route::get("/", \App\Location\Actions\ListCountriesAction::class)->name("countries.index");
			    Route::get("/{id}", \App\Location\Actions\ShowCountryAction::class)->name("countries.show");
			    Route::post("/", \App\Location\Actions\CreateCountryAction::class)->name("countries.store");
			    Route::put("/{id}/toggle-status", \App\Location\Actions\ToggleCountryStatusAction::class)->name("countries.toggle_status");
			    Route::put("/{id}", \App\Location\Actions\UpdateCountryAction::class)->name("countries.update");
			    Route::delete("/{id}", \App\Location\Actions\DeleteCountryAction::class)->name("countries.destroy");
			});

			//states
			Route::group(["prefix" => "/states"], function() {
			    Route::get("/", \App\Location\Actions\ListStatesAction::class)->name("states.index");
			    Route::get("/{id}", \App\Location\Actions\ShowStateAction::class)->name("states.show");
			    Route::post("/", \App\Location\Actions\CreateStateAction::class)->name("states.index");
			    Route::put("/{id}", \App\Location\Actions\UpdateStateAction::class)->name("states.update");
			    Route::put("/{id}/toggle-status", \App\Location\Actions\ToggleStateStatusAction::class)->name("states.toggle_status");
			    Route::delete("/{id}", \App\Location\Actions\DeleteStateAction::class)->name("states.destroy");
			});

			//cities
			Route::group(["prefix" => "/cities"], function() {
			    Route::get("/", \App\Location\Actions\ListCitiesAction::class)->name("cities.index");
			    Route::get("/{id}", \App\Location\Actions\ShowCityAction::class)->name("cities.update");
			    Route::post("/", \App\Location\Actions\CreateCityAction::class)->name("cities.index");
			    Route::put("/{id}", \App\Location\Actions\UpdateCityAction::class)->name("cities.update");
			    Route::put("/{id}/toggle-status", \App\Location\Actions\ToggleCityStatusAction::class)->name("cities.toggle_status");
			    Route::delete("/{id}", \App\Location\Actions\DeleteCityAction::class)->name("cities.destroy");
			});
	    });

		Route::delete("/attachments/{id}", \App\Uploader\Actions\DeleteAttachmentAction::class);

		Route::group(["prefix" => "permissions"], function() {
		    Route::get("/", \App\Admin\Actions\Permission\ListPermissionsAction::class)->name("permissions.index");
		});

		Route::group(["prefix" => "roles"], function() {
		    Route::get("/", \App\Admin\Actions\Permission\ListRolesAction::class)->name("roles.index");
		    Route::get("/{id}", \App\Admin\Actions\Permission\ShowRoleAction::class)->name("roles.show");
		    Route::delete("/{id}", \App\Admin\Actions\Permission\DeleteRoleAction::class)->name("roles.destroy");
		    Route::put("/{id}/toggle-status", \App\Admin\Actions\Permission\ToggleRoleStatusAction::class)->name("roles.toggle_status");
		    Route::post("/", \App\Admin\Actions\Permission\CreateRoleAction::class)->name("roles.store");
		    Route::put("/{id}", \App\Admin\Actions\Permission\UpdateRoleAction::class)->name("roles.update");
		});

		Route::group(["prefix" => "admins"], function() {
		    Route::get("/", \App\Admin\Actions\Admin\ListAdminsAction::class)->name("admins.index");
		    Route::get("/export-to-excel", \App\Admin\Actions\Admin\ExportAdminsToExcelAction::class)->name("admins.export");
		    Route::get("/{id}", \App\Admin\Actions\Admin\GetAdminAction::class)->name("admins.show");
		    Route::post("/", \App\Admin\Actions\Admin\CreateAdminAction::class)->name("admins.store");
		    Route::put("/{id}", \App\Admin\Actions\Admin\UpdateAdminAction::class)->name("admins.update");
		    Route::delete("/{id}", \App\Admin\Actions\Admin\DeleteAdminAction::class)->name("admins.destroy");
		    Route::put("/{id}/toggle-status", \App\Admin\Actions\Admin\ToggleAdminStatusAction::class)->name("admins.toggle_status");
		    // Route::post("/{id}/permissions", \App\Admin\Actions\Admin\AssignPermissionsToAdminAction::class)->name("admins.assignPermissions");
		    
		});

		Route::get("/statuses",  \App\Order\Actions\ListOrderStatusesAction::class)->name("statuses.index");
		Route::get("payment-methods", \App\Order\Actions\PaymentMethod\ListPaymentMethodsAction::class)->name("payment_methods.index");

		Route::group(["prefix" => "orders"], function() {
		    Route::get("/",  \App\Order\Actions\ListOrdersAction::class)->name("orders.index")->middleware('can:orders.index');
		    Route::get("/export-to-excel", \App\Order\Actions\ExportOrdersToExcelAction::class)->name("orders.export")->middleware('can:orders.index');
		    Route::put("/{id}/change-status", \App\Order\Actions\UpdateOrderStatusAction::class)->name("orders.change_status")->middleware('can:orders.update');
		    Route::put("/change-statuses", \App\Order\Actions\UpdateOrdersStatusAction::class)->name("orders.change_status")->middleware('can:orders.update');
		    Route::get("/{id}", \App\Order\Actions\ShowOrderAction::class)->name("orders.show");
		    Route::post("/", \App\Order\Actions\CreateOrderAction::class)->name("orders.store")->middleware('can:orders.create');
		    Route::put("/{id}", \App\Order\Actions\UpdateOrderAction::class)->name("orders.update")->middleware('can:orders.update');
		    Route::put("/service/{id}", \App\Order\Actions\UpdateServiceOrderAction::class)->name("serice_orders.update")->middleware('can:orders.update');
		    Route::delete("/{id}", \App\Order\Actions\DeleteOrderAction::class)->name("orders.destroy")->middleware('can:orders.delete');
		});


		Route::group(["prefix" => "pages"], function() {
		    Route::get("/", \App\AppContent\Actions\Page\ListPagesAction::class)->name("pages.index");
		    Route::get("/{slug}", \App\AppContent\Actions\Page\GetPageAction::class)->name("pages.index");
		    Route::put("/{slug}", \App\AppContent\Actions\Page\UpdatePageAction::class)->name("pages.update");
		});

		Route::group(["prefix" => "settings"], function() {
		    Route::get("/", \App\AppContent\Actions\Setting\GetSettingsAction::class)->name("settings.index");
		    Route::post("/", \App\AppContent\Actions\Setting\UpdateSettingsAction::class)->name("settings.store");
		});

		Route::group(["prefix" => "ads"], function() {
		    Route::get("/",  \App\Ad\Actions\ListAdsAction::class)->name("ads.index");
		    Route::get("/{id}", \App\Ad\Actions\ShowAdAction::class)->name("ads.show");
		    Route::post("/", \App\Ad\Actions\CreateAdAction::class)->name("ads.store");
		    Route::put("/{id}", \App\Ad\Actions\UpdateAdAction::class)->name("ads.update");
		    Route::delete("/{id}", \App\Ad\Actions\DeleteAdAction::class)->name("ads.destroy");
		    Route::put("/{id}/toggle-status", \App\Ad\Actions\ToggleAdStatusAction::class)->name("ads.toggle_status");
		});

		Route::group(["prefix" => "categories"], function() {
		    Route::get("/", \App\Category\Actions\ListCategoriesAction::class)->name("categories.index");
		    Route::get("/{id}", \App\Category\Actions\ShowCategoryAction::class)->name("categories.show");
		    Route::get("/{id}/subcategories", \App\Category\Actions\ListSubCategoriesAction::class)->name("categories.subcategories.index");
		    Route::post("/", \App\Category\Actions\CreateCategoryAction::class)->name("categories.store");
		    Route::put("/{id}", \App\Category\Actions\UpdateCategoryAction::class)->name("categories.update");
		    Route::delete("/{id}", \App\Category\Actions\DeleteCategoryAction::class)->name("categories.destroy");
		    Route::put("/{id}/toggle-status", \App\Category\Actions\ToggleCategoryStatusAction::class)->name("categories.toggle_status");
		});

		Route::group(["prefix" => "warranties"], function() {
		    Route::get("/", \App\Warranty\Actions\ListWarrantiesAction::class)->name("warranties.index");
		    Route::get("/{id}", \App\Warranty\Actions\ShowWarrantyAction::class)->name("warranties.show");
		    Route::post("/", \App\Warranty\Actions\CreateWarrantyAction::class)->name("warranties.store");
		    Route::put("/{id}", \App\Warranty\Actions\UpdateWarrantyAction::class)->name("warranties.update");
		    Route::delete("/{id}", \App\Warranty\Actions\DeleteWarrantyAction::class)->name("warranties.destroy");
		    Route::put("/{id}/toggle-status", \App\Warranty\Actions\ToggleWarrantyStatusAction::class)->name("warranties.toggle_status");
		});

		Route::group(["prefix" => "brands"], function() {
		    Route::get("/", \App\Brand\Actions\ListBrandsAction::class)->name("brands.index");
		    Route::get("/{id}", \App\Brand\Actions\ShowBrandAction::class)->name("brands.show");
		    Route::post("/", \App\Brand\Actions\CreateBrandAction::class)->name("brands.store");
		    Route::put("/{id}", \App\Brand\Actions\UpdateBrandAction::class)->name("brands.update");
		    Route::delete("/{id}", \App\Brand\Actions\DeleteBrandAction::class)->name("brands.destroy");
		    Route::put("/{id}/toggle-status", \App\Brand\Actions\ToggleBrandStatusAction::class)->name("brands.toggle_status");
		});

		Route::group(["prefix" => "promo-codes"], function() {
		    Route::get("/", \App\PromoCode\Actions\ListPromoCodesAction::class)->name("promo_codes.index");
		    Route::get("/export-to-excel", \App\PromoCode\Actions\ExportPromoCodesToExcelAction::class)->name("promo_codes.export");
		    Route::get("/{id}", \App\PromoCode\Actions\ShowPromoCodeAction::class)->name("promo_codes.show");
		    Route::post("/", \App\PromoCode\Actions\CreatePromoCodeAction::class)->name("promo_codes.store");
		    Route::put("/{id}", \App\PromoCode\Actions\UpdatePromoCodeAction::class)->name("promo_codes.update");
		    Route::delete("/{id}", \App\PromoCode\Actions\DeletePromoCodeAction::class)->name("promo_codes.destroy");
		    Route::put("/{id}/toggle-status", \App\PromoCode\Actions\TogglePromoCodeStatusAction::class)->name("promo_codes.toggle_status");
		});

		Route::group(["prefix" => "stores"], function() {
		    Route::get("/", \App\Store\Actions\ListStoresAction::class)->name("stores.index");
		    Route::get("/export-to-excel", \App\Store\Actions\ExportStoresToExcelAction::class)->name("stores.export");
		    Route::post("/featured", \App\Store\Actions\SetFeaturedStoresAction::class)->name("stores.featured");
		    Route::get("/{id}", \App\Store\Actions\ShowStoreAction::class)->name("stores.show");
		    Route::post("/", \App\Store\Actions\CreateStoreAction::class)->name("stores.store");
		    Route::put("/{id}", \App\Store\Actions\UpdateStoreAction::class)->name("stores.update");
		    Route::put("/{id}/toggle-status", \App\Store\Actions\ToggleStoreStatusAction::class)->name("stores.toggle_status");
		});

		Route::get("/property-types", \App\Property\Actions\ListPropertyTypesAction::class)->name("property_types.index");
		Route::get("/category-properties/{id}", \App\Property\Actions\ListCategoryPropertiesAction::class)->name("properties.index");

		Route::group(["prefix" => "properties"], function() {
		    Route::get("/", \App\Property\Actions\ListPropertiesAction::class)->name("properties.index");
		    Route::get("/{id}", \App\Property\Actions\ShowPropertyAction::class)->name("properties.show");
		    Route::post("/", \App\Property\Actions\CreatePropertyAction::class)->name("properties.Property");
		    Route::put("/{id}", \App\Property\Actions\UpdatePropertyAction::class)->name("properties.update");
		    Route::put("/{id}/toggle-status", \App\Property\Actions\TogglePropertyStatusAction::class)->name("properties.toggle_status");
		});

		Route::group(["prefix" => "products"], function() {
		    Route::get("/", \App\Product\Actions\ListProductsAction::class)->name("products.index");
		    Route::get("/{id}", \App\Product\Actions\ShowProductAction::class)->name("products.show");
		    Route::post("/", \App\Product\Actions\CreateProductAction::class)->name("products.create");
		    Route::put("/{id}", \App\Product\Actions\UpdateProductAction::class)->name("products.update");
		    Route::put("/{id}/toggle-status", \App\Product\Actions\ToggleProductStatusAction::class)->name("products.toggle_status");
		    Route::delete("/{id}", \App\Product\Actions\DeleteProductAction::class)->name("products.destroy");
            Route::delete("/unit/{id}", \App\Product\Actions\DeleteProductUnitAction::class)->name("products-units.destroy");
		});

		Route::group(["prefix" => "offers"], function() {
		    Route::get("/", \App\Offer\Actions\ListOffersAction::class)->name("offers.index");
		    Route::get("/{id}", \App\Offer\Actions\ShowOfferAction::class)->name("offers.show");
		    Route::post("/", \App\Offer\Actions\CreateOfferAction::class)->name("offers.Offer");
		    Route::put("/{id}", \App\Offer\Actions\UpdateOfferAction::class)->name("offers.update");
		    Route::put("/{id}/toggle-status", \App\Offer\Actions\ToggleOfferStatusAction::class)->name("offers.toggle_status");
		});

		Route::group(["prefix" => "users"], function() {
		    Route::get("/", \App\User\Actions\User\ListUsersAction::class)->name("users.index");
		    Route::get("/export-to-excel", \App\User\Actions\User\ExportUsersToExcelAction::class)->name("users.export");
		    Route::get("/{id}", \App\User\Actions\User\ShowUserAction::class)->name("users.show");
		    Route::post("/", \App\User\Actions\User\CreateUserAction::class)->name("users.store");
		    Route::put("/{id}", \App\User\Actions\User\UpdateUserAction::class)->name("users.update");
		    Route::delete("/{id}", \App\User\Actions\User\DeleteUserAction::class)->name("users.destroy");
		    Route::put("/{id}/toggle-status", \App\User\Actions\User\ToggleUserStatusAction::class)->name("users.toggle_status");
		    Route::get("/{id}/addresses", \App\User\Actions\User\ListUserAddressesAction::class)->name("users.addresses");
		});

	});
});

