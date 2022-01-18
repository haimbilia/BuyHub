<sidebar class="sidebar sidebar-hoverable" id="sidebar" data-close-on-click-outside="sidebar">
    <div class="sidebar-logo">
        <a href="#" class="logo">
            <img width="34" height="34" data-ratio="16:9" title="Yo!Kart" src="/yokart/admin/image/site-admin-logo/1?t=1638444603" alt="Yo!Kart">
        </a> <button class="sidebar-toggle sidebarOpenerBtnJs" type="button">
            <i class="fas fa-angle-double-right"></i>
        </button>
    </div>
    <div class="sidebar-menu sidebarMenuJs" id="sidebar-menu">
        <ul class="menu">
            <li class="menu-item dropdownJs">
                <button class="menu-section navLinkJs active" type="button" data-selector="[&quot;Home&quot;]" title="Home" onclick="redirectFn('/yokart/admin')">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-dashboard">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Home</span>
                </button>
            </li>
            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_PRODUCT_CATALOG" aria-expanded="true" aria-controls="collapseOne" title="Product Catalog">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-product-catalog">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Product Catalog</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_PRODUCT_CATALOG" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Brands&quot;]" href="/yokart/admin/brands">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Brands</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Shops&quot;]" href="/yokart/admin/shops">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Shops</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ProductCategories&quot;]" href="/yokart/admin/product-categories">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Categories</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Products&quot;]" href="/yokart/admin/products">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Products</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;SellerProducts&quot;]" href="/yokart/admin/seller-products">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Seller inventory</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Options&quot;, &quot;OptionValues&quot;]" href="/yokart/admin/options">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Options</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_REQUESTS" aria-expanded="true" aria-controls="collapseOne" title="Requests">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-requests">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Requests</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_REQUESTS" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;BrandRequests&quot;]" href="/yokart/admin/brand-requests">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Brand request(3)</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ProductCategoriesRequest&quot;]" href="/yokart/admin/product-categories-request">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Categories requests (1)</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" href="/yokart/admin/custom-products">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Custom product catalog requests (2)</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;SellerApprovalRequests&quot;]" href="/yokart/admin/seller-approval-requests">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Seller approval requests</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ThresholdProducts&quot;]" href="/yokart/admin/threshold-products">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Threshold products</span>
                            </a>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;OrderReturnRequests&quot;]" href="/yokart/admin/order-return-requests">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Order return requests (3) </span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;WithdrawalRequests&quot;]" href="/yokart/admin/withdrawal-requests">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Withdrawl requests (3) </span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;OrderCancellationRequests&quot;]" href="/yokart/admin/order-cancellation-requests">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Cancellation requests (5) </span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;OrderCancellationRequests&quot;]" href="/yokart/admin/badge-requests">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Badge request </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_ORDERS" aria-expanded="true" aria-controls="collapseOne" title="Orders">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-orders">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Orders</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_ORDERS" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Orders&quot;]" href="/yokart/admin/orders">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Orders</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;SubscriptionOrders&quot;]" href="/yokart/admin/subscription-orders">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Subscription orders</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;OrderCancelReasons&quot;]" href="/yokart/admin/order-cancel-reasons">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Order Cancel Reasons</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;OrderReturnReasons&quot;]" href="/yokart/admin/order-return-reasons">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Order Return Reasons </span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;OrderStatus&quot;]" href="/yokart/admin/order-status">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Order Statuses</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ProductReviews&quot;]" href="/yokart/admin/product-reviews">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Product reviews</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;AbandonedCart&quot;, &quot;AbandonedCartProducts&quot;]" href="/yokart/admin/abandoned-cart">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Abandoned cart</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_USERS" aria-expanded="true" aria-controls="collapseOne" title="Users">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-users">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Users</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_USERS" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;AdminUsers&quot;, &quot;AdminPermissions&quot;]" href="/yokart/admin/admin-users">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Admin users</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Users&quot;]" href="/yokart/admin/users">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text"> Users</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Rewards&quot;]" href="/yokart/admin/rewards">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Rewards</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Transactions&quot;]" href="/yokart/admin/transactions">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Transactions</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;DeletedUsers&quot;]" href="/yokart/admin/deleted-users">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Deleted users</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;UsersAddresses&quot;]" href="/yokart/admin/users-addresses">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Users addresses</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;UserGdprRequests&quot;]" href="/yokart/admin/user-gdpr-requests">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Gdpr requests</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Messages&quot;]" href="/yokart/admin/messages">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Messages</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_PROMOTIONS" aria-expanded="true" aria-controls="collapseOne" title="Promotions">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-promotions">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Promotions</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_PROMOTIONS" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;SpecialPrice&quot;]" href="/yokart/admin/special-price">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Special Price</span>
                            </a>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;VolumeDiscount&quot;]" href="/yokart/admin/volume-discount">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Volume Discount</span>
                            </a>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;RelatedProducts&quot;]" href="/yokart/admin/related-products">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Related Products</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;BuyTogetherProducts&quot;]" href="/yokart/admin/buy-together-products">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Buy together products</span>
                            </a>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Promotions&quot;]" href="/yokart/admin/promotions">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Ppc promotion management</span>
                            </a>
                        </li>


                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;RewardsOnPurchase&quot;]" href="/yokart/admin/rewards-on-purchase">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    rewards on purchase</span>
                            </a>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;SmartRecomendedWeightages&quot;]" href="/yokart/admin/smart-recomended-weightages">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    manage weightages</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;RecomendedTagProducts&quot;]" href="/yokart/admin/recomended-tag-products">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    recommended tag products weightages </span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;DiscountCoupons&quot;]" href="/yokart/admin/discount-coupons">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Discount coupons</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;PushNotifications&quot;]" href="/yokart/admin/push-notifications">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#mobile">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Push notifications</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Badges&quot;]" href="/yokart/admin/badges">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-badge">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Badges</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Ribbons&quot;]" href="/yokart/admin/ribbons">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-ribbon">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Ribbons</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_BLOG" aria-expanded="true" aria-controls="collapseOne" title="Blog">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-blog">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Blog</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_BLOG" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;BlogPostCategories&quot;]" href="/yokart/admin/blog-post-categories">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Blog Post Categories</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;BlogPosts&quot;]" href="/yokart/admin/blog-posts">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Blog Posts</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;BlogContributions&quot;]" href="/yokart/admin/blog-contributions">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Blog Contributions</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;BlogComments&quot;]" href="/yokart/admin/blog-comments">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span><span class="nav_text">Blog Comments</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_TAX" aria-expanded="true" aria-controls="collapseOne" title="Tax">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-sales-tax">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Tax</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_TAX" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;TaxStructure&quot;]" href="/yokart/admin/tax-structure">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Tax structure</span>
                            </a>
                        </li>

                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;TaxCategories&quot;]" href="/yokart/admin/tax-categories">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Tax categories</span>
                            </a>
                        </li>
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;TaxCategoriesRule&quot;]" href="/yokart/admin/tax-categories-rule">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Tax categories rule</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_CMS" aria-expanded="true" aria-controls="collapseOne" title="Cms">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-CMS">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Cms</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_CMS" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Slides&quot;]" href="/yokart/admin/slides">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Home page slides </span>
                            </a>
                        </li>
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;BannerLocation&quot;, &quot;Banners&quot;]" href="/yokart/admin/banner-location">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Banners </span>
                            </a>
                        </li>
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ContentPages&quot;]" href="/yokart/admin/content-pages">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Content pages </span>
                            </a>
                        </li>
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ContentBlock&quot;]" href="/yokart/admin/content-block">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Content block</span>
                            </a>
                        </li>
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;FaqCategories&quot;, &quot;Faq&quot;]" href="/yokart/admin/faq-categories">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Faqs</span>
                            </a>
                        </li>
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Testimonials&quot;]" href="/yokart/admin/testimonials">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Testimonials</span>
                            </a>
                        </li>
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Navigations&quot;]" href="/yokart/admin/navigations">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Navigations</span>
                            </a>
                        </li>
                        <li class="nav_item">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Collections&quot;]" href="/yokart/admin/collections">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Collections</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_REPORTS" aria-expanded="true" aria-controls="collapseOne" title="Reports">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-reports">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Reports</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_REPORTS" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level" id="reportsNav">
                        <li class="nav_item hasNestedChildJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-bs-toggle="collapse" data-parent="#salesReportNav" href="#salesReportNav" aria-expanded="true">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Sales Reports</span>
                                <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                            </a>
                            <div id="salesReportNav" class="panel-collapse collapse collapseJs">
                                <ul class="nav nav-level">
                                    <li class="nav_item navItemJs">
                                        <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;SalesReport&quot;]" href="/yokart/admin/sales-report">
                                            <span class="nav_text">Sales Over Time</span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;CatalogReport&quot;]" href="/yokart/admin/catalog-report">
                                            <span class="nav_text">Products</span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ProductsReport&quot;]" href="/yokart/admin/products-report">
                                            <span class="nav_text">Product Varients</span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ShopsReport&quot;]" href="/yokart/admin/shops-report">
                                            <span class="nav_text">Shops</span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;BuyersReport&quot;]" href="/yokart/admin/buyers-report">
                                            <span class="nav_text">Customers</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav_item hasNestedChildJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-bs-toggle="collapse" data-parent="#usersReportNav" href="#usersReportNav" aria-expanded="true">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Buyers reports </span>
                                <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                            </a>
                            <div id="usersReportNav" class="panel-collapse collapse collapseJs">
                                <ul class="nav nav-level">
                                    <li class="nav_item navItemJs">
                                        <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;UsersReport&quot;]" href="/yokart/admin/users-report/index/1">
                                            <span class="nav_text">
                                                Buyers </span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;UsersReport&quot;]" href="/yokart/admin/users-report/index/2">
                                            <span class="nav_text">
                                                Sellers </span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;AffiliatesReport&quot;]" href="/yokart/admin/affiliates-report">
                                            <span class="nav_text">
                                                Affiliates </span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;AdvertisersReport&quot;]" href="/yokart/admin/advertisers-report">
                                            <span class="nav_text">
                                                Advertisers </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav_item hasNestedChildJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-bs-toggle="collapse" data-parent="#financialReportNav" href="#financialReportNav" aria-expanded="true">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Financial report</span>
                                <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                            </a>
                            <div id="financialReportNav" class="panel-collapse collapse collapseJs">
                                <ul class="nav nav-level">
                                    <li class="nav_item navItemJs">
                                        <a href="/yokart/admin/earnings-report" class="nav_link navLinkJs ">
                                            <span class="nav_text">Earnings</span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a href="/yokart/admin/product-profit-report" class="nav_link navLinkJs ">
                                            <span class="nav_text">Profit by products</span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a href="/yokart/admin/preferred-payment-method" class="nav_link navLinkJs ">
                                            <span class="nav_text">Preferred payment method</span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a href="/yokart/admin/payout-report" class="nav_link navLinkJs ">
                                            <span class="nav_text">Payout</span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a href="/yokart/admin/transaction-report" class="nav_link navLinkJs ">
                                            <span class="nav_text">Transaction report</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav_item hasNestedChildJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-bs-toggle="collapse" data-parent="#subscriptionReportNav" href="#subscriptionReportNav" aria-expanded="true">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">subscription report</span>
                                <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                            </a>
                            <div id="subscriptionReportNav" class="panel-collapse collapse collapseJs">
                                <ul class="nav nav-level">
                                    <li class="nav_item navItemJs">
                                        <a href="/yokart/admin/subscription-plan-report" class="nav_link navLinkJs ">
                                            <span class="nav_text">by plan</span>
                                        </a>
                                    </li>
                                    <li class="nav_item navItemJs">
                                        <a href="/yokart/admin/subscription-seller-report" class="nav_link navLinkJs ">
                                            <span class="nav_text">by seller</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;DiscountCouponsReport&quot;]" href="/yokart/admin/discount-coupons-report">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Discount coupons </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_IMPORT_EXPORT" aria-expanded="true" aria-controls="collapseOne" title="Import Export">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-import-export">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Import Export</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_IMPORT_EXPORT" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ImportExport&quot;]" href="/yokart/admin/import-export">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Import Export</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_SHIPPING" aria-expanded="true" aria-controls="collapseOne" title="Shipping/pickup">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-shipping-pickup">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Shipping/pickup</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_SHIPPING" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ShippingCompanyUsers&quot;]" href="/yokart/admin/shipping-company-users">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Shipping company users</span>
                            </a>
                        </li>


                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs" data-selector="[&quot;ShippingProfile&quot;]" href="/yokart/admin/shipping-profile">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Shipping profile</span>
                            </a>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;PickupAddresses&quot;]" href="/yokart/admin/pickup-addresses">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Pickup addresses</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ShippedProducts&quot;]" href="/yokart/admin/shipped-products">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Shipped products</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item dropdownJs">
                <button class="menu-section dropdown-toggle-custom menuLinkJs collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#NAV_SEO" aria-expanded="true" aria-controls="collapseOne" title="Seo">
                    <span class="menu-icon">
                        <svg class="svg" width="24" height="24">
                            <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-SEO">
                            </use>
                        </svg>
                    </span>
                    <span class="menu-title">Seo</span>
                    <i class="menu_arrow dropdown-toggle-custom-arrow"></i>
                </button>
                <div class="sidebar-dropdown-menu collapse" id="NAV_SEO" aria-labelledby="" data-parent="#sidebar-menu">
                    <ul class="nav nav-level">
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;UrlRewriting&quot;]" href="/yokart/admin/url-rewriting">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Url Rewriting</span>
                            </a>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;ImageAttributes&quot;]" href="/yokart/admin/image-attributes">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">
                                    Image attributes</span>
                            </a>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;Sitemap&quot;]" href="/yokart/admin/sitemap/generate">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span><span class="nav_text">Generate Sitemap</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" target="_blank" href="http://localhost/yokart/custom/sitemap">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">View Html</span>
                            </a>
                        </li>
                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" target="_blank" href="http://localhost/yokart/sitemap.xml">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">View Xml</span>
                            </a>
                        </li>

                        <li class="nav_item navItemJs">
                            <a class="nav_link navLinkJs dropdown-toggle-custom" data-selector="[&quot;MetaTags&quot;]" href="/yokart/admin/meta-tags">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#test">
                                        </use>
                                    </svg>
                                </span> <span class="nav_text">Meta Tags Management</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="sidebar-foot">
        <ul class="menu">
            <li class="menu-item dropdownJs">
                <div class="sidebar-dropdown-menu">
                    <ul class="nav">
                        <li class="nav_item navItemJs">
                            <a href="" class="nav_link navLinkJs">
                                <span class="nav_icon">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="/yokart/admin/images/retina/sprite-aside-menu.svg#icon-system-settings">
                                        </use>
                                    </svg>
                                </span>
                                <span class="nav_text">Settings</span>
                            </a>
                        </li>

                    </ul>
                </div>


            </li>
        </ul>


    </div>
</sidebar>