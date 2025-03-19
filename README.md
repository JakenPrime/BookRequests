
## About Book Requests

Book Requests is a simple app for creating and managing book requests

To set up for development, make sure composer, node and laravel are installed

clone repo

run npm i

run php "artisan migrate"

you can run using "php artisan serve"

* the app uses Active directory to authenticate and create users but a dev user can be added with the seeder using "php artisan db:seed" after migrating and adding a button on the login page that routes to a dev endpoint seen in the auth routes.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
