jQuery(function ($) {
  jQuery("#add-new-color-field").on("click", function () {
    var newColorField =
      '<p class="form-field"><label for="new_color">New Color</label><input type="color" name="new_colors[]"><span class="remove-color-field">Remove</span></p>';
    jQuery("#woocommerce-product-data")
      .find(".options_group.pricing")
      .before(newColorField);
  });

  // Remove dynamically added color fields
  jQuery("#woocommerce-product-data").on(
    "click",
    ".remove-color-field",
    function () {
      jQuery(this).parent().remove();
    }
  );
});

//  Start jquery for shop filter using ajax

jQuery(document).ready(function () {
  jQuery(".fltr_btn").show();
  jQuery(".filter_id").on("click", function (e) {
    e.preventDefault();
    var customfieldArray = [];
    var taxonomyArray = [];

    jQuery(".filter_loader").show();
    jQuery(".fltr_btn").hide();

    jQuery("#toggleDiv").css("display", "none");
    // Iterate through form1 elements and extract data
    jQuery(
      '.custom_field_form input[type="text"], .custom_field_form select, .custom_field_form input[type="radio"]:checked'
    ).each(function () {
      var input = jQuery(this);
      customfieldArray.push({
        name: input.attr("name"),
        value: input.val(),
      });
    });

    jQuery('.taxonomy_form input[type="checkbox"]:checked').each(function () {
      var input = jQuery(this);
      taxonomyArray.push({
        name: input.data("taxonomy_name"),
        value: input.val(),
      });
    });
    var orderby = jQuery("input[name=orderby]").val();
    var page_number = jQuery("input[name=page_number]").val();
    var search_keyword = jQuery("input[name=search_keyword]").val();
    var min_price = jQuery("input[name=min_price]").val();
    var max_price = jQuery("input[name=max_price]").val();
    var rating = jQuery('input[name="rating"]:checked').val();
    var checkboxValuescustom_field = {};
    var selectedtagsValues = jQuery('select[name="tags[]"]').val();
    // Iterate over each checkbox group by name
    jQuery('.custom_field_form input[type="checkbox"]').each(function () {
      var checkboxName = jQuery(this).attr("name"); // Get the name attribute
      if (!checkboxValuescustom_field[checkboxName]) {
        checkboxValuescustom_field[checkboxName] = []; // Initialize an empty array for this name
      }
      if (jQuery(this).is(":checked")) {
        checkboxValuescustom_field[checkboxName].push(jQuery(this).val()); // Add the checked value to the array
      }
    });
    jQuery("#fullscreen-wcpfloader").css("display","flex");
    jQuery.ajax({
      type: "POST",
      url: ajax_object.ajax_url,
      data: {
        action: "wcpf_product_filter_by_cstm",
        customfieldArray: customfieldArray,
        taxonomyArray: taxonomyArray,
        orderby: orderby,
        security: ajax_object.ajax_nonce,
        checkboxValuescustom_field: checkboxValuescustom_field,
        page_number: page_number,
        search_keyword:search_keyword,
        min_price:min_price,
        max_price:max_price,
        rating:rating,
        tags:selectedtagsValues
      },
      success: function (result) {
        jQuery("#fullscreen-wcpfloader").css("display","none");
        jQuery(".wcpf_main_content").html(result.result);
        jQuery(".filter_loader").hide();
        jQuery(".wcpf_pagination_show").hide();
        jQuery(".fltr_btn").show();
        jQuery(".page__number").val(1);
        jQuery(".close").trigger('click');
      },
    });
  });

  //jQuery('.filter_id').prop('disabled', true);
  jQuery(".wcpf_select_size,.wcpf_select_radio_btn,.child_cat_check").on(
    "change",
    function () {
      var select_data = jQuery(this).val();
      if (select_data !== null && select_data !== "") {
        jQuery(".filter_id").prop("disabled", false);
      }
    }
  );

  jQuery(".wcpf_select_size,.wcpf_select_radio_btn").on("change", function () {
    var select_data = jQuery(this).val();
    if (select_data !== null && select_data !== "") {
      jQuery(".filter_id").prop("disabled", false);
    }
  });
});

/*  Update Option  */

