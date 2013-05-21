<?php echo $nonce; ?>
<p>
	<input id="pronamic_secure_enabled" type="checkbox" name="pronamic_secure_enabled" value="1" <?php if ( $pronamic_secure_enabled ) : ?> checked="checked" <?php endif; ?> />
	<label for="pronamic_secure_enabled"><?php _e( 'Secure enabled?', 'wp-pronamic-secure-content' ); ?></label>
</p>
<p>
	<label for="pronamic_secure_required_cap"><?php _e( 'Required cap', 'wp-pronamic-secure-content' ); ?></label>
	<input id="pronamic_secure_required_cap" type="text" name="pronamic_secure_required_cap" value="<?php echo $pronamic_secure_required_cap; ?>" />
</p>