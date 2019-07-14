<div id="cart-view" class="col active">
    <div class="navbar-placeholder"></div>
    <div id="cart-list" class="container">
        <div class="cart-warning"><i class="material-icons">warning</i><br>No items in your cart</div>
    </div>
    <div id="checkout-container">
        <div id="tip" class="cart-item">
            <div id="tip-container" class="d-flex justify-content-between">
                <Strong>Tip</Strong>
                <div>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <button id='cb-tip-1' data-tip='1' class="btn btn-outline-secondary form-control tip-opt">$1</button>
                            <button id='cb-tip-2' data-tip='2' class="btn btn-outline-secondary form-control tip-opt active">$2</button>
                            <button id='cb-tip-3' data-tip='3' class="btn btn-outline-secondary form-control tip-opt">$3</button>
                        </div>
                        <input id="cb-tip-x" class="tip-opt form-control" type="number">
                    </div>
                </div>
            </div>
        </div>
        <div id="checkout-bill-container" class="flex-column">
            <div class="d-flex justify-content-between">
                <span>Subtotal</span>
                <span id="cb-subtotal">0.00</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Deliver Fee</span>
                <span id="cb-deliver-fee">0.00</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tax</span>
                <span id="cb-tax">0.00</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tip</span>
                <span id="cb-tip">0.00</span>
            </div>
            <div class="d-flex justify-content-between cb-total-row">
                <span>Total</span>
                <strong id="cb-total">0.00</strong>
            </div>
        </div>
        <div id="checkout-btn" class="cart-item"><i class="material-icons">gavel</i><strong>Check Out</strong></div>

        <div id="user-info-container" class="cart-item">
            <strong style="text-align: center;">Comment</strong>
            <div class="form-group">
                <input type="text" class="form-control lined" id="user-msg" placeholder="E.g. No spicy. More forks.">
            </div>

            <strong style="text-align: center;">Delivery Info</strong>
            <div class="form-group">
                <label class="lined">Address 1</label>
                <input type="text" class="form-control lined" id="address1" placeholder="Stress address P.O. box, company name, c/o">
                <label class="lined">Address 2</label>
                <input type="text" class="form-control lined" id="address2" placeholder="Apartment, suite, unit, building, floor, etc.">
                <div class="row">
                    <div class="col">
                        <label class="lined">Zip/Postal Code</label>
                        <input type="text" class="form-control lined" id="zip" placeholder="Zip Code">
                    </div>
                    <div class="col">
                        <label class="lined">City</label>
                        <input type="text" class="form-control lined" id="state" placeholder="City">
                    </div>
                </div>
                <p class="lined" style="text-align: end;font-size: 0.5em;">TX, United States</p>
            </div>

            <strong style="text-align: center;">Payment</strong>
            <div class="form-group">
                <img id="paypal" class="img-btn" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-medium.png" alt="Check out with PayPal" /><br>
                <label class="lined">Card No.</label>
                <input type="text" class="form-control lined" id="cd-num" placeholder="Card number">
                <div class="row">
                    <div class="col">
                        <label class="lined">Name on card</label>
                        <input type="text" class="form-control lined" id="cd-name" placeholder="Name on card">
                    </div>
                    <div class="col">
                        <label class="lined">Zip code</label>
                        <input type="text" class="form-control lined" id="cd-zip" placeholder="xxxxx">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label class="lined">Expiry date</label>
                        <input type="text" class="form-control lined" id="cd-date" placeholder="mm/yy">
                    </div>
                    <div class="col">
                        <label class="lined">Security Code / CSC</label>
                        <input type="text" class="form-control lined" id="cd-csc" placeholder="XXX">
                    </div>
                </div>
            </div>

            <button id="checkout-confirm-btn" class="btn btn-primary container-fluid">Confirm</button>

        </div>
    </div>
</div>

<div class="modal fade" id="checkout-success-modal" tabindex="-1" role="dialog" aria-labelledby="checkout-success-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h2>Order Successfully created.</h2>
                <h3>Enjoy your meal.</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="showOrder()">Show My Orders</button>
            </div>
        </div>
    </div>
</div>