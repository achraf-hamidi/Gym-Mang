<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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



Auth::routes();


Route::get('/cach', function() {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
     return "Cache is cleared";
});







Route::post('/login/adherent', 'Auth\LoginController@adherentLogin')->name('login.adherent');
Route::get('/login/adherent', 'Auth\LoginController@showAdherentLoginForm');


Route::get('departements', 'Admin\AbonnementController@departements')->name("departements");



Route::get('api/set-locale/{locale}', function ($locale) {
	if (!in_array($locale, ['en', 'fr', 'ar'])) {
		abort(400);
	}
	if ($locale == 'ar') {
		Session::put('dir', 'rtl');
	} else {
		Session::put('dir', 'ltr');
	}

	Session::put('locale', $locale);
	App::setLocale($locale);
	//$arr = ['dir', 'locale'];
	//session()->forget($arr);
});

Route::middleware(['auth'])->group(function () {

	//######### Adherents Controller #############//
	Route::match(array('GET', 'POST'), 'api-admin/adherents', 'Admin\AdherentsController@index');
	Route::post('api-admin/adherent/store', 'Admin\AdherentsController@store');
	Route::post('api-admin/adherent/update', 'Admin\AdherentsController@update');
	Route::match(array('GET', 'POST'), 'api-admin/adherents/badge', 'Admin\AdherentsController@Badge');
	Route::match(array('GET', 'POST'), '/api-admin/adherents/assurances', 'Admin\AdherentsController@Assurances');
	Route::match(array('GET', 'POST'), '/api-admin/adherents/assurance/{code}', 'Admin\AdherentsController@AssurancesAdherent');

	Route::match(array('GET'), '/api-admin/adherents/historique-assurances/{code}', 'Admin\AdherentsController@HistoriqueAssurancesAdherent');


	Route::post('/api-admin/adherent/check-adherent-is-existe', 'Admin\AdherentsController@CheckAdherentIsExiste');
	Route::get('/api-admin/adherent/latestIdEmprinte', 'Admin\AdherentsController@LatestIdEmprinte');//
	Route::post('api-admin/adherent/supprimer-adherent', 'Admin\AdherentsController@SupprimerAdherent');

	Route::post('api-admin/adherents/supprimer-assurance-adherent', 'Admin\AdherentsController@SupprimerAssuranceAdherent');

Route::post('api-admin/adherents/ajouter-assurance-adherent', 'Admin\AdherentsController@AjouterAssuranceAdherent');

Route::post('api-admin/adherents/modifier-assurance-adherent', 'Admin\AdherentsController@ModifierAssuranceAdherent');



	Route::match(array('GET', 'POST'), 'api-admin/abonners/encours-ou-termines', 'Admin\AbonnementController@index');
	Route::match(array('GET', 'POST'), 'api-admin/abonners/abonnements_renouveler', 'Admin\AbonnementController@abonnementsRenouveler');

	Route::match(array('GET', 'POST'), 'api-admin/abonners/historiques-abonnements-by-adherent', 'Admin\AbonnementController@historiquesAbonnementsByAdherent');

	Route::match(array('GET', 'POST'), 'api-admin/abonners/suspend', 'Admin\AbonnementController@suspend');

	Route::post('api-admin/abonners/store-suspend', 'Admin\AbonnementController@storeSuspend');
 
	Route::post('api-admin/abonners/store', 'Admin\AbonnementController@store');
	Route::get('api-admin/abonners/dernier-enregistrement', 'Admin\AbonnementController@dernierEnregistrement');
	Route::post('api-admin/abonners/update', 'Admin\AbonnementController@update');
	Route::match(array('GET', 'POST'), 'api-admin/abonners/total-paiements', 'Admin\AbonnementController@TotalPaiements');
	Route::match(array('GET', 'POST'), 'api-admin/abonners/statistiques', 'Admin\AbonnementController@StatistiquesAbonners');

	Route::match(array('GET', 'POST'), 'api-admin/statistiques-abonnements-vendus', 'Admin\AbonnementController@statistiauesAbonnementsVendus');

	Route::post('api-admin/abonner/supprimer-abonnement', 'Admin\AbonnementController@SupprimerAbonnement');


	//############# Parametrages controller ##############//
	Route::get('api-admin/parametrages/categories', 'Admin\ParametragesController@Categories');
	Route::post('api-admin/parametrages/store-categorie', 'Admin\ParametragesController@storeCategorie');
	Route::post('api-admin/parametrages/update-categorie', 'Admin\ParametragesController@updateCategorie');
	Route::post('api-admin/parametrages/destroy-categorie', 'Admin\ParametragesController@destroyCategorie');


	Route::get('api-admin/parametrages/services', 'Admin\ParametragesController@Services');
 	Route::post('api-admin/parametrages/store-service', 'Admin\ParametragesController@storeService');
	Route::post('api-admin/parametrages/update-service', 'Admin\ParametragesController@updateService');
	Route::post('api-admin/parametrages/destroy-service', 'Admin\ParametragesController@destroyService');
	

	Route::get('api-admin/services-type-recette', 'Admin\RecettesController@Recettes'); // Service de type recette
	Route::match(array('GET', 'POST'), 'api-admin/recettes', 'Admin\RecettesController@index');
 	Route::post('api-admin/recette/store', 'Admin\RecettesController@store');
	Route::post('api-admin/recette/update', 'Admin\RecettesController@update');
	Route::post('api-admin/recette/destroy', 'Admin\RecettesController@destroy');
	Route::post('api-admin/recette/regler', 'Admin\RecettesController@regler');
	Route::post('api-admin/recette/edit-note', 'Admin\RecettesController@EditNote');


	Route::get('api-admin/services-type-depence', 'Admin\DepencesController@Depences'); // Service de type recette
	Route::match(array('GET', 'POST'), 'api-admin/depences', 'Admin\DepencesController@index');
 	Route::post('api-admin/depence/store', 'Admin\DepencesController@store');
	Route::post('api-admin/depence/update', 'Admin\DepencesController@update');
	Route::post('api-admin/depence/destroy', 'Admin\DepencesController@destroy');
	Route::post('api-admin/depence/regler', 'Admin\DepencesController@regler');
	Route::post('api-admin/depence/edit-note', 'Admin\DepencesController@EditNote');
	




	Route::get('api-admin/parametrages/activities', 'Admin\ParametragesController@Activities');
	Route::post('api-admin/parametrages/store-activitie', 'Admin\ParametragesController@storeActivitie');
	Route::post('api-admin/parametrages/update-activitie', 'Admin\ParametragesController@updateActivitie');
	Route::post('api-admin/parametrages/destroy-activitie', 'Admin\ParametragesController@destroyActivitie');

	Route::get('api-admin/parametrages/packs', 'Admin\ParametragesController@Packs');
	Route::post('api-admin/parametrages/is-pack-activities', 'Admin\ParametragesController@isPackActivities');
	Route::post('api-admin/parametrages/store-pack', 'Admin\ParametragesController@storePack');
	Route::post('api-admin/parametrages/update-pack', 'Admin\ParametragesController@updatePack');
	Route::post('api-admin/parametrages/destroy-pack', 'Admin\ParametragesController@destroyPack');

	Route::get('api-admin/parametrages/promotions', 'Admin\ParametragesController@Promotions');
	Route::post('api-admin/parametrages/store-promotion', 'Admin\ParametragesController@storePromotion');
	Route::post('api-admin/parametrages/update-promotion', 'Admin\ParametragesController@updatePromotion');
	Route::post('api-admin/parametrages/destroy-promotion', 'Admin\ParametragesController@destroyPromotion');

	Route::get('api-admin/parametrages/abonnements', 'Admin\ParametragesController@Abonnements');
	Route::post('api-admin/parametrages/store-abonnement', 'Admin\ParametragesController@storeAbonnement');
	Route::post('api-admin/parametrages/update-abonnement', 'Admin\ParametragesController@updateAbonnement');
	Route::post('api-admin/parametrages/destroy-abonnement', 'Admin\ParametragesController@destroyAbonnement');


	Route::get('api-admin/parametrages/assurances', 'Admin\ParametragesController@Assurances');
	Route::post('api-admin/parametrages/store-assurance', 'Admin\ParametragesController@storeAssurance');
	Route::post('api-admin/parametrages/update-assurance', 'Admin\ParametragesController@updateAssurance');
	Route::post('api-admin/parametrages/destroy-assurance', 'Admin\ParametragesController@destroyAssurance');

	Route::get('api-admin/parametrages/typefrais', 'Admin\ParametragesController@Typefrais');
	Route::get('api-admin/parametrages/tous-les-frais', 'Admin\ParametragesController@TousLesFrais');



	//############# Empechement controller ################//
	Route::match(array('GET', 'POST'), 'api-admin/empeches', 'Admin\EmpechesController@index');
	Route::post('api-admin/empeches/store', 'Admin\EmpechesController@store');
	Route::post('api-admin/empeches/update', 'Admin\EmpechesController@update');
	Route::post('api-admin/empeche/destroy', 'Admin\EmpechesController@destroy');

	Route::post('api-admin/empeche/find-adherent-has-abonnement-actif', 'Admin\EmpechesController@FindAdherentByMatricule') ;

	//############# Presences controller ################//
	Route::post('api-admin/manual-presence-or-qr', 'Admin\PresencesController@PresenceManualOrbyQR');
	Route::post('api-admin/get-information-adherent', 'Admin\PresencesController@GetInformationAdherent');
	Route::get('api-admin/presences-aujourdhui', 'Admin\PresencesController@PresencesAujourdhui');
	Route::post('api-admin/historiques-presences', 'Admin\PresencesController@HistoriquesPresences');

	//Route::get('api-admin/adherent-qr-code/{code}', 'Admin\ProfileController@getQrCode');
	Route::get('api-admin/details-adherent/{code}', 'Admin\ProfileController@DetailsAdherent');

	//Route::get('api-admin/abonnement-actuel/{code}', 'Admin\ProfileController@AbonnementActuel');
	Route::get('api-admin/historiques-abonners/{code}', 'Admin\ProfileController@HistoriquesAbonners');
	//Route::get('api-admin/historiques-paiements/{code}', 'Admin\ProfileController@HistoriquesPaiements');
	Route::match(array('GET', 'POST'), 'api-admin/presences/{code}', 'Admin\ProfileController@PresencesByAdherent');
  
	//############ Paiements controller ###############//
	Route::match(array('GET', 'POST'), 'api-admin/historiques-regelements', 'Admin\PaiementsController@HistoriquesReglementAbonnement');
	Route::match(array('GET', 'POST'), 'api-admin/abonnement-impayes', 'Admin\PaiementsController@AbonnementImpayes');
	Route::post('api-admin/paiements/store', 'Admin\PaiementsController@store');

	Route::match(array('GET', 'POST'), 'api-admin/statistiques-reglements', 'Admin\PaiementsController@statistiauesReglements');

	Route::match(array('GET', 'POST'), 'api-admin/list-abonnements-non-paye', 'Admin\PaiementsController@abonnementsNonPaye');

	Route::match(array('GET', 'POST'), 'api-admin/date-echeance-abonnements-non-paye', 'Admin\PaiementsController@DateEcheanceAbonnementsNonPaye');

	Route::get('api-admin/generate-qrcode', 'Admin\DashboardController@GenerateQrCode');
	Route::get('api-admin/list-adherents-has-abonners', 'Admin\DashboardController@ListAdherentsHasPaiements');

	Route::post('api-admin/paiement/supprimer-paiement', 'Admin\PaiementsController@SupprimerPaiement');

	//######### Utilisateur Controller #############//
	Route::match(array('GET', 'POST'), 'api-admin/utilisateurs', 'Admin\UtilisateursController@index');
	Route::post('api-admin/utilisateurs/store', 'Admin\UtilisateursController@store');
	Route::post('api-admin/utilisateurs/update', 'Admin\UtilisateursController@update');
	Route::post('api-admin/utilisateurs/destroy', 'Admin\UtilisateursController@destroy');
	Route::post('api-admin/utilisateurs/change-password', 'Admin\UtilisateursController@ChangerPassword');

	Route::post('api-admin/utilisateur/affect-permission', 'Admin\UtilisateursController@AffectPermission');

	Route::get('api-admin/utilisateur/{email}', 'Admin\UtilisateursController@ProfileUtilisateur');

	Route::match(array('GET', 'POST'), 'api-admin/utilisateur/fetch-message/', 'Admin\UtilisateursController@FetchMessages');

	Route::match(array('GET', 'POST'), 'api-admin/messagerie/fetch-utilisateurs/', 'Admin\UtilisateursController@FetchUtilisateurs');

	Route::post('api-admin/utilisateur/store-message/', 'Admin\UtilisateursController@storeMessage');

	Route::match(array('GET', 'POST'), 'api-admin/recharges', 'Admin\RechargeController@index');
	Route::post('api-admin/recharge/store', 'Admin\RechargeController@store');
	Route::post('api-admin/recharge/destroy', 'Admin\RechargeController@destroy');

	Route::get('api-admin/dashboard/termines', 'Admin\DashboardController@terminer');
	Route::get('api-admin/dashbaord/adherents', 'Admin\DashboardController@adherents');
	Route::get('api-admin/dashbaord/abonnements-renouveles', 'Admin\DashboardController@abonnementsRenouveler');
	Route::get('api-admin/dashbaord/promotions', 'Admin\DashboardController@Promotions');
	Route::get('api-admin/dashbaord/messages-unread', 'Admin\DashboardController@MessagesUnread');
	Route::post('api-admin/dashboard/avant-fin-date', 'Admin\DashboardController@AvantFinDate');
	Route::match(array('GET', 'POST'), 'api-admin/dashboard-list-abonnements-non-paye', 'Admin\DashboardController@abonnementsNonPaye');
	Route::match(array('GET', 'POST'), 'api-admin/dashboard/statistiques-actuel', 'Admin\DashboardController@StatistiquesActuel');
	Route::match(array('GET', 'POST'), 'api-admin/dashboard/statistiques-recettes', 'Admin\DashboardController@StatistiquesRecettes');
	Route::match(array('GET', 'POST'), 'api-admin/dashboard/statistiques-depences', 'Admin\DashboardController@StatistiquesDepences');

	Route::match(array('GET', 'POST'), 'api-admin/dashboard/statistiques-reglements-solde-de-caisse', 'Admin\DashboardController@StatistiquesReglementsSoldeCaisse');

	Route::match(array('GET', 'POST'), 'api-admin/dashbaord/count', 'Admin\DashboardController@count');

	Route::get('/home', 'HomeController@index')->name('home');

	// Emailing
	Route::match(array('GET', 'POST'), 'api-admin/fiche-inscription/{abonner}', 'Admin\MailController@FicheInscription');
	Route::match(array('GET', 'POST'), 'api-admin/rappel-de-paiement/{abonner}', 'Admin\MailController@RappelDePaiement');
	Route::match(array('GET', 'POST'), 'api-admin/email-manuel/{adherent?}', 'Admin\MailController@EmailManuel');

	Route::match(array('GET', 'POST'), 'api-admin/list-mails-adherents', 'Admin\MailController@getMailsAdherents');

});

Route::middleware(['adherent'])->group(function () {

	Route::get('api-adherent/details-adherent/{code}', 'Adherent\AdherentController@ProfileAdherent'); //->middleware('adherent');

	Route::get('api-adherent/historiques-abonners/{code}', 'Adherent\AdherentController@HistoriquesAbonners'); //->middleware('adherent');
	Route::match(array('GET', 'POST'), 'api-adherent/presences/{code}', 'Adherent\AdherentController@PresencesByAdherent'); //->middleware('adherent');

});











/*Route::get('/admin/{any}', function () {
return view('welcome');
})->where('any','.*')->middleware('auth');

Route::get('/adherent/{any}', function () {
return view('welcome');
})->where('any','.*')->middleware('adherent');

Route::get('/{any}', function () {
if (Auth::guard("adherent")->check()) {
return redirect()->intended("/adherent/profile/".Auth::guard('adherent')->user()->code_client);
} else if (Auth::check()) {
return redirect(RouteServiceProvider::HOME);
}else
return redirect()->guest('login');

})->where('any','.*');*/

Route::get('/', function () {
	//return view('home');
	return view('welcome');
})->middleware('auth');

Route::get('/{any}', function () {
	return view('welcome');
})->where('any', '.*')->middleware('auth');


