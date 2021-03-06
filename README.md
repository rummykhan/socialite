### rummykhan/socialite (Modified version of laravel/socialite to support instagram oauth)

## Introduction

Laravel Socialite provides an expressive, fluent interface to OAuth authentication with Facebook, Twitter, Google, LinkedIn, GitHub and Bitbucket. It handles almost all of the boilerplate social authentication code you are dreading writing.

## License

Laravel Socialite is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Official Documentation

In addition to typical, form based authentication, Laravel also provides a simple, convenient way to authenticate with OAuth providers using [Laravel Socialite](https://github.com/laravel/socialite). Socialite currently supports authentication with Facebook, Twitter, LinkedIn, Google, GitHub and Bitbucket.

To get started with Socialite, add to your `composer.json` file as a dependency:

    composer require rummykhan/socialite

### Configuration

After installing the Socialite library, register the `Laravel\Socialite\SocialiteServiceProvider` in your `config/app.php` configuration file:

    'providers' => [
        // Other service providers...

        RummyKhan\Socialite\SocialiteServiceProvider::class,
    ],

Also, add the `Socialite` facade to the `aliases` array in your `app` configuration file:

    'Socialite' => RummyKhan\Socialite\Facades\Socialite::class,

You will also need to add credentials for the OAuth services your application utilizes. These credentials should be placed in your `config/services.php` configuration file, and should use the key `facebook`, `twitter`, `linkedin`, `google`, `github` or `bitbucket`, depending on the providers your application requires. For example:

    'instagram' => [
        'client_id' => 'your-instagram-app-id',
        'client_secret' => 'your-instagram-app-secret',
        'redirect' => 'http://your-callback-url',
    ],

### Basic Usage

Next, you are ready to authenticate users! You will need two routes: one for redirecting the user to the OAuth provider, and another for receiving the callback from the provider after authentication. We will access Socialite using the `Socialite` facade:

    <?php

    namespace App\Http\Controllers;

    use Socialite;

    class AuthController extends Controller
    {
        /**
         * Redirect the user to the GitHub authentication page.
         *
         * @return Response
         */
        public function redirectToProvider()
        {
            return Socialite::driver('instagram')->redirect();
        }

        /**
         * Obtain the user information from GitHub.
         *
         * @return Response
         */
        public function handleProviderCallback()
        {
            $user = Socialite::driver('instagram')->user();

            // $user->token;
        }
    }

The `redirect` method takes care of sending the user to the OAuth provider, while the `user` method will read the incoming request and retrieve the user's information from the provider. Before redirecting the user, you may also set "scopes" on the request using the `scope` method. This method will overwrite all existing scopes:

    return Socialite::driver('instagram')
                ->scopes(['scope1', 'scope2'])->redirect();

Of course, you will need to define routes to your controller methods:

    Route::get('auth/instagram', 'Auth\AuthController@redirectToProvider');
    Route::get('auth/instagram/callback', 'Auth\AuthController@handleProviderCallback');

A number of OAuth providers support optional parameters in the redirect request. To include any optional parameters in the request, call the `with` method with an associative array:

    return Socialite::driver('google')
                ->with(['hd' => 'example.com'])->redirect();

#### Retrieving User Details

Once you have a user instance, you can grab a few more details about the user:

    $user = Socialite::driver('instagram')->user();

    // OAuth Two Providers
    $token = $user->token;

    // OAuth One Providers
    $token = $user->token;
    $tokenSecret = $user->tokenSecret;

    // All Providers
    $user->getId();
    $user->getNickname();
    $user->getName();
    $user->getEmail();
    $user->getAvatar();
