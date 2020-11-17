## Quick start

### Overview

This is a text field that stores a url to target image.

### Installation

Install package

```
composer require shedcollective/nova-unsplash-field
```

Set Unsplash ACCESS_KEY in `config/services.php`

```php
    'unsplash' => [
        'key' => env('UNSPLASH_ACCESS_KEY')
    ],
```

### Usage

```php
use Shed\Unsplash\Unsplash;

public function fields(Request $request)
{
    return [
        // ...

        Unsplash::make('Cover'),
    ];
}
```

