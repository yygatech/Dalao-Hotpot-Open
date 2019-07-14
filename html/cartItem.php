<?php
/**
 * Created by PhpStorm.
 * User: henry
 * Date: 3/17/18
 * Time: 13:31
 */

$photo = "./assets/img/1.jpg";
$name = "a name";
$quantity = '999';

?>

<div class='cart-item'>
    <img class='img-tn' src='<?php echo $photo ?>'>
    <?php echo $name ?> x <?php echo $quantity ?>
</div>