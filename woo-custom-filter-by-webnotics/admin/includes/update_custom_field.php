<?php

$custom_field_fetch_data = get_option( 'wcpf_custom_fields' );
 
if ($custom_field_fetch_data && is_array($custom_field_fetch_data)) {
    if (isset($_GET['index']) && $_GET['index'] !== '') {
        $index_no = $_GET['index'];
        
        $edit_fields = $custom_field_fetch_data[$index_no];  
    }else{
        echo 'This field not exists!';
        return false;
    }
}

 
$success_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['wcpf_custom_fields']) && is_array($_POST['wcpf_custom_fields'])) {
        $wcpf_custom_fields = array_map('sanitize_text_field', $_POST['wcpf_custom_fields']);
    } else {
        // Handle the case where the input is not an array
        $wcpf_custom_fields = sanitize_text_field($_POST['wcpf_custom_fields']);
    }

    
    
    $field_name_array=array();
    $existing_custom_fields = get_option('wcpf_custom_fields');
;
    foreach($existing_custom_fields as $single_custom_fields){
                 $field_name_array[]= $single_custom_fields['field_name'];
    }
    
    if (in_array($wcpf_custom_fields['field_name'], $field_name_array)){
        foreach ($existing_custom_fields as &$field) { // Use & to update the array by reference
            if ($field['field_name'] === $wcpf_custom_fields['field_name']) {
                
                $field['field_type'] = $wcpf_custom_fields['field_type'];
                $field['field_textarea_value'] = stripslashes($wcpf_custom_fields['field_textarea_value']);
                $field['field_input_value'] = $wcpf_custom_fields['field_input_value'];
                $field['field_status'] = $wcpf_custom_fields['field_status'];
                break; 
            }
        }
         
        update_option('wcpf_custom_fields', $existing_custom_fields);
        $success_msg = "<div class='succss_msg'>Custom filed has been updated successfully.</div>";
        redirect_page();

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
                <h2>Update Custom Field</h2>
                
                <form method="post" action="">
                    <div class="form-group field_name">
                        <label for="field_name">Field Name:</label>
                        <input type="text" id="field_name" name="wcpf_custom_fields[field_name]" class="form-control" value="<?= $edit_fields['field_name']; ?>">
                    </div>
                    <div class="form-group  field_type">
                        <label for="field_type">Field Type:</label>
                        <select id="field_type" name="wcpf_custom_fields[field_type]" class="form-control">
                            <option>Select Type</option>
                            <option value="input" <?php if($edit_fields['field_type'] == 'input'){ echo 'selected'; } ?>>Input</option>
                            <option value="radio" <?php if($edit_fields['field_type'] == 'radio'){ echo 'selected'; } ?>>Radio</option>
                            <option value="checkbox" <?php if($edit_fields['field_type'] == 'checkbox'){ echo 'selected'; } ?>>Checkboxes</option>
                            <option value="dropdown" <?php if($edit_fields['field_type'] == 'dropdown'){ echo 'selected'; } ?>>Dropdown</option>
                        </select>
                    </div>
                    <div class="field_input_type mt-3">
                        <div id="textarea-container" <?php if($edit_fields['field_type'] == 'input'){ echo 'style="display: none;"'; } ?>>
                            <label for="custom_textarea">Enter value:</label>
                            <textarea id="custom_textarea" class="form-control" name="wcpf_custom_fields[field_textarea_value]" placeholder="Enter value with seprate(,)" rows="4" cols="50" value="Test Color"><?= $edit_fields['field_textarea_value']; ?></textarea>
                        </div>
                        <div id="input-container" <?php if($edit_fields['field_type'] !== 'input'){ echo 'style="display: none;"'; } ?>>
                            <label for="custom_input">Enter value:</label>
                            <textarea id="custom_input" class="form-control" name="wcpf_custom_fields[field_input_value]" placeholder="Enter value"<?= $edit_fields['field_input_value']; ?>></textarea>
                        </div>
                    
                    </div>
                    <input type="hidden" id="field_status" name="wcpf_custom_fields[field_status]" class="form-control" value="<?= $edit_fields['field_status']; ?>">
                    <input type="submit" class="btn btn-primary button-primary mt-3" value="Update">
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