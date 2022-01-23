# Filling Station Management System

## Install

1) Run in your terminal:

``` bash
git clone https://github.com/MusheAbdulHakim/Filling-Station-Management-System.git fsms
```

2) Set your database information in your .env file (use the .env.example as an example);

3) Run in your fsms folder:
``` bash
composer install
php artisan key:generate
php artisan migrate --seed

```

## Usage 

1. Your admin panel is available at http://localhost/fsms/public/admin or start the local server by running:
```
php artisan serve
```
if you run the command, follow the server url in the terminal:
```http://127.0.0.1:8000/admin/```

2. Login with email ```admin@example.com```, password ```admin```
3. [optional] You can register a different account, to check out the process and see your gravatar inside the admin panel. 
4. By default, registration is open only in your local environment. Check out ```config/backpack/base.php``` to change this and other preferences.

Note: Depending on your configuration you may need to define a site within NGINX or Apache; Your URL domain may change from localhost to what you have defined.



## Security

If you discover any security related issues, please email musheabdulhakim99@gmail.com instead of using the issue tracker.


## Credits

- [Laravel Backpack][link-backpack]
- [All Contributors][link-contributors]



[link-backpack]: https://backpackforlaravel.com/
[link-contributors]: ../../contributors

