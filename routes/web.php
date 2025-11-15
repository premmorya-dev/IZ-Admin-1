<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\UpiIdController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseItemController;
use App\Http\Controllers\ExpenseController;

use App\Http\Middleware\CheckActiveSubscription;
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
// you can use verified middleware for verify email address.

// Route::get('/', function (){ return 'test'; });

//Email tracking route
Route::get('/email-open/{id}', function ($id) { 
    // Log email open into DB
    \DB::table('leads')
        ->where('id', $id)
        ->update([
            'is_opened' => 'Y',
            'opened_at' => now()
        ]);

    // Return a 1x1 transparent PNG
    $transparentImage = base64_decode(
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAA
         AAC0lEQVR42mP8z8AARwMDgP8BAG0BBsdo7FYAAAAASUVORK5CYII='
    );

    return response($transparentImage)
        ->header('Content-Type', 'image/png');
})->name('email.tracking');
//Email tracking route end

Route::get('/auth/callback', [DashboardController::class, 'handleCallback'])->name('auth.callback')->middleware('web');

Route::get('estimate/acceptance/{estimate_code}', [EstimateController::class, 'estimateAcceptance'])->name('estimate.acceptance');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/user/login', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');



    Route::group(['prefix' => '/invoice'], function () {
        Route::get('list', [InvoiceController::class, 'index'])->name('invoice.list');
        Route::get('add', [InvoiceController::class, 'create'])->name('invoice.add');
        Route::post('store', [InvoiceController::class, 'store'])->name('invoice.store')->middleware(CheckActiveSubscription::class);
        Route::post('destroy', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
        Route::get('edit/{invoice_code}', [InvoiceController::class, 'edit'])->name('invoice.edit');
        Route::post('view-model', [InvoiceController::class, 'viewModel'])->name('invoice.view.model');
        Route::post('update', [InvoiceController::class, 'update'])->name('invoice.update')->middleware(CheckActiveSubscription::class);
        Route::get('download/{invoice_code}', [InvoiceController::class, 'invoiceDownload'])->name('invoice.download');
        Route::post('bulk-download', [InvoiceController::class, 'downloadMultiple'])->name('invoice.bulk_download');
        Route::post('/bulk-delete', [InvoiceController::class, 'bulkDelete'])->name('invoice.bulk_delete');
        Route::post('/send-bulk-email', [InvoiceController::class, 'queueEmail'])->name('invoice.send_bulk_email');
        Route::post('/get-payment-form', [InvoiceController::class, 'getRecordPaymentForm'])->name('invoice.get_payment_form');
        Route::post('/record-payment', [InvoiceController::class, 'recordPayment'])->name('invoice.record_payment');
        Route::get('shortcode/{invoice_code}', [InvoiceController::class, 'shortcode'])->name('invoice.shortcode');
    });

    Route::group(['prefix' => '/bill'], function () {
        Route::get('list', [BillController::class, 'index'])->name('bill.list');
        Route::get('add', [BillController::class, 'create'])->name('bill.add');
        Route::post('store', [BillController::class, 'store'])->name('bill.store');
        Route::post('destroy', [BillController::class, 'destroy'])->name('bill.destroy');
        Route::get('edit/{bill_code}', [BillController::class, 'edit'])->name('bill.edit');
        Route::post('view-model', [BillController::class, 'viewModel'])->name('bill.view.model');
        Route::post('update', [BillController::class, 'update'])->name('bill.update');
        Route::get('download/{bill_code}', [BillController::class, 'billDownload'])->name('bill.download');
        Route::post('bulk-download', [BillController::class, 'downloadMultiple'])->name('bill.bulk_download');
        Route::post('/bulk-delete', [BillController::class, 'bulkDelete'])->name('bill.bulk_delete');
        Route::post('/get-payment-form', [BillController::class, 'getRecordPaymentForm'])->name('bill.get_payment_form');
        Route::post('/record-payment', [BillController::class, 'recordPayment'])->name('bill.record_payment');
        Route::get('shortcode/{bill_code}', [BillController::class, 'shortcode'])->name('bill.shortcode');
    });

    Route::group(['prefix' => '/estimate'], function () {

        Route::get('list', [EstimateController::class, 'index'])->name('estimate.list');
        Route::get('add', [EstimateController::class, 'create'])->name('estimate.add');
        Route::post('store', [EstimateController::class, 'store'])->name('estimate.store');
        Route::get('edit/{estimate_code}', [EstimateController::class, 'edit'])->name('estimate.edit');
        Route::post('update', [EstimateController::class, 'update'])->name('estimate.update');
        Route::post('destroy', [EstimateController::class, 'destroy'])->name('estimate.destroy');

        Route::get('download/{estimate_code}', [EstimateController::class, 'estimateDownload'])->name('estimate.download');
        Route::post('bulk-download', [EstimateController::class, 'downloadMultiple'])->name('estimate.bulk_download');
        Route::post('/bulk-delete', [EstimateController::class, 'bulkDelete'])->name('estimate.bulk_delete');
        Route::post('/send-bulk-email', [EstimateController::class, 'queueEmail'])->name('estimate.send_bulk_email');
        Route::post('view-model', [EstimateController::class, 'viewModel'])->name('estimate.view.model');
    });



    Route::group(['prefix' => '/client'], function () {

        Route::get('search', [ClientController::class, 'search'])->name('client.search');
        Route::get('list', [ClientController::class, 'index'])->name('client.list');
        Route::post('store', [ClientController::class, 'store'])->name('client.store')->middleware(CheckActiveSubscription::class);
        Route::post('update', [ClientController::class, 'update'])->name('client.update')->middleware(CheckActiveSubscription::class);
        Route::post('destroy', [ClientController::class, 'destroy'])->name('client.destroy');

        Route::post('add', [ClientController::class, 'add'])->name('client.add');
        Route::post('edit', [ClientController::class, 'edit'])->name('client.edit');
    });

    Route::group(['prefix' => '/vendor'], function () {

        Route::get('search', [VendorController::class, 'search'])->name('vendor.search');
        Route::get('list', [VendorController::class, 'index'])->name('vendor.list');
        Route::post('store', [VendorController::class, 'store'])->name('vendor.store');
        Route::post('update', [VendorController::class, 'update'])->name('vendor.update');
        Route::post('destroy', [VendorController::class, 'destroy'])->name('vendor.destroy');

        Route::post('add', [VendorController::class, 'add'])->name('vendor.add');
        Route::post('edit', [VendorController::class, 'edit'])->name('vendor.edit');
    });

    Route::group(['prefix' => '/tax'], function () {

        Route::get('list', [TaxController::class, 'index'])->name('tax.list');
        Route::get('add', [TaxController::class, 'create'])->name('tax.add');
        Route::post('store', [TaxController::class, 'store'])->name('tax.store');
        Route::post('edit', [TaxController::class, 'edit'])->name('tax.edit');
        Route::post('update', [TaxController::class, 'update'])->name('tax.update');
        Route::post('destroy', [TaxController::class, 'destroy'])->name('tax.destroy');
    });

    Route::group(['prefix' => '/discount'], function () {

        Route::get('list', [DiscountController::class, 'index'])->name('discount.list');
        Route::get('add', [DiscountController::class, 'create'])->name('discount.add');
        Route::post('store', [DiscountController::class, 'store'])->name('discount.store');
        Route::post('edit', [DiscountController::class, 'edit'])->name('discount.edit');
        Route::post('update', [DiscountController::class, 'update'])->name('discount.update');
        Route::post('destroy', [DiscountController::class, 'destroy'])->name('discount.destroy');
    });


    Route::group(['prefix' => '/upi-id'], function () {

        Route::get('list', [UpiIdController::class, 'index'])->name('upi_id.list');
        Route::get('add', [UpiIdController::class, 'create'])->name('upi_id.add');
        Route::post('store', [UpiIdController::class, 'store'])->name('upi_id.store');
        Route::get('edit/{upi_log_id}', [UpiIdController::class, 'edit'])->name('upi_id.edit');
        Route::post('update', [UpiIdController::class, 'update'])->name('upi_id.update');
        Route::post('destroy', [UpiIdController::class, 'destroy'])->name('upi_id.destroy');
    });


    Route::group(['prefix' => '/item'], function () {

        Route::get('list', [ItemController::class, 'index'])->name('item.list');
        Route::get('add', [ItemController::class, 'create'])->name('item.add');
        Route::post('store', [ItemController::class, 'store'])->name('item.store');
        Route::post('edit', [ItemController::class, 'edit'])->name('item.edit');
        Route::post('update', [ItemController::class, 'update'])->name('item.update');
        Route::post('destroy', [ItemController::class, 'destroy'])->name('item.destroy');

        Route::get('search', [ItemController::class, 'search'])->name('item.search');
    });



    Route::group(['prefix' => '/item/category'], function () {

        Route::get('list', [ItemCategoryController::class, 'index'])->name('item.category.list');
        Route::get('add', [ItemCategoryController::class, 'create'])->name('item.category.add');
        Route::post('store', [ItemCategoryController::class, 'store'])->name('item.category.store');
        Route::post('edit', [ItemCategoryController::class, 'edit'])->name('item.category.edit');
        Route::post('update', [ItemCategoryController::class, 'update'])->name('item.category.update');
        Route::post('destroy', [ItemCategoryController::class, 'destroy'])->name('item.category.destroy');
    });


    Route::group(['prefix' => '/expense/category'], function () {
        Route::get('list', [ExpenseCategoryController::class, 'index'])->name('expense.category.list');
        Route::get('add', [ExpenseCategoryController::class, 'create'])->name('expense.category.add');
        Route::post('store', [ExpenseCategoryController::class, 'store'])->name('expense.category.store');
        Route::get('edit/{expense_category_code}', [ExpenseCategoryController::class, 'edit'])->name('expense.category.edit');
        Route::post('update', [ExpenseCategoryController::class, 'update'])->name('expense.category.update');
        Route::post('destroy', [ExpenseCategoryController::class, 'destroy'])->name('expense.category.destroy');
    });

    Route::group(['prefix' => '/expense/item'], function () {
        Route::get('list', [ExpenseItemController::class, 'index'])->name('expense.item.list');
        Route::get('add', [ExpenseItemController::class, 'create'])->name('expense.item.add');
        Route::post('store', [ExpenseItemController::class, 'store'])->name('expense.item.store');
        Route::post('edit', [ExpenseItemController::class, 'edit'])->name('expense.item.edit');
        Route::post('update', [ExpenseItemController::class, 'update'])->name('expense.item.update');
        Route::post('destroy', [ExpenseItemController::class, 'destroy'])->name('expense.item.destroy');
        Route::get('search', [ExpenseItemController::class, 'search'])->name('expense.item.search');
    });

    Route::group(['prefix' => '/expense'], function () {
        Route::get('list', [ExpenseController::class, 'index'])->name('expense.list');
        Route::get('add', [ExpenseController::class, 'create'])->name('expense.add');
        Route::post('store', [ExpenseController::class, 'store'])->name('expense.store');
        Route::get('edit/{expense_code}', [ExpenseController::class, 'edit'])->name('expense.edit');
        Route::post('update', [ExpenseController::class, 'update'])->name('expense.update');
        Route::post('destroy', [ExpenseController::class, 'destroy'])->name('expense.destroy');


        Route::post('bulk-download', [ExpenseController::class, 'downloadMultiple'])->name('expense.bulk_download');
        Route::post('/bulk-delete', [ExpenseController::class, 'bulkDelete'])->name('expense.bulk_delete');
        Route::post('view-model', [ExpenseController::class, 'viewModel'])->name('expense.view.model');
    });



    Route::group(['prefix' => '/plan'], function () {

        Route::get('all-plans', [PlanController::class, 'upgrade'])->name('plan.upgrade');
        Route::get('plan/{plan_id}', [PlanController::class, 'planPayment'])->name('plan.payment');
        Route::post('payment-callback', [PlanController::class, 'paymentCallback'])->name('plan.payment_callback');
    });
    Route::get('payment-success', [PlanController::class, 'paymentSuccess'])->name('payment.success');

    Route::get('billing', [PlanController::class, 'billing'])->name('billing');

    Route::middleware(['auth', 'active.subscription'])->group(function () {
        Route::get('/test', function () {

            return "valid";
        });
    });

    Route::get('/subscription-error', function () {
        return view('pages/system.error-subscription');  // This view will automatically show the modal with errors
    })->name('subscription.error.page');


    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::post('/get-report', [ReportController::class, 'getReport'])->name('report.get');
    Route::get('/download-report', [ReportController::class, 'downloadReport'])->name('download.report');
    Route::get('/gst/json', [ReportController::class, 'generateFullGSTR1'])->name('gst.gstr1');

    Route::get('/settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/get-states', [SettingController::class, 'getStates'])->name('get.states.by.country');





    Route::get('/account/edit', [SettingController::class, 'account'])->name('settings.account');
    Route::post('/account/update', [SettingController::class, 'updateAccount'])->name('settings.account.update');

    Route::get('/search-client', [ClientController::class, 'searchClient'])->name('client.search2');


    Route::group(['prefix' => '/policy'], function () {
        Route::get('contact', [PolicyController::class, 'contact'])->name('policy.contact');
        Route::get('refund', [PolicyController::class, 'refund'])->name('policy.refund');
        Route::get('cookie', [PolicyController::class, 'cookie'])->name('policy.cookie');
        Route::get('privacy', [PolicyController::class, 'privacy'])->name('policy.privacy');
        Route::get('terms', [PolicyController::class, 'terms'])->name('policy.terms');
        Route::get('about', [PolicyController::class, 'about'])->name('policy.about');

        Route::post('contact', [PolicyController::class, 'storeContact'])->name('policy.store.contact');
    });
});



Route::get('/coming-soon', function () {
    return view('pages/system.coming_soon');
})->name('coming_soon');


Route::get('/payment', function () {
    return view('pages.test');
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
