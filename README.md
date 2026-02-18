# Work Hour Tracker (Laravel + Filament)

This repository contains the initial application blueprint for an employee weekly hour tracking web app using **Laravel** and **Filament**.

> Note: external package installation was blocked in this environment (HTTP 403 to package sources), so this commit provides the complete domain structure and Filament resources ready to run once dependencies are installed in a network-enabled environment.

## Roles

The app uses five roles:

1. `employee` – submit weekly hours.
2. `manager` – approve or deny weekly submissions.
3. `area_manager` – oversight across managers/employees.
4. `coordinator` – read approved sheets and lifetime totals.
5. `root_admin` – manage users, managers-to-employees visibility, trades, and hour sections/templates.

## Skill trades

Employees are assigned one immutable skill trade from:

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

## Data model summary

- `users`: common user account.
- `trades`: skill trade definitions.
- `employee_profiles`: immutable user-trade assignment.
- `manager_employee`: manager-to-employee visibility mapping.
- `hour_templates`: trade-specific row templates/sections used on weekly sheets.
- `weekly_sheets`: one sheet per employee/week with approval metadata.
- `weekly_sheet_entries`: daily hours per template row + weekly total.

## Runtime setup (network-enabled environment)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan make:filament-user
php artisan serve
```

## Filament resources included

- `UserResource`
- `TradeResource`
- `HourTemplateResource`
- `WeeklySheetResource`

These enforce role-aware visibility and workflows for submission and approval.
