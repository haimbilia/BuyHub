<?php $cartItemsCount = $cartItemsCount ?? 1; ?>
<div class="step">
    <ul class="review-block">
        <li class="review-block-item">
            <div class="review-block__label skeleton w-25">
                <!-- Shipping To Label -->
            </div>
            <div class="review-block__content" role="cell">
                <div class="delivery-address">
                    <!-- Address Lines -->
                    <p class="skeleton"></p>
                    <p class="skeleton"></p>
                    <!-- Address Lines -->

                    <p class="skeleton w-25">
                        <!-- Phone Number -->
                    </p>
                </div>
            </div>
        </li>
    </ul>

    <div class="step_section">
        <div class="step_head skeleton w-50">
            <!-- Shipping Summary Header -->
        </div>
        <div class="step_body">
            <ul class="list-cart list-shippings">
                <li class="list-cart-item list-shippings-head">
                    <div class="shop-detail shipping-select">
                        <h6 class="skeleton w-25">
                            <!-- Ship By Shop Name -->
                        </h6>
                        <div class="skeleton w-50">
                            <!-- Shipping Price -->
                        </div>
                    </div>
                </li>
                <?php for ($i = 0; $i < $cartItemsCount; $i++) { ?>
                    <li class="list-cart-item block-cart">
                        <div class="block-cart-img skeleton" style="height: 150px;">
                            <!-- Product Image -->
                        </div>
                        <div class="block-cart-detail">
                            <div class="block-cart-detail-top">
                                <div class="product-profile">
                                    <div class="product-profile-data">
                                        <div class="skeleton w-75">
                                            <!-- Item Name -->
                                        </div>
                                        <div class="products-price skeleton w-25">
                                            <!-- Item Price -->
                                        </div>
                                        <div class="options skeleton">
                                            <!-- Item Options -->
                                        </div>
                                    </div>
                                </div>
                                <div class="product-quantity skeleton w-25">
                                    <!-- Item Quantity -->
                                </div>
                            </div>
                            <div class="block-cart-detail-bottom">
                                <p class="skeleton w-25">
                                    <!-- Action Button (Remove Link) -->
                                </p>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>