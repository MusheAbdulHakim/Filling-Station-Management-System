<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.


Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    // -----
    // CRUDs
    // -----
    
    // ------------------
    // AJAX Chart Widgets
    // ------------------
    Route::get('charts/users', 'Charts\LatestUsersChartController@response');
    Route::get('charts/new-entries', 'Charts\NewEntriesChartController@response');

    // ---------------------------
    // Backpack DEMO Custom Routes
    // Prevent people from doing nasty stuff in the online demo
    // ---------------------------
    if (app('env') == 'production') {
        // disable delete and bulk delete for all CRUDs
        $cruds = ['article', 'category', 'tag', 'monster', 'icon', 'product', 'page', 'menu-item', 'user', 'role', 'permission'];
        foreach ($cruds as $name) {
            Route::delete($name.'/{id}', function () {
                return false;
            });
            Route::post($name.'/bulk-delete', function () {
                return false;
            });
        }
    }
    Route::crud('unit', 'UnitCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('supplier', 'SupplierCrudController');
    Route::crud('purchase', 'PurchaseCrudController');
    Route::crud('expense-category', 'ExpenseCategoryCrudController');
    Route::crud('expense', 'ExpenseCrudController');
    Route::crud('designation', 'DesignationCrudController');
    Route::crud('employee', 'EmployeeCrudController');
    Route::get('charts/latest-purchase', 'Charts\LatestPurchaseChartController@response')->name('charts.latest-purchase.index');
    Route::crud('sale', 'SaleCrudController');
    Route::crud('check-in', 'CheckInCrudController');
    Route::crud('check-out', 'CheckOutCrudController');
}); // this should be the absolute last line of this file