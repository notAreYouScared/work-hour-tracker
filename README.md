# Work Hour Tracker (Laravel + Filament)

This repository contains a Laravel/Filament starter implementation for a weekly employee hour tracking workflow with five roles:

1. **employee** – submits weekly hours.
2. **manager** – approves/denies direct employee hour sheets.
3. **area manager** – oversees managers/employees in their area.
4. **coordinator** – sees approved sheets and lifetime totals.
5. **root admin** – manages users, role assignments, skill trade sections, and manager/employee visibility.

## Implemented domain model

- Immutable **skill trade** assigned at employee creation (`skill_trade_id` field disabled on user edit in Filament).
- Configurable per-trade **hour sections** and **hour lines** used to build weekly sheets similar to your electrician example.
- **Weekly sheet entries** store day-by-day values (`monday`…`sunday`) with `week_total` and `lifetime_total` values.
- Approval lifecycle: `draft` → `submitted` → `approved` / `denied`.

## Skill trades seeded

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

## Key files

- `database/migrations/*` – schema for users, hierarchy, skill trades, sections, lines, and weekly sheets.
- `database/seeders/SkillTradeSeeder.php` – default trade list.
- `app/Filament/Resources/UserResource.php` – root admin user management and immutable skill trade behavior.
- `app/Filament/Resources/WeeklySheetResource.php` – manager review actions (approve/deny), status tracking, and weekly totals.
- `app/Policies/WeeklySheetPolicy.php` – role-based visibility rules.

## Notes for running locally

Network access to Packagist/GitHub was blocked in this environment, so dependencies could not be installed here. To run locally:

```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan make:filament-user
php artisan serve
```

Then open `/admin` for Filament.
