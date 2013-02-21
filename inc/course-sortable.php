<?php

// Create global sort page that sorts all course content (Units, Modules, and Lessons)
// http://soulsizzle.com/jquery/create-an-ajax-sorter-for-wordpress-custom-post-types/
function course_enable_global_sort() {
  // See: http://codex.wordpress.org/Function_Reference/add_menu_page
  $page_title = "Table of Contents";
  $menu_title = "Table of Contents";
  $capability = "edit_private_pages";
  $menu_slug  = "global-sort.php";
  $function   = "course_global_sort";
  $icon_url   = "div";
  $position   = "22.5";
  add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
}
add_action('admin_menu', 'course_enable_global_sort');


// Display function for global sort of all course content (Units, Modules, and Lessons)
function course_global_sort() {
  $units = new WP_Query(array(
    'post_type' => 'units',
    'post_status' => array('publish', 'private', 'draft', 'pending'),
    'posts_per_page' => '-1',
    'orderby' => 'menu_order',
    'order' => 'ASC',
  ));
?>
  <?php // Print table of contents ?>
  <div class="wrap">
    <h3>Sort Course Content <img src="<?php bloginfo('url'); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h3>
    <ul id="toc-units">
      <?php if ( !$units->have_posts()) : ?>
        <li id="unit-0">
          <span class='handle'>+</span>
          <?php course_global_sort_modules(0); ?>
        </li>
      <?php endif; ?>
      <?php foreach ($units->posts as $unit) : ?>
        <li id="<?php print $unit->ID; ?>">
          <span class='handle'>+</span>
          <span class='info'>Unit <span class='unit_order'><?php print $unit->menu_order; ?></span></span>:
          <?php print $unit->post_title; ?>
          <?php if (get_post_status($unit->ID) !== 'publish') : ?>
            <span class='warning right'>(Unpublished)</span>
          <?php endif; ?>
          <?php course_global_sort_modules($unit->ID); ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div><!-- End div#wrap //-->

  <?php // Print Modules bucket
  $modules = new WP_Query(array(
    'post_type' => 'modules',
    'post_status' => array('publish', 'private', 'draft', 'pending'),
    'posts_per_page' => '-1',
    'orderby' => 'menu_order',
    'order' => 'ASC',
  ));
  ?>
  <div class="wrap">
    <h3>Unattached Modules</h3>
    <ul id="toc-free-modules">
      <?php
      foreach ($modules->posts as $module):
        $connected = get_posts(array(
          'connected_type' => 'units_to_modules',
          'connected_items' => $module,
          'nopaging' => true,
          'suppress_filters' => false,
          'post_type' => 'modules',
          'post_status' => array('publish', 'private', 'draft', 'pending'),
          'posts_per_page' => '-1',
          'orderby' => 'menu_order',
          'order' => 'ASC',
        ));
      ?>
        <?php if (count($connected) < 1): ?>
          <li id="<?php print $module->ID; ?>">
            <span class='handle'>+</span>
            <span class='info'>Module <span class='module_order'><?php print $module->menu_order; ?></span></span>:
            <?php print $module->post_title; ?>
            <?php if (get_post_status($module->ID) !== 'publish') : ?>
              <span class='warning right'>(Unpublished)</span>
            <?php endif; ?>
            <span class='right detach detach-module'>x</span>
            <ul id="toc-module-<?php print $module->ID; ?>">
            </ul>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div><!-- End div#wrap //-->

  <?php // Print Lessons bucket
  $lessons = new WP_Query(array(
    'post_type' => 'lessons',
    'post_status' => array('publish', 'private', 'draft', 'pending'),
    'posts_per_page' => '-1',
    'orderby' => 'menu_order',
    'order' => 'ASC',
  ));
  ?>
  <div class="wrap">
    <h3>Unattached Lessons</h3>
    <ul id="toc-free-lessons">
      <?php
      foreach ($lessons->posts as $lesson):
        $connected = get_posts(array(
          'connected_type' => 'modules_to_lessons',
          'connected_items' => $lesson,
          'nopaging' => true,
          'suppress_filters' => false,
          'post_type' => 'lessons',
          'post_status' => array('publish', 'private', 'draft', 'pending'),
          'posts_per_page' => '-1',
          'orderby' => 'menu_order',
          'order' => 'ASC',
        ));
      ?>
        <?php if (count($connected) < 1): ?>
          <li id="<?php print $lesson->ID; ?>">
            <span class='handle'>+</span>
            <span class='info'>Lesson <span class='lesson_order'><?php print $lesson->menu_order; ?></span></span>:
            <?php print $lesson->post_title; ?>
            <?php if (get_post_status($lesson->ID) !== 'publish') : ?>
              <span class='warning right'>(Unpublished)</span>
            <?php endif; ?>
            <span class='right detach detach-lesson'>x</span>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div><!-- End div#wrap //-->
<?php
}



