<?php 
class WCNB_Admin {

	function init() {
		add_action( 'admin_menu', array( $this, 'wcnb_admin_menu' ) );

		add_filter( 'plugin_action_links_wen-cookie-notice-bar/wen-cookie-notice-bar.php', array( $this, 'wcnb_action_setting_links' ) );
	}

	/*
	 * Setting link
	*/
	public function wcnb_action_setting_links( $links ) {
		(array) $links[] = '<a href="' . esc_url( admin_url( 'options-general.php?page=wen-cookie-notice-bar' ) ) . '">' . __( 'Settings', 'wen-cookie-notice-bar' ) . '</a>';
		return $links;
	}

	/*
	* create the admin menu
	*/
	public function wcnb_admin_menu() {
		add_options_page( __( 'Cookie Notice Bar', 'wen-cookie-notice-bar' ), __( 'Cookie Notice Bar', 'wen-cookie-notice-bar' ), 'manage_options', 'wen-cookie-notice-bar', array( $this, 'wcnb_settings_page' ) );
	}

	/*
	 * Setting Tabs 
	*/
	public function wcnb_settings_page() {
		if ( isset( $_POST['update_settings'] ) ) {
			$nonce = $_REQUEST['_wpnonce'];
			if ( !wp_verify_nonce( $nonce, 'wcnb-settings-nonce' ) ) {
				wp_die( 'Error: Nonce security check failed, please save the settings again.' );
			}
			update_option( 'wcnb_enabled', ( isset( $_POST["enable_cookie_bar"] ) && $_POST["enable_cookie_bar"] == '1' ) ? '1' : '0' );
			update_option( 'wcnb_message', wp_kses_post( $_POST["cookie_message"] ) );
			update_option( 'wcnb_button_text', sanitize_text_field( $_POST["button_text"] ) );

			echo $this->wcnb_notification();
		}
		?>
		<div class="wrap wcnb-wrap">
			<h1><?php _e( 'Cookie Notice Bar', 'wen-cookie-notice-bar' ); ?></h1>
			<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row"><?php _e( 'Enable Cookie Notice Bar', 'wen-cookie-notice-bar' ); ?></th>
							<td> 
								<fieldset>
									<legend class="screen-reader-text"><span><?php _e( 'Enable Cookie Notice Bar', 'wen-cookie-notice-bar' ); ?></span></legend>
									<label for="enable_cookie_bar">
										<input name="enable_cookie_bar" type="checkbox" id="enable_cookie_bar" <?php if ( get_option( 'wcnb_enabled' ) == '1' ) echo 'checked="checked"'; ?> value="1">
										<?php _e( 'Yes', 'wen-cookie-notice-bar' ); ?>
									</label>
									</fieldset>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Cookie Message', 'wen-cookie-notice-bar' ); ?></th>
							<td> 
								<fieldset>
									<legend class="screen-reader-text"><span><?php _e( 'Cookie Message', 'wen-cookie-notice-bar' ); ?></span></legend>
									<label for="content">
										<?php  
										$content = get_option( 'wcnb_message' );
										$settings = array( 'media_buttons' => false, 'textarea_rows' => 15, 'editor_height' => 250 );
									 	wp_editor( $content, 'cookie_message', $settings );
									 	?>
									</label>
								</fieldset>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="button_text"><?php _e( 'Button Text', 'wen-cookie-notice-bar' ); ?></label>
							</th>
							<td>
								<input name="button_text" type="text" id="button_text" value="<?php echo get_option( 'wcnb_button_text' ); ?>" class="regular-text">
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit">
					<?php wp_nonce_field( 'wcnb-settings-nonce' ); ?>
					<input type="submit" name="update_settings" id="update_settings" class="button button-primary" value="<?php _e( 'Save Changes', 'wen-cookie-notice-bar' ); ?>">
				</p>
			</form> 
		</div>
		<?php
	}

	/*
	 * Setting Tabs 
	*/
	public function wcnb_notification(){
		return	'<div id="message" class="updated fade"><p><strong>' . __( 'Settings saved!', 'wen-cookie-notice-bar' ) . '</strong></p></div>';
	}
}
