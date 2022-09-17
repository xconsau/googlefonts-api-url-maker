<?php
/**
 * Example usage for Google Fonts API URL Maker
 */

// Include the class file in your php project
require_once( 'class_gf_api_url_maker.php' );


/**
 * Sample fonts data
 * 
 * In everyday use case of WordPress themes and plugins,
 * This data will be collected from different UI dropdowns
 * containing the font options
 * 
 * For example, your plugin may have Google Fonts dropdown for post title, excerpt and post meta.
 * Then collect values of all these in form of 'family' and 'variant', and provide inside this class
 */
$fonts_data = [
    [
        'family' => 'Noto Sans', // Family chosen from one field
        'variant' => '100italic'
    ],
    [
        'family' => 'Open Sans', // Family chosen from another field
        'variant' => '100'
    ],

    [
        'family' => 'Kumbh Sans', // and so on
        'variant' => '300'
    ],

    [
        'family' => 'Open Sans',
        'variant' => '300italic'
    ],

    [
        'family' => 'Space Grotesk',
        'variant' => '400'
    ],

    [
        'family' => 'Open Sans',
        'variant' => '200italic'
    ],

    [
        'family' => 'Open Sans',
        'variant' => '800'
    ],

    [
        'family' => 'Open Sans',
        'variant' => '600'
    ],

    [
        'family' => 'Noto Sans',
        'variant' => '700'
    ],

    [
        'family' => 'Noto Sans',
        'variant' => '600italic'
    ],
    [
        'family' => 'Noto Sans',
        'variant' => '300'
    ],
    [
        'family' => 'Public Sans',
        'variant' => '300'
    ],

    [
        'family' => 'Noto Sans',
        'variant' => 'italic'
    ], 

     [
        'family' => 'Noto Sans',
        'variant' => '100italic'
    ],

    [
        'family' => 'Noto Sans',
        'variant' => '700'
    ],

    [
        'family' => 'Noto Sans',
        'variant' => 'regular'
    ] 
];


// Create class instance
$url = new GF_API_URL_Maker;

/**
 * Use $return='html' for complete HTML markup
 * Markup will not be visible on frontend, view page source
 */

echo $url->generateApiUrl( $fonts_data, $return = 'url' );

// Will output
// https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300&family=Noto+Sans:ital,wght@0,300;0,400;0,700;1,100;1,400;1,600&family=Open+Sans:ital,wght@0,100;0,600;0,800;1,200;1,300&family=Public+Sans:wght@300&family=Space+Grotesk&display=swap