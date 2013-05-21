<?php

class Pronamic_Secure_Content {
	
	/**
	 * If the current page/post is
	 * secured
	 * 
	 * @access public
	 * @var boolean
	 */
	public $secure;
	
	public function __construct() {
		global $post;
		
		// Set the class properties
		$this->secure = get_post_meta( $post->ID, '_pronamic_secure_enabled', true );
		$this->required_cap = get_post_meta( $post->ID, '_pronamic_secure_required_cap', true );
	}
	
	/**
	 * Returns a boolean if the current
	 * page/post has been secured
	 * 
	 * @access public
	 * @return boolean
	 */
	public function is_secure() {
		return (bool) $this->secure;
	}
	
	/**
	 * Determines if the passed user has
	 * the required role to view the 
	 * secured content
	 * 
	 * @access public
	 * @param int $user_id
	 */
	public function has_access( $user_id ) {
		if ( ! is_user_logged_in() )
			return false;
		
		if ( ! isset( $this->required_cap ) )
			return false;
		
		// Get the users role
		$user = new WP_User( $user_id );
		
		return ( $user->has_cap( $this->required_cap ) );
	}
	
	/**
	 * Returns the required capability for this
	 * private content
	 * 
	 * @access public
	 * @return string
	 */
	public function get_required_cap() {
		return $this->required_cap;
	}
	
	
	
}