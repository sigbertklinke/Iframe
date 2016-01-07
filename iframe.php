<?php

/* 
Copyright 2014-2016 Sigbert Klinke (sigbert.klinke@web.de)

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

if ( !defined( 'MEDIAWIKI' ) ) {
  die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'iframe',
	'version' => '0.01',
	'description' => 'frame allowed sites in an iframe, derived from [http://www.mediawiki.org/wiki/Extension:IDisplay iDisplay] extension',
	'author' => 'Sigbert Klinke'
);
# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'iframe_Setup';
# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][]    = 'iframe_Magic';
# Allowed URLs
$wgIframeUrl = array ('rstudio' => 'http://shiny.rstudio.com/',
                      'mmstat'  => 'http://141.20.100.251/mmstat_en/');

function iframe_Setup( &$parser ) {
  # Set a function hook associating the magic word with our function
  $parser->setFunctionHook( 'iframe', 'iframe_Render' );
  return true;
}

function iframe_Magic( &$magicWords, $langCode ) {
  # Add the magic word
  # The first array element is whether to be case sensitive, in this case (0) it is not case sensitive, 1 would be sensitive
  # All remaining elements are synonyms for our parser function
  $magicWords['iframe'] = array( 0, 'iframe');
  # unless we return true, other parser functions extensions won't get loaded.
  return true;
}

function iframe_Render ($parser, $k='', $p='', $w='', $h='') {
  global $wgIframeUrl;
  $width  = (empty($w)? 800 : $w);      
  $height = (empty($h)? 600 : $h); 
  $key    = (empty($k)? 'rstudio' : $k); 
  $url    = $wgIframeUrl[$key];
  $page   = parse_url ($p);
  if (empty($url)) {
    $output = '<table width="'. $width .'"><tr align="left"><th>Possible key(s)</th><th>URL(s)</th></tr>';
    foreach ($wgIframeUrl as $key => $value) {
      $output .= '<tr><td>' . htmlentities($key) . '</td><td>' . htmlentities($value) . '</td></tr>';
    }
    $output .= '</table>';
  } else {
    $output = '<iframe src="'. $url . $page['path'] . '" width="'. $width .'" height="'. $height .'" frameborder="0"></iframe>';
  }
  return array( $output, 'noparse' => true, 'isHTML' => true );	    
}

?>
