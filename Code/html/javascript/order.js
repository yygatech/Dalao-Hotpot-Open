$(document).ready(function() {
    $('#order-list-modal').on('show.bs.modal', function(e) {
        $("#order-list").empty().append("<h4 class=\"list-group list-unstyled\">Loading...</h4>");
        updateOrder();
    });
});

function updateOrder() {
    $.ajax({
        type: 'POST',
        data: {
            'action': 'getOrders'
        },
        url: 'orderCtrl.php',
        success: function(res) {
            order_receive(res);
        },
        timeout: 5000,
        error: function(request, status, err) {
            if (status == "timeout") alert("Sorry, get orders time out.");
            else console.log("error: " + request + ", " + status + ", " + err);
        }
    });
}

function order_receive(res) {
    try {
        res = JSON.parse(res);
    } catch(err) {
        console.error("JSON parse error");
    }

    // Show orders to front-end
    switch (res['action']) {
        case 'getOrders': 
            showOrderCard(res['data']['arr1'],res['data']['arr2']); 
            break;
        default: 
            break;
    }
}

function showOrderCard(orders, dishes){

    $("#order-list").empty();

    if(orders.length === 0){
        $("#order-list").append("<h4 class=\"list-group list-unstyled\">You don't have any order yet.</h4>");
    }
    for (let order of orders) {
        //Processing status
        let s = null;
        switch(order['processed_status']){
            case '0':
                s = "Processing...";
                break;
            case '1':
                s = "Delivered.";
                break;
            default:
                break;
        }

        $("#order-list").append(
            "<div class='container-fluid'>"+
            "    <div>"+
            "       <ul class=\"list-group list-unstyled\" id='outer_listed_dish"+order['order_id']+"'>"+
            "           <li class=\"bg-light list-group-item d-flex justify-content-between align-items-center\"><b>Order Built-Time</b>"+order['built_time']+"</li>"+
            "           <li class=\"bg-light list-group-item d-flex justify-content-between align-items-center\"><b>Message</b>"+order['user_message']+"</li>"+
            "           <li class=\"bg-light list-group-item d-flex justify-content-between align-items-center\"><b>Order Status</b>"+s+"</li>"+
            "           <li class=\"bg-light list-group-item d-flex justify-content-between flex-row\">"+
            "               <div><b>Ordered Dishes</b></div>"+
            "               <div id='listed_dish"+order['order_id']+"'></div>"+
            "           </li>"+
            "       </ul>"+
            "    </div>"+
            "</div>"
        );
        let subtotal = 0;
        for (let dish of dishes) {
            if(dish['order_id'] === order['order_id']){
                subtotal = subtotal + dish['dish_quantity']*dish['dish_price_that_time'];
                $("#listed_dish"+order['order_id']).append(
                    "<li class='text-right'>"+dish['name']+" ("+Number(dish['dish_price_that_time']).toLocaleString('en-US', {style: 'currency',currency: 'USD'})+"/serving)"+
                    "    <span class=\"badge badge-warning\">&times;"+dish['dish_quantity']+"</span>"+
                    "</li>"
                );
            }
        }
        let total = subtotal + Number(order['tip']) + Number(order['delivery_fee']);
        $("#outer_listed_dish"+order['order_id']).append(
            "   <li class=\"bg-light list-group-item d-flex justify-content-between align-items-center\"><b>Subtotal</b>"+
            "       <span class=\"badge badge-primary\">"+subtotal.toLocaleString('en-US', {style: 'currency',currency: 'USD'})+"</span>"+
            "   </li>"+
            "   <li class=\"bg-light list-group-item d-flex justify-content-between align-items-center\"><b>Tip</b>"+
            "       <span class=\"badge badge-primary\">"+Number(order['tip']).toLocaleString('en-US', {style: 'currency',currency: 'USD'})+"</span>"+
            "   </li>"+
            "   <li class=\"bg-light list-group-item d-flex justify-content-between align-items-center\"><b>Delivery Fee</b>"+
            "       <span class=\"badge badge-primary\">"+Number(order['delivery_fee']).toLocaleString('en-US', {style: 'currency',currency: 'USD'})+"</span>"+
            "   </li>"+
            "   <li class=\"bg-light list-group-item d-flex justify-content-between align-items-center\"><b>Total</b>"+
            "       <span class=\"badge badge-primary\">"+total.toLocaleString('en-US', {style: 'currency',currency: 'USD'})+"</span>"+
            "   </li>"+
            "</br>"+
            "</br>"
        );
    }
}