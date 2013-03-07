<?php

/**
 * bedrock Action Hooks
 */

/**
 * Hook: bedrock_before
 * 
 * Located immediately after the <body> tag before anything else
 * in: header.php
 */
function bedrock_before() {
    do_action('bedrock_before');
}

/**
 * Hook: bedrock_aboveheader
 * 
 * Located immediately above the <header> tag
 * in: header.php
 */
function bedrock_aboveheader() {
    do_action('bedrock_aboveheader');
}

/**
 * Hook: bedrock_belowheader
 * 
 * Located immediately below the <header> tag
 * in: header.php
 */
function bedrock_belowheader() {
    do_action('bedrock_belowheader');
}

/**
 * Hook: bedrock_mainstart
 * 
 * Located directly after the #main tag before any content
 * in: header.php
 */
function bedrock_mainstart() {
    do_action('bedrock_mainstart');
}

/**
 * Hook: bedrock_contentstart
 * 
 * Located above all content, below the header and above the footer, on any page/post
 * in: page.php, single.php
 */
function bedrock_contentstart() {
    do_action('bedrock_contentstart');
}

/**
 * Hook: bedrock_abovepostcontent
 * 
 * Located above any post/page loop, below the breadcrumb,
 * in: page.php, single.php
 */
function bedrock_abovepostcontent() {
    do_action('bedrock_abovepostcontent');
}

/**
 * Hook: bedrock_postcontentstart
 * 
 * Located above the post/page title, inside the loop container,
 * in: content-page.php, content-single.php
 */
function bedrock_postcontentstart() {
    do_action('bedrock_postcontentstart');
}

/**
 * Hook: bedrock_abovetitle
 * 
 * Located above the post/page title, inside the loop container, below the module content.
 * in: content-page.php, content-single.php
 */
function bedrock_abovetitle() {
    do_action('bedrock_abovetitle');
}

/**
 * Hook: bedrock_belowtitle
 * 
 * Located directly below the post/page title, inside the loop container,
 * in: content-page.php, content-single.php
 */
function bedrock_belowtitle() {
    do_action('bedrock_belowtitle');
}

/**
 * Hook: bedrock_postcontentend
 * 
 * Located below the post/page content, inside the loop container,
 * in: content-page.php, content-single.php
 */
function bedrock_postcontentend() {
    do_action('bedrock_postcontentend');
}

/**
 * Hook: bedrock_belowpostcontent
 * 
 * Located below any post/page loop, after the "back to top" link,
 * in: page.php, single.php
 */
function bedrock_belowpostcontent() {
    do_action('bedrock_belowpostcontent');
}

/**
 * Hook: bedrock_contentend
 * 
 * Located below all content, below the header and above the footer, on any page/post
 * in: page.php, single.php
 */
function bedrock_contentend() {
    do_action('bedrock_contentend');
}

/**
 * Hook: bedrock_sidebarstart
 * 
 * Located above any sidebar content
 * in: sidebar.php
 */
function bedrock_sidebarstart() {
    do_action('bedrock_sidebarstart');
}

/**
 * Hook: bedrock_sidebarend
 * 
 * Located below sidebar content
 * in: sidebar.php
 */
function bedrock_sidebarend() {
    do_action('bedrock_sidebarend');
}

/**
 * Hook: bedrock_mainend
 * 
 * Located directly before the #main close tag after any content
 * in: footer.php
 */
function bedrock_mainend() {
    do_action('bedrock_mainend');
}

/**
 * Hook: bedrock_after
 * 
 * Located immediately before the <body> tag after anything else
 * in: footer.php
 */
function bedrock_after() {
    do_action('bedrock_after');
}


?>