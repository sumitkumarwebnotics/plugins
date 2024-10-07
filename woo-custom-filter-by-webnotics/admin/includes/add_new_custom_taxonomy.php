<?php
if (isset($_POST['wcpf_submit_taxonomy'])) {
    
    $wcpf_taxonomy_name = sanitize_text_field(strtolower($_POST['wcpf_taxonomy_name']));
    $wcpf_taxonomy_status = 1;
    $single_taxonomy_name_array=array();
    $wcpf_get_taxonomy_array = get_option('wcpf_custom_taxonomy');
    foreach($wcpf_get_taxonomy_array as $single_taxonomy_name){
                     $single_taxonomy_name_array[]= $single_taxonomy_name['taxonomy_name'];
        }
    $arrayValue = array("taxonomy_name"=>$wcpf_taxonomy_name,"taxonomy_status"=>$wcpf_taxonomy_status);
    $wcpf_taxonomy_names = array();
    if( empty($wcpf_get_taxonomy_array) ){
        $wcpf_taxonomy_names[] = $arrayValue;
        update_option('wcpf_custom_taxonomy', $wcpf_taxonomy_names);
        $success_msg = "<div class='succss_msg'>Taxonomy has been created successfully.</div>";
      redirect_page();
    }else{
        if(!in_array($wcpf_taxonomy_name,$single_taxonomy_name_array)){
            $wcpf_get_taxonomy_array[] = $arrayValue;
            update_option('wcpf_custom_taxonomy', $wcpf_get_taxonomy_array);
            $success_msg = "<div class='succss_msg'>Taxonomy has been created successfully.</div>";
            redirect_page();
        }else{
             $success_msg = "<div class='error_msg'>Taxonomy already exist.</div>";
        }
    }
}
function redirect_page(){
    ?>
        <script>
            setTimeout(function() {
                window.location.href = '<?php echo admin_url('admin.php?page=all-taxonomies') ?>';
            }, 3000); 
        </script>
    <?php
}

?>

<!-- Add this code to your WordPress template or plugin file -->
<div class="container max_700 new-tax">
    <div class="row">
        <div class="col-md-12">
            <h2><?= __("Add New Taxonomy","woo-custom-filter-by-webnotics"); ?></h2>
            <form method="post">
                <div class="form-group">
                    <label for="wcpf_taxonomy_name">Taxonomy Name:</label>
                    <input type="text" name="wcpf_taxonomy_name" class="wcpf_taxonomy_name form-control" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="wcpf_submit_taxonomy btn btn-primary button-primary mt-3" value="Insert Taxonomy" name="wcpf_submit_taxonomy">
                </div>
            </form>
            <div class="succerr_message mt-3"><?php if( !empty($success_msg) ){ echo $success_msg; } ?></div>
        </div>
    </div>
</div>

