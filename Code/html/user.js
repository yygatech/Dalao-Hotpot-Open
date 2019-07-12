/**
 * This file contain client login form process
 * Created by PhpStorm.
 * User: henry
 * Date: 3/12/18
 * Time: 19:30
 */

if (typeof(signUpValidation) === "undefined")signUpValidation = {
    email: false,
    pwd_s: false,
    username_s: false,
    first_name: false,
    last_name: false,
    mobile: false,
    email_server: false,
    username_server: false,
    mobile_server: false
};

$(document).ready(function() {
    // AUTO FOCUS
    $('#loginModal')
        .on('shown.bs.modal', function () {
            $('#username').trigger('focus');
        });
    $('#signUpModal')
        .on('shown.bs.modal', function () {
            $('#username_s').trigger('focus');
        });

    // SIGN UP VALIDATION HOOKS
    $('div.sign-up-div').each(function() {
        let div = $(this);
        div.find('input').each(function(){
            $(this)
                .on('input',function(e){
                    if(signUpFieldLocalValidation($(this),div))signUpFieldServerValidation($(this));
                })
        });
    })
});

// ---------------------------------------------------------------------------------------------------------------------    AJAX

/**
 * Send universal ajax to user.php
 * @param action: 'signUpTest' / 'signUp' / 'login' / 'logout'
 * @param data
 * @returns object
 */
function sendAjax(action,data=null) {
    $.ajax({
        type: 'POST',
        data: {
            action: action,
            data: data
        },
        url: 'user.php',
        success: function(res) {
            receiveAjaxResponse(res);
        },
        timeout: 5000,
        error: function(res) {
            errorAjax();
        }
    });
}

/**
 * Receive AJAX response from server
 * @param res
 */
function receiveAjaxResponse(res) {
    try {
        res = JSON.parse(res);
    } catch(err) {
        alert(err);
        alert(res);
    }
    switch(res['action']) {
        case 'login': loginResponse(res);break;
        case 'logout': window.location.reload(false);break;
        case 'signUpTest': signUpFieldServerResponse(res['res']);break;
        case 'signUp': signUpResponse(res['res']);break;
        case 'unknown': console.log("UNKNOWN REQUEST: ",res);break;

        // DEBUG
        case 'session_debug': console.log("session",res['session']);break;
        case 'cookie_debug': console.log("cookie",res['cookie']);break;
        default: console.log("UNKNOWN RESPONSE: ",res);
    }
}

function errorAjax() {
    alert("Sorry, Server time out, this cannot be done.");
}

// ---------------------------------------------------------------------------------------------------------------------    LOGIN (REQ/RES)

/**
 * Deal with login ajax logic.
 */
function loginAjax() {
    let username = $('input#username').val();
    let pwd = $('input#pwd').val();
    if(username==="" || pwd==="") {
        loginResponse({status:-1});
        return false;
    }
    sendAjax('login',{
        'username': username,
        'password': sha256(pwd)
    });
    return false;   // Prevent auto refresh
}

/**
 * login php response, process the client side
 * @param resJSON login status response by server side php (user.php)
 */
function loginResponse(resJSON) {
    let loginBadge = $('#login-badge');
    switch(resJSON['status']){
        case -1: changeBadge(loginBadge,'Oops, please fill in both fields.','error');break;
        case 0: {
            changeBadge(loginBadge,'Login succeed. Welcome back!','succeed');
            window.location.reload(false);break;
        }
        case 1: changeBadge(loginBadge,'Oops, wrong password or account is not exist, try again?','error');break;
        case 2: changeBadge(loginBadge,'Sorry, your account is locked. Please refer to Customer Service.','error');break;
        default: changeBadge(loginBadge,'Unknown status, Login failed. Please refer to Customer Service.','error');break;
    }
}

// ---------------------------------------------------------------------------------------------------------------------    SIGN UP VALIDATION

/**
 * Sign Up field local validation
 * @param input
 * @param signUpDiv
 * @return boolean
 */
function signUpFieldLocalValidation(input, signUpDiv) {
    let regex=/^.*$/,errorMsg="Unknown error";
    switch(input.attr("id")) {
        case "email": {
            regex = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
            errorMsg = "Please input valid email address: name@example.com";
            break;
        }
        case "pwd_s": {
            regex = /^(?=.*[A-Za-z]).{8,}$/;
            errorMsg = "Password is too weak, it's insecure.";
            break;
        }
        case "username_s": {
            regex = /^[A-Za-z_][A-Za-z_\-0-9]{4,}$/;
            errorMsg = "Not a valid username, please see instruction.";
            break;
        }
        case "first_name": {
            regex = /^[A-Za-z]{1,30}$/;
            errorMsg = "Please input your first name.";
            break;
        }
        case "last_name": {
            regex = /^[A-Za-z]{1,30}$/;
            errorMsg = "Please input your last name.";
            break;
        }
        case "mobile": {
            regex = /^\d{10}$/;
            errorMsg = "Please input valid 10 digits phone number.";
            break;
        }
        default: break;
    }

    if(regex.exec(input.val())) {
        inputDivStatusChange(signUpDiv,"","succeed");
        signUpValidation[input.attr('id')]=true;
        signUpButtonValidation();
        return true;
    }
    else {
        inputDivStatusChange(signUpDiv,errorMsg,"error");
        signUpValidation[input.attr('id')]=false;
        signUpButtonValidation();
        return false;
    }
}

