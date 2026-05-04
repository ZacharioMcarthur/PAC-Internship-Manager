# PAC Mobile (Flutter)

## Rôle
Application stagiaire/encadrement pour:
- se connecter à l'API Laravel
- faire le pointage arrivée/départ avec GPS
- saisir les activités journalières
- consulter l'historique

## Configuration
1. `flutter pub get`
2. Vérifier la base URL API dans `lib/config/app_config.dart`
3. `flutter run`

## Structure
- `lib/main.dart`: bootstrap + routage initial (session/token)
- `lib/screens/login_screen.dart`: écran de connexion
- `lib/screens/home_screen.dart`: écrans présence/activités
- `lib/services/*`: appels API + session
- `lib/models/*`: objets métier
