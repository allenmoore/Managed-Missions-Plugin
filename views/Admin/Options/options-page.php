<div class="wrap">
	<form action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>" method="post">
		<?php
		settings_fields( $fields );
		do_settings_sections( $options );
		?>
		<p class="submit">
			<?php submit_button( 'Save Changes', 'primary', 'submit', false ); ?>
			<button type="reset" class="button button-secondary"><?php esc_html_e( 'Reset Changes', 'am-managed-missions' ); ?></button>
		</p>
	</form>
</div>
