 


<div class="container">
	<h4 class="pugin-heading">
        <?php esc_html_e( 'Welcome to my Product filter based on custom field and custom taxonomy for woocommerce.', 'woo-custom-filter-by-webnotics' ); ?>
    </h4>
	<div class="row wpcf_custom_field_and_taxanomy">
		
		<div class="col-md-6 wpcf_custom_field">
			<h3><?= __("All Custom Field","woo-custom-filter-by-webnotics"); ?></h3>
			<?php
			
				$wpcf_get_field_fetch_data = get_option( 'wcpf_custom_fields' );
				if(isset($wpcf_get_field_fetch_data) && is_array($wpcf_get_field_fetch_data)){
		
					foreach ($wpcf_get_field_fetch_data as $key => $wpcf__data) {
						?>
							<div class="toggle-container">
								<label class="wpcf_switch">
									<input data-key="<?php echo "$key" ?>" data-id = "<?php if($wpcf__data['field_status'] == 0){ echo '1'; }else{ echo '0'; } ?>" type="checkbox" class="wpcf_toggleCheckbox" <?php if( $wpcf__data['field_status'] == 0 ){ echo "checked"; } ?>>
									<span class="wpcf_slider wpcf_round"></span>
									<span class="wpcf__filedname"><?php echo $wpcf__data['field_name'];  ?></span>
								</label>
							</div>
							
						<?php 
					} 
				}
				
			?>
		</div>





		<div class="col-md-6 wpcf_taxnomony">
			<h3><?= __("All Taxnomony","woo-custom-filter-by-webnotics"); ?></h3>
			<?php 
				$wpcf_get_taxonomy_fetch_data = get_option( 'wcpf_custom_taxonomy' );
				if(isset($wpcf_get_taxonomy_fetch_data) && is_array($wpcf_get_taxonomy_fetch_data)){
		
					foreach ($wpcf_get_taxonomy_fetch_data as $key => $wpcf_taxonomy_data) {
						?>
							<div class="toggle-container">
								<label class="wpcf_switch">
									<input data-key="<?php echo "$key" ?>" data-id = "<?php if($wpcf_taxonomy_data['taxonomy_status'] == 0){ echo '1'; }else{ echo '0'; } ?>" type="checkbox" class="wpcf_taxnomony_toggleCheckbox" <?php if( $wpcf_taxonomy_data['taxonomy_status'] == 0 ){ echo "checked"; } ?>>
									<span class="wpcf_slider wpcf_round"></span>
									<span class="wpcf__filedname"><?php echo $wpcf_taxonomy_data['taxonomy_name'];  ?></span>
								</label>
							</div>
						<?php 
					} 
				}
			?>

          <h3><?= __("Woocommerce Category","woo-custom-filter-by-webnotics"); ?></h3>
		    <div class="toggle-container">
			<?php 
               $woo_cat = get_option('enable_filter_woo_cat');
			?>
								<label class="wpcf_switch_woo_cat">
								<input type="checkbox" data-id = "<?php if($woo_cat == 1){ echo '0'; }else{ echo '1'; } ?>" class="wpcf_woo_cat_checkbox" <?php if($woo_cat == 1 ){ echo "checked"; } ?>>
								<span class="wpcf_slider wpcf_round"></span>
									<span class="woo_cat_name">Categories</span>
								</label>
			</div>
		</div>	
		 		
	</div>
</div>						
