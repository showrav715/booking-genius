<?php

use App\Http\Controllers\Admin\AdminLanguageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OtherController;
use App\Http\Controllers\Admin\HotelAttrController;
use App\Http\Controllers\Admin\AttrTremController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CarAttrController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CarOrderController;
use App\Http\Controllers\Admin\CarTermController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\HotelRoomAttrController;
use App\Http\Controllers\Admin\HotelRoomController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\HotelOrderController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PageSettingController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SeoToolController;
use App\Http\Controllers\Admin\SocialSettingController;
use App\Http\Controllers\Admin\SpaceAttrController;
use App\Http\Controllers\Admin\SpaceController;
use App\Http\Controllers\Admin\SpaceOrderController;
use App\Http\Controllers\Admin\SpaceTermController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\TourAttrController;
use App\Http\Controllers\Admin\TourCategoryController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TourOrderController;
use App\Http\Controllers\Admin\TourTermController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Admin\WithdrawMethodsController;
use App\Http\Controllers\Front\FrontendController;
use App\Http\Controllers\User\BulkDeleteController;
use App\Http\Controllers\User\CarController as UserCarController;
use App\Http\Controllers\User\CarOrderController as UserCarOrderController;
use App\Http\Controllers\User\ForgotController;
use App\Http\Controllers\User\HotelController as UserHotelController;
use App\Http\Controllers\User\HotelOrderController as UserHotelOrderController;
use App\Http\Controllers\User\HotelRoomController as UserHotelRoomController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\NotificationController as UserNotificationController;
use App\Http\Controllers\User\OrderHistoryController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\SocialRegisterController;
use App\Http\Controllers\User\SpaceController as UserSpaceController;
use App\Http\Controllers\User\SpaceOrderController as UserSpaceOrderController;
use App\Http\Controllers\User\TourController as UserTourController;
use App\Http\Controllers\User\TourOrderController as UserTourOrderController;
use App\Http\Controllers\User\UserController as UserUserController;
use App\Http\Controllers\User\WithdrawController as UserWithdrawController;
use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Checkout\TourCheckoutController;
use App\Http\Controllers\Checkout\HotelCheckoutController;
use App\Http\Controllers\Checkout\SpaceCheckoutController;
use App\Http\Controllers\Checkout\CarCheckoutController;
use App\Http\Controllers\Front\OfflinePayment;
use App\Http\Controllers\Front\ReviewController as FrontReviewController;
use App\Http\Controllers\Front\StripeController;
use App\Http\Controllers\Payment\CarOfflineController;
use App\Http\Controllers\Payment\CarStripeController;
use App\Http\Controllers\Payment\SpaceOfflineController;
use App\Http\Controllers\Payment\SpaceStripeController;
use App\Http\Controllers\Payment\TourOfflineController;
use App\Http\Controllers\Payment\TourStripeController;
use App\Http\Controllers\Payment\TourInstamojoController;
use App\Http\Controllers\Payment\TourMollieController;
use App\Http\Controllers\Payment\SpaceInstamojoController;
use App\Http\Controllers\Payment\SpaceMollieController;
use App\Http\Controllers\Payment\HotelInstamojoController;
use App\Http\Controllers\Payment\CarInstamojoController;
use App\Http\Controllers\Payment\CarMollieController;
use App\Http\Controllers\Payment\HotelRezorpayController;
use App\Http\Controllers\Payment\CarRezorpayController;
use App\Http\Controllers\Payment\SpaceRezorpayController;
use App\Http\Controllers\Payment\TourRezorpayController;
use App\Http\Controllers\Payment\TourPaypalController;
use App\Http\Controllers\Payment\SpacePaypalController;
use App\Http\Controllers\Payment\HotelPaypalController;
use App\Http\Controllers\Payment\HotelMollieController;
use App\Http\Controllers\Payment\CarPaypalController;
use App\Http\Controllers\Payment\TourAuthorizeController;
use App\Http\Controllers\Payment\SpaceAuthorizeController;
use App\Http\Controllers\Payment\HotelAuthorizeController;
use App\Http\Controllers\Payment\CarAuthorizeController;
use App\Http\Controllers\Payment\HotelPaystackController;
use App\Http\Controllers\Payment\TourPaystackController;
use App\Http\Controllers\Payment\SpacePaystackController;
use App\Http\Controllers\Payment\CarPaystackController;
use App\Http\Controllers\Payment\HotelMercadopagoController;
use App\Http\Controllers\Payment\TourMercadopagoController;
use App\Http\Controllers\Payment\SpaceMercadopagoController;
use App\Http\Controllers\Payment\CarMercadopagoController;
use Illuminate\Support\Facades\Route;


Route::get('location/state/ajax/{id}', [OtherController::class, 'getAjax']);
Route::get('location/state/update/{id}', [OtherController::class, 'updateState']);

