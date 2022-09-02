

## Requirements

- PHP 8+
- Laravel 9
- SQLite Driver
- NPM installed


## Installation
- Clone the repository
- Composer update
- run: npm run dev
- Rename .env.example to .env
- run: php artisan key:generate
- run: php artisan migrate:fresh --seed
- if any error throw in the console then check your sqlite driver working or not. if working then try to run: touch database/database.sqlite and then php artisan migrate --seed
- run: php artisan:optimize
- run: php artisan cache:clear
- run: php artisan serve
- Go to the browser with the url
- That's it! Application has been started.

## Credential
- User name= admin@email.com
- Password= password

## Using the application
- After you enter the application you should see login page.
- Login to the application with given credential above.
- After login to the system you should see the dashboard with option to file upload form.
- Upload input.csv file and you will get the result.

## Note
In the task description the output result now is not right. Due to big change in JPY currency with EUR one result is not same as given output result.
