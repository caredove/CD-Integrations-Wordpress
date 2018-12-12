<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://caredove.com
 * @since      0.1.0
 *
 * @package    Caredove
 * @subpackage Caredove/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <form action="options.php" method="post">
        <?php
            settings_fields( $this->plugin_name );
            do_settings_sections( $this->plugin_name );

            $api_test_results = Caredove_Admin::connect_to_api();

						if ($api_test_results->http_code == '200') {
							echo "<span style='color:green;font-weight:800;'>API Connected</span>";
						} else {
							echo "<span style='color:red;font-weight:600;'>Connection Error: ";
							print_r($api_test_results->http_code);
							print_r($api_test_results->response);
							echo "<span>";
						}

            submit_button();

    	  ?>    	  
				<!-- <input name="reset_all" type="button" value="Reset to default values" class="button" onclick="submit_form(this, document.forms['form'])" /> -->
    	   
    </form>
    <form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
        <input type="hidden" name="action" value="options_page_delete_transients">
        	<?php submit_button( 'Clear cache', 'delete', '', false ); ?>
		</form>

		<?php 

		// print_r(get_transient('caredove_listings')); 

		?>


</div>