# APCS
The web application for the Automatic Parking Charge System developed as a group project for Abertay University.

Site: https://mayar.abertay.ac.uk/~cmp311gc1801/

## Development Enviroment

To set the dev environment up for the site, you'll need to get Composer 

i.e. https://getcomposer.org/doc/00-intro.md#installation-windows if you are using Windows

Then run the command `composer update` when you are in the `Web` folder (same folder as composer.json).

If you don't do this, the site won't load up on your local machine cause index.php requires the `vendor/autoload.php` file. 

The `vendor` folder has been added to the `.gitignore` file because that folder can get pretty big because it's filled with all the external dependencies.
