# PAC Backend (Laravel)

## Rôle
API REST de la plateforme PAC Internship:
- authentification Sanctum
- gestion des présences (check-in/check-out GPS)
- gestion des activités (soumission/validation)
- dashboard de synthèse

## Démarrage
1. `composer install`
2. Copier `.env.example` vers `.env`
3. Configurer la DB
4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan serve`

## Endpoints principaux
- `POST /api/auth/register`
- `POST /api/auth/login`
- `GET /api/auth/me`
- `POST /api/auth/logout`
- `GET /api/presences`
- `POST /api/presences/check-in`
- `POST /api/presences/check-out`
- `GET /api/activites`
- `POST /api/activites`
- `POST /api/activites/{id}/approve`
- `GET /api/dashboard/summary`

## Structure clé
- `app/Http/Controllers/Api/*`: logique API
- `app/Models/*`: modèles métiers
- `routes/api.php`: route map
- `database/migrations/*`: schéma de données
