<?php
/**
 * This file contain navigation bar logic.
 * Including menu, search, filter, user sign in and sign up.
 * Created by PhpStorm.
 * User: henry
 * Date: 3/9/18
 * Time: 16:45
 */
include "user.php";

?>

<div id="navbar-container" class="container-fluid fixed-top">
<div id="navbar-row" class="row">
<nav class="col navbar navbar-expand-md navbar-dark justify-content-between">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarNav">
	    	<ul class="navbar-nav">
	    		<li class="nav-item active">
	    			<a class="nav-link" href="./index.php"><img class="logo-img" src="assets/img/logo.png" alt="Dalao Hotpot"><span class="sr-only">(current)</span></a>
	    		</li>
	    		<li class="nav-item">
	    			<a id="navbar-menu" class="nav-link" href="./index.php">Menu</a>
	    		</li>
	    		<li class="nav-item">
	    			<a class="nav-link" href="./index.php#footer-container">Location and Hours</a>
	    		</li>
	    		<li class="nav-item">
	    			<a class="nav-link" href="./index.php#footer-container">About</a>
	    		</li>
	    		<li class="nav-item">
	    			<a class="nav-link" href="./index.php#footer-container">Contact</a>
	    		</li>
	    	</ul>
	    </div>

        <!-- User & Cart-->
        <div class="inline">
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <?php insertUserButton(); ?>
        </div>
        </div>
    </div>
</nav>
<div id="cart-btn"><i class="material-icons">shopping_cart</i><span id="cart-amount"></span></div>
</div></div>
<?php insertLoginModal(); ?>