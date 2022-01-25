
Release Number : 
Release Date : 

New Feature :     
    => 88083 : System Log Listing Page 
    
Updates: N/A
	
Fixes: N/A
    
    
================================================================================

Multivendor - Released Version : RV-9.3.1
    => IOS/Android Buyer APP version : 2.0.1
    => System API version : 2.3

New Feature :     
    => 82892 : Easypost Shipping API Integration
    => Shopify sync module for SV seller
    => 85399 : QNB payment gateway 
    => 80928 : Mollie payment gateway 
    => MSG-1390138 : Payfast payment gateway 
    => 85369 : Aramex Shipping API 
    => 72808 : EasyEcom Marketplace Channel API
    => 86472 : YoCo Payment gateway
    => 88040 : ShipRocket Shipping API Integration
    => 88449 : ShipEngine Shipping API Integration

Updates/Fixes : 
    => 052459 - Repeat Fetched Rates from EasyPost API Plugin
    => 052463 - Setup shipping of other product not working with EasyPost
    => 053622 - Load all font family variants
    => 053451 - missing country code plugin with phone number field
    => 053462 - Instagram login not working after configuration, gives error
    => 053757 - when order status is changed then sms are not triggering to buyer for the same
    => 053451 - missing country code plugin with phone number field
    => 053462 - Instagram login not working after configuration, gives error
    => 053757 - when order status is changed then sms are not triggering to buyer for the same
    => 053612 - when tax is collected by admin and commission incl tax then invoice is having some issues
    => 053908 - when admin creates category collection (category layout 1) more than once with same category then in second collection> products are not populating
    => 054447 - when product having multiple options then on detail page> options are not listing properly
    => 054613 - Error display on invoice pdf page
    => 054742 - wrong message is populating on button on tooltip
    => 054591 - Getting delivery field in tax invoice on pickup order
    => 054711 - when multiple products are linked with same shipping profile then pagination count is not proper
    => 052651 - on using comma as currency separator it's not impacting in text areas 
    => 052654 - Admin can create seller/buyer/advertiser/affiliate account from back-end - Not working
    => 052664 - admin> users> asterisk marked field shouldn't be mandatory for admin 
    => 053779 - seller> reports> currency symbol is missing in tax and shipping column
    => 053782 - admin> reports> sales reports> on accessing reports for particular date> there needs to be filter to search on basis of invoice or order by time (latest on top and vice versa)
    => 053816 - admin> reports> buyers report>sorting is not working
    => 053823 - seller reports> total order count is listing of child orders while on seller end it's counting parent order.
    => 053833 - currency symbol changed to euro (€) is not populating on exporting reports
    => 053501 - seller> unable to define slots for pickup- getting error 
    => 053763 - admin> users> add button> icon is not there
    => 053749 - in reports> PRODUCT > on entering character value in from price filed> errors are listing there
    => 053753 - Shop >> filters >> conditions are not getting displayed under conditions filter
    => 053861 - In Side bar only number of items displayed.
    => 053822 - seller reports> balance is not populating
    => 053883 - pickup slots are not getting listed on front end while placing order on selection of address
    => 053882 - getting error on product detail page under recommended products
    => 053817 - on registration screen> logo is not displaying
    => 053832 - rating star color is different in admin and front end
    => 053932 - while placing order> when no coupon or discount is there then getting entry on name of saving
    => 053954 - Not storing Product unit price so in report data not coming
    => 053985 - Stripe connect unable to debit site commission
    => 053850 - admin> advertiser report> data is not populating.
    => 053849 - admin> advertiser report> keyword search needs to be there in filter
    => 053751 - after applying filters and exporting file in reports> all data is exporting instead of filtered data
    => 053935 - when buyer purchases multiple qty (incl. tax) then on seller end in transactions it's listing $1000.02 and under reports it's listing $1000 and on buyer end it's listing $0.01 as rounding off amount
    => 053948 - getting invalid slot when buyer changes date for pickup (admin's place)
    => 053855 - admin> reports> top products> filter> search by keyword is missing 
    => 054351 - when seller B purchases subscription then in Subscription Seller Report> subscription name for seller A changes similar to seller B
    => 054278 - if for any digital item there is no preview available then preview tab shouldn't be displayed
    => 054144 - Set Default Location not populating on front end after set by admin
    => 054071 - Product Download Attachments At Inventory Level for catalog is missing in import/export
    => 054441 - admin> shipping> Shipped Products By Admin> pagination is not working on facebox.
    => 054526 - when seller purchases subscription then on order success screen> neither adjusted amount is listing (if there), nor the original amount of package
    => 054441 - admin> shipping> Shipped Products By Admin> pagination is not working on facebox
    => 054499 - reviews added with category are not listing in admin    
    => 054527 - Blog >> some error is there
    => 054599 - when order is on pickup and status is changed to ready for pickup it gets stuck and on refreshing the page> getting error on screen
    => 054447 - when product having multiple options then on detail page> options are not listing properly
    => 054529 - On FAQ >> if any letter is in caps then it is not highlighting on search
    => 054545 - when subscription is downgraded and after adjustment amount becomes 0 then on applying coupon it's getting the total in negative
    => 054597 - generate label is coming on seller end on pickup order 
    => 054611 - while adding hipping profile> on deselection of region/country> linked states and countries are listing as selected
    => 054612 - login with otp is working with default otp 0000
    => 054616 - after submitting review> getting error on review page- front end
    => 054717 - on recently view product error coming on product detail page
    => 054731 - when review is placed with media then there is no need to add show more on 6th image
    => 054761 - despite having sku non mandatory it's not adding inventory from seller end
    => 054814 - admin> catalog> rating type> search is not working
    => 054813 - admin> catalog> rating types> rating types sr. no are not listing properly on changing page
    => 055069 - on product detail page undefined index: theprice notice coming
    => 055077 - when cookies policy are turned off from admin then recently viewed items are not listing on detail page of product
    => 055104 - seller dashboard> data migration tab is not highlighting on accessing
    => 055093 - while changing seller approval request if admin declines request without message then on front end it's listing heading- reason for cancellation which is blank
    => 055092 - when cookies are not allowed from admin still then user have option for the same in account
    => 055090 - when truncate request is raised by user then in admin> it's listing- view purpose which is not there on user end
    => 055597 - before checkout> there is no halt on last step- it's redirecting automatically to payment gateway
    => 054137 - Issue in product refund stats
    => 054183 - on admin order cancellation page roundoff error coming
    => 054242 - paystack gateway not supporting ZAR currency        
    => 054201	while adding catalog for digital item> only option to add attachment at inventory level is either Yes or No
    => 054208 - while uploading files> it's taking too much time to save data and meanwhile loader disappears- seems like process has been aborted
    => 054204	while adding catalog> when add attachment is set to No then > download tab is listing for that inventory setup too
    => 054206	there needs to be some message on inventory level when attachments are not allowed to add at inventory
    => 054212	while adding inventory> when we add link and url is long then UI is not proper
    => 055154	digital items> files linked with specific language are listing all on front end in preview
    => 055135	when digital catalog is added by admin and files are attached by admin and then seller should be allowed to see the name of file only not download
    => 055155	when admin adds catalog with digital links then on seller end links (preview and main) both are listing
    ====================TV-9.3.1.20210703==========================
    => 055215 - when only language is enabled in system then in header> language drop down is coming with single value
    =====================TV-9.3.1.20210705========================

    => 055632 - on accessing digital preview file from front end getting error
    => 055631 - when pickup order is canceled by seller then listing delivery charges field on screen
    ======================TV-9.3.1.20210708====================== 
    => 055604 - zip file needs to be exported on click of download button on buyer end containing (files and link) just like Tribe
    => 055720 - admin> promotions> ribbon> bind conditions> list having select option which is of no use and on selecting, nothing appears on top for operations
    => 055721 - admin> promotions> ribbon> bind conditions> filters> fields are not aligned properly
    => 055689 - while returning if there is no file attached still then listing download button on return order detail page on buyer end
    => 055715 - when single badge is linked with item then it's listing multiple times on product detail and shop
    => 055026 - corresponding to review> images added are not listing on front end
    => 055800 - when seller accesses order detail page then getting fatal
    => 055748 - when badge/ribbon is turned off from admin still then its listing on seller dashboard but not listing on front end 
    => 055746 - favorite option is missing on product detail page on buyer end
    => 055801 - admin can create multiple badges for a seller
    => 055802 - badges created by seller are getting edited by admin and allowing him to add other seller items to that
    => 055813 - Notice: Undefined variable: Shop/view.
    => 055810 - on viewing wish list from buyer> getting error
    => 055809 - when admin clicks on complete button for gdpr request then getting error
    => 055808 - when user requests for the data then in popup> email is not there in field
    => 055807 - ribbon linked by seller1 are getting edited by admin and allowing him to add other seller2 items to that
    => 055816 - remove phone number suggestion with fields throughout system
    => 055824 - seller> manage ribbons> link type is coming with n/a while values are there on editing the same
    => 055826 - when subscription is purchased through stripe connect then in admin> order detail page> payment mode is not listing
    => 055833 - admin> requests> badge request filters> buttons are not proper
    => 055832 - when admin creates badges (automatically) for completed orders then it's not listing on product detail page
    => 055840 - Google Shopping Feed Enhancement Changes
    => 055850 - Warning : Creating default object from empty value
==============================TV-9.3.2.20210716=====================================
    => 055874 - getting invalid request on linking rating type with new category
    => 056100 - Notice: Undefined index: op_special_price
    => 056031 - on order when tax is bifurcated in 3 types then on invoice listing 2 only
    => 056021 - when multiple items are ordered together then on packing slip> getting wrong data listed
    => 056034 - when order is canceled still then seller having option to generate shipping label for the same
    => 056029 - when ship by admin only is enabled then on seller end> shipping plugins are listing
    => 056166 - Warning: strtolower() expects parameter 1 to be string, array given in /library/core/FatUtility.class.php on line 0
    => 056027 - getting crash on approving return request when tax is incl price and and avalara is enabled
    => 056025 - when taxjar is enabled then on cart page> getting error
    => 056030 - when tax is enabled (avalara) then on bifurcation tax value is not listing properly
    => 056134 - getting error on marking order as completed from admin when tax is alavara and order cancellation request is declined
    => 055906 - Seller >> tax category >> tax rates >> "0.00" gets displayed along with actual percentage of tax .
    => 056199 - Paypal Payout Not Working : Client Auth Failed
    => 056197 - on adding item to wishlist getting 404
    => 056195 - admin> promotions> coupon> link> product and brand both tabs are highlighting 
    => 056194 - seller> wallet> withdrawal through paypal payout> getting 404

=========================TV-9.3.2.20210720=====================================
    => 056192 - Showing fatal error while opening settings of split payment method.
    => 056225 - The settings are not getting saved for the related product settings under Admin dashboard
    => 056228 - Undefined Variable rating types
    => 056229 - Notice: Undefined index: oua_phone_dcode
    => 055714 - seller> promotions> manage badges> when there is no data then message is not aligned
==========================TV-9.3.2.20210723========================================
    => 056222 - buyer/seller dashboard> logo is redirecting to dashboard instead of home page
    => 056147 - buyer> orders> feedback form> rating stars are not populating
================TV-9.3.2.20210726===================
    => 056373 - if admin shipping is enabled then even seller is credited with shipping amount
    => 056221 - seller> inventory> badges and ribbon collectively not working in filter
===============TV-9.3.2.20210728====================
    => 056264 - Shop details >> If "use manual shipping rates" checkbox is not checked then "postal code" should be mandatory
    => 056246 - Catalog -> Shipping options
    => 056265 - Admin >> General settings >> local > postal code and address should be mandatory as it requires when we use shipping API
    => 056337 - getting notices on checkout screen when multiple items are there in cart
    => 056340 - label generation option is coming on order when order is marked as completed
    => 056344 - on moving item to wish list from cart getting 404 
    => 056509 - Unable to change phone number if SMS plugin on
    => 056427 - after registration through phone number and configuring details post login page is flooded with errors
    => 056414 - Admin >> users >> for sub sellers >> edit >> bank account and address tabs are getting displayed only when we click on "cookies " tab
    => 056413 - Checkout (pickup ) >> when we select slot then "undefined " gets displayed on selected time and date
    => 056412 - Checkout (pickup ) >> when we select slot then popup should get closed.
    => 056410 - admin >> notifications for shop report > when we click on report notification then admin gets redirect to report reasons instead of report listing
    => 056508 - on order cancellation requests error coming at admin side
    => 056406 - admin> seller orders> ship by seller/admin needs to be there in listing and in filters too
===================TV-9.3.2.20210730==================
    => 056367 - once order is generated with aftership then link is not getting generated on seller/buyer end
    => 056366 - once after ship is enabled then on accessing email for the same is flooded with errors
    => 056362 - seller order is not accessible when only tracking api is enabled and order is marked s shipped
    => 056349 - admin> during login> getting message overlapped
    => 056555 - Unable to view products when seller has pending subscription
    => 056568 - on admin seller product left navigation wrong seller order count
    => 056585 - on manage collections Banner layout1 and layout2 has wrong image of layout
    => 056600 - Wallet recharge wrong URL
    => 056314 - on removing item from wishlist getting 404
    => 056263 - Cart >> For save for later >> "move to wishlist " tool tip is there instead of " save for later".
    => 056243 - seller> payout report> filters> buttons are not aligned with fields
    => 056398 - when tax is zero then on generating slip getting wrong tax amount listed
    => 056236 - Affiliate / advertiser >> some warnings are there. 
    => 056237 - if any user is logged in then 404 page is getting opened if we click on "become a seller " , " Advertise with us" or " register as affiliate" link in footer.
    => 056239 - seller> buy together> on clicking existing items getting error
    => 056241 - seller> sales reports> back button is not working
    => 056293 - Shipping profile is not getting created from admin end 
====================TV-9.3.2.20210805========================
    => 056898 - Seller/Buyer is not able to click on the "Accept Cookies" button
    => 056944 - on saving seller catalog specification at admin end error coming
    => 056959 - on updating seller order getting error at admin end 
    => 056954 - Seller: Country code is not showing while adding the Contact Number in the Seller Approval form
    => 056948 - Web Buyer: Getting a "404 error" while clicking on the "Open a Store" button on the front end
    => 057017 - importing seller products in german getting error invalid csv column
    => 057089 - Admin: Suggestion to override the images while uploading multiple images because we are showing only one image for the Brands at the buyers end
    => 057115 - Seller and Admin: "+" button is not showing while adding the pickup address' for "All days" Time Slots
    => 057163 - while adding the option in catalog getting struck in ajax loop

===========================TV-9.3.2.20210810==================
    => 057137 - Getting error while stripe connect transfer seller part
    => 057130 - Admin, Seller, and Buyer: Suggestion to give an "option" to Redirect to the Order details page on the Cancelled and Returned requests list
    => 057117 - Seller and Admin: Shipping packages' details are not showing on the Order details page with the Product
    => 057145 - Seller: Suggestion to dont allow the seller to add a Special Price greater than the Current Price
    => 057160 - Uncaught TypeError: Cannot set property scrollTop of undefined
    => 057112 - Seller: JSON error is receiving while adding the inventory for the Admin's products
    => 057113 - on submitting product review getting error 
    => 057109 - Buyer: Records are created in the "Reward Points" section with 0 value while placing an order
    => 057115 - Seller and Admin: "+" button is not showing while adding the pickup address' for "All days"
    => 057144 - Admin: "Complete" option is showing in the "User Gdpr Requests" section when the seller "Request to Remove My Data"
    => 057171 - Buyer: Suggestion to show the "Order ID" with cancelled order under the "My Credit" section
    => 057177 - Buyer: Suggestion to show the "Return Order Age" in the Order details page at the buyers end
    => 057166 - Buyer: "Share and Earn" functionality is not working properly
    => 057221 - Seller: "Categories and Tax Categories" listing is not showing when sellers click on these fields but, for brand listing is showing
    => 057217 - Seller and Buyer: Suggestion to show the "Cancel Order" button instead of the "Cross" icon in the order details
    => 057212 - The "same status" of order is updating when Seller clicks on the "Save Changes" button multiple times
    => 057238 - Buyer: Order ID is not showing with the "Earned Reward Points On Purchase" under the reward points section
    => 057227 - Admin and Seller: Suggestion to give some indication regarding the "Product Warranty" field is in Days or Months or Year while adding the product
    => 057044 - Seller: UI design is not correct while uploading the Banner and Logo for the Shop
==========================TV-9.3.2.20210813=============================
    => 057270 - Seller: Badges requests list is not showing if the first request is for Badges
    => 057264 - Admin: "Link to" field is not working while clicking on it and UI is also not correct on the "Badges request" section
    => 057261 - Admin: "Invalid Request" error is showing while clicking on the "Link" field after selecting "link type" in the Ribbons
    => 057258 - Admin: Back button linking is not correct for the Ribbons functionality
    => 057257 - Seller: Blank Confirmation message is showing while deleting the Product from the ribbon
    => 057304 - Admin: An error message is not correct while adding the same Badges name
    => 057281 - Seller: There is no option to delete the ribbons and badges listing
    => 057287 - Seller: There is no information regarding the seller satisfy the "Automatic badges" conditions
    => 057228 - Admin and Seller: Suggestion to give some indication regarding the "Display Time Slots After Order [Hours]", where it will be used? 
    => 057256 - on promotion add page time picker not coming
    => 057269 - Seller: Text is not correct on the "Requests" section
    => 057262 - Seller: More than two ribbons are showing for the products inventory
    => 057372 - Getting error while sending email from Users tab
    => 057408 - Buyer: "Undefined variable" error is showing while clicking on the Seller's collection
    => 057405 - Buyer: "Fatal error" is showing while clicking on the newly added Slides promotions
    => 057403 - Seller: Suggestion to don't show the selected products in the drop-down while adding the collections
    => 057396 - Advertiser: "404 error" is showing while clicking on the "Email Verification" link
    => 057391 - Buyer: A warning message is showing while clicking on the "Affiliate" option
    => 057384 - Admin: Information is missing regarding "Content Blocks
    => 057444 - If brand is mandatory then while importing getting error
    => 057684 - in apple app mp4 tried to run instead of download
    => 057715 - Badge condition listing for automatic case.
    => 057716 - Notice: Undefined variable: siteLangId in application/views/_partial/picture-tag.php
    => 057725 - Multiple first time purchase discount coupons are getting created by the system for one user
    => 057749 - Category with no product is also listing on view all category
    => 057717 - Admin: "Undefined variable" error is showing while searching on the "Catalog Report" section
    => 057775 - Fatal error: Uncaught TypeError: Argument (Checkout listing)
    => 057381 - Admin: Noting is showing under the "Banner Layouts" listing
    => 057778 - Product Detail and Shop View Page Copy link not working and invalid URL to copy
    => 057781 - Display processing if call ajax from fcom ajax
    => 057783 - while exporting file in russin language file name coming with unwanted string
    => 057535 - Advertiser: Remove the "My Message" icon for the Advertiser
    => 057884 - On page pages generic location label used
    => 057956 - importing category enable/disable issue
    => 057971 - Review/Feedback image is not visible when we click on any image on frontend
    => 057972 - Aftership tracking service can be enabled even when no shipping service is enabled
    => 057973 - While adding badge or ribbon name RTL mode chracters are displayed in LTR Mode
    => 057956 - importing category enable/disable issue 
    => 058034 - in blank db dummy data exist
    => 058112 - Stripe connect registration tab content not loading
    => 058142 - we should have zone export/import
    => 058197 - on email header logo static link is there
    => 058449 - import Product seo data not working 
    => 058462 - on product detail page specification not coming with group 
    => 058450 - product stock availability issue
    => 058557 - pagination issue in admin seller product pages
    => 058768 - if category identifier contain apostrophe then filter not coming on category page
    => 058807 - Unable to change the URL for a sellers collection    
    => 059263 - On order product search with lang there is query issue 
    => 059798 - invalid mime type error coming while uploading doc file in blog contribution
    => 059422 - Seller: Admin disable the "Allow Sellers To Add Products" option and then, "Add Seller's Shipping profile" option is not showing to add the shipping for the marketplace product
    => 059821 - new tag unable to add in catalog
    => 059913 - on home page favorite icon not updating
    => 060820 - On order subscription getting error
    => 060772 - Admin UI: Admin is not able to edit the 'Minimum Purchase Quantity' and 'Discount (%)' fields under the Volume Discount section
    => 060775 - Admin UI: Product's listing is not showing while adding the 'related products and facing some UI issue under the "Related Products" section
    => 061094 - Admin UI: Titles are not showing in the table and it is a mandatory field
    => 061073 - Admin UI: Heading is missing for the search's dropdown under the "meta tags management" section 
    => 061115 - commission going negative when refund the product [RV-9.3.1]
    => 061057 - Admin UI: 'URL Rewriting' is not working for the SEARCH
    => 061025 - Admin UI: Loader is not showing while uploading the media on the whole system 

New Features:  
    => Admin shipped products listing page
    => task-84719 Preview module for digital files
    => task-85619 Adding files when digital order is delivered 

Enhancements :
   => At shop level  pickup interval option given
   => Tracking order with Google Analytics ecommerce 
   => W3c validator.
   => Performance optimization
   => Upgrades in GEO location module to configure default location.  
   => Price surge based on special price. 
   => Admin Reports.
   => Map listing for products & shops 
   => Withdrawal Requests
   => Order Cancellation Requests 
   => Manage Alert text
   => Manage Product Reviews

Admin UI/UX Enhancements pages:
    => Login / Register, Forgot Password
    => My Profile/ Change Pasword
    => Product Catalog
        - Brands
        - Shops
        - Categories        

    => Requests
        - Brand request
        - Categories requests 
        - Seller approval requests
        - Threshold products
        - Rating types

    => Orders
        - Order Cancel Reasons
        - Order Return Reasons
        - Order Statuses

    => Users
        - Users
        - Rewards
        - Transactions
        - Deleted Users
        - Users addresses

    => Promotions
        - Special Price
        - Volume Discount
        - Related Products
        - Promotions
        - Rewards on purchase
        - manage weightages
        - Recommended tag products weightages

    => Blog
        - Blog Post Categories
        - Blog Posts
        - Blog Contributions
        - Blog Comments

    => Tax
        - Tax structure
        - Tax categories
        - Tax categories rule

    => CMS
        - Content Pages
        - Content Block
        - Faq's
        - Testimonials

    => Reports
        - Sales Report
        - Financial Report
        - Subscription Reports

    => Import/Export

    => Seo
        - Url Rewriting
        - Image attributes
        - Generate Sitemap
        - View Html
        - View Xml
        - Meta Tags Management

    => Settings

=========================TV-9.4.0.20211130======================
=> Product Catalog
    - Oprions

=> Requests    
    - Order return requests
    - Order cancellation requests
    - Withdrawal requests

=> Orders
    - Orders
    - Subscription Orders
    - Product Reviews

=> Users
    - Admin Users
    - GDPR requests

=> Promotions
    - Discount Coupons
    - Push notifications
    - Badges
    - Ribbons

=> CMS
    - Home page slidees
    - Banners
    - Navigations

=> Reports
   - Buyers report
   - Discount coupons

=> Shipping/Pickup
    - Shipping compnay users
    - Shipping packages
    - Shipping profiles
    - Pickup addresses
    - Shipped addresses

Bugs : 
    => 060304 - The homepage logo is not clearly visible.
    => 060346 - Admin UI: Nothing(hint text) is showing while hovering on the "Notification icon" on the top header section. 
	=> 060494 - Admin UI: Spacing issue between in the title of "Order status Name".
    => 060517 - Admin UI: Correct "order status type" is not showing while editing the order's status in case of subscription.
    => 060524 - Admin UI: "Subscription's status" moves to the "product's status listing" after inactivating the status by editing it.
    => 060615 - Admin UI: Price's search is not working and the shop's listing is also not showing under the sales reports section.
    => 060482 - Admin UI: Search icon is not showing while selecting the option from the "suggested text" on the whole system.
    => 060564 - Admin UI: States listing is not showing for the default selected country under the "Users Addresses.
    => 060570 - Admin UI: Spacing issue between "name" and "address" under the user's addresses.
    => 060572 - Admin UI: "Spacing" and "text size" issue for the Combined Tax option under the tax structure section.
    => 060531 - Admin UI: Nothing is showing while clicking on the User's name on the whole system.
    => 060513 - Admin UI: Order Status's sorting and re-arrange functionality is not working properly if trying to use it simultaneously.
    => 060776 - Recommended tag products section error is coming.
    => 060480 - Admin UI: Every-time page is refreshing while admin clicking(multiple times) on the "save" button while adding the new records.
    => 060771 - Admin UI: Inconsistency => In the table of the special price, seller info. is not showing according to the 'volume discount' section.
    => 060751 - Admin UI: Client-side validation is not showing while trying to enter the new password < 8 characters under the user's section.
    => 060753 - Admin UI: Validation message is missing while clicking on the 'Resend set password email' option under the user's section.
    => 060733 - Admin UI: Facing issue while adding the users at the admin's panel.
    => 060897 - Tax category rule addition giving issue.
    => 060600 - Admin UI: Suggestion to give information, on what basis the search functionality will work under the reports section.
    => 060619 - Admin UI: "No Record Found" is showing after clicking on the Clear button under the sales reports section.
    => 060682 - Admin UI: Heading name is not matched with the title and 1st letter of the heading is not capital under the Import/Export section.
    => 060732 - Admin UI: Search is not working properly under the permission sections of the admin's sub-users.

==================TV-9.4.0.20211215====================
    => Dashboard Stats
    => Product page
    => UAT Fixes

==================TV-9.4.0.20211223===================
    => Multilingual Sitemap
    => Add product screen
    => UAT Fixes
=============TV-9.4.0.20211228================
=> Product Catalog
    - Seller Inventory

=> Notification and Logs

=> Promotions   
    - Badges 
    - Robbons        

Bugs : 
    => 060664 - Admin UI: "Alpha-3 Code" column is not showing in the exported file under the countries section.
    => 061063 - Admin UI: 'Type' text is missing with the 'Select' under the "Image Attributes" section.
    => 061092 - Admin UI: "Clear" functionality is not working for the "Product details" listing under the 'Meta tags management' section.
    => 061058 - Admin UI: Getting an error while clicking on the 'edit' option under the Image attributes section.
    => 061133 - Error coming while editing blogs image attributes in image attributes section.
    => 061109 - Admin UI: "NEW" button design is not correct for the 'Advanced settings' under the "Meta Tag Management" section.
    => 061107 - Admin UI: "Clear" design is not correct under the "Meta Tag Management" section.
    => 061059 - Admin UI: 'Default' option is not selected after editing the records.
    => 061113 - Admin UI: Not able to delete the records from the "Advanced setting meta tags listing" under the Meta tags section.
    => 060672 - Admin UI: "Export Data Range" is not working according to 'By Id' and 'By Batches' while exporting the user's file.
    => 061106 - Admin UI: Admin navigates to the "English" page while clicking on the RESET button on the Arabic page under the "Meta Tag Management" section.
    => 061024 - Admin UI: 'Language data' is also updated while adding the 'General Data' and language data' title is also not the same under the Testimonial section.
    => 061101 - Admin UI: Search(Keyword and Dropdown) is not working properly under the "Meta tags Management" section.
    => 061018 - Admin UI: 'Language data' is also updated while updating the 'General Data' under the FAQ section.
    => 060822 - Admin UI: 'cpc' and 'ppc' is not capital under the promotion section.
    => 060825 - Admin UI: Getting multiple issues under the 'rewards on purchase' section.
    => 060830 - Admin UI: In the table, "N" is not capital for the serial number's abbreviation on the whole system.
    => 060833 - Admin UI: "recomended" spelling is not correct under the Manage weightages section.
    => 060861 - Admin UI: Watermark's text is not showing completely in the search fields under the "Blog Contributions" section.
    => 060873 - Admin UI: Different data is showing under the 'Language data' section while editing and adding the pages under the content pages section.
    => 060874 - Admin UI: Added data is not showing under the 'language data' section while editing the records under the content pages section.
    => 060885 - Admin UI: Getting multiple issues while editing the content blocks section.
    => 061020 - Admin UI: Admin is not able to 'copy' the text in the table if there is re-arrange functionality on the whole system
    => 061017 - Admin UI: Design is not aligned when the session is expired under the FAQ section
    => 061013 - Admin UI: Status is 'in-active' by default while adding the record on the whole system
    => 060886 - Admin UI: 'Background Image' title design is not matched with the other titles under the content blocks section
    => 060877 - Admin UI: Layout Instruction is not showing under the content pages section
    => 060876 - Admin UI: Session is expired message is not showing on some of the pages on the whole system
    => 060871 - Admin UI: Reset and Save buttons position is not aligned on the slide pages
    => 060750 - Admin UI: Double validations messages for the "confirm password" field is showing while changing the password under the admin user section
    => 060543 - Admin UI: In the pagination, the extreme right and left arrows icon is not showing on the whole system
    => 060536 - Admin UI: View comments moved in popup view from listing.
    => 060594 - Admin UI: Suggestion to show the "tax category" of the rules for the better understanding.
    => 060505 - Admin UI: Suggestion to give some indication to admin i.e. how "Order Status Color Class" will appear at the front-end
    => 061431 - Special Price and Volume discount listing design row issue while editing

=============TV-9.4.0.20210107================
    => 060478 - Admin UI: Suggestion to change the errors messages while trying to add the new record by using the same name on the whole system 
    => 061012 - Admin UI: "Row's Re-arrange" functionality is not working properly on the whole system
    => 060863 - Admin UI: Getting multiple issues under the side's menu section
    => 060835 - Admin UI: Inconsistency: Design is not the same for the edit fields in the table under the Manage weightages section
    => 060770 - Admin UI: Table's alignment is not correct under the special price section
    => 060538 - Admin UI: Validation's design is not consistent for the User's dropdown under the rewards section
    => 060587 - Admin UI: Suggestion removed the scroller if "no record found" in the list
    => 061099 - Admin UI: Breadcrumb is also gets blurred while selecting the options under the "Meta tags Management" section
    => 061441 - Admin UI: Search is not working while trying to search the record according to 'added by' under the Options' section.
    => 061445 - Admin UI: Admin is not able to add more than one option's value.
    => 061097 - Admin UI: Loading is not working properly while sorting the columns of the table under the "Meta tags Management" section
    => 060375 - Admin UI: Changes made to the requested brand media file by admin are not visible until the admin does not reload/refresh the page.
====================TV-9.4.0.20220112==============
    => 061594 - Admin UI: Search is not working according to "username and email address" under the Order Cancellation Requests section.
    => 061591 - Admin UI: Field's headings are missing under the 'advanced search' section under the "Withdrawal requests" section.
    => 061584 - Admin UI: Double options are selected while selecting the "cancellation requests" option in the side menu.
    => 061596 - Admin UI: All records are not showing on the table after updating the status of the withdrawal request.
    => 060758 - Admin UI: The whole table is not getting blurred while sorting the columns if the table contains more columns & the admin needs to scroll it horizontally
    => 060847 - Admin UI: Random behavior is showing while re-arranging the fields under the Blog post categories section
    => 060839 - Admin UI: Getting multiple issues under the "Blog Post Categories" section
    => 061660 - Admin UI: Titles, shop rating, and images are missing on the product reviews page
    => 061658 - Admin UI: "Invalid Request" error is showing while clicking on the "New" button on the product`s review page
    => 061657 - Admin UI: Search is not working properly on the "Product Reviews" page
    => 061650 - Admin UI: Admin is not able to update the "shipping" status of the orders and the updated status is also not showing on the order details page
    => 061639 - Admin UI: Comments are also showing on the wrong side on the order details page
    => 061638 - Admin UI: Admin is not able to update the payment more than one-time if payment is not complete under the order details page
    => 061587 - Admin UI: Multiple issues are faced under the "cancellation requests" option
    => 061583 - Admin UI: Clear functionality is not working properly under the "Order return requests" section
    => 061577 - Admin UI: Options text of the "Transfer refund" field is larger than the sub-titles and comments are also not showing on the orders details page
    => 061651 - Admin: 'Subscription period' and 'payment status' are not showing on the subscription order details page and the Seller's phone number is also missing

New Features :
 => Getting Started

Enhancement:
=> left Navigations
=> Quick Search
=> Updated System Labels    

====================TV-9.4.0.20220120==================
    => 061669 - Sr. No is not correct, default-sorting is not showing, and the search's watermark is also not showing completely on the Discount Coupons page.
    => 061665 - Admin UI: 'Search icon' is not showing in the search field and the 'search' watermark is also missing on the Abandoned cart page.
    => 061677 - Admin UI: Default-sorting is not showing in the table and the character limit is also missing for the Arabic's name while adding the badges.
    => 061857 - Admin UI: The 'wrong status' is showing for the inactive rating types while editing the same.
    
Known Issues and Problems :
    => 82248 : Renaming existing DPO Payment Gateway to Paygate as it belongs to South Africa linked with Dpo Group.
    => 93129 : In custom product request form view specification and EAN/UPC code will not come as old data is incorrect
Following is a list of known errors that don’t have a workaround. These issues will be fixed in the subsequent release. 
        => Change in minimum selling price when reconfigured by Admin
        => Safari and IE 11 do not support our CSS. More info can be found at https://developer.microsoft.com/en-us/microsoft-edge/platform/status/csslevel3attrfunction/
        => System does not support Zero decimal currency while checking out with stripe

Installation steps:
 	• Download the files and configured with your development/production environment.
 	• You can get all the files mentioned in .gitignore file from git-ignored-files directory.
 	• Renamed -.htaccess file to .htaccess from {document root} and {document root}/public directory
	• Upload Fatbit library and licence files under {document root}/library.
	• Define DB configuration under {document root}/public/settings.php
	• Update basic configuration as per your system requirements under {document root}/conf directory.

Notes:
    Procedures : 
        Execute "{siteurl}/admin/admin-users/create-procedures" is mandatory.
        
    Composer :

        => Composer should be installed on server to run the stripe connect module: composer.json on root of the project has details to download the required libraries in root's vendor folder.
        => Run command "composer update" at root of the project to update composer and fetch all dependennt libraries: 

    Configuration :
        => Please configure Ready For Pickup Order Statuses.

    Stripe Connect Installation :

        => Required to configure callback url as "{domain-name}/public/index.php?url=stripe-connect/callback" inside stripe's web master's account under https://dashboard.stripe.com/settings/applications under "Integration" -> "Redirects"
        =>  Setup webhook Stripe Connect  https://dashboard.stripe.com/test/webhooks . 
                i) Add Webhook url under "Endpoints receiving events from your account" 
                    1) "Webhook Detail" > Url as "{domain-name}/stripe-connect-pay/payment-status" bind events "payment_intent.payment_failed", "payment_intent.succeeded".
   
    Default Shipping profile setup:
       
       To Bind Products and Zones To Default Shipping Profile, Open <site-url>/admin/patch-update/update-shipping-profiles
       To Bind Zero Tax category as default if "Rest Of The World" country is not bind,Open <site-url>/admin/patch-update/update-tax-rules
       To Update state code which for only state which is present in old database state table, execute update_state_codes.sql  (Mostly done when upgrading form V9.2 to 9.3 )       

    Please replace tbl_countries, tbl_states from db_withdata.sql.

    Please hit <site-url>/admin/patch-update/update-category-relations to update all parent to child level relations in case of updating db.

    s3 bucket notes for bulk media:
        => Create a Lambda function.
        => Add trigers and upload zip file from  git-ignored-files/user-uploads/lib-files/fatbit-s3-zip-extractor.zip
        => Set permission and update Resource based on function created by you.
        {
            "Version": "2012-10-17",
            "Statement": [
                {
                    "Effect": "Allow",
                    "Action": "logs:CreateLogGroup",
                    "Resource": "arn:aws:logs:us-east-2:765751105868:*"
                },
                {
                    "Effect": "Allow",
                    "Action": [
                        "logs:CreateLogStream",
                        "logs:PutLogEvents"
                    ],
                    "Resource": "arn:aws:logs:*:*:*"
                },
                {
                    "Effect": "Allow",
                    "Action": [
                        "s3:PutObject",
                        "s3:GetObject",
                        "s3:DeleteObject"
                    ],
                    "Resource": [
                        "*"
                    ]
                }
            ]
        }

    2Checkout Payment Gateway:
        To Test Sandbox Payment Refer This: https://knowledgecenter.2checkout.com/Documentation/09Test_ordering_system/01Test_payment_methods


    ShipRocket : No sandbox environment available need to test live.