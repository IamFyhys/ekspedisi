<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StaffRegistrationController;
use App\Http\Controllers\ManagerApplicationController;
use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\TransitController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\PickupCourierController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-foto', [ProfileController::class, 'uploadFoto'])->name('profile.upload-foto');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Shipment Management
    Route::resource('shipments', ShipmentController::class);
    Route::post('/shipments/calculate-rate', [ShipmentController::class, 'calculateRate'])->name('shipments.calculate');
    Route::post('/shipments/{shipment}/cancel', [ShipmentController::class, 'cancel'])->name('shipments.cancel');
    Route::get('/shipments/{shipment}/print', [ShipmentController::class, 'printReceipt'])->name('shipments.print');
    Route::post('/shipments/{shipment}/mark-paid', [ShipmentController::class, 'markAsPaid'])->name('shipments.mark-paid');
    Route::get('/subdistricts', [ShipmentController::class, 'getSubdistricts'])->name('subdistricts.index');

    // Branch & Rate Management
    Route::resource('branches', BranchController::class);
    Route::resource('rates', RateController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// Kasir
Route::middleware(['auth', 'role:cashier'])
    ->prefix('cashier')
    ->name('cashier.')
    ->group(function () {
        Route::get('/dashboard', [CashierController::class, 'dashboard'])->name('dashboard');
        Route::get('/transactions', [CashierController::class, 'transactions'])->name('transactions');
        Route::get('/drawer', [CashierController::class, 'drawer'])->name('drawer');
        Route::post('/drawer/open', [CashierController::class, 'openDrawer'])->name('drawer.open');
        Route::post('/drawer/close', [CashierController::class, 'closeDrawer'])->name('drawer.close');
        Route::post('/receive-cod', [CashierController::class, 'receiveCOD'])->name('receive-cod');
        Route::get('/shifts', [CashierController::class, 'shifts'])->name('shifts');
        Route::post('/shipment/create', [CashierController::class, 'createShipment'])->name('shipment.create');
        Route::post('/payment/cash', [CashierController::class, 'processCash'])->name('payment.cash');
        Route::post('/payment/midtrans/create', [PaymentController::class, 'createMidtransPayment'])->name('payment.midtrans.create');
        Route::get('/pickups', [CashierController::class, 'pickups'])->name('pickups');
        Route::post('/pickup/process', [CashierController::class, 'processPickup'])->name('pickup.process');
        Route::get('/search-customer', [CashierController::class, 'searchCustomer'])->name('search.customer');
    });

// Kurir Transit
Route::middleware(['auth', 'role:courier_transit'])
    ->prefix('courier/transit')
    ->name('courier.transit.')
    ->group(function () {
        Route::get('/', [TransitController::class, 'dashboard'])->name('dashboard');
        Route::get('/manifest-out', [TransitController::class, 'manifestOut'])->name('manifest-out');
        Route::post('/manifest-out/scan', [TransitController::class, 'scanOut'])->name('manifest-out.scan');
        Route::post('/manifest-out/depart', [TransitController::class, 'depart'])->name('manifest-out.depart');
        Route::get('/manifest-in', [TransitController::class, 'manifestIn'])->name('manifest-in');
        Route::post('/manifest-in/scan', [TransitController::class, 'scanIn'])->name('manifest-in.scan');
        Route::post('/manifest-in/confirm', [TransitController::class, 'confirmArrival'])->name('manifest-in.confirm');
        Route::get('/trips', [TransitController::class, 'tripLogs'])->name('trips');
        Route::get('/laporan', [TransitController::class, 'laporan'])->name('laporan');
    });

// Kurir Dashboard (Delivery & Pickup) — Unified like JNE
Route::middleware(['auth', 'role:courier_delivery,courier_pickup'])
    ->prefix('courier/delivery')
    ->name('courier.delivery.')
    ->group(function () {
        Route::get('/', [DeliveryController::class, 'dashboard'])->name('dashboard');
        Route::post('/confirm', [DeliveryController::class, 'confirmDelivery'])->name('confirm');
        Route::post('/confirm-pickup', [DeliveryController::class, 'confirmPickup'])->name('confirm-pickup');
        Route::post('/accept-pickup', [DeliveryController::class, 'acceptPickup'])->name('accept-pickup');
        Route::post('/arrived-pickup', [DeliveryController::class, 'arrivedAtBranch'])->name('arrived-pickup');
        Route::post('/failed', [DeliveryController::class, 'reportFailed'])->name('failed');
        Route::post('/retry', [DeliveryController::class, 'retryDelivery'])->name('retry');
        Route::get('/laporan', [DeliveryController::class, 'laporan'])->name('laporan');
    });

// Manager Dashboard Routes
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
    Route::get('/applications', [ManagerController::class, 'applications'])->name('applications');
    Route::post('/applications/{id}/review', [ManagerController::class, 'reviewApplication'])->name('applications.review');
    Route::post('/applications/{id}/reject', [ManagerController::class, 'rejectApplication'])->name('applications.reject');
    Route::get('/transaksi', [ManagerController::class, 'transaksi'])->name('transaksi');
    Route::get('/gudang', [ManagerController::class, 'gudang'])->name('gudang');
    Route::get('/pickups', [ManagerController::class, 'pickups'])->name('pickups');
    Route::post('/assign-courier', [ManagerController::class, 'assignCourier'])->name('assign-courier');
    
    // Staff Management
    Route::get('/staff', [ManagerController::class, 'staff'])->name('staff');
    Route::get('/staff/lamaran', [ManagerApplicationController::class, 'index'])->name('staff.lamaran');
    Route::get('/staff/{user}', [ManagerController::class, 'staffShow'])->name('staff.show');
    Route::post('/staff/lamaran/{user}/forward', [ManagerApplicationController::class, 'forward'])->name('staff.lamaran.forward');
    Route::post('/staff/lamaran/{user}/reject', [ManagerApplicationController::class, 'reject'])->name('staff.lamaran.reject');
    Route::get('/shift', [ManagerController::class, 'shift'])->name('shift');
    
    // Finance & Audit
    Route::get('/audit', [ManagerController::class, 'audit'])->name('audit');
    Route::post('/audit/approve/{id}', [ManagerController::class, 'approveShift'])->name('audit.approve');
    Route::get('/omzet', [ManagerController::class, 'omzet'])->name('omzet');
    
    // System
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');

    // Pickup Management
    Route::post('/pickup/assign', [ManagerController::class, 'assignPickupCourier'])->name('pickup.assign');
});

