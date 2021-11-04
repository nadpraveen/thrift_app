
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

//function closewin(){
//    window.close();
//}

function post_article_comment() {
    var article_user_id = $('#article_user_id').val();
    var article_slug = $('#article_slug').val();
    var article_comment = $('#article_comment').val();
    var dataString = 'article_user_id=' + article_user_id + '&article_slug=' + article_slug + '&article_comment=' + article_comment;
    //alert(dataString);
    var url = window.location.href;
    $.ajax({
        type: "POST",
        url: "script_code.php",
        data: dataString,
        //cache: false,
        beforeSend: function () {
            $("#comments_list").css("background", "#FFF url(images/LoaderIcon.gif) no-repeat 165px");
        },
        success: function (data) {
            //alert(data);
            $(' #commnet_count').load(url + ' #commnet_count');
            $(' #comments_list').load(url + ' #comments_list');
            $("#comments_list").css("background", "#FFF");
        }
    });
    $('#article_comment').val("");
    return false;
}

$(document).ready(function () {
    $("#copy").hide();
});

$(document).ready(function () {
    $('#alert_div').hide();
});

$(document).ready(function () {
    $('#otp_info').hide();
});

$(document).ready(function () {
    $('#confirm_div').hide();
});

$(document).ready(function () {
    $('#sub_reg').hide();
});

$(document).ready(function () {
    $('#otp_div').hide();
});

$(document).ready(function () {
    $('#otp_info_withdraw').hide();
});

$(document).ready(function () {
    $('#otp_div_withdraw').hide();
});

$(document).ready(function () {
    $('#btn_withdraw').hide();
});

$(document).ready(function () {
    $('#alert_div').delay(1000).fadeOut();
});

$(document).ready(function () {
    $('#btn_rec').hide();
});

function enable_copy() {
    $("#copy").show();
}

function split_url(url) {
    return url.split("?")[0];
}


function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function enable_eliment() {

    $('#sub_reg').toggle();
}

function copy_address() {
    var d_no = $('#d_no').val();
    var street = $('#street').val();
    var area = $('#area').val();
    var city = $('#city').val();
    var district = $('#district').val();
    var state = $('#state').val();
    var pin = $('#pin').val();
    $('#p_d_no').val(d_no);
    $('#p_street').val(street);
    $('#p_area').val(area);
    $('#p_city').val(city);
    $('#p_district').val(district);
    $('#p_state').val(state);
    $('#p_pin').val(pin);
}

function submit_reg() {
    var error = "";
    var url = window.location.href;
//    var url_new = split_url(url);
    var emp_no = $("#emp_no").val();
    var mobile = $("#mobile").val();
    var email = $("#email").val();
    var aadhar = $("#aadhar").val();

    var d_no = $('#d_no').val();
    var street = $('#street').val();
    var area = $('#area').val();
    var city = $('#city').val();
    var district = $('#district').val();
    var state = $('#state').val();
    var pin = $('#pin').val();

    var p_d_no = $('#p_d_no').val();
    var p_street = $('#p_street').val();
    var p_area = $('#p_area').val();
    var p_city = $('#p_city').val();
    var p_district = $('#p_district').val();
    var p_state = $('#p_state').val();
    var p_pin = $('#p_pin').val();

    if (mobile == "" || mobile.length < 10) {
        error += "Enter Valid Mobile Number";
    }
    if (email == "" || isEmail(email) == false) {
        error += "<br>Enter a valid Email";
    }
    if (aadhar == "" || aadhar.length < 12) {
        error += "<br>Enter a valid Aadhar";
    }
    if (d_no == '' || street == '' || area == '' || city == '' || district == '' || state == '' || pin == '') {
        error += "<br>Enter Present Address";
    }
    if (p_d_no == '' || p_street == '' || p_area == '' || p_city == '' || p_district == '' || p_state == '' || p_pin == '') {
        error += "<br>Enter Permanent Address";
    }

    if (error != '') {
        $('#alert_div').show();
        $('#alert_div').html(error);
    } else {

        var dataString = 'emp_no=' + emp_no + '&mobile=' + mobile + '&email=' + email + '&aadhar=' + aadhar + '&d_no=' + d_no + '&street=' + street + '&area=' + area + '&city=' + city + '&district=' + district +
                '&state=' + state + '&pin=' + pin + '&p_d_no=' + p_d_no + '&p_street=' + p_street + '&p_area=' + p_area + '&p_city=' + p_city + '&p_district=' + p_district + '&p_state=' + p_state + '&p_pin=' + p_pin;
        //alert(dataString);
        $.ajax({
            type: "POST",
            url: "data_scripts.php",
            data: dataString,
            //cache: false,
            beforeSend: function () {
                $("#info_div").css("background", "#FFF url(lodar/ajax-loader.gif) no-repeat 300px");
            },
            success: function (data) {
                //alert(data);
                //location.href = url + '?emp=' + emp_no;
                $("#info_div").hide();
                $("#input_div").hide();
                $("#update_div").hide();
                $("#confirm_div").show();
                //history.pushState(null, '', 'reg.php?emp_no=' + emp_no);
            }
        });
        return false;
    }
}

