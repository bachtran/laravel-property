## Intro
This is an application built with Laravel that provide a number of API endpoints to the datasets in the CSV files
in `storage/app/`:

- `/api/properties` POST json object `{"guid": "1234", "suburb": "Sydney", "state": "NSW", "country": "Australia"}` 
to create new property 
- `/api/properties` GET to get list of all properties
- `/api/properties<property_id>/analytics` GET to get analytics of given property
- `/api/properties/<property_id>/analytics/<analytic_id>` POST to add or update an analytic of given property
- `/api/analytics/summary/suburb/<suburb_name>` GET to get analytic summary of given suburb
- `/api/analytics/summary/state/<state_name>` GET to get analytic summary of given state
- `/api/analytics/summary/country/<country_name>` GET to get analytic summary of given country

## Installation

`git clone https://github.com/bachtran/laravel-property.git` to retrieve the source code

`cd laravel-property`

`composer install` to install dependencies

`cp .env.example .env` and change `DB_CONNECTION` to `sqlite` and `DB_DATABASE` to `property.sqlite`

`touch database/property.sqlite` to create the main database in empty state

`php artisan migrate:fresh --seed` to populate the database

`touch database/test.sqlite` to create the test database in empty state

`php artisan test` to run tests

`php artisan serve` to serve the application with the builtin server
