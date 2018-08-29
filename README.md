[![Build Status](https://travis-ci.org/MasoudZarjani/zarinpal-laravel.svg?branch=master)](https://travis-ci.org/MasoudZarjani/zarinpal-laravel)

# zarinpal-laravel
Class send information to zarinpal in laravel

## install
copy this class into your directory

.
    ├── app                    # app in root laravel project
    │   ├── Helper             # copy into this folder
    |   |   ├──ZarinPalHelper.php      
    │   ├── Http               # controllers and resources folder
    │   └── Providers          # providers folder
    │── ...
    │── ...
    └── ...
    
 copy your api key into enviroment `.env` in root laravel project 
      ```jsx
      DEXSHARP_ZARRINPAL_APIKEY=********-****-****-****-************
      DEXSHARP_ZARRINPAL_CALLBACK_URL=<your callback url here>
      ```
