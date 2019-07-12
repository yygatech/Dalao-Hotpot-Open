<?php
/**
 * Created by PhpStorm.
 * User: hllla
 * Date: 4/13/2018
 * Time: 12:42 PM
 */
include 'database.php';
session_start();

// Answer User call
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    switch ($_POST['action']) {
        case 'checkout': checkout($_POST['cart'],$_POST['tip'],$_POST['msg']); break;
        default: break;
    }
}
else header("Location: index.php");

if (!isset($_SESSION['username'])) {
    // User does not log in
    echo json_encode((object)['action' => $_POST['action'], 'error' => 1]);
    exit(0);
}
else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST['action']) {
            case 'getOrders':
                echo json_encode((object)['action' => $_POST['action'], 'error' => 0, 'data' => getOrders()]);
                break;
            default:
                break;
        }
    }
    else header("Location: index.php");
}

function getOrders() {
    $con = getConnection();
    $u_id = $_SESSION['user_id'];

    $all_info = [];
    $order_id = [];
    $dish_detail = [];
    $query1 = "SELECT * FROM restaurant.order WHERE user_id = $u_id ORDER BY built_time DESC";
    $result1 = mysqli_query($con,$query1);
    while($row = mysqli_fetch_assoc($result1)){
        array_push($all_info, $row);
        array_push($order_id, $row['order_id']);
    }
    foreach($order_id as $oid){
        $query2 =
            "SELECT o.order_id, d.name, o.dish_quantity, o.dish_price_that_time
            FROM restaurant.dish AS d
            RIGHT JOIN restaurant.ordered_dish_qty AS o
            ON d.id = o.dish_id
            WHERE o.order_id = $oid";
        $result2 = mysqli_query($con,$query2);
        while($row = mysqli_fetch_assoc($result2)){
            array_push($dish_detail, $row);
        }
    }
    return ((object)['arr1' => $all_info, 'arr2' => $dish_detail]);
}

/**
 * It's a very complicated function
 * @param $cart
 * @param $tip
 * @param $msg
 */
function checkout($cart, $tip, $msg) {

    $msg = htmlspecialchars($msg);

    // Check login status
    if(!isset($_SESSION['username'])) {
        echo json_encode((object)['action' => 'checkout', 'result'=>false, 'error_code' => 1]);
        exit(0);
    }
    $user_id = $_SESSION['user_id'];

    // Check each item if they are available and enough inventory
    $dishes = getDishesDB();
    foreach($cart as $dish_id=>$quantity){
        foreach ($dishes as $dish) {
            if($dish['id']==$dish_id && ($dish['availability']==0 || $dish['inventory']<$quantity)) {
                echo json_encode((object)['action' => 'checkout', 'result'=>false, 'error_code' => 1001]);
                exit(0);
            }
        }
    }

    // Everything is okay after this line, then we go true
    $subtotal = 0;
    $delivery_fee = 5.00;
    $con = getConnection();

    // Data cleaning
    $msg = mysqli_escape_string($con,$msg);

    // First, create an order and get the order number
    $q = "INSERT INTO restaurant.order(user_id, user_message, tip, delivery_fee) VALUES ($user_id, '$msg', $tip, $delivery_fee)";
    mysqli_query($con, $q);
    $mysql_error = mysqli_error($con);
    if($mysql_error){
        echo json_encode((object)['action'=> 'checkout', 'result'=>false, 'mysql_error'=>$mysql_error]);
        exit(0);
    }
    $order_id = mysqli_insert_id($con);

    // Then, traverse each item to get price to compute subtotal, meanwhile, update remain inventory
    foreach($cart as $dish_id=>$quantity){
        foreach ($dishes as $dish) {
            if($dish['id']==$dish_id) {
                $remain = $dish['inventory'] - $quantity;
                $q = "UPDATE dish SET inventory=$remain WHERE id=$dish_id";
                mysqli_query($con, $q);
                $mysql_error = mysqli_error($con);
                if($mysql_error){
                    echo json_encode((object)['action'=> 'checkout', 'result'=>false, 'mysql_error'=>$mysql_error]);
                    exit(0);
                }

                $subtotal += $dish['price'] * $quantity;
                $price = $dish['price'];
                $q2 = "INSERT INTO ordered_dish_qty(order_id,dish_id,dish_quantity,dish_price_that_time) VALUES ($order_id,$dish_id,$quantity,$price)";
                mysqli_query($con, $q2);
                $mysql_error = mysqli_error($con);
                if($mysql_error){
                    echo json_encode((object)['action'=> 'checkout', 'result'=>false, 'mysql_error'=>$mysql_error]);
                    exit(0);
                }
            }
        }
    }
    $subtotal = round($subtotal,2);

    // Last, use the subtotal and delivery fee to update order
    if($subtotal>=50) {
        $delivery_fee = 0.00;
        $q3 = "UPDATE restaurant.order SET delivery_fee=$delivery_fee WHERE order_id=$order_id";
        mysqli_query($con, $q3);
        $mysql_error = mysqli_error($con);
        if($mysql_error){
            echo json_encode((object)['action'=> 'checkout', 'result'=>false, 'mysql_error'=>$mysql_error]);
            exit(0);
        }
    }

    // Empty Cart for this user
    $q4 = "DELETE FROM cart WHERE user_id=$user_id";
    mysqli_query($con, $q4);
    $mysql_error = mysqli_error($con);
    if($mysql_error){
        echo json_encode((object)['action'=> 'checkout', 'result'=>false, 'mysql_error'=>$mysql_error]);
        exit(0);
    }

    // Return
    echo json_encode((object)['action' => 'checkout', 'result'=>true, 'debug'=>$_POST,'user_id'=> $user_id, 'order_id' => $order_id, 'subtotal'=>$subtotal, 'delivery_fee'=>$delivery_fee]);
}