function course_global_sort_modules($unit_id) {
  $connected_modules = get_posts(array(
    'connected_type' => 'units_to_modules',
    'connected_items' => get_post($unit_id),
    'nopaging' => true,
    'suppress_filters' => false,
    'post_type' => 'modules',
    'post_status' => array('publish', 'private', 'draft', 'pending'),
    'posts_per_page' => '-1',
    'orderby' => 'menu_order',
    'order' => 'ASC',
  ));

  // Sort by menu_order (get_posts above doesn't seem to do it)
  $menu_order = array();
  foreach ($connected_modules as $key => $value) {
    $menu_order[$key] = $value->menu_order;
  }
  array_multisort($menu_order, SORT_ASC, $connected_modules);
?>
    <ul id="toc-unit-<?php print $unit_id; ?>">
      <?php foreach ($connected_modules as $module) : ?>
        <li id="<?php print $module->ID; ?>">
          <span class='handle'>+</span>
          <span class='info'>Module <span class='module_order'><?php print $module->menu_order; ?></span></span>:
          <?php print $module->post_title; ?>
          <?php if (get_post_status($module->ID) !== 'publish') : ?>
            <span class='warning right'>(Unpublished)</span>
          <?php endif; ?>
          <span class='right detach detach-module'>x</span>
          <?php course_global_sort_lessons($module->ID); ?>
        </li>
      <?php endforeach; ?>
    </ul>
<?php
}



function course_global_sort_lessons($module_id) {
  $connected_lessons = get_posts(array(
    'connected_type' => 'modules_to_lessons',
    'connected_items' => get_post($module_id),
    'nopaging' => true,
    'suppress_filters' => false,
    'post_type' => 'lessons',
    'post_status' => array('publish', 'private', 'draft', 'pending'),
    'posts_per_page' => '-1',
    'orderby' => 'menu_order',
    'order' => 'ASC',
  ));

  // Sort by menu_order (get_posts above doesn't seem to do it)
  $menu_order = array();
  foreach ($connected_lessons as $key => $value) {
    $menu_order[$key] = $value->menu_order;
  }
  array_multisort($menu_order, SORT_ASC, $connected_lessons);
?>
    <ul id="toc-module-<?php print $module_id; ?>">
      <?php foreach ($connected_lessons as $lesson) : ?>
        <li id="<?php print $lesson->ID; ?>">
          <span class='handle'>+</span>
          <span class='info'>Lesson <span class='lesson_order'><?php print $lesson->menu_order; ?></span></span>:
          <?php print $lesson->post_title; ?>
          <?php if (get_post_status($lesson->ID) !== 'publish') : ?>
            <span class='warning right'>(Unpublished)</span>
          <?php endif; ?>
          <span class='right detach detach-lesson'>x</span>
        </li>
      <?php endforeach; ?>
    </ul>
<?php
}



// Queue admin javascript for sorting all course content
function course_global_sortable_scripts() {
  global $pagenow;
  $pages = array("admin.php");
  if (in_array($pagenow, $pages)) {
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('course_global_sortable', get_bloginfo('template_url').'/inc/js/course_global_sortable.js');
  }
}
add_action('admin_print_scripts', 'course_global_sortable_scripts');



// Queue admin css for sorting custom post types
function course_global_sortable_styles() {
  //global $pagenow;
  //$pages = array("admin.php","index.php","edit.php");
  //if (in_array($pagenow, $pages)) {
    wp_enqueue_style('course_global_sortable', get_bloginfo('template_url').'/inc/css/course_global_sortable.css');
  //}
}
add_action('admin_print_styles', 'course_global_sortable_styles');





