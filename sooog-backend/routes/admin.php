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
	//Route::middleware(['api', 'SuperAdminMiddleware'])->group(function () {
		Route::middleware('auth:admin')->get('/admin-test', function (Request $request) {
		    return $request->user();
		});
	Route::group(["prefix" => "auth"], function() {
		Route::post("/login", \App\Admin\Actions\Auth\LoginAdminAction::class);
		Route::post("/forget-password", \App\Admin\Actions\Auth\ForgetPasswordAction::class);
		Route::post("/reset-password", \App\Admin\Actions\Auth\ResetPasswordAction::class);
	});

	Route::get("/pdf", \App\Order\Actions\ExportFinancialDuesToPdfAction::class)->name("FinancialDues.export_to_pdf");



	//Route::group(['middleware' => ['auth:admin']], function () {
	Route::middleware(['auth:admin', 'SuperAdminMiddleware', 'IsActiveAdmin'])->group(function () {
		Route::post("/auth/logout", \App\Admin\Actions\Auth\LogoutAdminAction::class);

		Route::group(["prefix" => "auth/profile"], function() {
			Route::put("/", \App\Admin\Actions\Auth\UpdateProfileAction::class)->name("admins.update_profile");
			Route::put("/change-password", \App\Admin\Actions\Auth\ChangePasswordAction::class)->name("admins.update_password");
		});

		Route::group(["prefix" => "uploader"], function() {
		    Route::post("/", \App\Uploader\Actions\API\UploadFileAction::class)->name("uploader.store");
		    Route::post("/multiple-files", \App\Uploader\Actions\API\UploadMultipleFilesAction::class)->name("uploader.multiple_files");
		    Route::post("/delete", \App\Uploader\Actions\API\DeleteFileAction::class)->name("uploader.destroy");
		});

		//location
		Route::group(["prefix" => "location"], function() {
			//countries
			Route::group(["prefix" => "/countries"], function() {
			    Route::get("/", \App\Location\Actions\ListCountriesAction::class)->name("countries.index")->middleware('can:countries.index');
			    Route::get("/{id}", \App\Location\Actions\ShowCountryAction::class)->name("countries.show");
			    Route::post("/", \App\Location\Actions\CreateCountryAction::class)->name("countries.store")->middleware('can:countries.create');
			    Route::put("/{id}/toggle-status", \App\Location\Actions\ToggleCountryStatusAction::class)->name("countries.toggle_status")->middleware('can:countries.update');
			    Route::put("/{id}", \App\Location\Actions\UpdateCountryAction::class)->name("countries.update")->middleware('can:countries.update');
			    Route::delete("/{id}", \App\Location\Actions\DeleteCountryAction::class)->name("countries.destroy")->middleware('can:countries.delete');
			});

			//states
			Route::group(["prefix" => "/states"], function() {
			    Route::get("/", \App\Location\Actions\ListStatesAction::class)->name("states.index")->middleware('can:states.index');
			    Route::get("/{id}", \App\Location\Actions\ShowStateAction::class)->name("states.show");
			    Route::post("/", \App\Location\Actions\CreateStateAction::class)->name("states.index")->middleware('can:states.create');
			    Route::put("/{id}", \App\Location\Actions\UpdateStateAction::class)->name("states.update")->middleware('can:states.update');
			    Route::put("/{id}/toggle-status", \App\Location\Actions\ToggleStateStatusAction::class)->name("states.toggle_status")->middleware('can:states.update');
			    Route::delete("/{id}", \App\Location\Actions\DeleteStateAction::class)->name("states.destroy")->middleware('can:states.delete');
			});

			//cities
			Route::group(["prefix" => "/cities"], function() {
			    Route::get("/", \App\Location\Actions\ListCitiesAction::class)->name("cities.index")->middleware('can:cities.index');
			    Route::get("/{id}", \App\Location\Actions\ShowCityAction::class)->name("cities.show");
			    Route::post("/", \App\Location\Actions\CreateCityAction::class)->name("cities.index")->middleware('can:cities.create');
			    Route::put("/{id}", \App\Location\Actions\UpdateCityAction::class)->name("cities.update")->middleware('can:cities.update');
			    Route::put("/{id}/toggle-status", \App\Location\Actions\ToggleCityStatusAction::class)->name("cities.toggle_status")->middleware('can:cities.update');
			    Route::delete("/{id}", \App\Location\Actions\DeleteCityAction::class)->name("cities.destroy")->middleware('can:cities.delete');
			});
	    });

		Route::delete("/attachments/{id}", \App\Uploader\Actions\DeleteAttachmentAction::class);

		Route::group(["prefix" => "permissions"], function() {
		    Route::get("/", \App\Admin\Actions\Permission\ListPermissionsAction::class)->name("permissions.index");
		});

		Route::group(["prefix" => "roles"], function() {
		    Route::get("/", \App\Admin\Actions\Permission\ListRolesAction::class)->name("roles.index")->middleware('can:roles.index');
		    Route::get("/{id}", \App\Admin\Actions\Permission\ShowRoleAction::class)->name("roles.show");
		    Route::delete("/{id}", \App\Admin\Actions\Permission\DeleteRoleAction::class)->name("roles.destroy")->middleware('can:roles.delete');
		    Route::put("/{id}/toggle-status", \App\Admin\Actions\Permission\ToggleRoleStatusAction::class)->name("roles.toggle_status")->middleware('can:roles.update');
		    Route::post("/", \App\Admin\Actions\Permission\CreateRoleAction::class)->name("roles.store")->middleware('can:roles.create');
		    Route::put("/{id}", \App\Admin\Actions\Permission\UpdateRoleAction::class)->name("roles.update")->middleware('can:roles.update');
		});

		Route::group(["prefix" => "admins"], function() {
		    Route::get("/", \App\Admin\Actions\Admin\ListAdminsAction::class)->name("admins.index")->middleware('can:admins.index');
		    Route::get("/export-to-excel", \App\Admin\Actions\Admin\ExportAdminsToExcelAction::class)->name("admins.export")->middleware('can:admins.index');
		    Route::get("/{id}", \App\Admin\Actions\Admin\GetAdminAction::class)->name("admins.show");
		    Route::post("/", \App\Admin\Actions\Admin\CreateAdminAction::class)->name("admins.store")->middleware('can:admins.create');
		    Route::put("/{id}", \App\Admin\Actions\Admin\UpdateAdminAction::class)->name("admins.update")->middleware('can:admins.update');
		    Route::delete("/{id}", \App\Admin\Actions\Admin\DeleteAdminAction::class)->name("admins.destroy")->middleware('can:admins.delete');
		    Route::put("/{id}/toggle-status", \App\Admin\Actions\Admin\ToggleAdminStatusAction::class)->name("admins.toggle_status")->middleware('can:admins.update');
		    // Route::post("/{id}/permissions", \App\Admin\Actions\Admin\AssignPermissionsToAdminAction::class)->name("admins.assignPermissions");
		    
		});

		Route::group(["prefix" => "pages"], function() {
		    Route::get("/", \App\AppContent\Actions\Page\ListPagesAction::class)->name("pages.index")->middleware('can:pages.index');
		    Route::get("/{slug}", \App\AppContent\Actions\Page\GetPageAction::class)->name("pages.index");
		    Route::put("/{slug}", \App\AppContent\Actions\Page\UpdatePageAction::class)->name("pages.update")->middleware('can:pages.index');
		});

		Route::group(["prefix" => "settings"], function() {
		    Route::get("/", \App\AppContent\Actions\Setting\GetSettingsAction::class)->name("settings.index")->middleware('can:settings.index');
		    Route::post("/", \App\AppContent\Actions\Setting\UpdateSettingsAction::class)->name("settings.store")->middleware('can:settings.index');
		});

		Route::group(["prefix" => "slides"], function() {
		    Route::get("/",  \App\Ad\Actions\ListAdsAction::class)->name("ads.index")->middleware('can:ads.index');
		    Route::get("/{id}", \App\Ad\Actions\ShowAdAction::class)->name("ads.show");
		    Route::post("/", \App\Ad\Actions\CreateAdAction::class)->name("ads.store")->middleware('can:ads.create');
		    Route::put("/{id}", \App\Ad\Actions\UpdateAdAction::class)->name("ads.update")->middleware('can:ads.update');
		    Route::delete("/{id}", \App\Ad\Actions\DeleteAdAction::class)->name("ads.destroy")->middleware('can:ads.delete');
		    Route::put("/{id}/toggle-status", \App\Ad\Actions\ToggleAdStatusAction::class)->name("ads.toggle_status")->middleware('can:ads.update');
		});

		Route::group(["prefix" => "categories"], function() {
		    Route::get("/", \App\Category\Actions\ListCategoriesAction::class)->name("categories.index");
		    Route::get("/{id}", \App\Category\Actions\ShowCategoryAction::class)->name("categories.show");
		    Route::post("/", \App\Category\Actions\CreateCategoryAction::class)->name("categories.store");
		    Route::put("/{id}", \App\Category\Actions\UpdateCategoryAction::class)->name("categories.update");
		    Route::delete("/{id}", \App\Category\Actions\DeleteCategoryAction::class)->name("categories.destroy");
		    Route::put("/{id}/toggle-status", \App\Category\Actions\ToggleCategoryStatusAction::class)->name("categories.toggle_status");
		});
		Route::get("/subcategories", \App\Category\Actions\ListSubCategoriesAction::class)->name("subcategories.index");

		Route::group(["prefix" => "warranties"], function() {
		    Route::get("/", \App\Warranty\Actions\ListWarrantiesAction::class)->name("warranties.index")->middleware('can:warranties.index');
		    Route::get("/{id}", \App\Warranty\Actions\ShowWarrantyAction::class)->name("warranties.show");
		    Route::post("/", \App\Warranty\Actions\CreateWarrantyAction::class)->name("warranties.store")->middleware('can:warranties.create');
		    Route::put("/{id}", \App\Warranty\Actions\UpdateWarrantyAction::class)->name("warranties.update")->middleware('can:warranties.update');
		    Route::delete("/{id}", \App\Warranty\Actions\DeleteWarrantyAction::class)->name("warranties.destroy")->middleware('can:warranties.delete');
		    Route::put("/{id}/toggle-status", \App\Warranty\Actions\ToggleWarrantyStatusAction::class)->name("warranties.toggle_status")->middleware('can:warranties.update');
		});

		Route::group(["prefix" => "brands"], function() {
		    Route::get("/", \App\Brand\Actions\ListBrandsAction::class)->name("brands.index")->middleware('can:brands.index');
		    Route::get("/{id}", \App\Brand\Actions\ShowBrandAction::class)->name("brands.show");
		    Route::post("/", \App\Brand\Actions\CreateBrandAction::class)->name("brands.store")->middleware('can:brands.create');
		    Route::put("/{id}", \App\Brand\Actions\UpdateBrandAction::class)->name("brands.update")->middleware('can:brands.update');
		    Route::delete("/{id}", \App\Brand\Actions\DeleteBrandAction::class)->name("brands.destroy")->middleware('can:brands.delete');
		    Route::put("/{id}/toggle-status", \App\Brand\Actions\ToggleBrandStatusAction::class)->name("brands.toggle_status")->middleware('can:brands.update');
		});

		Route::group(["prefix" => "packages"], function() {
		    Route::get("/", \App\Package\Actions\ListPackagesAction::class)->name("packages.index")->middleware('can:packages.index');
		    Route::get("/{id}", \App\Package\Actions\ShowPackageAction::class)->name("packages.show");
		    Route::post("/", \App\Package\Actions\CreatePackageAction::class)->name("packages.store")->middleware('can:packages.create');
		    Route::put("/{id}", \App\Package\Actions\UpdatePackageAction::class)->name("packages.update")->middleware('can:packages.update');
		    Route::delete("/{id}", \App\Package\Actions\DeletePackageAction::class)->name("packages.destroy")->middleware('can:packages.delete');
		    Route::put("/{id}/toggle-status", \App\Package\Actions\TogglePackageStatusAction::class)->name("packages.toggle_status")->middleware('can:packages.update');
		});

		Route::group(["prefix" => "promo-codes"], function() {
		    Route::get("/", \App\PromoCode\Actions\ListPromoCodesAction::class)->name("promo_codes.index")->middleware('can:promo_codes.index');
		    Route::get("/export-to-excel", \App\PromoCode\Actions\ExportPromoCodesToExcelAction::class)->name("promo_codes.export")->middleware('can:promo_codes.index');

		    Route::get("/{id}", \App\PromoCode\Actions\ShowPromoCodeAction::class)->name("promo_codes.show");

		    Route::post("/", \App\PromoCode\Actions\CreatePromoCodeAction::class)->name("promo_codes.store")->middleware('can:promo_codes.create');

		    Route::put("/{id}", \App\PromoCode\Actions\UpdatePromoCodeAction::class)->name("promo_codes.update")->middleware('can:promo_codes.update');

		    Route::delete("/{id}", \App\PromoCode\Actions\DeletePromoCodeAction::class)->name("promo_codes.destroy")->middleware('can:promo_codes.delete');

		    Route::put("/{id}/toggle-status", \App\PromoCode\Actions\TogglePromoCodeStatusAction::class)->name("promo_codes.toggle_status")->middleware('can:promo_codes.update');

		});

		Route::group(["prefix" => "stores"], function() {
		    Route::get("/", \App\Store\Actions\ListStoresAction::class)->name("stores.index");
		    Route::get("/list-temp-store", \App\Store\Actions\ListStoresTempAction::class)->name("stores.temp-index");
		    Route::get("/export-to-excel", \App\Store\Actions\ExportStoresToExcelAction::class)->name("stores.export");
		    Route::post("/featured", \App\Store\Actions\SetFeaturedStoresAction::class)->name("stores.featured");
		    Route::get("/temp-stores/{id}", \App\Store\Actions\ShowStoreTempAction::class)->name("stores.get-temp");
		    Route::post("/temp-stores", \App\Store\Actions\TempStoreActionAction::class)->name("stores.update-temp");
		    Route::get("/{id}", \App\Store\Actions\ShowStoreAction::class)->name("stores.show");
		    Route::post("/", \App\Store\Actions\CreateStoreAction::class)->name("stores.store");
		    Route::put("/{id}", \App\Store\Actions\UpdateStoreAction::class)->name("stores.update");
		    Route::put("/{id}/toggle-status", \App\Store\Actions\ToggleStoreStatusAction::class)->name("stores.toggle_status");
		});

		Route::get("/property-types", \App\Property\Actions\ListPropertyTypesAction::class)->name("property_types.index");
		Route::get("/category-properties/{id}", \App\Property\Actions\ListCategoryPropertiesAction::class)->name("properties.index");

		Route::group(["prefix" => "properties"], function() {
		    Route::get("/", \App\Property\Actions\ListPropertiesAction::class)->name("properties.index")->middleware('can:properties.index');
		    Route::get("/{id}", \App\Property\Actions\ShowPropertyAction::class)->name("properties.show");
		    Route::post("/", \App\Property\Actions\CreatePropertyAction::class)->name("properties.create")->middleware('can:properties.create');
		    Route::put("/{id}", \App\Property\Actions\UpdatePropertyAction::class)->name("properties.update")->middleware('can:properties.update');
		    Route::put("/{id}/toggle-status", \App\Property\Actions\TogglePropertyStatusAction::class)->name("properties.toggle_status")->middleware('can:properties.update');
		    Route::delete("/{id}", \App\Property\Actions\DeletePropertyAction::class)->name("properties.destroy")->middleware('can:properties.delete');
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

		Route::group(["prefix" => "ratings"], function() {
		    Route::get("/", \App\Product\Actions\Rating\ListCommentsAction::class)->name("comments.index")->middleware('can:comments.index');
		    Route::put("/{id}/toggle-status", \App\Product\Actions\Rating\UpdateCommentStatusAction::class)->name("comments.update")->middleware('can:comments.update');
		});

		Route::group(["prefix" => "offers"], function() {
		    Route::get("/", \App\Offer\Actions\ListOffersAction::class)->name("offers.index")->middleware('can:offers.index');
		    Route::get("/{id}", \App\Offer\Actions\ShowOfferAction::class)->name("offers.show");
		    Route::post("/", \App\Offer\Actions\CreateOfferAction::class)->name("offers.Offer")->middleware('can:offers.create');
		    Route::delete("/{id}", \App\Offer\Actions\DeleteOfferAction::class)->name("offers.destroy");
		    Route::put("/{id}", \App\Offer\Actions\UpdateOfferAction::class)->name("offers.create")->middleware('can:offers.update');
		    Route::put("/{id}/toggle-status", \App\Offer\Actions\ToggleOfferStatusAction::class)->name("offers.toggle_status")->middleware('can:offers.update');
		});

		Route::group(["prefix" => "users"], function() {
		    Route::get("/", \App\User\Actions\User\ListUsersAction::class)->name("users.index")->middleware('can:users.index');
		    Route::get("/export-to-excel", \App\User\Actions\User\ExportUsersToExcelAction::class)->name("users.export")->middleware('can:users.index');
		    Route::get("/{id}", \App\User\Actions\User\ShowUserAction::class)->name("users.show");
		    Route::post("/", \App\User\Actions\User\CreateUserAction::class)->name("users.store")->middleware('can:users.create');
		    Route::put("/{id}", \App\User\Actions\User\UpdateUserAction::class)->name("users.update")->middleware('can:users.update');
		    Route::delete("/{id}", \App\User\Actions\User\DeleteUserAction::class)->name("users.destroy")->middleware('can:users.delete');
		    Route::put("/{id}/toggle-status", \App\User\Actions\User\ToggleUserStatusAction::class)->name("users.toggle_status")->middleware('can:users.update');
		    Route::get("/{id}/addresses", \App\User\Actions\User\ListUserAddressesAction::class)->name("users.addresses");

		 //    Route::group(["prefix" => "/{user_id}/transactions"], function() {
			//     Route::get("/", \App\Order\Actions\Transaction\ListTransactionsAction::class)->name("transactions.index")->middleware('can:index,App\Order\Domain\Models\Transaction');
			//     Route::post("/", \App\Order\Actions\Transaction\CreateTransactionAction::class)->name("transactions.store")->middleware('can:create,App\Order\Domain\Models\Transaction');
			// });

			Route::group(["prefix" => "/{user_id}/transactions"], function() {
			    Route::get("/", \App\Order\Actions\Transaction\ListTransactionsAction::class)->name("transactions.index");
			    Route::post("/", \App\Order\Actions\Transaction\CreateTransactionAction::class)->name("transactions.store");
			});

		});

		Route::group(["prefix" => "refund-reasons"], function() {
		    Route::get("/",  \App\Refund\Actions\RefundReason\ListRefundReasonsAction::class)->name("refund_reasons.index")->middleware('can:refund_reasons.index');
		    Route::get("/export-to-excel", \App\Refund\Actions\RefundReason\ExportRefundReasonsToExcelAction::class)->name("refund_reasons.export")->middleware('can:refund_reasons.index');
		    Route::get("/{id}", \App\Refund\Actions\RefundReason\ShowRefundReasonAction::class)->name("refund_reasons.show");
		    Route::post("/", \App\Refund\Actions\RefundReason\CreateRefundReasonAction::class)->name("refund_reasons.store")->middleware('can:refund_reasons.create');
		    Route::put("/{id}", \App\Refund\Actions\RefundReason\UpdateRefundReasonAction::class)->name("refund_reasons.update")->middleware('can:refund_reasons.update');
		    Route::delete("/{id}", \App\Refund\Actions\RefundReason\DeleteRefundReasonAction::class)->name("refund_reasons.destroy")->middleware('can:refund_reasons.delete');
		    Route::put("/{id}/toggle-status", \App\Refund\Actions\RefundReason\ToggleRefundReasonStatusAction::class)->middleware('can:refund_reasons.update');
		});

		Route::get("/statuses",  \App\Order\Actions\ListOrderStatusesAction::class)->name("statuses.index");
		Route::get("payment-methods", \App\Order\Actions\PaymentMethod\ListPaymentMethodsAction::class)->name("payment_methods.index");
        Route::put("payment-methods/{id}/toggle-status", \App\Order\Actions\Payments\TogglePaymentStatusAction::class);

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
		    Route::post("/{id}/refund", \App\Refund\Actions\RefundOrderAction::class)->name("orders.refund")->middleware('can:refunds.create');
		});
		Route::group(["prefix" => "refunds"], function() {
		    Route::get("/",  \App\Refund\Actions\ListRefundsAction::class)->name("refunds.index")->middleware('can:refunds.index');
		    Route::post("/",  \App\Refund\Actions\CreateRefundAction::class)->name("refunds.store")->middleware('can:refunds.create');
		    Route::get("/statuses",  \App\Refund\Actions\ListRefundStatusesAction::class)->name("srefund_tatuses.index");
		    Route::get("/export-to-excel", \App\Refund\Actions\ExportRefundsToExcelAction::class)->name("refunds.export")->middleware('can:refunds.index');
		    Route::put("/{id}/change-status", \App\Refund\Actions\UpdateRefundStatusAction::class)->name("orderefundsrs.change_status")->middleware('can:refunds.update');
		    Route::get("/{id}", \App\Refund\Actions\ShowRefundAction::class)->name("refunds.show");
		    

		});

		Route::get("/statistics", \App\AppContent\Actions\Statistics\GetStatisticsAction::class)->name("statistics.index");


		Route::group(["prefix" => "contact-us"], function() {
		    Route::get("/", \App\AppContent\Actions\ContactUs\ListContactUsAction::class)->name("contact_us.index")->middleware('can:contact_us.index');
		    Route::get("/export-to-excel", \App\AppContent\Actions\ContactUs\ExportContactUsToExcelAction::class)->name("contact_us.export")->middleware('can:contact_us.index');
		    Route::post("/", \App\AppContent\Actions\ContactUs\CreateContactUsAction::class)->name("contact_us.store")->middleware('can:contact_us.create');
		    Route::get("/{id}", \App\AppContent\Actions\ContactUs\ShowContactUsAction::class)->name("contact_us.show");
		    Route::put("/{id}", \App\AppContent\Actions\ContactUs\UpdateContactUsAction::class)->name("contact_us.update")->middleware('can:contact_us.update');
		    Route::delete("/{id}", \App\AppContent\Actions\ContactUs\DeleteContactUsAction::class)->name("contact_us.destroy")->middleware('can:contact_us.delete');
		});

		Route::group(["prefix" => "bank-accounts"], function() {
		    Route::get("/", \App\BankAccount\Actions\ListBankAccountsAction::class)->name("bank_accounts.index")->middleware('can:bank_accounts.index');
		    Route::get("/{id}", \App\BankAccount\Actions\ShowBankAccountAction::class)->name("bank_accounts.show");
		    Route::post("/", \App\BankAccount\Actions\CreateBankAccountAction::class)->name("bank_accounts.store")->middleware('can:bank_accounts.create');
		    Route::put("/{id}", \App\BankAccount\Actions\UpdateBankAccountAction::class)->name("bank_accounts.update")->middleware('can:bank_accounts.update');
		    Route::delete("/{id}", \App\BankAccount\Actions\DeleteBankAccountAction::class)->name("bank_accounts.destroy")->middleware('can:bank_accounts.delete');
		    Route::put("/{id}/toggle-status", \App\BankAccount\Actions\ToggleBankAccountStatusAction::class)->name("bank_accounts.toggle_status")->middleware('can:bank_accounts.update');
		});

		Route::group(["prefix" => "notifications"], function() {
		    Route::get("/",  \App\Notification\Actions\ListNotificationsAction::class)->name("notifications.index");
		    Route::get("/{id}", \App\Notification\Actions\GetNotificationAction::class)->name("notifications.show");
		    Route::post("/", \App\Notification\Actions\SendNotificationAction::class)->name("notifications.store");
		    Route::delete("/{id}", \App\Notification\Actions\DeleteNotificationAction::class)->name("notifications.destroy");
		});
		Route::group(["prefix" => "banners"], function() {
		    Route::get("/",  \App\Banner\Actions\ListBannersAction::class)->name("banners.index");
		    Route::get("/{id}", \App\Banner\Actions\ShowBannerAction::class)->name("banners.show");
//            Route::post("/", \App\Banner\Actions\CreateAdAction::class)->name("ads.store")->middleware('can:ads.create');
            Route::put("/{id}", \App\Banner\Actions\UpdateBannerAction::class)->name("banners.update");
//		    Route::post("/", \App\Notification\Actions\SendNotificationAction::class)->name("notifications.store");
//		    Route::delete("/{id}", \App\Notification\Actions\DeleteNotificationAction::class)->name("notifications.destroy");
		});

		//Route::get("/financial-dues",  \App\Order\Actions\ListFinancialDuesAction::class);

		Route::group(["prefix" => "financial-dues"], function() {
		    Route::get("/",  \App\Order\Actions\ListFinancialDuesAction::class);
		    Route::get("/export-to-excel", \App\Order\Actions\ExportFinancialDuesToExcelAction::class)->name("FinancialDues.export_to_excel");
		    Route::get("/export-to-pdf", \App\Order\Actions\ExportFinancialDuesToPdfAction::class)->name("FinancialDues.export_to_pdf");
		});

		Route::group(["prefix" => "payments"], function() {
		    Route::get("/",  \App\Order\Actions\Payments\ListPaymentsAction::class)->name("payments.index");
		    Route::get("/export-to-excel", \App\Order\Actions\Payments\ExportPaymentsToExcelAction::class)->name("payments.export_to_excel");
		    Route::get("/export-to-pdf", \App\Order\Actions\Payments\ExportPaymentsToPdfAction::class)->name("payments.export_to_pdf");
		    Route::get("/{id}",  \App\Order\Actions\Payments\ShowPaymentAction::class)->name("payments.show");
		    Route::post("/", \App\Order\Actions\Payments\CreatePaymentAction::class)->name("payments.store");
		});


	});
});

