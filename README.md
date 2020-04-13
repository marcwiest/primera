
# Primera

Primera is an WordPress theme with a modern development workflow.

## Features

- Laravel's Blade templating engine
- Laravel's Mix webpack wrapper
- Controllers for template data passing
- Modern JavaScript via Babel.js
- Modern CSS via Sass, Less, Stylus or PostCSS
- Autoprefixer and Browserlist
- Browsersync live updates
- Composer and NPM package managers
- Composer PSR-4 autoloader
- Build scripts for zip and pot files
- Single point Dotenv configuration

## Requirements

Make sure all dependencies have been installed before moving on.

- [WordPress](https://wordpress.org/) >= 5.4
- [PHP](https://www.php.net/manual/en/install.php) >= 7.3
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/) >= 12.0.0

## Installation

1. Download WordPress, either manually or via WP CLI, if installed.
```shell
wp core download
```
2. Open the themes directory inside your WordPress installation.
```shell
cd wp-content/themes
```
3. If you don't have [Composer](https://getcomposer.org/doc/00-intro.md) installed, go ahead and do that now. Then run the following command in your terminal.
```shell
composer create-project gooddaywp/primera my-theme-name
```

This will install all PHP and NPM dependencies for you. It will also copy the **.env.example** file to **.env**.

## Folder Structure

**/app** <br>
This folder holds the template Controllers and theme helpers functions. This folder maps to the autoload PSR-4 setting within composer.

**/config** <br>
The config holds the theme and plugin configuration.

**/public** <br>
This folder holds assets such as images, fonts as well as compiled asset (CSS & JS) coming from the source folder.

**/source** <br>
The source folder holds assets that need compiling i.e. CSS, JS and the Blade template files inside of the views folder.

**/tasks** <br>
This folder holds build scripts written in Node.js. They are placed into theme so you can modify them suit your project's needs.

**/templates** <br>
The template folder holds custom WordPress page tempaltes.

## App Files

Throughout the theme, "app" files are used to handle data that's ment to be applied to the theme globally.

**/app/Controllers/App.php** <br>
This file supplies values globally to all templates.

**/source/css/app.css** & **/source/js/app.js** <br>
These files compile global JS & CSS.

**/source/views/app.blade.php** <br>
This is the main template file that other view are extending.

## Controllers, Views & View Scripts

Controller class names follow the same hierarchy as WordPress. Meaning, to create a controller for the `front-page.php` WordPress template, you would create a Controller with the class name `FrontPage.php` inside the Controllers folder. The controller will automatically be loaded for this template file.

Primera will tell WP to look for the coresponding Blade template (<abbr title="also known as">AKA</abbr> view) inside the views directory. The template name does not need to be modified. Meaning, `front-page.php` or `front-page.blade.php` will both work.

If you prefer to use the default WordPress template, simply place it into the root level of your WP theme. However, Controllers and Blade templating won't work in this case.

Primera will also look for so called view scritps inside your public folder. Meaning, CSS or JS scritps (e.g. `front-page.css`) with same name as the WP template will get automatically enqueued on the front page template.

Please have a look at the [soberwp/controller documentation](https://github.com/soberwp/controller/blob/master/README.md) to fully understand how they work.

## AJAX Actions & REST Routes

## Blade Templating

## Dotenv Configuration

## Getting Up To Speed With Modern PHP

https://www.smashingmagazine.com/2019/02/wordpress-modern-php/



