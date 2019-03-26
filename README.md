# APCS
The web application for the Automatic Parking Charge System developed as a group project for Abertay University.

Site: https://mayar.abertay.ac.uk/~cmp311gc1801/

## Development Enviroment

To set the dev environment up for the site, you'll need to get Composer 

i.e. https://getcomposer.org/doc/00-intro.md#installation-windows if you are using Windows

Then run the command `composer update` when you are in the `Web` folder (same folder as composer.json).

If you don't do this, the site won't load up on your local machine cause index.php requires the `vendor/autoload.php` file. 

The `vendor` folder has been added to the `.gitignore` file because that folder can get pretty big because it's filled with all the external dependencies.

## API

URL: `https://mayar.abertay.ac.uk/~cmp311gc1801/index.php?controller=api&action=check&type=[type]&reg=[reg]&carparkid=[id]`

`type`: entry OR exit
`reg`: the vehicle reg (i.e. SA07ENW)
`carparkid`: the carpark ID...

Potential results:

`CARPARK_NOT_FOUND` - The carpark ID did not match any in the database.

`VEHICLE_NOT_FOUND` - The vehicle reg did not match any in the database.

`ENTRY_SUCCESS` - The vehicle reg was found and an entry was added to the database. The PI can allow the driver to pass through.

`EXIT_SUCCESS` - The vehicle reg was found and the entry was updated with the exit time. The PI can allow the driver to exit.

`PARKING_ENTRY_NOT_FOUND` - This message will appear when calling for the vehicle to exit if the entry for the reg did not exist or if the ExitDateTime is not null or not set to default. This shouldn't happen.

`TYPE_NOT_SPECIFIED` - The `type` parameter was not set in the URL, or it was set but not to `entry` or `exit`

`PARAMETERS_MISSING` - One or more of the parameters were missing: `type`, `reg`, or `carparkid`

The JSON result will be in the following format: `{"Message":"ENTRY_SUCCESS"}`
