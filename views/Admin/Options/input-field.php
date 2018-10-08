<input type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $field ); ?>" id="<?php echo esc_attr( $field  ); ?>" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
<p class="description">
	<?php echo esc_html( $desc ); ?>
	<?php if ( isset( $example ) ) { ?>
		Ex: <code><?php echo esc_html( $example ); ?></code>
	<?php } ?>
</p>
