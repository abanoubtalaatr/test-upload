<?php

use App\RequestOfferQuantity\Actions\Api\Store\DetailsReplyRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\User\AcceptReplyRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\User\CreateRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\User\DetailsRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\User\ListRepliesRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\User\ListRequestOfferQuantityAction;
use App\RequestOfferQuantity\Actions\Api\User\RejectReplyRequestOfferQuantityAction;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function () {
    Route::group(["prefix" => "packages"], function () {
        Route::get("/", \App\Package\Actions\ListPackagesAction::class)->name("packages.index");
        Route::get("/{id}", \App\Package\Actions\ShowPackageAction::class)->name("packages.show");
//        Route::post("/subscribe", \App\Package\Actions\SubscribePackageAction::class)->name("packages.subscribe");
    });
    //slug in ['terms-conditions , about-us']
    Route::get("pages/{slug}", \App\AppContent\Actions\Page\GetPageAction::class)->name("pages.index");
    Route::group(["prefix" => "auth"], function () {
        Route::post('/register', \App\User\Actions\Auth\RegisterUserAction::class);
        Route::post('/resend-verification-code', \App\User\Actions\Auth\ResendVerificationCodeAction::class);
        Route::get('/verification-code', \App\User\Actions\Auth\GetVerificationCodeAction::class);
        Route::post('/verify-account', \App\User\Actions\Auth\VerifyAccountAction::class);
        Route::post("/login", \App\User\Actions\Auth\LoginUserAction::class);
        Route::post("/forget-password", \App\User\Actions\Auth\ForgetUserPasswordAction::class);
        Route::post("/verify-token", \App\User\Actions\Auth\VerifyResetUserPasswordCodeAction::class);
        Route::post("/reset-password", \App\User\Actions\Auth\ResetUserPasswordAction::class);
    });

    Route::group(["prefix" => "location"], function () {
        Route::get("/countries", \App\Location\Actions\ListCountriesAction::class)->name("api.countries.index");
        Route::get("/states", \App\Location\Actions\ListStatesAction::class)->name("states.index");
        Route::get("/cities", \App\Location\Actions\ListCitiesAction::class)->name("cities.index");
        Route::get("/countries/{id}/states", \App\Location\Actions\ListStatesAction::class)->name("api.states.index");
        Route::get("/states/{id}/cities", \App\Location\Actions\ListCitiesAction::class)->name("api.cities.index");
    });

    Route::group(["prefix" => "categories"], function () {
        Route::get("/", \App\Category\Actions\ListCategoriesAction::class)->name("categories.index");
        Route::get("/all", \App\Category\Actions\ListAllCategoriesAction::class)->name("categories.all");
        Route::get("/{id}/sub-categories", \App\Category\Actions\RetrieveAllSubCategoriesAction::class)->name("categories.sub_categories.all");
    });

    Route::get("/sub-categories", \App\Category\Actions\ListSubCategoriesAction::class)->name("sub_categories.index");

    Route::get("/brands", \App\Brand\Actions\ListBrandsAction::class)->name("api.brands.index");
    Route::post("contact-us/", \App\AppContent\Actions\ContactUs\CreateContactUsAction::class)->name("contact_us.store");
    Route::get("contact-types", \App\AppContent\Actions\ContactUs\ListContactTypesAction::class)->name("contact_types.index");

    // Route::get("/shipping-companies",  \App\Order\Actions\ShippingCompany\ListShippingCompaniesAction::class)->name("shipping_companies.index");

    // Route::post("contact_us/", \App\AppContent\Actions\API\CreateContactUsAction::class)->name("contact_us.store");

    Route::get("/stores", \App\Store\Actions\ListStoresAction::class)->name("stores.index");
    Route::post("/stores", \App\Store\Actions\CreateStoreAction::class)->name("stores.store");


    Route::group(["prefix" => "products"], function () {
        Route::get("/", \App\Product\Actions\ListProductsAction::class)->name("products.index");
        Route::get("/most-selling", \App\Product\Actions\ListMostSellingProductsAction::class)->name("products.most_selling");
        Route::get("/suggestions", \App\Product\Actions\ListMostSellingProductsAction::class)->name("products.suggestions");
        Route::get("/{id}", \App\Product\Actions\ShowProductAction::class)->name("products.show");
        Route::get("/{id}/ratings", \App\Product\Actions\Rating\ListProductRatingsAction::class)->name("ratings.list");

    });

    Route::group(["prefix" => "offers"], function () {
        Route::get("/", \App\Offer\Actions\ListOfferProductsAction::class)->name("offers.index");
    });

    Route::group(["prefix" => "slides"], function () {
        Route::get("/", \App\Ad\Actions\ListAdsAction::class)->name("slides.index");
    });
    Route::group(["prefix" => "banners"], function () {
        Route::get("/", \App\Banner\Actions\ListBannersAction::class)->name("banners.index");
    });

    //Route::post("contact-us", \App\AppContent\Actions\API\CreateContactUsAction::class)->name("contact_us.store");

    Route::get("/settings", \App\AppContent\Actions\Setting\GetSettingsAction::class)->name("settings.index");
    Route::get("/warranties", \App\Warranty\Actions\ListWarrantiesAction::class)->name("warranties.index");

    //Route::get("/contacts", \App\AppContent\Actions\API\GetContactsAction::class)->name("settings.contacts.index");

    //Route::get("/panners", \App\AppContent\Actions\API\GetPannersAction::class)->name("panners.index");

    Route::group(['middleware' => ['IsActiveUser', 'auth:api']], function () {
        Route::post("/auth/logout", \App\User\Actions\Auth\LogoutUserAction::class);
        Route::group(["prefix" => "/profile"], function () {
            Route::post("/change-password", \App\User\Actions\User\ChangePasswordAction::class);
            Route::get("/", \App\User\Actions\User\GetProfileAction::class);
            Route::put("/", \App\User\Actions\User\UpdateUserProfileAction::class);
            Route::post('/verify-phone', \App\User\Actions\User\UpdatePhoneAction::class);
            Route::group(["prefix" => "/user-addresses"], function () {
                Route::get("/", \App\User\Actions\UserAddress\ListUserAddressesAction::class);
                Route::post("/", \App\User\Actions\UserAddress\CreateUserAddressAction::class);
                Route::get("/{id}", \App\User\Actions\UserAddress\ShowUserAddressAction::class);
                Route::put("/{id}", \App\User\Actions\UserAddress\UpdateUserAddressAction::class);
                Route::delete("/{id}", \App\User\Actions\UserAddress\DeleteUserAddressAction::class);
            });
        });

        Route::group(["prefix" => "chats"], function () {
            Route::get("/", \App\Chat\Actions\ListChatsAction::class)->name("chats.index");
            Route::get("/{id}", \App\Chat\Actions\GetChatAction::class)->name("chats.show");
            Route::post("/send", \App\Chat\Actions\SendMessageAction::class)->name("chats.send");
        });

        Route::group(["prefix" => "favourites"], function () {
            Route::get("/", \App\Product\Actions\Favourite\ListUserFavouritesAction::class)->name("favourites.index");
            Route::post("/", \App\Product\Actions\Favourite\AddProductToFavouriteAction::class)->name("favourites.store");
            Route::delete("/", \App\Product\Actions\Favourite\DeleteProductFromFavouriteAction::class)->name("favourites.destroy");
        });

        Route::group(["prefix" => "ratings"], function () {
            Route::post("/", \App\Product\Actions\Rating\AddRateAction::class)->name("ratings.store");
            Route::put("/", \App\Product\Actions\Rating\UpdateRateAction::class)->name("ratings.update");
            Route::delete("/", \App\Product\Actions\Rating\DeleteRateAction::class)->name("ratings.destroy");
        });


        Route::post("check-coupon", \App\PromoCode\Actions\CheckPromoCodeAction::class)->name("promo_codes.check");

        Route::get("refund-reasons", \App\Refund\Actions\RefundReason\ListRefundReasonsAction::class)->name("refund_reasons.index");
        Route::get("payment-methods", \App\Order\Actions\PaymentMethod\ListPaymentMethodsAction::class)->name("payment_methods.index");
        Route::get("online-payment-methods", \App\Order\Actions\PaymentMethod\ListOnlinePaymentMethodsAction::class)->name("online-payment_methods.index");

        Route::group(["prefix" => "orders"], function () {
            Route::get("/", \App\Order\Actions\ListOrdersAction::class)->name("orders.index");
            Route::post("/", \App\Order\Actions\CreateOrderAction::class)->name("orders.store");
            Route::post("/service", \App\Order\Actions\CreateServiceOrderAction::class)->name("orders.store");
            Route::get("/{id}", \App\Order\Actions\ShowOrderAction::class)->name("orders.show");
            Route::post("/{id}/refund", \App\Refund\Actions\RefundOrderAction::class)->name("orders.refund");
            Route::put("/{id}/change-status", \App\Order\Actions\UpdateUserOrderStatusAction::class)->name("orders.change_status");
            Route::post("/preview", \App\Order\Actions\PreviewOrderAction::class)->name("orders.preview");
        });

        Route::group(["prefix" => "cart"], function () {
            Route::get("/", \App\Order\Actions\Cart\ListUserCartAction::class)->name("cart.index");
            Route::post("/", \App\Order\Actions\Cart\AddToCartAction::class)->name("cart.store");
            Route::put("/", \App\Order\Actions\Cart\UpdateCartAction::class)->name("cart.update");
            Route::delete("/", \App\Order\Actions\Cart\DeleteFromCartAction::class)->name("cart.destroy");
        });

        Route::get("bank-accounts", \App\BankAccount\Actions\ListBankAccountsAction::class)->name("bank_accounts.index");

        Route::group(["prefix" => "user-notifications"], function () {
            Route::get("/", \App\User\Actions\Notifications\ListUserNotificationsAction::class);
            Route::get("/count", \App\User\Actions\Notifications\GetUnreadUserNotificationsAction::class);
        });

        Route::get("user-transactions", \App\Order\Actions\Transaction\ListUserTransactionsAction::class)->name("transactions.index");

    });
    Route::get("check-payment", \App\Order\Actions\PaymentMethod\CheckPaymentAction::class)->name("check-payment");
    Route::group(["prefix" => "uploader"], function () {
        Route::post("/", \App\Uploader\Actions\API\UploadFileAction::class)->name("uploader.store");
        Route::post("/multiple-files", \App\Uploader\Actions\API\UploadMultipleFilesAction::class)->name("uploader.multiple_files");
        Route::post("/delete", \App\Uploader\Actions\API\DeleteFileAction::class)->name("uploader.destroy");
    });
    Route::get('hyperPayView/{for}/{order}', App\Order\Actions\PaymentMethod\HyperPayPaymentAction::class)->name('hyperPay');
    Route::get('test', function () {
        dd(\Illuminate\Support\Facades\Crypt::encrypt());
    });
});

Route::group(["prefix" => "request-offer-quantity", 'name' => 'request.offer.quantity.'], function () {
    Route::post('/', CreateRequestOfferQuantityAction::class)
        ->name('store');

    Route::get('/{id}', DetailsRequestOfferQuantityAction::class)
        ->name('details');

    Route::get('/', ListRequestOfferQuantityAction::class)
        ->name('list');

    Route::get('/{id}/replies', ListRepliesRequestOfferQuantityAction::class)
        ->name('replies');

    Route::patch('/accept', AcceptReplyRequestOfferQuantityAction::class)
        ->name('accept');

    Route::patch('/reject', RejectReplyRequestOfferQuantityAction::class)
        ->name('reject');

    Route::get('reply/{id}', DetailsReplyRequestOfferQuantityAction::class)
        ->name('details.reply');

});
