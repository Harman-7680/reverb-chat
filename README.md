#  Reverb Chat Package (Laravel)

A simple **real-time user-to-user chat package** for Laravel powered by **Laravel Reverb WebSockets**.  
It enables instant messaging with private channels and live updates.

---

##  Features

- ⚡ Real-time messaging using Laravel Reverb
-  Private user-to-user chat
-  Simple Blade UI included
-  Instant message delivery
-  Database-based message storage
-  Secure private channels
-  Auto route & event registration

---

##  Installation

### 1. Install via Composer

```bash
composer require harman-7680/reverb-chat
```
### 2. Run Package Installer

php artisan reverb-chat:install

### 3. Publish Config (optional)

php artisan vendor:publish --provider="Harman\ReverbChat\Providers\ReverbChatServiceProvider"

### 4. Run Migrations

php artisan migrate

  Laravel Reverb Setup

# Install Reverb (if not already installed)

composer require laravel/reverb
php artisan reverb:install

# Start Reverb Server

php artisan reverb:start

    Troubleshooting
    Channel file not found

Problem: Users expect routes/channels.php but it’s missing.
Solution: Add manually: 

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

# Reverb not working / no real-time updates

BROADCAST_DRIVER=reverb
php artisan queue:work
php artisan reverb:start

# Vite / Tailwind error
Cannot find module '@tailwindcss/forms'

Fix
npm install @tailwindcss/forms
npm run dev

