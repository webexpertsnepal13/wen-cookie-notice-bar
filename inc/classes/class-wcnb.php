<?php
class WCNB {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wcnb_enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'wcnb_add_cookie_bar' ) );
	}

	public function wcnb_enqueue_scripts() {
		wp_enqueue_style( 'wcnb-style', WCNB_URL . 'assets/css/wen-cookie-notice-bar.css' );
		wp_enqueue_script( 'wcnb-script', WCNB_URL . 'assets/js/wen-cookie-notice-bar.js', array( 'jquery' ), null, true );
	}

	public function wcnb_add_cookie_bar() {
		if( get_option( 'wcnb_enabled' ) && !isset( $_COOKIE["wcnb_cookie"] ) ) {
			?>
		    <div id="wcnb-cookie-info">
	            <?php echo get_option( 'wcnb_message' ); ?>
	            <button type="button" onclick="setWCNB( 'wcnb_cookie', 'Accepted', 365 );"><?php echo get_option( 'wcnb_button_text' ); ?></button>
		    </div>
		    <?php
		}
	}

}
new WCNB();