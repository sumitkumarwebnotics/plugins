jQuery(document).ready(function($){
    var checkboxestaxno = $('input[name="wpcf_customtaxnomoy[]"]');

	$(".wpcf_submit").click(function(){
		
		var $checkedtaxno = checkboxestaxno.filter(":checked"),
		checkedValuestaxno = $checkedtaxno.map(function () {
			return this.value;
		}).get();

		//alert(checkedValuestaxno);
		//alert("hello");
	
				$.ajax({
					url: ajaxurl,
					type: 'post',
					data: { action: 'wpcf_savedata', custom_taxnomoy:checkedValuestaxno},
					success: function(data) {
						alert(data);
						location.reload();
						
					}
				});
})
});

jQuery(document).ready(function() {
    jQuery(".wp-color-picker-field").wpColorPicker();

    jQuery("#add-color-field").click(function() {
        var container = jQuery("#color-fields-container");
        var index = container.children(".color-field").length;
        var newField = '<div class="color-field">';
        newField += '<input type="text" name="color_fields[' + index + ']" value="#ffffff" class="wp-color-picker-field" />';
        newField += '<button class="remove-color-field">Remove</button>';
        newField += '</div>';
        container.append(newField);

        jQuery(".wp-color-picker-field").wpColorPicker(); // Reinitialize color pickers
    });

    jQuery(document).on("click", ".remove-color-field", function() {
        jQuery(this).closest(".color-field").remove();
    });
});


