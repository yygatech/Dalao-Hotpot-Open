let dishes = null;
let cart = null;
let tip = 2;
let total = 0;
let msg = null;
let dishesRemain = [];

let tmp_dish_id = 0;

$(document).ready(function() {

    // Cart view initialize
    $("#cart-view").mCustomScrollbar({
        theme: "minimal"
    });
    $('#cart-btn').on('click', function () {
        controlCartView();
    });

    // Hook: Course detail ON/OFF
    let course_detail = $('#dish-detail');
    let course_detail_admin = $('#dish-detail-admin');

    // Control when detail is shown
    course_detail.on('show.bs.modal', function (event) {
        let card = $(event.relatedTarget);                    // Button that triggered the modal
        let thisDish = getDishByID(card.data('id'));

        // Inflate the modal
        $('#dish-img').attr("src",thisDish['photo']);
        $('#dish-name').text(thisDish['name']);
        $('#dish-description').text(thisDish['description']);
        $('#dish-price').text(thisDish['price']);
        $('#dish-inv').text(thisDish['inventory']);
        $('#dish-cal').text(thisDish['calorie']);
        if (thisDish['vegetarian'] === "1") $('#detail-veg').show();

        // Add to cart
        $('#add-to-cart').on('click', function () {
            addToCart(thisDish,$('#dish-quantity').val());
            course_detail.modal('hide');                        // Close the modal
            controlCartView(1);                                 // Open the cart view
        });

        // Admin control
        if ($('#role-flag').data('role')===1) {
            $('#detail-admin').show();                          // Show edit button row
            tmp_dish_id = thisDish['id'];                       // Send dish ID to edit page to inflate the edit modal
        }
    });

    course_detail.on('hide.bs.modal', function () {
        $('#add-to-cart').off('click');
        $('#dish-quantity').val(1);                             // Reset the quantity counter
        tmp_dish_id = 0;

    });

    // Hook: Course detail (admin) ON/OFF
    course_detail_admin.on('show.bs.modal', function () {
        if (tmp_dish_id === 0) {
            // console.log('tmp_dish_id');
            // console.log(tmp_dish_id);

            // Reset contents
            $('#dish-id-admin').val(0);
            $('#dish-action').val("addDish");
            $('#dish-img-admin').attr("src","assets/img/logo.png");
            $('#dish-name-admin').val('');
            $('#dish-description-admin').val('');
            $('#dish-cat-admin').val('');
            $('#dish-price-admin').val('');
            $('#dish-cal-admin').val('');
            $('#veg-yes').checked = false;
            $('#veg-no').checked = false;
            $('#dish-inventory-admin').val('');
            $('#dish-avail-admin').val('');
            $('#update').html('Add this food');

            // Click adding button
            // $('#update').on('click', function () {
            //     addDish();
            // });

        } else {
            let thisDish = getDishByID(tmp_dish_id);

            $('#dish-id-admin').val(thisDish['id']);
            $('#dish-img-admin').attr("src",thisDish['photo']);
            $('#dish-name-admin').val(thisDish['name']);
            $('#dish-description-admin').val(thisDish['description']);
            $('#dish-cat-admin').val(thisDish['category']);
            $('#dish-price-admin').val(thisDish['price']);
            $('#dish-cal-admin').val(thisDish['calorie']);
            let veg = thisDish['vegetarian'];
            if (veg === "1") {
                document.getElementById('veg-yes').checked = true;
            } else {
                document.getElementById('veg-no').checked = true;
            }

            $('#dish-inventory-admin').val(thisDish['inventory']);
            $('#dish-avail-admin').val(thisDish['availability']);

            // Click 'Update' button
            // TODO: change to form
            // $('#update').on('click', function () {
            //     updateDish(thisDish);
            // });
        }
    });

    course_detail_admin.on('hide.bs.modal', function () {
        $('#update').off('click');
    });

    // Hook: Cart Tip Button or customize
    $('button.tip-opt').each(function () {
        $(this).on('click', function () {
            if(!$(this).hasClass('active')){
                $('#cb-tip-x').val('');
                $('.tip-opt').each(function () {
                    $(this).removeClass('active');
                });
                $(this).addClass('active');
                tip = $(this).data('tip');
                updateCart();
            }
        });
    });
    $('#cb-tip-x').on('input', function () {
        let tip_cus = parseFloat($(this).val());
        if(isNaN(tip_cus) || tip_cus<0) {
            $(this).val(null);
            $('.tip-opt').each(function () {
                $(this).removeClass('active');
            });
            $('#cb-tip-2').addClass('active');
            tip = 2;
        }
        else {
            $(this).addClass('active');
            $('button.tip-opt').each(function () {
                $(this).removeClass('active');
            });
            tip = tip_cus;
        }
        updateCart();
    });

    // Hook: Check-out Button
    $('#checkout-btn').on('click',function () {
        checkOut();
    });

    // Require all dishes
    $.ajax({
        type: 'POST',
        data: {
            'action': 'getDishes'
        },
        url: 'dishCtrl.php',
        success: function(res) {
            receive(res);
        },
        timeout: 5000,
        error: function(request, status, err) {
            if (status === "timeout") alert("Sorry, get dishes time out. Please check network connection.");
            else console.log("error: " + request + " " + status + " " + err);
        }
    });
});

