<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\VariantInventoryController;
use App\Http\Controllers\Frontend\IndexController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// ---------------------------------------------------Admin Panel Routes-----------------------------------------------

// LOGIN ROUTES (only for guests)
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'loginPage'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// LOGOUT + PROTECTED ROUTES
Route::middleware(['auth.admin', 'set.admin.guard'])->prefix('admin')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    //Users
    Route::prefix('users')->name('admin.users.')->group(function () {
        Route::resource('', AdminController::class)->parameters([
            '' => 'id'
        ]);
        Route::get('/dashboard', [AdminController::class, 'show'])->name('dashboard');
    });

    //Roles
    Route::prefix('roles')->name('admin.roles.')->group(function () {
        Route::resource('', RoleController::class)->parameters([
            '' => 'id'
        ]);
    });

    //Categories
    Route::prefix('categories')->name('admin.categories.')->group(function () {
        Route::resource('', CategoryController::class)->parameters([
            '' => 'id'
        ]);
    });

    //Permission
    Route::prefix('permissions')->controller(PermissionController::class)->group(function () {
        Route::get('/', 'editPermissions')->name('role.permissions.edit');
        Route::post('/saved', 'updatePermissions')->name('role.permissions.update');
    });

    //Brands
    Route::prefix('brands')->name('admin.brands.')->group(function () {
        Route::resource('', BrandController::class)->parameters([
            '' => 'id'
        ]);
    });

    //Attributes
    Route::prefix('attributes')->name('admin.attributes.')->group(function () {
        Route::resource('', AttributeController::class)->parameters([
            '' => 'id'
        ]);
    });

    //AttributeValues
    Route::prefix('attribute-value')->controller(AttributeValueController::class)->group(function () {
        Route::get('/list', 'index')->name('attributeValue.list');
        Route::get('/create', 'create')->name('attributeValue.create');
        Route::post('/bulk-store', 'bulkStore')->name('attributeValue.bulkStore');
        Route::put('/{id}/update', 'update')->name('attributeValue.update');
        Route::post('/update-sort-order', 'updateSortOrder')->name('attributeValue.sort');
        Route::delete('/{id}/delete', 'destroy')->name('attributeValue.delete');
    });

    //Products
    Route::prefix('product')->controller(ProductController::class)->group(function () {
        Route::get('/list', 'index')->name('product.list');
        Route::get('/create', 'create')->name('product.create');
        Route::post('/store', 'store')->name('product.store');
        Route::get('/{product}/edit', 'edit')->name('product.edit');
        Route::put('/{product}/update', 'update')->name('product.update');
        Route::delete('/{id}/delete', 'destroy')->name('product.delete');

        Route::put('products/{product}/seo', 'updateSeo')->name('product.seo.update');
        Route::post('/product-image/upload', 'upload')->name('product.image.upload');
        Route::delete('/product-image/delete/{id}', 'deleteImage')->name('product.image.delete');
        Route::post('/product-image/sort', 'sortImages')->name('product.image.sort');
        Route::post('/{product}/variants/save', 'saveVariants')->name('product.variants.save');
    });

    //Product Variant
    Route::prefix('variant')->controller(VariantInventoryController::class)->group(function () {
        Route::get('/list', 'index')->name('product.variants.list');
        Route::post('/inventory/update', 'update')->name('product.variants.updateInventory');
    });

    //coupons
    Route::prefix('coupons')->name('admin.coupons.')->group(function () {
        Route::resource('', CouponController::class)->parameters([
            '' => 'id'
        ]);
        Route::post('/{id}/toggle-status', [CouponController::class, 'toggleStatus'])->name('toggleStatus');
    });

    //customers
    Route::prefix('customers')->name('admin.customers.')->group(function () {
        Route::resource('', CustomerController::class)->parameters([
            '' => 'id'
        ]);

    });


});

// ____________________________________________________________Frontend Routes______________________________________________________________________

Route::get('/',[IndexController::class,'index'])->name('index');
