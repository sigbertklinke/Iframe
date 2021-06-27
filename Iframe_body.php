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
                                'size'   => 'size',   'width' => 'width',
                                'allowfullscreen' => 'allowfullscreen');

  public static function onRegistration() {
    global $wgIframe;
    $config = array(
        "description" => array(
            "delay"    => "Determines when and how fast iframes are loaded (in ms)",
            "width"    => "Determines the default width of an iframe (in pixel)",
            "height"   => "Determines the default height of an iframe (in pixel)",
            "category" => "Determines if and which category page is used by the extension",
            "server"   => "Determines which servers can be used.<br>A URL is composed by <i>key-scheme://level.key-domain/path</i>",
            "size"     => "Predefined sizes (in pixel) for iframes<br>Note: Names are case-sensitive!",
            "allowfullscreen" => "Allow content to be displayed in fullscreen mode"
        ),
        "delay"    => 50,
        "width"    => 800,
        "height"   => 600,
        "allowfullscreen" => false,
        "category" => "Iframe",
        "server"   => array(
            "local"     => array("scheme" => "http",  "domain" => "localhost"),
            "locals"    => array("scheme" => "https",   "domain" => "localhost"),
            "shiny"     => array("scheme" => "http",    "domain" => "localhost:3838"),
            "shinys"    => array("scheme" => "https",   "domain" => "localhost:3838"),
            "rstudio"   => array("scheme" => "http",    "domain" => "shiny.rstudio.com"),
            "shinyapps" => array("scheme" => "http",    "domain" => "shinyapps.io"),
            "mars"      => array("scheme" => "http",    "domain" => "mars.wiwi.hu-berlin.de"),
            "wiwi"      => array("scheme" => "https",   "domain" => "shinyapps.wiwi.hu-berlin.de"),
            "hubox"     => array("scheme" => "https",   "domain" => "box.hu-berlin.de")
        ),
        "size" => array(
            "QQVGA"   => array(   160,   120),
            "HQVGA"   => array(   240,   160),
            "QVGA"    => array(   320,   240),
            "WQVGA"   => array(   400,   240),
            "HVGA"    => array(   480,   320),
            "nHD"     => array(   640,   360),
            "WVGA_1"  => array(   640,   360),
            "WVGA_2"  => array(   640,   384),
            "SD"      => array(   640,   480),
            "VGA"     => array(   640,   480),
            "WVGA_3"  => array(   720,   480),
            "WGA"     => array(   768,   480),
            "WVGA"    => array(   768,   480),
            "WVGA_5"  => array(   768,   480),
            "WVGA_4"  => array(   800,   450),
            "WVGA_6"  => array(   800,   480),
            "SVGA"    => array(   800,   600),
            "WVGA_7"  => array(   848,   480),
            "FWVGA"   => array(   854,   480),
            "DVGA"    => array(   960,   480),
            "qHD"     => array(   960,   540),
            "WSVGA_5" => array(  1024,   576),
            "WSVGA"   => array(  1024,   600),
            "WSVGA_6" => array(  1024,   600),
            "XGA"     => array(  1024,   768),
            "WXGA_1"  => array(  1152,   768),
            "XGA+_1"  => array(  1152,   832),
            "XGA+"    => array(  1152,   864),
            "XGA+_2"  => array(  1152,   864),
            "XGA+_3"  => array(  1152,   870),
            "XGA+_4"  => array(  1152,   900),
            "HD"      => array(  1280,   720),
            "WXGA_2"  => array(  1280,   720),
            "WXGA_3"  => array(  1280,   768),
            "WXGA_4"  => array(  1280,   800),
            "SXGA"    => array(  1280,  1024),
            "WXGA_5"  => array(  1344,   768),
            "WXGA_6"  => array(  1360,   768),
            "WXGA"    => array(  1366,   768),
            "WXGA_7"  => array(  1366,   768),
            "SXGA+"   => array(  1400,  1050),
            "WSXGA"   => array(  1440,   900),
            "WXGA+"   => array(  1440,   900),
            "HD+"     => array(  1600,   900),
            "UXGA"    => array(  1600,  1200),
            "WSXGA+"  => array(  1680,  1050),
            "FHD"     => array(  1920,  1080),
            "WUXGA"   => array(  1920,  1200),
            "DCI2K"   => array(  2048,  1080),
            "QWXGA"   => array(  2048,  1152),
            "QXGA"    => array(  2048,  1536),
            "FHD+"    => array(  2160,  1440),
            "1440p"   => array(  2560,  1440),
            "WQHD"    => array(  2560,  1440),
            "WQXGA"   => array(  2560,  1600),
            "QSXGA"   => array(  2560,  2048),
            "QHD+"    => array(  3200,  1800),
            "WQXGA+"  => array(  3200,  1800),
            "WQSXGA"  => array(  3200,  2048),
            "QUXGA"   => array(  3200,  2400),
            "UWQHD"   => array(  3440,  1440),
            "UW4K"    => array(  3840,  1600),
            "4KUHD"   => array(  3840,  2160),
            "UHDTV-1" => array(  3840,  2160),
            "WQUXGA"  => array(  3840,  2400),
            "HXGA"    => array(  4093,  3072),
            "Cinema4K"=> array(  4096,  2160),
            "DCI4K"   => array(  4096,  2160),
            "UW5K"    => array(  5120,  2160),
            "5K"      => array(  5120,  2880),
            "UHD+"    => array(  5120,  2880),
            "WHXGA"   => array(  5120,  3200),
            "HSXGA"   => array(  5120,  4096),
            "HUXGA"   => array(  6400,  4800),
            "8KUHD"   => array(  7680,  4320),
            "UHDTV-2" => array(  7680,  4320),
            "WHUXGA"  => array(  7680,  4800),
            "10KUHD"  => array( 10240,  4320)
        )
    );
#    echo "<pre> start";
    foreach ($config as $key => $value) {
#var_dump($key);      
	    if (array_key_exists($key, $wgIframe)) {
	if (is_array($config[$key])) {
          $wgIframe[$key] = array_merge($config[$key], $wgIframe[$key]);
        }
      } else {
	$wgIframe[$key] = $config[$key];
      }
    }
#    echo "End</pre>";
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
 #   var_dump("render");	  
    if (!property_exists($parser, 'Iframe')) {
      $parser->Iframe = array('no' => 1);
    } else {
      $parser->Iframe['no']++;
    }
#    var_dump("match param");
    #$parser->mOutput->addModules('ext.Iframe');
    $parser->getOutput()->addModules( 'ext.Iframe' );
    # partial matching of parameters if necessary
#    var_dump("argv");
    foreach ($argv as $key => $value) {
#var_dump($key);	   
      $karr = self::match($key, self::$params);
      if (count($karr)==1) $argv[array_pop($karr)] = $value;
    }
#    var_dump("set param");
    # set parameters
#    var_dump($wgIframe);
    $width  = $wgIframe['width'];
    $height = $wgIframe['height'];
    if (array_key_exists('size', $argv)) {
      if (array_key_exists($argv['size'], $wgIframe['size'])) {
        $width  = $wgIframe['size'][$argv['size']][0];
        $height = $wgIframe['size'][$argv['size']][1];
      }
    }
    $width  = (array_key_exists('width',  $argv) ? $argv['width']  : $width);
    $height = (array_key_exists('height', $argv) ? $argv['height'] : $height);
    $key    = (array_key_exists('key',    $argv) ? $argv['key']    : 'local');
    $allowfullscreen = (array_key_exists('allowfullscreen', $argv) ? $argv['allowfullscreen'] : $wgIframe['allowfullscreen']);
    // From boolean to iframe option:
    $allowfullscreen = $allowfullscreen ? 'allowfullscreen' : '';
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
    if (array_key_exists('fragment', $page)) {
      $furl .= '#' . htmlentities($page['fragment']);
    }
    $id = 'Iframe' . $parser->Iframe['no'];
    if ($wgIframe['delay']<0) {
      $output = '<iframe id="' . $id . '" src="' . $furl . '" width="'. $width .'" height="'. $height .'" frameborder="0" '. $allowfullscreen .' ></iframe>';
    } else {
      $output = '<iframe id="' . $id . '" data-src="' . $furl . '" data-delay="' . $wgIframe['delay'] . '" width="'. $width .'" height="'. $height .'" frameborder="0" '. $allowfullscreen .' ></iframe>';
    }
    if (array_key_exists('category', $wgIframe)) {
      #var_dump($wgIframe['category']);
      if (is_array($wgIframe['category'])) {
        foreach ($wgIframe['category'] as $value) {
          $output .= $parser->recursiveTagParse(sprintf('[[Category:%s]]', $value), $frame);
	}
      } else {
        $output .= $parser->recursiveTagParse(sprintf("[[Category:%s]]", $wgIframe['category']), $frame);
      }
    }
#    var_dump("end of render");
#    $output = '<iframe id="' . $id . '" src="'. $furl . '" width="'. $width .'" height="'. $height .'" frameborder="0"></iframe>';
    return array( $output, 'noparse' => true, 'isHTML' => true );
  }
}

?>
