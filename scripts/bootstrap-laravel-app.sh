#!/usr/bin/env bash
set -euo pipefail

# Bootstraps this repository into a real Laravel 12 + Filament 4 application.
# It creates a temporary Laravel skeleton, copies it into this repo,
# then reapplies this repository's domain customizations.

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
TMP_DIR="${ROOT_DIR}/.tmp-laravel-skeleton"
BACKUP_DIR="${ROOT_DIR}/.tmp-custom-backup"

cleanup() {
  rm -rf "$TMP_DIR" "$BACKUP_DIR"
}
trap cleanup EXIT

if [[ -f "${ROOT_DIR}/artisan" ]]; then
  echo "artisan already exists. This repo already looks like a Laravel app."
  exit 0
fi

command -v composer >/dev/null 2>&1 || {
  echo "composer is required but not installed."
  exit 1
}

mkdir -p "$BACKUP_DIR"

# Backup custom files to restore after copying Laravel skeleton.
for path in \
  composer.json \
  README.md \
  .gitignore \
  app/Enums \
  app/Filament \
  app/Models \
  app/Policies \
  database/migrations \
  database/seeders \
  routes/web.php
  do
    src="${ROOT_DIR}/${path}"
    if [[ -e "$src" ]]; then
      mkdir -p "${BACKUP_DIR}/$(dirname "$path")"
      cp -a "$src" "${BACKUP_DIR}/${path}"
    fi
  done

echo "Creating fresh Laravel 12 skeleton in temporary directory..."
composer create-project laravel/laravel "$TMP_DIR" "^12.0"

echo "Copying Laravel skeleton into repository..."
rsync -a --delete --exclude='.git' --exclude='vendor' --exclude='node_modules' "$TMP_DIR"/ "$ROOT_DIR"/

echo "Reapplying custom hour-tracker files..."
rsync -a "$BACKUP_DIR"/ "$ROOT_DIR"/

cat <<'MSG'

Bootstrap complete.

Next steps:
  cp .env.example .env
  composer install
  php artisan key:generate
  php artisan migrate --seed
  php artisan make:filament-user
  php artisan serve

Open: http://127.0.0.1:8000/admin
MSG
