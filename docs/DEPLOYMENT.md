# Déploiement PAC

## Backend Laravel
1. `cd backend`
2. `composer install --no-dev --optimize-autoloader`
3. Configurer `.env` (APP, DB, CORS)
4. `php artisan key:generate`
5. `php artisan migrate --force`
6. `php artisan config:cache`
7. Démarrer serveur web (Nginx/Apache) sur `public/`

## Mobile Flutter
1. `cd mobile`
2. `flutter pub get`
3. Configurer `lib/config/app_config.dart` (URL API prod)
4. Android:
   - `flutter build apk --release`
   - ou `flutter build appbundle --release`
5. iOS (si utilisé):
   - `flutter build ios --release`

## Vérifications post-déploiement
- Login API réussi.
- Route protégée `/api/auth/me` accessible avec token.
- Check-in/check-out et création activité fonctionnels.
