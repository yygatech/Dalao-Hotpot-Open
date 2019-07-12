<?php
/**
 * Created by PhpStorm.
 * User: yygatech
 * Date: 4/18/18
 * Time: 2:14 PM
 */
?>

<!-- Dish Details Modal (Admin View) -->
<div class="modal fade" role="dialog" id="dish-detail-admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body detail-body">
                <form action="dishCtrl.php" method="post" enctype="multipart/form-data">
                    <input id="dish-action" style="display: none" name="action" value="updateDish_form">
                    <input id="dish-id-admin" style="display: none" name="dish-id" value="">
                    <div class="container detail-top">
                        <div class="row border justify-content-center">
                            <img class="detail-img" src="#" alt="food picture" id="dish-img-admin">
                            <input type="file" name="dish-img-upload" class='form-control' id="dish-img-upload">
                        </div>
                    </div>

                    <div class="container detail-middle">

                        <div class="row form-group">
                            <label for="">Item name</label>
                            <input class="form-control" name="dish-name-admin" id="dish-name-admin" type="text" placeholder="name...">
                        </div>

                        <div class="row form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" name="dish-description-admin" id="dish-description-admin" rows="2" placeholder="description..."></textarea>
                        </div>

                        <div class="row form-group">
                            <label for="">Category</label>
                            <input class="form-control" name="dish-cat-admin" id="dish-cat-admin" type="text" placeholder="category...">
                        </div>

                        <div class="row form-group">
                            <label for="">Price ($)</label>
                            <input type="text" name="dish-price-admin" id="dish-price-admin" class="form-control" placeholder="price...">
                        </div>

                        <div class="row form-group">
                            <label for="">Calorie</label>
                            <input type="text" name="dish-cal-admin" id="dish-cal-admin" class="form-control" placeholder="calorie...">
                        </div>

                        <div class="row form-group">
                            <label for="">Vegetarian</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="veg" value="yes" id="veg-yes">Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="veg" value="no" id="veg-no">No
                                </label>
                            </div>

                        </div>

                        <div class="row form-group">
                            <label for="">Inventory</label>
                            <input class="form-control" id="dish-inventory-admin" name="dish-inventory-admin" type="text" placeholder="inventory...">
                        </div>

                        <div class="row form-group">
                            <label for="">Availability</label>
                            <input class="form-control" id="dish-avail-admin" name="dish-avail-admin" type="text" placeholder="availability...">
                        </div>
                    </div>

                    <hr class="detail-divider"/>

                    <div class="container detail-bottom">

                        <div class="row detail-buttons">

                            <div class="col-3">
                                <div class="row btn-left">
                                    <button class="btn btn-block cancel" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>

                            <div class="col-9">
                                <div class="row btn-right">
                                    <button type="submit" id="update" class="btn btn-primary btn-block">Update</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>