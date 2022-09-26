<?php

use App\Http\Livewire\Admin\AdminDashboard;
use App\Http\Livewire\Admin\AdminSaleComponent;
use App\Http\Livewire\Admin\Attribute\AdminAddAttributeComponent;
use App\Http\Livewire\Admin\Attribute\AdminAttributeComponent;
use App\Http\Livewire\Admin\Attribute\AdminEditAttributeComponent;
use App\Http\Livewire\Admin\Category\AdminAddCategoryComponent;
use App\Http\Livewire\Admin\Category\AdminAddSubcategory;
use App\Http\Livewire\Admin\Category\AdminCategoryComponent as CategoryAdminCategoryComponent;
use App\Http\Livewire\Admin\Category\AdminEditCategoryComponent;
use App\Http\Livewire\Admin\Category\AdminEditSubcategory;
use App\Http\Livewire\Admin\Category\AdminHomeCategoryComponent;
use App\Http\Livewire\Admin\Contact\AdminContactComponent;
use App\Http\Livewire\Admin\Coupon\AdminAddCouponComponent;
use App\Http\Livewire\Admin\Coupon\AdminCouponComponent;
use App\Http\Livewire\Admin\Coupon\AdminEditCouponComponent;
use App\Http\Livewire\Admin\HomeSlider\AdminAddHomeSliderComponent;
use App\Http\Livewire\Admin\HomeSlider\AdminEditHomeSliderComponent;
use App\Http\Livewire\Admin\HomeSlider\AdminHomeSliderComponent;
use App\Http\Livewire\Admin\Order\AdminOrderComponent;
use App\Http\Livewire\Admin\Order\AdminOrderDetailsComponent;
use App\Http\Livewire\Admin\Product\AdminAddProductComponent;
use App\Http\Livewire\Admin\Product\AdminEditProductComponent;
use App\Http\Livewire\Admin\Product\AdminProductComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CategoryComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\CustomerDashobard;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ProductDetails;
use App\Http\Livewire\SearchComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\ThankyouComponent;
use App\Http\Livewire\User\Order\UserOrderComponent;
use App\Http\Livewire\User\Order\UserOrderDetailsComponent;
use App\Http\Livewire\User\Review\UserReviewComponent;
use App\Http\Livewire\User\UserChangePassword;
use App\Http\Livewire\User\UserEditProfile;
use App\Http\Livewire\User\UserProfileComponent;
use App\Http\Livewire\WishlistComponent;
use Illuminate\Support\Facades\Route;

// Route::get( '/', function () {
//     return view( 'welcome' );
// } );

Route::get( '/', HomeComponent::class );

Route::get( '/shop', ShopComponent::class );

Route::get( '/product/{slug}', ProductDetails::class )->name( 'product.details' );
Route::get( '/product-category/{category_slug}/{scategory_slug?}', CategoryComponent::class )->name( 'product.category' );

Route::get( '/search', SearchComponent::class )->name( 'product.search' );

Route::get( '/cart', CartComponent::class )->name( 'product.cart' );

Route::get( '/wishlist', WishlistComponent::class )->name( 'product.wishlist' );

Route::get( '/checkout', CheckoutComponent::class )->name( 'checkout' );

Route::get( '/contact', ContactComponent::class )->name( 'contact' );

Route::get( '/thankyou', ThankyouComponent::class )->name( 'thankyou' );

//For User or Customer
Route::middleware( array( 'auth:sanctum', 'verified' ) )->group( function () {
    Route::get( 'user/dashboard', CustomerDashobard::class )->name( 'user.dashboard' );

    Route::get( 'user/profile', UserProfileComponent::class )->name( 'user.profile' );
    Route::get( 'user/profile/edit/{user_id}', UserEditProfile::class )->name( 'user.editProfile' );

    Route::get( 'user/orders', UserOrderComponent::class )->name( 'user.orders' );
    Route::get( 'user/orders/{order_id}', UserOrderDetailsComponent::class )->name( 'user.orderDetails' );

    Route::get( 'user/review/{order_item_id}', UserReviewComponent::class )->name( 'user.review' );

    Route::get( 'user/change-password', UserChangePassword::class )->name( 'user.changePassword' );
} );

//For Admin
Route::middleware( array( 'auth:sanctum', 'verified', 'adminAuth' ) )->group( function () {
    Route::get( 'admin/dashboard', AdminDashboard::class )->name( 'admin.dashboard' );

    Route::get( 'admin/category', CategoryAdminCategoryComponent::class )->name( 'admin.category' );
    Route::get( 'admin/category/add', AdminAddCategoryComponent::class )->name( 'admin.addCategory' );
    Route::get( 'admin/subCategory/add', AdminAddSubcategory::class )->name( 'admin.addSubcategory' );
    Route::get( 'admin/category/edit/{category_slug}', AdminEditCategoryComponent::class )->name( 'admin.editCategory' );
    Route::get( 'admin/subcategory/edit/{scategory_slug}', AdminEditSubcategory::class )->name( 'admin.editSubcategory' );
    Route::get( 'admin/home-categories', AdminHomeCategoryComponent::class )->name( 'admin.homeCategories' );

    Route::get( 'admin/product', AdminProductComponent::class )->name( 'admin.product' );
    Route::get( 'admin/product/add', AdminAddProductComponent::class )->name( 'admin.addProduct' );
    Route::get( 'admin/product/edit/{product_slug}', AdminEditProductComponent::class )->name( 'admin.editProduct' );

    Route::get( 'admin/attribute', AdminAttributeComponent::class )->name( 'admin.attribute' );
    Route::get( 'admin/attribute/add', AdminAddAttributeComponent::class )->name( 'admin.addAttribute' );
    Route::get( 'admin/attribute/edit/{attribute_id}', AdminEditAttributeComponent::class )->name( 'admin.editAttribute' );

    Route::get( 'admin/home-slider', AdminHomeSliderComponent::class )->name( 'admin.homeSlider' );
    Route::get( 'admin/home-slider/add', AdminAddHomeSliderComponent::class )->name( 'admin.addHomeSlider' );
    Route::get( 'admin/home-slider/edit/{slider_id}', AdminEditHomeSliderComponent::class )->name( 'admin.editHomeSlider' );

    Route::get( 'admin/sale', AdminSaleComponent::class )->name( 'admin.sale' );

    Route::get( 'admin/coupon/', AdminCouponComponent::class )->name( 'admin.coupon' );
    Route::get( 'admin/coupon/add', AdminAddCouponComponent::class )->name( 'admin.addCoupon' );
    Route::get( 'admin/coupon/edit/{coupon_id}', AdminEditCouponComponent::class )->name( 'admin.editCoupon' );

    Route::get( 'admin/orders', AdminOrderComponent::class )->name( 'admin.orders' );
    Route::get( 'admin/orders/{order_id}', AdminOrderDetailsComponent::class )->name( 'admin.orderDetails' );

    Route::get( 'admin/contact', AdminContactComponent::class )->name( 'admin.contact' );
} );