// Event handler: save new sort order after sorting Units
// http://wordpress.stackexchange.com/questions/23012/control-attachments-menu-order-with-jquery-sortable
function course_save_global_unit_order() {
  global $wpdb;
  $order = explode(',', $_POST['order']);
  $counter = 1;
  foreach ($order as $post_id) {
    $wpdb->update(
      $wpdb->posts, 
      array('menu_order' => $counter),
      array('ID' => $post_id)
    );
    $counter++;
  }
  die(1);
}
add_action('wp_ajax_course_update_global_sortable_unit', 'course_save_global_unit_order');

// Event handler: save new sort order after sorting Modules
// http://wordpress.stackexchange.com/questions/23012/control-attachments-menu-order-with-jquery-sortable
function course_save_global_module_order() {
//error_log("reordering modules: " . $_POST['parent_id']);
  global $wpdb;
  $order = explode(',', $_POST['order']);
  $priorModules = intval($_POST['priorModules']);
  $counter = 1 + $priorModules; // start numbering at next available if there is a previous unit with modules in it
  foreach ($order as $post_id) {
    $wpdb->update(
      $wpdb->posts, 
      array('menu_order' => $counter),
      array('ID' => $post_id)
    );
    $counter++;
  }
  die(1);
}
add_action('wp_ajax_course_update_global_sortable_module', 'course_save_global_module_order');

// Event handler: save new sort order after sorting Lessons
// http://wordpress.stackexchange.com/questions/23012/control-attachments-menu-order-with-jquery-sortable
function course_save_global_lesson_order() {
  global $wpdb;
  $order = explode(',', $_POST['order']);
  $counter = 1;
  foreach ($order as $post_id) {
    $wpdb->update(
      $wpdb->posts, 
      array('menu_order' => $counter),
      array('ID' => $post_id)
    );
    $counter++;
  }
  die(1);
}
add_action('wp_ajax_course_update_global_sortable_lesson', 'course_save_global_lesson_order');


// Event handler: p2p attach new Module
// http://wordpress.stackexchange.com/questions/23012/control-attachments-menu-order-with-jquery-sortable
function course_attach_global_sortable_module() {
  $module_id = $_POST['module_id'];
  $parent_id = str_replace("toc-unit-", "", $_POST['parent_id']);
  $old_parent_id = str_replace("toc-unit-", "", $_POST['old_parent_id']);
  p2p_type('units_to_modules')->disconnect($old_parent_id, $module_id);
  p2p_type('units_to_modules')->connect($parent_id, $module_id, array('date' => current_time('mysql')));
  die(1);
}
add_action('wp_ajax_course_receive_global_sortable_module', 'course_attach_global_sortable_module');

// Event handler: p2p attach new Lesson
// http://wordpress.stackexchange.com/questions/23012/control-attachments-menu-order-with-jquery-sortable
function course_attach_global_sortable_lesson() {
  $lesson_id = $_POST['lesson_id'];
  $parent_id = str_replace("toc-module-", "", $_POST['parent_id']);
  $old_parent_id = str_replace("toc-module-", "", $_POST['old_parent_id']);
  p2p_type('modules_to_lessons')->disconnect($old_parent_id, $lesson_id);
  p2p_type('modules_to_lessons')->connect($parent_id, $lesson_id, array('date' => current_time('mysql')));
  die(1);
}
add_action('wp_ajax_course_receive_global_sortable_lesson', 'course_attach_global_sortable_lesson');


// Event handler: p2p detach Module
// http://wordpress.stackexchange.com/questions/23012/control-attachments-menu-order-with-jquery-sortable
function course_detach_global_sortable_module() {
  $module_id = $_POST['module_id'];
  $old_parent_id = str_replace("toc-unit-", "", $_POST['old_parent_id']);
  p2p_type('units_to_modules')->disconnect($old_parent_id, $module_id);
  die(1);
}
add_action('wp_ajax_course_detach_global_sortable_module', 'course_detach_global_sortable_module');

// Event handler: p2p detach Lesson
// http://wordpress.stackexchange.com/questions/23012/control-attachments-menu-order-with-jquery-sortable
function course_detach_global_sortable_lesson() {
  $lesson_id = $_POST['lesson_id'];
  $old_parent_id = str_replace("toc-module-", "", $_POST['old_parent_id']);
  p2p_type('modules_to_lessons')->disconnect($old_parent_id, $lesson_id);
  die(1);
}
add_action('wp_ajax_course_detach_global_sortable_lesson', 'course_detach_global_sortable_lesson');

?>