function receive(res) {
    try {
        res = JSON.parse(res);
    } catch(err) {
        alert(err);
        alert(res);
    }
    switch (res['action']) {
        case 'getDishes': {
            dishes = res['data'];
            dishesRemain = dishes.slice();
            graduallyShowDishCard(12, dishesRemain);
            requestCart();
            break;
        }
        case 'getCart': {
            cart = res['data'];
            updateCart();
            break;
        }
        case 'addDish': addDish_res(res); break;
        case 'updateDish': updateDish_res(res); break;
        case 'addToCart': addToCart_res(res); break;
        case 'checkout': checkOut_res(res); break;
        default: break;
    }
}

/**
 * Show all cards of dishes to the dish list
 */
function showAllDishCard(dishes) {
    for (let dish of dishes) appendDishCard(dish);
}

/**
 * Only if user scroll to button of page then show dish card. Use to paging
 * @param count: how many card to show every time
 * @param dishesToShow: the buffer list
 */
function graduallyShowDishCard(count=12) {
    $("#btn-more-container").remove();

    let j = 0;
    for(let i=0;i<count;i++) {
        if (dishesRemain[i]) appendDishCard(dishesRemain[i]);
        else j=i;
    }

    dishesRemain = dishesRemain.slice(j?j:count);

    if(!j){
        // append more button
        $("#dish-list").after(
            "<nav id='btn-more-container' aria-label=\"Page navigation example\">\n" +
            "  <ul class=\"pagination justify-content-center\">\n" +
            "<button onclick='graduallyShowDishCard(12,dishesRemain)' class='btn btn-warning btn-more'>Load Next page</button>" +
            "  </ul>" +
            "</nav>");
    }
}

/**
 * Request cart data after dishes data is loaded
 */
function requestCart() {
    $.ajax({
        type: 'POST',
        data: {
            'action': 'getCart'
        },
        url: 'dishCtrl.php',
        success: function(res) {
            receive(res);
        },
        timeout: 5000
    });
}

/**
 * Append a dish card to dish list
 * @param dish: dish want to append
 */
function appendDishCard(dish) {
    $("#dish-list").append(
        "        <div class='card dish-card' data-toggle='modal' data-target='#dish-detail' data-id='"+dish['id']+"'>" +
        "            <img class='card-img-top' src='"+dish['photo']+"' alt='food picture'>" +
        "            <div class='card-body'>" +
        "                <h4 class='card-title'>"+dish['name']+"</h4>" +
        "                        <strong>$</strong>" +
        "                        <strong>"+dish['price']+"</strong>" +
        "            </div>" +
        "        </div>");

    let id = dish['id'];
    if(dish['availability']<=0) {
        $(".dish-card[data-id*="+id+"]").addClass("dish-card-na");
    }
}

/**
 * Switch of cart view
 * @param mode: 0-close / 1-open / 2-toggle
 */
function controlCartView(mode=2) {
    let ctl = $('#cart-view, #index-view');
    switch (mode) {
        case 0: ctl.addClass('active'); break;
        case 1: ctl.removeClass('active'); break;
        default:
        case 2: ctl.toggleClass('active'); break;
    }
}

function addToCart(dish, quantity) {
    // Get the quantity already in cart, add them together
    if(cart) {
        let dishOldQuantity = cart[dish['id']];
        if(dishOldQuantity) quantity = parseInt(quantity) + parseInt(dishOldQuantity);
    }

    $.ajax({
        type: 'POST',
        data: {
            'action': 'addToCart',
            'dish': dish['id'],
            'quantity': quantity
        },
        url: 'dishCtrl.php',
        success: function(res) {
            receive(res);
        },
        timeout: 5000
    });
}

function addToCart_res(res) {
    if(!res['result']) {
        switch (res['reason']) {
            case 1: alert("Sorry, you need to login before order."); break;
            default: alert("Sorry, add failed. And we don't know why."); break;
        }
    }
    else {
        cart = res["cart"];
        updateCart();
    }
}

