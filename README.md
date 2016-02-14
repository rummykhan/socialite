## Introduction
---
* Laravel Socialite provides an expressive, fluent interface to OAuth authentication with Facebook, Twitter, Google, LinkedIn, GitHub and Bitbucket. It handles almost all of the boilerplate social authentication code you are dreading writing.
---
## Official Documentation

* Documentation for Socialite can be found on the [Laravel/Socialite](https://github.com/laravel/socialite#laravel-socialite)
---
## License
* Laravel Socialite is open-sourced software licensed under the MIT license
---
## Modification

* Created `InstagramProvider` in `src/Two Directory`
* Created `protected function createInstagramDriver()` in `src/SocialiteManager.php` Class
---
## Usage
* Add your instagram configuration in app/services.php
* And change the driver to instagram `return Socialite::driver('instagram')->scopes(['public_content'])->redirect();`

---
Cheers!
