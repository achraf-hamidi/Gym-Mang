<?php

namespace App\Http\Controllers\Admin;

use App\Adherent; // spatie
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use App\Mail\SendUserAuth;
use Auth;
use Mail;
use File;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UtilisateursController extends Controller {

	public function index(Request $request) {
		// La liste des adhérents
		$date = null ;
		if ( $request->has('filtrer.date') )
			$date = Helper::getDate($request); 
		
		$is_valide = (isset($request['filtrer.is_valide']) && $request['filtrer.is_valide'] != '') ? [$request['filtrer.is_valide']] : [1, 0];
		$utilisateurs = User::with('parent')
			//->when( $date , function ($query, $date ) {
			//     $query->whereBetween('created_at', [ $date ] ) ;
			//})	
			->whereNotIn('id', [ auth()->user()->id ])
			->whereIn('is_valide', $is_valide)
			->orderBy('id', 'desc')
			->paginate(50);
		return response()->json($utilisateurs);
	}
	public function store(Request $request) {

		$imgName = (isset($request['utilisateur.gender']) && $request['utilisateur.gender'] == "Homme") ? 'homme.png' : 'femme.png';

		if (isset($request['utilisateur.image']) && $request['utilisateur.image'] != null ) {
			$imgName = str_replace(array(" ", "'", ":", ",", ";", ".", "?", "!"), '_', $request['utilisateur.nom']) . '_' . time() . '.' . $request['utilisateur.image']->extension();
			$request['utilisateur.image']->move(public_path('admin/utilisateurs/photos'), $imgName);
		}

		$utilisateur = User::create([
			'name' => $request['utilisateur.nom'],
			'email' => $request['utilisateur.email'],
			'password' => bcrypt('secret'),
			'tele' => $request['utilisateur.tele'],
			'cin' => ($request['utilisateur.cin']) ? $request['utilisateur.cin'] : '',
			'gender' => ($request['utilisateur.gender']) ? $request['utilisateur.gender'] : 'Homme',
			'image' => $imgName,
			'is_valide' => 1,
			'id_user' => 1,
			'created_at' => now()
		]);

		/*$integration = Integration::create([
			'id_utilisateur' =>  $utilisateur->id ,
			'date_debut'  => now()
		]); */
		$titre = "Création de compte";
		$text = "Votre compte a été crée";
		$nom_utilisateur = $request['utilisateur.nom'] ;
		$email = $request['utilisateur.email'] ;
		$default_mot_passe = 'secret' ;
		$app_link = 'https://' . $_SERVER['HTTP_HOST'] .'/login' ;

 		Mail::to($email)->send(
 							new SendUserAuth( 
 									$titre,
 								 	$text,
 								 	$nom_utilisateur,
 								 	$email,
 								 	$default_mot_passe,
 								 	$app_link
 								 )
 						);


		$utilisateur = User::with('parent')->orderBy('id', 'desc')->first();
		return response()->json($utilisateur);
	}

	public function update(Request $request) {
		//$utilisateur = User::find($request['utilisateur_id']);
		$utilisateur = User::with('parent')->where('id', $request['utilisateur_id'])->first();
		if ($utilisateur) {
			$gender = array("femme.png", "homme.png");
 			if ( !in_array($utilisateur->image , $gender) && $utilisateur->image != '') {
				$imgName = $utilisateur->image;
			} 
			else if ($request['utilisateur.image'] && $request['utilisateur.image'] != null && $request['utilisateur.image'] != '') {
				$imgName = str_replace(array(" ", "'", ":", ",", ";", ".", "?", "!"), '_', $request['utilisateur.nom']) . '_' . time() . '.' . $request['utilisateur.image']->extension();
			}

			if ($request['utilisateur.image'] && $request['utilisateur.image'] != null && $request['utilisateur.image'] != '') {
				$request['utilisateur.image']->move(public_path('admin/utilisateurs/photos'), $imgName);
			}

			$utilisateur->update([
				'name' => $request['utilisateur.nom'],
				'email' => $request['utilisateur.email'],
				'password' => bcrypt($request['utilisateur.password']),
				'tele' => $request['utilisateur.tele'],
				'cin' => ($request['utilisateur.cin']) ? $request['utilisateur.cin'] : '',
				'gender' => ($request['utilisateur.gender']) ? $request['utilisateur.gender'] : 'Homme',
				'image' => (isset($imgName)) ? $imgName : $utilisateur->image,
				'is_valide' => $request['utilisateur.is_valide'],
			]);
			return response()->json($utilisateur);
		} else {
			return response()->json(false);
		}

	}

	public function AffectPermission(Request $request) {
		$user = User::find($request['user_id']);
		if ($user) {
			if ($request['permission_name'] == "all") {
				$permissions = Permission::all();
			} else {
				$permissions = $request['permission_name'];
			}

			if ($request['event'] == 'give') { // attache
				$user->givePermissionTo($permissions);
			} else {  // detache
				$user->revokePermissionTo($permissions);
			}

		}
		return response()->json($user);

	}

	public function destroy(Request $request) {
		$utilisateur = User::find($request['id_utilisateur']);
		if ($utilisateur) {

			$permissions = Permission::all();
			$roles = Role::all()->pluck('name');

			$utilisateur->syncRoles($roles);
			$utilisateur->revokePermissionTo($permissions);

			if ($utilisateur->image != "default.jpg" && $utilisateur->image != "" && $utilisateur->image != null) {
				$output_file = 'admin/utilisateurs/photos/' . $utilisateur->image;
				File::delete($output_file);
			}

			$utilisateur->delete();

			return response()->json(true);
		}
		return response()->json(false);
	}

	public function ProfileUtilisateur(Request $request, $email) {
		$utilisateur = User::where('email', $email)->first();
		$permissions = $utilisateur->permissions;
		return response()->json(['auth' => Auth::user(), 'utilisateur' => $utilisateur, 'permissions' => $permissions]);
	}

	public function FetchUtilisateurs(Request $request) {
		$auth = Auth::user();
		$utilisateurs = User::withCount(['messages' => function ($message) use ($request) {
			$message->where([['to_user_id', Auth::user()->id],
				['seen_it', 0],
			]);
		}])
			->where([
				['id', '<>', $auth->id],
				['is_valide', 1],
			])->get();

		return response()->json(['auth' => $auth, 'utilisateurs' => $utilisateurs]);
	}

	public function storeMessage(Request $request) {
		$message = Message::create([
			'message' => $request->message,
		]);

		$message->users()->attach(Auth::user()->id, [
			'to_user_id' => $request->to_user_id,
		]);

		$message = Message::with('users')->where('id', $message->id)->first();

		return response()->json(['message' => $message]);
	}

	public function FetchMessages(Request $request) {

		$messages = Message::with(['users' => function ($users) use ($request) {
			$users->where([['user_id', Auth::user()->id],
				['to_user_id', $request->to_user_id],
			])
				->orWhere([['user_id', $request->to_user_id],
					['to_user_id', Auth::user()->id],
				]);
		}])
			->whereHas('users', function ($users) use ($request) {
				$users->where([['user_id', Auth::user()->id],
					['to_user_id', $request->to_user_id],
				])
					->orWhere([['user_id', $request->to_user_id],
						['to_user_id', Auth::user()->id],
					]);
			})
			->orderBy('id', 'desc')
			->offset($request->offset)
			->take($request->limit)
			->get();

		$messages->each(function ($item) use ($request) {
			$item->users()->updateExistingPivot($request->to_user_id, [
				'seen_it' => 1,
			]);
		});
		return response()->json(['messages' => $messages]);
	}


	public function ChangerPassword(Request $request) {
 		$utilisateur = User::where('id', $request['utilisateur.id_utilisateur'])->first();
		if ($utilisateur) {
			 	
			 if ($request['utilisateur.password'] == $request['utilisateur.confirmpassword']) {
			 	$utilisateur->update([
					'password' => bcrypt($request['utilisateur.password'])
				]);

				 

				$titre = "Changement de mot de passe";
				$text = "votre mot de passe a été changé";
				$nom_utilisateur = $utilisateur->name ;
				$email = $utilisateur->email;
				$default_mot_passe = $request['utilisateur.password']  ;
				$app_link = 'https://' . $_SERVER['HTTP_HOST'] .'/login' ;
				

		 		Mail::to($email)->send(
 							new SendUserAuth( 
 									$titre,
 								 	$text,
 								 	$nom_utilisateur,
 								 	$email,
 								 	$default_mot_passe,
 								 	$app_link
 								 )
 						);


				return response()->json(['message' => 'Le mot de passe a été changé avec succès', 'type' => 'success']);
			}else {
				return response()->json(['message' => 'La confirmation de mot de passe est incorrect', 'type' => 'warning']);
			}

		} 
		return response()->json(['message' => 'Cet utilisateur n\'existe pas ', 'type' => 'warning']);
		

	}

}
