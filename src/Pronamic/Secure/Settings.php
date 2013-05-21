<?php

class Pronamic_Secure_Settings {
	
	public static function get_replacement_text() {
		return get_option( 'pronamic-secure-content-replacement-text', '' );
	}
	
	public static function get_login_page() {
		return get_option( 'pronamic-secure-content-login-page' );
	}
}