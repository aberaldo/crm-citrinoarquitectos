<?php
use App\Http\Controllers\Services\BudgetServiceController;
// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('client', 'ClientCrudController');
    Route::crud('budget', 'BudgetCrudController');
    Route::get('budget/{id}/generatepdf', [BudgetServiceController::class, 'generatePdf']);
    Route::post('budget/getTotals', [BudgetServiceController::class, 'getTotals']);
}); // this should be the absolute last line of this file