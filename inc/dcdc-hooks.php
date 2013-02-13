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
 * Hook: dcdc_mainfirst
 * 
 * Located directly after the #main tag before any content
 * in: header.php
 */
function dcdc_mainfirst() {
    do_action('dcdc_mainfirst');
}

/**
 * Hook: dcdc_contentfirst
 * 
 * Located above all content, below the header and above the footer, on any page/post
 * in: page.php, single.php
 */
function dcdc_contentfirst() {
    do_action('dcdc_contentfirst');
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
 * Hook: dcdc_postcontentfirst
 * 
 * Located above the post/page title, inside the loop container,
 * in: content-page.php, content-single.php
 */
function dcdc_postcontentfirst() {
    do_action('dcdc_postcontentfirst');
}

/**
 * Hook: dcdc_postcontentlast
 * 
 * Located below the post/page content, inside the loop container,
 * in: content-page.php, content-single.php
 */
function dcdc_postcontentlast() {
    do_action('dcdc_postcontentlast');
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
 * Hook: dcdc_contentlast
 * 
 * Located below all content, below the header and above the footer, on any page/post
 * in: page.php, single.php
 */
function dcdc_contentlast() {
    do_action('dcdc_contentlast');
}

/**
 * Hook: dcdc_sidebarfirst
 * 
 * Located above any sidebar content
 * in: sidebar.php
 */
function dcdc_sidebarfirst() {
    do_action('dcdc_sidebarfirst');
}

/**
 * Hook: dcdc_sidebarlast
 * 
 * Located below sidebar content
 * in: sidebar.php
 */
function dcdc_sidebarlast() {
    do_action('dcdc_sidebarlast');
}

/**
 * Hook: dcdc_mainlast
 * 
 * Located directly before the #main close tag after any content
 * in: footer.php
 */
function dcdc_mainlast() {
    do_action('dcdc_mainlast');
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