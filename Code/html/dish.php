<?php
/**
 * Created by PhpStorm.
 * User: yygatech
 * Date: 3/17/18
 * Time: 1:18 PM
 */
?>

<div id="dish-list"></div>

<!-- Dish Details Modal (User View) -->
<div class="modal fade" role="dialog" id="dish-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body detail-body">

                <div class="container detail-top">
                    <div class="row border justify-content-center">
                        <img class="detail-img" src="#" alt="food picture" id="dish-img">
                    </div>
                </div>

                <div class="container detail-middle">

                    <div class="row" id="detail-name">
                        <div class="col">
                            <div class="row">
                                <h5 class="modal-title" id="dish-name"></h5>
                            </div>
                        </div>
                        <div class="col" id="detail-veg" style="display: none;">
                            <div class="row justify-content-end">
                                <img id="veg-img" src="assets/img/vegetarian-mark-60.png" alt="vegetarian">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="detail-description">
                        <p id="dish-description"></p>
                    </div>

                    <div class="row" id="detail-price-qty">
                        <div class="col-4">
                            <div class="row" id="detail-price">
                                <strong>$</strong>
                                <strong id="dish-price"></strong>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row justify-content-end" id="detail-inv">
                                <em id="dish-inv"></em>
                                <em>left</em>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4" id="detail-qty-col">
                            <div class="row justify-content-end" id="detail-qty-row">
                                <div class="input-group p-0" id="detail-qty">
                                    <span class="input-group-btn input-group-prepend">
                                        <button class="btn btn-danger btn-number btn-number-left" type="button" data-type="minus" data-field="quant[2]">
                                            <h4>-</h4>
                                        </button>
                                    </span>
                                    <input id="dish-quantity" type="text" name="quant[2]" class="form-control input-number text-center" value="1" min="1" max="10">
                                    <span class="input-group-btn input-group-append">
                                        <button class="btn btn-success btn-number btn-number-right" type="button" data-type="plus" data-field="quant[2]">
                                            <h4>+</h4>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="detail-cal">
                        <span id="dish-cal"></span>
                        <span>cal.</span>
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
                                <button id="add-to-cart" class="btn btn-block">
                                    <span>Add to cart</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="detail-admin" style="display: none;">
                        <div class="row" id="btn-line-space"></div>
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <button id="edit" class="btn btn-danger btn-block" data-toggle="modal" data-target="#dish-detail-admin">
                                        <span>Edit this item</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


<script src="javascript/quantity.js"></script>