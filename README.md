# Purpose

The extension allows in a MediWiki the embedding of foreign web pages via an `iframe`.

# Usage

`<iframe k="rstudio" p="page" w="800" h="600" />`

The parameters `w`, `h` and `allowfullscreen` are optional. The final URL is `http://shiny.rstudio.com/page`, composed of the value in `$wgIframeUrl` for the key `rstudio` and `p`.

# Installation

* Go to the extensions directory of your MediaWiki installation.
* Clone the extension from github by `git clone https://github.com/sigbertklinke/Iframe`
* Edit your `LocalSettings.php` and add at the end `wfLoadExtension( 'Iframe' );`
* The global variable `$wgIframe` controls which defaults are used (web address, sizes etc.)  

# Note

The extension is potentially a security reason, since an external web page may contain malicious code.

The software is usable under the GNU General Public License, Version 3.0, for details see [LICENSE](LICENSE).

# History

2021-06-27 Adapted to MediaWiki 1.36.1, v 0.09
