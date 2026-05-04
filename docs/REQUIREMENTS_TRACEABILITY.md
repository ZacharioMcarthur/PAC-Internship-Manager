# Matrice de traçabilité des exigences PAC

## Statut source documentaire
Le PDF demandé (`Conception et mise en place d'une plateforme de capitalisation du savoir et de gestion des talents.pdf`) n'a pas été trouvé dans le projet au moment de cette implémentation.

## Source provisoire utilisée
- Objectifs fonctionnels du `README.md` racine.
- Besoins standards d'une plateforme de suivi de stage (présence GPS, activités, dashboard, rôles).

## Matrice
| ID | Exigence | Implémentation | Statut | Preuve technique | Tests à faire |
|---|---|---|---|---|---|
| PAC-REQ-001 | Authentifier les utilisateurs | Sanctum + endpoints auth | Fait | `backend/app/Http/Controllers/Api/AuthController.php` | login/register/logout |
| PAC-REQ-002 | Gérer rôles stagiaire/maitre/admin | champ `role` user + contrôles validation activité | Fait partiel | `backend/app/Models/User.php`, `ActiviteController` | contrôle d'accès rôles |
| PAC-REQ-003 | Pointer l'arrivée et le départ | endpoints check-in/check-out | Fait | `PresenceController`, `routes/api.php` | test GPS et doublons |
| PAC-REQ-004 | Valider présence via GPS | calcul de distance Haversine + rayon PAC | Fait | `PresenceController::isInsidePac()` | test in/out radius |
| PAC-REQ-005 | Saisir activités journalières | endpoint création activité | Fait | `ActiviteController::store()` | validation champs |
| PAC-REQ-006 | Valider/rejeter activités | endpoint approve pour maitre/admin | Fait | `ActiviteController::approve()` | droits d'accès |
| PAC-REQ-007 | Tableau de bord synthétique | endpoint dashboard summary | Fait | `DashboardController::summary()` | cohérence compteurs |
| PAC-REQ-008 | Interface mobile utilisable | login + home + présence + activités | Fait | `mobile/lib/screens/*` | parcours E2E mobile |
| PAC-REQ-009 | Export rapports | non implémenté | À faire | - | format + génération |
| PAC-REQ-010 | Gestion départements/affectations | non implémenté | À faire | - | modélisation + API |

## Actions restantes prioritaires
1. Intégrer le PDF officiel dès disponibilité.
2. Réconcilier cette matrice avec les exigences exactes du document.
3. Ajouter tests backend (Feature) et tests widget Flutter.