// Admin Login Section
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login/submit', [LoginController::class, 'login'])->name('admin.login.submit');
Route::get('/forgot', [LoginController::class, 'showForgotForm'])->name('admin.forgot');
Route::post('/forgot', [LoginController::class, 'forgot'])->name('admin.forgot.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::prefix('admin')->group(function () {
// Admin Profile Section
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/profile', [DashboardController::class, 'profile'])->name('admin.profile');
Route::post('/profile/update', [DashboardController::class, 'profileupdate'])->name('admin.profile.update');
Route::get('/password', [DashboardController::class, 'passwordreset'])->name('admin.password');
Route::post('/password/update', [DashboardController::class, 'changepass'])->name('admin.password.update');

// ADMIN NOTIFICATION SECTION
Route::get('/conv/notf/show', [NotificationController::class, 'conv_notf_show'])->name('conv-notf-show');
Route::get('/conv/notf/count', [NotificationController::class, 'conv_notf_count'])->name('conv-notf-count');
Route::get('/conv/notf/clear', [NotificationController::class, 'conv_notf_clear'])->name('conv-notf-clear');
// ADMIN NOTIFICATION SECTION END

// ADMIN NOTIFICATION SECTION
Route::get('notification/count', [NotificationController::class, 'notf_count'])->name('notification-count');
Route::get('notification/show', [NotificationController::class, 'notf_show'])->name('order-notf-show');
Route::get('notification/clear', [NotificationController::class, 'notf_clear'])->name('order-notf-clear');
// ADMIN NOTIFICATION SECTION END

Route::get('/data/bulk/delete', [BulkDeleteController::class, 'bulkdelete'])->name('admin.bulk.delete');

Route::group(['middleware' => 'permissions:Hotel Section'], function () {

    // HOTEL ATTRIBUTES SECTION
    Route::get('/hotel/attribute/datatables', [HotelAttrController::class, 'datatables'])->name('admin-hotelattr-datatables');
    Route::get('/hotel/attribute', [HotelAttrController::class, 'index'])->name('admin-hotelattr-index');
    Route::get('/hotel/attribute/create', [HotelAttrController::class, 'create'])->name('admin-hotelattr-create');
    Route::post('/hotel/attribute/create', [HotelAttrController::class, 'store'])->name('admin-hotelattr-store');
    Route::get('/hotel/attribute/edit/{id}', [HotelAttrController::class, 'edit'])->name('admin-hotelattr-edit');
    Route::post('/hotel/attribute/update/{id}', [HotelAttrController::class, 'update'])->name('admin-hotelattr-update');
    Route::get('/hotel/attribute/delete/{id}', [HotelAttrController::class, 'destroy'])->name('admin-hotelattr-delete');
    // HOTEL ATTRIBUTES SECTION END

    // HOTEL ATTRIBUTES SECTION
    Route::get('/hotel/attribute/trem/datatables/{id}', [AttrTremController::class, 'datatables'])->name('admin-attrtrem-datatables');
    Route::get('/hotel/attribute/trem/attributes/{id}', [AttrTremController::class, 'index'])->name('admin-attrtrem-index');
    Route::post('/hotel/attribute/trem/store', [AttrTremController::class, 'store'])->name('admin-attrtrem-store');
    Route::get('/hotel/attribute/trem/edit/{id}', [AttrTremController::class, 'edit'])->name('admin-attrtrem-edit');
    Route::post('/hotel/attribute/trem/update/{id}', [AttrTremController::class, 'update'])->name('admin-attrtrem-update');
    Route::get('/hotel/attribute/trem/delete/{id}', [AttrTremController::class, 'destroy'])->name('admin-attrtrem-delete');
    // HOTEL ATTRIBUTES SECTION END

    // HOTEL ROOM ATTRIBUTES SECTION
    Route::get('/room/attributes/datatables', [HotelRoomAttrController::class, 'datatables'])->name('admin-roomattr-datatables');
    Route::get('/room/attributes', [HotelRoomAttrController::class, 'index'])->name('admin-roomattr-index');
    Route::get('/room/attributes/create', [HotelRoomAttrController::class, 'create'])->name('admin-roomattr-create');
    Route::post('/room/attributes/store', [HotelRoomAttrController::class, 'store'])->name('admin-roomattr-store');
    Route::get('/room/attributes/edit/{id}', [HotelRoomAttrController::class, 'edit'])->name('admin-roomattr-edit');
    Route::post('/room/attributes/update/{id}', [HotelRoomAttrController::class, 'update'])->name('admin-roomattr-update');
    Route::get('/room/attributes/delete/{id}', [HotelRoomAttrController::class, 'destroy'])->name('admin-roomattr-delete');
    // HOTEL ROOM ATTRIBUTES SECTION END

    // HOTEL ATTRIBUTES SECTION
    Route::get('/hotel/room/datatables/{id}', [HotelRoomController::class, 'datatables'])->name('admin-hotel-room-datatables');
    Route::get('/hotel/room/{id}', [HotelRoomController::class, 'index'])->name('admin-hotel-room');
    Route::get('/hotel/room/create/{id}', [HotelRoomController::class, 'create'])->name('admin-hotel-room-create');
    Route::post('/hotel/room/store', [HotelRoomController::class, 'store'])->name('admin-hotel-room-store');
    Route::get('/hotel/room/edit/{id}', [HotelRoomController::class, 'edit'])->name('admin-hotel-room-edit');
    Route::post('/hotel/room/update/{id}', [HotelRoomController::class, 'update'])->name('admin-hotel-room-update');
    Route::get('/hotel/room/delete/{id}', [HotelRoomController::class, 'destroy'])->name('admin-hotel-room-delete');
    Route::get('admin/hotel/room/image/remove/{id}', [HotelController::class, 'GalleryRemove'])->name('hotel.room.image.remove');
    Route::get('admin/hotel/room/galler/remove/{id}', [HotelRoomController::class, 'RoomGalleryRemove'])->name('hotel.room.gallery.remove');
    // HOTEL ATTRIBUTES SECTION END

    Route::get('/hotel/datatables', [HotelController::class, 'datatables'])->name('admin-hotel-datatables');
    Route::get('/hotel', [HotelController::class, 'index'])->name('admin-hotel-index');
    Route::get('/hotel/create', [HotelController::class, 'create'])->name('admin-hotel-create');
    Route::post('/hotel/create', [HotelController::class, 'store'])->name('admin-hotel-store');
    Route::get('/hotel/edit/{id}', [HotelController::class, 'edit'])->name('admin-hotel-edit');
    Route::post('/hotel/update/{id}', [HotelController::class, 'update'])->name('admin-hotel-update');
    Route::get('/hotel/delete/{id}', [HotelController::class, 'destroy'])->name('admin-hotel-delete');
    Route::get('admin/hotel/gallery/image/remove/{id}', [HotelController::class, 'GalleryRemove'])->name('hotel.gallery.image.remove');

    Route::get('/hotel/orders/datatables/{type}', [HotelOrderController::class, 'datatables'])->name('admin-hotel-datatables-orders');
    Route::get('/hotel/orders/details/{id}', [HotelOrderController::class, 'HotelordersDetails'])->name('admin.hotel.order.details');
    Route::get('/hotel/order/status/{order_id}/{status}', [HotelOrderController::class, 'hotelOrderStatus'])->name('admin-hotel-order-status');
    Route::get('/hotel/orders/all', [HotelOrderController::class, 'orders'])->name('admin-hotel-allorders');
    Route::get('/hotel/orders/pending', [HotelOrderController::class, 'orders'])->name('admin-hotel-pending.orders');
    Route::get('/hotel/orders/completed', [HotelOrderController::class, 'orders'])->name('admin-hotel-completed.orders');
    Route::get('/hotel/orders/delete/{id}', [HotelOrderController::class, 'ordersDelete'])->name('admin-hotel-order-delete');
});

Route::group(['middleware' => 'permissions:Tour Section'], function () {
    Route::get('/tour/category/datatables', [TourCategoryController::class, 'datatables'])->name('admin-tour-cat-datatables');
    Route::get('/tour/category', [TourCategoryController::class, 'index'])->name('admin-tour-cat-index');
    Route::get('/tour/category/create', [TourCategoryController::class, 'create'])->name('admin-tour-cat-create');
    Route::post('/tour/category/create', [TourCategoryController::class, 'store'])->name('admin-tour-cat-store');
    Route::get('/tour/category/edit/{id}', [TourCategoryController::class, 'edit'])->name('admin-tour-cat-edit');
    Route::post('/tour/category/update/{id}', [TourCategoryController::class, 'update'])->name('admin-tour-cat-update');
    Route::get('/tour/category/delete/{id}', [TourCategoryController::class, 'destroy'])->name('admin-tour-cat-delete');
    Route::get('tour/category/status/{id1}/{id2}', [TourCategoryController::class, 'status'])->name('admin-tour-cat-status');

    Route::get('/tour/attribute/datatables', [TourAttrController::class, 'datatables'])->name('admin-tourattr-datatables');
    Route::get('/tour/attribute', [TourAttrController::class, 'index'])->name('admin-tourattr-index');
    Route::get('/tour/attribute/create', [TourAttrController::class, 'create'])->name('admin-tourattr-create');
    Route::post('/tour/attribute/create', [TourAttrController::class, 'store'])->name('admin-tourattr-store');
    Route::get('/tour/attribute/edit/{id}', [TourAttrController::class, 'edit'])->name('admin-tourattr-edit');
    Route::post('/tour/attribute/update/{id}', [TourAttrController::class, 'update'])->name('admin-tourattr-update');
    Route::get('/tour/attribute/delete/{id}', [TourAttrController::class, 'destroy'])->name('admin-tourattr-delete');

    Route::get('/tour/attribute/trem/datatables/{id}', [TourTermController::class, 'datatables'])->name('admin-tourtrem-datatables');
    Route::get('/tour/attribute/trem/{id}', [TourTermController::class, 'index'])->name('admin-tourtrem-index');
    Route::post('/tour/attribute/trem/store', [TourTermController::class, 'store'])->name('admin-tourterm-store');
    Route::get('/tour/attribute/trem/edit/{id}', [TourTermController::class, 'edit'])->name('admin-tourtrem-edit');
    Route::post('/tour/attribute/trem/update/{id}', [TourTermController::class, 'update'])->name('admin-tourtrem-update');
    Route::get('/tour/attribute/trem/delete/{id}', [TourTermController::class, 'destroy'])->name('admin-tourtrem-delete');


    Route::get('/tour/datatables', [TourController::class, 'datatables'])->name('admin-tour-datatables');
    Route::get('/tour', [TourController::class, 'index'])->name('admin-tour-index');
    Route::get('/tour/create', [TourController::class, 'create'])->name('admin-tour-create');
    Route::post('/tour/create', [TourController::class, 'store'])->name('admin-tour-store');
    Route::get('/tour/edit/{id}', [TourController::class, 'edit'])->name('admin-tour-edit');
    Route::post('/tour/update/{id}', [TourController::class, 'update'])->name('admin-tour-update');
    Route::get('/tour/delete/{id}', [TourController::class, 'destroy'])->name('admin-tour-delete');
    Route::post('/tour/inventory/update/{id}', [TourController::class, 'inventoryUpdate'])->name('inventory.update.image');
    Route::post('/new-inventory/image/upload/ajax/{id}', [TourController::class, 'inventoryNewUpload']);
    Route::get('/inventore-remove/single/{id}', [TourController::class, 'inventoryRemove']);
    Route::get('admin/tour/gallery/image/remove/{id}', [TourController::class, 'GalleryRemove'])->name('admin.tour.gallery.image.remove');

    Route::get('/tour/orders/datatables/{type}', [TourOrderController::class, 'datatables'])->name('admin-tour-datatables-orders');
    Route::get('/tour/orders/details/{id}', [TourOrderController::class, 'TourordersDetails'])->name('admin.tour.order.details');
    Route::get('/tour/order/status/{order_id}/{status}', [TourOrderController::class, 'TourOrderStatus'])->name('admin-tour-order-status');
    Route::get('/tour/orders/all', [TourOrderController::class, 'orders'])->name('admin-tour-allorders');
    Route::get('/tour/orders/pending', [TourOrderController::class, 'orders'])->name('admin-tour-pending.orders');
});


Route::group(['middleware' => 'permissions:Space Section'], function () {

    Route::get('/space/attribute/datatables', [SpaceAttrController::class, 'datatables'])->name('admin-spaceattr-datatables');
    Route::get('/space/attribute', [SpaceAttrController::class, 'index'])->name('admin-spaceattr-index');
    Route::get('/space/attribute/create', [SpaceAttrController::class, 'create'])->name('admin-spaceattr-create');
    Route::post('/space/attribute/create', [SpaceAttrController::class, 'store'])->name('admin-spaceattr-store');
    Route::get('/space/attribute/edit/{id}', [SpaceAttrController::class, 'edit'])->name('admin-spaceattr-edit');
    Route::post('/space/attribute/update/{id}', [SpaceAttrController::class, 'update'])->name('admin-spaceattr-update');
    Route::get('/space/attribute/delete/{id}', [SpaceAttrController::class, 'destroy'])->name('admin-spaceattr-delete');


    Route::get('/space/attribute/trem/datatables/{id}', [SpaceTermController::class, 'datatables'])->name('admin-spaceterm-datatables');
    Route::get('/space/attribute/trem/{id}', [SpaceTermController::class, 'index'])->name('admin-spaceterm-index');
    Route::post('/space/attribute/trem/store', [SpaceTermController::class, 'store'])->name('admin-spaceterm-store');
    Route::get('/space/attribute/trem/edit/{id}', [SpaceTermController::class, 'edit'])->name('admin-spaceterm-edit');
    Route::post('/space/attribute/trem/update/{id}', [SpaceTermController::class, 'update'])->name('admin-spaceterm-update');
    Route::get('/space/attribute/trem/delete/{id}', [SpaceTermController::class, 'destroy'])->name('admin-spaceterm-delete');


    Route::get('/space/datatables', [SpaceController::class, 'datatables'])->name('admin-space-datatables');
    Route::get('/space', [SpaceController::class, 'index'])->name('admin-space-index');
    Route::get('/space/create', [SpaceController::class, 'create'])->name('admin-space-create');
    Route::post('/space/create', [SpaceController::class, 'store'])->name('admin-space-store');
    Route::get('/space/edit/{id}', [SpaceController::class, 'edit'])->name('admin-space-edit');
    Route::post('/space/update/{id}', [SpaceController::class, 'update'])->name('admin-space-update');
    Route::get('/space/delete/{id}', [SpaceController::class, 'destroy'])->name('admin-space-delete');
    Route::get('admin/gallery/image/remove/{id}', [SpaceController::class, 'GalleryRemove'])->name('admin.space.gallery.image.remove');


    Route::get('/space/orders/datatables/{type}', [SpaceOrderController::class, 'datatables'])->name('admin-space-datatables-orders');
    Route::get('/space/orders/details/{id}', [SpaceOrderController::class, 'SpaceordersDetails'])->name('admin.space.order.details');
    Route::get('/space/order/status/{order_id}/{status}', [SpaceOrderController::class, 'SpaceOrderStatus'])->name('admin-space-order-status');
    Route::get('/space/orders/all', [SpaceOrderController::class, 'orders'])->name('admin-space-allorders');
    Route::get('/space/orders/pending', [SpaceOrderController::class, 'orders'])->name('admin-space-pending.orders');
    Route::get('/space/orders/completed', [SpaceOrderController::class, 'orders'])->name('admin-space-completed.orders');
    Route::get('/space/orders/delete/{id}', [SpaceOrderController::class, 'ordersDelete'])->name('admin-space-order-delete');
});

Route::group(['middleware' => 'permissions:Car Section'], function () {

    Route::get('/car/attribute/datatables', [CarAttrController::class, 'datatables'])->name('admin-carattr-datatables');
    Route::get('/car/attribute', [CarAttrController::class, 'index'])->name('admin-carattr-index');
    Route::get('/car/attribute/create', [CarAttrController::class, 'create'])->name('admin-carattr-create');
    Route::post('/car/attribute/create', [CarAttrController::class, 'store'])->name('admin-carattr-store');
    Route::get('/car/attribute/edit/{id}', [CarAttrController::class, 'edit'])->name('admin-carattr-edit');
    Route::post('/car/attribute/update/{id}', [CarAttrController::class, 'update'])->name('admin-carattr-update');
    Route::get('/car/attribute/delete/{id}', [CarAttrController::class, 'destroy'])->name('admin-carattr-delete');


    Route::get('/car/attribute/trem/datatables/{id}', [CarTermController::class, 'datatables'])->name('admin-carterm-datatables');
    Route::get('/car/attribute/trem/{id}', [CarTermController::class, 'index'])->name('admin-carterm-index');
    Route::post('/car/attribute/trem/store', [CarTermController::class, 'store'])->name('admin-carterm-store');
    Route::get('/car/attribute/trem/edit/{id}', [CarTermController::class, 'edit'])->name('admin-carterm-edit');
    Route::post('/car/attribute/trem/update/{id}', [CarTermController::class, 'update'])->name('admin-carterm-update');
    Route::get('/car/attribute/trem/delete/{id}', [CarTermController::class, 'destroy'])->name('admin-carterm-delete');


    Route::get('/car/datatables', [CarController::class, 'datatables'])->name('admin-car-datatables');
    Route::get('/car', [CarController::class, 'index'])->name('admin-car-index');
    Route::get('/car/create', [CarController::class, 'create'])->name('admin-car-create');
    Route::post('/car/create', [CarController::class, 'store'])->name('admin-car-store');
    Route::get('/car/edit/{id}', [CarController::class, 'edit'])->name('admin-car-edit');
    Route::post('/car/update/{id}', [CarController::class, 'update'])->name('admin-car-update');
    Route::get('/car/delete/{id}', [CarController::class, 'destroy'])->name('admin-car-delete');
    Route::get('/gallery/image/remove/{id}', [CarController::class, 'GalleryRemove'])->name('car.gallery.image.remove');




    Route::get('/car/orders/datatables/{type}', [CarOrderController::class, 'datatables'])->name('admin-car-datatables-orders');
    Route::get('/car/orders/details/{id}', [CarOrderController::class, 'CarordersDetails'])->name('admin.car.order.details');
    Route::get('/car/order/status/{order_id}/{status}', [CarOrderController::class, 'CarOrderStatus'])->name('admin-car-order-status');
    Route::get('/car/orders/all', [CarOrderController::class, 'orders'])->name('admin-car-allorders');
    Route::get('/car/orders/pending', [CarOrderController::class, 'orders'])->name('admin-car-pending.orders');
    Route::get('/car/orders/completed', [CarOrderController::class, 'orders'])->name('admin-car-completed.orders');
    Route::get('/car/orders/delete/{id}', [CarOrderController::class, 'ordersDelete'])->name('admin-car-order-delete');

    Route::get('/cancel/booking/datatables', [DashboardController::class, 'cancelDatatables'])->name('admin-order-cancel-datatables');
    Route::get('/cancel/booking', [DashboardController::class, 'cancelIndex'])->name('admin-order-cancel');
    Route::get('/book/cancel/status/{id}/{status}', [DashboardController::class, 'status'])->name('admin-order-cancel-status');
});


Route::group(['middleware' => 'permissions:Home Page Settings Section'], function () {

    Route::get('/home-page/cutomize', [PageSettingController::class, 'pageCustomize'])->name('admin-homepage-customize');
    Route::get('/home-page/heading/cutomize', [PageSettingController::class, 'headingCustomize'])->name('admin-section-heading');
    Route::post('/home/update', [PageSettingController::class, 'Update'])->name('admin-homepage-update');
    Route::post('/home/menu/update', [PageSettingController::class, 'menuUpdate'])->name('admin-homepage-menu-update');
    Route::post('/home/heading/update', [PageSettingController::class, 'HeadingUpdate'])->name('admin-homepage-heading-update');

    Route::get('/member/background/edit', [PageSettingController::class, 'memberBackgroundUpdate'])->name('admin-member-background-edit');
    Route::post('/member/background/update', [PageSettingController::class, 'memberBackgroundstore'])->name('admin-member-background-update');

    Route::get('/slider/datatables', [FeatureController::class, 'datatables'])->name('admin-slider-datatables');
    Route::get('/slider', [FeatureController::class, 'index'])->name('admin-slider-index');
    Route::get('/slider/create', [FeatureController::class, 'create'])->name('admin-slider-create');
    Route::post('/slider/create', [FeatureController::class, 'store'])->name('admin-slider-store');
    Route::get('/slider/edit/{id}', [FeatureController::class, 'edit'])->name('admin-slider-edit');
    Route::post('/slider/update/{id}', [FeatureController::class, 'update'])->name('admin-slider-update');
    Route::get('/slider/delete/{id}', [FeatureController::class, 'destroy'])->name('admin-slider-delete');


    Route::get('/member/datatables', [MemberController::class, 'datatables'])->name('admin-member-datatables');
    Route::get('/member', [MemberController::class, 'index'])->name('admin-member-index');
    Route::get('/member/create', [MemberController::class, 'create'])->name('admin-member-create');
    Route::post('/member/create', [MemberController::class, 'store'])->name('admin-member-store');
    Route::get('/member/edit/{id}', [MemberController::class, 'edit'])->name('admin-member-edit');
    Route::post('/member/edit/{id}', [MemberController::class, 'update'])->name('admin-member-update');
    Route::get('/member/delete/{id}', [MemberController::class, 'destroy'])->name('admin-member-delete');
});


Route::group(['middleware' => 'permissions:Blog Section'], function () {
    Route::get('/blog/datatables', [BlogController::class, 'datatables'])->name('admin-blog-datatables');
    Route::get('/blog', [BlogController::class, 'index'])->name('admin-blog-index');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('admin-blog-create');
    Route::post('/blog/create', [BlogController::class, 'store'])->name('admin-blog-store');
    Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('admin-blog-edit');
    Route::post('/blog/edit/{id}', [BlogController::class, 'update'])->name('admin-blog-update');
    Route::get('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('admin-blog-delete');


    Route::get('/blog/category/datatables', [BlogCategoryController::class, 'datatables'])->name('admin-cblog-datatables');
    Route::get('/blog/category', [BlogCategoryController::class, 'index'])->name('admin-cblog-index');
    Route::get('/blog/category/create', [BlogCategoryController::class, 'create'])->name('admin-cblog-create');
    Route::post('/blog/category/create', [BlogCategoryController::class, 'store'])->name('admin-cblog-store');
    Route::get('/blog/category/edit/{id}', [BlogCategoryController::class, 'edit'])->name('admin-cblog-edit');
    Route::post('/blog/category/edit/{id}', [BlogCategoryController::class, 'update'])->name('admin-cblog-update');
    Route::get('/blog/category/delete/{id}', [BlogCategoryController::class, 'destroy'])->name('admin-cblog-delete');
    Route::get('blog/category/status/{id1}/{id2}', [BlogCategoryController::class, 'status'])->name('admin-bcat-status');
});



Route::group(['middleware' => 'permissions:Menu Page Settings Section'], function () {

    Route::get('/page-settings/contact', [PageSettingController::class, 'contact'])->name('admin-ps-contact');
    Route::get('/page-settings/customize', [PageSettingController::class, 'customize'])->name('admin-ps-customize');
    Route::get('/page-settings/experience', [PageSettingController::class, 'video'])->name('admin-ps-video');
    Route::get('/page-settings/homecontact', [PageSettingController::class, 'homecontact'])->name('admin-ps-homecontact');
    Route::get('/page-settings/donate', [PageSettingController::class, 'donate'])->name('admin-ps-donate');
    Route::get('/page-settings/blog', [PageSettingController::class, 'blog'])->name('admin-ps-blog');
    Route::post('/page-settings/update/all', [PageSettingController::class, 'update'])->name('admin-ps-update');
    Route::post('/page-settings/update/home', [PageSettingController::class, 'homeupdate'])->name('admin-ps-homeupdate');
    Route::post('/page-settings/update/contact', [PageSettingController::class, 'contactupdate'])->name('admin-ps-contact-update');
    Route::get('menu/customize', [PageSettingController::class, 'menuCustomize'])->name('admin-menu-customize');


    Route::get('/page/datatables', [PageController::class, 'datatables'])->name('admin-page-datatables');
    Route::get('/page', [PageController::class, 'index'])->name('admin-page-index');
    Route::get('/page/create', [PageController::class, 'create'])->name('admin-page-create');
    Route::post('/page/create', [PageController::class, 'store'])->name('admin-page-store');
    Route::get('/page/edit/{id}', [PageController::class, 'edit'])->name('admin-page-edit');
    Route::post('/page/update/{id}', [PageController::class, 'update'])->name('admin-page-update');
    Route::get('/page/delete/{id}', [PageController::class, 'destroy'])->name('admin-page-delete');
    Route::get('/page/header/{id1}/{id2}', [PageController::class, 'header'])->name('admin-page-header');
    Route::get('/page/footer/{id1}/{id2}', [PageController::class, 'footer'])->name('admin-page-footer');


    Route::get('/faq/datatables', [FaqController::class, 'datatables'])->name('admin-faq-datatables');
    Route::get('/faq', [FaqController::class, 'index'])->name('admin-faq-index');
    Route::get('/faq/create', [FaqController::class, 'create'])->name('admin-faq-create');
    Route::post('/faq/create', [FaqController::class, 'store'])->name('admin-faq-store');
    Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('admin-faq-edit');
    Route::post('/faq/update/{id}', [FaqController::class, 'update'])->name('admin-faq-update');
    Route::get('/faq/delete/{id}', [FaqController::class, 'destroy'])->name('admin-faq-delete');
});


Route::group(['middleware' => 'permissions:Social Settings Section'], function () {

    Route::get('/social', [SocialSettingController::class, 'index'])->name('admin-social-index');
    Route::post('/social/update', [SocialSettingController::class, 'socialupdate'])->name('admin-social-update');
    Route::post('/social/update/all', [SocialSettingController::class, 'socialupdateall'])->name('admin-social-update-all');
    Route::get('/social/facebook', [SocialSettingController::class, 'facebook'])->name('admin-social-facebook');
    Route::get('/social/google', [SocialSettingController::class, 'google'])->name('admin-social-google');
    Route::get('/social/facebook/{status}', [SocialSettingController::class, 'facebookup'])->name('admin-social-facebookup');
    Route::get('/social/google/{status}', [SocialSettingController::class, 'googleup'])->name('admin-social-googleup');


    Route::get('/seotools/analytics', [SeoToolController::class, 'analytics'])->name('admin-seotool-analytics');
    Route::post('/seotools/analytics/update', [SeoToolController::class, 'analyticsupdate'])->name('admin-seotool-analytics-update');
    Route::get('/seotools/keywords', [SeoToolController::class, 'keywords'])->name('admin-seotool-keywords');
    Route::post('/seotools/keywords/update', [SeoToolController::class, 'keywordsupdate'])->name('admin-seotool-keywords-update');
    Route::get('/products/popular/{id}', [SeoToolController::class, 'popular'])->name('admin-prod-popular');
});


Route::group(['middleware' => 'permissions:Location Section'], function () {

    Route::get('/location/country/datatables', [CountryController::class, 'datatables'])->name('admin-country-datatables');
    Route::get('/location/country', [CountryController::class, 'index'])->name('admin.country.index');
    Route::get('/location/country/create', [CountryController::class, 'create'])->name('admin.country.create');
    Route::post('/location/country/create', [CountryController::class, 'store'])->name('admin.country.store');
    Route::get('/location/country/edit/{id}', [CountryController::class, 'edit'])->name('admin.country.edit');
    Route::post('/location/country/update/{id}', [CountryController::class, 'update'])->name('admin.country.update');
    Route::get('/location/country/delete/{id}', [CountryController::class, 'destroy'])->name('admin.country.delete');
    Route::get('location/country/status/{id1}/{id2}', [CountryController::class, 'status'])->name('admin.country.status');


    Route::get('/location/state/datatables', [StateController::class, 'datatables'])->name('admin-state-datatables');
    Route::get('/location/state', [StateController::class, 'index'])->name('admin.state.index');
    Route::get('/location/state/create', [StateController::class, 'create'])->name('admin.state.create');
    Route::post('/location/state/create', [StateController::class, 'store'])->name('admin.state.store');
    Route::get('/location/state/edit/{id}', [StateController::class, 'edit'])->name('admin.state.edit');
    Route::post('/location/state/update/{id}', [StateController::class, 'update'])->name('admin.state.update');
    Route::get('/location/state/delete/{id}', [StateController::class, 'destroy'])->name('admin.state.delete');
});


Route::group(['middleware' => 'permissions:Language Section'], function () {

    Route::get('/languages/datatables', [LanguageController::class, 'datatables'])->name('admin-lang-datatables');
    Route::get('/languages', [LanguageController::class, 'index'])->name('admin-lang-index');
    Route::get('/languages/create', [LanguageController::class, 'create'])->name('admin-lang-create');
    Route::get('/languages/edit/{id}', [LanguageController::class, 'edit'])->name('admin-lang-edit');
    Route::post('/languages/create', [LanguageController::class, 'store'])->name('admin-lang-store');
    Route::post('/languages/edit/{id}', [LanguageController::class, 'update'])->name('admin-lang-update');
    Route::get('/languages/status/{id1}/{id2}', [LanguageController::class, 'status'])->name('admin-lang-st');
    Route::get('/languages/delete/{id}', [LanguageController::class, 'destroy'])->name('admin-lang-delete');
    Route::get('/languages/export/{id}', [LanguageController::class, 'LanguageExport'])->name('website.lang.export');
    Route::post('/languages/import/', [LanguageController::class, 'LanguageImport'])->name('website.lang.import');

    Route::get('/panel/languages/datatables', [AdminLanguageController::class, 'datatables'])->name('admin-lang-admin-datatables');
    Route::get('/panel/languages/', [AdminLanguageController::class, 'index'])->name('admin-lang-admin-index');
    Route::get('/panel/languages/create', [AdminLanguageController::class, 'create'])->name('admin-lang-admin-create');
    Route::get('/panel/languages/edit/{id}', [AdminLanguageController::class, 'edit'])->name('admin-lang-admin-edit');
    Route::post('/panel/languages/create', [AdminLanguageController::class, 'store'])->name('admin-lang-admin-store');
    Route::post('/panel/languages/edit/{id}', [AdminLanguageController::class, 'update'])->name('admin-lang-admin-update');
    Route::get('/panel/languages/status/{id1}/{id2}', [AdminLanguageController::class, 'status'])->name('admin-lang-admin-st');
    Route::get('/panel/languages/delete/{id}', [AdminLanguageController::class, 'destroy'])->name('admin-lang-admin-delete');
    Route::get('/panel/languages/export/{id}', [AdminLanguageController::class, 'LanguageExport'])->name('admin-lang-export');
    Route::post('/panel/languages/import/', [AdminLanguageController::class, 'LanguageImport'])->name('admin.lang.import');
});


Route::group(['middleware' => 'permissions:Manage Role Section'], function () {

    Route::get('/role/datatables', [RoleController::class, 'datatables'])->name('admin-role-datatables');
    Route::get('/role', [RoleController::class, 'index'])->name('admin-role-index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('admin-role-create');
    Route::post('/role/create', [RoleController::class, 'store'])->name('admin-role-store');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('admin-role-edit');
    Route::post('/role/edit/{id}', [RoleController::class, 'update'])->name('admin-role-update');
    Route::get('/role/delete/{id}', [RoleController::class, 'destroy'])->name('admin-role-delete');
});


Route::group(['middleware' => 'permissions:Manage Staff Section'], function () {
    Route::get('/staff/datatables', [StaffController::class, 'datatables'])->name('admin-staff-datatables');
    Route::get('/staff', [StaffController::class, 'index'])->name('admin-staff-index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('admin-staff-create');
    Route::post('/staff/create', [StaffController::class, 'store'])->name('admin-staff-store');
    Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('admin-staff-edit');
    Route::post('/staff/update/{id}', [StaffController::class, 'update'])->name('admin-staff-update');
    Route::get('/staff/show/{id}', [StaffController::class, 'show'])->name('admin-staff-show');
    Route::get('/staff/delete/{id}', [StaffController::class, 'destroy'])->name('admin-staff-delete');
});



Route::group(['middleware' => 'permissions:User Manage Section'], function () {
    Route::get('/user/datatables', [UserController::class, 'datatables'])->name('admin-user-datatables');
    Route::get('/user', [UserController::class, 'index'])->name('admin-user-index');
    Route::get('/user/create', [UserController::class, 'create'])->name('admin-user-create');
    Route::post('/user/create', [UserController::class, 'store'])->name('admin-user-store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('admin-user-edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('admin-user-update');
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('admin-user-show');
    Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('admin-user-delete');
});


Route::group(['middleware' => 'permissions:General Settings Section'], function () {
    Route::get('/general-settings/logo', [GeneralSettingController::class, 'logo'])->name('admin-gs-logo');
    Route::get('/general-settings/favicon', [GeneralSettingController::class, 'fav'])->name('admin-gs-fav');
    Route::get('/general-settings/loader', [GeneralSettingController::class, 'load'])->name('admin-gs-load');
    Route::get('/general-settings/contents', [GeneralSettingController::class, 'contents'])->name('admin-gs-contents');
    Route::get('/general-settings/success', [GeneralSettingController::class, 'success'])->name('admin-gs-success');
    Route::get('/general-settings/footer', [GeneralSettingController::class, 'footer'])->name('admin-gs-footer');
    Route::get('/general-settings/error', [GeneralSettingController::class, 'error'])->name('admin-gs-error');
    Route::get('/general-settings/breadcumb', [GeneralSettingController::class, 'breadcumb'])->name('admin-gs-breadcumb');
    Route::post('/general-settings/update/all', [GeneralSettingController::class, 'generalupdate'])->name('admin-gs-update');
    Route::get('/general-settings/status/update/{value}', [GeneralSettingController::class, 'StatusUpdate'])->name('admin.gs.status');
});


Route::group(['middleware' => 'permissions:Payment Settings Section'], function () {

    Route::get('/payment-informations', [GeneralSettingController::class, 'paymentsinfo'])->name('admin-gs-payments');


    Route::get('/paymentgateway/datatables', [PaymentGatewayController::class, 'datatables'])->name('admin-payment-datatables');
    Route::get('/paymentgateway', [PaymentGatewayController::class, 'index'])->name('admin-payment-index');
    Route::get('/paymentgateway/create', [PaymentGatewayController::class, 'create'])->name('admin-payment-create');
    Route::post('/paymentgateway/create', [PaymentGatewayController::class, 'store'])->name('admin-payment-store');
    Route::get('/paymentgateway/edit/{id}', [PaymentGatewayController::class, 'edit'])->name('admin-payment-edit');
    Route::post('/paymentgateway/update/{id}', [PaymentGatewayController::class, 'update'])->name('admin-payment-update');
    Route::get('/paymentgateway/delete/{id}', [PaymentGatewayController::class, 'destroy'])->name('admin-payment-delete');
    Route::get('/paymentgateway/status/{id1}/{id2}', [PaymentGatewayController::class, 'status'])->name('admin-payment-status');



    Route::get('/currency/datatables', [CurrencyController::class, 'datatables'])->name('admin-currency-datatables');
    Route::get('/currency', [CurrencyController::class, 'index'])->name('admin-currency-index');
    Route::get('/currency/create', [CurrencyController::class, 'create'])->name('admin-currency-create');
    Route::post('/currency/create', [CurrencyController::class, 'store'])->name('admin-currency-store');
    Route::get('/currency/edit/{id}', [CurrencyController::class, 'edit'])->name('admin-currency-edit');
    Route::post('/currency/update/{id}', [CurrencyController::class, 'update'])->name('admin-currency-update');
    Route::get('/currency/delete/{id}', [CurrencyController::class, 'destroy'])->name('admin-currency-delete');
    Route::get('/currency/status/{id1}/{id2}', [CurrencyController::class, 'status'])->name('admin-currency-status');

    Route::get('/general-settings/status/{field}/{status}', [GeneralSettingController::class, 'status'])->name('admin-gs-status');

    Route::get('/withdraw/methods/datatables', [WithdrawMethodsController::class, 'datatables'])->name('admin-withdraw-method-datatables');
    Route::get('/withdraw/methods', [WithdrawMethodsController::class, 'index'])->name('admin-withdraw-method-index');
    Route::get('/withdraw/methods/status/{id1}/{id2}', [WithdrawMethodsController::class, 'status'])->name('admin-withdraw-method-status');
    Route::get('/withdraw/methods/create', [WithdrawMethodsController::class, 'create'])->name('admin-withdraw-method-create');
    Route::post('/withdraw/methods/store', [WithdrawMethodsController::class, 'store'])->name('admin-withdraw-method-store');
    Route::get('/withdraw/methods/edit/{id}', [WithdrawMethodsController::class, 'edit'])->name('admin-withdraw-method-edit');
    Route::post('/withdraw/methods/update/{id}', [WithdrawMethodsController::class, 'update'])->name('admin-withdraw-method-update');
    Route::get('/withdraw/methods/delete/{id}', [WithdrawMethodsController::class, 'delete'])->name('admin-withdraw-method-delete');
});


Route::group(['middleware' => 'permissions:Withdraw'], function () {
    Route::get('/withdraw/methods/datatables', [WithdrawController::class, 'datatables'])->name('admin-withdraw-datatables');
    Route::get('/withdraws', [WithdrawController::class, 'index'])->name('admin-withdraw-index');
    Route::get('/withdraw/status/{id}/{status}', [WithdrawController::class, 'status'])->name('admin-withdraw-status');
});


Route::group(['middleware' => 'permissions:Subscriber Section'], function () {
    Route::get('/subscribers/datatables', [SubscriberController::class, 'datatables'])->name('admin-subs-datatables');
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('admin-subs-index');
    Route::get('/subscribers/download', [SubscriberController::class, 'download'])->name('admin-subs-download');
});

Route::get('module/review/datatables', [ReviewController::class, 'datatables'])->name('admin.review.datatables');
Route::get('module/review', [ReviewController::class, 'index'])->name('admin.review.index');


Route::group(['middleware' => 'permissions:Email Settings Section'], function () {
    Route::get('/email-templates/datatables', [EmailController::class, 'datatables'])->name('admin-mail-datatables');
    Route::get('/email-templates', [EmailController::class, 'index'])->name('admin-mail-index');
    Route::get('/email-templates/{id}', [EmailController::class, 'edit'])->name('admin-mail-edit');
    Route::post('/email-templates/{id}', [EmailController::class, 'update'])->name('admin-mail-update');
    Route::get('/email-config', [EmailController::class, 'config'])->name('admin-mail-config');
    Route::get('/groupemail', [EmailController::class, 'groupemail'])->name('admin-group-show');
    Route::post('/groupemailpost', [EmailController::class, 'groupemailpost'])->name('admin-group-submit');
    Route::get('/issmtp/{status}', [GeneralSettingController::class, 'issmtp'])->name('admin-gs-issmtp');
});


});
// =========================== user route ==========================//

Route::prefix('user')->group(function () {

    // ---------------------------- USER DASHBOARD SECTION ------------------------//
    Route::get('/dashboard', [UserUserController::class, 'index'])->name('user-dashboard');
    // ---------------------------- USER DASHBOARD SECTION END -------------------//

    // ----------------------------- USER LOGIN SECTION ---------------------------//
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('user.login.submit');
    // ----------------------------- USER LOGIN SECTION END -----------------------//

    // ----------------------------- USER REGISTER SECTION ------------------------//
    Route::get('/register', [RegisterController::class, 'registerForm'])->name('user-register-form');
    Route::post('/register/submit', [RegisterController::class, 'register'])->name('user-register-submit');
    Route::get('/register/verify/{token}', [RegisterController::class, 'token'])->name('user-register-token');
    // ----------------------------- USER REGISTER SECTION END --------------------//

    // ----------------------------- USER RESET SECTION ---------------------------//
    Route::get('/reset', [UserUserController::class, 'resetform'])->name('user-reset');
    Route::post('/reset', [UserUserController::class, 'reset'])->name('user-reset-submit');
    // ----------------------------- USER RESET  SECTION END -----------------------//

    // ----------------------------- USER PROFILE SECTION -------------------------//
    Route::get('/profile', [UserUserController::class, 'profile'])->name('user-profile');
    Route::post('/profile', [UserUserController::class, 'profileupdate'])->name('user-profile-update');
    // ----------------------------- USER PROFILE  SECTION END ---------------------//

    // ---------------------------- USER FORGOT SECTION --------------------------//
    Route::get('/forgot', [ForgotController::class, 'showforgotform'])->name('user-forgot');
    Route::post('/forgot', [ForgotController::class, 'forgot'])->name('user-forgot-submit');
    // ----------------------------- USER FORGOT SECTION END ----------------------//

    // ----------------------------- USER LOGOUT SECTION --------------------------//
    Route::get('/logout', [UserLoginController::class, 'logout'])->name('user-logout');
    // ----------------------------- USER LOGOUT SECTION END ----------------------//

    // LOGIN WITH FACEBOOK OR GOOGLE SECTION
    Route::get('auth/{provider}', [SocialRegisterController::class, 'redirectToProvider'])->name('social-provider');
    Route::get('auth/{provider}/callback', [SocialRegisterController::class, 'handleProviderCallback']);
    // LOGIN WITH FACEBOOK OR GOOGLE SECTION ENDS

    // ----------------------------- USER NOTIFICATION SECTION ---------------------//
    Route::get('/notf/show', [UserNotificationController::class, 'user_notf_show'])->name('customer-notf-show');
    Route::get('/notf/count', [UserNotificationController::class, 'user_notf_count'])->name('customer-notf-count');
    Route::get('/notf/clear', [UserNotificationController::class, 'user_notf_clear'])->name('customer-notf-clear');
    // ----------------------------- USER NOTIFICATION SECTION END -----------------//


    // ----------------------------- HOTEL SECTION START --------------------------------------//
    Route::get('/hotel/datatables', [UserHotelController::class, 'datatables'])->name('user-hotel-datatables');
    Route::get('/hotel', [UserHotelController::class, 'index'])->name('user-hotel-index');
    Route::get('/hotel/create', [UserHotelController::class, 'create'])->name('user-hotel-create');
    Route::post('/hotel/create', [UserHotelController::class, 'store'])->name('user-hotel-store');
    Route::get('/hotel/edit/{id}', [UserHotelController::class, 'edit'])->name('user-hotel-edit');
    Route::post('/hotel/update/{id}', [UserHotelController::class, 'update'])->name('user-hotel-update');
    Route::get('/hotel/delete/{id}', [UserHotelController::class, 'destroy'])->name('user-hotel-delete');
    Route::get('/user/hotel/gallery/remove/{id}', [UserHotelController::class, 'GalleryRemove'])->name('user.hotel.gallery.remove');
    // ----------------------------- HOTEL SECTION END --------------------------------------//

    // ----------------------------- HOTEL ATTRIBUTES SECTION START --------------------------------------//
    Route::get('/hotel/room/datatables/{id}', [UserHotelRoomController::class, 'datatables'])->name('user-hotel-room-datatables');
    Route::get('/hotel/room/{id}', [UserHotelRoomController::class, 'index'])->name('user-hotel-room');
    Route::get('/hotel/room/create/{id}', [UserHotelRoomController::class, 'create'])->name('user-hotel-room-create');
    Route::post('/hotel/room/store', [UserHotelRoomController::class, 'store'])->name('user-hotel-room-store');
    Route::get('/hotel/room/edit/{id}', [UserHotelRoomController::class, 'edit'])->name('user-hotel-room-edit');
    Route::post('/hotel/room/update/{id}', [UserHotelRoomController::class, 'update'])->name('user-hotel-room-update');
    Route::get('/hotel/room/delete/{id}', [UserHotelRoomController::class, 'destroy'])->name('user-hotel-room-delete');
    Route::get('user/hotel/room/image/remove/{id}', [UserHotelRoomController::class, 'GalleryRemove'])->name('hotel.room.image.remove');
    // ----------------------------- HOTEL ATTRIBUTES SECTION END --------------------------------------//

    Route::get('/data/bulk/delete', [BulkDeleteController::class, 'bulkdelete'])->name('user.bulk.delete');


    // ------------------------------ Hotel Order Section Start -------------------------------------------//
    Route::get('/hotel/orders/datatables/{type}', [UserHotelOrderController::class, 'datatables'])->name('user-hotel-datatables-orders');
    Route::get('/hotel/orders/details/{id}', [UserHotelOrderController::class, 'HotelordersDetails'])->name('user.hotel.order.details');
    Route::get('/hotel/order/status/{order_id}/{status}', [UserHotelOrderController::class, 'hotelOrderStatus'])->name('user-hotel-order-status');
    Route::get('/hotel/orders/all', [UserHotelOrderController::class, 'orders'])->name('user-hotel-allorders');
    Route::get('/hotel/orders/pending', [UserHotelOrderController::class, 'orders'])->name('user-hotel-pending.orders');
    Route::get('/hotel/orders/completed', [UserHotelOrderController::class, 'orders'])->name('user-hotel-completed.orders');
    Route::get('/hotel/orders/delete/{id}', [UserHotelOrderController::class, 'ordersDelete'])->name('user-hotel-order-delete');
    // ----------------------------- HOTEL SECTION END --------------------------------------//


    // ----------------------------- TOUR SECTION START --------------------------------------//
    Route::get('/tour/datatables', [UserTourController::class, 'datatables'])->name('user-tour-datatables');
    Route::get('/tour', [UserTourController::class, 'index'])->name('user-tour-index');
    Route::get('/tour/create', [UserTourController::class, 'create'])->name('user-tour-create');
    Route::post('/tour/create', [UserTourController::class, 'store'])->name('user-tour-store');
    Route::get('/tour/edit/{id}', [UserTourController::class, 'edit'])->name('user-tour-edit');
    Route::post('/tour/update/{id}', [UserTourController::class, 'update'])->name('user-tour-update');
    Route::get('/tour/delete/{id}', [UserTourController::class, 'destroy'])->name('user-tour-delete');
    Route::post('/user/tour/inventory/update/{id}', [UserTourController::class, 'inventoryUpdate'])->name('user.inventory.update.image');
    Route::post('/user/new-inventory/image/upload/ajax/{id}', [UserTourController::class, 'inventoryNewUpload']);
    Route::get('/user/inventore-remove/single/{id}', [UserTourController::class, 'inventoryRemove']);
    Route::get('/user/gallery/remove/{id}', [UserTourController::class, 'GalleryRemove'])->name('user.tour.gallery.image.remove');
    // ----------------------------- TOUR SECTION END --------------------------------------//

    // ------------------------------ Tour Order Section Start -------------------------------------------//
    Route::get('/tour/orders/datatables/{type}', [UserTourOrderController::class, 'datatables'])->name('user-tour-datatables-orders');
    Route::get('/tour/orders/details/{id}', [UserTourOrderController::class, 'TourordersDetails'])->name('user.tour.order.details');
    Route::get('/tour/order/status/{order_id}/{status}', [UserTourOrderController::class, 'TourOrderStatus'])->name('user-tour-order-status');
    Route::get('/tour/orders/all', [UserTourOrderController::class, 'orders'])->name('user-tour-allorders');
    Route::get('/tour/orders/pending', [UserTourOrderController::class, 'orders'])->name('user-tour-pending.orders');
    Route::get('/tour/orders/completed', [UserTourOrderController::class, 'orders'])->name('user-tour-completed.orders');
    Route::get('/tour/orders/delete/{id}', [UserTourOrderController::class, 'ordersDelete'])->name('user-tour-order-delete');
    // ------------------------------ Tour Order Section End -------------------------------------------//


    // ----------------------------- SPACE SECTION START --------------------------------------//
    Route::get('/space/datatables', [UserSpaceController::class, 'datatables'])->name('user-space-datatables');
    Route::get('/space', [UserSpaceController::class, 'index'])->name('user-space-index');
    Route::get('/space/create', [UserSpaceController::class, 'create'])->name('user-space-create');
    Route::post('/space/create', [UserSpaceController::class, 'store'])->name('user-space-store');
    Route::get('/space/edit/{id}', [UserSpaceController::class, 'edit'])->name('user-space-edit');
    Route::post('/space/update/{id}', [UserSpaceController::class, 'update'])->name('user-space-update');
    Route::get('/space/delete/{id}', [UserSpaceController::class, 'destroy'])->name('user-space-delete');
    Route::get('/gallery/remove/{id}', [UserSpaceController::class, 'GalleryRemove'])->name('user.space.gallery.image.remove');
    Route::get('/user/space/gallery/remove/{id}', [UserSpaceController::class, 'GalleryRemove'])->name('user.space.gallery.remove');
    // ----------------------------- SPACE SECTION END --------------------------------------//

    // ------------------------------ Space Order Section Start -------------------------------------------//
    Route::get('/space/orders/datatables/{type}', [UserSpaceOrderController::class, 'datatables'])->name('user-space-datatables-orders');
    Route::get('/space/orders/details/{id}', [UserSpaceOrderController::class, 'SpaceordersDetails'])->name('user.space.order.details');
    Route::get('/space/order/status/{order_id}/{status}', [UserSpaceOrderController::class, 'SpaceOrderStatus'])->name('user-space-order-status');
    Route::get('/space/orders/all', [UserSpaceOrderController::class, 'orders'])->name('user-space-allorders');
    Route::get('/space/orders/pending', [UserSpaceOrderController::class, 'orders'])->name('user-space-pending.orders');
    Route::get('/space/orders/completed', [UserSpaceOrderController::class, 'orders'])->name('user-space-completed.orders');
    Route::get('/space/orders/delete/{id}', [UserSpaceOrderController::class, 'ordersDelete'])->name('user-space-order-delete');
    // ------------------------------ Space Order Section End -------------------------------------------//

    // ----------------------------- CAR SECTION START --------------------------------------//
    Route::get('/car/datatables', [UserCarController::class, 'datatables'])->name('user-car-datatables');
    Route::get('/car', [UserCarController::class, 'index'])->name('user-car-index');
    Route::get('/car/create', [UserCarController::class, 'create'])->name('user-car-create');
    Route::post('/car/create', [UserCarController::class, 'store'])->name('user-car-store');
    Route::get('/car/edit/{id}', [UserCarController::class, 'edit'])->name('user-car-edit');
    Route::post('/car/update/{id}', [UserCarController::class, 'update'])->name('user-car-update');
    Route::get('/car/delete/{id}', [UserCarController::class, 'destroy'])->name('user-car-delete');
    Route::get('user/car/gallery/remove/{id}', [UserCarController::class, 'GalleryRemove'])->name('user.car.gallery.image.remove');
    // ----------------------------- CAR SECTION END --------------------------------------//

    // ------------------------------ Car Order Section Start -------------------------------------------//
    Route::get('/car/orders/datatables/{type}', [UserCarOrderController::class, 'datatables'])->name('user-car-datatables-orders');
    Route::get('/car/orders/details/{id}', [UserCarOrderController::class, 'CarordersDetails'])->name('user.car.order.details');
    Route::get('/car/order/status/{order_id}/{status}', [UserCarOrderController::class, 'CarOrderStatus'])->name('user-car-order-status');
    Route::get('/car/orders/all', [UserCarOrderController::class, 'orders'])->name('user-car-allorders');
    Route::get('/car/orders/pending', [UserCarOrderController::class, 'orders'])->name('user-car-pending.orders');
    Route::get('/car/orders/completed', [UserCarOrderController::class, 'orders'])->name('user-car-completed.orders');
    Route::get('/car/orders/delete/{id}', [UserCarOrderController::class, 'ordersDelete'])->name('user-car-order-delete');
    // ------------------------------ Car Order Section End -------------------------------------------//

    Route::get('/{order_type}/order/history', [OrderHistoryController::class, 'History'])->name('user-order-history');
    Route::get('/car/order/history/datatables', [OrderHistoryController::class, 'carDatatables'])->name('user-car-datatables-orders-history');
    Route::get('/hotel/order/history/datatables', [OrderHistoryController::class, 'hotelDatatables'])->name('user-hotel-datatables-orders-history');
    Route::get('/space/order/history/datatables', [OrderHistoryController::class, 'spaceDatatables'])->name('user-space-datatables-orders-history');
    Route::get('/tour/order/history/datatables', [OrderHistoryController::class, 'tourDatatables'])->name('user-tour-datatables-orders-history');
    Route::post('/order/cancel/submit', [OrderHistoryController::class, 'orderCancel'])->name('user.order.cancel');


    // ------------------------ USER NOTIFICATION SECTION -------------------//
    Route::get('notification/count', [UserNotificationController::class, 'notf_count'])->name('user-notification-count');
    Route::get('notification/show', [UserNotificationController::class, 'notf_show'])->name('user-order-notf-show');
    Route::get('notification/clear', [UserNotificationController::class, 'notf_clear'])->name('user-order-notf-clear');
    // ------------------------- USER NOTIFICATION SECTION END --------------//

    // ------------------------- USER WITHDRAW SECTION START ---------------//
    Route::get('withdraw/datatables', [UserWithdrawController::class, 'datatables'])->name('user-withdraw-datatables');
    Route::get('withdraws', [UserWithdrawController::class, 'index'])->name('user-withdraw-index');
    Route::get('withdraw/create', [UserWithdrawController::class, 'create'])->name('user-withdraw-create');
    Route::post('withdraw/store', [UserWithdrawController::class, 'store'])->name('user-withdraw-store');
    Route::get('withdraw/edit/{id}', [UserWithdrawController::class, 'edit'])->name('user-withdraw-edit');
    Route::get('withdraw/edit/update/{id}', [UserWithdrawController::class, 'update'])->name('user-withdraw-update');
    // ------------------------- USER WITHDRAW SECTION END -----------------//
});


// ************************ FRONT ROUTE SECTION START ******************************//

Route::get('/', [FrontendController::class, 'index'])->name('front.index');
Route::get('/faq', [FrontendController::class, 'faq'])->name('front.faq');
Route::get('contact', [FrontendController::class, 'contact'])->name('front.contact');
Route::get('language/setup', [FrontendController::class, 'languageSet'])->name('front.language.setup');
Route::get('currency/setup', [FrontendController::class, 'currencySet'])->name('front.currency.setup');

Route::post('contact/submit', [FrontendController::class, 'contactemail'])->name('front.contact.submit');
Route::post('/newsletter/post/email', [FrontendController::class, 'subscribe'])->name('newsletter.post');

// **************************** GLOBAL CAPTCHA **********************************************//
Route::get('/contact/refresh_code', [FrontendController::class, 'refresh_code']);
// **************************** GLOBAL CAPTCHA **********************************************//

// BLOG SECTION
Route::get('/blog', [FrontendController::class, 'blog'])->name('front.blog');
Route::get('blog/{slug}', [FrontendController::class, 'blogshow'])->name('front.blog.show');
Route::get('/blog/category/{slug}', [FrontendController::class, 'blogcategory'])->name('front.blogcategory');
Route::get('/blog/tag/{slug}', [FrontendController::class, 'blogtags'])->name('front.blogtags');
Route::get('/blog-search', [FrontendController::class, 'blogsearch'])->name('front.blogsearch');
Route::get('/blog/archive/{slug}', [FrontendController::class, 'blogarchive'])->name('front.blogarchive');

Route::get('tours', [BookingController::class, 'tour'])->name('front.tours');
Route::get('tour/search/', [BookingController::class, 'tourSearch'])->name('front.tours.ajax');
Route::get('tour/{slug}', [BookingController::class, 'tourDetails'])->name('tour.details');
Route::get('favarite/all/{id_type}', [BookingController::class, 'favarite'])->name('front.favarite');
Route::post('/tour/book/store', [TourCheckoutController::class, 'booking'])->name('tour.book');
Route::get('tour/booking/checkout', [TourCheckoutController::class, 'checkout'])->name('tour.checkout');

Route::get('hotels/', [BookingController::class, 'hotel'])->name('front.hotels');
Route::post('/hotel/room/book', [HotelCheckoutController::class, 'booking'])->name('front.checkout');
Route::get('hotel/booking/checkout', [HotelCheckoutController::class, 'checkout'])->name('hotel.checkout');
Route::get('hotel/{slug}', [BookingController::class, 'hotelDetails'])->name('hotel.details');
Route::get('hotel/room/ajax/search', [HotelCheckoutController::class, 'hotelRoomGet'])->name('hotel.room.search');

Route::get('spaces', [BookingController::class, 'space'])->name('front.spaces');
Route::get('space/{slug}', [BookingController::class, 'spaceDetails'])->name('space.details');
Route::post('/space/book/store', [SpaceCheckoutController::class, 'booking'])->name('space.book');
Route::get('space/booking/checkout', [SpaceCheckoutController::class, 'checkout'])->name('space.checkout');
Route::get('space/availability/check', [SpaceCheckoutController::class, 'checkAvailability'])->name('space.availability.check');

Route::get('cars/', [BookingController::class, 'cars'])->name('front.cars');
Route::get('cars/{slug}', [BookingController::class, 'cardetails'])->name('car.details');
Route::post('/car/book/store', [CarCheckoutController::class, 'booking'])->name('car.book');
Route::get('car/booking/checkout', [CarCheckoutController::class, 'checkout'])->name('car.checkout');
Route::get('car/availability/check', [CarCheckoutController::class, 'checkAvailability'])->name('car.availability.check');


// CHECKOUT SECTION ENDS
Route::post('/hotel/stripe/submit', [StripeController::class, 'store'])->name('stripe.submit');
Route::post('hotel/offline/checkout/submit', [OfflinePayment::class, 'store'])->name('offline.payment');
Route::post('car/chackout/stripe/submit', [CarStripeController::class, 'store'])->name('car.stripe.payment');
Route::post('car/offline/submit', [CarOfflineController::class, 'store'])->name('car.offline.payment');
Route::post('/space/stripe/submit', [SpaceStripeController::class, 'store'])->name('space.stripe.submit');
Route::post('space/offline/checkout/submit', [SpaceOfflineController::class, 'store'])->name('space.offline.payment');
Route::post('/car/stripe/submit', [TourStripeController::class, 'store'])->name('tour.stripe.submit');
Route::post('car/offline/checkout/submit', [TourOfflineController::class, 'store'])->name('tour.offline.payment');


Route::post('tour/instamojo/checkout/submit', [TourInstamojoController::class, 'store'])->name('tour.instamojo.payment');
Route::get('tour/instamojo/checkout/notify', [TourInstamojoController::class, 'notify'])->name('tour.instamojo.notify');

Route::post('tour/mollie/checkout/submit', [TourMollieController::class, 'store'])->name('tour.mollie.payment');
Route::get('tour/mollie/checkout/notify', [TourMollieController::class, 'notify'])->name('tour.mollie.notify');

Route::post('space/instamojo/checkout/submit', [SpaceInstamojoController::class, 'store'])->name('space.instamojo.payment');
Route::get('space/instamojo/checkout/notify', [SpaceInstamojoController::class, 'notify'])->name('space.instamojo.notify');

Route::post('space/mollie/checkout/submit', [SpaceMollieController::class, 'store'])->name('space.mollie.payment');
Route::get('space/mollie/checkout/notify', [SpaceMollieController::class, 'notify'])->name('space.mollie.notify');

Route::post('hotel/instamojo/checkout/submit', [HotelInstamojoController::class, 'store'])->name('hotel.instamojo.payment');
Route::get('hotel/instamojo/checkout/notify', [HotelInstamojoController::class, 'notify'])->name('hotel.instamojo.notify');

Route::post('car/instamojo/checkout/submit', [CarInstamojoController::class, 'store'])->name('car.instamojo.payment');
Route::get('car/instamojo/checkout/notify', [CarInstamojoController::class, 'notify'])->name('car.instamojo.notify');

Route::post('car/mollie/checkout/submit', [CarMollieController::class, 'store'])->name('car.mollie.payment');
Route::get('car/mollie/checkout/notify', [CarMollieController::class, 'notify'])->name('car.mollie.notify');


Route::post('hotel/mollie/checkout/submit', [HotelMollieController::class, 'store'])->name('hotel.mollie.payment');
Route::get('hotel/mollie/checkout/notify', [HotelMollieController::class, 'notify'])->name('hotel.mollie.notify');


Route::post('/hotel/rezorpay/checkout/submit', [HotelRezorpayController::class, 'store'])->name('hotel.rezorpay.payment');
Route::post('/hotel/rezorpay/checkout/notify', [HotelRezorpayController::class, 'notify'])->name('hotel.rezorpay.notify');

Route::post('/car/rezorpay/checkout/submit', [CarRezorpayController::class, 'store'])->name('car.rezorpay.payment');
Route::post('/car/rezorpay/checkout/notify', [CarRezorpayController::class, 'notify'])->name('car.rezorpay.notify');

Route::post('/space/rezorpay/checkout/submit', [SpaceRezorpayController::class, 'store'])->name('space.rezorpay.payment');
Route::post('/space/rezorpay/checkout/notify', [SpaceRezorpayController::class, 'notify'])->name('space.rezorpay.notify');

Route::post('/tour/rezorpay/checkout/submit', [TourRezorpayController::class, 'store'])->name('tour.rezorpay.payment');
Route::post('/tour/rezorpay/checkout/notify', [TourRezorpayController::class, 'notify'])->name('tour.rezorpay.notify');

Route::post('tour/paypal/checkout/submit', [TourPaypalController::class, 'store'])->name('tour.paypal.payment');
Route::get('tour/paypal/checkout/notify', [TourPaypalController::class, 'notify'])->name('tour.paypal.notify');

Route::post('space/paypal/checkout/submit', [SpacePaypalController::class, 'store'])->name('space.paypal.payment');
Route::get('space/paypal/checkout/notify', [SpacePaypalController::class, 'notify'])->name('space.paypal.notify');

Route::post('hotel/paypal/checkout/submit', [HotelPaypalController::class, 'store'])->name('hotel.paypal.payment');
Route::get('hotel/paypal/checkout/notify', [HotelPaypalController::class, 'notify'])->name('hotel.paypal.notify');

Route::post('car/paypal/checkout/submit', [CarPaypalController::class, 'store'])->name('car.paypal.payment');
Route::get('car/paypal/checkout/notify', [CarPaypalController::class, 'notify'])->name('car.paypal.notify');



Route::post('tour/authorize/checkout/submit', [TourAuthorizeController::class, 'store'])->name('tour.authorize.payment');
Route::post('space/authorize/checkout/submit', [SpaceAuthorizeController::class, 'store'])->name('space.authorize.payment');
Route::post('hotel/authorize/checkout/submit', [HotelAuthorizeController::class, 'store'])->name('hotel.authorize.payment');
Route::post('car/authorize/checkout/submit', [CarAuthorizeController::class, 'store'])->name('car.authorize.payment');

// ... (similar for other Authorize.net routes)


Route::post('hotel/paystack/checkout/submit', [HotelPaystackController::class, 'store'])->name('hotel.paystack.payment');
Route::post('tour/paystack/checkout/submit', [TourPaystackController::class, 'store'])->name('tour.paystack.payment');
Route::post('space/paystack/checkout/submit', [SpacePaystackController::class, 'store'])->name('space.paystack.payment');
Route::post('car/paystack/checkout/submit', [CarPaystackController::class, 'store'])->name('car.paystack.payment');

// ... (similar for other Paystack routes)

Route::post('hotel/mercadopago/checkout/submit', [HotelMercadopagoController::class, 'store'])->name('hotel.mercadopago.payment');
Route::post('tour/mercadopago/checkout/submit', [TourMercadopagoController::class, 'store'])->name('tour.mercadopago.payment');
Route::post('space/mercadopago/checkout/submit', [SpaceMercadopagoController::class, 'store'])->name('space.mercadopago.payment');
Route::post('car/mercadopago/checkout/submit', [CarMercadopagoController::class, 'store'])->name('car.mercadopago.payment');

// ... (similar for other MercadoPago routes)

Route::get('front/success', [FrontendController::class, 'success'])->name('front.success');

Route::post('front/search', [FrontendController::class, 'search'])->name('front.search');
Route::post('front/review/store', [FrontReviewController::class, 'reviewstore'])->name('front.review.store');
Route::post('the/genius/ocean/2441139', [FrontendController::class, 'subscription']);
Route::get('finalize', [FrontendController::class, 'finalize']);

Route::get('/{slug}', [FrontendController::class, 'pages'])->name('front.pages');
// ************************ FRONT ROUTE SECTION END ******************************//