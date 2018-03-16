# Restful API with Symfony 4 #

## Step 1 ##
Clone the project ```restful-api-symfony-4-dot-0``` repository (for example in **rest-api** folder)
https://github.com/elyamanukyan/restful-api-symfony-4-dot-0.git
## Step 2 ##
* Make sure you're using PHP 7.1 or higher 
* Make sure you have Composer installed and it is the latest version. 
```
composer self-update
```
* Go to **rest-api** and run 
```
composer install
```
## Step 3 ##
* inside your .env file change text 
```
DATABASE_URL=mysql://your_username:your_password@localhost:3306/rest-api
```
* Run
```
bin/console doctrine:database:create
bin/console doctrine:schema:update --force
```
## Step 4 ##
* To start the server, run 
```
bin/console server:run
```
* Install Postman(Or other toolchain for API development and testing)
## Configuration. Now you have "API with Symfony 4" installed on you local machine. Enjoy!!!
©Elya
