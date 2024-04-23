<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {         
       

        DB::table('typefrais')->insert([
            [  'libelle'        => 'Assurance'],
            [  'libelle'        => 'Inscription'],
            [  'libelle'        => 'Autres'],
        ]);


        DB::table('abonnements')->insert([
            [  'libelle'        => 'Mensuel', 'nb_mois' => 1 ], 
            [  'libelle'        => 'Trimestriel', 'nb_mois' => 3 ], 
            [  'libelle'        => 'Semestriel', 'nb_mois' => 6 ], 
            [  'libelle'        => 'Annuel', 'nb_mois' => 12 ], 
        ]);

         DB::table('activities')->insert([
            [  'name'        => 'Musculation'], 
            [  'name'        => 'Cardio'], 
            [  'name'        => 'Fitness'], 
            [  'name'        => 'Mma'], 
            [  'name'        => 'Box'], 
        ]);

        /* factory(App\Pack::class, 5)->create();
         DB::table('activitie_pack')->insert([
            [  'pack_id'        =>  1 , 'activitie_id' =>  1 ], 
            [  'pack_id'        =>  1 , 'activitie_id' =>  4 ], 
            [  'pack_id'        =>  1 , 'activitie_id' =>  2 ], 

            [  'pack_id'        =>  2 , 'activitie_id' =>  3 ], 
            [  'pack_id'        =>  2 , 'activitie_id' =>  4 ], 

            [  'pack_id'        =>  3 , 'activitie_id' =>  5 ], 
            [  'pack_id'        =>  3 , 'activitie_id' =>  4 ], 
            [  'pack_id'        =>  3 , 'activitie_id' =>  2 ], 

            [  'pack_id'        =>  4 , 'activitie_id' =>  1 ], 
            [  'pack_id'        =>  4 , 'activitie_id' =>  4 ], 

            [  'pack_id'        =>  5 , 'activitie_id' =>  3 ], 
            [  'pack_id'        =>  5 , 'activitie_id' =>  4 ], 
            [  'pack_id'        =>  5 , 'activitie_id' =>  2 ], 
        ]);*/
  

          DB::table('users')->insert([
            /*[
                'name' => 'Ayoub boudafdafa',
                'email' => 'ayouboudafdafa.bef@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('secret'),
                'remember_token' => Str::random(10),
                'cin'              =>  'M552233' , 
                'gender'              => 'male',
                'tele'             => '0619845673' ,
                'image'             => 'homme.png',
                'is_valide'        =>1 ,
                'id_user'        => 1
            ],*/
            [
                'name' => 'Zakaria',
                'email' => 'zakaria.faouzi16@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('secret'),
                'remember_token' => Str::random(10),
                'cin'              =>  'M552233' , 
                'gender'              => 'male',
                'tele'             => '0619845673' ,
                'image'             => 'homme.png',
                'is_valide'        =>1 ,
                'id_user'        => 1
            ],
            [
                'name' => 'Démo Clubi',
                'email' => 'demo@clubi.ma',
                'email_verified_at' => now(),
                'password' => bcrypt('secret'),
                'remember_token' => Str::random(10),
                'cin'              =>  'M552233' , 
                'gender'              => 'male',
                'tele'             => '0601020304' ,
                'image'             => 'homme.png',
                'is_valide'        =>1 ,
                'id_user'        => 1
            ]
           ]);


       // factory(App\User::class, 3)->create();

        /*factory(App\Adherent::class, 4)->create()->each(function ($adherent) {
              DB::table('integrations')->insert([
                [  
                    'date_debut' => now() , //$recharge->recharge,
                    'date_fin' => null, //$recharge->code_client,
                    'id_adherent'        => $adherent->id ,
                ]
            ]);
        });*/

        ////factory(App\Promotion::class, 4)->create();
        //factory(App\Abonner::class, 4)->create();
        //factory(App\Paiement::class, 4)->create();
        //factory(App\Presence::class, 4)->create();
        //factory(App\Recharge::class, 15)->create();
           

        /*factory(App\Recharge::class, 4)->create()->each(function ($recharge) {
            DB::table('soldes')->insert([
                [  
                    'solde' => $recharge->recharge,
                    'code_client' => $recharge->code_client
                ]
            ]);
        });*/
  

        /*for ($i = 1 ; $i <= 4; $i++){ 
            DB::table('abonnement_abonner')->insert([
                [   'abonner_id'        =>  $i ,
                    'abonnement_id' => rand(1,4),
                    'date' => now() ,
                    'is_active' => 1
                ]
            ]);

            DB::table('abonner_pack')->insert([
                [   'abonner_id'        => $i, 
                    'pack_id' => rand(1,5), 
                    'date' => now(), 
                    'promo' => App\Promotion::inRandomOrder()->first()->remise, 
                    'is_active' => 1
               ]
            ]);
            DB::table('assurances')->insert([
                [   'id_adherent'        =>  $i ,
                    'date_assuree' => now(),
                    'date_fin' =>  date('Y/m/d', strtotime(date('Y/m/d',strtotime('+365 days')))) ,
                    'id_assureur' => 1,
                    'prix' => 150
                ] 
            ]);
        }*/
        





// Reset cached roles and permissions
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

/*
$permission_tabealu_de_bord = Permission::create(['name'   => 'Tableau de bord']);
$permission_tabealu_de_bord_1 = Permission::create(['name' => 'Derniers adhérents (Tableau d bord)']);
$permission_tabealu_de_bord_2 = Permission::create(['name' => 'Derniers abonnements terminé (Tableau d bord)']);
$permission_tabealu_de_bord_3 = Permission::create(['name' => 'Statistiques de 3 derniers mois (Tableau d bord)']);
$permission_tabealu_de_bord_4 = Permission::create(['name' => 'Liste d\'abonnements au moins 15 jours avant la date fin (Tableau d bord)']);

// create permissions memeber
$permission_gestion_adherents = Permission::create(['name' => 'Gestion des adhérents']);
$permission_liste_adherent       = Permission::create(['name'       => 'Liste des adhérents']);
$permission_ajouter_adherent       = Permission::create(['name'       => 'Ajouter un adhérent']);
$permission_modifier_adherent      = Permission::create(['name'      => 'Modifier adhérent']);
$permission_supprimer_adherent    = Permission::create(['name'    => 'Supprimer un adhérent']);
$permission_profile_adherent   = Permission::create(['name'   => 'Profile adhérent']);
$permission_badges_adherents = Permission::create(['name' => 'Badges des adherents']);
$permission_assurances_adherents = Permission::create(['name' => 'Assurances']);
$permission_historiques_assurances_adherent = Permission::create(['name' => 'Historique de l’Assurance']);

// Abonner
$permission_gestions_abonners             = Permission::create(['name'      => 'Gestion des abonnements']);
$permission_ajouter_abonner             = Permission::create(['name'      => 'Nouvel abonnement']);
$permission_supprimer_abonner          = Permission::create(['name'    => 'Supprimer un abonnement']);
$permission_modifier_abonner            = Permission::create(['name'       => 'Modifier abonnement']);

$permission_suspendre_abonner            = Permission::create(['name'       => 'Suspendre abonnement']);

$permission_consulter_encour   = Permission::create(['name'    => 'Abonnement en cours']);
$permission_consulter_terminer   = Permission::create(['name'    => 'Abonnement terminés']);
$permission_avant_terminer   = Permission::create(['name'    => 'Abonnement avant terminés']);
$permission_statistiques_abonners = Permission::create(['name' => 'Statistiques abonnements']);
$permission_desabonner = Permission::create(['name' => 'Se désabonner']);


$permission_gestion_absences   = Permission::create(['name'   => 'Absences']);
$permission_ajouter_absence   = Permission::create(['name'   => 'Ajouter une absence']);
$permission_modifier_absence   = Permission::create(['name'   => 'Modifier une absence']);
$permission_delet_absence   = Permission::create(['name'   => 'Effacer une absence']);

$permission_gestion_paiements = Permission::create(['name' => 'Gestion des paiements']);
$permission_impayes = Permission::create(['name' => 'Les impayés']);
$permission_historiques_regelements = Permission::create(['name' => 'Historiques des réglements']);
$permission_statistiques_reglements = Permission::create(['name' => 'Statistiques des reglements']);
$permission_recharges = Permission::create(['name' => 'Recharges']);
$permission_ajouter_recharge = Permission::create(['name' => 'Ajouter un recharge']);
$permission_supprimer_recharge = Permission::create(['name' => 'Supprimer un recharge']);
$permission_modifier_recharge = Permission::create(['name' => 'Modifier un recharge']);


$permission_gestion_presences = Permission::create(['name' => 'Gestion des présences']);
$permission_aujourdhui = Permission::create(['name' => 'Ajourd\'hui']);
$permission_ajouter_presence = Permission::create(['name' => 'Ajouter présence']);
$permission_historiques_presence = Permission::create(['name' => 'Historiques présences']);


$permission_gestion_utilisateurs = Permission::create(['name' => 'Gestion des utilisateurs']);
$permission_ajouter_utilisateur = Permission::create(['name' => 'Ajouter utilisateur']);
$permission_modifier_utilisateur = Permission::create(['name' => 'Modifier utilisateur']);
$permission_supprimer_utilisateur = Permission::create(['name' => 'Supprimer utilisateur']);
$permission_affecter_roles = Permission::create(['name' => 'Gestion des rôles']);
$permission_profile_utilisateur = Permission::create(['name' => 'Profile utilisateur']);
$permission_messagerie = Permission::create(['name' => 'Messagerie']);


$permission_parametrages = Permission::create(['name' => 'Paramétrages']); 
$permission_types_abonnements = Permission::create(['name' => 'Type d\'abonnements']); 
$permission_ajouter_types_abonnements = Permission::create(['name' => 'Nouvel type d\'abonnement']); 
$permission_modifier_types_abonnements = Permission::create(['name' => 'Modifier un type d\'abonnement']); 
$permission_supprimer_types_abonnements = Permission::create(['name' => 'Supprimer un type d\'abonnement']); 


$permission_packs_activities = Permission::create(['name' => 'Activities & Packs']); 
$permission_ajouter_activities = Permission::create(['name' => 'Ajouter une activité']); 
$permission_modifier_activities = Permission::create(['name' => 'Modifier une activité']); 
$permission_supprimer_activities = Permission::create(['name' => 'Supprimer une activité']);

$permission_ajouter_packs = Permission::create(['name' => 'Ajouter un pack']); 
$permission_modifier_packs = Permission::create(['name' => 'Modifier un pack']); 
$permission_supprimer_packs = Permission::create(['name' => 'Supprimer un pack']); 

$permission_promotions = Permission::create(['name' => 'Promotions']); 
$permission_ajouter_promotion = Permission::create(['name' => 'Ajouter un promotion']); 
$permission_modifier_promotion = Permission::create(['name' => 'Modifier un promotion']); 
$permission_supprimer_promotion = Permission::create(['name' => 'Supprimer un promotion']); 
*/






/**** new roles *********/



 DB::table('roles')->insert([
    [ 'guard_name' => 'web', 'name' => 'Tableau de bord'],
    [ 'guard_name' => 'web', 'name' => 'Gestions des adhérents'],
    [ 'guard_name' => 'web', 'name' => 'Assurances'],
    [ 'guard_name' => 'web', 'name' => 'Gestion des abonnements'],
    [ 'guard_name' => 'web', 'name' => 'Gestion des paiements'],
    [ 'guard_name' => 'web', 'name' => 'Les recettes'],
    [ 'guard_name' => 'web', 'name' => 'Les dépenses'],
    [ 'guard_name' => 'web', 'name' => 'Gestion des présences'],
    [ 'guard_name' => 'web', 'name' => 'Emails'],
    [ 'guard_name' => 'web', 'name' => 'Paramétrage'] 
 ]);



//$permissions = Permission::create(

 DB::table('permissions')->insert([
    /** Tableau de bord **/
    ['guard_name' => 'web', 'name'   => 'Tableau de bord'],
    ['guard_name' => 'web', 'name' => "Afficher le total des adhérents, Adhérents Actifs, Adhérents Inactifs"],
    ['guard_name' => 'web', 'name' => "Afficher les derniers adhérents inscrits"],
    ['guard_name' => 'web', 'name' => "Afficher les derniers abonnements terminés"],
    ['guard_name' => 'web', 'name' => "Afficher les abonnements prochainement expirés"],
    ['guard_name' => 'web', 'name' => "Afficher les statistiques des inscriptions des 3 derniers mois (Abonnements vendus)"],
    ['guard_name' => 'web', 'name' => "Afficher les statistiques des règlements des 3 derniers mois"],
    ['guard_name' => 'web', 'name' => "Afficher les recettes d'aujourd'hui"],
    ['guard_name' => 'web', 'name' => "Afficher les dépenses d'aujourd'hui"],


    /** Gestion des adhérents **/
    ['guard_name' => 'web', "name" => "Gestions des adhérents" ], 
    ['guard_name' => 'web', "name" => "Ajouter un adhérent" ],
    ['guard_name' => 'web', "name" => "Supprimer un adhérent" ],
    ['guard_name' => 'web', "name" => "Modifier un adhérent" ],
    ['guard_name' => 'web', "name" => "Envoyer la fiche d'inscription" ],
    ['guard_name' => 'web', "name" => "Consulter la fiche d'adhérent" ],

    ['guard_name' => 'web', "name" => "Assurances" ] , 
    ['guard_name' => 'web', "name" => "Ajouter une assurance" ] ,
    ['guard_name' => 'web', "name" => "Modifier une assurance" ] , 
    ['guard_name' => 'web', "name" => "Supprimer une assurance" ] ,
    ['guard_name' => 'web', "name" => "Consulter les details d’une assurance" ] ,



    /** Gestion des abonnements **/
    ['guard_name' => 'web', "name" => "Gestion des abonnements" ] , 
    ['guard_name' => 'web', "name" => "Ajouter un abonnement" ] , 
    ['guard_name' => 'web', "name" => "Consulter les abonnement actifs" ] , 
    ['guard_name' => 'web', "name" => "Consulter l’historique des abonnements" ] , 
    ['guard_name' => 'web', "name" => "Supprimer un abonnement" ] ,
    ['guard_name' => 'web', "name" => "Consulter les abonnements términés" ] , 
    ['guard_name' => 'web', "name" => "Consulter les abonnements prochainement expirés" ] , 

['guard_name' => 'web', "name" => "Consulter les absences" ], 
['guard_name' => 'web', "name" => "Ajouter une absence" ],  
['guard_name' => 'web', "name" => "Supprimer une absence" ], 
['guard_name' => 'web', "name" => "Modifier une absence" ], 
['guard_name' => 'web', "name" => "Consulter les statistiques de nombre des abonnements vendus" ], 
['guard_name' => 'web', "name" => "Consulter les statistiques du chiffre d’affaires des abonnements vendus" ], 
 

    /** Gestion des paiements **/
['guard_name' => 'web', "name" => "Gestion des paiements" ],   
['guard_name' => 'web', "name" => "Consulter la liste des crédits" ],  
['guard_name' => 'web', "name" => "Régler les impayés" ],  
['guard_name' => 'web', "name" => "Consulter l’historique des réglements" ], 
['guard_name' => 'web', "name" => "Supprimer un paiement" ], 
['guard_name' => 'web', "name" => "Consulter les statistiques des réglements encaissés"],


    /** Gestion des recettes **/
['guard_name' => 'web', "name" => "Consulter la liste des recettes" ], 
['guard_name' => 'web', "name" => "Ajouter une recette" ], 
['guard_name' => 'web', "name" => "Modifier une recette" ], 
['guard_name' => 'web', "name" => "Supprimer une recette" ], 
['guard_name' => 'web', "name" => "Régler une recette" ],
['guard_name' => 'web', "name" => "Voir les détails d’une recette" ],
['guard_name' => 'web', "name" => "Consulter les statistiques des recettes" ],
/** Gestion des depense **/
['guard_name' => 'web', "name" => "Consulter la liste des dépenses" ], 
['guard_name' => 'web', "name" => "Ajouter une dépense" ], 
['guard_name' => 'web', "name" => "Modifier une dépense" ], 
['guard_name' => 'web', "name" => "Supprimer une dépense" ],
['guard_name' => 'web', "name" => "Voir les détails d’une dépense" ], 
['guard_name' => 'web', "name" => "Régler une dépense" ],
['guard_name' => 'web', "name" => "Consulter les statistiques des dépenses" ],


    /** Gestion des présences **/
['guard_name' => 'web', "name" => "Gestion des présences" ],  
['guard_name' => 'web', "name" => "Pointage des adhérents" ],  
['guard_name' => 'web', "name" => "Consulter l’historique des présences" ],  


/***Envoyer des emails  ***/

['guard_name' => 'web', "name" => "Envoyer des emails"],

    /** Gestion des utilisateurs **/

['guard_name' => 'web', "name" => "Consulter la liste des utilisateurs" ] ,
['guard_name' => 'web', "name" => "Ajouter un utilisateur" ] ,
['guard_name' => 'web', "name" => "Modifier un utilisateur" ] ,
['guard_name' => 'web', "name" => "Supprimer un utilisateur" ] ,
['guard_name' => 'web', "name" => "Modifier le mot de passe personnel"],
['guard_name' => 'web', "name" => "Modifier les mots de passe des utilisateurs"],
['guard_name' => 'web', "name" => "Consulter le profil d'un utilisateur" ] ,
['guard_name' => 'web', "name" => "Consulter le profil personnel" ] ,
['guard_name' => 'web', "name" => "Autoriser les accès aux utilisateurs" ] ,

    /** Gestion des paramétrages **/

['guard_name' => 'web', "name" => "Paramétrage" ],

['guard_name' => 'web', "name" => "Consulter les types d'abonnement" ], 
['guard_name' => 'web', "name" => "Ajouter un nouveau type d’abonnement" ], 
['guard_name' => 'web', "name" => "Modifier un type d’abonnement" ], 
['guard_name' => 'web', "name" => "Supprimer un type d’abonnement" ], 

['guard_name' => 'web', "name" => "Consulter les activités" ], 
['guard_name' => 'web', "name" => "Ajouter une activité" ], 
['guard_name' => 'web', "name" => "Modifier une activité" ], 
['guard_name' => 'web', "name" => "Supprimer une activité" ],

['guard_name' => 'web', "name" => "Consulter les packs" ], 
['guard_name' => 'web', "name" => "Ajouter un pack" ], 
['guard_name' => 'web', "name" => "Modifier un pack" ], 
['guard_name' => 'web', "name" => "Supprimer un pack" ],

['guard_name' => 'web', "name" => "Consulter les catégories des services"  ],  
['guard_name' => 'web', "name" => "Ajouter une catégorie"  ],  
['guard_name' => 'web', "name" => "Modifier une catégorie"  ],  
['guard_name' => 'web', "name" => "Supprimer une catégorie"  ],  
['guard_name' => 'web', "name" => "Consulter les services"  ],  
['guard_name' => 'web', "name" => "Ajouter un service"  ],  
['guard_name' => 'web', "name" => "Modifier un service"  ],  
['guard_name' => 'web', "name" => "Supprimer un service"  ], 

['guard_name' => 'web', "name" => "Consulter les promotions"  ],  
['guard_name' => 'web', "name" => "Ajouter une promotion"  ],  
['guard_name' => 'web', "name" => "Modifier une promotion"  ],  
['guard_name' => 'web', "name" => "Supprimer une promotion"  ],  

['guard_name' => 'web', "name" => "Consulter les frais"  ],  
['guard_name' => 'web', "name" => "Ajouter des frais"  ],  
['guard_name' => 'web', "name" => "Modifier des frais"  ],  
['guard_name' => 'web', "name" => "Supprimer des frais"  ],  

['guard_name' => 'web', "name" => "Afficher les notifications des dates d'écheance"  ],   
['guard_name' => 'web', "name" => "Afficher les notifications des abonnements prochainnement expirés"  ],   
['guard_name' => 'web', "name" => "Afficher les notifications des abonnements terminés"  ],   



]);
/***** end new roles  ****/







        // this can be done as separate statements
        
        //$role_admin  = Role::create(['name' => 'admin']);
        //$role_assistant = Role::create(['name' => 'assistant']);

        $allPermission = Permission::all();

        // Affect role to utilisateur
        $user_admin = App\User::find(1);
        //$user_admin->assignRole('Gestions des adhérents');

        $user_assisstant = App\User::find(2);
        //$user_assisstant->assignRole('assistant');

         // Admin permissions
        $user_admin->givePermissionTo($allPermission); 

        // Assistant permissions
       $user_assisstant->givePermissionTo($allPermission);
        
        














    }
}
