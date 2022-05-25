<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\RequestOfferQuantity\Actions\Api\Store\UpdateReplyRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\Store\CreateReplayRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\Store\DeliveredRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\Store\DetailsReplyRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\Store\DetailsRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\Store\ExportRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\Store\ListRepliesForRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\Store\NewRequestOfferQuantityAction;


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

Route::group(['middleware' => 'api'], function () {
//Route::middleware(['api', 'StoreMiddleware'])->group(function () {
    Route::middleware('auth:store')->get('/admin-test', function (Request $request) {
        return $request->user();
    });
    Route::group(["prefix" => "auth"], function () {
        Route::post("/login", \App\Store\Actions\Auth\LoginAdminAction::class);
        Route::post("/forget-password", \App\Store\Actions\Auth\ForgetPasswordAction::class);
        Route::post("/reset-password", \App\Store\Actions\Auth\ResetPasswordAction::class);
    });
    Route::get("/brands", \App\Brand\Actions\ListBrandsAction::class)->name("brands.index");
    Route::get("/users", \App\User\Actions\User\ListUsersAction::class)->name("users.index");
    Route::get("/stores", \App\Store\Actions\ListStoresAction::class)->name("stores.index");
    Route::get("/settings", \App\AppContent\Actions\Setting\GetSettingsAction::class)->name("settings.index");

    Route::group(["prefix" => "packages"], function () {
        Route::get("/", \App\Package\Actions\ListPackagesAction::class)->name("packages.index");
        Route::get("/{id}", \App\Package\Actions\ShowPackageAction::class)->name("packages.show");
        Route::post("/subscribe", \App\Package\Actions\SubscribePackageAction::class)->name("packages.subscribe");
    });

    //Route::group(['middleware' => ['auth:store']], function () {
    Route::middleware(['auth:store', 'StoreMiddleware', 'IsActiveAdmin'])->group(function () {
        Route::get("/statistics", \App\AppContent\Actions\Statistics\GetStatisticsAction::class)->name("statistics.index");
        Route::post("/auth/logout", \App\Store\Actions\Auth\LogoutAdminAction::class);

        Route::group(["prefix" => "auth/profile"], function () {
            Route::get("/{id}", \App\Store\Actions\ShowStoreAction::class);
            Route::put("/", \App\Store\Actions\Auth\UpdateProfileAction::class)->name("admins.update_profile");
            Route::put("/bank-setting", \App\Store\Actions\Auth\UpdateBankDataAction::class)->name("admins.update_bank-setting");
            Route::put("/change-password", \App\Store\Actions\Auth\ChangePasswordAction::class)->name("admins.update_password");
        });
        Route::get("online-payment-methods", \App\Order\Actions\PaymentMethod\ListOnlinePaymentMethodsAction::class)->name("online-payment_methods.index");
        Route::group(["prefix" => "uploader"], function () {
            Route::post("/", \App\Uploader\Actions\API\UploadFileAction::class)->name("uploader.store");
            Route::post("/multiple-files", \App\Uploader\Actions\API\UploadMultipleFilesAction::class)->name("uploader.multiple_files");
            Route::post("/delete", \App\Uploader\Actions\API\DeleteFileAction::class)->name("uploader.destroy");
        });

        //location
        Route::group(["prefix" => "location"], function () {
            //countries
            Route::group(["prefix" => "/countries"], function () {
                Route::get("/", \App\Location\Actions\ListCountriesAction::class)->name("countries.index");
            });

            //states
            Route::group(["prefix" => "/states"], function () {
                Route::get("/", \App\Location\Actions\ListStatesAction::class)->name("states.index");
            });

            //cities
            Route::group(["prefix" => "/cities"], function () {
                Route::get("/", \App\Location\Actions\ListCitiesAction::class)->name("cities.index");
            });
        });

        Route::delete("/attachments/{id}", \App\Uploader\Actions\DeleteAttachmentAction::class);

        Route::group(["prefix" => "permissions"], function () {
            Route::get("/", \App\Admin\Actions\Permission\ListPermissionsAction::class)->name("permissions.index");
        });

        Route::group(["prefix" => "roles"], function () {
            Route::get("/", \App\Admin\Actions\Permission\ListRolesAction::class)->name("roles.index");
            Route::get("/{id}", \App\Admin\Actions\Permission\ShowRoleAction::class)->name("roles.show");
            Route::delete("/{id}", \App\Admin\Actions\Permission\DeleteRoleAction::class)->name("roles.destroy");
            Route::put("/{id}/toggle-status", \App\Admin\Actions\Permission\ToggleRoleStatusAction::class)->name("roles.toggle_status");
            Route::post("/", \App\Admin\Actions\Permission\CreateRoleAction::class)->name("roles.store");
            Route::put("/{id}", \App\Admin\Actions\Permission\UpdateRoleAction::class)->name("roles.update");
        });
        Route::group(["prefix" => "chats"], function () {
            Route::get("/", \App\Chat\Actions\ListChatsAction::class)->name("chats.index");
            Route::get("/{id}", \App\Chat\Actions\GetChatAction::class)->name("chats.show");
            Route::post("/send", \App\Chat\Actions\SendMessageAction::class)->name("chats.send");
        });

        Route::group(["prefix" => "admins"], function () {
            Route::get("/", \App\Admin\Actions\Admin\ListAdminsAction::class)->name("admins.index");
            Route::get("/export-to-excel", \App\Admin\Actions\Admin\ExportAdminsToExcelAction::class)->name("admins.export");
            Route::get("/{id}", \App\Admin\Actions\Admin\GetAdminAction::class)->name("admins.show");
            Route::post("/", \App\Admin\Actions\Admin\CreateAdminAction::class)->name("admins.store");
            Route::put("/{id}", \App\Admin\Actions\Admin\UpdateAdminAction::class)->name("admins.update");
            Route::delete("/{id}", \App\Admin\Actions\Admin\DeleteAdminAction::class)->name("admins.destroy");
            Route::put("/{id}/toggle-status", \App\Admin\Actions\Admin\ToggleAdminStatusAction::class)->name("admins.toggle_status");
            // Route::post("/{id}/permissions", \App\Admin\Actions\Admin\AssignPermissionsToAdminAction::class)->name("admins.assignPermissions");

        });

        Route::get("/statuses", \App\Order\Actions\ListOrderStatusesAction::class)->name("statuses.index");
        Route::get("payment-methods", \App\Order\Actions\PaymentMethod\ListPaymentMethodsAction::class)->name("payment_methods.index");


        Route::group(["prefix" => "categories"], function () {
            Route::get("/", \App\Category\Actions\ListCategoriesAction::class)->name("categories.index");
            Route::get("/{id}", \App\Category\Actions\ShowCategoryAction::class)->name("categories.show");
            Route::get("/{id}/subcategories", \App\Category\Actions\ListSubCategoriesAction::class)->name("categories.subcategories.index");
            Route::post("/", \App\Category\Actions\CreateCategoryAction::class)->name("categories.store");
            Route::put("/{id}", \App\Category\Actions\UpdateCategoryAction::class)->name("categories.update");
            Route::delete("/{id}", \App\Category\Actions\DeleteCategoryAction::class)->name("categories.destroy");
            Route::put("/{id}/toggle-status", \App\Category\Actions\ToggleCategoryStatusAction::class)->name("categories.toggle_status");
        });

        Route::get("/subcategories", \App\Category\Actions\ListSubCategoriesAction::class)->name("subcategories.index");

        Route::group(["prefix" => "warranties"], function () {
            Route::get("/", \App\Warranty\Actions\ListWarrantiesAction::class)->name("warranties.index");
            Route::get("/{id}", \App\Warranty\Actions\ShowWarrantyAction::class)->name("warranties.show");
            Route::post("/", \App\Warranty\Actions\CreateWarrantyAction::class)->name("warranties.store");
            Route::put("/{id}", \App\Warranty\Actions\UpdateWarrantyAction::class)->name("warranties.update");
            Route::delete("/{id}", \App\Warranty\Actions\DeleteWarrantyAction::class)->name("warranties.destroy");
            Route::put("/{id}/toggle-status", \App\Warranty\Actions\ToggleWarrantyStatusAction::class)->name("warranties.toggle_status");
        });

        Route::group(["prefix" => "promo-codes"], function () {
            Route::get("/", \App\PromoCode\Actions\ListPromoCodesAction::class)->name("promo_codes.index");
            Route::get("/export-to-excel", \App\PromoCode\Actions\ExportPromoCodesToExcelAction::class)->name("promo_codes.export");
            Route::get("/{id}", \App\PromoCode\Actions\ShowPromoCodeAction::class)->name("promo_codes.show");
            Route::post("/", \App\PromoCode\Actions\CreatePromoCodeAction::class)->name("promo_codes.store");
            Route::put("/{id}", \App\PromoCode\Actions\UpdatePromoCodeAction::class)->name("promo_codes.update");
            Route::delete("/{id}", \App\PromoCode\Actions\DeletePromoCodeAction::class)->name("promo_codes.destroy");
            Route::put("/{id}/toggle-status", \App\PromoCode\Actions\TogglePromoCodeStatusAction::class)->name("promo_codes.toggle_status");
        });

        Route::get("/property-types", \App\Property\Actions\ListPropertyTypesAction::class)->name("property_types.index");
        Route::get("/category-properties/{id}", \App\Property\Actions\ListCategoryPropertiesAction::class)->name("properties.index");

        Route::group(["prefix" => "properties"], function () {
            Route::get("/", \App\Property\Actions\ListPropertiesAction::class)->name("properties.index");
            Route::get("/{id}", \App\Property\Actions\ShowPropertyAction::class)->name("properties.show");
            Route::post("/", \App\Property\Actions\CreatePropertyAction::class)->name("properties.Property");
            Route::put("/{id}", \App\Property\Actions\UpdatePropertyAction::class)->name("properties.update");
            Route::put("/{id}/toggle-status", \App\Property\Actions\TogglePropertyStatusAction::class)->name("properties.toggle_status");
        });

        Route::group(["prefix" => "products"], function () {
            Route::get("/", \App\Product\Actions\ListProductsAction::class)->name("products.index");
            Route::get("/{id}", \App\Product\Actions\ShowProductAction::class)->name("products.show");
            Route::post("/", \App\Product\Actions\CreateProductAction::class)->name("products.create");
            Route::put("/{id}", \App\Product\Actions\UpdateProductAction::class)->name("products.update");
            Route::put("/{id}/toggle-status", \App\Product\Actions\ToggleProductStatusAction::class)->name("products.toggle_status");
            Route::delete("/{id}", \App\Product\Actions\DeleteProductAction::class)->name("products.destroy");
            Route::delete("/unit/{id}", \App\Product\Actions\DeleteProductUnitAction::class)->name("products-units.destroy");

        });
        Route::get("/most-selling", \App\Product\Actions\ListMost10SellingForStoreProductsAction::class)->name('products.most-sell-store');
        Route::group(["prefix" => "offers"], function () {
            Route::get("/", \App\Offer\Actions\ListOffersAction::class)->name("offers.index");
            Route::get("/{id}", \App\Offer\Actions\ShowOfferAction::class)->name("offers.show");
            Route::post("/", \App\Offer\Actions\CreateOfferAction::class)->name("offers.Offer");
            Route::put("/{id}", \App\Offer\Actions\UpdateOfferAction::class)->name("offers.update");
            Route::put("/{id}/toggle-status", \App\Offer\Actions\ToggleOfferStatusAction::class)->name("offers.toggle_status");
            Route::delete("/{id}", \App\Offer\Actions\DeleteOfferAction::class)->name("offers.destroy");
        });

        Route::group(["prefix" => "orders"], function () {
            Route::get("/", \App\Order\Actions\ListOrdersAction::class)->name("orders.index")->middleware('can:orders.index');
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
        Route::group(["prefix" => "refunds"], function () {
            Route::get("/", \App\Refund\Actions\ListRefundsAction::class)->name("refunds.index")->middleware('can:refunds.index');
            Route::post("/", \App\Refund\Actions\CreateRefundAction::class)->name("refunds.store")->middleware('can:refunds.create');
            Route::get("/statuses", \App\Refund\Actions\ListRefundStatusesAction::class)->name("srefund_tatuses.index");
            Route::get("/export-to-excel", \App\Refund\Actions\ExportRefundsToExcelAction::class)->name("refunds.export")->middleware('can:refunds.index');
            Route::put("/{id}/change-status", \App\Refund\Actions\UpdateRefundStatusAction::class)->name("orderefundsrs.change_status")->middleware('can:refunds.update');
            Route::get("/{id}", \App\Refund\Actions\ShowRefundAction::class)->name("refunds.show");

        });
        Route::group(["prefix" => "refund-reasons"], function () {
            Route::get("/", \App\Refund\Actions\RefundReason\ListRefundReasonsAction::class)->name("refund_reasons.index");

        });


    });

});


Route::group(["prefix" => "request-offer-quantity", 'name' => 'request.offer.quantity.'], function () {

    Route::get('/export-to-excel', ExportRequestOfferQuantityAction::class)
        ->name('export');

    Route::get('/', NewRequestOfferQuantityAction::class)
        ->name('index');

    Route::get('/{id}', DetailsRequestOfferQuantityAction::class)
        ->name('show');

    Route::group(['prefix' => '/reply', 'name' => 'reply.'], function () {
        Route::post('/', CreateReplayRequestOfferQuantityAction::class)
            ->name('store');

        Route::get('/list', ListRepliesForRequestOfferQuantityAction::class)
            ->name('list');

        Route::patch('/delivered', DeliveredRequestOfferQuantityAction::class)
            ->name('delivered');

        Route::patch('/update', UpdateReplyRequestOfferQuantityAction::class)
            ->name('update');

        Route::get('/{id}', DetailsReplyRequestOfferQuantityAction::class)
            ->name('details');

    });
});
