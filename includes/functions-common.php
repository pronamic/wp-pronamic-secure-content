<?php

/**
 * Used to determine if the current page is
 * a requested secure page
 * 
 * @global Pronamic_Secure_Content $pronamic_secure_content
 * @return boolean
 */
function is_pronamic_secure_content() {
	global $pronamic_secure_content;
	
	if ( ! Pronamic_Secure_Content instanceof $pronamic_secure_content )
		return false;
	
	return ( $pronamic_secure_content->is_secure() );
}

/**
 * Used to determine if the passed user_id has
 * access to the secure content
 * 
 * @global Pronamic_Secure_Content $pronamic_secure_content
 * @param int $user_id
 * @return boolean
 */
function user_can_access_pronamic_secure_content( $user_id ) {
	global $pronamic_secure_content;
	
	return ( $pronamic_secure_content->has_access( $user_id ) );
}

/**
 * Used to determine if the current user has
 * access to the secure content
 * 
 * @global Pronamic_Secure_Content $pronamic_secure_content
 * @return boolean
 */
function current_user_can_access_pronamic_secure_content() {
	global $pronamic_secure_content;
	
	return ( $pronamic_secure_content->has_access( get_current_user_id() ) );
}