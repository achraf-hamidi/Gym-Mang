export default {
    "fr": {
        'side': {
            'path' : '/public/',
            "menu": {
                "dashboard": "Tableau de bord",
                "adherents": {
                    "titre": "Gestion des adhérents",
                    "liste": "Liste des adhérents",
                    "badges": "Badge adhérents"
                },
                "abonnements": {
                    "titre": "Gestion des abonnements",
                    "nouveau": "Nouvel abonnement",
                    "encours": "Abonnements actifs",
                    "terminer": "Abonnements términés",
                    "desabonner": "Se désabonner",
                    "empeches": "Absences",
                    "statistiques": "Statistiques"

                },
                "paiements": {
                    "titre": "Gestion des paiements",
                    "impayes": "Les impayés",
                    "historiques": "Historique des réglements",
                    "recharges": "Recharges",
                    "statistiques": "Statistiques"
                },
                "presences": {
                    "titre": "Gestion des présences",
                    "aujourdhui": "Aujourd'hui",
                    "historiques": "Historiques"
                },
                "utilisateurs": "Gestion des utilisateurs",
                "parametrages": {
                    "titre": "Paramétrage",
                    "abonnements": "Types d’abonnements",
                    "activities": "Activités & packs",
                    "promotions": "Promotions"
                }
            }
        },
        'header': {
            "lang": {
                "francais": "Francais",
                "anglais": "Anglais",
                "arabe": "Arabe"
            },
            "recherche": {
                "titre": " Le profile adhérent est reconnaissable par le matricule",
                "placeholder": "Matricule"
            },
            "notifications": {
                "abonnement_avant_terminer": {
                    "titre": "Liste d'abonnements au moins 15 jours avant la Date de fin",
                    "date_fin": "Date de fin",
                    "jours": "Jours restants"
                },
                "abonnement_terminer": {
                    "titre": "Derniers abonnements terminé",
                    "date_fin": "Date de fin",
                    "jours": "Jours restants"
                },
                "promotions": {
                    "titre": "Promotions",
                    "date_fin": "Date de fin"
                },
                "utilisateur": {
                    "deconnexion": "Déconnexion"
                }
            }
        },
        "content": {
            "pages": {
                "dashboard": {
                    "titre": "Tableau de bord",
                    "count": {
                        "filtrer": {
                            "date": "Date du au"
                        },
                        "adherents": "Adhérents",
                        "encours": "Abonnements en cours",
                        "presences": "Présences"
                    },
                    "adherents": {
                        "titre": "Derniers adhérents",
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "cin": "Cin",
                            "genre": "Genre"
                        }
                    },
                    "abonnement_terminer": {
                        "titre": "Derniers abonnements terminé",
                        "tableau": {
                            "matricule": "Matricule",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "jours": "Jours restants"
                        }
                    },
                    "abonnement_avant_terminer": {
                        "titre": "Liste d'abonnements au moins 15 jours avant la Date de fin",
                        "tableau": {
                            "matricule": "Matricule",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "jours": "Jours restants"
                        }
                    },
                    "statistiques_reglements": {
                        "titre": "Statistiques de 3 derniers mois"
                    }


                },
                "adherents": {
                    "liste": {
                        "nouveau": "Ajouter un adhérent",
                        "titre": "Liste des adhérents",
                        "recherche": {
                            "statut": {
                                "titre": "Statut",
                                "tous": "Tous",
                                "valide": "Actif",
                                "bloque": "Inactif"
                            },
                            "date": "Date du au",
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin, nom & prénom, email, genre..."
                        },
                        "tableau": {
                            "qrcode": "Qr code",
                            "matricule": "Matricule",
                            "cin": "Cin",
                            "nom": "Nom & prénom",
                            "email": "Email",
                            "tele": "Téléphone",
                            "date_naiss": "Date de naissance",
                            "genre": "Genre",
                            "statut": "Statut"
                        }
                    },
                    "badges": {
                        "titre": "Badges",
                        "recherche": {
                            "matricule": {
                                "titre": "Matricule",
                                "placeholder": "Matricule"
                            },
                            "date": "Date du au"
                        },
                        "filtrer": {
                            "titre": "filtrer",
                            "placeholder": "Matricule, Nom & prénom..."
                        },
                        "matricule": "Matricule"
                    },
                    'modale_nouveau': {
                        'titre': "Ajouter un nouvel adhérent",
                        "inputs": {
                            "nom": {
                                'titre': "Nom",
                                'placeholder': "Entrer le nom d'adhérent",
                            },
                            "email": {
                                'titre': "Adresse email",
                                'placeholder': "Entrer l'adresse email..",
                            },
                            "cin": {
                                'titre': "CIN",
                                'placeholder': "Entrer CIN",
                            },
                            "tele": {
                                'titre': "Téléphone",
                                'placeholder': "Entrer le numéro de téléphone",
                            },
                            "gender": {
                                'titre': "Genre",
                                'placeholder': "Entrer le genre..",
                            },
                            "date_naiss": {
                                'titre': "Date de naissance",
                                'placeholder': "Choisier votre date de naissance",
                            },
                            "address": {
                                'titre': "Adresse",
                                'placeholder': "Entrer l'adresse",
                            },
                            "photos": {
                                'titre': "Photo",
                                'placeholder': "Importer la photo d’adhérent",
                            },
                            "parrain": {
                                'titre': "Parrain",
                                'placeholder': "Matricule de parrain..",
                            }

                        },
                    },
                    'profile': {
                        "titre": "Profile adhérent",
                        'revenu': {
                            'net_paye': 'Net à payer',
                            'montant_paye': 'Montant payé',
                            "retourne": "Montant retourner",
                            'reste': 'Reste à payer'
                        },
                        'abonnement_actuel': {
                            'titre': 'Abonnement actuel',
                            "details": {
                                "expire": "Inactif",
                                "jours": "jours restants",
                                "date_debut": "Date de début",
                                "date_fin": "Date de fin",
                                "remise": "Remise & Promo",
                                "abonnement": "Abonnement",
                                "packs": "Packs",
                                'net_paye': 'Net à payer',
                                "suspendre": "Abonnement suspendre"
                            },
                        },
                        'qrcode': {
                            'matricule': 'Matricule'
                        },
                        'info_adherent': {
                            'titre': 'Informations adhérent',
                            "inputs": {
                                "nom": {
                                    'titre': "Nom",
                                    'placeholder': "Entrer le nom d'adhérent",
                                },
                                "email": {
                                    'titre': "Adresse Email",
                                    'placeholder': "Entrer l'adresse Email",
                                },
                                "cin": {
                                    'titre': "CIN",
                                    'placeholder': "Entrer CIN",
                                },
                                "phone": {
                                    'titre': "Numéro de Téléphone",
                                    'placeholder': "Entrer le numéro de téléphone",
                                },
                                "gender": {
                                    'titre': "Genre",
                                    'placeholder': "Entrer le genre..",
                                },
                                "birth": {
                                    'titre': "Date de naissance",
                                    'placeholder': "Choisier votre date de naissance",
                                },
                                "address": {
                                    'titre': "Adresse",
                                    'placeholder': "Entrer l'adresse",
                                },
                                "photos": {
                                    'titre': "Photo",
                                    'placeholder': "Importer la photo d’adhérent",
                                },
                                "parrain": {
                                    'titre': "Parrain",
                                    'placeholder': "Matricule de parrain..",
                                }
                            },
                            "integrer": "Date d'integration",
                            "parrain": "Parrain"
                        },
                        'historiques': {
                            'abonnements': {
                                "titre": "Historique des abonnements",
                                "tableau": {
                                    "date_debut": "Date de début",
                                    "date_fin": "Date de fin",
                                    "remise": "Remise & Promo"
                                }
                            },
                            'paiements': {
                                "titre": "Historiques de paiements",
                                "tableau": {
                                    "date_paiement": "Date de paiements",
                                    "prix": "Prix"
                                }
                            }
                        },
                        'presences': {
                            'titre': 'Historiques de présences',
                            'recherche': {
                                'date': 'Date du au'
                            },
                            "visites": "Nombre de visites",
                            "entrer": "Entrer",
                            "sortier": "Sortier"
                        },
                        "activities": {
                            "titre": "Activités",
                            "abonnement": "Abonnement"
                        },
                        "recharges": {
                            "titre": "Recharges",
                            "solde": "Solde",
                            "tableau": {
                                "date_recharge": "Date de recharge",
                                "recharge": "Recharge",
                                "type": "Type de recharge"
                            }
                        },
                        "parrinages": {
                            "titre": "Parrinages",
                            "tableau": {
                                "matricule": "Matricule",
                                "nom": "Nom & prénom",
                                "email": "Email"
                            }
                        }
                    }
                },
                "abonnements": {
                    'nouveau': {
                        'titre': "Nouvel abonnement",
                        'steps': {
                            'infos': "Informations adhérent",
                            'packs': "Abonnements & packs",
                            'paiements': 'Paiements'
                        },
                        "inputs": {
                            "infos": {
                                "checkbox": "Adhérent existe déja !",
                                "nom": {
                                    'titre': "Nom",
                                    'placeholder': "Entrer le nom d'adhérent",
                                },
                                "email": {
                                    'titre': "Adresse email",
                                    'placeholder': "Entrer l'adresse email..",
                                },
                                "cin": {
                                    'titre': "CIN",
                                    'placeholder': "Entrer CIN",
                                },
                                "tele": {
                                    'titre': "Numéro de téléphone",
                                    'placeholder': "Entrer le numéro de téléphone",
                                },
                                "genre": {
                                    'titre': "Genre",
                                    'placeholder': "Entrer le genre..",
                                },
                                "date_naiss": {
                                    'titre': "Date de naissance",
                                    'placeholder': "Choisier votre date de naissance",
                                },
                                "address": {
                                    'titre': "Adresse",
                                    'placeholder': "Entrer l'adresse",
                                },
                                "photos": {
                                    'titre': "Photo",
                                    'placeholder': "Importer la photo d’adhérent",
                                },
                                "parrain": {
                                    'titre': "Parrain",
                                    'placeholder': "Matricule de parrain",
                                },
                                "matricule": {
                                    'titre': "Matricule",
                                    'placeholder': "Matricule adhérent",
                                }
                            },
                            "abonnements": {
                                "checkbox": "Si vous souhaitez de choisier le type d'abonnement maintenant, sélectionnez cette option",
                                "date_debut": {
                                    "titre": "Date de début",
                                    "placeholder": "Date de début"
                                },
                                "date_fin": {
                                    "titre": "Date de fin",
                                    "placeholder": "Date de fin"
                                },
                                "remise": {
                                    "titre": "Remise",
                                    "placeholder": "Entrer Remise.."
                                },
                                "abonnement": {
                                    "titre": "Type d'abonnement",
                                    "placeholder": "Type d'abonnement"
                                },
                                "packs": {
                                    "titre": "Pack",
                                    "placeholder": "Pack"
                                }
                            },
                            "paiements": {
                                "checkbox": "Si vous souhaitez payer l'abonnement maintenant, séléctionnez cette option",
                                "checkbox_ass": "Si vous souhaitez payer l'assurance maintenant, séléctionnez cette option",
                                "date_paiement": {
                                    "titre": "Date de paiement",
                                    "placeholder": "Date de paiement"
                                },
                                "prix": {
                                    "titre": "Montant payé",
                                    "placeholder": "Entrer le prix.."
                                }
                            }
                        },
                        "facture": {
                            "abonnement": "Type d'abonnement",
                            "packs": "Tarif de pack",
                            "remise": "Remise",
                            "total_net_paye": "Prix net à payer",
                            "montant_paye": "Montant payé",
                            "reste": "Restant à payer",
                            "month": "Mois"
                        }
                    },
                    "encours": {
                        "titre": "Abonnements en cours",
                        "recherche": {
                            "abonnement": "Type d'abonnement",
                            "pack": "Type de pack",
                            "date": "Date du au"
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin,  nom & prénom, email, genre..."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "jours": "Jours restants",
                            "type_abonnement": "Type d'abonnement",
                            "type_pack": "Type de pack",
                            "statut": "Statut",
                            "action": "Action"
                        }
                    },
                    "terminer": {
                        "titre": "Abonnements terminés",
                        "recherche": {
                            "abonnement": "Type d'abonnement",
                            "pack": "Type de pack",
                            "date": "Date du au"
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin,  nom & prénom, email, genre..."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "jours": "Jours restants",
                            "type_abonnement": "Type d'abonnement",
                            "type_pack": "Type de pack",
                            "statut": "Statut",
                            "action": "Action"
                        }
                    },
                    "modifier": {
                        "titre": "Changement type d'abonnement ou pack",
                        "abonnement_actuel": {
                            "titre": "Détails abonnement actuel",
                            "details": {
                                "type_abonnement": "Type d'abonnement",
                                "type_pack": "Type de pack",
                                "remise": "Remise d'abonnement",
                                "promotion": "Remise de promotion",
                                "montant_paye": "Total montant payé",
                                "retourner": "Total montant returner de cette abonnement",
                                "surcaisse": "Montant sur caisse",
                                "net_paye": "Total net à payer"
                            }
                        },

                        "abonnement_choisir": {
                            "titre": "Détails nouvelle abonnement",
                            "details": {
                                "type_abonnement": "Type d'abonnement",
                                "type_pack": "Type de pack",
                                "remise": "Remise d'abonnement",
                                "promotion": "Remise de promotion",
                                "net_paye": "Total nouveau net à payer",
                                "calcule_net_surcaisse": " Nouvel net à payer - montant a caisse"
                            }
                        },
                        "inputs": {
                            "packs": "Type de pack",
                            "abonnement": "Type d'abonnement",
                            "remise": {
                                "titre": "Remise",
                                "placeholder": "Remise"
                            }
                        }

                    },
                    "desabonner": {
                        "titre": "Se désabonner",
                        "recherche": {
                            "date": "Date du au"
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin, nom & prénom, email, genre..."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "suspendre_at": "Suspendre date",
                        }
                    },
                    "empeches": {
                        "titre": "Liste des absences",
                        "liste": {
                            "recherche": {
                                "date": "Date du au",
                                "statut": {
                                    "titre": "Statut",
                                    "tous": "Tous",
                                    "valide": "Validé",
                                    "bloque": "Bloqué"
                                }
                            },
                            "filtrer": {
                                "titre": "Filtrer",
                                "placeholder": "..."
                            },
                            "tableau": {
                                "matricule": "Matricule",
                                "nom": "Nom",
                                "empeche": "Motif",
                                "date_declaration": "Date de déclaration",
                                "debut_empeche": "Début d'absence",
                                "date_retour": "Date de retour",
                                "nv_date_fin": "Nouvelle date de fin",
                                "nb_jours_declare": "Jours d'absences",
                                "jours": "Jours restants",
                                "statut": "Statut",
                                "action": "Action"
                            },
                            "statut": {
                                "attendant": "En attendant",
                                "expire": "Expiré",
                                "active": "Active"
                            }
                        },
                        "nouveau": {
                            "titre": "Ajouter une absence",
                            "titre_modif": "Modifier une absence",
                            "inputs": {
                                "adherents": {
                                    "titre": "Adhérents",
                                },
                                "empeche": {
                                    "titre": "Motif",
                                    "placeholder": "Motif"
                                },
                                "nb_jours_declare": {
                                    "titre": "Jours d'absence",
                                    "placeholder": "Jours d'absence"
                                },
                                "date_absence": {
                                    "titre": "Date d'absence"
                                },
                            },
                            "text": {
                                "date_fin": "Date de Date de fin",
                                "jours": "Abonnement Jours restants",
                                "nv_jours": "Jours restants between date absence et Date de fin abonnement",
                                "impossible": "Impossible"
                            }
                        }
                    },
                    "statistiques": {
                        "titre": "Statistiques type de packs & type d'abonnements",
                        "recherche": {
                            "annee": "Années"
                        },
                        "packs": "Statistiques de packs par année",
                        "abonnements": "Statistiques de abonnements par année",
                    }
                },
                "paiements": {
                    "recharges": {
                        "titre": "Recharges",
                        "nouveau": {
                            "titre": "Ajouter un recharge",
                            "inputs": {
                                "type": {
                                    "titre": "Type de recharge",
                                    "recharge": "Recharge",
                                    "achat": "Achat",
                                    "parrinage": "Parrinages"
                                },
                                "matricule": {
                                    "titre": "Matricule",
                                    "placeholder": "Matricule"
                                },
                                "prix": "Prix"
                            }
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin, nom & prénom..."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom",
                            "date_recharge": "Date de recharge",
                            "prix": "Prix",
                            "type": "Type de recharge",
                            "action": "Action"
                        }
                    },
                    "statistiques": {
                        "titre": "Statistiques règlements",
                        "recherche": {
                            "matricule": {
                                "titre": "Matricule",
                                "placeholder": "Matricule"
                            },
                            "annee": {
                                "titre": "Année",
                                "placeholder": "Années"
                            },
                            "mois": {
                                "titre": "Mois",
                                "placeholder": "Mois"
                            }
                        },
                        "format_tableau": {
                            "titre": "Sous format de tableau",
                            "filtrer": {
                                "titre": "Filtrer",
                                "placeholder": "Mois ou année..."
                            },
                            "tableau": {
                                "mois": "Mois",
                                "annee": "Année",
                                "montant_total": "Montant total"
                            }
                        },
                        "format_graphique": {
                            "titre": "Sous format de graphique"
                        }
                    },
                    "impayes": {
                        "titre": "Les impayés",
                        "recherche": {
                            "adherents": "Adhérents"
                        },
                        "revenu": {
                            "net_paye": "Net total à payer",
                            "montant_paye": "Montant total payé",
                            "montant_retourne": "Montant total retourné",
                            "montant_rest": "Montant total restant"
                        },
                        "info_adherent": {
                            "titre": "Informations adhérent",
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "email": "Email"
                        },
                        "details_abonnement": {
                            "titre": "Détails abonnement",
                            "type_abonnement": "Type d'abonnement",
                            "type_pack": "Type de pack",
                            "activities": "Activités",
                            "suspendre": "Abonnement suspended a"
                        },
                        "regler": {
                            "titre": "Régler",
                            "inputs": {
                                "payer": {
                                    "titre": "à payer",
                                    "placeholder": "prix"
                                }
                            },
                            "reste": "Restant à payer"
                        },
                        "details_reglement": {
                            "titre": "Détails de réglements",
                            "tableau": {
                                "date_debut": "Date de début",
                                "date_fin": "Date de fin",
                                "jours": "Jours restants",
                                "prix_pack_mois": "Prix du pack",
                                "remise_abn_promo": "Remise & Promo",
                                "net_paye": "Net à payer",
                                "statut": {
                                    "titre" : "Statut",
                                    "expire" : "Inactif",
                                    "active" : "Actif"
                                },
                                "paiements": {
                                    "date_paiement": "Date de paiement",
                                    "montant_paye": "Montant payé"
                                },
                                "calcule": {
                                    "total_paye_et_retour": "Montant total payé  - Montant total retourné",
                                    "montant_caisse": "Montant sur caisse",
                                    "net_paye_et_caisse": "[ Net à payer - Montant sur caisse ]",
                                    "reste_payer": "Restant à payer"
                                }
                            },
                        }
                    },
                    "historiques": {
                        "titre": "Historiques de réglements",
                        "recherche": {
                            "adherents": "Adhérents",
                            "ordre" : {
                                "titre" : "Ordre",
                                "tous" : "Tous",
                                "derniers_abonnement" : "Dernier abonnement"
                            },
                            "date" : "Date du au"
                        },
                        "revenu": {
                            "net_paye": "Net total à payer",
                            "montant_paye": "Montant total payé",
                            "montant_retourne": "Montant total retourné",
                            "montant_rest": "Montant total restant"
                        },
                        "info_adherent": {
                            "titre": "Informations adhérent",
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "email": "Email"
                        },
                        "details_abonnement": {
                            "titre": "Détails abonnement",
                            "type_abonnement": "Type d'abonnement",
                            "type_pack": "Type de pack",
                            "activities": "Activités",
                            "suspendre": "Abonnement suspended a"
                        },
                        "regler": {
                            "titre": "Régler",
                            "inputs": {
                                "payer": {
                                    "titre": "à payer",
                                    "placeholder": "prix"
                                }
                            },
                            "reste": "Restant à payer"
                        },
                        "details_reglement": {
                            "titre": "Détails de réglements",
                            "tableau": {
                                "date_debut": "Date de début",
                                "date_fin": "Date de fin",
                                "jours": "Jours restants",
                                "prix_pack_mois": "Prix du pack",
                                "remise_abn_promo": "Remise & Promo",
                                "net_paye": "Net à payer",
                                "statut": {
                                    "titre" : "Statut",
                                    "expire" : "Inactif",
                                    "active" : "Actif"
                                },
                                "paiements": {
                                    "date_paiement": "Date de paiement",
                                    "montant_paye": "Montant payé"
                                },
                                "calcule": {
                                    "total_paye_et_retour": "Montant total payé  - Montant total retourné",
                                    "montant_caisse": "Montant sur caisse",
                                    "net_paye_et_caisse": "[ Net à payer - Montant sur caisse ]",
                                    "reste_payer": "Restant à payer"
                                }
                            },
                        }

                    }
                },

                "parametrages": {
                    "abonnements": {
                        "titre": "Type d'abonnements",
                        "nouveau": {
                            "titre_ajout": "Nouvel type d'abonnement",
                            "titre_modif": "Modification type d'abonnement",
                            "inputs": {
                                "libelle": {
                                    "titre": "Libelle",
                                    "placeholder": "Libelle "
                                },
                                "nb_mois": {
                                    "titre": "Nombre de mois",
                                    "placeholder": "Nombre de mois "
                                }
                            }
                        },
                        "liste": {
                            "titre": "Liste types abonnements",
                            "filtrer": {
                                "titre": "Filtrer",
                                "placeholder": "Libelle, nombre de mois"
                            },
                            "tableau": {
                                "libelle": "Libelle",
                                "nb_mois": "Nombre de mois",
                                "action": "Action"
                            }
                        }
                    },
                    "pack_activities": {
                        "titre": "Pack & Activities",
                        "activities": {
                            "titre": "Liste des activities",
                            "nouveau": {
                                "titre_ajout": "Nouvelle activité",
                                "titre_modif": "Modifier l'activité",
                                "inputs": {
                                    "libelle": {
                                        "titre": "Libelle",
                                        "placeholder": "Libelle "
                                    },
                                    "image": {
                                        "titre": "image",
                                        "placeholder": "image "
                                    }
                                }
                            },
                            "liste": {
                                "titre": "Liste des activities",
                                "filtrer": {
                                    "titre": "Filtrer",
                                    "placeholder": "Libelle.."
                                },
                                "tableau": {
                                    "image": "Image",
                                    "libelle": "Libelle",
                                    "action": "Action"
                                }
                            }
                        },
                        "packs": {
                            "titre": "Liste des packs",
                            "nouveau": {
                                "titre_ajout": "Ajouter un pack",
                                "titre_modif": "Modifier le pack",
                                "inputs": {
                                    "description": {
                                        "titre": "Description",
                                        "placeholder": "Description "
                                    },
                                    "prix": {
                                        "titre": "prix",
                                        "placeholder": "prix "
                                    },
                                    "activities": {
                                        "titre": "Activités",
                                        "placeholder": "Selectionner vos activities"
                                    }
                                }
                            },
                            "liste": {
                                "titre": "Liste des packs",
                                "filtrer": {
                                    "titre": "Filtrer",
                                    "placeholder": "Description, prix.."
                                },
                                "tableau": {
                                    "description": "Description",
                                    "prix": "Prix",
                                    "activities": "Activités",
                                    "action": "Action"
                                }
                            }
                        },
                    },
                    "promotions": {
                        "titre": "Promotions",
                        "nouveau": {
                            "titre_ajout": "Nouvel promotion",
                            "titre_modif": "Modification promotion",
                            "inputs": {
                                "description": {
                                    "titre": "Description",
                                    "placeholder": "Description "
                                },
                                "remise": {
                                    "titre": "Remise",
                                    "placeholder": "Remise "
                                },
                                "date_lancement": {
                                    "titre": "Date de lancement",
                                    "placeholder": "Date de lancement "
                                },
                                "date_fin": {
                                    "titre": "Date de fin",
                                    "placeholder": "Date de fin "
                                },
                                "pack": {
                                    "titre": "Pack",
                                    "placeholder": "Pack "
                                },
                                "image": {
                                    "titre": "Image",
                                    "placeholder": "Image "
                                },
                            }
                        },
                        "liste": {
                            "titre": "Liste des promotions",
                            "filtrer": {
                                "titre": "Filtrer",
                                "placeholder": "Description, Remise",

                            },
                            "tableau": {
                                "image": "Image",
                                "remise": "Remise",
                                "pack": "Pack",
                                "date_lancement": "Date de lancement",
                                "date_fin": "Date de fin",
                                "statut": "Statut",
                                "action": "Action"
                            }
                        }
                    },


                },
                "presences": {
                    "aujourdhui": {
                        "titre": "Présences",
                        "nouveau": {
                            "titre": "Ajouter présence",
                            "matricule": {
                                "titre": "Matricule",
                                "placeholder": "Matricule"
                            }
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, nom.."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "date_entrer": "Date et heure d'entrée",
                            "date_sortier": "Date de sortier",
                            "jours": "Jours restants",
                            "statut": "Statut"
                        },
                        "statut": {
                            "entrer": "Entrer",
                            "sortier": "Sortier"
                        }
                    },
                    "historiques": {
                        "titre": "Historiques des présences",
                        "recherche": {
                            "date": "Date du au"
                        },
                    }
                },
                "utilisateurs": {
                    "titre": "Gestion des utilisateurs",
                    "nouveau": {
                        "btn_ajout": "Ajouter utilisateur",
                        "titre_ajout": "Nouveau compte utilisateur",
                        "titre_modif": "Modification des informations",
                        "inputs": {
                            "nom": "Nom & prénom",
                            "email": "Email",
                            "cin": "Cin",
                            "tele": "Téléphone",
                            "genre": "Genre",
                            "photo": "Photo"
                        }
                    },
                    "recherche": {
                        "statut": {
                            "titre": "Statut",
                            "tous": "Tous",
                            "valid": "Validé",
                            "bloque": "Bloqué"
                        },
                        "date": "Date du au"
                    },
                    "filtrer": {
                        "titre": "Filtrer",
                        "placeholder": "Email, nom..."
                    },
                    "tableau": {
                        "afficher": "Afficher / masquer",
                        "cin": "Cin",
                        "nom": "Nom & prénom",
                        "email": "Email",
                        "tele": "Téléphone",
                        "genre": "Genre",
                        "parrain": "Parrain",
                        "statut": "Statut",
                        "action": "Action",
                        "sous_tableau": {
                            "role": "Les accès",
                            "action": "Action"
                        }
                    }
                }
            },
            "bouton": {
                "enregistrer" : "Enregistrer",
                "ajout": "Ajouter",
                "annuler": "Annuler",
                "valid": "Validé",
                "upload": "Importer",
                "modifier": "Modifier",
                "supprimer" : "Supprimer",
                "close": "Fermer",
                "prev": "Précédent",
                "next": "Suivant",
                "completed": "Terminé",
                'afficher_tout': 'Afficher tout',
                'recherche': 'Rechercher',
                'filtrer_recherche': 'Rechercher',
                "active": "Activer",
                "desactive": "Désactiver",
                "regler" : "Régler",
                "mise_jour" : "Mise à jour",
                "suspendre" : "Suspendre",
                "renouvler" : "Renouvler",
                "ok" : "Ok",
                "non" : "Non",
                "oui" : "Oui"
            },
            "alerts": {
                "ajout" : {
                    "message" : "Vous êtes sûr de vouloir ajouter ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "L’opération est effectuée avec succès"
                },
                "suppression" : {
                    "message" : "Vous êtes sûr de vouloir supprimer ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "La suppression est effectuée avec succès"
                },
                "modification" : {
                    "message" : "Vous êtes sûr de vouloir modifier ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "Les modifications ont été effectués avec succès"
                },
                "modification_adherent" : {
                    "message" : "Vous êtes sûr de vouloir modifier les informations ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "Les informations ont été modifiés avec succès"
                },
                "suspendre" : {
                    "message" : "Vous êtes sûr de vouloir suspendre ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "Adhérent suspendre avec success"
                },
                "aucune_info" : "Aucune information à afficher.",
                "permission" : "Vous n'êtes pas autorisé à naviguer sur cette page",
                "adherents" : {
                    "n_existe" : "Cet adhérent n'existe pas",
                    "ni_abonner" : "Adhérent délégué n'est pas abonné ou son abonnement a été térimné",
                    "absent" : "Cet adhérent est absent dans cette période",
                    "ni_ajout" : "Adhérent n'a pas été ajouté, veuillez réessayer plus tard."
                },
                "recharge" : {
                    "n_existe" : "n'existe pas"
                },
                "utilisateur" : {
                    "n_existe" : "Utilisateur n'existe pas"
                },
                "abonnement" : {
                    "n_existe" : "Type d'abonnement n'existe pas",
                    "affecter" : "Impossible de supprimer ce type d'abonnement, car il est encore affecté à des adhérents",
                },
                "promotion" : {
                    "n_existe" : "Promotion n'existe pas",
                },
                "activitie" : {
                    "n_existe" : "Activitie n'existe pas",
                    "affecter" : "Impossible de supprimer cet élément , car il est encore affecté à des adhérents",
                },
                "pack" : {
                    "n_existe" : "Pack n'existe pas",
                    "affecter" : "Impossible de supprimer cet élément , car il est encore affecté à des adhérents",
                },
                "categorie" : {
                    "n_existe" : "Catégorie n'existe pas",
                },
                "service" : {
                    "n_existe" : "Service n'existe pas",
                },
                "frais" : {
                    "n_existe" : "Frais n'existe pas",
                }
            },
            "text" : {
                "dh" : "Dh",
                "mois": "Mois",
                "annee" : "Année",
                "jours" : "j",
                "affichage" : 'Affichage de {start} - {end} sur {total}',
                "homme" : 'Homme',
                'homme_H' : 'H',
                "femme" : 'Femme',
                'femme_F' : 'F', 
                'jours_terminer' : 'Terminé', 
                'select_tout' : 'Sélectionner tout'
            }
        },
        "validation": {
            'accepted': 'Le champ {attribute} doit être accepté.',
            'active_url': "Le champ {attribute} n'est pas une URL valide.",
            'after': 'Le champ {attribute} doit être une date postérieure au {date}.',
            'after_or_equal': 'Le champ {attribute} doit être une date postérieure ou égale au {date}.',
            'alpha': 'Le champ {attribute} doit contenir uniquement des lettres.',
            'alpha_dash': 'Le champ {attribute} doit contenir uniquement des lettres, des chiffres et des tirets.',
            'alpha_num': 'Le champ {attribute} doit contenir uniquement des chiffres et des lettres.',
            'array': 'Le champ {attribute} doit être un tableau.',
            'before': 'Le champ {attribute} doit être une date antérieure au {date}.',
            'before_or_equal': 'Le champ {attribute} doit être une date antérieure ou égale au {date}.',
            'between': {
                'numeric': 'La valeur de {attribute} doit être comprise entre {min} et {max}.',
                'file': 'La taille du fichier de {attribute} doit être comprise entre {min} et {max} kilo-octets.',
                'string': 'Le texte {attribute} doit contenir entre {min} et {max} caractères.',
                'array': 'Le tableau {attribute} doit contenir entre {min} et {max} éléments.',
            },
            'boolean': 'Le champ {attribute} doit être vrai ou faux.',
            'confirmed': 'Le champ de confirmation {attribute} ne correspond pas.',
            'date': "Le champ {attribute} n'est pas une date valide.",
            'date_equals': 'Le champ {attribute} doit être une date égale à {date}.',
            'date_format': 'Le champ {attribute} ne correspond pas au format {format}.',
            'different': 'Les champs {attribute} et {other} doivent être différents.',
            'digits': 'Le champ {attribute} doit contenir :digits chiffres.',
            'digits_between': 'Le champ {attribute} doit contenir entre {min} et {max} chiffres.',
            'dimensions': "La taille de l'image {attribute} n'est pas conforme.",
            'distinct': 'Le champ {attribute} a une valeur en double.',
            'email': 'Le champ {attribute} doit être une adresse email valide.',
            'ends_with': 'Le champ {attribute} doit se terminer par une des valeurs suivantes : {values}',
            'exists': 'Le champ {attribute} sélectionné est invalide.',
            'file': 'Le champ {attribute} doit être un fichier.',
            'filled': 'Le champ {attribute} doit avoir une valeur.',
            'gt': {
                'numeric': 'La valeur de {attribute} doit être supérieure à {value}.',
                'file': 'La taille du fichier de {attribute} doit être supérieure à {value} kilo-octets.',
                'string': 'Le texte {attribute} doit contenir plus de {value} caractères.',
                'array': 'Le tableau {attribute} doit contenir plus de {value} éléments.',
            },
            'gte': {
                'numeric': 'La valeur de {attribute} doit être supérieure ou égale à {value}.',
                'file': 'La taille du fichier de {attribute} doit être supérieure ou égale à {value} kilo-octets.',
                'string': 'Le texte {attribute} doit contenir au moins {value} caractères.',
                'array': 'Le tableau {attribute} doit contenir au moins {value} éléments.',
            },
            'image': 'Le champ {attribute} doit être une image.',
            'in': 'Le champ {attribute} est invalide.',
            'in_array': "Le champ {attribute} n'existe pas dans {other}.",
            'integer': 'Le champ {attribute} doit être un entier.',
            'ip': 'Le champ {attribute} doit être une adresse IP valide.',
            'ipv4': 'Le champ {attribute} doit être une adresse IPv4 valide.',
            'ipv6': 'Le champ {attribute} doit être une adresse IPv6 valide.',
            'json': 'Le champ {attribute} doit être un document JSON valide.',
            'lt': {
                'numeric': 'La valeur de {attribute} doit être inférieure à {value}.',
                'file': 'La taille du fichier de {attribute} doit être inférieure à {value} kilo-octets.',
                'string': 'Le texte {attribute} doit contenir moins de {value} caractères.',
                'array': 'Le tableau {attribute} doit contenir moins de {value} éléments.',
            },
            'lte': {
                'numeric': 'La valeur de {attribute} doit être inférieure ou égale à {value}.',
                'file': 'La taille du fichier de {attribute} doit être inférieure ou égale à {value} kilo-octets.',
                'string': 'Le texte {attribute} doit contenir au plus {value} caractères.',
                'array': 'Le tableau {attribute} doit contenir au plus {value} éléments.',
            },
            'max': {
                'numeric': 'La valeur de {attribute} ne peut être supérieure à {max}.',
                'file': 'La taille du fichier de {attribute} ne peut pas dépasser {max} kilo-octets.',
                'string': 'Le texte de {attribute} ne peut contenir plus de {max} caractères.',
                'array': 'Le tableau {attribute} ne peut contenir plus de {max} éléments.',
            },
            'mimes': 'Le champ {attribute} doit être un fichier de type : {values}.',
            'mimetypes': 'Le champ {attribute} doit être un fichier de type : {values}.',
            'min': {
                'numeric': 'La valeur de {attribute} doit être supérieure ou égale à {min}.',
                'file': 'La taille du fichier de {attribute} doit être supérieure à {min} kilo-octets.',
                'string': 'Le texte {attribute} doit contenir au moins {min} caractères.',
                'array': 'Le tableau {attribute} doit contenir au moins {min} éléments.',
            },
            'multiple_of': 'La valeur de {attribute} doit être un multiple de {value}',
            'not_in': "Le champ {attribute} sélectionné n'est pas valide.",
            'not_regex': "Le format du champ {attribute} n'est pas valide.",
            'numeric': 'Le champ {attribute} doit contenir un nombre.',
            'password': 'Le mot de passe est incorrect',
            'present': 'Le champ {attribute} doit être présent.',
            'regex': 'Le format du champ {attribute} est invalide.',
            'required': 'Le champ {attribute} est obligatoire.',
            'required_if': 'Le champ {attribute} est obligatoire quand la valeur de {other} est {value}.',
            'required_unless': 'Le champ {attribute} est obligatoire sauf si {other} est {values}.',
            'required_with': 'Le champ {attribute} est obligatoire quand {values} est présent.',
            'required_with_all': 'Le champ {attribute} est obligatoire quand {values} sont présents.',
            'required_without': "Le champ {attribute} est obligatoire quand {values} n'est pas présent.",
            'required_without_all': "Le champ {attribute} est requis quand aucun de {values} n'est présent.",
            'same': 'Les champs {attribute} et {other} doivent être identiques.',
            'size': {
                'numeric': 'La valeur de {attribute} doit être :size.',
                'file': 'La taille du fichier de {attribute} doit être de :size kilo-octets.',
                'string': 'Le texte de {attribute} doit contenir :size caractères.',
                'array': 'Le tableau {attribute} doit contenir :size éléments.',
            },
            'starts_with': 'Le champ {attribute} doit commencer avec une des valeurs suivantes : {values}',
            'string': 'Le champ {attribute} doit être une chaîne de caractères.',
            'timezone': 'Le champ {attribute} doit être un fuseau horaire valide.',
            'unique': 'La valeur du champ {attribute} est déjà utilisée.',
            'uploaded': "Le fichier du champ {attribute} n'a pu être téléversé.",
            'url': "Le format de l'URL de {attribute} n'est pas valide.",
            'uuid': 'Le champ {attribute} doit être un UUID valide',
            'custom': {
                'attribute-name': {
                    'rule-name': 'custom-message',
                },
            },
            'attributes': {
                'name': 'nom',
                'username': "nom d'utilisateur",
                'email': 'adresse email',
                'first_name': 'prénom',
                'last_name': 'nom',
                'password': 'mot de passe',
                'password_confirmation': 'confirmation du mot de passe',
                'city': 'ville',
                'country': 'pays',
                'address': 'adresse',
                'phone': 'téléphone',
                'mobile': 'portable',
                'age': 'âge',
                'sex': 'sexe',
                'gender': 'genre',
                'day': 'jour',
                'month': 'mois',
                'year': 'année',
                'hour': 'heure',
                'minute': 'minute',
                'second': 'seconde',
                'title': 'titre',
                'content': 'contenu',
                'description': 'description',
                'excerpt': 'extrait',
                'date': 'date',
                'time': 'heure',
                'available': 'disponible',
                'size': 'taille'
            }
        }
    },
    "en": {
       'side': {
            "menu": {
                "dashboard": "Tableau de bord",
                "adherents": {
                    "titre": "Gestion des adhérents",
                    "liste": "Liste adherents",
                    "badges": "Badge adhérents"
                },
                "abonnements": {
                    "titre": "Gestion des abonnements",
                    "nouveau": "Nouvel abonnement",
                    "encours": "Abonnements actifs",
                    "terminer": "Abonnements términés",
                    "desabonner": "Se désabonner",
                    "empeches": "Absences",
                    "statistiques": "Statistiques"

                },
                "paiements": {
                    "titre": "Gestion des paiements",
                    "impayes": "Les impayés",
                    "historiques": "Historique des réglements",
                    "recharges": "Recharges",
                    "statistiques": "Statistiques"
                },
                "presences": {
                    "titre": "Gestion des présences",
                    "aujourdhui": "Aujourd'hui",
                    "historiques": "Historiques"
                },
                "utilisateurs": "Gestion des utilisateurs",
                "parametrages": {
                    "titre": "Paramétrage",
                    "abonnements": "Abonnements",
                    "activities": "Activités & packs",
                    "promotions": "Promotions"
                }
            }
        },
        'header': {
            "lang": {
                "francais": "Francais",
                "anglais": "Anglais",
                "arabe": "Arabe"
            },
            "recherche": {
                "titre": " Le profile adhérent est reconnaissable par le matricule",
                "placeholder": "Matricule"
            },
            "notifications": {
                "abonnement_avant_terminer": {
                    "titre": "Liste d'abonnements au moins 15 jours avant la Date de fin",
                    "date_fin": "Date de fin",
                    "jours": "Jours restants"
                },
                "abonnement_terminer": {
                    "titre": "Derniers abonnements terminé",
                    "date_fin": "Date de fin",
                    "jours": "Jours restants"
                },
                "promotions": {
                    "titre": "Promotions",
                    "date_fin": "Date de fin"
                },
                "utilisateur": {
                    "deconnexion": "Déconnexion"
                }
            }
        },
        "content": {
            "pages": {
                "dashboard": {
                    "titre": "Tableau de bord",
                    "count": {
                        "filtrer": {
                            "date": "Date du au"
                        },
                        "adherents": "Adhérents",
                        "encours": "Abonnements en cours",
                        "presences": "Présences"
                    },
                    "adherents": {
                        "titre": "Derniers adhérents",
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "cin": "Cin",
                            "genre": "Genre"
                        }
                    },
                    "abonnement_terminer": {
                        "titre": "Derniers abonnements terminé",
                        "tableau": {
                            "matricule": "Matricule",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "jours": "Jours restants"
                        }
                    },
                    "abonnement_avant_terminer": {
                        "titre": "Liste d'abonnements au moins 15 jours avant la Date de fin",
                        "tableau": {
                            "matricule": "Matricule",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "jours": "Jours restants"
                        }
                    },
                    "statistiques_reglements": {
                        "titre": "Statistiques de 3 derniers mois"
                    }


                },
                "adherents": {
                    "liste": {
                        "nouveau": "Ajouter un adhérent",
                        "titre": "Fiche adhérents",
                        "recherche": {
                            "statut": {
                                "titre": "Statut",
                                "tous": "Tous",
                                "valide": "Validé",
                                "bloque": "Bloqué"
                            },
                            "date": "Date du au",
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin, nom & prénom, email, genre..."
                        },
                        "tableau": {
                            "qrcode": "Qr code",
                            "matricule": "Matricule",
                            "cin": "Cin",
                            "nom": "Nom & prénom",
                            "email": "Email",
                            "tele": "Téléphone",
                            "date_naiss": "Date de naissance",
                            "genre": "Genre",
                            "statut": "Statut"
                        }
                    },
                    "badges": {
                        "titre": "Badges",
                        "recherche": {
                            "matricule": {
                                "titre": "Matricule",
                                "placeholder": "Matricule"
                            },
                            "date": "Date du au"
                        },
                        "filtrer": {
                            "titre": "filtrer",
                            "placeholder": "Matricule, Nom & prénom..."
                        },
                        "matricule": "Matricule"
                    },
                    'modale_nouveau': {
                        'titre': "Inscription nouveau adhérent",
                        "inputs": {
                            "nom": {
                                'titre': "Nom",
                                'placeholder': "Entrer le nom d'adhérent",
                            },
                            "email": {
                                'titre': "Adresse email",
                                'placeholder': "Entrer l'adresse email..",
                            },
                            "cin": {
                                'titre': "CIN",
                                'placeholder': "Entrer CIN",
                            },
                            "tele": {
                                'titre': "Téléphone",
                                'placeholder': "Entrer le numéro de téléphone",
                            },
                            "gender": {
                                'titre': "Genre",
                                'placeholder': "Entrer le genre..",
                            },
                            "date_naiss": {
                                'titre': "Date de naissance",
                                'placeholder': "Choisier votre date de naissance",
                            },
                            "address": {
                                'titre': "Adresse",
                                'placeholder': "Entrer l'adresse",
                            },
                            "photos": {
                                'titre': "Photo",
                                'placeholder': "Importer la photo d’adhérent",
                            },
                            "parrain": {
                                'titre': "Parrain",
                                'placeholder': "Matricule de parrain..",
                            }

                        },
                    },
                    'profile': {
                        "titre": "Profile adhérent",
                        'revenu': {
                            'net_paye': 'Net à payer',
                            'montant_paye': 'Montant payé',
                            "retourne": "Montant retourner",
                            'reste': 'Reste à payer'
                        },
                        'abonnement_actuel': {
                            'titre': 'Abonnement actuel',
                            "details": {
                                "expire": "Inactif",
                                "jours": "jours restants",
                                "date_debut": "Date de début",
                                "date_fin": "Date de fin",
                                "remise": "Remise & Promo",
                                "abonnement": "Abonnement",
                                "packs": "Packs",
                                'net_paye': 'Net à payer',
                                "suspendre": "Abonnement suspendre"
                            },
                        },
                        'qrcode': {
                            'matricule': 'Matricule'
                        },
                        'info_adherent': {
                            'titre': 'Informations adhérent',
                            "inputs": {
                                "nom": {
                                    'titre': "Nom",
                                    'placeholder': "Entrer le nom d'adhérent",
                                },
                                "email": {
                                    'titre': "Adresse Email",
                                    'placeholder': "Entrer l'adresse Email..",
                                },
                                "cin": {
                                    'titre': "CIN",
                                    'placeholder': "Entrer CIN",
                                },
                                "phone": {
                                    'titre': "Téléphone",
                                    'placeholder': "Entrer le numéro de téléphone",
                                },
                                "gender": {
                                    'titre': "Genre",
                                    'placeholder': "Entrer le genre..",
                                },
                                "birth": {
                                    'titre': "Date de naissance",
                                    'placeholder': "Choisier votre date de naissance",
                                },
                                "address": {
                                    'titre': "Adresse",
                                    'placeholder': "Entrer l'adresse",
                                },
                                "photos": {
                                    'titre': "Photo",
                                    'placeholder': "Importer la photo d’adhérent",
                                },
                                "parrain": {
                                    'titre': "Parrain",
                                    'placeholder': "Matricule de parrain..",
                                }
                            },
                            "integrer": "Date d'integration",
                            "parrain": "Parrain"
                        },
                        'historiques': {
                            'abonnements': {
                                "titre": "Historique des abonnements",
                                "tableau": {
                                    "date_debut": "Date de début",
                                    "date_fin": "Date de fin",
                                    "remise": "Remise & Promo"
                                }
                            },
                            'paiements': {
                                "titre": "Historiques de paiements",
                                "tableau": {
                                    "date_paiement": "Date de paiements",
                                    "prix": "Prix"
                                }
                            }
                        },
                        'presences': {
                            'titre': 'Historiques de présences',
                            'recherche': {
                                'date': 'Date du au'
                            },
                            "visites": "Nombre de visites",
                            "entrer": "Entrer",
                            "sortier": "Sortier"
                        },
                        "activities": {
                            "titre": "Activités",
                            "abonnement": "Abonnement"
                        },
                        "recharges": {
                            "titre": "Recharges",
                            "solde": "Solde",
                            "tableau": {
                                "date_recharge": "Date de recharge",
                                "recharge": "Recharge",
                                "type": "Type de recharge"
                            }
                        },
                        "parrinages": {
                            "titre": "Parrinages",
                            "tableau": {
                                "matricule": "Matricule",
                                "nom": "Nom & prénom",
                                "email": "Email"
                            }
                        }
                    }
                },
                "abonnements": {
                    'nouveau': {
                        'titre': "Ajouter un abonnement",
                        'steps': {
                            'infos': "Informations adhérent",
                            'packs': "Abonnements & packs",
                            'paiements': 'Paiements'
                        },
                        "inputs": {
                            "infos": {
                                "checkbox": "Adhérent existe deja !",
                                "nom": {
                                    'titre': "Nom",
                                    'placeholder': "Entrer le nom d'adhérent",
                                },
                                "email": {
                                    'titre': "Adresse email",
                                    'placeholder': "Entrer l'adresse email..",
                                },
                                "cin": {
                                    'titre': "CIN",
                                    'placeholder': "Entrer CIN",
                                },
                                "tele": {
                                    'titre': "Téléphone",
                                    'placeholder': "Entrer le numéro de téléphone",
                                },
                                "genre": {
                                    'titre': "Genre",
                                    'placeholder': "Entrer le genre..",
                                },
                                "date_naiss": {
                                    'titre': "Date de naissance",
                                    'placeholder': "Choisier votre date de naissance",
                                },
                                "address": {
                                    'titre': "Adresse",
                                    'placeholder': "Entrer l'adresse",
                                },
                                "photos": {
                                    'titre': "Photo",
                                    'placeholder': "Importer la photo d’adhérent",
                                },
                                "parrain": {
                                    'titre': "Parrain",
                                    'placeholder': "Matricule de parrain",
                                },
                                "matricule": {
                                    'titre': "Matricule",
                                    'placeholder': "Matricule adhérent",
                                }
                            },
                            "abonnements": {
                                "checkbox": "Si vous souhaitez de choisier le type d'abonnement maintenant, sélectionnez cette option",
                                "date_debut": {
                                    "titre": "Date de début",
                                    "placeholder": "Date de début"
                                },
                                "date_fin": {
                                    "titre": "Date de fin",
                                    "placeholder": "Date de fin"
                                },
                                "remise": {
                                    "titre": "Remise",
                                    "placeholder": "Entrer Remise.."
                                },
                                "abonnement": {
                                    "titre": "Type d'abonnement",
                                    "placeholder": "Type d'abonnement"
                                },
                                "packs": {
                                    "titre": "Pack",
                                    "placeholder": "Pack"
                                }
                            },
                            "paiements": {
                                "checkbox": "Si vous souhaitez payer l'abonnement maintenant, séléctionnez cette option",
                                "checkbox_ass": "Si vous souhaitez payer l'assurance maintenant, séléctionnez cette option",
                                "date_paiement": {
                                    "titre": "Date de paiement",
                                    "placeholder": "Date de paiement"
                                },
                                "prix": {
                                    "titre": "Montant payé",
                                    "placeholder": "Entrer le prix.."
                                }
                            }
                        },
                        "facture": {
                            "abonnement": "Type d'abonnement",
                            "packs": "Tarif de pack",
                            "remise": "Remise",
                            "total_net_paye": "Prix net à payer",
                            "montant_paye": "Montant payé",
                            "reste": "Restant à payer",
                            "month": "Mois"
                        }
                    },
                    "encours": {
                        "titre": "Abonnements en cours",
                        "recherche": {
                            "abonnement": "Type d'abonnement",
                            "pack": "Type de pack",
                            "date": "Date du au"
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin,  nom & prénom, email, genre..."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "jours": "Jours restants",
                            "type_abonnement": "Type d'abonnement",
                            "type_pack": "Type de pack",
                            "statut": "Statut",
                            "action": "Action"
                        }
                    },
                    "terminer": {
                        "titre": "Abonnements terminés",
                        "recherche": {
                            "abonnement": "Type d'abonnement",
                            "pack": "Type de pack",
                            "date": "Date du au"
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin,  nom & prénom, email, genre..."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "jours": "Jours restants",
                            "type_abonnement": "Type d'abonnement",
                            "type_pack": "Type de pack",
                            "statut": "Statut",
                            "action": "Action"
                        }
                    },
                    "modifier": {
                        "titre": "Changement type d'abonnement ou pack",
                        "abonnement_actuel": {
                            "titre": "Détails abonnement actuel",
                            "details": {
                                "type_abonnement": "Type d'abonnement",
                                "type_pack": "Type de pack",
                                "remise": "Remise d'abonnement",
                                "promotion": "Remise de promotion",
                                "montant_paye": "Total montant payé",
                                "retourner": "Total montant returner de cette abonnement",
                                "surcaisse": "Montant sur caisse",
                                "net_paye": "Total net à payer"
                            }
                        },

                        "abonnement_choisir": {
                            "titre": "Détails nouvelle abonnement",
                            "details": {
                                "type_abonnement": "Type d'abonnement",
                                "type_pack": "Type de pack",
                                "remise": "Remise d'abonnement",
                                "promotion": "Remise de promotion",
                                "net_paye": "Total nouveau net à payer",
                                "calcule_net_surcaisse": " Nouvel net à payer - montant a caisse"
                            }
                        },
                        "inputs": {
                            "packs": "Type de pack",
                            "abonnement": "Type d'abonnement",
                            "remise": {
                                "titre": "Remise",
                                "placeholder": "Remise"
                            }
                        }

                    },
                    "desabonner": {
                        "titre": "Se désabonner",
                        "recherche": {
                            "date": "Date du au"
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin, nom & prénom, email, genre..."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "date_debut": "Date de début",
                            "date_fin": "Date de fin",
                            "suspendre_at": "Suspendre date",
                        }
                    },
                    "empeches": {
                        "titre": "Liste des absences",
                        "liste": {
                            "recherche": {
                                "date": "Date du au",
                                "statut": {
                                    "titre": "Statut",
                                    "tous": "Tous",
                                    "valide": "Validé",
                                    "bloque": "Bloqué"
                                }
                            },
                            "filtrer": {
                                "titre": "Filtrer",
                                "placeholder": "..."
                            },
                            "tableau": {
                                "matricule": "Matricule",
                                "nom": "Nom",
                                "empeche": "Motif",
                                "date_declaration": "Date de déclaration",
                                "debut_empeche": "Début d’absence",
                                "date_retour": "Date de retour",
                                "nv_date_fin": "Nouvelle Date de fin",
                                "nb_jours_declare": "Jours d’absnece",
                                "jours": "Jours restants",
                                "statut": "Statut",
                                "action": "Action"
                            },
                            "statut": {
                                "attendant": "En attendant",
                                "expire": "Expiré",
                                "active": "Active"
                            }
                        },
                        "nouveau": {
                            "titre": "Ajouter une absence",
                            "inputs": {
                                "adherents": {
                                    "titre": "Adhérents",
                                },
                                "empeche": {
                                    "titre": "Motif",
                                    "placeholder": "Motif"
                                },
                                "nb_jours_declare": {
                                    "titre": "Jours d'absence",
                                    "placeholder": "Jours d'absence"
                                },
                                "date_absence": {
                                    "titre": "Date absence"
                                },
                            },
                            "text": {
                                "date_fin": "Date de Date de fin",
                                "jours": "Abonnement Jours restants",
                                "nv_jours": "Jours restants between date absence et Date de fin abonnement",
                                "impossible": "Impossible"
                            }
                        }
                    },
                    "statistiques": {
                        "titre": "Statistiques type de packs & type d'abonnements",
                        "recherche": {
                            "annee": "Années"
                        },
                        "packs": "Statistiques de packs par année",
                        "abonnements": "Statistiques de abonnements par année",
                    }
                },
                "paiements": {
                    "recharges": {
                        "titre": "Recharges",
                        "nouveau": {
                            "titre": "Ajouter un recharge",
                            "inputs": {
                                "type": {
                                    "titre": "Type de recharge",
                                    "recharge": "Recharge",
                                    "achat": "Achat",
                                    "parrinage": "Parrinages"
                                },
                                "matricule": {
                                    "titre": "Matricule",
                                    "placeholder": "Matricule"
                                },
                                "prix": "Prix"
                            }
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, cin, nom & prénom..."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom",
                            "date_recharge": "Date de recharge",
                            "prix": "Prix",
                            "type": "Type de recharge",
                            "action": "Action"
                        }
                    },
                    "statistiques": {
                        "titre": "Statistiques règlements",
                        "recherche": {
                            "matricule": {
                                "titre": "Matricule",
                                "placeholder": "Matricule"
                            },
                            "annee": {
                                "titre": "Année",
                                "placeholder": "Années"
                            },
                            "mois": {
                                "titre": "Mois",
                                "placeholder": "Mois"
                            }
                        },
                        "format_tableau": {
                            "titre": "Sous format de tableau",
                            "filtrer": {
                                "titre": "Filtrer",
                                "placeholder": "Mois ou année..."
                            },
                            "tableau": {
                                "mois": "Mois",
                                "annee": "Année",
                                "montant_total": "Montant total"
                            }
                        },
                        "format_graphique": {
                            "titre": "Sous format de graphique"
                        }
                    },
                    "impayes": {
                        "titre": "Les impayés",
                        "recherche": {
                            "adherents": "Adhérents"
                        },
                        "revenu": {
                            "net_paye": "Net total à payer",
                            "montant_paye": "Montant total payé",
                            "montant_retourne": "Montant total retourné",
                            "montant_rest": "Montant total restant"
                        },
                        "info_adherent": {
                            "titre": "Informations adhérent",
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "email": "Email"
                        },
                        "details_abonnement": {
                            "titre": "Détails abonnement",
                            "type_abonnement": "Type d'abonnement",
                            "type_pack": "Type de pack",
                            "activities": "Activités",
                            "suspendre": "Abonnement suspended a"
                        },
                        "regler": {
                            "titre": "Régler",
                            "inputs": {
                                "payer": {
                                    "titre": "à payer",
                                    "placeholder": "prix"
                                }
                            },
                            "reste": "Restant à payer"
                        },
                        "details_reglement": {
                            "titre": "Détails de réglements",
                            "tableau": {
                                "date_debut": "Date de début",
                                "date_fin": "Date de fin",
                                "jours": "Jours restants",
                                "prix_pack_mois": "Prix du pack",
                                "remise_abn_promo": "Remise & Promo",
                                "net_paye": "Net à payer",
                                "statut": {
                                    "titre" : "Statut",
                                    "expire" : "Inactif",
                                    "active" : "Actif"
                                },
                                "paiements": {
                                    "date_paiement": "Date de paiement",
                                    "montant_paye": "Montant payé"
                                },
                                "calcule": {
                                    "total_paye_et_retour": "Montant total payé  - Montant total retourné",
                                    "montant_caisse": "Montant sur caisse",
                                    "net_paye_et_caisse": "[ Net à payer - Montant sur caisse ]",
                                    "reste_payer": "Restant à payer"
                                }
                            },
                        }
                    },
                    "historiques": {
                        "titre": "Historiques de réglements",
                        "recherche": {
                            "adherents": "Adhérents",
                            "ordre" : {
                                "titre" : "Ordre",
                                "tous" : "Tous",
                                "derniers_abonnement" : "Dernier abonnement"
                            },
                            "date" : "Date du au"
                        },
                        "revenu": {
                            "net_paye": "Net total à payer",
                            "montant_paye": "Montant total payé",
                            "montant_retourne": "Montant total retourné",
                            "montant_rest": "Montant total restant"
                        },
                        "info_adherent": {
                            "titre": "Informations adhérent",
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "email": "Email"
                        },
                        "details_abonnement": {
                            "titre": "Détails abonnement",
                            "type_abonnement": "Type d'abonnement",
                            "type_pack": "Type de pack",
                            "activities": "Activités",
                            "suspendre": "Abonnement suspended a"
                        },
                        "regler": {
                            "titre": "Régler",
                            "inputs": {
                                "payer": {
                                    "titre": "à payer",
                                    "placeholder": "prix"
                                }
                            },
                            "reste": "Restant à payer"
                        },
                        "details_reglement": {
                            "titre": "Détails de réglements",
                            "tableau": {
                                "date_debut": "Date de début",
                                "date_fin": "Date de fin",
                                "jours": "Jours restants",
                                "prix_pack_mois": "Prix du pack",
                                "remise_abn_promo": "Remise & Promo",
                                "net_paye": "Net à payer",
                                "statut": {
                                    "titre" : "Statut",
                                    "expire" : "Inactif",
                                    "active" : "Actif"
                                },
                                "paiements": {
                                    "date_paiement": "Date de paiement",
                                    "montant_paye": "Montant payé"
                                },
                                "calcule": {
                                    "total_paye_et_retour": "Montant total payé  - Montant total retourné",
                                    "montant_caisse": "Montant sur caisse",
                                    "net_paye_et_caisse": "[ Net à payer - Montant sur caisse ]",
                                    "reste_payer": "Restant à payer"
                                }
                            },
                        }

                    }
                },

                "parametrages": {
                    "abonnements": {
                        "titre": "Type d'abonnements",
                        "nouveau": {
                            "titre_ajout": "Nouvel type d'abonnement",
                            "titre_modif": "Modification type d'abonnement",
                            "inputs": {
                                "libelle": {
                                    "titre": "Libelle",
                                    "placeholder": "Libelle "
                                },
                                "nb_mois": {
                                    "titre": "Nombre de mois",
                                    "placeholder": "Nombre de mois "
                                }
                            }
                        },
                        "liste": {
                            "titre": "Liste des types abonnements",
                            "filtrer": {
                                "titre": "Filtrer",
                                "placeholder": "Libelle, nombre de mois"
                            },
                            "tableau": {
                                "libelle": "Libelle",
                                "nb_mois": "Nombre de mois",
                                "action": "Action"
                            }
                        }
                    },
                    "pack_activities": {
                        "titre": "Pack & Activities",
                        "activities": {
                            "titre": "Liste des activities",
                            "nouveau": {
                                "titre_ajout": "Nouvel activitie",
                                "titre_modif": "Modifier l'activité",
                                "inputs": {
                                    "libelle": {
                                        "titre": "Libelle",
                                        "placeholder": "Libelle "
                                    },
                                    "image": {
                                        "titre": "image",
                                        "placeholder": "image "
                                    }
                                }
                            },
                            "liste": {
                                "titre": "Liste des activities",
                                "filtrer": {
                                    "titre": "Filtrer",
                                    "placeholder": "Libelle.."
                                },
                                "tableau": {
                                    "image": "Image",
                                    "libelle": "Libelle",
                                    "action": "Action"
                                }
                            }
                        },
                        "packs": {
                            "titre": "Liste des packs",
                            "nouveau": {
                                "titre_ajout": "Nouvel pack",
                                "titre_modif": "Modification pack",
                                "inputs": {
                                    "description": {
                                        "titre": "Description",
                                        "placeholder": "Description "
                                    },
                                    "prix": {
                                        "titre": "prix",
                                        "placeholder": "prix "
                                    },
                                    "activities": {
                                        "titre": "Activités",
                                        "placeholder": "Selectionner vos activities"
                                    }
                                }
                            },
                            "liste": {
                                "titre": "Liste des packs",
                                "filtrer": {
                                    "titre": "Filtrer",
                                    "placeholder": "Description, prix.."
                                },
                                "tableau": {
                                    "description": "Description",
                                    "prix": "Prix",
                                    "activities": "Activités",
                                    "action": "Action"
                                }
                            }
                        },
                    },
                    "promotions": {
                        "titre": "Promotions",
                        "nouveau": {
                            "titre_ajout": "Nouvel promotion",
                            "titre_modif": "Modification promotion",
                            "inputs": {
                                "description": {
                                    "titre": "Description",
                                    "placeholder": "Description "
                                },
                                "remise": {
                                    "titre": "Remise",
                                    "placeholder": "Remise "
                                },
                                "date_lancement": {
                                    "titre": "Date de lancement",
                                    "placeholder": "Date de lancement "
                                },
                                "date_fin": {
                                    "titre": "Date de fin",
                                    "placeholder": "Date de fin "
                                },
                                "pack": {
                                    "titre": "Pack",
                                    "placeholder": "Pack "
                                },
                                "image": {
                                    "titre": "Image",
                                    "placeholder": "Image "
                                },
                            }
                        },
                        "liste": {
                            "titre": "Liste des promotions",
                            "filtrer": {
                                "titre": "Filtrer",
                                "placeholder": "Description, Remise",

                            },
                            "tableau": {
                                "image": "Image",
                                "remise": "Remise",
                                "pack": "Pack",
                                "date_lancement": "Date de lancement",
                                "date_fin": "Date de fin",
                                "statut": "Statut",
                                "action": "Action"
                            }
                        }
                    },


                },
                "presences": {
                    "aujourdhui": {
                        "titre": "Présences",
                        "nouveau": {
                            "titre": "Ajouter",
                            "matricule": {
                                "titre": "Matricule",
                                "placeholder": "Matricule"
                            }
                        },
                        "filtrer": {
                            "titre": "Filtrer",
                            "placeholder": "Matricule, nom.."
                        },
                        "tableau": {
                            "matricule": "Matricule",
                            "nom": "Nom & prénom",
                            "date_entrer": "Date et heure d'entrée",
                            "date_sortier": "Date de sortier",
                            "jours": "Jours restants",
                            "statut": "Statut"
                        },
                        "statut": {
                            "entrer": "Entrer",
                            "sortier": "Sortier"
                        }
                    },
                    "historiques": {
                        "titre": "Historiques des présences",
                        "recherche": {
                            "date": "Date du au"
                        },
                    }
                },
                "utilisateurs": {
                    "titre": "Gestion des utilisateurs",
                    "nouveau": {
                        "btn_ajout": "Ajouter utilisateur",
                        "titre_ajout": "Nouveau compte utilisateur",
                        "titre_modif": "Modification des informations",
                        "inputs": {
                            "nom": "Nom d'utilisateur",
                            "email": "Email",
                            "cin": "Cin",
                            "tele": "Téléphone",
                            "genre": "Genre",
                            "photo": "Photo"
                        }
                    },
                    "recherche": {
                        "statut": {
                            "titre": "Statut",
                            "tous": "Tous",
                            "valid": "Validé",
                            "bloque": "Bloqué"
                        },
                        "date": "Date du au"
                    },
                    "filtrer": {
                        "titre": "Filtrer",
                        "placeholder": "Email, nom..."
                    },
                    "tableau": {
                        "afficher": "Afficher / masquer",
                        "cin": "Cin",
                        "nom": "Nom & prénom",
                        "email": "Email",
                        "tele": "Téléphone",
                        "genre": "Genre",
                        "parrain": "Parrain",
                        "statut": "Statut",
                        "action": "Action",
                        "sous_tableau": {
                            "role": "Les accès",
                            "action": "Action"
                        }
                    }
                }
            },
            "bouton": {
                "enregistrer" : "Enregistrer",
                "ajout": "Ajouter",
                "annuler": "Annuler",
                "valid": "Validé",
                "upload": "Importer",
                "modifier": "Modifier",
                "supprimer" : "Supprimer",
                "close": "Fermer",
                "prev": "Précédent",
                "next": "Suivant",
                "completed": "Terminé",
                'afficher_tout': 'Afficher tout',
                'recherche': 'Rechercher',
                "active": "Activer",
                "desactive": "Désactiver",
                "regler" : "Régler",
                "mise_jour" : "Mise à jour",
                "suspendre" : "Suspendre",
                "renouvler" : "Renouvler",
                "ok" : "Ok",
                "non" : "Non",
                "oui" : "Oui"
            },
            "alerts": {
                "ajout" : {
                    "message" : "vous êtes sûr de vouloir ajouter ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "Ajout avec succès"
                },
                "suppression" : {
                    "message" : "Vous êtes sûr de vouloir supprimer ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "La suppression est effectuée avec succès"
                },
                "modification" : {
                    "message" : "Vous êtes sûr de vouloir modifier ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "Les modifications ont été effectués avec succès"
                },
                "suspendre" : {
                    "message" : "Vous êtes sûr de vouloir suspendre ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "Adhérent suspendre avec succès"
                },
                "regler" : {
                    "message" : "Vous êtes sûr de vouloir régler la facture ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "Paiement effectué"
                },
                "regler_recette" : {
                    "message" : "Vous êtes sûr de vouloir régler la recette ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "Paiement effectué"
                },
                "regler_depense" : {
                    "message" : "Vous êtes sûr de vouloir régler la dépense ?",
                    "sous_message" : "",
                    "error" : "",
                    "success" : "Paiement effectué"
                },
                "presences" : {
                    "entrer" : "entré",
                    "sortier" : "sortié",
                    "success" : "Hello, Votre présence est confirmé, vous êtes {verbe} a : {date_entrer}. Nombre de jours restants avant une date précise : {jours_restant} jour(s)" 
                },
                "aucune_info" : "Aucune information à afficher.",
                "permission" : "Vous n'êtes pas autorisé à naviguer sur cette page"
            }
        },
        "validation": {
            'accepted': 'The {attribute} must be accepted.',
            'active_url': 'The {attribute} is not a valid URL.',
            'after': 'The {attribute} must be a date after {date}.',
            'after_or_equal': 'The {attribute} must be a date after or equal to {date}.',
            'alpha': 'The {attribute} may only contain letters.',
            'alpha_dash': 'The {attribute} may only contain letters, numbers, dashes and underscores.',
            'alpha_num': 'The {attribute} may only contain letters and numbers.',
            'array': 'The {attribute} must be an array.',
            'before': 'The {attribute} must be a date before {date}.',
            'before_or_equal': 'The {attribute} must be a date before or equal to {date}.',
            'between': {
                'numeric': 'The {attribute} must be between {min} and {max}.',
                'file': 'The {attribute} must be between {min} and {max} kilobytes.',
                'string': 'The {attribute} must be between {min} and {max} characters.',
                'array': 'The {attribute} must have between {min} and {max} items.',
            },
            'boolean': 'The {attribute} field must be true or false.',
            'confirmed': 'The {attribute} confirmation does not match.',
            'date': 'The {attribute} is not a valid date.',
            'date_equals': 'The {attribute} must be a date equal to {date}.',
            'date_format': 'The {attribute} does not match the format {format}.',
            'different': 'The {attribute} and {other} must be different.',
            'digits': 'The {attribute} must be :digits digits.',
            'digits_between': 'The {attribute} must be between {min} and {max} digits.',
            'dimensions': 'The {attribute} has invalid image dimensions.',
            'distinct': 'The {attribute} field has a duplicate value.',
            'email': 'The {attribute} must be a valid email address.',
            'ends_with': 'The {attribute} must end with one of the following: {values}.',
            'exists': 'The selected {attribute} is invalid.',
            'file': 'The {attribute} must be a file.',
            'filled': 'The {attribute} field must have a value.',
            'gt': {
                'numeric': 'The {attribute} must be greater than {value}.',
                'file': 'The {attribute} must be greater than {value} kilobytes.',
                'string': 'The {attribute} must be greater than {value} characters.',
                'array': 'The {attribute} must have more than {value} items.',
            },
            'gte': {
                'numeric': 'The {attribute} must be greater than or equal {value}.',
                'file': 'The {attribute} must be greater than or equal {value} kilobytes.',
                'string': 'The {attribute} must be greater than or equal {value} characters.',
                'array': 'The {attribute} must have {value} items or more.',
            },
            'image': 'The {attribute} must be an image.',
            'in': 'The selected {attribute} is invalid.',
            'in_array': 'The {attribute} field does not exist in {other}.',
            'integer': 'The {attribute} must be an integer.',
            'ip': 'The {attribute} must be a valid IP address.',
            'ipv4': 'The {attribute} must be a valid IPv4 address.',
            'ipv6': 'The {attribute} must be a valid IPv6 address.',
            'json': 'The {attribute} must be a valid JSON string.',
            'lt': {
                'numeric': 'The {attribute} must be less than {value}.',
                'file': 'The {attribute} must be less than {value} kilobytes.',
                'string': 'The {attribute} must be less than {value} characters.',
                'array': 'The {attribute} must have less than {value} items.',
            },
            'lte': {
                'numeric': 'The {attribute} must be less than or equal {value}.',
                'file': 'The {attribute} must be less than or equal {value} kilobytes.',
                'string': 'The {attribute} must be less than or equal {value} characters.',
                'array': 'The {attribute} must not have more than {value} items.',
            },
            'max': {
                'numeric': 'The {attribute} may not be greater than {max}.',
                'file': 'The {attribute} may not be greater than {max} kilobytes.',
                'string': 'The {attribute} may not be greater than {max} characters.',
                'array': 'The {attribute} may not have more than {max} items.',
            },
            'mimes': 'The {attribute} must be a file of type: {values}.',
            'mimetypes': 'The {attribute} must be a file of type: {values}.',
            'min': {
                'numeric': 'The {attribute} must be at least {min}.',
                'file': 'The {attribute} must be at least {min} kilobytes.',
                'string': 'The {attribute} must be at least {min} characters.',
                'array': 'The {attribute} must have at least {min} items.',
            },
            'not_in': 'The selected {attribute} is invalid.',
            'not_regex': 'The {attribute} format is invalid.',
            'numeric': 'The {attribute} must be a number.',
            'password': 'The password is incorrect.',
            'present': 'The {attribute} field must be present.',
            'regex': 'The {attribute} format is invalid.',
            'required': 'The {attribute} field is required.',
            'required_if': 'The {attribute} field is required when {other} is {value}.',
            'required_unless': 'The {attribute} field is required unless {other} is in {values}.',
            'required_with': 'The {attribute} field is required when {values} is present.',
            'required_with_all': 'The {attribute} field is required when {values} are present.',
            'required_without': 'The {attribute} field is required when {values} is not present.',
            'required_without_all': 'The {attribute} field is required when none of {values} are present.',
            'same': 'The {attribute} and {other} must match.',
            'size': {
                'numeric': 'The {attribute} must be :size.',
                'file': 'The {attribute} must be :size kilobytes.',
                'string': 'The {attribute} must be :size characters.',
                'array': 'The {attribute} must contain :size items.',
            },
            'starts_with': 'The {attribute} must start with one of the following: {values}.',
            'string': 'The {attribute} must be a string.',
            'timezone': 'The {attribute} must be a valid zone.',
            'unique': 'The {attribute} has already been taken.',
            'uploaded': 'The {attribute} failed to upload.',
            'url': 'The {attribute} format is invalid.',
            'uuid': 'The {attribute} must be a valid UUID.',
            'custom': {
                'attribute-name': {
                    'rule-name': 'custom-message',
                },
            },
            'attributes': {},
        }
    },
    "ar": {
        'side': {
            "menu": {
                "dashboard": "لوحة القيادة",
                "adherents": "أتباع",
                "adherent": {
                    "ajout": "إضافة",
                    "consultation": "التشاور",
                    "abonner": "مشترك"
                },
                "abonnement": "الاشتراك",
                "presences": "حضور",
                "activities": "الأنشطة",
                "paiements": "دفع"

            }
        },
        "content": {
            "pages": {
                "dashboard": {

                },
                "adherents": {

                },
                "activities": {
                    "table": {
                        "heading": "لوحة القيادة",
                        "description": "Description",
                        "price": "Price",
                        "activities": "Activités",
                        "status": "Status"
                    },
                    "activitie": {
                        "titre": "لوحة القيادة",
                        "libelle": "Title",
                        "libelle_placeholder": "Libelle...",
                        "image": "Image",
                        "image_placeholder": "Image..."
                    },
                    "pack": {
                        "titre": "لوحة القيادة",
                        "description": "Description",
                        "desc_placeholder": "Description...",
                        "price": "Price",
                        "price_placeholder": "Price...",
                        "tags_activities": {
                            "name": "أنشطة",
                            "placeholder": "ابحث عن الأنشطة"
                        }
                    }
                }
            },
            "bouton": {
                "ajout": "Add",
                "annuler": "Cancle",
                "valid": "Valid",
                "upload": "Importer",
                "modifier": "Edit",
                "close": "Fermer"
            },
            "notifications": {

            }
        },
        "validation": {
            'accepted': 'يجب قبول {attribute}.',
            'active_url': '{attribute} لا يُمثّل رابطًا صحيحًا.',
            'after': 'يجب على {attribute} أن يكون تاريخًا لاحقًا للتاريخ {date}.',
            'after_or_equal': '{attribute} يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ {date}.',
            'alpha': 'يجب أن لا يحتوي {attribute} سوى على حروف.',
            'alpha_dash': 'يجب أن لا يحتوي {attribute} سوى على حروف، أرقام ومطّات.',
            'alpha_num': 'يجب أن يحتوي {attribute} على حروفٍ وأرقامٍ فقط.',
            'array': 'يجب أن يكون {attribute} ًمصفوفة.',
            'before': 'يجب على {attribute} أن يكون تاريخًا سابقًا للتاريخ {date}.',
            'before_or_equal': '{attribute} يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ {date}.',
            'between': {
                'numeric': 'يجب أن تكون قيمة {attribute} بين {min} و {max}.',
                'file': 'يجب أن يكون حجم الملف {attribute} بين {min} و {max} كيلوبايت.',
                'string': 'يجب أن يكون عدد حروف النّص {attribute} بين {min} و {max}.',
                'array': 'يجب أن يحتوي {attribute} على عدد من العناصر بين {min} و {max}.',
            },
            'boolean': 'يجب أن تكون قيمة {attribute} إما true أو false .',
            'confirmed': 'حقل التأكيد غير مُطابق للحقل {attribute}.',
            'date': '{attribute} ليس تاريخًا صحيحًا.',
            'date_equals': 'يجب أن يكون {attribute} مطابقاً للتاريخ {date}.',
            'date_format': 'لا يتوافق {attribute} مع الشكل {format}.',
            'different': 'يجب أن يكون الحقلان {attribute} و {other} مُختلفين.',
            'digits': 'يجب أن يحتوي {attribute} على :digits رقمًا/أرقام.',
            'digits_between': 'يجب أن يحتوي {attribute} بين {min} و {max} رقمًا/أرقام .',
            'dimensions': 'الـ {attribute} يحتوي على أبعاد صورة غير صالحة.',
            'distinct': 'للحقل {attribute} قيمة مُكرّرة.',
            'email': 'يجب أن يكون {attribute} عنوان بريد إلكتروني صحيح البُنية.',
            'ends_with': 'يجب أن ينتهي {attribute} بأحد القيم التالية: {values}',
            'exists': 'القيمة المحددة {attribute} غير موجودة.',
            'file': 'الـ {attribute} يجب أن يكون ملفا.',
            'filled': '{attribute} إجباري.',
            'gt': {
                'numeric': 'يجب أن تكون قيمة {attribute} أكبر من {value}.',
                'file': 'يجب أن يكون حجم الملف {attribute} أكبر من {value} كيلوبايت.',
                'string': 'يجب أن يكون طول النّص {attribute} أكثر من {value} حروفٍ/حرفًا.',
                'array': 'يجب أن يحتوي {attribute} على أكثر من {value} عناصر/عنصر.',
            },
            'gte': {
                'numeric': 'يجب أن تكون قيمة {attribute} مساوية أو أكبر من {value}.',
                'file': 'يجب أن يكون حجم الملف {attribute} على الأقل {value} كيلوبايت.',
                'string': 'يجب أن يكون طول النص {attribute} على الأقل {value} حروفٍ/حرفًا.',
                'array': 'يجب أن يحتوي {attribute} على الأقل على {value} عُنصرًا/عناصر.',
            },
            'image': 'يجب أن يكون {attribute} صورةً.',
            'in': '{attribute} غير موجود.',
            'in_array': '{attribute} غير موجود في {other}.',
            'integer': 'يجب أن يكون {attribute} عددًا صحيحًا.',
            'ip': 'يجب أن يكون {attribute} عنوان IP صحيحًا.',
            'ipv4': 'يجب أن يكون {attribute} عنوان IPv4 صحيحًا.',
            'ipv6': 'يجب أن يكون {attribute} عنوان IPv6 صحيحًا.',
            'json': 'يجب أن يكون {attribute} نصًا من نوع JSON.',
            'lt': {
                'numeric': 'يجب أن تكون قيمة {attribute} أصغر من {value}.',
                'file': 'يجب أن يكون حجم الملف {attribute} أصغر من {value} كيلوبايت.',
                'string': 'يجب أن يكون طول النّص {attribute} أقل من {value} حروفٍ/حرفًا.',
                'array': 'يجب أن يحتوي {attribute} على أقل من {value} عناصر/عنصر.',
            },
            'lte': {
                'numeric': 'يجب أن تكون قيمة {attribute} مساوية أو أصغر من {value}.',
                'file': 'يجب أن لا يتجاوز حجم الملف {attribute} {value} كيلوبايت.',
                'string': 'يجب أن لا يتجاوز طول النّص {attribute} {value} حروفٍ/حرفًا.',
                'array': 'يجب أن لا يحتوي {attribute} على أكثر من {value} عناصر/عنصر.',
            },
            'max': {
                'numeric': 'يجب أن تكون قيمة {attribute} مساوية أو أصغر من {max}.',
                'file': 'يجب أن لا يتجاوز حجم الملف {attribute} {max} كيلوبايت.',
                'string': 'يجب أن لا يتجاوز طول النّص {attribute} {max} حروفٍ/حرفًا.',
                'array': 'يجب أن لا يحتوي {attribute} على أكثر من {max} عناصر/عنصر.',
            },
            'mimes': 'يجب أن يكون ملفًا من نوع : {values}.',
            'mimetypes': 'يجب أن يكون ملفًا من نوع : {values}.',
            'min': {
                'numeric': 'يجب أن تكون قيمة {attribute} مساوية أو أكبر من {min}.',
                'file': 'يجب أن يكون حجم الملف {attribute} على الأقل {min} كيلوبايت.',
                'string': 'يجب أن يكون طول النص {attribute} على الأقل {min} حروفٍ/حرفًا.',
                'array': 'يجب أن يحتوي {attribute} على الأقل على {min} عُنصرًا/عناصر.',
            },
            'multiple_of': '{attribute} يجب أن يكون من مضاعفات {value}',
            'not_in': 'العنصر {attribute} غير صحيح.',
            'not_regex': 'صيغة {attribute} غير صحيحة.',
            'numeric': 'يجب على {attribute} أن يكون رقمًا.',
            'password': 'كلمة المرور غير صحيحة.',
            'present': 'يجب تقديم {attribute}.',
            'regex': 'صيغة {attribute} .غير صحيحة.',
            'required': '{attribute} مطلوب.',
            'required_if': '{attribute} مطلوب في حال ما إذا كان {other} يساوي {value}.',
            'required_unless': '{attribute} مطلوب في حال ما لم يكن {other} يساوي {values}.',
            'required_with': '{attribute} مطلوب إذا توفّر {values}.',
            'required_with_all': '{attribute} مطلوب إذا توفّر {values}.',
            'required_without': '{attribute} مطلوب إذا لم يتوفّر {values}.',
            'required_without_all': '{attribute} مطلوب إذا لم يتوفّر {values}.',
            'same': 'يجب أن يتطابق {attribute} مع {other}.',
            'size': {
                'numeric': 'يجب أن تكون قيمة {attribute} مساوية لـ :size.',
                'file': 'يجب أن يكون حجم الملف {attribute} :size كيلوبايت.',
                'string': 'يجب أن يحتوي النص {attribute} على :size حروفٍ/حرفًا بالضبط.',
                'array': 'يجب أن يحتوي {attribute} على :size عنصرٍ/عناصر بالضبط.',
            },
            'starts_with': 'يجب أن يبدأ {attribute} بأحد القيم التالية: {values}',
            'string': 'يجب أن يكون {attribute} نصًا.',
            'timezone': 'يجب أن يكون {attribute} نطاقًا زمنيًا صحيحًا.',
            'unique': 'قيمة {attribute} مُستخدمة من قبل.',
            'uploaded': 'فشل في تحميل الـ {attribute}.',
            'url': 'صيغة الرابط {attribute} غير صحيحة.',
            'uuid': '{attribute} يجب أن يكون بصيغة UUID سليمة.',
            'custom': {
                'attribute-name': {
                    'rule-name': 'custom-message',
                },
            },
            'attributes': {
                'name': 'الاسم',
                'username': 'اسم المُستخدم',
                'email': 'البريد الالكتروني',
                'first_name': 'الاسم الأول',
                'last_name': 'اسم العائلة',
                'password': 'كلمة المرور',
                'password_confirmation': 'تأكيد كلمة المرور',
                'city': 'المدينة',
                'country': 'الدولة',
                'address': 'العنوان',
                'phone': 'الهاتف',
                'mobile': 'الجوال',
                'age': 'العمر',
                'sex': 'الجنس',
                'gender': 'النوع',
                'day': 'اليوم',
                'month': 'الشهر',
                'year': 'السنة',
                'hour': 'ساعة',
                'minute': 'دقيقة',
                'second': 'ثانية',
                'title': 'العنوان',
                'content': 'المُحتوى',
                'description': 'الوصف',
                'excerpt': 'المُلخص',
                'date': 'التاريخ',
                'time': 'الوقت',
                'available': 'مُتاح',
                'size': 'الحجم',
            }
        }
    },
}


