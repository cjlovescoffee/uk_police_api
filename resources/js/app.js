window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

$(document).ready(function() {

  var header = $('body > header');
  var currentScrollPosition = $(window).scrollTop();

  $(window).on('load resize', function() {
    $(':root').css('--header-height', $('body > header').outerHeight());
  });

  $(window).scroll(_.throttle(headerHandler, 250));

  function headerHandler() {
    var updatedScrollPosition = $(window).scrollTop();
    var show = updatedScrollPosition > currentScrollPosition;
    header.toggleClass("show", !show);
    header.toggleClass("hide", show);
    currentScrollPosition = updatedScrollPosition;
  }

});
