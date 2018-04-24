# Purpose

The extension allows in a MediWiki the embedding of foreign web pages via an `iframe`. 

# Usage

`<iframe k="rstudio" p="page" w="800" h="600" />`

The parameters `w`and `h` are optional. The final URL is `http://shiny.rstudio.com/page`, composed of the value in `$wgIframeUrl` for the key `rstudio` and `p`.

# Installation

* Create a subfolder `iframe` in the extensions directory of your MediaWiki installation.
* Install `iframe.php` in the subfolder
* Edit your `LocalSettings.php` and add at the end `include("$IP/extensions/iframe/iframe.php");`
* The hash `$wgIframeUrl` in `iframe.php` controls which web addresses can be used 

# Files

    iframe.php       PHP-Skript

# Note

The extension is potentially a security reason, since an external web page may contain malicious code.

The software is usable under the GNU General Public License, Version 3.0, for details see [LICENSE](LICENSE).
