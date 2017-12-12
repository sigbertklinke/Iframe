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

class Iframe {

  public static $params = array('height' => 'height', 'key'   => 'key', 
                                'level'  => 'level',  'path'  => 'path', 
                                'size'   => 'size',   'width' => 'width');

  public static function onRegistration() {
    global $wgIframe, $wgExtensionDirectory;
    $wgIframe = array('server' => array(), 'size' => array());
    if (($handle = fopen("$wgExtensionDirectory/Iframe/sizes.csv", 'r')) !==FALSE) {
      while (($data = fgetcsv($handle)) !== FALSE) {
        $wgIframe['size'][$data[0]] = array('width' => $data[1], 'height' => $data[2]);
      }
      fclose($handle);
    }
    if (($handle = fopen("$wgExtensionDirectory/Iframe/servers.csv", 'r')) !==FALSE) {
      while (($data = fgetcsv($handle)) !== FALSE) {
        $wgIframe['server'][$data[0]] = array('scheme' => $data[1], 'domain' => $data[2]);
      }
      fclose($handle);
    }
  }
  
  /**
   * Initialize the parser hooks
   *
   * @param Parser $parser
   *
   * @return bool
   */
  public static function setHooks( Parser $parser ) {
    $parser->setHook( 'iframe', 'Iframe::renderIframe' );
    return true;
  }

 /**
   * Callback function for <iframe>
   *
   * @param string|null $str Raw content of the <iframe> tag.
   * @param string[] $argv Arguments
   * @param Parser $parser
   * @param PPFrame $frame
   *
   * @return array with output
   */ 

  public static function match($str, $arr, $partial = true) {
    $karr = array();
    $lstr = strtolower($str);
    foreach ($arr as $key => $value) {
      $cmpstr = strtolower($partial ? substr($key, 0, strlen($lstr)) : $key);
      if ($cmpstr === $lstr) array_push($karr, $value);
    }
    return($karr);
  }

  public static function renderIframe( $str, array $argv, Parser $parser, PPFrame $frame ) {
    global $wgIframe;
    # partial matching of parameters if necessary
    foreach ($argv as $key => $value) {
      $karr = self::match($key, self::$params);
      if (count($karr)==1) $argv[array_pop($karr)] = $value;
    }
    # get parameters
    $width  = 800;
    $height = 600;
    if (array_key_exists('size', $argv)) {
      $karr   = self::match($argv['size'], $wgIframe['size'], FALSE);
      if (count($karr)==1) {
        $karr   = array_pop($karr);
        $width  = intval($karr['width']);
        $height = intval($karr['height']);
      }
    }
    $width  = (array_key_exists('width',  $argv) ? $argv['width']  : $width);      
    $height = (array_key_exists('height', $argv) ? $argv['height'] : $height); 
    $key    = (array_key_exists('key',    $argv) ? $argv['key']    : 'local'); 
    $phost  = (array_key_exists('level',  $argv) ? $argv['level']  : ''); 
    if (!empty($phost)) $phost .= '.';
    #
    $page   = (array_key_exists('path',  $argv) ? $argv['path']  : ''); 
    $url    = $wgIframe['server'][$key]['scheme'] . '://' . $phost .  $wgIframe['server'][$key]['domain'] . '/';
    $page   = parse_url ($page);
    $furl   = $url . $page['path'];
    if (array_key_exists('query', $page)) {
      parse_str($page['query'], $queries);
      $qarr = array();
      foreach ($queries as $key => $value) array_push($qarr, htmlentities($key) . '=' . htmlentities($value));
      $furl .= '?' . implode('&', $qarr);
    }
    $output = '<iframe src="'. $furl . '" width="'. $width .'" height="'. $height .'" frameborder="0"></iframe>';
    return array( $output, 'noparse' => true, 'isHTML' => true );	 
  } 
}

?>
