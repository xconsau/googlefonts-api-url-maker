## About

Google Fonts API URL Maker is a php tool for generating Google Fonts v2 API URL from user provided font data. The URL is generated as per [Google Font's API URL Specification](https://developers.google.com/fonts/docs/css2#forming_api_urls)

## Background
While developing a Gutenberg plugin for WordPress, I needed some Typography controls for various elements like post title, excerpt, image captions, etc. Each typography control was a group of select/input fields like font-family, variant, font-size, line-height, text-transform, etc. The "font-family" and "variant" data was fetched from the Google fonts JSON data. After creating several controls for the typography, the main task was to combine this data and generate a Google Fonts API URL which can download necessary font files as chosen for each field. It was this requirement which led to the creation of the Google Fonts API URL Maker.


## Installation

Download and include the class file inside your php project as:

```php
require_once( 'class_gf_api_url_maker.php' );
```

Then provide sample fonts data from which you wish to generate the URL:

```php
$fonts_data = [
    [
        'family' => 'Noto Sans',
        'variant' => '100italic'
    ],
    
    [
        'family' => 'Open Sans',
        'variant' => '100'
    ],

    [
        'family' => 'Kumbh Sans',
        'variant' => '300'
    ]
];


// Create class instance
$url = new GF_API_URL_Maker;

/**
 * Use $return='html' for complete HTML markup
 * Markup will not be visible on frontend, view page source
 */

echo $url->generateApiUrl( $fonts_data, $return = 'url' );
```

Sample URL will look like:

```html
https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300&family=Noto+Sans:ital,wght@1,100&family=Open+Sans:wght@100&display=swap
```

See example.php for more details.

## Changelog

**17 Sep 2022. Version 1.0**
- Initial Release

## License

GPLv2 or later
http://www.gnu.org/licenses/gpl-2.0.html
