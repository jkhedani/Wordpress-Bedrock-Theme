<?php

/**
 * DCDC Action Hooks
 */

/**
 * Hook: dcdc_before
 * 
 * Located immediately after the <body> tag before anything else
 * in: header.php
 */
function dcdc_before() {
    do_action('dcdc_before');
}

/**
 * Hook: dcdc_aboveheader
 * 
 * Located immediately above the <header> tag
 * in: header.php
 */
function dcdc_aboveheader() {
    do_action('dcdc_aboveheader');
}

/**
 * Hook: dcdc_belowheader
 * 
 * Located immediately below the <header> tag
 * in: header.php
 */
function dcdc_belowheader() {
    do_action('dcdc_belowheader');
}

/**
 * Hook: dcdc_mainstart
 * 
 * Located directly after the #main tag before any content
 * in: header.php
 */
function dcdc_mainstart() {
    do_action('dcdc_mainstart');
}

/**
 * Hook: dcdc_contentstart
 * 
 * Located above all content, below the header and above the footer, on any page/post
 * in: page.php, single.php
 */
function dcdc_contentstart() {
    do_action('dcdc_contentstart');
}

/**
 * Hook: dcdc_abovepostcontent
 * 
 * Located above any post/page loop, below the breadcrumb,
 * in: page.php, single.php
 */
function dcdc_abovepostcontent() {
    do_action('dcdc_abovepostcontent');
}

/**
 * Hook: dcdc_postcontentstart
 * 
 * Located above the post/page title, inside the loop container,
 * in: content-page.php, content-single.php
 */
function dcdc_postcontentstart() {
    do_action('dcdc_postcontentstart');
}

/**
 * Hook: dcdc_postcontentend
 * 
 * Located below the post/page content, inside the loop container,
 * in: content-page.php, content-single.php
 */
function dcdc_postcontentend() {
    do_action('dcdc_postcontentend');
}

/**
 * Hook: dcdc_belowpostcontent
 * 
 * Located below any post/page loop, after the "back to top" link,
 * in: page.php, single.php
 */
function dcdc_belowpostcontent() {
    do_action('dcdc_belowpostcontent');
}

/**
 * Hook: dcdc_contentend
 * 
 * Located below all content, below the header and above the footer, on any page/post
 * in: page.php, single.php
 */
function dcdc_contentend() {
    do_action('dcdc_contentend');
}

/**
 * Hook: dcdc_sidebarstart
 * 
 * Located above any sidebar content
 * in: sidebar.php
 */
function dcdc_sidebarstart() {
    do_action('dcdc_sidebarstart');
}

/**
 * Hook: dcdc_sidebarend
 * 
 * Located below sidebar content
 * in: sidebar.php
 */
function dcdc_sidebarend() {
    do_action('dcdc_sidebarend');
}

/**
 * Hook: dcdc_mainend
 * 
 * Located directly before the #main close tag after any content
 * in: footer.php
 */
function dcdc_mainend() {
    do_action('dcdc_mainend');
}

/**
 * Hook: dcdc_after
 * 
 * Located immediately before the <body> tag after anything else
 * in: footer.php
 */
function dcdc_after() {
    do_action('dcdc_after');
}


?>