# Multivendor - Released Version : RV-10.0.0

> IOS/Android Buyer APP version : 2.0.1
> System API version : 2.3

## New Features : 
    - Maintain Single seller products to buyer cart.
    - Collect customer comments on order product while checkout.
    - Hide product variants and merge product catalog and inventory form.

## Known Issues and Problems :

    - Following is a list of known errors that don’t have a workaround. These issues will be fixed in the subsequent release. 
        - Change in minimum selling price when reconfigured by Admin
        - Safari and IE 11 do not support our CSS. More info can be found at https://developer.microsoft.com/en-us/microsoft-edge/platform/status/csslevel3attrfunction/
        - System does not support Zero decimal currency while checking out with stripe
## Enhancements:
    - Load all categories on ajax call instead of page load.
    - Performance optimization to handle product ratings.

## Bug Fixes:
    - Bug-074802 - Omise Payment gateway deprecated issue.
    - Bug-076133 - Stripe payment gateway functionality upgrade
    - Bug-076193 - The unlimited plan validity expires after 24 hours.
    - Bug-076198 - Unable to save downloadable file on new digital product.
    - Bug-077681 - The user can download the preview files but not able to preview within the system.
    - Bug-078138 - Product setup page gets distorted when the admin tries to paste the content in CMS editor (Firefox)
    - Bug-076927 - The shipping charges get refunded to the buyer even if the admin disabled return shipping charges to the customer setting
    - Bug-080564 - Buy now button should not be there on the Detail page after offer acceptance.
    - Bug-080559 - Hide price setting is not working properly
    - Bug-080573 - no option appears to purchase a product or place rfq on the detail page.
    - Bug-080931 - Shipping address is not similar to that of the defined address in the rfq form
    - Bug-080934 - Multiple issues in email templates in case of rfq
    - Bug-080917 - Variant selction does not appear properly
    - Bug-080895 - it still shows manageblity for Rfq on shop level and Inventory level on admin end.
    - Bug-082740 - The 'Enable RFQ' toggle button continues to appear on the 'Inventory Setup' page of the seller, even though the seller has disabled the 'Enable RFQ Module' toggle button on the 'Shop Details' page.
    - Bug-082748 - 'Available quantity' of a product decreases when RFQ order of the product is completed
    - Bug-082754 - When the 'Available Quantity' is 0, the buyer is unable to place the RFQ order
    - Bug-082765 - No validation message appears when buyer does not add Delivery Address on 'Request a quote' popup box.
    - Bug-082762 - The unit of the ordered quantity should be displayed on the 'Your Shopping Bag' page of buyer
    - Bug-080244 - Error occur on the My Offers page on the buyer dashboard in Arabic language.
    - Bug-079388 - "Pay At Store" not working.
    - Bug-082913 - Reorder functionality need to be managed properly.
    - Bug-082875 - Shop name does not direct the user to shop detail page
    - Bug-082874 - Price still appears for when hide price is enabled on system level
    - Bug-072665 - Product specification special character issue
    - Bug-083140 - The same setting appears twice under the product settings
    - Bug-083245 - Services: A warning appears when the seller/admin tries to update the media sequence using drag and drop.
    - Bug-084657 - User is unable to add inventory for services.
    - Bug-083721 - Depraction appears when the guest user tries to place a GDPRrequest
    - Bug-083863 - A fatal error occurs when the admin enables the Payout settings in the production mode.
    - Bug-084137 - Please remove the duplicity in the settings
    - Bug-084136 - Need to remove Brand parameters from Inventory Missing Info when linking brand with the catalog is not mandatory
    - Bug-084664 - Add inventory button is not working properly.
    - Bug-084668 - it shows wrong information text.
    - Bug-084662 - Offer acceptance flow is not proper in some cases
    - Bug-084643 - it shows an invalid validation message.
    - Bug-084638 - It shows unnecessary accept button and if clikced them creates a conflict.
    - Bug-084644 - platform non registered product's name should not be clickable.
    - Bug-084640 - Looking for field's options are not proeprly visible in mobile and tablet devices
    - Bug-084639 - Category field's ui is not proper in global RFQ form
    - Bug-084742 - All Data should appear in the downloaded RFQ details
    - Bug-084727 - Email template is not proper in case of global RFQ.
    - Bug-084726 - RFQ title should not appear as bold and clickable.
    - Bug-084724 - Calender field's is not properly clickable
    - Bug-084722 - Admin is able to assign any seller in case if Buyer had selected only one while filling form
    - Bug-084718 - Favourite option is not coming even if a guest user have added the shop in fav
    - Bug-084716 - Seller is unable to see that which inventory has been linked with the RFQ.
    - Bug-084709 - Back button Redirection is not proper from GLobal RFQ offer detail page
    - Bug-084700 - Attachment acess is not working properly
    - Bug-084712 - There is no option to remove the atached file in the rfq form
    - Bug-084775 - Content missing for No data found while searching Brand name.
    - Bug-084685 - Dropdown suggestions still shows selected seller name.
    - Bug-084686 - User is still able to activate the disabled field from console. 
    - Bug-085023 - Global RFQ flow is not working properly
    - Bug-085117 - Address Label Field Exceeds Character Limit in Shipping Address Form
    - Bug-085115 - 'Duplicate offer with same quantity' error still appears when admin tries to add an offer for the same seller after deleting the previous offer.
    - Bug-085113 - The admin can accept the buyer's offer on behalf of the seller when the seller has not linked the product's inventory
    - Bug-085132 - issue on 'RFQ detail' page of buyer and seller account
    - Bug-085112 - 'New' button does not appear for the RFQ sent to a particular seller.
    - Bug-085196 - 'Reject' button should appear to buyer when seller has given the offer while the 'Buyer can negotiate the offer' toggle button is disabled.
    - Bug-085191 - RFQ >> suggestion >> 'New' button should be replaced with 'Offer' text.
    - Bug-085186 - RFQ >> Suggestion >> A validation message should be displayed to the seller when they attempt to accept the buyer's counteroffer without linking the inventory
    - Bug-085183 - 'Accept' button still appears for the seller's offer to the buyer even when seller has accepted the counter offer
    - Bug-085177 - 'Final Acceptance button does not appear to seller when buyer accepts the offer of seller

## Hit URL:
    - admin/patch-update/updateProductRating  