# Contrat API PAC

## Base URL
- `http://<host>:8000/api`

## Authentification
- Type: Bearer token Sanctum
- Header: `Authorization: Bearer <token>`

## Réponses
Format recommandé:
- `success` (bool)
- `message` (string)
- `data` (object|array|null)
- `errors` (objet de validation, optionnel)

## Endpoints implémentés
- `POST /auth/register`
- `POST /auth/login`
- `GET /auth/me`
- `POST /auth/logout`
- `GET /dashboard/summary`
- `GET /presences`
- `POST /presences/check-in`
- `POST /presences/check-out`
- `GET /activites`
- `POST /activites`
- `POST /activites/{id}/approve`

## Règles métiers actuelles
- Présence validée selon la distance GPS autour du PAC.
- Validation d'activité réservée aux rôles `maitre` et `admin`.
