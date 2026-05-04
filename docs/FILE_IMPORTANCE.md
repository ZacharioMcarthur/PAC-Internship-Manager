# Utilité des fichiers (PAC)

## Backend
- `backend/routes/api.php`: contrat d'entrée de l'API.
- `backend/bootstrap/app.php`: enregistrement du routeur API Laravel 12.
- `backend/app/Http/Controllers/Api/AuthController.php`: sécurité et tokens.
- `backend/app/Http/Controllers/Api/PresenceController.php`: pointage géolocalisé.
- `backend/app/Http/Controllers/Api/ActiviteController.php`: journal d'activités.
- `backend/app/Http/Controllers/Api/DashboardController.php`: statistiques synthétiques.
- `backend/app/Models/User.php`: identité et rôles.
- `backend/app/Models/Presence.php`: enregistrement des présences.
- `backend/app/Models/Activite.php`: cycle de validation des activités.
- `backend/database/migrations/*`: schéma de référence.

## Mobile
- `mobile/lib/main.dart`: point d'entrée + redirection session.
- `mobile/lib/config/app_config.dart`: URL API.
- `mobile/lib/screens/login_screen.dart`: authentification.
- `mobile/lib/screens/home_screen.dart`: parcours utilisateur principal.
- `mobile/lib/services/api_client.dart`: client HTTP unifié.
- `mobile/lib/services/auth_service.dart`: token et session.
- `mobile/lib/services/presence_service.dart`: GPS + endpoints présence.
- `mobile/lib/services/activity_service.dart`: endpoints activités.

## Pourquoi ces fichiers sont critiques
- Ils forment la chaîne complète mobile -> API -> base.
- Ils portent les règles métier à plus fort impact utilisateur.
