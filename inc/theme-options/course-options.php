<?php

// Create register for Custom Course Settings
function courses_customize_register($wp_customize) {

  // Custom Controls for Custom Course Settings
  class Customize_Textarea_Control extends WP_Customize_Control {
    public $type = 'textarea';
    public function render_content() {
      ?>
      <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
      </label>
      <?php
    }
  }


  // SECTIONS

  // SECTION: Course Description
  $wp_customize->add_section( 'courses_desc', array(
    'title'          => __( 'Course Description', 'courses' ),
    'priority'       => 31,
  ));

  // SECTION: Layouts
  $wp_customize->add_section( 'courses_layouts', array(
    'title'          => __( 'Layouts', 'courses' ),
    'priority'       => 35,
  ));
  
  // SECTION: Branding
  $wp_customize->add_section( 'courses_branding', array(
    'title'          => __( 'Branding', 'courses' ),
    'priority'       => 35,
  ));


  // SETTINGS

  // SETTING: Course Description
  $wp_customize->add_setting( 'courses_short_desc', array(
    'default'        => 'A short description/welcome piece for my new online course.',
    'transport'      => 'postMessage'
  ));
  
  // SETTING: Layout: IA
  $wp_customize->add_setting( 'courses_layout_ia', array(
    'default'        => 'modulesLessons',
    'transport'      => 'postMessage'
  ));

  // SETTING: Layout: Visual
  $wp_customize->add_setting( 'courses_layout_template', array(
    'default'        => 'singular',
    'transport'      => 'postMessage'
  ));

  // SETTING: Branding[College Affiliation]
  $wp_customize->add_setting( 'courses_branding_college_affil', array(
    'default'        => 'system',
    'transport'      => 'postMessage'
  ));
  // // SETTING: Branding[College Affiliation Color]
  // $wp_customize->add_setting( 'courses_branding_tint', array(
  //  'default'        => 'dark',
  //   'transport'      => 'postMessage'
  // ));


  // CONTROLS

  // CONTROL: Course Description
  $wp_customize->add_control( new Customize_Textarea_Control( $wp_customize, 'courses_short_desc', array(
    'label'      =>  __( 'Write a short course description', 'courses' ),
    'section'    => 'courses_desc',
    'settings'   => 'courses_short_desc'
  )));

  // CONTROL: Layout: IA
  $wp_customize->add_control( 'courses_layouts_ia', array(
    'label'      => __( 'Select a Course Layout', 'courses' ),
    'section'    => 'courses_layouts',
    'settings'   => 'courses_layout_ia',
    'type'       => 'radio',
    'choices'    => array(
      'modulesLessons' => 'Modules & Lessons',
      'unitsModulesLessons' => 'Units, Modules & Lessons',
    ),
  ));

  // CONTROL: Layout: Visual
  $wp_customize->add_control( 'courses_layouts_visual', array(
    'label'      => __( 'Select a Course Layout', 'courses' ),
    'section'    => 'courses_layouts',
    'settings'   => 'courses_layout_template',
    'type'       => 'radio',
    'choices'    => array(
      'singular' => 'Single Module Layout',
      'nested' => 'Modules With Nested Lessons Layout',
      'custom' => 'Custom Layout',
    ),
  ));

  // CONTROL: Branding
  $wp_customize->add_control( 'courses_branding_affil', array(
    'label'      => __( 'Select Your Affiliated College', 'courses' ),
    'section'    => 'courses_branding',
    'settings'   => 'courses_branding_college_affil',
    'type'       => 'radio',
    'choices'    => array(
      'system' => 'UH System',
      'manoa' => 'UH Manoa',
      'hcc' => 'Honolulu Community College',
    ),
  ));

  // // CONTROL: Branding
  // $wp_customize->add_control( 'courses_branding_tint', array(
  //   'label'      => __( 'Select a Tint', 'courses' ),
  //   'section'    => 'courses_branding',
  //   'settings'   => 'courses_branding_tint',
  //   'type'       => 'radio',
  //   'choices'    => array(
  //     'dark' => 'Dark',
  //     'light' => 'Light',
  //   ),
  // ));
}
add_action( 'customize_register', 'courses_customize_register' );


// Biting TwentyEleven: Add Layout options to body class
function courses_layout_classes( $existing_classes ) {
  $current_ia = get_theme_mod('courses_layout_ia');
  $current_layout = get_theme_mod('courses_layout_template');

  if('modulesLessons' == $current_ia)
    $classes[] = 'modules-lessons';
  elseif('unitsModulesLessons' == $current_ia)
    $classes[] = 'units-modules-lessons';

  if('singular' == $current_layout)
    $classes[] = 'single-layout';
  elseif('nested' == $current_layout)
    $classes[] = 'nested-layout';
  elseif('custom' == $current_layout)
    $classes[] = 'custom-layout';
  else
    $classes[] = 'single-layout';

  $classes = apply_filters( 'courses_layout_classes', $classes, $current_layout, $current_ia );
  return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'courses_layout_classes' );


// Add Classes to #college-branding
// function courses_layout_classes( $existing_classes ) {
//  $options = get_option('courses_theme_options');
//  $current_layout = $options['layout'];

//  if('singular' == $current_layout)
//    $classes[] = 'single-layout';
//  elseif('nested' == $current_layout)
//    $classes[] = 'nested-layout';
//  elseif('custom' == $current_layout)
//    $classes[] = 'custom-layout';
//  else
//    $classes[] = 'single-layout';

//  $classes = apply_filters( 'courses_layout_classes', $classes, $current_layout );
//  return array_merge( $existing_classes, $classes );
// }
// add_action('footerCredits','addFooterCredits');


// Add "Customize" to main menu
function themedemo_admin() {
  // Add the Customize link to the admin menu and call if Course Options
  add_theme_page( 'Course Options', 'Course Options', 'edit_theme_options', 'customize.php' );
}
add_action ('admin_menu', 'themedemo_admin');


// Enqueue instant preview javascript
function twentyeleven_customize_preview_js() {
  wp_enqueue_script( 'courses-customizer', get_template_directory_uri() . '/inc/theme-options/theme-instant-preview-options.js', array( 'customize-preview' ), '20120523', true );
}
add_action( 'customize_preview_init', 'twentyeleven_customize_preview_js' );

?>
