<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
         
        if (isset($_POST['wcpf_custom_fields']) && is_array($_POST['wcpf_custom_fields'])) {
            // Apply stripslashes to each field in the array and then sanitize
            $wcpf_custom_fields = array_map(function($field) {
                return sanitize_text_field(stripslashes($field));
            }, $_POST['wcpf_custom_fields']);
        } else {
            // Apply stripslashes and sanitize for single field case
            $wcpf_custom_fields = sanitize_text_field(stripslashes($_POST['wcpf_custom_fields']));
        }
 

        $existing_custom_fields = get_option('wcpf_custom_fields');

        if(is_array($existing_custom_fields)){
            $field_status=1;
            $wcpf_custom_fields['field_status']=$field_status;
        }
       

        $field_name_array = array();
        
        
        if( empty($existing_custom_fields) ){
                $wcpf_custom_fields = array($wcpf_custom_fields);
                if(update_option('wcpf_custom_fields',  $wcpf_custom_fields)){
                    $success_msg = "<div class='succss_msg'>Custom filed has been created successfully.</div>";
                  //  redirect_page();
                }
       }else{
                foreach($existing_custom_fields as $single_custom_fields){
                $field_name_array[]= $single_custom_fields['field_name'];
                }
                if (!in_array($wcpf_custom_fields['field_name'], $field_name_array)){
                   $existing_custom_fields[] = $wcpf_custom_fields;
                   update_option('wcpf_custom_fields', $existing_custom_fields);
                   $success_msg = "<div class='succss_msg'>Custom filed has been created successfully.</div>";
                   redirect_page();
                }else{
                  $success_msg = "<div class='error_msg'>Custom filed already exist!.</div>";
                  redirect_page();
                }
             
       }

    }
  

function redirect_page(){
    ?>
        <script>
            setTimeout(function() {
                window.location.href = '<?php echo admin_url('admin.php?page=all-custom-fields') ?>';
            }, 3000); 
        </script>
    <?php
}
?>

<div class="container max_700">
    <div class="row">
        <div class="col-md-12">
            <div class="add_new_fields" style="margin-top:30px">
                <h2><?= __("Add New Custom Field","woo-custom-filter-by-webnotics"); ?></h2>
                
                <form method="post" action="">
                    <div class="form-group field_name">
                        <label for="field_name">Field Name:</label>
                        <input type="text" id="field_name" name="wcpf_custom_fields[field_name]" class="form-control">
                    </div>
                    <div class="form-group  field_type">
                        <label for="field_type">Field Type:</label>
                        <select id="field_type" name="wcpf_custom_fields[field_type]" class="form-control">
                            <option>Select Type</option>
                            <option value="input">Input</option>
                            <option value="radio">Radio</option>
                            <option value="checkbox">Checkboxes</option>
                            <option value="dropdown">Dropdown</option>
                        </select>
                    </div>
                    <div class="field_input_type mt-3">
                        <div id="textarea-container" style="display: none;">
                            <label for="custom_textarea">Enter value:</label>
                            <textarea id="custom_textarea" class="form-control" name="wcpf_custom_fields[field_textarea_value]" placeholder="Enter value with seprate(,)" rows="4" cols="50" value="Test Color"></textarea>
                        </div>
                        <div id="input-container" style="display: none;">
                            <label for="custom_input">Enter value:</label>
                            <textarea id="custom_input" class="form-control" name="wcpf_custom_fields[field_input_value]" placeholder="Enter value"></textarea>
                        </div>
                    
                    </div>
                    <input type="submit" class="btn btn-primary button-primary mt-3" value="Save">
                </form>
                <div class="succerr_message mt-3"><?php if( !empty($success_msg) ){ echo $success_msg; } ?></div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#field_type').on('change',function(){
            if (jQuery(this).val() === 'input'){
                jQuery('#textarea-container').hide();
                jQuery('#input-container').show();
            }else {
                jQuery('#input-container').hide();
                jQuery('#textarea-container').show();
            }
        });
    });
</script>
