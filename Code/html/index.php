<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php' ?>
    <title>Dalao Hotpot</title>
    <script src="javascript/index.js"></script>
    <script src="javascript/search.js"></script>
    <script src="javascript/order.js"></script>
</head>
<body>

<!-- Header(Navigation bar) -->
<?php include 'header.php' ?>

<!-- Homepage Content -->
<div id="homepage" class="container-fluid">

    <div class="row">
        <div id="index-view" class="col active">
            <div class="container-fluid">
                <div class="row">
                    <!-- Image -->
                    <?php include 'homepageCarousel.php' ?>
                </div>
                <div class="row">
                    <div id="search-bar-container" class="col-2">
                        <?php include 'search.php'; ?>
                    </div>
                    <div id="dish-list-container" class="col">
                         <?php include 'dish.php'; ?>
                        <?php include 'dishAdmin.php'; ?>
                    </div>
                </div>
                <div class="row">
                    <?php include 'footer.php' ?>
                </div>
            </div>
        </div>

        <?php include 'cart.php' ?>
    </div>
</div>

<?php include 'OrderList.php' ?>



</body>
</html>