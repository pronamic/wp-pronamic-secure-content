<?php

class Pronamic_Secure_Admin {
	
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		
		add_action( 'save_post', array( $this, 'save_secure_meta_box' ) );
		
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}
	
	public function register_settings() {
		register_setting( 'pronamic-secure-content-common', 'pronamic-secure-content-replacement-text' );
		register_setting( 'pronamic-secure-content-common', 'pronamic-secure-content-login-page' );
	}
	
	public function add_meta_boxes() {
		// Get all post types
		$post_types = get_post_types( '', 'names' );
		
		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'pronamic_secure_content' ) ) {
				
				add_meta_box( 
					'pronamic_secure_meta_box', 
					__( 'Pronamic Secure Content', 'wp-pronamic-secure-content' ),
					array( $this, 'view_secure_meta_box' ),
					$post_type,
					'side',
					'high'
				);
				
			}
		}
		
	}
	
	public function view_secure_meta_box( $post ) {
		global $wp_pronamic_secure_content;
		
		// Get existing secured value
		$pronamic_secure_enabled = get_post_meta( $post->ID, '_pronamic_secure_enabled', true );
		$pronamic_secure_required_cap = get_post_meta( $post->ID, '_pronamic_secure_required_cap', true );
		
		// Generate the nonce
		$nonce = wp_nonce_field( 'pronamic_secure', 'pronamic_secure_nonce', true, false );
		
		// Make the view
		$view = new Pronamic_Secure_View( $wp_pronamic_secure_content->plugin_path() . '/views' );
		$view
			->setVariable( 'nonce', $nonce )
			->setVariable( 'pronamic_secure_enabled', (bool) $pronamic_secure_enabled )
			->setVariable( 'pronamic_secure_required_cap', $pronamic_secure_required_cap )
			->setView( 'view_secure_meta_box' )
			->render();
		
	}
	
	public function save_secure_meta_box( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		
		if ( ! isset( $_POST['pronamic_secure_nonce'] ) )
			return;

		if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'pronamic_secure_nonce' ), 'pronamic_secure' ) )
			return;
		
		// Get the state of the meta box
		$pronamic_secure_enabled = filter_input( INPUT_POST, 'pronamic_secure_enabled', FILTER_VALIDATE_BOOLEAN );
		$pronamic_secure_required_cap = filter_input( INPUT_POST, 'pronamic_secure_required_cap', FILTER_SANITIZE_STRING );
		
		// Set or remove the enabled state conditionally
		if ( $pronamic_secure_enabled ) {
			update_post_meta( $post_id, '_pronamic_secure_enabled', $pronamic_secure_enabled );
		} else {
			delete_post_meta( $post_id, '_pronamic_secure_enabled' );
		}
		
		if ( $pronamic_secure_required_cap ) {
			update_post_meta( $post_id, '_pronamic_secure_required_cap', $pronamic_secure_required_cap );
		} else {
			delete_post_meta( $post_id, '_pronamic_secure_required_cap' );
		}
	}
	
	public function admin_menu() {
		add_options_page( 
			__( 'Pronamic Secure Content', 'wp-pronamic-secure-content' ), 
			__( 'Pronamic Secure Content', 'wp-pronamic-secure-content'), 
			'manage_options', 
			'pronamic-secure-content', 
			array( $this, 'view_pronamic_secure_content' ) 
		);
	}
	
	public function view_pronamic_secure_content() {
		global $wp_pronamic_secure_content;
		
		// Generate view
		$view = new Pronamic_Secure_View( $wp_pronamic_secure_content->plugin_path() . '/views' );
		$view
			->setView( 'view_pronamic_secure_content' )
			->render();
	}
}