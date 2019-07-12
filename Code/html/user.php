<?php
/**
 * This file deal with user logic, including sign in and sign up
 * Created by PhpStorm.
 * User: henry
 * Date: 3/10/18
 * Time: 17:55
 */

include 'database.php';

session_start();
answerRequest();

/**
 * Insert a User Button
 */
function insertUserButton() {
    echo "";
    if (!isset($_SESSION['username'])) {
        // User is not login
        echo "
        <div class='btn-group mr-3' role=\"group\">
            <button class='user-btn btn btn-outline-light no-border' id='user-btn' data-toggle='modal' data-target='#loginModal'><i class='material-icons'>play_for_work</i><span>Login</span></button>
        </div>
        <div class='btn-group' role='group'>
            <button class='user-btn btn btn-outline-light' id='user-btn' data-toggle='modal' data-target='#signUpModal'><span>Sign Up</span></button>
        </div>
        ";
    }
    else {
        // User is login
        echo "
        <div class='btn-group' role=\"group\" aria-label=\"Basic example\">
            <div class='dropdown'>
                <button class='user-btn btn btn-outline-light dropdown-toggle no-border' id='user-btn' data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><i class='material-icons'>account_circle</i><span>".$_SESSION['username']."</span></button>
                <div class=\"dropdown-menu\" aria-labelledby=\"user-btn\">
                    ".showRole()."
                    <button class=\"dropdown-item\" data-toggle='modal' data-target='#order-list-modal'><i class='material-icons'>description</i>My orders</button>
                    <div class=\"dropdown-divider\"></div>
                    ".showCustomizedBar()."
                    <a class='dropdown-item' href='#' onclick='return sendAjax(\"logout\")'><i class='material-icons'>exit_to_app</i>Logout</a>
                    <script src='user.js'></script>
                </div>
            </div>
        </div>
        ";
    }
}

/**
 * Show user is admin or not
 * @return string
 */
function showRole() {
    $role = $_SESSION['role'];
    switch ($role) {
        case 1:    return "<h6 id='role-flag' data-role='1'    class='dropdown-header'><i class='material-icons'>supervisor_account</i>Admin</h6>";
        case 0:    return "<h6 id='role-flag' data-role='0'    class='dropdown-header'><i class='material-icons'>supervisor_account</i>User</h6>";
        case 1024: return "<h6 id='role-flag' data-role='1024' class='dropdown-header'><i class='material-icons'>supervisor_account</i>Developer</h6>";
        default: break;
    }
}

function showCustomizedBar() {
    if($_SESSION['role']==1024) {
        return "
            <a class='dropdown-item' href='#' data-toggle=\"modal\" data-target=\"#debugModal\"><i class='material-icons'>bug_report</i>Debug</a>
            <a class='dropdown-item' href='#' onclick='toggleSearchBar()'><i class='material-icons'>bug_report</i>Toggle search bar</a>
            <div class=\"dropdown-divider\"></div>
        ";
    }
}

/**
 * Insert a login modal on the top of the page
 */
function insertLoginModal() {
    echo "
        <script src='sha256.js'></script>
        <script src='user.js'></script>
        <div class='modal fade' id='loginModal' tabindex='-1' role='dialog' aria-labelledby='loginModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-lg' role='document'>
                <div class='modal-content'>
                    <div class='modal-body modal-white'>
                    <div class='container-fluid'>
                        <div class='row'>
                        <div id='login-welcome' class='col'>
                            <h4>Welcome</h4>
                            <div id='login-helper'>
                                <small id='loginToSignUpHelper' class='form-text text-muted'>
                                    First come? <a href='#' onclick='loginSignUpModalToggle(true)'>Create Account</a>
                                </small>
                                <small id='passwordForgetHelper' class='form-text text-muted'>
                                    Forget account or password? <a id='anchor-find-my-account' href='#' onclick='findMyAccount()'>Find my account</a>
                                </small>
                            </div>
                        </div>
                        <div class='col'>
                            <form class='form-group' id='login-form' onsubmit='return loginAjax()' method='post'>
                                <div class='form-group'>
                                    <input class='form-control lined' type='text' id='username' name='username' placeholder='Username / Mobile number / Email'>
                                </div>
                                <div class='form-group'>
                                    <input class='form-control lined' type='password' id='pwd' name='pwd' placeholder='Password'>
                                </div>
                                    <input class='form-control btn btn-primary' type='submit' value='Login'>
                                    <div style='display: none;' id='login-badge' class='badge'>
                                        Login message.
                                    </div>
                            </form>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ";
    insertSignUpModal();
}

