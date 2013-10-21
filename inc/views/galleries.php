<?php wp_enqueue_media(); ?>
<div id="su-galleries-screen">
	<div id="su-galleries" data-delete-gallery-message="<?php _e( 'Are you sure that you want to delete this gallery? This action can\'t be undone!', $this->textdomain ); ?>" data-delete-image-message="<?php _e( 'Are you sure that you want to delete this image? This action can\'t be undone!', $this->textdomain ); ?>">
		<div id="su-galleries-actions">
			<a href="#" class="button su-gallery-create"><?php _e( 'Create new gallery', $this->textdomain ); ?></a>
		</div>
		<?php // echo '<pre>' . print_r( $settings, true ) . '</pre>'; ?>
		<?php
			// Prepare galleries
			$galleries = $settings[$option['id']];
			// Galleries are found
			if ( is_array( $galleries ) && count( $galleries ) ) {
				// Loop through galleries
				foreach ( $galleries as $id => $gallery ) {
					?>
					<div class="su-gallery" data-id="<?php echo $id; ?>">
						<div class="su-gallery-title">
							<strong><?php echo $id + 1; ?></strong>: <input type="text" value="<?php echo stripslashes( $gallery['name'] ); ?>" class="su-gallery-name" size="30" name="galleries[<?php echo $id; ?>][name]" placeholder="<?php _e( 'Enter gallery name', $this->textdomain ); ?>" />
							<span class="su-gallery-actions">
								<a href="#" class="su-gallery-open"><?php _e( 'Edit gallery', $this->textdomain ); ?></a>
								<a href="#" class="su-gallery-save-close"><?php _e( 'Save &amp; close', $this->textdomain ); ?></a>
								<a href="#" class="su-gallery-close"><?php _e( 'Close', $this->textdomain ); ?></a>
								<a href="#" class="su-gallery-delete"><?php _e( 'Delete', $this->textdomain ); ?></a>
							</span>
						</div>
						<div class="su-gallery-content">
							<div class="su-gallery-add-image"><a href="javscript:;" class="button button-primary button-large"><?php _e( 'Add images', 'su' ); ?></a></div>
							<?php
							if ( is_array( $gallery['items'] ) && count( $gallery['items'] ) )
								foreach ( $gallery['items'] as $item_id => $item ) {
									?>
									<div class="su-gallery-image">
										<span class="su-gallery-image-sort-handle"></span>
										<a href="<?php echo $item['image']; ?>" class="su-gallery-image-preview"><img src="<?php echo $item['image']; ?>" alt="" /></a>
										<div class="su-gallery-image-header">
											<a href="#" class="su-gallery-image-title"><?php echo stripslashes( $item['title'] ); ?></a>
											<span class="su-gallery-image-actions">
												<a href="#" class="su-gallery-image-open"><?php _e( 'Edit', $this->textdomain ); ?></a>
												<a href="#" class="su-gallery-image-delete"><?php _e( 'Delete', $this->textdomain ); ?></a>
											</span>
										</div>
										<div class="su-gallery-image-data">
											<label><?php _e( 'Title', $this->textdomain ); ?></label><br />
											<input type="text" value="<?php echo stripslashes( $item['title'] ); ?>" name="galleries[<?php echo $id; ?>][items][<?php echo $item_id; ?>][title]" class="su-gallery-image-title-value" data-field="title" /><br />
											<label><?php _e( 'Link', $this->textdomain ); ?></label><br />
											<input type="text" value="<?php echo stripslashes( $item['link'] ); ?>" name="galleries[<?php echo $id; ?>][items][<?php echo $item_id; ?>][link]" data-field="link" /><br />
											<input type="hidden" value="<?php echo $item['image']; ?>" class="su-gallery-image-image" name="galleries[<?php echo $id; ?>][items][<?php echo $item_id; ?>][image]" data-field="image" />
											<a href="#" class="button button-small su-gallery-image-ok"><?php _e( 'Close', $this->textdomain ); ?></a>
										</div>
									</div>
									<?php
								}
							?>
						</div>
					</div>
					<?php
				}
			}
			// Galleries not found
			else {
				?>
				<div id="su-galleries-not-found"><?php _e( 'Galleries not found', $this->textdomain ); ?></div>
				<?php
			}
		?>
	</div>
	<script type="text/html" id="su_new_gallery_template">
		<div class="su-gallery su-gallery-edit" data-id="{{:id}}">
			<div class="su-gallery-title">
				<strong>{{:id+1}}</strong>: <input type="text" value="" class="su-gallery-name" size="30" name="galleries[{{:id}}][name]" placeholder="<?php _e( 'Enter gallery name', $this->textdomain ); ?>" />
				<span class="su-gallery-actions">
					<a href="#" class="su-gallery-open"><?php _e( 'Edit gallery', $this->textdomain ); ?></a>
					<a href="#" class="su-gallery-save-close"><?php _e( 'Save &amp; close', $this->textdomain ); ?></a>
					<a href="#" class="su-gallery-close"><?php _e( 'Close', $this->textdomain ); ?></a>
					<a href="#" class="su-gallery-delete"><?php _e( 'Delete', $this->textdomain ); ?></a>
				</span>
			</div>
			<div class="su-gallery-content">
				<div class="su-gallery-add-image"><a href="javscript:;" class="button button-primary button-large"><?php _e( 'Add images', 'su' ); ?></a></div>
			</div>
		</div>
	</script>
	<script type="text/html" id="su_new_image_template">
		<div class="su-gallery-image">
			<span class="su-gallery-image-sort-handle"></span>
			<a href="{{:image}}" class="su-gallery-image-preview"><img src="{{:image}}" alt="" /></a>
			<div class="su-gallery-image-header">
				<a href="#" class="su-gallery-image-title">{{:title}}</a>
				<span class="su-gallery-image-actions">
					<a href="#" class="su-gallery-image-open"><?php _e( 'Edit', $this->textdomain ); ?></a>
					<a href="#" class="su-gallery-image-delete"><?php _e( 'Delete', $this->textdomain ); ?></a>
				</span>
			</div>
			<div class="su-gallery-image-data">
				<label><?php _e( 'Title', $this->textdomain ); ?></label><br />
				<input type="text" value="{{:title}}" name="galleries[{{:gallery_id}}][items][{{:id}}][title]" class="su-gallery-image-title-value" data-field="title" /><br />
				<label><?php _e( 'Link', $this->textdomain ); ?></label><br />
				<input type="text" value="{{:image}}" name="galleries[{{:gallery_id}}][items][{{:id}}][link]" data-field="link" /><br />
				<input type="hidden" value="{{:image}}" class="su-gallery-image-image" name="galleries[{{:gallery_id}}][items][{{:id}}][image]" data-field="image" />
				<a href="#" class="button button-small su-gallery-image-ok"><?php _e( 'Close', $this->textdomain ); ?></a>
			</div>
		</div>
	</script>
</div>