function updateCart() {
    let cartList = $('div#cart-list');
    let check_out_container = $('#checkout-container');
    let subtotal_span = $('#cb-subtotal');
    let deliver_fee_span = $('#cb-deliver-fee');
    let tax_span = $('#cb-tax');
    let tip_span = $('#cb-tip');
    let total_span = $('#cb-total');

    // Cart Initialize
    cartList.empty();
    subtotal_span.html("0.00");
    deliver_fee_span.html("5.00");
    tax_span.html("0.00");
    total_span.html("0.00");

    // When no item in cart, show warning and hide checkout section
    if(!cart || Object.keys(cart).length===0) {
        check_out_container.hide();
        cartList.append("<div class='cart-warning'><i class='material-icons'>warning</i><br>No items in your cart</div>");
    }
    else {
        check_out_container.show();

        // Show each cart item in cart list, compute subTotal
        let subTotal = 0.00;
        $.each(cart,function(dish_id ,quantity) {
            let thisDish = getDishByID(dish_id);
            if(thisDish==null)
                cartList.append("<div class='cart-item'>An item unavailable anymore</div>");
            else {
                cartList.append(
                    "<div class='cart-item'>" +
                    "   <div class='row' style='align-items: center'>" +
                    "       <div class='col-3'>" +
                    "           <img class='ci-img' src='"+thisDish['photo']+"'>" +
                    "       </div>" +
                    "       <div class='col'>" +
                    "           <div class='ci-first-line d-flex justify-content-between'>" +
                    "               <strong>"+thisDish['name']+" </strong>"+
                    "           </div>" +
                    "           <div class='ci-second-line d-flex justify-content-between'>" +
                    "               <div id='ci-price'>$ "+thisDish['price']+"</div>"+
                    "               <div>" +
                    "                   <div data-id='"+thisDish['id']+"' class='ci-counter input-group input-group-sm'>"+
                    "                       <div class='input-group-prepend'>" +
                    "                           <button class='btn btn-outline-secondary ci-btn btn-dec' style='line-height: 0'>-</button>" +
                    "                       </div>" +
                    "                       <input class='ci-counter-input input-group-text' value='"+quantity+"' type='text'>" +
                    "                       <div class='input-group-append'>" +
                    "                           <button class='btn btn-outline-secondary ci-btn btn-add' style='line-height: 0'>+</button>" +
                    "                       </div>" +
                    "                   </div>" +
                    "               </div>" +
                    "           </div>" +
                    "       </div>" +
                    "   </div>" +
                    "</div>"
                );
                subTotal += parseFloat(thisDish['price']) * quantity;
            }
        });

        // Compute fees
        let deliverFee = subTotal>=50?0.00:5.00;
        let tax = 0.0625 * (subTotal + deliverFee);
        total = subTotal + deliverFee + tax + tip;

        // update UI w/ currency format
        subtotal_span.html(subTotal.toLocaleString('en-US', {style: 'currency',currency: 'USD'}));
        deliver_fee_span.html(deliverFee.toLocaleString('en-US', {style: 'currency',currency: 'USD'}));
        tax_span.html(tax.toLocaleString('en-US', {style: 'currency',currency: 'USD'}));
        tip_span.html(tip.toLocaleString('en-US', {style: 'currency',currency: 'USD'}));
        total_span.html(total.toLocaleString('en-US', {style: 'currency',currency: 'USD'}));

        // Change item quantity in cart
        $('div.ci-counter').each(function() {
            let ctrlPanel = $(this);
            let decBtn = ctrlPanel.find("button.btn-dec");
            let counter = ctrlPanel.find("input");
            let addBtn = ctrlPanel.find("button.btn-add");
            let dishID = ctrlPanel.data("id");

            // When item's quantity is 1, change the "-" to "x" to warning user
            if(counter.val()==='1')
                decBtn.removeClass("btn-outline-secondary").addClass("btn-outline-danger").html('&times;');
            else decBtn.removeClass("btn-outline-danger").addClass("btn-outline-secondary").html("-");

            // Control the add & decrease function. (delete item when quantity below zero, this logic is at server-side)
            counter.on("input", function() {
                if(isNaN(parseInt(counter.val()))) updateCart();
                else cartItemQuantityChange(dishID, counter.val());
            });
            decBtn.on("click", function () {
                cartItemQuantityChange(dishID, parseInt(counter.val())-1);
            });
            addBtn.on("click", function () {
                cartItemQuantityChange(dishID, parseInt(counter.val())+1);
            });
        });
    }
}

