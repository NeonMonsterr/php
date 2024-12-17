<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PharmacyStaffController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicineDataController;
use App\Http\Controllers\TrainingAndSupportController;
use App\Http\Controllers\Auth\PharmacyStaffAuthController;
use App\Http\Controllers\Auth\ClientAuthController;

// Welcome Route
Route::get('/home', function () {
    return view('home');
})->name('home');

// ========================== CLIENT ROUTES ==========================
// Route::prefix('clients')->name('clients.')->group(function () {
    Route::get('profile',[ClientController::class,'accessInfo'])->name('profile');
    Route::get('prescription',[ClientController::class,'showprescriptions'])->name('clientPrescription');
    // Additional routes
    Route::get('editContactDetails', [ClientController::class, 'editContactDetails'])->name('editContact');
    Route::post('editContactDetails', [ClientController::class, 'editContactDetails'])->name('editContact');
    Route::put('updateContactDetails', [ClientController::class, 'updateContactDetails'])->name('updateContactDetails');

// });

// ====================== PHARMACY STAFF ROUTES ======================
// Route::prefix('pharmacy-staff')->name('pharmacyStaff.')->group(function () {
    Route::get('clients/create', [PharmacyStaffController::class, 'createClient'])->name('createClient');
    Route::post('clients', [PharmacyStaffController::class, 'storeClient'])->name('storeClient');
    Route::get('clients/{id}/edit', [PharmacyStaffController::class, 'editClient'])->name('editClient');
    Route::put('clients/{id}', [PharmacyStaffController::class, 'updateClient'])->name('updateClient');
    Route::get('clients/{id}/prescriptions/create', [PharmacyStaffController::class, 'createPrescription'])->name('createPrescription');
    Route::post('clients/{id}/prescriptions', [PharmacyStaffController::class, 'storePrescription'])->name('storePrescription');
    Route::get('clients/{id}/edit-contact', [PharmacyStaffController::class, 'editContactDetails'])->name('editContactDetails');
    Route::put('clients/{id}/edit-contact', [PharmacyStaffController::class, 'updateContactDetails'])->name('updateContactDetails');
    Route::get('clients/{id}/edit-private', [PharmacyStaffController::class, 'editPrivateDetails'])->name('editPrivateDetails');
    Route::put('clients/{id}/edit-private', [PharmacyStaffController::class, 'updatePrivateDetails'])->name('updatePrivateDetails');
    Route::get('clients/{id}/edit-medical-history', [PharmacyStaffController::class, 'editMedicalHistory'])->name('editMedicalHistory');
    Route::put('clients/{id}/edit-medical-history', [PharmacyStaffController::class, 'updateMedicalHistory'])->name('updateMedicalHistory');
    Route::get('/pharmacyStaff/clients', [PharmacyStaffController::class, 'index'])->name('pharmacyStaff.clients.index');
    Route::get('/pharmacyStaff/clients/{id}', [PharmacyStaffController::class, 'showClient'])->name('showClient');
    Route::get('/medicines', [PharmacyStaffController::class, 'indexMedicines'])->name('pharmacyStaff.medicines.index');
    Route::get('/medicines/create', [PharmacyStaffController::class, 'createMedicine'])->name('pharmacyStaff.medicines.create');
    Route::post('/medicines', [PharmacyStaffController::class, 'storeMedicine'])->name('pharmacyStaff.medicines.store');
    Route::get('/medicines/{id}', [PharmacyStaffController::class, 'showMedicine'])->name('pharmacyStaff.medicines.show');
    Route::delete('/medicines/{id}', [PharmacyStaffController::class, 'destroyMedicine'])->name('pharmacyStaff.medicines.destroy');
    // In web.php (or routes file)
Route::prefix('pharmacyStaff/inventory')->group(function () {
    Route::get('/', [PharmacyStaffController::class, 'inventoryIndex'])->name('pharmacyStaff.inventory.index');
    Route::get('/create', [PharmacyStaffController::class, 'inventoryCreateView'])->name('pharmacyStaff.inventory.create');
    Route::post('/store', [PharmacyStaffController::class, 'inventoryStore'])->name('pharmacyStaff.inventory.store');
    Route::get('/{medicine_id}/edit', [PharmacyStaffController::class, 'inventoryEditView'])->name('pharmacyStaff.inventory.edit'); // Expect medicine_id instead of id
    Route::put('/{medicine_id}', [PharmacyStaffController::class, 'inventoryUpdate'])->name('pharmacyStaff.inventory.update');
    Route::delete('/{medicine_id}', [PharmacyStaffController::class, 'inventoryDestroy'])->name('pharmacyStaff.inventory.destroy');
});

