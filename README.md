# Work Hour Tracker (Laravel + Filament)

This repository contains a Laravel + Filament implementation for weekly employee hour tracking with **5 roles**:

1. Employee
2. Manager
3. Area Manager
4. Coordinator
5. Root Admin

## Functional coverage

- Role model and permissions scaffolded with `spatie/laravel-permission`.
- Employee users are created with an immutable `skill_trade` assignment.
- Supported skill trades:
  - Die Maker
  - Metal Model Maker
  - Wood Model Maker
  - Experimental Auto
  - Auto Inspector
  - Tool & Die Welder
  - Electrician
  - Machine Repair
  - Millwright
  - Pipefitter
- Weekly sheet data model includes daily columns (`monday` ... `sunday`), per-row weekly total, and per-row lifetime total.
- Manager approval lifecycle: draft -> submitted -> approved/denied.
- Coordinator visibility policy allows viewing sheets once approved.
- Root admin can manage users, roles, and hour template sections.
- Hour template model supports section/category structures matching apprenticeship report layouts.

## Key files

- Roles and trades enums: `app/Enums`.
- Domain models: `app/Models`.
- Filament admin resources:
  - Users: `app/Filament/Resources/UserResource.php`
  - Hour templates: `app/Filament/Resources/HourSectionResource.php`
  - Weekly sheets + approval actions: `app/Filament/Resources/WeeklySheetResource.php`
- Migrations: `database/migrations`.
- Seed data (roles + electrician template seed): `database/seeders/RoleAndTemplateSeeder.php`.

## Setup

> Network access to package registries is required.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Then open `/admin` and sign in with:

- `root@tracker.test` / `password`

## Notes

- Because this environment cannot reach Packagist/GitHub, dependencies could not be installed here.
- The codebase is scaffolded to Laravel 11 + Filament 3 conventions and is ready to install in a network-enabled environment.