function signUpFieldServerValidation(input) {
    switch(input.attr("id")) {
        case "email": sendAjax("signUpTest",{testField:"email",value:input.val()});break;
        case "username_s": sendAjax("signUpTest",{testField:"username",value:input.val()});break;
        case "mobile": sendAjax("signUpTest",{testField:"mobile",value:input.val()});break;
        default: break;
    }
}

function signUpFieldServerResponse(res) {
    let field = res['testField'];
    let uni = res['unique'];
    signUpValidation[field+'_server']=uni;

    // Switch UI
    switch(field) {
        case "email":{
            if(!uni)inputDivStatusChange($('input#email').parent(),"This email has been signed. login if It's your email.","error");
            break;
        }
        case "username":{
            if(!uni)inputDivStatusChange($('input#username_s').parent(),"Sorry, this username has been taken, change a new one","error");
            break;
        }
        case "mobile":{
            if(!uni)inputDivStatusChange($('input#mobile').parent().parent(),"This mobile number has been signed. login if It's your's.","error");
            break;
        }
        default: break;
    }
    signUpButtonValidation();
}

function signUpButtonValidation(changeUI=true) {
    let result = false;
    for(let key in signUpValidation) {
        if(!signUpValidation[key]){
            result = false;
            break;
        }
        else result = true;
    }
    if(changeUI)$("#sign-up-btn").attr("disabled",!result);
    return result;
}

// ---------------------------------------------------------------------------------------------------------------------    SIGN UP

function signUp() {
    // Lock the inputs and button
    $('div.sign-up-div').each(function() {
        $(this).find('input').each(function(){
            $(this).attr("disabled",true);
        });
    });
    let button = $("#sign-up-btn");
    button.attr("disabled",true).val('Wait..');


    if(!signUpButtonValidation(false)){
        changeBadge($("#sign-up-badge"),"Please check all the fields","error");
        return false;
    }
    else {
        button.attr("disabled",true).val('Wait...');
        sendAjax("signUp",{
            username:$('input#username_s').val(),
            pwd:sha256($('input#pwd_s').val()),
            email:$('input#email').val(),
            mobile:$('input#mobile').val(),
            first_name:$('input#first_name').val(),
            last_name:$('input#last_name').val()
        })
    }

    return false;
}

function signUpResponse(res) {
    let badge = $("#sign-up-badge");
    let button = $("#sign-up-btn");
    if(res['successful']) {
        changeBadge(badge,"Sign up succeed! Wait 5 second to redirect or click the green button","succeed");
        $('form#sign-up-form').attr('onsubmit','return refresh()');
        button.removeClass().addClass('form-control btn btn-success').val('Click to Login').attr("disabled",false);
        setTimeout(function(){
            window.location.reload(false);
        },5000);
    }
    else {
        $('div.sign-up-div').each(function() {
            $(this).find('input').each(function(){
                $(this).attr("disabled",false);
            });
        });
        button.attr("disabled",false).val('Sign up');
        if(!res['server_check'])changeBadge($("#sign-up-badge"),"Server check error. Please re sign and try again.","error");
        else changeBadge($("#sign-up-badge"),"Server internal error. Please try again latter.","error");
        console.log("### Sign up failed.");
        console.log(res);
    }
}

function refresh() {
    window.location.reload(false);
    return false;
}

// ---------------------------------------------------------------------------------------------------------------------    UI

/**
 * Change input status both input and badge
 * @param inputDiv
 * @param msg
 * @param status
 */
function inputDivStatusChange(inputDiv, msg, status){
    let input = inputDiv.find('input');
    let badge = inputDiv.find('small');
    changeBadge(badge,msg,status);
    changeInput(input,status);
}

/**
 * Show badge with specific badge-id, msg and type
 * @param badge: badge need to change
 * @param msg: message want to be shown
 * @param type: 'error'->red / 'succeed'->green
 */
function changeBadge(badge, msg, type='badge-secondary') {
    badge
        .removeClass()
        .addClass('badge')
        .addClass(type)
        .text(msg)
        .fadeIn(300);
}

/**
 * Change input line color
 * @param input
 * @param type
 */
function changeInput(input,type='') {
    input
        .removeClass()
        .addClass('form-control')
        .addClass('lined')
        .addClass(type);
}

/**
 * Switch login modal with Signup modal
 */
function loginSignUpModalToggle(bool) {
    if(bool){
        $('#signUpModal')
            .on('shown.bs.modal', function () {
                $('#email').trigger('focus');
            })
            .modal('show');
        $('#loginModal').modal('hide');
    }
    else {
        $('#loginModal')
            .on('shown.bs.modal', function () {
                $('#username').trigger('focus');
            })
            .modal('show');
        $('#signUpModal').modal('hide');
    }
}

// ---------------------------------------------------------------------------------------------------------------------    DEBUG

function debug() {
    sendAjax("session_debug");
    sendAjax("cookie_debug");
}

function toggleSearchBar() {
    let bar = $("#search-bar-container");
    if(bar.css("display")==="none")bar.show(400);
    else bar.hide(400);
}