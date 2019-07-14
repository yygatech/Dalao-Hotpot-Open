$(document).ready(function() {
    $('#searchInput').on('input', function() {
        filter($(this));
    });

    if($('#role-flag').data('role')===1) {
        $('#addFood').show();
    }

    $('#addFoodBtn').on('click', function () {
        console.log('addbtn clicked');
    });

});

// check filters
function filter(){

    $("#dish-list").empty();

    let dishesFiltered = [];

    // add dishes in checked categories
    checkCatStatus(dishesFiltered);

    // remove dishes in unchecked price ranges
    checkPriceStatus(dishesFiltered);

    // remove dishes in unchecked calorie ranges
    checkCalStatus(dishesFiltered);

    // show vegetarian food only
    checkVegStatus(dishesFiltered);

    // filter against the keyword in search box
    checkSearch(dishesFiltered);

    // show filtered dishes
    dishesRemain = dishesFiltered;
    graduallyShowDishCard(12);

}

function checkCatStatus(dishesFiltered){

    // count categories
    let categories = $('#category').find('.checkbox');

    // indicator of no-checked status
    let anyChecked = false;

    // include checked categories
    for (let category of categories) {
        let key = category.getAttribute('name').toLowerCase();
        let value = category.checked;
        if (value) {
            anyChecked = true;

            // include dishes in this category
            let dishesAdded = dishes.filter(function(dish){
                return dish['category'].toLowerCase() === key;
            });
            Array.prototype.push.apply(dishesFiltered, dishesAdded);
        }
    }

    // include all dishes if none is checked
    if (!anyChecked) {
        Array.prototype.push.apply(dishesFiltered, dishes);
    }

}

function checkPriceStatus(dishesFiltered){

    let tempDishesFiltered = [];
    Array.prototype.push.apply(tempDishesFiltered, dishesFiltered);

    // indicator of no-checked status
    let noChecked = true;

    // count prices
    let prices = $('#price').find('.checkbox');

    // include checked categories
    for (let price of prices) {
        let low = parseInt(price.getAttribute('low'));
        let high = parseInt(price.getAttribute('high'));
        let value = price.checked;
        if (value) {
            noChecked = false;
        } else {
            // filter out dishes in this price range
            let dishesRemoved = dishesFiltered.filter(function(dish) {
                let priceValue = dish['price'];
                return priceValue >= low && priceValue < high;
            });

            for (let elem of dishesRemoved) {
                let index = dishesFiltered.indexOf(elem);
                if (index >= 0) {
                    dishesFiltered.splice(index, 1);
                }
            }
        }
    }

    // restore input if none is checked
    if (noChecked) {
        Array.prototype.push.apply(dishesFiltered, tempDishesFiltered);
    }
}

function checkCalStatus(dishesFiltered){

    let tempDishesFiltered = [];
    Array.prototype.push.apply(tempDishesFiltered, dishesFiltered);

    // indicator of no-checked status
    let noChecked = true;

    // count calories
    let calories = $('#calorie').find('.checkbox');

    // include checked calories
    for (let calorie of calories) {
        let low = parseInt(calorie.getAttribute('low'));
        let high = parseInt(calorie.getAttribute('high'));
        let value = calorie.checked;
        if (value) {
            noChecked = false;
        } else {
            // filter out dishes in this calorie range
            let dishesRemoved = dishesFiltered.filter(function(dish) {
                let calorieValue = dish['calorie'];
                return calorieValue > low && calorieValue <= high;
            });

            for (let elem of dishesRemoved) {
                let index = dishesFiltered.indexOf(elem);
                if (index >= 0) {
                    dishesFiltered.splice(index, 1);
                }
            }
        }
    }

    // restore input if none is checked
    if (noChecked) {
        Array.prototype.push.apply(dishesFiltered, tempDishesFiltered);
    }
}

function checkVegStatus(dishesFiltered) {
    let checked = $('#vegetarian').find('.checkbox')[0].checked;
    if (checked) {
        for (let i = 0; i < dishesFiltered.length; i++) {
            let dish = dishesFiltered[i];
            let veg = dish['vegetarian'];
            if (veg == 0) {
                dishesFiltered.splice(i, 1);
                i--;
            }
        }
    }

}

function checkSearch(dishesFiltered) {
    let keyword = $('#searchInput').val().toString().trim().toLowerCase();

    if (keyword ==  "") {
        // console.log("keyword is null.");

    } else {
        // console.log("keyword is: " + keyword);

        // filter out dishes not searched for
        let dishesNotSearched = dishesFiltered.filter(function (dish) {
            let keywordInName = isKeyword(keyword, dish['name']);
            let keywordInDesc = isKeyword(keyword, dish['description']);
            let keywordInCat = isKeyword(keyword, dish['category']);
            return !keywordInName && !keywordInDesc && !keywordInCat;
        });

        for (let elem of dishesNotSearched) {
            let index = dishesFiltered.indexOf(elem);
            if (index >= 0) {
                dishesFiltered.splice(index, 1);
            }
        }
    }
}

function isKeyword(word, sentence) {
    word = word.trim().toLowerCase();
    sentence = sentence.toLowerCase();
    let index = sentence.indexOf(word);
    if (index < 0) return false;
    else return true;
}
