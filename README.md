# PAC-Internship-Management

Plateforme API-first de gestion des stagiaires (backend Laravel + application Flutter).

## État actuel
- Backend API Sanctum opérationnel pour:
  - authentification (`register/login/me/logout`)
  - suivi des présences (check-in/check-out GPS)
  - gestion des activités (soumission + validation)
  - dashboard synthétique (stagiaire/encadrement)
- Mobile Flutter structuré en `screens`, `services`, `models`.

## Structure
- `backend/` : API Laravel 12
- `mobile/` : application Flutter
- `docs/` : architecture, endpoints, contrat API, utilité des fichiers, déploiement, traçabilité exigences

## Lancement rapide
### Backend
1. `cd backend`
2. `composer install`
3. Copier `.env.example` vers `.env` et configurer DB
4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan serve`

### Mobile
1. `cd mobile`
2. `flutter pub get`
3. Vérifier la base URL API (`lib/config/app_config.dart`)
4. `flutter run`

## Documentation détaillée
- `docs/ARCHITECTURE.md`
- `docs/FILE_IMPORTANCE.md`
- `docs/API_CONTRACT.md`
- `docs/DEPLOYMENT.md`
- `docs/REQUIREMENTS_TRACEABILITY.md`