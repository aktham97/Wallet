git clone https://aliabdm@bitbucket.org/aliabdm/wallet.git

composer install 

copy .env.example to .env and configure database credential

php artisan migrate

php artisan db:seed

php artisan serve


admin-email= admin@gmail.com
admin-password = admin123

