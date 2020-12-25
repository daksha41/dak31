<?php include_once('inc/function.php'); ?>
<html>
<?php include_once('inc/head_section.php'); ?>
<body>
<!-- header nav section -->
<?php include_once('inc/common_nav.php'); ?>
<!-- header nav section -->

<!-- registeration,login,,mange donar,manage patient req,manage ity /location,view feed back,mange inquiry --> 

<style>
#date,#camp-address{
    padding: 0px 25px;
    border: none;
    border-radius: 10px;
    outline: none;
    -webkit-text-fill-color: #fff;
    background-color: #da8075b3;
    color: #fff;
    font-size: 15px;
}
#camp-address{
    padding-top: 4px;
    padding-bottom: 4px;
    resize: none;
}
#manage-camp, #add-blood, #remove-blood{
    margin: 10px;
    padding: 20px 10px;
}
#add-blood .signup-fields, #remove-blood .signup-fields, #manage-camp .signup-fields{ grid-template-columns: 1fr 1fr; }
#add-blood, #remove-blood, #signup-area{ display: none;}
#manage-camp input[type="submit"]{ width:auto; }
#manage-camp select{
    width: auto;
    padding: 0 10px;
}
@media (max-width: 600px){
    
    #donor-area {margin:0;}
}
@media (max-width: 550px){
    #add-blood .signup-fields, #remove-blood .signup-fields, #manage-camp .signup-fields{ grid-template-columns: 1fr; margin: 30px 5px;}

}
</style>

<div class="admin-tab">
    <div id="manage-tab" class="admin-tab-active">Manage Camp</div>
    <div id="add-tab">Add Blood</div>
    <div id="remove-tab">Remove Blood</div>
    <div id="signup-tab">Add Admin</div>
</div>

