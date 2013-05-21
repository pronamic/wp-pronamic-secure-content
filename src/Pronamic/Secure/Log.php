<?php

class Pronamic_Secure_Log {

	public static function access( WP_User $user, $content_id ) {
		$timezone_string = get_option( 'timezone_string' );
		
		// Current datetime
		$date = new DateTime();
		$date->setTimezone( new DateTimeZone( $timezone_string ) );
		
		// Get the object of the given content id
		$content_object = get_post( $content_id );
		
		self::log( 
			apply_filters( 
				'pronamic_secure_log_access', 
				sprintf( 
						__( 'User: %d %s accessed %s %s at %s', 'wp-pronamic-secure-content' ), 
						$user->ID, 
						$user->username, 
						$content_object->post_type, 
						$content_object->post_title, 
						$date->format( 'd-M-Y H:i:s' ) 
				) 
			) 
		);
		
	}
	
	public static function log( $message ) {
		$secure_content_log = get_option( 'pronamic_secure_content_log', array() );
		$secure_content_log[] = $message;
		update_option( 'pronamic_secure_content_log', $secure_content_log );
	}
	
}