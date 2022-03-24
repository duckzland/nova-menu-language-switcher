# Simple Language Switcher for Laravel Nova Menu Builder

This package is developed for my specific use case only. It might fit or not with your needs.


# Define the available locales
At you config/app.php add this variables:

```
    // Available locales to switch
    'locales' => [
        'en_US' => 'English',
        'en_CA => 'Canadian English',
        'de' => 'Germans',

        ... and other locales
    ],

    // Fallback locale
    'fallback_locale' => 'en_US,
```


# Add the field to nova

```
    use Duckzland\NovaMenuLanguageSwitcher\MenuLanguageSwitcher;

    MenuLanguageSwitcher::make(__('Locale'))
        ->setPlaceholder(__('Change Language'))
```
