## Introduction
This is a simple Laravel Package for making access codes for you models that can then be used elsewhere such as in Door Control Systems.

## Installation
This package can be installed in any Laravel app with ease, just follow the steps below:

1. As this is a small side project it isn't hosted on Composer, you can still install via composer though by adding this Repo as a repository, you can add the below snippet under your `repositories` composer.json config.
```
{
    "type": "vcs",
    "url": "git@github.com:TraffordFewster/access-code.git"
}
```
2. Run `composer require traffordfewster/access-code`
3. In your `app.php` Laravel config add `Traffordfewster\AccessCode\AccessCodeServiceProvider::class` under the Package Service Providers.
4. Run Migrations on your Laravel App.

## Integrating with your model
Integrating with your model is quite simple, all you need todo is use the trait for example:
```
class YourModel extends Model
{
    use Traffordfewster\AccessCode\Traits\InteractsWithAccessCodes

    ...
}
```
You will then have access to all the trait methods on your model with can be found [here](https://github.com/TraffordFewster/access-code/wiki/InteractsWithAccessCodes).

## More Documentation
[Generators](https://github.com/TraffordFewster/access-code/wiki/Generators)
