# Laravel View Generator

## Introduction

> Quickly create views and view resources from the Artisan console, saving a surprising amount of time.

## Code Samples

Creating views is as easy as:

    php artisan make:view user  // creates --> index, create, show, edit views in the resources/views/user directory
  
    php artisan make:view user.index  // creates --> resources/views/user/index.blade.php

Using something other than `blade` templates?
     
    php artisan make:view user.index -e twig  // creates --> resources/views/index.twig


Want to use a view path you specified in `config/view.php`?
     
    // If your config/view file looks like this:
    'paths' => [
        resource_path('views'),
        resource_path('my-custom-view-folder')
    ],

    // Then just pass the key you want to use, like this:
    php artisan make:view user.index -p 1  // creates --> resources/my-custom-view-folder/index.blade.php

## Install

To get started, use composer to require this package:

    composer require bencomeau/artisan-make-view --dev

Then simply `register` the package's Service Provider in your `app/Providers/AppServiceProvider.php` file:

    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\BenComeau\ArtisanMakeView\ArtisanMakeViewServiceProvider::class);
        }
    }

And you're ready to quickly generate views!

## Usage

To list all command options

    php artisan make:view --help

Make a single view by name, in `dot` notation

    php artisan make:view user.index

Make a view `resource` by passing just the name of the `resource`

    php artisan make:view user -r

Make a view with a custom extension

    php artisan make:view user.index -e twig

Make a view and store it in another directory
_Note: `-p 1` refers to the value of array key of `1` in your `config('view.paths')` setting._

    php artisan make:view user.index -p 1

Combine multiple options to fully-customize the view(s) being created
_Note: this will create all resource views in your custom directory, with the `twig` extension._

    php artisan make:view user -r -p 1 -e twig

## License
Artisan Make View is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).