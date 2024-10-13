<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BilanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\EntiteController;
use App\Http\Controllers\FamilleController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\UnitGroupController;
use App\Http\Controllers\AjustementController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\GaspillageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\SousFamilleController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ModifGaspillageController;
use App\Http\Controllers\Account\SettingsController;

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

Route::middleware('auth')->group(function () {

    Route::prefix('account')->group(function () {
        Route::get('settings/password/change', [SettingsController::class, 'passwordChangeView'])->name('settings.password.change');
        Route::post('settings-password-change-stote', [SettingsController::class, 'changePasswordStore'])->name('settings-password-change-store');
    });

    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings-post', [SettingController::class, 'store'])->name('settings.store');

    Route::resource('produits', ProduitController::class);
    Route::post('produit-view', [ProduitController::class, 'produit_view']);
    Route::post('produit-delete', [ProduitController::class, 'produit_delete']);
    Route::post('get-single-product', [ProduitController::class, 'get_single_product']);
    Route::post('delete-unit-product', [ProduitController::class, 'delete_unit_product']);
    Route::get('unit-product-select', [ProduitController::class, 'unit_product_select']);
    Route::get('charge-product-destination-select', [ProduitController::class, 'charge_product_destination_select']);
    Route::get('search-product-stock-depot', [ProduitController::class, 'search_product_stock_depot'])->name('search-product-stock-depot');
    Route::get('search-product-semi-fini', [ProduitController::class, 'search_product_semi_fini'])->name('search-product-semi-fini');
    Route::get('search-product-matiere-premiere', [ProduitController::class, 'search_product_matiere_premiere'])->name('search-product-matiere-premiere');
    Route::get('get-single-product-depot', [ProduitController::class, 'get_single_product_depot']);
    Route::get('products/stock-status', [ProduitController::class, 'products_stock_status'])->name('products-stock-status');
    Route::get('produit-select', [ProduitController::class, 'produit_select']);

    Route::resource('entites', EntiteController::class);
    Route::post('entite-view', [EntiteController::class, 'entite_view']);
    Route::post('entite-delete', [EntiteController::class, 'entite_delete']);

    Route::resource('departements', DepartementController::class);
    Route::post('departement-view', [DepartementController::class, 'departement_view']);
    Route::post('departement-delete', [DepartementController::class, 'departement_delete']);


    Route::resource('permissions',PermissionController::class);
    Route::post('delete-permission', [PermissionController::class, 'permission_delete']);
    Route::get('users/permissions/{id}/edit', [PermissionController::class, 'permission_user_edit'])->name('users-permission-edit');
    Route::put('store-user-permission/{id}', [PermissionController::class, 'storeUserPermission'])->name('store.user.permission');

    Route::resource('roles',RoleController::class);
    Route::post('delete-role', [RoleController::class, 'delete_role']);

    Route::get('users', [UserController::class, 'users_index'])->name('users.index');
    Route::get('check-email-exist',[UserController::class, 'check_email_exist']);
    Route::get('check-username-exist',[UserController::class, 'check_username_exist']);
    Route::get('users/create', [UserController::class, 'users_create'])->name('users.create');
    Route::post('users-store', [UserController::class, 'users_store'])->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'users_edit'])->name('users.edit');
    Route::put('users-edit-password/{id}', [UserController::class, 'users_edit_password'])->name('users-edit-password');
    Route::put('users-edit-email/{id}', [UserController::class, 'users_edit_email'])->name('users-edit-email');
    Route::put('users-edit-role/{id}', [UserController::class, 'users_edit_role'])->name('users-edit-role');
    Route::post('disabled-account',[UserController::class, 'disabled_account'])->name('disabled-account');
    Route::post('activate-account',[UserController::class, 'activate_account'])->name('activate-account');
    Route::put('users-edit-username/{id}', [UserController::class, 'users_edit_username'])->name('users-edit-username');
    Route::put('users-edit-depot/{id}', [UserController::class, 'users_edit_entrepot'])->name('users-edit-depot');
    Route::post('delete-user',[UserController::class, 'destroy_user']);

    Route::resource('categories',CategorieController::class);
    Route::post('categorie-view', [CategorieController::class, 'categorie_view']);
    Route::post('categorie-delete', [CategorieController::class, 'categorie_delete']);

    Route::resource('sous-familles',SousFamilleController::class);
    Route::post('sous-famille-view', [SousFamilleController::class, 'sous_famille_view']);
    Route::post('sous-famille-delete', [SousFamilleController::class, 'sous_famille_delete']);

    Route::resource('familles',FamilleController::class);
    Route::post('famille-view', [FamilleController::class, 'famille_view']);
    Route::post('famille-delete', [FamilleController::class, 'famille_delete']);
    Route::get('export-famille', [FamilleController::class,'exportFamilleExcel'])->name('export-famille');

    Route::resource('unites',UniteController::class);
    Route::post('unite-view', [UniteController::class, 'unite_view']);
    Route::post('unite-delete', [UniteController::class, 'unite_delete']);
    Route::post('unit-select', [UniteController::class, 'unit_select']);
    Route::post('select-unit-group-unit', [UniteController::class, 'selectUnitGroupUnit']);

    Route::resource('fournisseurs', FournisseurController::class);
    Route::post('fournisseur-view', [FournisseurController::class, 'fournisseur_view']);
    Route::post('fournisseur-delete', [FournisseurController::class, 'fournisseur_delete']);
    Route::get('export-fournisseur', [FournisseurController::class,'exportFournisseurExcel'])->name('export-fournisseur');

    // commandes fournisseurs
    Route::get('purchases/providers', [ProcurementController::class,'procurementIndex'])->name('procurments.providers.index');
    Route::get('purchases/providers/create', [ProcurementController::class,'procurementCreate'])->name('procurments.providers.create');
    Route::get('purchases/providers/edit/{reference}', [ProcurementController::class,'procurementEdit'])->name('procurments.providers.edit');
    Route::post('purchase-store', [ProcurementController::class,'procurementStore'])->name('purchase-store');
    Route::put('purchase-update/{id}', [ProcurementController::class,'procurementUpdate'])->name('purchase-update');
    Route::get('purchases/providers/{id}/print', [ProcurementController::class,'procurementsView'])->name('procurments.providers.print');
    Route::get('purchases/providers/view/{reference}', [ProcurementController::class,'procurementView'])->name('procurments.providers.view');
    Route::post('closed-procurement-process', [ProcurementController::class, 'closedProcurementProcess'])->name('closed-procurement-process');
    Route::post('accepted-procurement-process', [ProcurementController::class,'acceptedProcurementProcess'])->name('accepted-procurement-process');
    Route::post('rejected-procurement-process', [ProcurementController::class,'rejectedProcurementProcess'])->name('rejected-procurement-process');
    Route::post('delete-procurement-item', [ProcurementController::class, 'delete_procurement_item']);
    //reception commande fournisseur


    Route::get('purchases/providers/receipt/create/{id}', [ReceptionController::class,'procurementReceiptCreate'])->name('procurments.providers.receipt.create');
    Route::get('purchases/providers/receipt/{id}/edit', [ReceptionController::class,'procurementReceiptEdit'])->name('procurments.providers.receipt.edit');
    Route::get('purchases/providers/receipt/{id}/print', [ReceptionController::class, 'procurementReceiptPrint'])->name('procurments.providers.receipt.print');
    Route::post('purchase-receipt-store', [ReceptionController::class,'procurementReceiptStore'])->name('purchase-receipt-store');
    Route::put('purchase-receipt-update/{id}', [ReceptionController::class,'procurementReceiptUpdate'])->name('purchase-receipt-update');
    Route::post('receipt-delete', [ReceptionController::class, 'receiptProductDelete']);
    Route::get('purchases/providers/receipt/view/{reference}', [ReceptionController::class,'procurmentsProvidersReceiptView'])->name('procurments.providers.receipt.view');
    Route::get('purchases/providers/receipt', [ReceptionController::class,'procurementReceiptIndex'])->name('procurments.providers.receipt');
    Route::post('cancel-receipt-process', [ReceptionController::class,'cancelReceiptProcess'])->name('cancel-receipt-process');


    Route::get('orders', [OrderController::class,'orderIndex'])->name('orders.index');
    Route::get('orders/create', [OrderController::class,'orderCreate'])->name('orders.create');
    Route::post('orders-store', [OrderController::class,'orderStore'])->name('orders.store');
    Route::post('delete-order-item', [OrderController::class,'deleteOrderItem']);
    Route::get('orders/edit/{reference}', [OrderController::class,'orderEdit'])->name('orders.edit');
    Route::put('orders-update/{reference}', [OrderController::class,'orderUpdate'])->name('orders.update');


    Route::get('orders/delivery/create/{reference}', [OrderController::class,'orderDeliveryCreate'])->name('orders.delivery.create');
    Route::get('orders/delivery/edit/{reference}', [OrderController::class,'orderDeliveryEdit'])->name('orders.delivery.edit');
    Route::post('orders-delivery-store', [OrderController::class,'orderDeliveryStore'])->name('orders.delivery.store');
    Route::post('delivery-order-send', [OrderController::class, 'senderOrderDelivery'])->name('delivery-order-send');

    Route::get('orders/print/{reference}', [OrderController::class,'orderPrint'])->name('orders.print');
    Route::get('orders/receipt', [OrderController::class,'orderReceiptIndex'])->name('orders.receipt');
    Route::get('orders/receipt/view{reference}', [OrderController::class,'orderReceiptView'])->name('orders.receipt.view');
    Route::get('orders/receipt/create/{reference}', [OrderController::class,'orderReceiptCreate'])->name('orders.receipt.create');
    Route::post('orders-receipt-store', [OrderController::class,'orderReceiptStore'])->name('orders.receipt.store');
    Route::post('accept-order-process', [OrderController::class, 'orderAcceptProcess'])->name('accept-order-process');
    Route::post('cancel-order-process', [OrderController::class, 'orderCancelProcess'])->name('cancel-order-process');
    Route::post('order-delete',[OrderController::class, 'orderDelete']);
    Route::post('order-validate', [OrderController::class, 'orderValidate']);
    Route::post('sender-order-delivery', [OrderController::class, 'senderOrderDelivery']);
    Route::post('close-order', [OrderController::class, 'closeOrderReceipt']);

    //gestion des bon de commande
    Route::get('orders/deposit', [OrderController::class,'orderStorehouseIndex'])->name('orders.deposit.index');
    Route::get('orders/deposit/view/{reference}', [OrderController::class,'orderStorehouseView'])->name('orders.deposit.view');
    Route::get('orders/deposit/delivery', [OrderController::class,'orderStorehouseDelivery'])->name('orders.deposit.delivery');
    Route::get('orders/deposit/delivery/{reference}/print', [OrderController::class,'orderDeliveryPrint'])->name('order.delivery.print');
    Route::post('delivery-accepted', [OrderController::class, 'deliveryAccepted']);
    Route::put('delivery-cancel/{id}', [OrderController::class, 'deliveryCancel'])->name('delivery-cancel');
    Route::get('orders/deposit/delivery/{reference}/view', [OrderController::class,'orderDeliveryView'])->name('order.delivery.view');

    //gestion commande
    Route::get('orders/production/create', [OrderController::class,'orderProductionCreate'])->name('orders.production.create');
    Route::get('orders/central/create', [OrderController::class,'orderCentralCreate'])->name('orders.central.create');
    /*Route::get('orders/cuisine/central', [OrderController::class,'orderCuisineCentral'])->name('orders.cuisine.central');*/

    Route::get('products/stock-adjustment', [AjustementController::class,'productAjustementIndex'])->name('products.ajustement.index');
    // Route::get('products/stock-adjustment/entry/create', [AjustementController::class,'productEntryStock'])->name('products.ajustement.entry.create');
    // Route::get('products/stock-adjustment/output/create', [AjustementController::class,'productOutputStock'])->name('products.ajustement.output.create');
    Route::get('products/stock-adjustment/create', [AjustementController::class,'productAjustementCreate'])->name('products.ajustement.create');
    Route::post('ajustement-store', [AjustementController::class, 'ajustementStore'])->name('ajustement-store');
    Route::post('ajustement-delete', [AjustementController::class, 'ajustementDelete'])->name('ajustement-delete');
    Route::get('type-ajustement-select', [AjustementController::class, 'typeAjustementSelect']);
    Route::get('products/stock-adjustment/stock-initialization', [AjustementController::class, 'stockInitialization'])->name('stock-initialization');
    Route::post('stock-initialization-store', [AjustementController::class, 'stockInitializationStore'])->name('stock-initialization-store');

    Route::get('squandering', [GaspillageController::class,'squanderingIndex'])->name('squandering.index');
    Route::get('squandering/create', [GaspillageController::class,'squanderingCreate'])->name('squandering.create');
    Route::post('squandering-store', [GaspillageController::class,'squanderingStore'])->name('squandering.store');


    Route::get('motifs-gaspillages', [ModifGaspillageController::class,'motifGaspillageIndex'])->name('motif-gaspillage.index');
    Route::post('motif-gaspillage-store', [ModifGaspillageController::class,'motifGaspillageStore'])->name('motif-gaspillage.store');
    Route::post('motif-gaspillage-view', [ModifGaspillageController::class,'motifGaspillageView']);
    Route::post('motif-gaspillage-delete', [ModifGaspillageController::class,'motifGaspillageDelete']);
    Route::get('selectionner-motif-gaspillage', [ModifGaspillageController::class,'selectionnerMotifGaspillage']);



    Route::get('recettes', [RecetteController::class, 'recetteIndex'])->name('index-recette');
    Route::get('recettes/create', [RecetteController::class, 'recetteCreate'])->name('recette-create');
    Route::post('recettes-store', [RecetteController::class, 'recetteStore'])->name('recette-store');
    Route::get('recettes/etit/{id}', [RecetteController::class, 'recetteEdit'])->name('edit-recette');
    Route::post('delete-fiche-item', [RecetteController::class, 'ficheItemDelete']);
    Route::put('recettes-update/{id}', [RecetteController::class, 'recetteUpdate'])->name('recette-update');
    Route::post('recette-delete', [RecetteController::class, 'recetteDelete']);
    Route::get('ajax-autocomplete-recette-search', [RecetteController::class, 'recetteSearch']);

    Route::get('bilan-produit-recette/create', [BilanController::class, 'BilanProduitRecetteCreate'])->name('bilan-produit-recette-create');
    Route::post('bilan-produit-recette-store', [BilanController::class, 'BilanProduitRecetteStore'])->name('bilan-produit-recette-store');
    Route::get('bilan-produit-recette', [BilanController::class, 'BilanProduitRecette'])->name('bilan-produit-recette');
    Route::post('bilan-recette-product-delete', [BilanController::class, 'BilanProduitRecetteDelete']);
    Route::get('bilan-produit-recette/view/{reference}', [BilanController::class, 'BilanProduitRecetteView'])->name('bilan-produit-recette-view');
    Route::get('export-bilan{reference}', [BilanController::class,'exportBilanExcel'])->name('export-bilan');
    Route::get('bilan-produit-recette/validate/{reference}', [BilanController::class, 'BilanProduitRecetteValidate'])->name('bilan-produit-recette-validate');
    Route::post('store-bilan-product-validate', [BilanController::class, 'storeBilanProductValidate'])->name('store-bilan-product-validate');


    Route::post('select-unit-arrived', [ConversionController::class,'selectUnitArrived']);
    Route::post('unit-group-select', [UnitGroupController::class,'unitGroupselect']);
    Route::get('unit-group-select-product', [UniteController::class, 'unit_group_select_product']);
    Route::post('select-unit-group-unit', [UniteController::class, 'selectUnitGroupUnit']);


    Route::group(['middleware' => ['role:super-admin']], function () {
        Route::get('conversions', [ConversionController::class,'conversionIndex'])->name('conversion.index');
        Route::post('conversion-store', [ConversionController::class,'conversionStore'])->name('conversion.store');
        Route::post('conversion-view', [ConversionController::class,'conversionView']);
        Route::post('conversion-delete', [ConversionController::class,'conversionDelete']);

        Route::get('units-groups', [UnitGroupController::class,'groupUnitIndex'])->name('unit-group-index');
        Route::post('unit-group-store', [UnitGroupController::class,'unitGroupStore'])->name('unit-group-store');
        Route::post('unit-group-view', [UnitGroupController::class,'unitGroupView']);
        Route::post('unit-group-delete', [UnitGroupController::class,'unitGroupDelete']);



        Route::resource('unites',UniteController::class);
        Route::post('unite-view', [UniteController::class, 'unite_view']);
        Route::post('unite-delete', [UniteController::class, 'unite_delete']);
    });

});


// Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified']);

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__.'/auth.php';
