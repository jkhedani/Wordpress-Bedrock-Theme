<?php

class MySettingsPage {

  /**
   * Holds the values to be used in the fields callbacks
   */
  private $options;

  /**
   * Start up
   */
  public function __construct() {
    add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    add_action( 'admin_init', array( $this, 'page_init' ) );
  }

  /**
   * Add options page
   */
  public function add_plugin_page() {
    // This page will be under "Settings"
    add_options_page(
      'Settings Admin', // <title> 
      'My Settings',  // Menu name
      'manage_options', // Permission required to edit
      'my-setting-admin', // Menu slug
      array( $this, 'create_admin_page' )
    );
  }

  /**
   * Options page callback
   */
  public function create_admin_page() {
    // Set class property
    $this->options = get_option( 'my_option_name' );
    ?>
    <div class="wrap">
      <h2>My Settings</h2>           
      <form method="post" action="options.php">
      <?php
          // This prints out all hidden setting fields
          settings_fields( 'my_option_group' );   
          do_settings_sections( 'my-setting-admin' );
          submit_button(); 
      ?>
      </form>
    </div>
    <?php
  }

  /**
   * Register and add settings
   */
  public function page_init() {        
      register_setting(
        'my_option_group', // Option group
        'my_option_name', // Option name
        array( $this, 'sanitize' ) // Sanitize
      );

      add_settings_section(
        'general_settings', // ID
        'My Custom Settings', // Title
        array( $this, 'print_section_info' ), // Callback
        'my-setting-admin' // Page
      );  

          add_settings_field(
            'site_mode', // ID
            'Site Mode', // Title 
            array( $this, 'site_mode_callback' ), // Callback
            'my-setting-admin', // Page
            'general_settings' // Section           
          );

		      add_settings_field(
		        'id_number', // ID
		        'ID Number', // Title 
		        array( $this, 'id_number_callback' ), // Callback
		        'my-setting-admin', // Page
		        'general_settings' // Section           
		      );      

		      add_settings_field(
		        'title', 
		        'Title', 
		        array( $this, 'title_callback' ), // Callback
		        'my-setting-admin', 
		        'general_settings'
		      );      
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function sanitize( $input ) {
    $new_input = array();
    if( isset( $input['site_mode'] ) )
        $new_input['site_mode'] = $input['site_mode'];

    if( isset( $input['id_number'] ) )
        $new_input['id_number'] = absint( $input['id_number'] );

    if( isset( $input['title'] ) )
        $new_input['title'] = sanitize_text_field( $input['title'] );

    return $new_input;
  }

  /** 
   * Print the Section text
   */
  public function print_section_info() {
    print 'Enter your settings below:';
  }

  /** 
   * Get the settings option array and print one of its values
   */
  public function site_mode_callback() {

    $devChecked = checked('development', $this->options['site_mode'], false);
    $prodChecked = checked('production', $this->options['site_mode'], false);

    printf(
      '<input type="radio" id="site_mode_1" name="my_option_name[site_mode]" value="%1$s" '. $devChecked .' />
       <label class="description" for="my_option_name[site_mode]">Development</label>
       <input type="radio" id="site_mode_2" name="my_option_name[site_mode]" value="%2$s" '. $prodChecked .' />
       <label class="description" for="my_option_name[site_mode]">Production</label>
       <p>Make sure your style.css file is properly compiled before switching to production.</p>',
      isset( $this->options['site_mode'] ) ? 'development' : '',
      isset( $this->options['site_mode'] ) ? 'production' : ''
    );
  }

  /** 
   * Get the settings option array and print one of its values
   */
  public function id_number_callback() {
    printf(
      '<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
      isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
    );
  }

  /** 
   * Get the settings option array and print one of its values
   */
  public function title_callback() {
    printf(
        '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
        isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
    );
  }
}

if ( is_admin() )
  $my_settings_page = new MySettingsPage();

?>