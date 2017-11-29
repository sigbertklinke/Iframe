<?php

/* 
Copyright 2014-2017 Sigbert Klinke (sigbert.klinke@web.de)

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
	'version' => '0.03',
	'description' => 'embeds external webpages in an wiki with an iframe, derived from [http://www.mediawiki.org/wiki/Extension:IDisplay iDisplay] extension',
	'author' => 'Sigbert Klinke'
);
# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'iframe_Setup';
# Allowed URLs
$wgIframeUrl = array ('rstudio'    => array('scheme' =>'http',  'domain' => 'shiny.rstudio.com'),
                      'shinyapps'  => array('scheme' =>'http',  'domain' => 'shinyapps.io'),
                      'mars'       => array('scheme' =>'http',  'domain' => 'mars.wiwi.hu-berlin.de:3838'),
                      'wiwi'       => array('scheme' =>'https', 'domain' => 'shinyapps.wiwi.hu-berlin.de');

function iframe_Setup( &$parser ) {
  # Set a function hook associating the magic word with our function
  $parser->setHook( 'iframe', 'iframe_Render' );
  return true;
}

function iframe_Render ($input, array $args, Parser $parser, PPFrame $frame) {
  global $wgIframeUrl;
  $width  = (array_key_exists('w',  $args) ? $args['w']  : 800);      
  $height = (array_key_exists('h',  $args) ? $args['h']  : 600); 
  $key    = (array_key_exists('k',  $args) ? $args['k']  : 'rstudio'); 
  $phost  = (array_key_exists('l', $args)  ? $args['l']  : ''); 
  if (!empty($phost)) $phost .= '.';
  $page   = (array_key_exists('p',  $args) ? $args['p']  : ''); 
  $url    = $wgIframeUrl[$key]['scheme'] . '://' . $phost .  $wgIframeUrl[$key]['domain'] . '/';
  $page   = parse_url ($page);
  if (empty($url)) {
    $output = '<table width="'. $width .'"><tr align="left"><th>Possible key(s)</th><th>URL(s)</th></tr>';
    foreach ($wgIframeUrl as $key => $value) {
      $output .= '<tr><td>' . htmlentities($key) . '</td><td>' . htmlentities($value) . '</td></tr>';
    }
    $output .= '</table>';
  } else {
    $furl = $url . $page['path'];
    if (array_key_exists('query', $page)) {
      parse_str($page['query'], $queries);
      $qarr = array();
      foreach ($queries as $key => $value) array_push($qarr, htmlentities($key) . '=' . htmlentities($value));
      $furl .= '?' . implode('&', $qarr);
    }
    $output = '<iframe src="'. $furl . '" width="'. $width .'" height="'. $height .'" frameborder="0"></iframe>';
  }
  return array( $output, 'noparse' => true, 'isHTML' => true );	    
}

?>
