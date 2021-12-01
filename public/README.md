## Installation Guide

#### Clone the repo
    $ git clone https://github.com/msafrin3/laramin8.git myApp

#### Configure `.env` file.

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=myDB
    DB_USERNAME=root
    DB_PASSWORD="password"

#### Install Packages

    $ composer install
    $ php artisan key:generate

#### Clear cache using `cache.sh` file given if needed.

    $ sh cache.sh

#### Run Migration

    $ php artisan migrate

## What's new on Laramin 8

  

<b>Laravel Admin (<i>Laramin</i>)</b> is an administrative interface builder for [Laravel](https://laravel.com/) which can help you build CRUID backends with just a few lines of code. It contain few interactive plugins to improve users experience and start developing their logics without concern about the administrative section because Laramin will handle it. Laramin takes the pain out of development by easing common tasks use in many web projects and readymade basic administrative management, such as:

  

1. <b>User Management</b> - As we all know that most of the application require a user management panel. That's where we think that this could help the developers to build their own ideas much faster.

2. <b>Role Based Access Control (RBAC)</b> - One of the most important features that required in every development is a role management. Now that could be solved in <b>Laramin</b> as we served the most basic need to control the access of the users.

3. <b>Interactive & Beautiful Interface</b> - UI/UX is the most important element in any application development as that is the first thing that people will see which bring us to make sure that user have the best experience in our product. <b>Laramin</b> is using [Porto Template](https://themeforest.net/item/porto-responsive-html5-template/4106987) as our main UI template because it has almost everything we need in our application.

4. <b>Objec-Oriented View</b> - As a Laravel developers, most common issue we're facing is repeated view file created for specific module which make the development period much longer. Well, with <b>Laramin</b>, we've created several template page suitable for few condition such as:

- <b>Table View</b> - page where we list out the data that we want for example list of users or list of post. This include integration with [Yajra Datatables](https://yajrabox.com/docs/laravel-datatables/master/installation) to give user the experience in managing the data

- <b>Form View</b> - Creating a form is so much time consuming, as a developers, forms is the most common element that we must facing, so we created an object driven pre-defined template for the developers to produce the form without any concern about the design. <b>Laramin</b> will do it for u. Just fill up few informations and.. <i>Voilà!!</i>

  

## Package Included

  

These are the open sourced packages/plugins included in <b>Laramin</b>:

- [Laravel 8.0](https://laravel.com/)

- [Laravel UI 3.3](https://github.com/laravel/ui)

- [Laratrust 6.3](https://laratrust.santigarcor.me/docs/6.x/installation.html)

- [Porto Template](https://themeforest.net/item/porto-responsive-html5-template/4106987)

- [Sweet Alert 2](https://sweetalert2.github.io/)

- [Jquery DataTable 1.11.3](https://datatables.net/examples/index)

- [Data Table Checkboxes](https://datatables.net/extensions/select/examples/initialisation/checkbox.html)

- [Yajra Data Tables](https://yajrabox.com/docs/laravel-datatables/master/installation)