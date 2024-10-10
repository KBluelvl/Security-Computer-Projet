# Computer project

## Authors
This project was made Essomba Florian 58137 and Lejeune Mathéo 58738

## Helper
Zeki OZKARA 58143

## Orders and installation required
After cloning the project, perform the following manipulations :

#### XAMPP
- Open XAMPP
- Start apache
- Start MySQL

#### Composer
- Open terminal

Into this terminal,execute the following commands :
- ```cd copies```
- ``` composer update ```

#### Database
- Copy .env.exemple into a new file .env

#### Npm and server
Into a terminal execute the following commands :
- ```php artisan key:generate```
- ```npm install```
- ```php artisan migrate```

#### Seeder
Fill the tables :
- ```php artisan db:seed --class=RolesTableSeeder```
- ```php artisan db:seed --class=CreateAdminUsers```

#### Run the server
- ```php artisan serve```

## Open a new terminal 

In this terminal execute :
- ```npm run dev```
