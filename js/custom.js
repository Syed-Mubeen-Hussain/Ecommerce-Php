function manage_cart(pid, type) {
    if (type == "update") {
        var qty = jQuery("#" + pid+'qty').val();
    } else {
        var qty = jQuery("#qty").val();
    }
    jQuery.ajax({
        url: 'manage_cart.php',
        type: 'post',
        data: 'pid=' + pid + '&qty=' + qty + '&type=' + type,
        success: function(result) {
            result = result.trim();
            if (type == "update" || type == "remove") {
                window.location.href =  window.location.href;
            }
            if(result == "not_avaliable"){
                alert("Qty not avaliable");
            }else{
                jQuery('.htc__qua').html(result);
            }
        }
    });
}

function user_register() {
    jQuery(".field_error").html('');
    var name = jQuery("#name").val();
    var email = jQuery("#email").val();
    var mobile = jQuery("#mobile").val();
    var password = jQuery("#password").val();
    var is_error = '';

    if (name == "") {
        jQuery("#name_error").html("Please enter name");
        is_error = 'yes';
    }
    if (email == "") {
        jQuery("#email_error").html("Please enter email");
        is_error = 'yes';
    }
    if (mobile == "") {
        jQuery("#mobile_error").html("Please enter mobile");
        is_error = 'yes';
    }
    if (password == "") {
        jQuery("#password_error").html("Please enter password");
        is_error = 'yes';
    }
    if (is_error == '') {
        jQuery.ajax({
            url: 'register_submit.php',
            type: 'post',
            data: 'name=' + name + '&email=' + email + '&mobile=' + mobile + '&password=' + password,
            success: function(result) {
                result = result.trim();
                if (result == "email_present") {
                    jQuery("#email_error").html("Email already present");
                }
                if (result == "insert") {
                    jQuery(".register_msg p").html("Thank you for registration");
                    jQuery("#name").val("");
                    jQuery("#email").val("");
                    jQuery("#mobile").val("");
                    jQuery("#password").val("");
                }
            }
        });
    }
}


function user_login() {
    jQuery(".field_error").html('');
    var email = jQuery("#login_email").val();
    var password = jQuery("#login_password").val();
    var is_error = '';

    if (email == "") {
        jQuery("#login_email_error").html("Please enter email");
        is_error = 'yes';
    }
    if (password == "") {
        jQuery("#login_password_error").html("Please enter password");
        is_error = 'yes';
    }
    if (is_error == '') {
        jQuery.ajax({
            url: 'login_submit.php',
            type: 'post',
            data: 'email=' + email + '&password=' + password,
            success: function(result) {
                result = result.trim();
                if (result == 'wrong') {
                    jQuery(".login_msg p").html("Please enter valid login details");
                }
                if (result == "valid") {
                    window.location.href = window.location.href;
                }
            }
        });
    }
}

function sort_product_drop(cat_id,site_path){
    var sort_product_id = jQuery("#sort_product_id").val();
   window.location.href = site_path+"categories.php?id="+cat_id+"&sort="+sort_product_id;   
}

function manage_wishlist(pid,type){
    jQuery.ajax({
        url: 'manage_wishlist.php',
        type: 'post',
        data: 'pid=' + pid + '&type=' + type,
        success: function(result) {
            result = result.trim();
            if (result == "not_login") {
                window.location.href =  'login.php';
            }else{
                jQuery(".htc__wishlist").html(result);
            }
        }
    });
}