/*
 "auth": {
            "failed": "These credentials do not match our records.",
            "throttle": "Too many login attempts. Please try again in {seconds} seconds."
        },
        "pagination": {
            "previous": "&laquo; Previous",
            "next": "Next &raquo;"
        },
        "passwords": {
            "reset": "Your password has been reset!",
            "sent": "We have emailed your password reset link!",
            "throttled": "Please wait before retrying.",
            "token": "This password reset token is invalid.",
            "user": "We can't find a user with that email address."
        },
        "validation": {
            "accepted": "The {attribute} must be accepted.",
            "active_url": "The {attribute} is not a valid URL.",
            "after": "The {attribute} must be a date after {date}.",
            "after_or_equal": "The {attribute} must be a date after or equal to {date}.",
            "alpha": "The {attribute} may only contain letters.",
            "alpha_dash": "The {attribute} may only contain letters, numbers, dashes and underscores.",
            "alpha_num": "The {attribute} may only contain letters and numbers.",
            "array": "The {attribute} must be an array.",
            "before": "The {attribute} must be a date before {date}.",
            "before_or_equal": "The {attribute} must be a date before or equal to {date}.",
            "between": {
                "numeric": "The {attribute} must be between {min} and {max}.",
                "file": "The {attribute} must be between {min} and {max} kilobytes.",
                "string": "The {attribute} must be between {min} and {max} characters.",
                "array": "The {attribute} must have between {min} and {max} items."
            },
            "boolean": "The {attribute} field must be true or false.",
            "confirmed": "The {attribute} confirmation does not match.",
            "date": "The {attribute} is not a valid date.",
            "date_equals": "The {attribute} must be a date equal to {date}.",
            "date_format": "The {attribute} does not match the format {format}.",
            "different": "The {attribute} and {other} must be different.",
            "digits": "The {attribute} must be {digits} digits.",
            "digits_between": "The {attribute} must be between {min} and {max} digits.",
            "dimensions": "The {attribute} has invalid image dimensions.",
            "distinct": "The {attribute} field has a duplicate value.",
            "email": "The {attribute} must be a valid email address.",
            "ends_with": "The {attribute} must end with one of the following: {values}.",
            "exists": "The selected {attribute} is invalid.",
            "file": "The {attribute} must be a file.",
            "filled": "The {attribute} field must have a value.",
            "gt": {
                "numeric": "The {attribute} must be greater than {value}.",
                "file": "The {attribute} must be greater than {value} kilobytes.",
                "string": "The {attribute} must be greater than {value} characters.",
                "array": "The {attribute} must have more than {value} items."
            },
            "gte": {
                "numeric": "The {attribute} must be greater than or equal {value}.",
                "file": "The {attribute} must be greater than or equal {value} kilobytes.",
                "string": "The {attribute} must be greater than or equal {value} characters.",
                "array": "The {attribute} must have {value} items or more."
            },
            "image": "The {attribute} must be an image.",
            "in": "The selected {attribute} is invalid.",
            "in_array": "The {attribute} field does not exist in {other}.",
            "integer": "The {attribute} must be an integer.",
            "ip": "The {attribute} must be a valid IP address.",
            "ipv4": "The {attribute} must be a valid IPv4 address.",
            "ipv6": "The {attribute} must be a valid IPv6 address.",
            "json": "The {attribute} must be a valid JSON string.",
            "lt": {
                "numeric": "The {attribute} must be less than {value}.",
                "file": "The {attribute} must be less than {value} kilobytes.",
                "string": "The {attribute} must be less than {value} characters.",
                "array": "The {attribute} must have less than {value} items."
            },
            "lte": {
                "numeric": "The {attribute} must be less than or equal {value}.",
                "file": "The {attribute} must be less than or equal {value} kilobytes.",
                "string": "The {attribute} must be less than or equal {value} characters.",
                "array": "The {attribute} must not have more than {value} items."
            },
            "max": {
                "numeric": "The {attribute} may not be greater than {max}.",
                "file": "The {attribute} may not be greater than {max} kilobytes.",
                "string": "The {attribute} may not be greater than {max} characters.",
                "array": "The {attribute} may not have more than {max} items."
            },
            "mimes": "The {attribute} must be a file of type: {values}.",
            "mimetypes": "The {attribute} must be a file of type: {values}.",
            "min": {
                "numeric": "The {attribute} must be at least {min}.",
                "file": "The {attribute} must be at least {min} kilobytes.",
                "string": "The {attribute} must be at least {min} characters.",
                "array": "The {attribute} must have at least {min} items."
            },
            "not_in": "The selected {attribute} is invalid.",
            "not_regex": "The {attribute} format is invalid.",
            "numeric": "The {attribute} must be a number.",
            "password": "The password is incorrect.",
            "present": "The {attribute} field must be present.",
            "regex": "The {attribute} format is invalid.",
            "required": "The {attribute} field is required.",
            "required_if": "The {attribute} field is required when {other} is {value}.",
            "required_unless": "The {attribute} field is required unless {other} is in {values}.",
            "required_with": "The {attribute} field is required when {values} is present.",
            "required_with_all": "The {attribute} field is required when {values} are present.",
            "required_without": "The {attribute} field is required when {values} is not present.",
            "required_without_all": "The {attribute} field is required when none of {values} are present.",
            "same": "The {attribute} and {other} must match.",
            "size": {
                "numeric": "The {attribute} must be {size}.",
                "file": "The {attribute} must be {size} kilobytes.",
                "string": "The {attribute} must be {size} characters.",
                "array": "The {attribute} must contain {size} items."
            },
            "starts_with": "The {attribute} must start with one of the following: {values}.",
            "string": "The {attribute} must be a string.",
            "timezone": "The {attribute} must be a valid zone.",
            "unique": "The {attribute} has already been taken.",
            "uploaded": "The {attribute} failed to upload.",
            "url": "The {attribute} format is invalid.",
            "uuid": "The {attribute} must be a valid UUID.",
            "custom": {
                "attribute-name": {
                    "rule-name": "custom-message"
                }
            },
            "attributes": []
        },*/
