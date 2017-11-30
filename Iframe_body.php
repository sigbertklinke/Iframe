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

  /**
   * Initialize the parser hooks
   *
   * @param Parser $parser
   *
   * @return bool
   */
  public static function setHooks( Parser $parser ) {
    global $wgIframe;
    $wgIframe = array ('local'      => array('scheme' =>'http',  'domain' => 'localhost:3838'),
                       'locals'     => array('scheme' =>'https', 'domain' => 'localhost:3838'),
                       'rstudio'    => array('scheme' =>'http',  'domain' => 'shiny.rstudio.com'),
                       'shinyapps'  => array('scheme' =>'http',  'domain' => 'shinyapps.io'),
                       'mars'       => array('scheme' =>'http',  'domain' => 'mars.wiwi.hu-berlin.de:3838'),
                       'wiwi'       => array('scheme' =>'https', 'domain' => 'shinyapps.wiwi.hu-berlin.de')
                       );
    $parser->extIframe = new self();
    $parser->setHook( 'iframe', [ $parser->extIframe, 'iframe' ] );
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

  public function iframe( $str, array $argv, Parser $parser, PPFrame $frame ) {
    # partial matching of parameters if necessary
    $params = array('width', 'height', 'path', 'level');
    foreach ($argv as $key => $value) {
      $parr = array();
      foreach($params as $param) {
        if (substr($param, 0, strlen($key)) === $key) array_push($parr, $param);
      }
      if (count($parr)==1) $argv[array_pop($parr)] = $value;
    }
    # get parameters
    $width  = (array_key_exists('width',  $args) ? $args['width']  : 800);      
    $height = (array_key_exists('height', $args) ? $args['height'] : 600); 
    $key    = (array_key_exists('path',   $args) ? $args['path']   : 'local'); 
    $phost  = (array_key_exists('level',  $args) ? $args['level']  : ''); 
    if (!empty($phost)) $phost .= '.';
    #
    $page   = (array_key_exists('p',  $args) ? $args['p']  : ''); 
    $url    = $wgIframe[$key]['scheme'] . '://' . $phost .  $wgIframe[$key]['domain'] . '/';
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

}

?>
