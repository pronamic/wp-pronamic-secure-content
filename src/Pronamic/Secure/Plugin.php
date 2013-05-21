<?php

/**
 * Base plugin for Pronamic Secure Content
 * 
 * Handles most front end registrations and
 * assignments
 * 
 * @since 1.0.0
 * 
 * @author Leon Rowland <leon@rowland.nl>
 * 
 * @package Pronamic
 * @subpackage Secure
 * @version 1.0.0
 */
class Pronamic_Secure_Plugin {
	
	public function __construct() {
		// Intercept any access to a secure page
		add_action( 'template_redirect', array( $this, 'intercept' ) );
		
		// Overide the content and excerpt
		add_filter( 'the_content', array( $this, 'overide_content' ) );
		add_filter( 'the_excerpt', array( $this, 'overide_content' ) );
		
		add_shortcode( 'pronamic_secure_login_box', array( $this, 'shortcode_pronamic_secure_login_box' ) );
	}
	
	public function shortcode_pronamic_secure_login_box() {
		return wp_login_form( array( 'echo' => false ) );
	}
	
	
	/**
	 * Intercepts the base template redirect
	 * to determine if the page has been specified
	 * to be secured.
	 * 
	 * @hooked template_redirect
	 * 
	 * @actions before_pronamic_secure_plugin_intercept
	 * @actions after_pronamic_secure_plugin_intercept
	 * 
	 * @access public
	 * @return void
	 */
	public function intercept() {
		do_action( 'before_pronamic_secure_plugin_intercept' );
		
		global $post;
		
		if ( post_type_supports( $post->post_type, 'pronamic_secure_content' ) ) {
			global $pronamic_secure_content;
			$pronamic_secure_content = new Pronamic_Secure_Content();
			
			// If the post/page/cpt is secured and the current user cant access it
			if ( $pronamic_secure_content->is_secure() && ! $pronamic_secure_content->has_access( get_current_user_id() ) )
				// redirect to the saved login page setting
				wp_redirect( site_url( get_page_uri( Pronamic_Secure_Settings::get_login_page() ) ) );
			
			// Log access to this post/page/cpt
			Pronamic_Secure_Log::access( wp_get_current_user(), $post->ID );
		}
		
		do_action( 'after_pronamic_secure_plugin_intercept' );
	}
	
	/**
	 * Overides the_content and the_excerpt if the post
	 * 
	 * @global type $pronamic_secure_content
	 * @param type $the_content
	 * @return string
	 */
	public function overide_content( $the_content ) {
		// Make a new secure content class for this looped post
		$secure = new Pronamic_Secure_Content();
			
		// Check they have access
		if ( $secure->is_secure() && ! $secure->has_access( get_current_user_id() ) )
			$the_content = wpautop ( Pronamic_Secure_Settings::get_replacement_text() );

		
		return $the_content;
	}
	
}