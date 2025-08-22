# Project Management System
A simple project using Laravel + Inertia + VueJS.

## Running the project
Execute that on you terminal (the `.env.example` will automatically be copied to `.env`).
```bash
$ docker compose up
```
The application should be running on your [local port 80](http://localhost).
The database is automatically seeded on startup.

## Test User Credentials
Email: `test@example.com`  
Password: `testpassword`

## Running Automated Tests
There are also some simple automated tests. Use this command on your terminal to run them:
```bash
$ docker compose run --rm php php artisan test
```

## Architecture
- The base setup was made using [Laravel Starter Kit with Vue and Intertia](https://laravel.com/docs/12.x/starter-kits#vue-customization)
- [FrankenPHP](https://frankenphp.dev/): An easy to use fast PHP runtime written in Go and based on Caddy.
- The starter kit also brought some components from [reka-ui](https://reka-ui.com/)

## Steps Remaining for Production Readiness
- Optmize UX listing tasks as cards instead table
- Implement caching layers
- Setup eslint to enhance code organizing
- Prepare project for k8s environment