<div id="manage-camp">
    <div id="donor-area">
        <div class="donor-form-header">Register new blood donation camp</div>
        <div class="signup-fields">
            <div><input type="text" id="city" placeholder="City" required></div>
            <div style="padding-top:15px;"><input type="date" id="date"></div>
            <div>
                <select name="hour" id="hour" required>
                    <?php
                        for($i=0; $i<13; $i++){
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                    ?>
                </select>
                <select name="minute" id="minute" required>
                    <?php
                        for($i=0; $i<60; $i++){
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                    ?>
                </select>
                <input type="radio" id="am" name="am-pm">AM
                <input type="radio" id="pm" name="am-pm">PM
            </div>
            <!--div><input type="text" id="camp_address" placeholder="Camp address" required></div-->
            <textarea id="camp-address" placeholder="Camp address"></textarea>
        </div>
        <center>
            <div id="manage-camp-error-msg" class="err-msg"></div>
            <input type="submit" id="submit-camp-details" value="Submit camp details">
        </center>
    </div>
</div>
<div id="add-blood">
    <div id="donor-area">
        <div class="donor-form-header">Add Blood</div>
        <div class="signup-fields">
            <div>
                <select name="blood_group" id="blood-group" required>
                    <option value="default" selected>Select blood group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
            </div>
            <div><input type="text" id="blood-quantity" placeholder="Quantity (in Ltr)" required></div>
        </div>
        <center>
            <div id="add-blood-error-msg" class="err-msg"></div>
            <input type="submit" onclick="manage_blood_quantity('add')" value="Submit details">
        </center>
    </div>
</div>
<div id="remove-blood">
    <div id="donor-area">
        <div class="donor-form-header">Remove Blood</div>
        <div class="signup-fields">
            <div>
                <select name="blood_group" id="blood-group" required>
                    <option value="default" selected>Select blood group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
            </div>
            <div><input type="text" id="blood-quantity" placeholder="Quantity (in Ltr)" required></div>
        </div>
        <center>
            <div id="remove-blood-error-msg" class="err-msg"></div>
            <input type="submit" onclick="manage_blood_quantity('remove')" value="Submit details">
        </center>
    </div>
</div>
<div id="signup-area">
    <div id="donor-area">
        <div class="heading">Add new admin</div>
        <div class="signup-fields">
            <div><input type="text" id="f_name" placeholder="First Name" required></div>
            <div><input type="text" id="l_name" placeholder="Last Name" required></div>
            <div><input type="email" id="email" placeholder="Email" required></div>
            <div><input type="text" id="ph_number" placeholder="Contact Number" required></div>
            <div><input type="text" id="admin-city" placeholder="City" required></div>
            <div><input type="text" id="role" placeholder="Role: Admin" disabled></div>
            <div><input type="text" id="username-signup" placeholder="Type Username" required></div>
            <div><input type="password" id="password-signup" placeholder="Password" required></div>
            <div><input type="password" id="conf-password"placeholder="Confirm Password" required></div>
        </div>
        <center>
            <div id="signup-error-msg" class="err-msg"></div>
            <input type="submit" id="signup" value="Add Admin">
        </center>
    </div>
</div>
<script>

$('#signup').click(function(){
    if($('#f_name').val() == '' || $('#l_name').val() == '' || $('#email').val() == '' || $('#admin-city').val() == '' || $('#username-signup').val() == '' || $('#password-signup').val() == '' || $('#conf-password').val() == ''){
        popup_alert("All fields are required", "warning");
        $('#signup-error-msg').html('** Fill all fields');
        return false;
    }
    if($('#password-signup').val() != $('#conf-password').val()){
        popup_alert("Password doesnot same", "warning");
        $('#signup-error-msg').html('** Password doesnot match');
        return false;
    }
    if($('#password-signup').val().length > 16 || $('#password-signup').val().length < 8){
        popup_alert("Password should be 8-16 characters", "warning");
        $('#signup-error-msg').html('** Password should be 8-16 characters');
        return false;
    }
    if(isNaN($('#ph_number').val()) || $('#ph_number').val().length > 10 || $('#ph_number').val().length < 10){
        popup_alert("Phone number is incorrect", "warning");
        $('#signup-error-msg').html('** Phone number is incorrect');
        return false;
    }
    $.ajax({
        url: process_url(),
        type: 'post',
        dataType: 'text',
        data: {
                action      : 'user_signup',
                username    : $('#username-signup').val(),
                password    : $('#password-signup').val(),
                first_name  : $('#f_name').val(),
                last_name   : $('#l_name').val(),
                email       : $('#email').val(),
                ph_number   : $('#ph_number').val(),
                city        : $('#admin-city').val(),
                role        : 'admin'
              },
        success: function(data){
            if(data == 'user_exist'){
                popup_alert("Username already exist", "warning");
                $('#signup-error-msg').html('** Username already taken, choose another one');
                return false;
            }
            else if(data == 'success'){
                popup_alert("Signup successful", "success");
                $('#signup-error-msg').html('** Admin has been added');
                $('#username-signup').val(''),
                $('#password-signup').val('');
                $('#conf-password').val('');
                $('#f_name').val(''),
                $('#l_name').val('');
                $('#email').val(''),
                $('#ph_number').val('');
                $('#admin-city').val('');
            }
            else{
                popup_alert("Something went wrong, please try again later", "warning");
                $('#login-error-msg').html('** something went wrong, please try again later');
            }
        }
    });
});
$('#submit-camp-details').click(function(){
    var city = $('#city').val();
    var date = $('#date').val();
    var hour = $('#hour').val();
    var minute = $('#minute').val();
    var am = $('input[id="am"]:checked').val();
    var pm = $('input[id="pm"]:checked').val();
    var camp_address = $('#camp-address').val();
    if(city == '' || date == '' || hour == '0' || (am == undefined && pm == undefined) || camp_address == ''){
        popup_alert("All fields are required", "warning");
        $('#manage-camp-error-msg').html('** All fields are required');
        return false;
    }
    if(am != undefined) var am_pm = 'am';
    else var am_pm = 'pm';
    $.ajax({
        url: process_url(),
        type: 'post',
        dataType: 'text',
        data: {
                action       : 'update_camp_details',
                city         : city,
                date         : date,
                hour         : hour,
                minute       : minute,
                am_pm        : am_pm,
                camp_address : camp_address
              },
        success: function(data){
            if(data == 'success'){
                popup_alert("Data has been submitted", "success");
                $('#manage-camp-error-msg').html('** Data has been updated.');
                $('#city').val('');
                $('#date').val('');
                $('#hour').val(0);
                $('#minute').val(0);
                $('input[id="am"]').prop('checked', false);
                $('input[id="pm"]').prop('checked', false);
                camp_address = $('#camp-address').val('');
            }
            else{
                popup_alert("Something went wrong, please try again later", "warning");
                $('#'+sub_action+'-blood-error-msg').html('** something went wrong, please try again later');
            }
        }
    });
});
$('#manage-tab').click(function(){
    tab_click_action();
    $('#add-tab, #remove-tab').removeClass('admin-tab-active');
    $('#manage-camp').fadeIn(200);
});
$('#add-tab').click(function(){
    tab_click_action();
    $('#add-tab').addClass('admin-tab-active');
    $('#add-blood').fadeIn(200);
});
$('#remove-tab').click(function(){
    tab_click_action();
    $('#remove-tab').addClass('admin-tab-active');
    $('#remove-blood').fadeIn(200);
});
$('#signup-tab').click(function(){
    tab_click_action();
    $('#signup-tab').addClass('admin-tab-active');
    $('#signup-area').fadeIn(200);
});

function tab_click_action(){
    $('#manage-tab, #add-tab, #remove-tab, #signup-tab').removeClass('admin-tab-active');
    $('#manage-camp, #add-blood, #remove-blood, #signup-area').hide();
}
function manage_blood_quantity(sub_action){
    var blood_group = $(`#${sub_action}-blood #blood-group`).val();
    var quantity = $(`#${sub_action}-blood #blood-quantity`).val();
    if(quantity == '' || isNaN(quantity) || quantity < 1){
        popup_alert("Quantity field is incorrect", "warning");
        $('#'+sub_action+'-blood-error-msg').html('** Quantity field is incorrect');
        return false;
    }
    if(blood_group == 'default'){
        popup_alert("Blood group not selected", "warning");
        $('#'+sub_action+'-blood-error-msg').html('** Blood group not selected');
        return false;
    }
    $.ajax({
        url: process_url(),
        type: 'post',
        dataType: 'text',
        data: {
                action      : 'update_blood_quantity',
                sub_action  : sub_action,
                quantity    : quantity,
                blood_group : blood_group
              },
        success: function(data){
            if(data == 'quantity_empty'){
                popup_alert("Stored blood quantity is empty", "warning");
                $('#'+sub_action+'-blood-error-msg').html('** Stored blood quantity is empty, so you can\'t remove '+blood_group+' blood');
            }
            else if(data == 'less_quantity'){
                popup_alert("Submitted quantity is more", "warning");
                $('#'+sub_action+'-blood-error-msg').html('** Submitted quantity is more than the stored quantity, so you can\'t remove '+blood_group+' blood');
            }
            else if(data == 'success'){
                popup_alert("Data has been submitted", "success");
                $('#'+sub_action+'-blood-error-msg').html('** Data has been updated.');
                $(`#${sub_action}-blood #blood-quantity`).val('');
                $(`#${sub_action}-blood #blood-group`).val('default');
            }
            else{
                popup_alert("Something went wrong, please try again later", "warning");
                $('#'+sub_action+'-blood-error-msg').html('** something went wrong, please try again later');
            }
        }
    });
}

</script>
<!-- footer common section -->
<?php include_once('inc/footer_section.php'); ?>
<!-- footer common section -->
</body>
</html>
