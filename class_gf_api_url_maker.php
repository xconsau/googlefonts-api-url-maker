<?php
/**
 * Google Fonts API URL Maker
 *
 * Generates Google Fonts API v2 URL as per recommended specification
 * See https://developers.google.com/fonts/docs/css2#forming_api_urls
 * 
 * Takes a font data array and returns valid API URL for fetching font files from Google Fonts
 * 
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * Author: Saurabh Sharma
 */



if ( ! class_exists( 'GF_API_URL_Maker' ) ) {

    class GF_API_URL_Maker {

        
        // Using fallback function for str_contains() as backward compatibility
        public function str_contains( string $haystack, string $needle ): bool {
            return '' === $needle || false !== strpos( $haystack, $needle );
        }

        
        /**
         * Generates API URL
         * 
         * $fonts_data should be an array with each items as array of family and variant
         * See example.php
         * 
         */
        public function generateApiUrl( $fonts_data = array(), $return = 'url' ) {
            
            if ( ! empty( $fonts_data ) ) {

                $temp = [];
                foreach( $fonts_data as $data ) {
                    $v = '';
                    $arr = '';
                    if ( array_key_exists( $data['family'], $temp ) ) {
                        $v = $temp[$data['family']];
                    }

                    if ( '' == $v ) {
                        $arr = $data['variant'];
                    } else {
                        $arr = $v . ',' . $data['variant'];
                    }

                    $temp[$data['family']] = $arr;
                }

                if ( ! empty ( $temp ) ) {
                    $filtered = [];
                    foreach( $temp as $key => $val ) {
                        
                        // Skip if the family name is 'Default'
                        if ( 'Default' == $key )
                            continue;
                        
                        $variants_arr = [];
                        $swapped = [];
                        $val = str_replace( 'regular', '400', $val );            

                        // Swap the word 'italic' for proper sorting
                        $variants_arr = explode( ',', $val );

                        foreach( $variants_arr as $item ) { 

                            if ( $item === 'italic' ) {
                                $item = str_replace( 'italic', '400italic', $item );
                            }

                            if( $this->str_contains( $item, 'italic' ) ) {
                                $item = str_replace( 'italic', '', $item );
                                $item = 'italic' . $item;
                            }

                            $swapped[] = $item;
                        }
                        
                        $filtered[$key] = array_unique( $swapped );
                        
                        // Sort variants per family
                        sort( $filtered[$key] );
                    }
                }
                
                // Sort entire array by family (key) name
                ksort( $filtered );
            }

            // Build API URL on filtered array
            if ( isset( $filtered ) && is_array( $filtered ) && ! empty( $filtered ) ) {

                $family = '';
                $tuple = '';
                $variants = '';
                $per_font_query = '';
                $i = 0;
                $query_string = '';
                $colon = ':';

                foreach( $filtered as $key => $val ) {
                    $family = str_replace( ' ', '+', $key );

                    // Single variant
                    if ( count( $val ) == 1 ) {

                        // 400
                        if ( '400' == $val[0] ) {
                            //continue;
                            $colon = '';
                            $variants = '';
                            $tuple = '';
                        }

                        // 400 italic
                        elseif ( 'italic' == $val[0] || $val[0] === 'italic400' ) {
                            $tuple = 'ital@1';
                            $colon = ':';
                        }

                        // One variant except 400
                        elseif ( '400' !== $val[0] ) {
                            
                            // Reset variants
                            $variants = '';
                            $colon = ':';
                            
                            if( $this->str_contains( $val[0], 'italic' ) ) {                                    
                                $tuple = 'ital,wght@1,' . str_replace('italic', '', $val[0]);
                            } else {
                                $tuple = 'wght@' . $val[0];
                            }
                        }
                    }

                    // Multiple variants
                    else {
                        $tuple = 'wght@';
                        $count = 0;
                        $variants = '';
                        $ital_flag = false;
                        $colon = ':';
                        
                        // Check if there is any italic variant
                        foreach( $val as $v ) {
                            if( $this->str_contains( $v, 'italic' ) ) {
                                $ital_flag = 'true';
                            }
                        }
                        
                        foreach( $val as $v ) {

                            if( $this->str_contains( $v, 'italic' ) ) {
                                if ( 'italic' == $v ) {
                                    $variants .= '1,400';
                                } else {
                                    $variants .= '1,' . str_replace('italic', '', $v);
                                }
                            } else {
                                if('true' == $ital_flag) {
                                    $variants .= '0,' . $v;
                                } else {
                                    $variants .= $v;
                                }
                            }

                            if( 'true' == $ital_flag) {
                                $tuple = 'ital,wght@';
                            }

                            if ( $count < ( count( $val ) - 1 ) ) {
                                $variants .= ';';
                            }

                            $count++;

                        }
                    }

                    $per_font_query .= 'family=' . $family . $colon . $tuple . $variants;

                    if ( $i < ( count( $filtered ) - 1 ) ) {
                        $per_font_query .= '&';
                    }

                    $i++;
                }

                if ( '' !== $per_font_query ) {
                    $query_string = 'https://fonts.googleapis.com/css2?' . $per_font_query . '&display=swap';
                }

                if ( 'url' === $return ) {
                    return $query_string;
                } else {
                    $markup = "<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\n";
                    $markup .= "<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\n";
                    $markup .= "<link rel=\"stylesheet\" href=\"" . $query_string . "\" />\n";

                    return $markup;
                }
            }
        }

    } // Class GF_API_URL_Maker

} // If not class exists