function update_reg() {

    var error = '';
    var url = window.location.href;
    var emp_no = $("#emp_no").val();
    var reg_no = $('#reg_no').val();

    if (reg_no == "") {
        error += "Enter a valid Registration Number";
    }

    if (error != '') {
        $('#alert_div').show();
        $('#alert_div').html(error);
    } else {
        var dataString = 're_emp_no=' + emp_no + '&reg_no=' + reg_no;

        $.ajax({
            type: "POST",
            url: "data_scripts.php",
            data: dataString,
            //cache: false,
            beforeSend: function () {
                $("#aadhar_div").css("background", "#FFF url(lodar/ajax-loader.gif) no-repeat 300px");
            },
            success: function (data) {
                location.href = url + '?page=update&emp=' + emp_no + '&reg_no=' + reg_no;
            }
//            fail: function(data){
//                
//            }
        });
        return false;
    }
}

function gen_otp(pourpose, user) {
    event.preventDefault();
    var dataString = 'emp_no=' + user + '&pourpose=' + pourpose;
    $.ajax({
        type: "POST",
        url: "data_scripts.php",
        data: dataString,
        cache: false,
        beforeSend: function () {
            $("#change_div").css("background", "#FFF url(lodar/ajax-loader.gif) no-repeat 300px");
        },
        success: function (data) {
            //alert(data);
            $("#change_div").css("background", "#FFF");
            $('#otp_gen').hide();
            $('#otp_gen_withdraw').hide();
            $('#otp_info').show();
            $('#btn_rec').show();
            $('#otp_div').show();
            $('#otp_info_withdraw').show();
            $('#otp_div_withdraw').show();
            $('#btn_withdraw').show();
        }
    });
    return false;
}

function resend_otp(pourpose, user, type) {
    event.preventDefault();
    var dataString = 're_emp_no=' + user + '&re_pourpose=' + pourpose + '&type=' + type;
    $.ajax({
        type: "POST",
        url: "data_scripts.php",
        data: dataString,
        cache: false,
        beforeSend: function () {
            $("#change_div").css("background", "#FFF url(lodar/ajax-loader.gif) no-repeat 300px");
        },
        success: function (data) {
            //alert(data);
            $("#change_div").css("background", "#FFF");
        }
    });
    return false;
}

function is_eligible(eligble_amount) {
    var error = '';
    var amt_required = $('#amt_required').val();
    if (amt_required > eligble_amount) {
        error += 'Amount Must be less thane or equil to Eligible Amount';
    }
    if (amt_required == null || amt_required == 0) {
        error += 'Please Enter amount in the field';
    }
    if (amt_required % 100 != 0) {
        error += 'Amount Must be in multiples of 100';
    }
    if (error != '') {
        $('#amt_required').focus();
        alert(error);
    }
}

function reload_captcha() {
    var url = window.location.href;
    $(' #captcha_div').load(url + ' #captcha_div');
}