/**
 * Insert a Sign Up modal
 */
function insertSignUpModal() {
    echo "
        <script src='sha256.js'></script>
        <script src='user.js'></script>
        <div class='modal fade' id='signUpModal' tabindex='-1' role='dialog' aria-labelledby='signUpModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-lg' role='document'>
                <div class='modal-content'>
                
                    <div class='modal-header'>
                        <h4 style='margin: 0;'>SignUp</h4>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">&times;</span>
                        </button>
                    </div>
                
                    <div class='modal-body modal-white'>
                        <div class='container-fluid'>
                        
                        <div class='alert alert-secondary alert-dismissible fade show'>
                            <span id='switchToLoginHelpBlock'>
                                Already a member? <a href='#' onclick='loginSignUpModalToggle(false)'>Login</a>
                            </span>
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                              <span aria-hidden=\"true\">&times;</span>
                            </button>
                        </div>
                        
                        <form class='form-group' id='sign-up-form' onsubmit='return signUp()' method='post'>
                        
                        <div class='row row-form'>
                            <div class='col-4'>
                                <h5>Username</h5>
                                <small class='form-text text-muted'>
                                    At least 5 characters.<br><strong>Not</strong> case sensitive.<br>Only start with letter or _
                                </small>
                            </div>
                            <div class='col'>
                                <div class='form-group sign-up-div'>
                                    <input class='form-control lined' type='text' id='username_s' name='username_s' placeholder='How should we call you?'>
                                    <small style='display: none' id='username-validation-badge' class='badge'>Some error</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class='row row-form'>
                            <div class='col-4'>
                                <h5>Password</h5>
                                <small class='form-text text-muted'>
                                    Password should at least 8 characters, including at least 1 letter.<br>Case sensitive
                                </small>
                            </div>
                            <div class='col'>
                                <div class='form-group sign-up-div'>
                                    <input class='form-control lined' type='password' id='pwd_s' name='pwd_s' placeholder='Password'>
                                    <small style='display: none' id='password-validation-badge' class='badge'>Some error</small>
                                </div>
                            </div>
                        </div>          
                                      
                        <div class='row row-form'>
                            <div class='col-4'>
                                <h5>Email</h5>
                                <small class='form-text text-muted'>
                                    A valid email account to login, get notification and reset password.
                                </small>
                            </div>
                            <div class='col'>
                                <div class='form-group sign-up-div'>
                                    <input class='form-control lined' type='text' id='email' name='email' placeholder='name@example.com'>
                                    <small style='display: none' id='email-validation-badge' class='badge'>Some error</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class='row row-form'>
                            <div class='col-4'>
                                <h5>Mobile Number</h5>
                                <small class='form-text text-muted'>
                                    Your phone number can login, get call by deliverer
                                </small>
                            </div>
                            <div class='col'>
                                <div class='form-group sign-up-div'>
                                    <div class='input-group'>
                                        <div class='input-group-prepend'>
                                            <span class='input-group-text form-control lined'>+1</span>
                                        </div>
                                        <input class='form-control lined' type='text' id='mobile' name='mobile' placeholder='888-888-8888'>
                                    </div>
                                    <small style='display: none' id='mobile-validation-badge' class='badge'>Some error</small>
                                </div>
                            </div>
                        </div>
                                                
                        <div class='row row-form'>
                            <div class='col-4'>
                                <h5>Name</h5>
                                <small class='form-text text-muted'>
                                    Please enter your name
                                </small>
                            </div>
                            <div class='col'>
                                <div class='row'>
                                <div class='col'>
                                <div class='form-group sign-up-div'>
                                    <input class='form-control lined' type='text' id='first_name' name='first_name' placeholder='First Name'>
                                    <small style='display: none' id='first-name-validation-badge' class='badge'>Some error</small>
                                </div>
                                </div>
                                <div class='col'>
                                <div class='form-group sign-up-div'>
                                    <input class='form-control lined' type='text' id='last_name' name='last_name' placeholder='Last Name'>
                                    <small style='display: none' id='last-name-validation-badge' class='badge'>Some error</small>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sign up button -->
                        <div class='form-group'>
                            <input type='hidden' name='action' value='signUp'/>
                            <input id='sign-up-btn' class='form-control btn btn-primary' type='submit' value='Sign Up' disabled>
                            <small style='display: none' id='sign-up-badge' class='badge'>Sign Up message.</small>
                        </div>
                        
                        </form>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ";
}

