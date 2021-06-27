<?php
class SpecialIframe extends SpecialPage {
	function __construct() {
		parent::__construct( 'Iframe' );
	}

	function execute( $par ) {
	        global $wgIframe;
		$request = $this->getRequest();
		$output = $this->getOutput();
		$this->setHeaders();

		$wikitext = "This page gives you an overview about the parameters of the global variable <b><tt>" . '$wgIframe' . "</tt></b> which can be set at in the [https://www.mediawiki.org/wiki/Manual:LocalSettings.php <tt>LocalSettings.php</tt>] file of the wiki:\n\n{| class=\"wikitable\"\n!Parameter\n!Value(s)\n!Remark\n|- style=\"vertical-align:top;\" \n";
                foreach ($wgIframe['description'] as $key => $value) {
                  $wikitext .= ("|" . $key . "\n");
		  if (is_array($wgIframe[$key])) {
		    $wikitext .= "|";  
		    foreach ($wgIframe[$key] as $subkey => $subvalue) {
   	              $wikitext .= "<b>" . $subkey . "</b>: " . json_encode($subvalue) . "<br>";
		    }
		  } else {
		    $wikitext .= ("|" . $wgIframe[$key]);
		  }
		  $wikitext .= "\n|" . $value . "\n|- style=\"vertical-align:top;\"\n";
                }
                $wikitext .= "\n|}";

		$output->addWikiTextAsInterface( $wikitext );
	}
}
