# Multivendor - Released Version : RV-10.0.0

> IOS/Android Buyer APP version : 2.0.1
> System API version : 2.3

## New Features : 
    - Maintain Single seller products to buyer cart.
    - Collect customer comments on order product while checkout.
    - Hide product variants and merge product catalog and inventory form.
    - Product type as a service is added under product type.
    - Gift card feature added for buyers.

## Known Issues and Problems :

    - Following is a list of known errors that don’t have a workaround. These issues will be fixed in the subsequent release. 
        - Change in minimum selling price when reconfigured by Admin
        - Safari and IE 11 do not support our CSS. More info can be found at https://developer.microsoft.com/en-us/microsoft-edge/platform/status/csslevel3attrfunction/
        - System does not support Zero decimal currency while checking out with stripe
## Enhancements:
    - Load all categories on ajax call instead of page load.
    - Performance optimization to handle product ratings.
    - Geo location popup at the header section.
    - Language and currency selection via popup.
    - Displayed review images at the top of reviews list.
    - Performance optimization ar admin end, product search, filters and collections list.
    

## Bug Fixes:
    - Bug-074802 - Omise Payment gateway deprecated issue.
    - Bug-076133 - Stripe payment gateway functionality upgrade
    - Bug-076193 - The unlimited plan validity expires after 24 hours.
    - Bug-076198 - Unable to save downloadable file on new digital product.
    - Bug-077681 - The user can download the preview files but not able to preview within the system.
    - Bug-078138 - Product setup page gets distorted when the admin tries to paste the content in CMS editor (Firefox)
    - Bug-076927 - The shipping charges get refunded to the buyer even if the admin disabled return shipping charges to the customer setting
    - Bug-080244 - Error occur on the My Offers page on the buyer dashboard in Arabic language.
    - Bug-079388 - "Pay At Store" not working.
    - Bug-072665 - Product specification special character issue
    - Bug-084657 - User is unable to add inventory for services.
    - Bug-083721 - Depraction appears when the guest user tries to place a GDPRrequest
    - Bug-083863 - A fatal error occurs when the admin enables the Payout settings in the production mode.
    - Bug-084137 - Please remove the duplicity in the settings
    - Bug-084136 - Need to remove Brand parameters from Inventory Missing Info when linking brand with the catalog is not mandatory
    - Bug-085143 - 404 on the product details page when the new user creates a product.
    - Bug-085068 - cancellation is not working properly if stripe connect is on.
    - Bug-086044 - Branch 1: The image added in the review also appears in the product images gallery.
    - Bug-086039 - Branch 1: Admin sellers should not be able to add Volume discounts for services.
    - Bug-086030 - Branch 1: Order status changed to Paid if admin approves any transaction of less amount than the order amount.
    - Bug-086026 - Delivery Address field appears on the service order details page if ordered with physical products.
    - Bug-086006 - Branch 1: The deleted file also appears again if the user adds a new product with the same details as the deleted one.
    - Bug-086054 - 'Share and earn' page vibrates or shakes while scrolling
    - Bug-085928 - RTL >> 'Product Listing' Page Appears in English When Buyer Has Selected Arabic Language
    - Bug-085916 - RTL >> Issue on 'Inventory setup form
    - Bug-085851 - Deprecation appears on the reviews listing page on the front end.
    - Bug-085849 - Suggestion listing does not appear in the location popup on the homepage
    - Bug-085923 - "Without product variant" seller inventory listing still appears
    - Bug-085914 - A fatal error occurs on the checkout page when the admin enables the shipping plugin
    - Bug-085880 - Seller-added pickup address is visible on the checkout page even if shipped by admin only setting is enabled
    - Bug-085921 - Without product variants >> minimum selling price language label should be managebale for both conditions
    - Bug-085951 - Admin's default order-level shipping profile should get linked with seller products when "Shipped by admin" setting is enabled.
    - Bug-086019 - Suggestion >> The currently selected tab is not visually highlighted
    - Bug-085989 - Responsive >> Issue on sub modules of 'Reports' module
    - Bug-085957 - Branch 1 RTL >> Issues on ' Order Invoice' page on both buyer and seller end
    - Bug-085899 - Branch 1 RTL >> Month navigation icon on calendar does not appear in correct direction
    - Bug-086546 - Branch 1: The link product variant option should not appear on the Ribbons and Badges

## Hit URL:
    - admin/patch-update/updateProductRating  