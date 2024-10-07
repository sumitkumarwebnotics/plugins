<div class="container">
    <div class="row">
        <div class="col-md-12">
        <div class="custom_field_list" >
            <h3><?= __("Taxonomies List","woo-custom-filter-by-webnotics"); ?></h3>
                <a href="<?php echo site_url() ?>/wp-admin/admin.php?page=add_new_custom_taxonomy"><button class="wcpf_add_new_custom_field">+ <?= __("Add New Taxonomy","woo-custom-filter-by-webnotics"); ?></button></a>
                <table class="table border">
                    <thead>
                        <tr>
                            <th scope="col">#</th>    
                            <th scope="col"><?= __("Taxonomy Name","woo-custom-filter-by-webnotics"); ?></th> 
                            <th scope="col" class="field_action"><?= __("Action","woo-custom-filter-by-webnotics"); ?></th>         
                            <!-- <th scope="col">Enable/Disable</th>      -->
                        </tr>
                        </thead>  
                    <tbody>
                        <?php  
                            $wcpf_taxonomy_fetch_data = get_option( 'wcpf_custom_taxonomy' );
                            // $checked = ($custom_field_fetch_data === '1') ? 'checked' : '';
                            $i=1;
                            
                            if(isset($wcpf_taxonomy_fetch_data) && is_array($wcpf_taxonomy_fetch_data)){
                            
                                foreach ( $wcpf_taxonomy_fetch_data as $key => $wcpf_get_data ) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?php echo $wcpf_get_data['taxonomy_name']; ?></td>
                                            <td><a class="wcpf_delete_link" data-name="<?php echo $key; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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