Route::prefix('pharmacyStaff/trainings')->group(function () {
    Route::get('/', [PharmacyStaffController::class, 'trainingsIndex'])->name('pharmacyStaff.trainings.index');
    Route::get('/create', [PharmacyStaffController::class, 'trainingsCreateView'])->name('pharmacyStaff.trainings.create');
    Route::post('/store', [PharmacyStaffController::class, 'trainingsStore'])->name('pharmacyStaff.trainings.store');
    Route::get('/{training_id}', [PharmacyStaffController::class, 'trainingsShow'])->name('pharmacyStaff.trainings.show');
    Route::get('/{training_id}/edit', [PharmacyStaffController::class, 'trainingsEditView'])->name('pharmacyStaff.trainings.edit');
    Route::put('/{training_id}', [PharmacyStaffController::class, 'trainingsUpdate'])->name('pharmacyStaff.trainings.update');
    Route::delete('/{training_id}', [PharmacyStaffController::class, 'trainingsDestroy'])->name('pharmacyStaff.trainings.destroy');
});



// });

// ======================= PRESCRIPTION ROUTES =======================
// Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
//     Route::get('/', [PrescriptionController::class, 'indexView'])->name('index');
//     Route::get('/create', [PrescriptionController::class, 'createView'])->name('create');
//     Route::post('/', [PrescriptionController::class, 'store'])->name('store');
//     Route::get('/{id}', [PrescriptionController::class, 'showView'])->name('show');
//     Route::get('/{id}/edit', [PrescriptionController::class, 'editView'])->name('edit');
//     Route::put('/{id}', [PrescriptionController::class, 'update'])->name('update');
//     Route::delete('/{id}', [PrescriptionController::class, 'destroy'])->name('destroy');
// });

// ====================== MEDICINE DATA ROUTES ======================
// Route::prefix('medicines')->name('medicines.')->group(function () {
//     Route::get('/', [MedicineDataController::class, 'indexView'])->name('index');
//     Route::get('/create', [MedicineDataController::class, 'createView'])->name('create');
//     Route::post('/', [MedicineDataController::class, 'store'])->name('store');
//     Route::get('/{id}', [MedicineDataController::class, 'showView'])->name('show');
//     Route::get('/{id}/edit', [MedicineDataController::class, 'editView'])->name('edit');
//     Route::put('/{id}', [MedicineDataController::class, 'update'])->name('update');
//     Route::delete('/{id}', [MedicineDataController::class, 'destroy'])->name('destroy');
// });

// ================= TRAINING AND SUPPORT ROUTES =================
// Route::prefix('training-support')->name('training_support.')->group(function () {
//     Route::get('/', [TrainingAndSupportController::class, 'indexView'])->name('index');
//     Route::get('/create', [TrainingAndSupportController::class, 'createView'])->name('create');
//     Route::post('/', [TrainingAndSupportController::class, 'store'])->name('store');
//     Route::get('/{id}', [TrainingAndSupportController::class, 'showView'])->name('show');
// });

// ====================== CLIENT AUTH ROUTES ======================
// Route::prefix('client')->name('auth.client.')->group(function () {
    // Route::get('login', [ClientAuthController::class, 'showLoginForm'])->name('login');
    // Route::post('login', [ClientAuthController::class, 'login']);
    // Route::get('register', [ClientAuthController::class, 'showRegisterForm'])->name('register');
    // Route::post('register', [ClientAuthController::class, 'register']);
    // Route::post('logout', [ClientAuthController::class, 'logout'])->name('logout');

// });

// ===================== PHARMACY STAFF AUTH ROUTES =====================
// Route::prefix('staff')->name('staff.')->group(function () {
//     Route::get('login', [PharmacyStaffAuthController::class, 'showLoginForm'])->name('login');
//     Route::post('login', [PharmacyStaffAuthController::class, 'login']);
//     Route::get('register', [PharmacyStaffAuthController::class, 'showRegisterForm'])->name('register');
//     Route::post('register', [PharmacyStaffAuthController::class, 'register']);
//     Route::post('logout', [PharmacyStaffAuthController::class, 'logout'])->name('logout');
// });

