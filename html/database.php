<?php
/**
 * Deal with database logic
 * Created by PhpStorm.
 * User: henry
 * Date: 3/11/18
 * Time: 00:10
 */

/**
 * Get MySQL connection
 * @return mysqli MySQL Connection
 */
function getConnection() {
    return mysqli_connect('127.0.0.1','ubuntu','ubuntu','dalao_hotpot',3306);
    //return mysqli_connect('eys.red','restaurant','CS6314','restaurant');
}

/**
 * Database action: login
 * @param $account: username
 * @param $hashed_pwd: user input password SHA256 hashed
 * @return array: user info
 */
function loginDB($account, $hashed_pwd) {
    $con = getConnection();
    $account = mysqli_real_escape_string($con, $account);
    $hashed_pwd = mysqli_real_escape_string($con, $hashed_pwd);
    $query = "SELECT user_id,username,status,role FROM user WHERE (username='$account' OR mobile='$account' OR email='$account') AND pwd='$hashed_pwd'";
    $result = mysqli_query($con,$query);
    return mysqli_fetch_array($result);
}

/**
 * Database action: sign up test
 * test if a given value of specific field is unique or not
 * @param $field: field of user
 * @param $value: given value
 * @return boolean: value is unique or not
 */
function getUserID($field, $value) {
    $con = getConnection();
    $value = mysqli_real_escape_string($con, $value);
    $query = "SELECT user_id FROM user WHERE $field='$value'";
    $result = mysqli_query($con,$query);
    return mysqli_fetch_array($result)['user_id'];
}

/**
 * Database action: sign up
 * @param $username
 * @param $pwd
 * @param $email
 * @param $mobile
 * @param $first_name
 * @param $last_name
 * @return bool|mysqli_result
 */
function signUpDB($username,$pwd,$email,$mobile,$first_name,$last_name) {
    $con = getConnection();
    $username=mysqli_real_escape_string($con, $username);
    $pwd=mysqli_real_escape_string($con, $pwd);
    $email=mysqli_real_escape_string($con, $email);
    $mobile=mysqli_real_escape_string($con, $mobile);
    $first_name=mysqli_real_escape_string($con, $first_name);
    $last_name=mysqli_real_escape_string($con, $last_name);
    $query = "INSERT INTO user(username,pwd,email,mobile,first_name,last_name) values('$username','$pwd','$email','$mobile','$first_name','$last_name')";
    $result = mysqli_query($con,$query);
    return $result;
}

/**
 * Get dishes from database
 * @param $criteria: if there is some criteria need
 * @return array: Dishes array from database
 */
function getDishesDB($criteria=null) {
    $con = getConnection();
    $query = "SELECT * FROM dish ".$criteria;
    $result = mysqli_query($con,$query);

    $dish_arr = [];
    while($row=mysqli_fetch_assoc($result)){
        array_push($dish_arr, $row);
    }
    return $dish_arr;
}

/**
 * Database - Add dish to cart
 * @param $dish_id: id of the dish
 * @param $quantity: quantity of the dish want to add, 0 or negative means delete this dish
 * @param $user_id: user id in session
 * @return array: return the updated array of cart [{dish_id:quantity}...]
 */
function addToCartDB($dish_id, $quantity, $user_id) {
    $con = getConnection();

    // First, Execute the add, update or delete sql
    if($quantity<=0) $q1 = "DELETE FROM cart where user_id=$user_id and dish_id=$dish_id";
    else $q1 = "INSERT INTO cart(user_id, dish_id, dish_qty) VALUES($user_id, $dish_id, $quantity) ON DUPLICATE KEY UPDATE user_id=$user_id, dish_id=$dish_id, dish_qty=$quantity";
    mysqli_query($con, $q1);

    // Then, get the update cart array
    return getCartDB($user_id);
}

/**
 * Database - Get cart array of specific user
 * @param $user_id: user id in session
 * @return array: return the array of cart [{dish_id:quantity}...]
 */
function getCartDB($user_id) {
    $cart_item = [];
    $con = getConnection();
    $q = "SELECT dish_id,dish_qty FROM cart WHERE user_id=$user_id";
    $r = mysqli_query($con, $q);
    while($row = mysqli_fetch_assoc($r)) $cart_item[$row['dish_id']] = $row['dish_qty'];
    return $cart_item;
}

/**
 * Database - Add a dish
 * @param $dish
 * @return int: the id of the new dish
 */
function addDishDB($dish) {
    $con = getConnection();

    $name = $dish['name'];
    $desc = $dish['description'];
    $cat = $dish['category'];
    $price = $dish['price'];
    $cal = $dish['calorie'];
    $veg = $dish['vegetarian']=="yes"?1:0;
    $inv = $dish['inventory'];
    $avail = $dish['availability'];

    $q = "INSERT INTO dish(name, description, category, price, calorie, vegetarian, inventory, availability)
          VALUES ('$name', '$desc', '$cat', $price, $cal, $veg, $inv, $avail)";
    mysqli_query($con, $q);

    return mysqli_insert_id($con);
}

/**
 * Database - Update a dish
 * @param $dish
 * @return boolean: success or not
 */
function updateDishDB($dish) {
    $con = getConnection();

    $id = $dish['id'];
    $name = $dish['name'];
    $desc = $dish['description'];
    $cat = $dish['category'];
    $price = $dish['price'];
    $cal = $dish['calorie'];
    $veg = $dish['vegetarian']=="yes"?1:0;
    $inv = $dish['inventory'];
    $avail = $dish['availability'];

    $q = "UPDATE dish 
          SET name='$name', description='$desc', category='$cat', price=$price, calorie=$cal, vegetarian=$veg, inventory=$inv, availability=$avail 
          WHERE id=$id";
    mysqli_query($con, $q);

    return mysqli_error($con);
}

function debug($msg) {
    $con = getConnection();
    $msg = mysqli_escape_string($con, $msg);
    $q = "INSERT INTO debug(data) VALUES ('$msg')";
    mysqli_query($con,$q);
}
