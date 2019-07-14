<?php
/**
 * Individual Search & Filter function
 * Created by PhpStorm.
 * User: henry
 * Date: 3/10/18
 * Time: 18:08
 */

?>
<container>
    <div class="col">
        <div class="row" >
            <div class="col">
                <div class="row" id="addFood" style="display: none">
                    <button class="btn" id="addFoodBtn" data-toggle="modal" data-target="#dish-detail-admin">
                        <span>+  Food</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row" id="search-bar">
            <div id="searchForm">
                <form class="form-inline">
                    <input id="searchInput" class="form-control" type="search" placeholder="Search..." aria-label="Search">
                    <!--            <i id="searchIcon" class="material-icons btn">search</i>-->
                </form>
                <br>
            </div>

            <div id="category">
                <h1>Category</h1>
                <ul class="cleandot">
                    <li><input class="checkbox" type="checkbox" name="Combo" onchange="filter(this)"> Combo</li>
                    <li><input class="checkbox" type="checkbox" name="Meat" onchange="filter(this)"> Meat</li>
                    <li><input class="checkbox" type="checkbox" name="Seafood" onchange="filter(this)"> Seafood</li>
                    <li><input class="checkbox" type="checkbox" name="Vegetable" onchange="filter(this)"> Vegetable</li>
                    <li><input class="checkbox" type="checkbox" name="Soy" onchange="filter(this)"> Soy</li>
                    <li><input class="checkbox" type="checkbox" name="Mushroom" onchange="filter(this)"> Mushroom</li>
                    <li><input class="checkbox" type="checkbox" name="Wheat" onchange="filter(this)"> Wheat</li>
                    <li><input class="checkbox" type="checkbox" name="Base" onchange="filter(this)"> Base</li>
                    <li><input class="checkbox" type="checkbox" name="Sauce" onchange="filter(this)"> Sauce</li>
                    <li><input class="checkbox" type="checkbox" name="Drink" onchange="filter(this)"> Drink</li>
                </ul>
                <br>
            </div>

            <div id="price">
                <h1>Price</h1>
                <ul class="cleandot">
                    <li><input class="checkbox" type="checkbox" name="five_down" low="0" high="5" onchange="filter(this)"> $4.99 ↓</li>
                    <li><input class="checkbox" type="checkbox" name="five_to_ten" low="5" high="10" onchange="filter(this)"> $5 - $9.99</li>
                    <li><input class="checkbox" type="checkbox" name="ten_to_twty" low="10" high="20" onchange="filter(this)"> $10 - $19.99</li>
                    <li><input class="checkbox" type="checkbox" name="twty_up" low="20" high="65535" onchange="filter(this)"> $20 ↑</li>
                </ul>
                <br>
            </div>

            <div id="calorie">
                <h1>Calories</h1>
                <ul class="cleandot">
                    <li><input class="checkbox" type="checkbox" name="fivehd_down" low="-1" high="500" onchange="filter(this)"> 500 cal. ↓</li>
                    <li><input class="checkbox" type="checkbox" name="fivehd_to_tenhd" low="500" high="1000" onchange="filter(this)"> 501 - 1000 cal.</li>
                    <li><input class="checkbox" type="checkbox" name="ten_to_twty" low="1000" high="65535" onchange="filter(this)"> 1001 cal. ↑</li>
                </ul>
                <br>
            </div>

            <div id="vegetarian">
                <h1>Vegetarian</h1>
                <ul class="cleandot">
                    <li><input class="checkbox" type="checkbox" name="vege_or_not" onchange="filter(this)"> Show vegetarian food</li>
                </ul>
                <br>
            </div>
        </div>
    </div>

</container>