// ---------------------------------------------------------------------------------------------------------------------    SERVER SIDE: RESPONSE

/**
 * Response the user HTTP request
 * Judge which action is requested by user
 */
function answerRequest() {
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        switch ($_POST['action']) {
            case 'login': login($_POST['data']);break;
            case 'logout': logout();break;
            case 'signUpTest': signUpTest($_POST['data']);break;
            case 'signUp': signUp($_POST['data']);break;
            case 'session_debug': echo json_encode((object)['action'=>'session_debug','session'=>$_SESSION]);break;
            case 'cookie_debug': echo json_encode((object)['action'=>'cookie_debug','cookie'=>$_COOKIE]);break;
            default: echo json_encode((object)['action' => 'unknown','post'=>$_POST]);break;
        }
    }
    else {
        showDebugModal();
    }
}

/**
 * Deal with login request
 * @param $data: including username and password
 */
function login($data) {
    $account = htmlspecialchars(strtolower($data['username']));
    $pwd = htmlspecialchars($data['password']);
    $result = loginDB($account,$pwd);

    $res = new stdClass();
    $res->action = 'login';

    if(!$result) {
        // Wrong password or no account
        $res->status = 1;
    }
    else if($result['status']==0) {
        // Account is disabled
        $res->status = 2;
    }
    else {
        // Login successful
        $res->status = 0;

        // Write session
        session_regenerate_id();
        $_SESSION['login_time'] = time();
        $_SESSION['username'] = $result['username'];
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['role'] = $result['role'];
        session_write_close();
    };
    echo json_encode($res);
}

/**
 * Let user logout
 */
function logout() {
    session_start();
    session_destroy();
    echo json_encode((object)['action' => 'logout']);
}

/**
 * Test one field of sign up data in DB to check unique
 * @param $data: including field to test and value
 */
function signUpTest($data) {
    $field = htmlspecialchars($data['testField']);
    $value = htmlspecialchars(strtolower($data['value']));
    $uni = getUserID($field,$value)==null;
    echo json_encode((object)['action' => 'signUpTest','res'=>['testField'=>$field,'value'=>$value,'unique'=>$uni]]);
}

/**
 * Deal with sign up request
 * @param $data
 */
function signUp($data) {
    $username = htmlspecialchars(strtolower($data['username']));
    $pwd = htmlspecialchars($data['pwd']);
    $email = htmlspecialchars($data['email']);
    $mobile = htmlspecialchars($data['mobile']);
    $first_name = htmlspecialchars($data['first_name']);
    $last_name = htmlspecialchars($data['last_name']);

    $m1 = filter_var($email, FILTER_VALIDATE_EMAIL);
    $m2 = preg_match('/^[A-Za-z_][A-Za-z_\-0-9]{4,}$/',$username);
    $m3 = preg_match('/^\d{10}$/',$mobile);
    $m4 = preg_match('/^[0-9a-f]{64}$/',$pwd);
    $m5 = preg_match('/^[A-Za-z]{1,30}$/',$first_name);
    $m6 = preg_match('/^[A-Za-z]{1,30}$/',$last_name);
    $m7 = getUserID("username",$username)==null && getUserID("mobile",$mobile)==null && getUserID("email",$email)==null;

    $server_check = $m1 && $m2 && $m3 && $m4 && $m5 && $m6 && $m7;
    if($server_check) $result = signUpDB($username,$pwd,$email,$mobile,$first_name,$last_name);
    else $result = false;

    if($result) {
        // Write session
        session_regenerate_id();
        $_SESSION['login_time'] = time();
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = getUserID("username",$username);
        $_SESSION['role'] = 0;
        session_write_close();
    }

    echo json_encode((object)['action' => 'signUp','res'=>[
        'server_check' => $server_check,
        'successful' => $result
    ]]);
}

// ---------------------------------------------------------------------------------------------------------------------    DEBUG

function showDebugModal() {
    echo "
    <!-- Debug Modal -->
    <div class=\"modal fade\" id=\"debugModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"debugModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
    <div class='modal-header'><h3>Debug</h3><hr></div>
    <div id='debug_div' class=\"modal-body\">";
    echo "</div></div></div></div>";
}