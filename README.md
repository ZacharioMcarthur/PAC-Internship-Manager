# PAC-Internship-Manager

## Plateforme de Gestion des Stagiaires - Port Autonome de Cotonou
Développement Full-Stack – Laravel / Flutter
Année Académique 2025–2026

---

## Nom du Projet
# PAC-Internship-Manager

PAC-Internship-Manager est une solution intégrée conçue pour optimiser le suivi des stagiaires au sein du Port Autonome de Cotonou. Elle combine un backend robuste pour l'administration et une application mobile pour les stagiaires, permettant un suivi en temps réel des présences par géolocalisation et des activités quotidiennes.

---

## Développeur
- NASCIMENTO Zachario

---

## Objectifs du Projet
- Digitaliser le processus de suivi des stagiaires du PAC.
- Assurer l'intégrité des pointages via la validation GPS.
- Centraliser les rapports d'activités hebdomadaires et mensuels.
- Offrir un tableau de bord administratif pour les maîtres de stage.
- Faciliter l'interopérabilité entre le terrain (Mobile) et l'administration (Web).

---

## Architecture du Système
Le projet utilise une architecture découplée (API-First) :
- Backend : API REST développée avec Laravel.
- Mobile : Application multiplateforme développée avec Flutter.

---

## Fonctionnalités Principales

### Gestion des Utilisateurs
- Authentification sécurisée via Laravel Sanctum.
- Attribution des rôles (Stagiaire, Maître de stage, Administrateur).
- Gestion des profils utilisateurs.

### Suivi des Présences (Mobile)
- Pointage d'arrivée et de départ.
- Récupération des coordonnées GPS en temps réel.
- Validation automatique de la présence basée sur le périmètre du Port.

### Journal de Bord
- Saisie des activités journalières par le stagiaire.
- Consultation et validation des activités par le maître de stage.
- Historique complet des tâches effectuées.

### Administration (Web)
- Dashboard récapitulatif des présences.
- Gestion des départements et des affectations.
- Exportation des rapports de fin de stage.

---

## Technologies Utilisées

### Back-End
- Laravel 12.x
- PHP 8.2
- MySQL
- Laravel Sanctum (Authentification API)

### Mobile
- Flutter SDK
- Dart
- Geolocator (Positionnement GPS)
- Shared Preferences (Persistance locale)
- HTTP Client

### Outils & Sécurité
- Git / GitHub (ZachMcArthur)
- VS Code
- Protection CSRF et CORS
- Hashage des mots de passe (Bcrypt)

---

## Structure du Projet

PAC-Internship-Manager/
├── backend/                  (API Laravel)
│   ├── app/Models/           (User, Presence, Activite)
│   ├── app/Http/Controllers/ (AuthController, API Controllers)
│   ├── database/migrations/  (Structure SQL)
│   └── routes/api.php        (Points d'entrée de l'API)
└── mobile/                   (Application Flutter)
    ├── lib/screens/          (Interfaces UI)
    ├── lib/services/         (Appels API)
    └── lib/models/           (Objets Dart)

---

## Installation & Configuration

### Prérequis
- PHP >= 8.2 & Composer
- Flutter SDK
- MySQL (XAMPP)

### Configuration Backend
1. Entrer dans le dossier : cd backend
2. Installer les dépendances : composer install
3. Configurer le .env (DB_DATABASE=pac_internship_db)
4. Générer la clé : php artisan key:generate
5. Lancer les migrations : php artisan migrate
6. Lancer le serveur : php artisan serve --host=0.0.0.0

### Configuration Mobile
1. Entrer dans le dossier : cd mobile
2. Récupérer les packages : flutter pub get
3. Configurer l'URL de l'API dans les services (10.0.2.2 pour l'émulateur)
4. Lancer l'application : flutter run

---

## Sécurité Implémentée
- Authentification par jetons (Bearer Tokens) avec Sanctum.
- Validation stricte des données entrantes.
- Restriction d'accès aux routes sensibles via Middleware.
- Sécurisation des données de localisation.

---

## Support
Développement réalisé par NASCIMENTO Zachario dans le cadre du projet de stage au Port Autonome de Cotonou.