require __DIR__.'/auth.php';

// Public Tracking
Route::get('/tracking', [TrackingController::class, 'show'])->name('tracking');
Route::get('/tracking/{resi}', [TrackingController::class, 'show'])->name('tracking.show');
Route::post('/tracking', [TrackingController::class, 'show'])->name('tracking.search');
Route::get('/tracking/resi/{tracking_number}', [TrackingController::class, 'show'])->name('tracking.get');

// Public Pickup Request
Route::get('/pickup', [PickupController::class, 'index'])->name('pickup.index');
Route::post('/pickup', [PickupController::class, 'store'])->name('pickup.store');
Route::get('/pickup/success', [PickupController::class, 'success'])->name('pickup.success');
Route::get('/pickup/track/{code?}', [PickupController::class, 'track'])->name('pickup.track');

// Public Tools (Cek Tarif & Cabang)
Route::get('/cek-tarif', [PublicController::class, 'cekTarif'])->name('cek-tarif');
Route::post('/cek-tarif', [PublicController::class, 'hitungTarif'])->name('cek-tarif.hitung');
Route::get('/cabang', [PublicController::class, 'cabang'])->name('cabang');

// Kurir Pickup Dashboard (Deprecated: Redirected to Unified Dashboard)
Route::middleware(['auth', 'role:courier_pickup'])
    ->prefix('courier/pickup')
    ->name('courier.pickup.')
    ->group(function () {
        Route::get('/', function() { return redirect()->route('courier.delivery.dashboard'); });
    });

// Public Staff Registration
Route::get('/register/staff', [StaffRegistrationController::class, 'create'])->name('register.staff');
Route::post('/register/staff', [StaffRegistrationController::class, 'store'])->name('register.staff.store');
Route::get('/register/success', function() {
    return view('auth.register-success');
})->name('register.success');

// Wilayah API Proxy
Route::get('/api/wilayah/provinces', [StaffRegistrationController::class, 'getProvinces']);
Route::get('/api/wilayah/regencies/{provinceId}', [StaffRegistrationController::class, 'getRegencies']);
Route::get('/api/wilayah/districts/{regencyId}', [StaffRegistrationController::class, 'getDistricts']);

// Admin Approval
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/approvals', [AdminApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{user}/approve', [AdminApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{user}/reject', [AdminApprovalController::class, 'reject'])->name('approvals.reject');
    
    // Global Monitoring
    Route::get('/monitoring', [App\Http\Controllers\AdminManagementController::class, 'monitoring'])->name('monitoring');
    Route::post('/assign-courier', [App\Http\Controllers\AdminManagementController::class, 'assignCourier'])->name('assign-courier');
});
