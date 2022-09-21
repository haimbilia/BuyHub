<?php $cartItemsCount = $cartItemsCount ?? 1; ?>
<div class="step">
    <div class="step_section">
        <div class="step_body">
            <ul class="list-cart list-shippings">
                <?php for ($i = 0; $i < $cartItemsCount; $i++) { ?>
                    <li class="list-cart-item list-shippings-head block-cart">
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