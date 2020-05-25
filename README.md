# APCS
The web application for the Automatic Parking Charge System developed as a group project for Abertay University.

Site: https://mayar.abertay.ac.uk/~cmp311gc1801/

## Description

This project was the development of a parking system that scans the registration plates of vehicles when they enter and leave a car park, and automatically charges customers based on the length of their stay. This system was requested by the client Smart Parking Ltd. The client desires a modern and elegant parking system solution that will be far more convenient to customers than solutions currently available through competitors, and that will allow changes to parking prices to be quickly and easily implemented throughout the entire system.

To  achieve  this,  a  system  was  created  involving  a  website,  client-server  setup,  a license-plate  recognising  API  (known  as  OpenALPR;  Automatic  License  Plate Recognition), and a Raspberry Pi device. The website is what a customer will use to create  an  account,  register  vehicles  to that  account,  and  purchase  season  permits. The  server  contains  details  of  registered  customers  and  vehicles  owned  by  the customers. The Raspberry Pi controls a camera to capture images of license plates and interacts with the API that identifies the license number in the images. Once the API has identified a valid plate, the device sends this plate to the server database via a client API. If this plate is registered to a customer, the device would allow entry to the car park. If it is not registered, entry is denied. The API also keeps track of whether the given vehicle is entering or leaving, and if it is leaving the customer who owns it is charged accordingly.  

The result of this project was a robust system with a secure and functioning front-end, and a mostly-accurate license plate detector. It adequately demonstrates all the core functionality requested  and  forms  a  solid  basis  for  a  viable  real-world  car  park technology. It would need to be scaled up appropriately and refactored for commercial use, but in its current form it successfully carries out all necessary tasks on a minor scale.

[See White Paper](https://github.com/MickMelon/AutomaticParkingChargeSystem/blob/master/WhitePaper.pdf)

## Development Enviroment

To set the dev environment up for the site, you'll need to get Composer 

i.e. https://getcomposer.org/doc/00-intro.md#installation-windows if you are using Windows

Then run the command `composer update` when you are in the `Web` folder (same folder as composer.json).

If you don't do this, the site won't load up on your local machine cause index.php requires the `vendor/autoload.php` file. 

The `vendor` folder has been added to the `.gitignore` file because that folder can get pretty big because it's filled with all the external dependencies.

## API

**URL**

`https://mayar.abertay.ac.uk/~cmp311gc1801/index.php?controller=api&action=check&reg=[reg]&carparkid=[id]`

**Parameters**

`reg`: the vehicle reg (i.e. SA07ENW)

`carparkid`: the carpark ID...

**Potential Results**

`CARPARK_NOT_FOUND` - The carpark ID did not match any in the database.

`VEHICLE_NOT_FOUND` - The vehicle reg did not match any in the database.

`ENTRY_SUCCESS` - The vehicle reg was found and an entry was added to the database. The PI can allow the driver to pass through.

`EXIT_SUCCESS` - The vehicle reg was found and the entry was updated with the exit time. The PI can allow the driver to exit.

`PARKING_ENTRY_NOT_FOUND` - This message will appear when calling for the vehicle to exit if the entry for the reg did not exist or if the ExitDateTime is not null or not set to default. This shouldn't happen.

`PARAMETERS_MISSING` - One or more of the parameters were missing: `reg` or `carparkid`

**JSON Result Format**

The JSON result will be in the following format: `{"Message":"ENTRY_SUCCESS"}`
