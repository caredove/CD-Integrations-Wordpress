<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://caredove.com
 * @since      0.1.0
 *
 * @package    Caredove
 * @subpackage Caredove/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Caredove
 * @subpackage Caredove/admin
 * @author     Steedan Crowe <steedancrowe@gmail.com>
 */
class Caredove_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	0.1.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'caredove';

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the visual shortcode for the visual editor.
	 *
	 * @since    0.1.0
	 */

	public function visual_shortcode($options) {


		return $options;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Caredove_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Caredove_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name . 'visualshortcodes', plugin_dir_url( __FILE__ ) . 'css/buttons.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/caredove-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/caredove-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Registers the shortcode images script as a tinyMCE plugin.
	 *
	 * @since 0.1.0
	 * @param array $plugins An associative array of plugins
	 * @return array
	 */

	public function tmce_plugin($plugins) {
		$plugins['visualshortcodes'] = plugins_url('js/caredove-mce-placeholder.js', __FILE__);
		return $plugins;
	}


	/**
	 * Registers the vars for our caredove-mce-placeholder.js file.
	 *
	 *
	 * @since 0.1.0
	 * @param array $langs An associative array of objects
	 * @return array
	 */
	public function shortcode_config($string) {
			$popup = new stdClass();
			//Define the standard buttons (these can be overridden for a specific shortcode if desired)
			$popup->buttons = array(array ('text' => 'Cancel','onclick' => 'close'), array ('text' => 'Insert','onclick' => 'submit'));

			$caredove_booking_buttons = [];
			$caredove_booking_buttons[0]['value'] = '';
			$caredove_listing_categories = [];
			$caredove_api_listings = Caredove_Admin::get_api_listings($listings_options = '');
			$api_listings = json_decode($caredove_api_listings, true);
			$caredove_api_categories = Caredove_Admin::get_api_categories();
			$api_categories = json_decode($caredove_api_categories, true);

			if(isset($api_categories['results'])){
				$caredove_listing_categories[] = array('text' => 'All Categories', 'value' => '');
				foreach ($api_categories['results'] as $result){
						$caredove_listing_categories[] = array('text' => $result['display'].'('.$result['service_count'].')', 'value' => $result['id']);
				}
			}

			if(isset($api_listings['results'])){
				foreach ($api_listings['results'] as $result){
					if (isset($result['eReferral']['formUrl']) && $result['eReferral']['formUrl'] !== '' ){
						$caredove_booking_buttons[] = array('text' => $result['name'], 'value' => esc_url($result['eReferral']['formUrl']), 'classes' => 'caredove-booking-button-link ' . esc_url($result['eReferral']['formUrl']));
					}
				}
			}

			//these are the defaults for button_options we want included whenever there is buttons available
		    $popup->button_options[] = array(
              'type'=> 'textbox',
              'name'=> 'button_text',
              'label'=> 'Button Text',
              'tooltip'=> 'This will be used for the button text',
              'classes' => 'caredove_button_text caredove_hide-embedded'
            );
			$popup->button_options[] = array(
		    	'type'   => 'listbox',
				'name'   => 'button_style',
				'label'  => 'Button Style',
				'values' => [
					array( 'text'=> 'Theme Default', 'value'=> 'default', 'classes'=> 'optional caredove_button_color-hide caredove_text_color-hide caredove-style-default' ),
					array( 'text'=> 'Small - solid', 'value'=> 'solid-sm', 'classes'=> 'optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-solid-sm'),
					array( 'text'=> 'Medium - solid', 'value'=> 'solid-md', 'classes'=> 'optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-solid-md' ),
					array( 'text'=> 'Large - solid', 'value'=> 'solid-lg', 'classes'=> 'optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-solid-lg' ),
					array( 'text'=> 'Small - outlined', 'value'=> 'outline-sm', 'classes'=> 'optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-outline-sm' ),
					array( 'text'=> 'Medium - outlined', 'value'=> 'outline-md', 'classes'=> 'optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-outline-md' ),
					array( 'text'=> 'Large - outlined', 'value'=> 'outline-lg', 'classes'=> 'optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-outline-lg' ),
				],
				'classes' => 'caredove_button_style caredove_hide-embedded optional-control',
				'value' => 'default'
			);						
			$popup->button_options[] = array (
				'type'   => 'textbox',
				'name'   => 'button_color',
				'label'  => 'Button Color',
				'tooltip'=> 'Please use hex "#" color code',
				'classes' => 'caredove_button_color caredove_hide-default',
				'placeholder' => 'Enter Hex Code e.g., #00A4FF (default)'
					);
			$popup->button_options[] = array (
				'type'   => 'textbox',
				'name'   => 'text_color',
				'label'  => 'Text Color',
				'tooltip'=> 'Please use hex "#" color code',
				'classes' => 'caredove_text_color caredove_hide-default',
				'placeholder' => 'Enter Hex Code e.g., #FFFFFF (default)'
							);	
			$popup->button_options[] = array(
				'type'   => 'container',
				'name'   => 'button_style_hidden',
				'label'  => '',
				'html' => "<select class='caredove_button_style caredove_hide-embedded optional-control'>
						<option value='default' class='optional caredove_button_color-hide caredove_text_color-hide caredove-style-default'>Theme Default</option>
						<option value='solid-sm' class='optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-solid-sm'>Small - solid</option>
						<option value='solid-md' class='optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-solid-md'>Medium - solid</option>
						<option value='solid-lg' class='optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-solid-lg'>Large - solid</option>
						<option value='outline-sm' class='optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-outline-sm'>Small - outlined</option>
						<option value='outline-md' class='optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-outline-md'>Medium - outlined</option>
						<option value='outline-lg' class='optional caredove_button_color-show caredove_text_color-show caredove-sample-button-wrapper-show caredove-style-outline-lg'>Large - outlined</option>
				</select>",
				'hidden' => 'true',
				'classes' => ''
			);						  	 
			 $popup->logo = array(
			 				'type'=> 'container',
			 				'html'=> '<img src="'.plugins_url("img/Caredove-Logo.svg", __FILE__).'" />',
			 				'classes'=> 'caredove-tinymce-logo'
			 			);
			 $popup->button_sample = array(
							'type'=> 'container',
							'name'=> 'sample_button',
			 				'html'=> '<button class="caredove-sample-button caredove-iframe-button">Button Preview</button>',
			 				'classes'=> 'caredove-sample-button-wrapper caredove_hide-sample'
						 );
						 
		  //string is the array of shortcode options for the TinyMCE editor popup
			$string = array(
					//first shortcode 'caredove search'
					'0' => array (
					'shortcode' => 'caredove_search',
					'title'=> 'Add a Caredove Search Page',
		    	'image' => plugins_url("img/search-svg.svg", __FILE__),
		    	'command' => 'editImage',
		    	'buttons' => $popup->buttons,
		    	'popupbody' => [
		    		$popup->logo,
		    		array(
						    'type'=> 'container',
						    'html'=> '<p><strong>Add a Caredove search page to your website</strong><br /> These can be network search sites, or your organization\'s search site, <br />or even service listings pages. Read <a href="http://help.caredove.com/developer-integrations/add-caredove-to-your-wordpress-site" target="_blank">the tutorial</a> to learn more.</p>',
						    'classes'=> 'caredove-tinymce-description'
		    		),
            array(
              'type'=> 'textbox',
              'name'=> 'page_url',
              'label'=> 'Search Page URL',
              'tooltip'=> 'This is the Caredove URL of your search page',
              'classes'=> 'caredove-tinymce-page_url',
              'placeholder'=> ''
            ),
            array (
              'type'   => 'listbox',
              'values'  => [
              	 		array( 'text'=> 'Button opens popup window', 'value'=> 'modal', 'classes' => 'optional caredove_modal_title-show caredove_button_text-show caredove_button_style-show' ),
	                  array( 'text'=> 'Button opens link', 'value'=> 'link', 'classes' => 'optional caredove_modal_title-hide caredove_button_text-show caredove_button_style-show' ),
	                  array( 'text'=> 'Embedded in page', 'value'=> 'embedded', 'classes' => 'optional caredove_modal_title-hide caredove_button_text-hide caredove_button_color-hide caredove_text_color-hide caredove_button_style-hide' )
              ],
              'name'   => 'display_option',
              'label'  => 'Display Style',
              'classes' => 'optional-control',
							'value' => 'none'
						),
						array(
              'type'=> 'textbox',
              'name'=> 'button_text',
							'label'=> 'Button Text',
							'placeholder'=> 'Search (default)',
              'tooltip'=> 'This will be used for the button text',
              'classes' => 'caredove_button_text caredove_hide-embedded'
            ),$popup->button_options[1],$popup->button_options[2],$popup->button_options[3],$popup->button_options[4],
            array (
              'type'   => 'textbox',
              'name'   => 'modal_title',
              'label'  => 'Popup Window Title',
							'placeholder' => 'Search for Services (default)',
              'tooltip' => 'The title for the popup window, default: Search for Services',
              'classes' => 'caredove_modal_title caredove_hide-embedded caredove_hide-link',
            ),
            $popup->button_sample
          	]
					), //seccond shortcode 'caredove button'
					'1' => array (
						'shortcode' => 'caredove_button',
						'title' => 'Add a Caredove Refer Button',
						'image' => plugins_url("img/missing-field.svg", __FILE__),
						'command' => 'editImage',
						'buttons' => $popup->buttons,
						'popupbody' => [
							$popup->logo,
							array(
								'type'=> 'container',
								'html'=> '<p><strong>Add a Caredove refer/book button to your page</strong><br /> Enable submitting secure referrals to a specific service without leaving your website. <br />Read <a href="http://help.caredove.com/developer-integrations/add-caredove-to-your-wordpress-site" target="_blank">the tutorial</a> to learn more.</p>',
								'classes'=> 'caredove-tinymce-description'
							),
							array(
								'type'=> 'container',
								'name'=> 'sample_view_link',
								'html'=> '<a href="'.$caredove_booking_buttons[0]['value'].'" target="_blank" class="caredove-sample-view-link">view page</a>',
								'classes'=> 'caredove-sample-view-link'
							),
							array(
								'type'   => 'listbox',
								'name'   => 'page_url',
								'label'  => 'Service Listing',
								'values' => $caredove_booking_buttons,
								'value' => 'none'
							),
							array (
								'type'   => 'listbox',
								'values'  => [
											array( 'text'=> 'Button opens popup window', 'value'=> 'modal', 'classes' => 'optional caredove_modal_title-show caredove_button_text-show caredove_button_style-show' ),
											array( 'text'=> 'Button opens link', 'value'=> 'link', 'classes' => 'optional caredove_modal_title-hide caredove_button_text-show caredove_button_style-show' ),
								],
								'name'   => 'display_option',
								'label'  => 'Display Style',
								'classes' => 'optional-control',
								'value' => 'none',
							),
	            array (
	              'type'   => 'textbox',
	              'name'   => 'modal_title',
	              'label'  => 'Popup Window Title',
	              'placeholder'  => 'Book an Appointment (default)',
								'tooltip' => 'The title for the popup window, default: Book an Appointment',
								'classes' => 'caredove_modal_title caredove_hide-embedded caredove_hide-link',
	            ), array(
								'type'=> 'textbox',
								'name'=> 'button_text',
								'label'=> 'Button Text',
								'placeholder'=> 'Book Now (default)',
								'tooltip'=> 'This will be used for the button text',
								'classes' => 'caredove_button_text caredove_hide-embedded'
							),$popup->button_options[1],$popup->button_options[2],$popup->button_options[3],$popup->button_options[4],$popup->button_sample
			    	]
					), //third shortcode 'caredove listings'
					'2' => array ( //do we need Category options?
						'shortcode' => 'caredove_listings',
						'title' => 'Add Caredove Listings',
						'image' => plugins_url("img/listing-lists.svg", __FILE__),
						'button' => 'false',
		    		'command' => 'editImage',
		    		'buttons' => $popup->buttons,
		    		'popupbody' => [
		    			$popup->logo,
		    				array(
		    					'type'   => 'listbox',
                  'name'   => 'listing_categories',
                  'label'  => 'Listing Categories',
                  'values' => $caredove_listing_categories,
                  'value' => 'none'
              ),
			    		array(
	              'type'   => 'listbox',
	              'name'   => 'list_style',
	              'label'  => 'List Style',
	              'values' => [
	                  array( 'text'=> 'Full Width', 'value'=> 'full_width' ),
	                  array( 'text'=> '2 Column', 'value'=> '2-column' ),
	                  array( 'text'=> '3 Column', 'value'=> '3-column' )
	              ],
	              'value' => 'full_width'
	            ),
							array(
								'type' 	=> 'listbox',
								'name'	=> 'listings_per_page',
								'label' => 'Listings Per Page',
								'values' => [
									array( 'text'=> '10', 'value'=>'10'),
									array( 'text'=> '25', 'value'=>'25'),
									array( 'text'=> '50', 'value'=>'50'),
									array( 'text'=> '100', 'value'=>'100'),
								]
							),
							array(
								'type'=> 'textbox',
								'name'=> 'button_text',
								'label'=> 'Button Text',
								'tooltip'=> 'This will be used for the button text',
								'placeholder'=> 'Book Now (default)',
								'classes' => 'caredove_button_text caredove_hide-embedded'
							),$popup->button_options[1],$popup->button_options[2],$popup->button_options[3],$popup->button_options[4],$popup->button_sample
			    	]
					)

				);

			wp_localize_script( 'jquery', 'caredove_tinymce_options', $string);
	}


	//Reference: https://www.sitepoint.com/adding-a-media-button-to-the-content-editor/
	public function media_button_insert_search_page() {
		echo '<a href="#" id="insert-caredove-button" class="button caredove-admin-button">Add Caredove Refer Button</a>';
		echo '<a href="#" id="insert-caredove-listings" class="button caredove-admin-button">Add Caredove Listings</a>';
		echo '<a href="#" id="insert-caredove-search-page" class="button caredove-admin-button">Add Caredove Search Page</a>';
	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  0.1.0
	 */
	public function add_options_page() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Caredove Settings', 'caredove' ),
			__( 'Caredove', 'caredove' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Add ability to clear transients from option page
	 * @ since 0.1.10
	 */
	public function options_page_delete_transients() {
	  delete_transient( 'caredove_listings' );
	  // at the end redirect to target page
	  exit( wp_redirect( admin_url( 'options-general.php?page=caredove&cleared=true' ) ) );
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  0.1.0
	 */
	public function display_options_page() {
		include_once 'partials/caredove-admin-display.php';
	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  0.1.0
	 */
	public function register_setting() {

		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'caredove' ),
			array( $this, $this->option_name . '_general_options' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_api_username',
			__( 'API Username', 'caredove' ),
			array( $this, $this->option_name . '_api_username_field' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_username' )
		);

		add_settings_field(
			$this->option_name . '_api_password',
			__( 'API Password', 'caredove' ),
			array( $this, $this->option_name . '_api_password_field' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_password' )
		);

		add_settings_field(
			$this->option_name . '_api_org_id',
			__( 'Your Organization ID', 'caredove' ),
			array( $this, $this->option_name . '_api_org_id_field' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_org_id' )
		);

		add_settings_field(
			$this->option_name . '_api_testing',
			__( 'Testing', 'caredove' ),
			array( $this, $this->option_name . '_api_testing_field' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_testing' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_api_username', 'string' );
		register_setting( $this->plugin_name, $this->option_name . '_api_password', 'string' );
		register_setting( $this->plugin_name, $this->option_name . '_api_org_id', 'string' );
		register_setting( $this->plugin_name, $this->option_name . '_api_testing', 'boolean' );
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  0.1.0
	 */
	public function caredove_general_options() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'caredove' ) . '</p>';
	}
	/**
	 * Render the option page options
	 *
	 * @since  0.1.0
	 */
	public function caredove_api_username_field() {
		$api_username = get_option( $this->option_name . '_api_username' );
		echo '<input type="text" name="' . $this->option_name . '_api_username' . '" id="' . $this->option_name . '_api_username' . '" value="' . $api_username . '"> ' . __( 'get your API username from caredove.com', 'caredove' );
		}
	public function caredove_api_password_field() {
		$api_password = get_option( $this->option_name . '_api_password' );
		echo '<input type="password" name="' . $this->option_name . '_api_password' . '" id="' . $this->option_name . '_api_password' . '" value="' . $api_password . '"> ' . __( 'get your API password from caredove.com', 'caredove' );
	}
	public function caredove_api_org_id_field() {
		$api_org_id = get_option( $this->option_name . '_api_org_id' );
		echo '<input type="text" name="' . $this->option_name . '_api_org_id' . '" id="' . $this->option_name . '_api_org_id' . '" value="' . $api_org_id . '"> ' . __( 'get your organization ID from caredove.com', 'caredove' );
	}

		public function caredove_api_testing_field() {
		$api_testing = get_option( $this->option_name . '_api_testing' );
		if ($api_testing == "true"){
			$api_testing_status = "checked";
		}else{
			$api_testing_status = "";
		}
		echo '<input type="checkbox" name="' . $this->option_name . '_api_testing' . '" id="' . $this->option_name . '_api_testing' . '" value="true" ' . $api_testing_status . ' > ' . __( 'Use test connection at sandbox.caredove.com', 'caredove' );
	}

	static function connect_to_api($options) {

    	$caredove_api = new StdClass;
    	$api_username = get_option('caredove_api_username',array());
    	$api_password = get_option('caredove_api_password',array());
    	$api_org_id = get_option('caredove_api_org_id',array());
    	$api_testing = get_option('caredove_api_testing',array());

    	$api_auth = $api_username . ':' . $api_password;

    	if($api_testing == "true"){
    		$url_prefix = 'https://sandbox.';
    	} else {
    		$url_prefix = 'https://www.';
    	}

			$url = $url_prefix . $options['root_url'] . '?organization_id=' . $api_org_id . '&limit=100' . '&active=true';
			$args = array(
	    'headers' => array(
	        'Authorization' => 'Basic ' . base64_encode($api_auth)
			    )
			);

			//first check to see if all of the necesary fields are filled out
			if (strlen($api_username) == 0 || strlen($api_password) == 0 || strlen($api_org_id) == 0) {
				$caredove_api->http_code = 'please enter connection info';
			} else {
				//if all of the fields are filled, then proceed to conenct
				$response = wp_remote_get( $url, $args );
				$http_code = wp_remote_retrieve_response_code( $response );


				if($http_code == '200'){
					//if connection is good, get and set the data
					$caredove_api->data = wp_remote_retrieve_body( $response );
					$caredove_api->http_code = $http_code;
				} else {
					//if connection is bad, send error response to admin page
					$caredove_api->http_code = "something went wrong: " . $http_code . ' - ' . wp_remote_retrieve_response_message( $response );
					$caredove_api->response = $response;
				}
			}

			return $caredove_api;

	}

	static function get_api_listings($listing_options) {
			//https://gist.github.com/leocaseiro/455df1f8e1118cb8a2a2
			$listings = get_transient('caredove_listings');

			$options = array();
			$options['root_url'] = 'caredove.com/api/native_v1/Service/';
			$options['category_id'] = '';

			if(!empty($options['category_id'])){
				$category_listings = get_transeint('caredove_listings_category_'.$options['category_id']);
				if(empty($category_listings)){
					$caredove_api = Caredove_Admin::connect_to_api($options);
					set_transient('caredove_listings_category_'.$options['category_id'], $caredove_api->data, 60 * 10);
					$listings = $caredove_api->data;
				}
			} elseif(empty($listings)){
	    		$caredove_api = Caredove_Admin::connect_to_api($options);
	    		if(!empty($caredove_api->data)){
	    			set_transient('caredove_listings', $caredove_api->data, 60 * 10);
						$listings = $caredove_api->data;
	    		}

	    }

			return $listings;
	}

	public function get_api_categories() {

		$options = array();
		$options['root_url'] = 'caredove.com/api/native_v1/ServiceCategory/';

		$categories = get_transient('caredove_categories');

		if(empty($categories)){
    		$caredove_api = Caredove_Admin::connect_to_api($options);
    		if(!empty($caredove_api->data)){
    			set_transient('caredove_categories', $caredove_api->data, 60 * 10);
					$categories = $caredove_api->data;	
    		}
				
    }

		return $categories;

	}
}