function cartItemQuantityChange(dishID, quantity) {
    $.ajax({
        type: 'POST',
        data: {
            'action': 'addToCart',
            'dish': dishID,
            'quantity': quantity
        },
        url: 'dishCtrl.php',
        success: function(res) {
            receive(res);
        },
        timeout: 5000
    });
}

function getDishByID(dishID) {
    for (let dish of dishes) {
        if(dish['id'] === dishID.toString()) return dish;
    }
    return null;
}

function checkOut() {
    // Check cart info
    if(cart==null || total<=0) return false;
    $.each(cart,function(dish_id ,quantity) {
        if(!quantity || quantity<=0 || !tip || tip<0) {
            console.log("Sorry, your cart or tip has some problem, please check before check out.");
            return false;
        }
    });

    // UI transition
    $("#checkout-btn").off().fadeOut(300, function () {
        $("#user-info-container").fadeIn(300);
        $("#cart-view").mCustomScrollbar("scrollTo","bottom");
    });

    // Paypal link (Just kidding...)
    $("#paypal").on("click", function () {
       window.open("https://paypal.me/yygatech/"+total.toFixed(2));
    });

    // Hook: confirm
    $("#checkout-confirm-btn").on("click", function () {
        checkOutConfirm();
    });
    $("#user-msg").on("input",function () {
        msg = $(this).val();
    })
}

function checkOutConfirm() {
    $.ajax({
        type: 'POST',
        data: {
            'action': 'checkout',
            'cart': cart,
            'tip': tip,
            'msg': msg
        },
        url: 'orderCtrl.php',
        success: function (res) {
            receive(res);
        },
        timeout: 5000
    });
}


function checkOut_res(res) {
    console.log(res);
    if(!res['result']) {
        switch (res['error_code']) {
            case 1: alert("Sorry, you need to login before order."); break;
            case 1001: alert("Sorry, one or more items you requested is unavailable now, please check again."); break;
            case 2001: alert("Sorry, but our database report some error. And it's our fault. You can check it." + res['msg']); break;
            default: alert("Sorry, order failed. And we don't know why."); break;
        }
    }
    else {
        // Just a simple modal will do.
        cart = null;
        tip = 2;
        total = 0;
        msg = null;
        updateCart();
        controlCartView(0);
        $("#checkout-success-modal").modal('show');
    }
}

function addDish() {
    console.log('here1');
    $.ajax({
        type: 'POST',
        data: {
            action: 'addDish',
            dish: {
                'name': $('#dish-name-admin').val(),
                'description': $('#dish-description-admin').val(),
                'category': $('#dish-cat-admin').val(),
                'price': $('#dish-price-admin').val(),
                'calorie': $('#dish-cal-admin').val(),
                'vegetarian': $('#veg-yes:checked').val() === "on",
                'inventory': $('#dish-inventory-admin').val(),
                'availability': $('#dish-avail-admin').val()
            }
        },
        url: 'dishCtrl.php',
        success: function(res) {
            receive(res);
        },
        timeout: 5000
    });
}

function addDish_res(res) {
    if(res['result']) {
        alert("Food is successfully added!");
        location.reload(false);
    }
    else{
        switch (res['error']) {
            case 1:
            case 2: alert("Sorry, you need to login as admin to add food"); break;
            default: alert("Sorry, adding food failed, and we don't know why"); break;
        }
    }
}

function updateDish(dish) {
    $.ajax({
        type: 'POST',
        data: {
            action: 'updateDish',
            dish: {
                'id': dish['id'],
                'name': $('#dish-name-admin').val(),
                'description': $('#dish-description-admin').val(),
                'category': $('#dish-cat-admin').val(),
                'price': $('#dish-price-admin').val(),
                'calorie': $('#dish-cal-admin').val(),
                'vegetarian': $('#veg-yes:checked').val()==="on",
                'inventory': $('#dish-inventory-admin').val(),
                'availability': $('#dish-avail-admin').val()
            }
        },
        url: 'dishCtrl.php',
        success: function(res) {
            receive(res);
        },
        timeout: 5000
    });
}

function updateDish_res(res) {
    console.log(res);
    if(res['result']) {
        alert("Update successful!");
        location.reload(false);
    }
    else {
        switch (res['error']) {
            case 1:
            case 2: alert("Sorry, you need to login as admin to update dish"); break;
            default: alert("Sorry, update failed, and we don't know why"); break;
        }
    }
}

function showOrder() {
    $("#order-list-modal").modal("show");
}