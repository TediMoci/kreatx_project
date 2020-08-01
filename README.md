
## Before you start

The application used a mysql connection and a database called kreatx. When you open the project, first open the terminal and run the following commands:

## php artisan migrate:fresh

This will first create the tables in the database.

## php artisan db:seed

This will create:
1) User 'admin' with:
email: admin@kreatx.com
password: 12345678

2) 17 departments

## php artisan tinker
## factory(App\User::class, 20)->create()

creates 20 new non-administrator users and assigns them to departments (departments must have already been created). Their passwords are "12345678"

## factory(App\Message::class, 200)->create()

creates 200 chat messages among the created users

## You can now launch the application and either log in with an existing user and register a new account