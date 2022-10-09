$(document).ready(function ($) {
  console.log("Delayed Iframe loading...");
  delay   = 0;
  iframes = document.querySelectorAll('iframe[id^="Iframe"]');
//  console.log(iframes);
  for (var i=0; i<iframes.length; i++) {
    iframeName = '#' + iframes[i].id;
// console.log(iframeName);
// for (var i = 1; ; i++) {
//   var iframeName = '#Iframe' + i;  
    if ($(iframeName).length) {
      if ($(iframeName).data('delay')) {
        console.log(iframeName + " = ", $(iframeName).data('src'));
        delay += 
        setTimeout(function(iframe) { $(iframe).attr('src', $(iframe).data('src')); },
                   delay, iframeName);
      }
    } else break;
  }
});
