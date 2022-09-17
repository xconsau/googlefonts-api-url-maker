## About

Google Fonts API URL Maker is a small php tool for generating Google Fonts v2 API from the supplied font data. The URL is generated as per [Google's Font API URL Specification](https://developers.google.com/fonts/docs/css2#forming_api_urls)

## Installation

Download and include the class file inside your php project as:

<pre>require_once( 'class_gf_api_url_maker.php' );</pre>

Then provide sample fonts data from which you wish to generate the URL:

<pre>$fonts_data = [
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

echo $url->generateApiUrl( $fonts_data, $return = 'html' );</pre>

Sample URL will look like:

<pre>https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300&family=Noto+Sans:ital,wght@1,100&family=Open+Sans:wght@100&display=swap</pre>

See example.php for more details.

## Changelog

**17 Sep 2022. Version 1.0**
- Initial Release

## License

GPLv2 or later
http://www.gnu.org/licenses/gpl-2.0.html