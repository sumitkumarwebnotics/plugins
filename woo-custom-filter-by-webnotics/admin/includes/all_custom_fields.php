<div class="container">
    <div class="row">
        <div class="col-md-12">
        <div class="custom_field_list" >
            <h3><?= __("Custom Field List","woo-custom-filter-by-webnotics"); ?></h3>
                <a href="<?php echo site_url() ?>/wp-admin/admin.php?page=add_new_custom_field"><button class="wcpf_add_new_custom_field">+ <?= __("Add New Custom Field","woo-custom-filter-by-webnotics"); ?></button></a>
                <table class="table border">
                    <thead>
                        <tr>
                            <th scope="col">#</th>    
                            <th scope="col"><?= __("Field Name","woo-custom-filter-by-webnotics"); ?></th>  
                            <th scope="col"><?= __("Field Type","woo-custom-filter-by-webnotics"); ?></th>  
                            <th scope="col" class="field_action"><?= __("Action","woo-custom-filter-by-webnotics"); ?></th>         
                            <!-- <th scope="col">Enable/Disable</th>      -->
                        </tr>
                        </thead>  
                    <tbody>
                        <?php  
                            $custom_field_fetch_data = get_option( 'wcpf_custom_fields' );
                            // echo '<pre>';
                            // print_r($custom_field_fetch_data);
                            // echo '</pre>';
                            // $checked = ($custom_field_fetch_data === '1') ? 'checked' : '';
                            $i=1;
                            
                            if(isset($custom_field_fetch_data) && is_array($custom_field_fetch_data)){
                            
                                foreach ($custom_field_fetch_data as $key => $fetch) {
                                  
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?php echo $fetch['field_name'];  ?></td>
                                            <td><?= $fetch['field_type'];  ?></td>
                                            <td><a href="<?php echo admin_url('admin.php?page=update_value_custom_field&index=').$key; ?>" class="custom-options-update-link" data-index="<?php echo $key; ?>" data-option-name="custom_option_name"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a href="#" class="custom-options-delete-link" data-index="<?php echo $key; ?>" data-option-name="custom_option_name"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                        </tr>       
                                    <?php 
                                    $i++; 
                                } 
                            }  
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
