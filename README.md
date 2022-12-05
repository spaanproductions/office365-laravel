## Laravel Office365

A Office365 package for Laravel 9.0 or higher
 
## Installation

````
composer require spaanproductions/office365-laravel
````

This package wil register this ServiceProvider automatically in Laravel.
````
SpaanProductions\Office365\Office365ServiceProvider::class,
````

You can optionaly publish the config files.
````
php artisan vendor:publish --provider="SpaanProductions\Office365\Office365ServiceProvider"
````

Get your app id and secret from [Application Registration Portal](https://portal.azure.com/#blade/Microsoft_AAD_RegisteredApps/ApplicationsListBlade) 

Then put them in the **environment** file

````
OFFICE365_TENANT_ID=
OFFICE365_CLIENT_ID=
OFFICE365_CLIENT_SECRET=
OFFICE365_OBJECT_ID=
OFFICE365_REDIRECT_URI=http://localhost:8000/redirect
OFFICE365_SCOPES='openid profile offline_access User.Read Mail.Read'
````

## Example Usage
````
<?php

namespace App\Http\Controllers;

use SpaanProductions\Office365\Facade\Office365;

class AuthController extends Controller
{
    public function signin()
    {
        $link = Office365::login();

        return redirect($link);
    }

    public function redirect()
    {
        if (!request()->has('code')) {
            abort(500);
        }

        $code = Office365::getAccessToken(request()->get('code'));

        $user = Office365::getUserInfo($code['token']);

        $messages = Office365::getEmails($code['token']);

        dd($user, $messages);
    }
}
 ````

Methods supported by this package and their parameters can be found in the [API Reference](https://learn.microsoft.com/en-us/graph/api/overview?view=graph-rest-1.0) 

## Issues
If you have any questions or issues, please open an Issue .
