<?php
/**
 * Created by PhpStorm.
 * User: henry
 * Date: 4/13/18
 * Time: 9:59 AM
 */

include 'database.php';
session_start();

// Answer User call
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($_POST['action']) {
        case 'getDishes':
            echo json_encode((object)['action' => $_POST['action'], 'data' => getDishes()]);
            break;
        case 'getCart':
            echo json_encode((object)['action' => $_POST['action'], 'data' => getCart()]);
            break;
        case 'addToCart':
            addToCart($_POST['dish'], $_POST['quantity']);
            break;
        case 'addDish':
            addDish();
            break;
        case 'updateDish':
            updateDish($_POST['dish']);
            break;
        case 'updateDish_form':
            updateDishForm();
            break;
        default:
            break;
    }
} else header("Location: index.php");

function addToCart($dish_id, $quantity)
{
    if (!isset($_SESSION['username'])) {
        echo json_encode((object)[
            'action' => 'addToCart',
            'result' => false,
            'reason' => 1
        ]);
        exit(0);
    } else {
        $cart = addToCartDB($dish_id, $quantity, $_SESSION['user_id']);
        echo json_encode((object)[
            'action' => 'addToCart',
            'result' => true,
            'cart' => $cart
        ]);
        exit(0);
    }
}

function getDishes()
{
    if (isset($_SESSION['role'])) {
        switch ($_SESSION['role']) {
            case 1:
                return getDishesDB();
            case 1024:
                return getDishesDB();
            default:
                return getDishesDB("WHERE availability=1");   // As normal user
        }
    } // Not login
    else return getDishesDB("WHERE availability=1");
}

function getCart()
{
    if (!isset($_SESSION['username'])) {
        return null;
    } else {
        return getCartDB($_SESSION['user_id']);
    }
}

function addDish()
{
    if (!isset($_SESSION['username'])) {
        echo json_encode((object)['action' => 'updateDish', 'result' => false, 'error' => 1]);
    } else if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        echo json_encode((object)['action' => 'updateDish', 'result' => false, 'error' => 2]);
    }
    else {
        $dish = [
            'name' => $_POST['dish-name-admin'],
            'description' => $_POST['dish-description-admin'],
            'category' => $_POST['dish-cat-admin'],
            'price' => $_POST['dish-price-admin'],
            'calorie' => $_POST['dish-cal-admin'],
            'vegetarian' => $_POST['veg'],
            'inventory' => $_POST['dish-inventory-admin'],
            'availability' => $_POST['dish-avail-admin'],
        ];
        var_dump($dish);
        $dish_id = addDishDB($dish);
        echo $dish_id;

        if($_FILES["dish-img-upload"]) fileUpload($dish_id);
        else header("Location: ./index.php");
    }
}

function updateDish($dish)
{
    if (!isset($_SESSION['username'])) {
        echo json_encode((object)['action' => 'updateDish', 'result' => false, 'error' => 1]);
    } else if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        echo json_encode((object)['action' => 'updateDish', 'result' => false, 'error' => 2]);
    } else {
        $error = updateDishDB($dish);
        echo json_encode((object)['action' => 'updateDish', 'result' => true, 'mysql_error' => $error, 'debug' => $_POST]);
    }
}

function updateDishForm()
{
    if (!isset($_SESSION['username'])) {
        echo json_encode((object)['action' => 'updateDish', 'result' => false, 'error' => 1]);
    } else if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        echo json_encode((object)['action' => 'updateDish', 'result' => false, 'error' => 2]);
    }
    else {
        $dish = [
            'id' => $_POST['dish-id'],
            'name' => $_POST['dish-name-admin'],
            'description' => $_POST['dish-description-admin'],
            'category' => $_POST['dish-cat-admin'],
            'price' => $_POST['dish-price-admin'],
            'calorie' => $_POST['dish-cal-admin'],
            'vegetarian' => $_POST['veg'],
            'inventory' => $_POST['dish-inventory-admin'],
            'availability' => $_POST['dish-avail-admin'],
        ];
        updateDishDB($dish);

        if($_FILES["dish-img-upload"]) fileUpload($_POST['dish-id']);
        else header("Location: ./index.php");
    }
}

function fileUpload($dish_id) {
    if ($_FILES["dish-img-upload"]["error"] <= 0) {
        $name = $_FILES["dish-img-upload"]["name"];
        move_uploaded_file($_FILES["dish-img-upload"]["tmp_name"],"assets/img/course/".$name);

        $q = "UPDATE dish SET photo='assets/img/course/$name' WHERE id=$dish_id";
        $con = getConnection();
        mysqli_query($con, $q);
    }
    header("Location: ./index.php");
}