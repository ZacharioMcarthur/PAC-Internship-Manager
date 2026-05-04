# Architecture PAC-Intership-Management

## Vue globale
- `backend` (Laravel 12): API et persistance
- `mobile` (Flutter): client terrain

## Flux principal
1. Authentification utilisateur via `/api/auth/login`.
2. Le mobile stocke le token et appelle les routes protégées.
3. Le backend applique validation + règles métiers.
4. Les données sont stockées dans MySQL via Eloquent.

## Modules backend
- `AuthController`: login/register/logout/me.
- `PresenceController`: check-in/check-out + validité GPS.
- `ActiviteController`: création et validation des activités.
- `DashboardController`: indicateurs stagiaire et encadrement.

## Modules mobile
- `LoginScreen`: session.
- `HomeScreen`: onglets présences et activités.
- `AuthService`, `PresenceService`, `ActivityService`: communication API.