jQuery(document).ready(function () {
  jQuery(".fa-eye,.fa-eye-slash").click(function () {
    //jQuery(this).toggleClass("fa-eye-slash");

    var keyVal = jQuery(this).closest("a").data("id");
    var keyNAme = jQuery(this).closest("a").data("key");
    // alert(val);
    updateOption(keyNAme, keyVal);
  });
});

/*  Update Option  */

function updateOption(keyNAme, keyVal) {
  jQuery.ajax({
    type: "POST",
    url: ajax_object.ajax_url,
    data: {
      action: "update_custom_field_option",
      option_name: keyNAme,
      value: keyVal,
    },
    success: function (response) {
      // Handle success or error here
      console.log(response);
      // alert("Custom field Disable successfully!");
      location.reload();
    },
  });
}

/* For Delete Taxonomy  */

jQuery(document).ready(function () {
  jQuery(".wcpf_delete_link").on("click", function () {
    var data_name = jQuery(this).attr("data-name");

    if (confirm("Are you sure want to delete this item?")) {
      var thisVar = jQuery(this);
      thisVar.text("Processing");
      jQuery.ajax({
        type: "POST",
        url: ajax_object.ajax_url,
        data: {
          action: "wcpf_delete_taxonomy",
          data_name: data_name,
        },
        success: function (response) {
          thisVar.text("Deleted successfully");
          setTimeout(function () {
            thisVar.closest("tr").remove();
            location.reload();
          }, 3000);
        },
      });
    } else {
      return false;
    }
  });
});

// For custom field setting page toggle button script

jQuery(document).ready(function () {
  jQuery(".wpcf_toggleCheckbox").change(function () {
    var keyVal = jQuery(this).attr("data-id");
    var keyNAme = jQuery(this).attr("data-key");
    jQuery.ajax({
      type: "POST",
      url: ajax_object.ajax_url,
      data: {
        action: "wcpf_update_custom_field_option",
        option_name: keyNAme,
        value: keyVal,
      },
      success: function (response) {
        alert("Your status has been updated successfully!");
        location.reload();
      },
    });
  });
});

// For Taxonomy setting page toggle button script

jQuery(document).ready(function () {
  jQuery(".wpcf_taxnomony_toggleCheckbox").change(function () {
    var taxonomy_status = jQuery(this).attr("data-id");
    var key_name = jQuery(this).attr("data-key");
    jQuery.ajax({
      type: "POST",
      url: ajax_object.ajax_url,
      data: {
        action: "wcpf_update_taxonomy_option",
        key_name: key_name,
        taxonomy_status: taxonomy_status,
      },
      success: function (response) {
        alert("Your status has been updated successfully!");
        location.reload();
      },
    });
  });

  jQuery(".wpcf_woo_cat_checkbox").change(function () {
    var woo_cat_checkbox = jQuery(this).attr("data-id");
    jQuery.ajax({
      type: "POST",
      url: ajax_object.ajax_url,
      data: {
        action: "wcpf_update_status_woo_cat_checkbox",
        woo_cat_checkbox: woo_cat_checkbox,
      },
      success: function (response) {
        alert("Your status has been updated successfully!");
        location.reload();
      },
    });
  });

  
});

jQuery(document).on(
  "click",
  ".wcpf_main_content .woocommerce-pagination ul.page-numbers a.page-numbers",
  function (e) {
    e.preventDefault();

    if (jQuery(this).hasClass("next")) {
      var pagenumber = jQuery(".page-numbers.current").text();
      pagenumber = parseInt(pagenumber) + parseInt(1);
    } else if (jQuery(this).hasClass("prev")) {
      var pagenumber = jQuery(".page-numbers.current").text();
      pagenumber = parseInt(pagenumber) - parseInt(1);
    } else {
      var pagenumber = jQuery(this).text();
    }

    jQuery(".page__number").val(pagenumber);
    jQuery(".filter_id").trigger("click");
  }
);

jQuery(document).ready(function(){
  jQuery('.wcpf_main_section_filter input[type="radio"]').on('dblclick', function() {
    if (jQuery(this).is(':checked')) {
        jQuery(this).prop('checked', false).trigger('change'); 
    }
});
});