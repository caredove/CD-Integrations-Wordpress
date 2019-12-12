<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://caredove.com
 * @since      0.1.0
 *
 * @package    Caredove
 * @subpackage Caredove/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Caredove
 * @subpackage Caredove/public
 * @author     Steedan Crowe <steedancrowe@gmail.com>
 */
class Caredove_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/caredove-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-modaal', plugin_dir_url( __FILE__ ) . 'css/modaal.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/caredove-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-modaal', plugin_dir_url( __FILE__ ) . 'js/modaal.js', array( 'jquery' ), $this->version, false );

	}



  /**
	 * Regsiter the shortcodes
	 *
	 * @since 0.2.0
	 */
	public function register_shortcodes() {
		add_shortcode('caredove_listings', array($this, 'caredove_listings_shortcode'));
		add_shortcode('caredove_search', array($this, 'caredove_search_shortcode'));
		add_shortcode('caredove_button', array($this, 'caredove_button_shortcode'));

		wp_localize_script('jquery', 'customvars', array(
			'pluginurl' => plugin_dir_url( __FILE__ ),
		));

	}


	public function caredove_modal() {
		?>
<!-- 					<div class="caredove-modal">
				    <div class="caredove-modal-content">
				        <span class="caredove-modal-close">×</span>
				        	<iframe id="caredove-iframe" scrolling="yes" src=""></iframe>
				    </div>
					</div> -->
		<?php
	}

	//make the button function available, since it's used in more than one plance
	public function caredove_button($a) {
			$style_name = '';
			$style_inline = '';
			$style_class = '';
			$svg = '';

			$button_style = explode('-', $a['button_style']);
			foreach ($button_style as $value){
				$style_name .= 'caredove-button-'.$value.' ';
				switch($value){
					case 'outline':
						$style_inline = 'border-color:'.$a['button_color'].';';
						$style_inline .= 'color:'.$a['text_color'].';';
						$style_class = 'caredove-styled-button';
						break;
					case 'solid':
						$style_inline = 'background-color:'.$a['button_color'].';';
						$style_inline .= 'border-color:'.$a['button_color'].';';
						$style_inline .= 'color:'.$a['text_color'].';';
						$style_class = 'caredove-styled-button';
						break;
				}
			}

			$api_testing = get_option('caredove_api_testing',array());

			if($api_testing == "true"){
				$url_prefix = 'https://launch.sandbox.';
			} else {
				$url_prefix = 'https://launch.';
			}
			$pattern = '/^https?\:\/\/([^\/?#]+)(?:[\/?#]|$)/';
			$page_url = preg_replace($pattern, '', $a['page_url'] );
			$full_url = $url_prefix."caredove.com/".$page_url;

			// $svg = '<svg version="1.1" viewBox="0 0 142.358 24.582"><style>#search-path {stroke:'.$a['text_color'].';}</style><path id="search-path" fill="none" d="M131.597,14.529c-1.487,1.487-3.542,2.407-5.811,2.407c-4.539,0-8.218-3.679-8.218-8.218s3.679-8.218,8.218-8.218c4.539,0,8.218,3.679,8.218,8.218C134.004,10.987,133.084,13.042,131.597,14.529c0,0,9.554,9.554,9.554,9.554H0"/></svg>';
			// $svg = '<svg class="svg-icon" viewBox="0 0 20 20"><style>path{stroke:'.$a['text_color'].';}</style><path d="M18.125,15.804l-4.038-4.037c0.675-1.079,1.012-2.308,1.01-3.534C15.089,4.62,12.199,1.75,8.584,1.75C4.815,1.75,1.982,4.726,2,8.286c0.021,3.577,2.908,6.549,6.578,6.549c1.241,0,2.417-0.347,3.44-0.985l4.032,4.026c0.167,0.166,0.43,0.166,0.596,0l1.479-1.478C18.292,16.234,18.292,15.968,18.125,15.804 M8.578,13.99c-3.198,0-5.716-2.593-5.733-5.71c-0.017-3.084,2.438-5.686,5.74-5.686c3.197,0,5.625,2.493,5.64,5.624C14.242,11.548,11.621,13.99,8.578,13.99 M16.349,16.981l-3.637-3.635c0.131-0.11,0.721-0.695,0.876-0.884l3.642,3.639L16.349,16.981z"></path></svg>';
			$svg = '<svg class="svg-icon" viewBox="0 0 20 20"><path style="stroke:'.$a['text_color'].';" d="M18.125,15.804l-4.038-4.037c0.675-1.079,1.012-2.308,1.01-3.534C15.089,4.62,12.199,1.75,8.584,1.75C4.815,1.75,1.982,4.726,2,8.286c0.021,3.577,2.908,6.549,6.578,6.549c1.241,0,2.417-0.347,3.44-0.985l4.032,4.026c0.167,0.166,0.43,0.166,0.596,0l1.479-1.478C18.292,16.234,18.292,15.968,18.125,15.804 M8.578,13.99c-3.198,0-5.716-2.593-5.733-5.71c-0.017-3.084,2.438-5.686,5.74-5.686c3.197,0,5.625,2.493,5.64,5.624C14.242,11.548,11.621,13.99,8.578,13.99 M16.349,16.981l-3.637-3.635c0.131-0.11,0.721-0.695,0.876-0.884l3.642,3.639L16.349,16.981z"></path></svg>';
			if($a['display_option'] == 'link'){
		 		ob_start();
				?>
					<button type="button" onclick="window.open('<?php echo $full_url; ?>','_blank');" class="caredove-inline-link <?php echo $style_class?> <?php echo $style_name ?> <?php if($a['search_icon'] == 'true'){ echo 'caredove-button-with-icon';}?>" style="<?php echo $style_inline?>"><?php echo $a['button_text']; ?><?php if($a['search_icon'] == 'true'){ echo $svg; } ?></button>
				<?php
				return ob_get_clean();
		} else {
				ob_start();
				?>
				<button type="button" class="<?php echo $style_class?> caredove-iframe-button <?php echo $style_name ?> <?php if($a['search_icon'] == 'true'){ echo 'caredove-button-with-icon';}?>" data-modal-title="<?php echo $a["modal_title"]?>" href="<?php echo $full_url?>" style="<?php echo $style_inline?>"><?php echo $a['button_text']; ?><?php if($a['search_icon'] == 'true'){ echo $svg; } ?></button>
				<?php
				return ob_get_clean();
		}
	}

	public function caredove_search_shortcode($atts) {
				$a = shortcode_atts( array(
						'page_url' => '',
						'display_option' => 'false',
						'button_text' => 'Search',
						'button_color' => '',
						'text_color' => '',
						'button_style' => 'default',
						'modal_title' => 'Search for Services',
						'search_icon' => 'true',
						'iframe_height' => '900px'
				), $atts );
			 //in the future, we should strip out any unwanted characters, i.e. an extra forward slash that might be in the page_url value
			$api_testing = get_option('caredove_api_testing',array());

			if($api_testing == "true"){
				$url_prefix = 'https://launch.sandbox.';
			} else {
				$url_prefix = 'https://launch.';
			}

			 $iframe = '<iframe style="height:'.$a['iframe_height'].'" id="caredove-iframe" scrolling="yes" src="'.$url_prefix.'caredove.com/'.$a['page_url'].'?embed=1"></iframe>';

			 if($a['display_option'] == 'modal' || $a['display_option'] == 'false' || $a['display_option'] == 'link'){

						return $this->caredove_button($a);

			 } else {
			 		ob_start();
					echo $iframe;
					return ob_get_clean();
			 }

	}

	public function caredove_button_shortcode($atts) {
		$a = shortcode_atts( array(
				'page_url' => '',
				'display_option' => 'false',
				'button_text' => 'Book Now',
				'button_color' => '',
				'text_color' => '',
				'button_style' => 'default',
				'modal_title' => 'Book our Services',
				'search_icon' => 'false'
		), $atts );
		//in the future, we should strip out any unwanted characters, i.e. an extra forward slash that might be in the page_url value
		$iframe = '<iframe id="caredove-iframe" scrolling="yes" src="https://launch.caredove.com/'.$a['page_url'].'?embed=1"></iframe>';

		if($a['display_option'] == 'modal' || $a['display_option'] == 'false' || $a['display_option'] == 'link'){

					return $this->caredove_button($a);

		} else {
				ob_start();
				echo $iframe;
				return ob_get_clean();
		}

	}

	public function caredove_listings($api_object, $current_offset, $current_limit, $a){

		foreach ($api_object->results as $k => $result){
			if($k >= $current_offset && $k <= $current_limit){
							
					?>
						<div class="caredove-listing-item <?php echo ($result->details->description == null ? '1row' : '2row' ) ?>" style="background-color: <?php echo($a['listing_background_color']) ?>">
							<?php if($a['show_title'] == 'true'){ ?>
								<h3><?php echo $result->name; ?></h3>
							<?php } ?>								
							<?php if($a['show_description'] == 'true'){ ?>
								<p><?php echo $result->details->description; ?></p>
							<?php } ?>							
							<?php if($a['show_address'] == 'true'){ ?>
								<?php if(strlen($result->contact->addressText)){ ?>
									<p><?php echo "<strong>Address: </strong><br />".$result->contact->addressText; ?></p>
								<?php } ?>
							<?php } ?>							
							<?php if($a['show_phone'] == 'true'){ ?>
								<?php if(strlen($result->contact->inquiryPhone)){ ?>
									<p><?php echo "<strong>Phone #: </strong>".$result->contact->inquiryPhone; ?></p>
								<?php } ?>
							<?php } ?>							
							<?php if($a['show_tty'] == 'true'){ ?>
								<?php if(strlen($result->contact->tty)){ ?>
									<p><?php echo "<strong>TTY: </strong>".$result->contact->tty; ?></p>
								<?php } ?>
							<?php } ?>													
							<?php if($a['show_inquiry_email'] == 'true'){ ?>
								<?php if(strlen($result->contact->inquiryEmail)){ ?>
									<p><?php echo "<strong>Email: </strong>".$result->contact->inquiryEmail; ?></p>
								<?php } ?>
							<?php } ?>							
							<?php if($a['show_inquiry_fax'] == 'true'){ ?>
								<?php if(strlen($result->contact->fax)){ ?>
									<p><?php echo "<strong>Fax #: </strong>".$result->contact->fax; ?></p>
								<?php }?>
							<?php } ?>							
							<?php if($a['show_inquiry_hours'] == 'true'){ ?>
								<?php if(sizeof($result->details->availableTime) > 0){ ?>
									<p><strong>Available Hours:<br /></strong>
										<?php foreach($result->details->availableTime as $availableTime){
											$numberOfDays = sizeof($availableTime->daysOfWeek);
											$i = 0;
											foreach($availableTime->daysOfWeek as $days){
												$i+=1;
												echo $days;
												if($i !== $numberOfDays){
													echo ', ';
												}
											}
											echo '<br />';
											echo date("g:ia", strtotime($availableTime->availableStartTime));
											echo ' to ';
											echo date("g:ia", strtotime($availableTime->availableEndTime));

										} ?></p>
								<?php } ?>
							<?php } ?>							
							<?php $a['page_url'] = $result->eReferral->formUrl; ?>
							<?php echo $this->caredove_button($a); ?>
						</div>
					<?php				
			}
		}
	}

	public function caredove_listings_shortcode($atts) {

		$a = shortcode_atts( array(
				'listing_order' => 'ASC',
				'columns' => '1',
				'list_style' => 'full_width',
				'button_text' => 'Book Now',
				'button_color' => '',
				'button_style' => 'default',
				'text_color' => '',
				'modal_title' => 'Book an Appointment',
				'listing_categories' => '',
				'category_code' => '',
				'listing_background_color' => '#F7F7F7',
				'listings_per_page' => '6',
				'offest' => '0',
				'display_option' => 'false',
				'show_title' => 'true',
				'show_description' => 'true',
				'show_address' => 'false',
				'show_phone' => 'false',
				'show_tty' => 'false',
				'show_inquiry_email' => 'false',
				'show_inquiry_fax' => 'false',
				'show_inquiry_hours' => 'false',
				'search_icon' => 'false'
					
		), $atts );

  		$caredove_api_data = Caredove_Admin::get_api_listings($listing_options = '');

  	if(isset($caredove_api_data)){
	  		$api_object = json_decode($caredove_api_data);
	}
	
	$categories = json_decode(Caredove_Admin::get_api_categories());

	if($a['listing_categories'] !== ''){
		foreach($categories->results as $category){
			if($category->id == $a['listing_categories']){
				$a['category_code'] = $category->display;
			}
		}
	}	

	 	if ( isset($api_object->results) ) :

			if($a['category_code'] !== ''){
				foreach($api_object->results as $key => $theResult){
					if($theResult->category->display != $a['category_code']){						
						unset($api_object->results[$key]);
					}
				}
			}

			$max_num_pages = ceil(sizeof($api_object->results) / $a['listings_per_page']);
			$current_page = (get_query_var( 'paged' ) ? get_query_var( 'paged' ) : "1" );
			$current_offset = $current_page * $a['listings_per_page'] - $a['listings_per_page'];
			$current_limit = $current_offset + $a['listings_per_page'] - 1;
			// echo('max pages: '. $max_num_pages.'<br/>');
			// echo('offset: '. $current_offset.'<br/>');
			// echo('current limit'.$current_limit);
			ob_start();
			?><div class="caredove-listings caredove-listings-<?php echo $a['list_style'] ?>">
				<?php $this->caredove_listings($api_object, $current_offset, $current_limit, $a); ?>					
			</div><?php			

      	// Your loop

		// This is responsible for 1, 2, 3 pagination links. You can easily change this to previous and next links.
		if ( $max_num_pages > 1 ) :
			$big = 999999999;
			echo '<div class="pagination">';
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $max_num_pages
			) );
			echo '</div>';
		endif;
		return ob_get_clean();

  	endif;

	}

}
