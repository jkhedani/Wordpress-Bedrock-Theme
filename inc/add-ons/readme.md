================================================

Add-ons
Description: An additional set of plugins, scripts,
styles etc. that can be included in your build.

================================================

=============================
Javascript
Inlcude these into the footer
to help increase page load.
=============================

<code>
  <script src="../assets/js/jquery.js"></script>
  <script src="../assets/js/bootstrap-transition.js"></script>
  <script src="../assets/js/bootstrap-alert.js"></script>
  <script src="../assets/js/bootstrap-modal.js"></script>
  <script src="../assets/js/bootstrap-dropdown.js"></script>
  <script src="../assets/js/bootstrap-scrollspy.js"></script>
  <script src="../assets/js/bootstrap-tab.js"></script>
  <script src="../assets/js/bootstrap-tooltip.js"></script>
  <script src="../assets/js/bootstrap-popover.js"></script>
  <script src="../assets/js/bootstrap-button.js"></script>
  <script src="../assets/js/bootstrap-collapse.js"></script>
  <script src="../assets/js/bootstrap-carousel.js"></script>
  <script src="../assets/js/bootstrap-typeahead.js"></script>
</code>

=============================
CSS
=============================

To add these css classes, include the appropriate files in the "less" folder and add "@import" calls in "dcdcBoostrap.less" to include them in the compile.

<code>

// Base CSS
@import "code.less";
@import "tables.less";

// Components: Common
@import "wells.less";

// Components: Buttons & Alerts
// @import "alerts.less"; // Note: alerts share common CSS with buttons and thus have styles in buttons.less

// Components: Popovers
//@import "modals.less";
//@import "tooltip.less";

// Components: Nav
@import "pagination.less";
@import "pager.less";

// Components: Misc
//@import "thumbnails.less";
//@import "labels-badges.less";
//@import "progress-bars.less";
//@import "accordion.less";
//@import "carousel.less";
//@import "hero-unit.less";
</code>