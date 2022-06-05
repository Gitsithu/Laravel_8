# Business logic
B2C -> Business to Consumer 

# Project Idea
to build an api for selling lacquerwares

# API
The first thing that you need to have to run this program is composer.

# Composer download
You can download composersetup in https://getcomposer.org/.

# Project Setup
The second is you need to download this project and open it in your command line (CMD)or(Terminal)

After that you also need to go into the project folder path in your cmd.

And you should write "composer update" in your cmd.

# Database Name
Then, you need to create database by the name which also must be set to "database name" in .env file.

# Datbase User Name and Password
If you have database password and database user name, you also need to fill them in .env file

# Artisan Command

Next, you must type the following command 

1." php artisan optimize:clear "
2." php artisan key:generate "
3." php artisan migrate --seed "

After all, the last command that you need to type is 

" php artisan serve "

# Account email and password
I made the given test account for two roles.

For admin 
user email= "admin@gmail.com"
password ="aaaaaaaa" 

For customer view
user email= "customer@gmail.com"
password ="aaaaaaaa" 

# Run register

You need to call the following url in POSTMAN or other tools.

# URL -> localhost:yourport/api/register
# Method -> post
# form-data -> name , email, password, phone, address

a promo_code will be automactically generated after creating account.


# Run login

You need to call the following url in POSTMAN or other tools.

# URL -> localhost:yourport/api/login
# Method -> post
# form-data -> email, password


# Run addToCart

You need to call the following url in POSTMAN or other tools.

# URL -> localhost:yourport/api/addToCart
# Method -> post
# form-data -> product_id , qty, user_id



# Run checkout

You need to call the following url in POSTMAN or other tools.

# URL -> localhost:yourport/api/addToCart
# Method -> post
# form-data -> user_id , payment_ss, transaction_id, promo_code (optional)

this (user_id) must be the same from addToCart. 


# Run logout

You need to call the following url in POSTMAN or other tools.

# URL -> localhost:yourport/api/logout
# Method -> postddToCart. 

