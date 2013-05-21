<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php echo get_admin_page_title(); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'pronamic-secure-content-common' ); ?>
		<table class="form-table">
			<tr>
				<th><?php _e( 'Text used in replacement of secure post/pages', 'wp-pronamic-secure-content' ); ?></th>
				<td><?php wp_editor( Pronamic_Secure_Settings::get_replacement_text(), 'pronamic-secure-content-replacement-text' ); ?></td>
			</tr>
			<tr>
				<th><?php _e( 'Login Page', 'wp-pronamic-secure-content' ); ?></th>
				<td>
					<?php wp_dropdown_pages( array( 'name' => 'pronamic-secure-content-login-page', 'selected' => Pronamic_Secure_Settings::get_login_page() ) ); ?>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>