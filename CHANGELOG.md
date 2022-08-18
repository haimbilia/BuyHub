# Multivendor - Released Version : RV-9.3.1

> IOS/Android Buyer APP version : 2.0.1
> System API version : 2.3
    
## New Feature :

    - #82892 Easypost Shipping API Integration.
    - Shopify sync module for SV seller.
    - #85399 QNB payment gateway.
    - #80928 Mollie payment gateway.
    - MSG-1390138 : Payfast payment gateway.
    - #85369 : Aramex Shipping API.
    - #72808 : EasyEcom Marketplace Channel API.
    - #86472 : YoCo Payment gateway.
    - #88040 : ShipRocket Shipping API Integration.
    - #88449 : ShipEngine Shipping API Integration.
    - Admin shipped products listing page.
    - task-84719 Preview module for digital files.
    - task-85619 Adding files when digital order is delivered.
    - #88083 : System Log Listing Page.
    
## Enhancements :

    - At shop level  pickup interval option given.
    - Tracking order with Google Analytics ecommerce.
    - W3c validator.
    - Performance optimization.
    - Upgrades in GEO location module to configure default location.
    - Price surge based on special price.
    - Admin Reports.
    - Map listing for products & shops.
    - Withdrawal Requests.
    - Order Cancellation Requests.
    - Manage Alert text.
    - Manage Product Reviews.
    - Multilingual Sitemap and canonical url update.
    - Add product screen.

## Updates/Fixes : 

    - #052459 - Repeat Fetched Rates from EasyPost API Plugin
    - #052463 - Setup shipping of other product not working with EasyPost
    - #053622 - Load all font family variants
    - #053451 - missing country code plugin with phone number field
    - #053462 - Instagram login not working after configuration, gives error
    - #053757 - when order status is changed then sms are not triggering to buyer for the same
    - #053451 - missing country code plugin with phone number field
    - #053462 - Instagram login not working after configuration, gives error
    - #053757 - when order status is changed then sms are not triggering to buyer for the same
    - #053612 - when tax is collected by admin and commission incl tax then invoice is having some issues
    - #053908 - when admin creates category collection (category layout 1) more than once with same category then in second collection> products are not populating
    - #054447 - when product having multiple options then on detail page> options are not listing properly
    - #054613 - Error display on invoice pdf page
    - #054742 - wrong message is populating on button on tooltip
    - #054591 - Getting delivery field in tax invoice on pickup order
    - #054711 - when multiple products are linked with same shipping profile then pagination count is not proper
    - #052651 - on using comma as currency separator it's not impacting in text areas 
    - #052654 - Admin can create seller/buyer/advertiser/affiliate account from back-end - Not working
    - #052664 - admin> users> asterisk marked field shouldn't be mandatory for admin 
    - #053779 - seller> reports> currency symbol is missing in tax and shipping column
    - #053782 - admin> reports> sales reports> on accessing reports for particular date> there needs to be filter to search on basis of invoice or order by time (latest on top and vice versa)
    - #053816 - admin> reports> buyers report>sorting is not working
    - #053823 - seller reports> total order count is listing of child orders while on seller end it's counting parent order.
    - #053833 - currency symbol changed to euro (€) is not populating on exporting reports
    - #053501 - seller> unable to define slots for pickup- getting error 
    - #053763 - admin> users> add button> icon is not there
    - #053749 - in reports> PRODUCT > on entering character value in from price filed> errors are listing there
    - #053753 - Shop >> filters >> conditions are not getting displayed under conditions filter
    - #053861 - In Side bar only number of items displayed.
    - #053822 - seller reports> balance is not populating
    - #053883 - pickup slots are not getting listed on front end while placing order on selection of address
    - #053882 - getting error on product detail page under recommended products
    - #053817 - on registration screen> logo is not displaying
    - #053832 - rating star color is different in admin and front end
    - #053932 - while placing order> when no coupon or discount is there then getting entry on name of saving
    - #053954 - Not storing Product unit price so in report data not coming
    - #053985 - Stripe connect unable to debit site commission
    - #053850 - admin> advertiser report> data is not populating.
    - #053849 - admin> advertiser report> keyword search needs to be there in filter
    - #053751 - after applying filters and exporting file in reports> all data is exporting instead of filtered data
    - #053935 - when buyer purchases multiple qty (incl. tax) then on seller end in transactions it's listing $1000.02 and under reports it's listing $1000 and on buyer end it's listing $0.01 as rounding off amount
    - #053948 - getting invalid slot when buyer changes date for pickup (admin's place)
    - #053855 - admin> reports> top products> filter> search by keyword is missing 
    - #054351 - when seller B purchases subscription then in Subscription Seller Report> subscription name for seller A changes similar to seller B
    - #054278 - if for any digital item there is no preview available then preview tab shouldn't be displayed
    - #054144 - Set Default Location not populating on front end after set by admin
    - #054071 - Product Download Attachments At Inventory Level for catalog is missing in import/export
    - #054441 - admin> shipping> Shipped Products By Admin> pagination is not working on facebox.
    - #054526 - when seller purchases subscription then on order success screen> neither adjusted amount is listing (if there), nor the original amount of package
    - #054441 - admin> shipping> Shipped Products By Admin> pagination is not working on facebox
    - #054499 - reviews added with category are not listing in admin    
    - #054527 - Blog >> some error is there
    - #054599 - when order is on pickup and status is changed to ready for pickup it gets stuck and on refreshing the page> getting error on screen
    - #054447 - when product having multiple options then on detail page> options are not listing properly
    - #054529 - On FAQ >> if any letter is in caps then it is not highlighting on search
    - #054545 - when subscription is downgraded and after adjustment amount becomes 0 then on applying coupon it's getting the total in negative
    - #054597 - generate label is coming on seller end on pickup order 
    - #054611 - while adding hipping profile> on deselection of region/country> linked states and countries are listing as selected
    - #054612 - login with otp is working with default otp 0000
    - #054616 - after submitting review> getting error on review page- front end
    - #054717 - on recently view product error coming on product detail page
    - #054731 - when review is placed with media then there is no need to add show more on 6th image
    - #054761 - despite having sku non mandatory it's not adding inventory from seller end
    - #054814 - admin> catalog> rating type> search is not working
    - #054813 - admin> catalog> rating types> rating types sr. no are not listing properly on changing page
    - #055069 - on product detail page undefined index: theprice notice coming
    - #055077 - when cookies policy are turned off from admin then recently viewed items are not listing on detail page of product
    - #055104 - seller dashboard> data migration tab is not highlighting on accessing
    - #055093 - while changing seller approval request if admin declines request without message then on front end it's listing heading- reason for cancellation which is blank
    - #055092 - when cookies are not allowed from admin still then user have option for the same in account
    - #055090 - when truncate request is raised by user then in admin> it's listing- view purpose which is not there on user end
    - #055597 - before checkout> there is no halt on last step- it's redirecting automatically to payment gateway
    - #054137 - Issue in product refund stats
    - #054183 - on admin order cancellation page roundoff error coming
    - #054242 - paystack gateway not supporting ZAR currency        
    - #054201	while adding catalog for digital item> only option to add attachment at inventory level is either Yes or No
    - #054208 - while uploading files> it's taking too much time to save data and meanwhile loader disappears- seems like process has been aborted
    - #054204	while adding catalog> when add attachment is set to No then > download tab is listing for that inventory setup too
    - #054206	there needs to be some message on inventory level when attachments are not allowed to add at inventory
    - #054212	while adding inventory> when we add link and url is long then UI is not proper
    - #055154	digital items> files linked with specific language are listing all on front end in preview
    - #055135	when digital catalog is added by admin and files are attached by admin and then seller should be allowed to see the name of file only not download
    - #055155	when admin adds catalog with digital links then on seller end links (preview and main) both are listing

```sh
TV-9.3.1.20210703
```

    - #055215 - when only language is enabled in system then in header> language drop down is coming with single value

```sh
TV-9.3.1.20210705
```

    - #055632 - on accessing digital preview file from front end getting error
    - #055631 - when pickup order is canceled by seller then listing delivery charges field on screen

```sh
TV-9.3.1.20210708
``` 

    - #055604 - zip file needs to be exported on click of download button on buyer end containing (files and link) just like Tribe
    - #055720 - admin> promotions> ribbon> bind conditions> list having select option which is of no use and on selecting, nothing appears on top for operations
    - #055721 - admin> promotions> ribbon> bind conditions> filters> fields are not aligned properly
    - #055689 - while returning if there is no file attached still then listing download button on return order detail page on buyer end
    - #055715 - when single badge is linked with item then it's listing multiple times on product detail and shop
    - #055026 - corresponding to review> images added are not listing on front end
    - #055800 - when seller accesses order detail page then getting fatal
    - #055748 - when badge/ribbon is turned off from admin still then its listing on seller dashboard but not listing on front end 
    - #055746 - favorite option is missing on product detail page on buyer end
    - #055801 - admin can create multiple badges for a seller
    - #055802 - badges created by seller are getting edited by admin and allowing him to add other seller items to that
    - #055813 - Notice: Undefined variable: Shop/view.
    - #055810 - on viewing wish list from buyer> getting error
    - #055809 - when admin clicks on complete button for gdpr request then getting error
    - #055808 - when user requests for the data then in popup> email is not there in field
    - #055807 - ribbon linked by seller1 are getting edited by admin and allowing him to add other seller2 items to that
    - #055816 - remove phone number suggestion with fields throughout system
    - #055824 - seller> manage ribbons> link type is coming with n/a while values are there on editing the same
    - #055826 - when subscription is purchased through stripe connect then in admin> order detail page> payment mode is not listing
    - #055833 - admin> requests> badge request filters> buttons are not proper
    - #055832 - when admin creates badges (automatically) for completed orders then it's not listing on product detail page
    - #055840 - Google Shopping Feed Enhancement Changes
    - #055850 - Warning : Creating default object from empty value

```sh
TV-9.3.2.20210716
```

    - #055874 - getting invalid request on linking rating type with new category
    - #056100 - Notice: Undefined index: op_special_price
    - #056031 - on order when tax is bifurcated in 3 types then on invoice listing 2 only
    - #056021 - when multiple items are ordered together then on packing slip> getting wrong data listed
    - #056034 - when order is canceled still then seller having option to generate shipping label for the same
    - #056029 - when ship by admin only is enabled then on seller end> shipping plugins are listing
    - #056166 - Warning: strtolower() expects parameter 1 to be string, array given in /library/core/FatUtility.class.php on line 0
    - #056027 - getting crash on approving return request when tax is incl price and and avalara is enabled
    - #056025 - when taxjar is enabled then on cart page> getting error
    - #056030 - when tax is enabled (avalara) then on bifurcation tax value is not listing properly
    - #056134 - getting error on marking order as completed from admin when tax is alavara and order cancellation request is declined
    - #055906 - Seller >> tax category >> tax rates >> "0.00" gets displayed along with actual percentage of tax .
    - #056199 - Paypal Payout Not Working : Client Auth Failed
    - #056197 - on adding item to wishlist getting 404
    - #056195 - admin> promotions> coupon> link> product and brand both tabs are highlighting 
    - #056194 - seller> wallet> withdrawal through paypal payout> getting 404

```sh
TV-9.3.2.20210720
```

    - #056192 - Showing fatal error while opening settings of split payment method.
    - #056225 - The settings are not getting saved for the related product settings under Admin dashboard
    - #056228 - Undefined Variable rating types
    - #056229 - Notice: Undefined index: oua_phone_dcode
    - #055714 - seller> promotions> manage badges> when there is no data then message is not aligned

```sh   
TV-9.3.2.20210723
```

    - #056222 - buyer/seller dashboard> logo is redirecting to dashboard instead of home page
    - #056147 - buyer> orders> feedback form> rating stars are not populating

```sh  
TV-9.3.2.20210726
```
    - #056373 - if admin shipping is enabled then even seller is credited with shipping amount
    - #056221 - seller> inventory> badges and ribbon collectively not working in filter

```sh
TV-9.3.2.20210728
```

    - #056264 - Shop details >> If "use manual shipping rates" checkbox is not checked then "postal code" should be mandatory
    - #056246 - Catalog -> Shipping options
    - #056265 - Admin >> General settings >> local > postal code and address should be mandatory as it requires when we use shipping API
    - #056337 - getting notices on checkout screen when multiple items are there in cart
    - #056340 - label generation option is coming on order when order is marked as completed
    - #056344 - on moving item to wish list from cart getting 404 
    - #056509 - Unable to change phone number if SMS plugin on
    - #056427 - after registration through phone number and configuring details post login page is flooded with errors
    - #056414 - Admin >> users >> for sub sellers >> edit >> bank account and address tabs are getting displayed only when we click on "cookies " tab
    - #056413 - Checkout (pickup ) >> when we select slot then "undefined " gets displayed on selected time and date
    - #056412 - Checkout (pickup ) >> when we select slot then popup should get closed.
    - #056410 - admin >> notifications for shop report > when we click on report notification then admin gets redirect to report reasons instead of report listing
    - #056508 - on order cancellation requests error coming at admin side
    - #056406 - admin> seller orders> ship by seller/admin needs to be there in listing and in filters too

```sh 
TV-9.3.2.20210730
```

    - #056367 - once order is generated with aftership then link is not getting generated on seller/buyer end
    - #056366 - once after ship is enabled then on accessing email for the same is flooded with errors
    - #056362 - seller order is not accessible when only tracking api is enabled and order is marked s shipped
    - #056349 - admin> during login> getting message overlapped
    - #056555 - Unable to view products when seller has pending subscription
    - #056568 - on admin seller product left navigation wrong seller order count
    - #056585 - on manage collections Banner layout1 and layout2 has wrong image of layout
    - #056600 - Wallet recharge wrong URL
    - #056314 - on removing item from wishlist getting 404
    - #056263 - Cart >> For save for later >> "move to wishlist " tool tip is there instead of " save for later".
    - #056243 - seller> payout report> filters> buttons are not aligned with fields
    - #056398 - when tax is zero then on generating slip getting wrong tax amount listed
    - #056236 - Affiliate / advertiser >> some warnings are there. 
    - #056237 - if any user is logged in then 404 page is getting opened if we click on "become a seller " , " Advertise with us" or " register as affiliate" link in footer.
    - #056239 - seller> buy together> on clicking existing items getting error
    - #056241 - seller> sales reports> back button is not working
    - #056293 - Shipping profile is not getting created from admin end 

```sh 
TV-9.3.2.20210805
```

    - #056898 - Seller/Buyer is not able to click on the "Accept Cookies" button
    - #056944 - on saving seller catalog specification at admin end error coming
    - #056959 - on updating seller order getting error at admin end 
    - #056954 - Seller: Country code is not showing while adding the Contact Number in the Seller Approval form
    - #056948 - Web Buyer: Getting a "404 error" while clicking on the "Open a Store" button on the front end
    - #057017 - importing seller products in german getting error invalid csv column
    - #057089 - Admin: Suggestion to override the images while uploading multiple images because we are showing only one image for the Brands at the buyers end
    - #057115 - Seller and Admin: "+" button is not showing while adding the pickup address' for "All days" Time Slots
    - #057163 - while adding the option in catalog getting struck in ajax loop

```sh 
TV-9.3.2.20210810
```

    - #057137 - Getting error while stripe connect transfer seller part
    - #057130 - Admin, Seller, and Buyer: Suggestion to give an "option" to Redirect to the Order details page on the Cancelled and Returned requests list
    - #057117 - Seller and Admin: Shipping packages' details are not showing on the Order details page with the Product
    - #057145 - Seller: Suggestion to dont allow the seller to add a Special Price greater than the Current Price
    - #057160 - Uncaught TypeError: Cannot set property scrollTop of undefined
    - #057112 - Seller: JSON error is receiving while adding the inventory for the Admin's products
    - #057113 - on submitting product review getting error 
    - #057109 - Buyer: Records are created in the "Reward Points" section with 0 value while placing an order
    - #057115 - Seller and Admin: "+" button is not showing while adding the pickup address' for "All days"
    - #057144 - Admin: "Complete" option is showing in the "User Gdpr Requests" section when the seller "Request to Remove My Data"
    - #057171 - Buyer: Suggestion to show the "Order ID" with cancelled order under the "My Credit" section
    - #057177 - Buyer: Suggestion to show the "Return Order Age" in the Order details page at the buyers end
    - #057166 - Buyer: "Share and Earn" functionality is not working properly
    - #057221 - Seller: "Categories and Tax Categories" listing is not showing when sellers click on these fields but, for brand listing is showing
    - #057217 - Seller and Buyer: Suggestion to show the "Cancel Order" button instead of the "Cross" icon in the order details
    - #057212 - The "same status" of order is updating when Seller clicks on the "Save Changes" button multiple times
    - #057238 - Buyer: Order ID is not showing with the "Earned Reward Points On Purchase" under the reward points section
    - #057227 - Admin and Seller: Suggestion to give some indication regarding the "Product Warranty" field is in Days or Months or Year while adding the product
    - #057044 - Seller: UI design is not correct while uploading the Banner and Logo for the Shop

```sh 
TV-9.3.2.20210813
```

    - #060304 - The homepage logo is not clearly visible.
    - #060346 - Admin UI: Nothing(hint text) is showing while hovering on the "Notification icon" on the top header section. 
    - #060494 - Admin UI: Spacing issue between in the title of "Order status Name".
    - #060517 - Admin UI: Correct "order status type" is not showing while editing the order's status in case of subscription.
    - #060524 - Admin UI: "Subscription's status" moves to the "product's status listing" after inactivating the status by editing it.
    - #060615 - Admin UI: Price's search is not working and the shop's listing is also not showing under the sales reports section.
    - #060482 - Admin UI: Search icon is not showing while selecting the option from the "suggested text" on the whole system.
    - #060564 - Admin UI: States listing is not showing for the default selected country under the "Users Addresses.
    - #060570 - Admin UI: Spacing issue between "name" and "address" under the user's addresses.
    - #060572 - Admin UI: "Spacing" and "text size" issue for the Combined Tax option under the tax structure section.
    - #060531 - Admin UI: Nothing is showing while clicking on the User's name on the whole system.
    - #060513 - Admin UI: Order Status's sorting and re-arrange functionality is not working properly if trying to use it simultaneously.
    - #060776 - Recommended tag products section error is coming.
    - #060480 - Admin UI: Every-time page is refreshing while admin clicking(multiple times) on the "save" button while adding the new records.
    - #060771 - Admin UI: Inconsistency - #In the table of the special price, seller info. is not showing according to the 'volume discount' section.
    - #060751 - Admin UI: Client-side validation is not showing while trying to enter the new password < 8 characters under the user's section.
    - #060753 - Admin UI: Validation message is missing while clicking on the 'Resend set password email' option under the user's section.
    - #060733 - Admin UI: Facing issue while adding the users at the admin's panel.
    - #060897 - Tax category rule addition giving issue.
    - #060600 - Admin UI: Suggestion to give information, on what basis the search functionality will work under the reports section.
    - #060619 - Admin UI: "No Record Found" is showing after clicking on the Clear button under the sales reports section.
    - #060682 - Admin UI: Heading name is not matched with the title and 1st letter of the heading is not capital under the Import/Export section.
    - #060732 - Admin UI: Search is not working properly under the permission sections of the admin's sub-users.
    - #057270 - Seller: Badges requests list is not showing if the first request is for Badges
    - #057264 - Admin: "Link to" field is not working while clicking on it and UI is also not correct on the "Badges request" section
    - #057261 - Admin: "Invalid Request" error is showing while clicking on the "Link" field after selecting "link type" in the Ribbons
    - #057258 - Admin: Back button linking is not correct for the Ribbons functionality
    - #057257 - Seller: Blank Confirmation message is showing while deleting the Product from the ribbon
    - #057304 - Admin: An error message is not correct while adding the same Badges name
    - #057281 - Seller: There is no option to delete the ribbons and badges listing
    - #057287 - Seller: There is no information regarding the seller satisfy the "Automatic badges" conditions
    - #057228 - Admin and Seller: Suggestion to give some indication regarding the "Display Time Slots After Order [Hours]", where it will be used? 
    - #057256 - on promotion add page time picker not coming
    - #057269 - Seller: Text is not correct on the "Requests" section
    - #057262 - Seller: More than two ribbons are showing for the products inventory
    - #057372 - Getting error while sending email from Users tab
    - #057408 - Buyer: "Undefined variable" error is showing while clicking on the Seller's collection
    - #057405 - Buyer: "Fatal error" is showing while clicking on the newly added Slides promotions
    - #057403 - Seller: Suggestion to don't show the selected products in the drop-down while adding the collections
    - #057396 - Advertiser: "404 error" is showing while clicking on the "Email Verification" link
    - #057391 - Buyer: A warning message is showing while clicking on the "Affiliate" option
    - #057384 - Admin: Information is missing regarding "Content Blocks
    - #057444 - If brand is mandatory then while importing getting error
    - #057684 - in apple app mp4 tried to run instead of download
    - #057715 - Badge condition listing for automatic case.
    - #057716 - Notice: Undefined variable: siteLangId in application/views/_partial/picture-tag.php
    - #057725 - Multiple first time purchase discount coupons are getting created by the system for one user
    - #057749 - Category with no product is also listing on view all category
    - #057717 - Admin: "Undefined variable" error is showing while searching on the "Catalog Report" section
    - #057775 - Fatal error: Uncaught TypeError: Argument (Checkout listing)
    - #057381 - Admin: Noting is showing under the "Banner Layouts" listing
    - #057778 - Product Detail and Shop View Page Copy link not working and invalid URL to copy
    - #057781 - Display processing if call ajax from fcom ajax
    - #057783 - while exporting file in russin language file name coming with unwanted string
    - #057535 - Advertiser: Remove the "My Message" icon for the Advertiser
    - #057884 - On page pages generic location label used
    - #057956 - importing category enable/disable issue
    - #057971 - Review/Feedback image is not visible when we click on any image on frontend
    - #057972 - Aftership tracking service can be enabled even when no shipping service is enabled
    - #057973 - While adding badge or ribbon name RTL mode chracters are displayed in LTR Mode
    - #057956 - importing category enable/disable issue 
    - #058034 - in blank db dummy data exist
    - #058112 - Stripe connect registration tab content not loading
    - #058142 - we should have zone export/import
    - #058197 - on email header logo static link is there
    - #058449 - import Product seo data not working 
    - #058462 - on product detail page specification not coming with group 
    - #058450 - product stock availability issue
    - #058557 - pagination issue in admin seller product pages
    - #058768 - if category identifier contain apostrophe then filter not coming on category page
    - #058807 - Unable to change the URL for a sellers collection    
    - #059263 - On order product search with lang there is query issue 
    - #059798 - invalid mime type error coming while uploading doc file in blog contribution
    - #059422 - Seller: Admin disable the "Allow Sellers To Add Products" option and then, "Add Seller's Shipping profile" option is not showing to add the shipping for the marketplace product
    - #059821 - new tag unable to add in catalog
    - #059913 - on home page favorite icon not updating

```sh 
TV-9.4.0.20211215
```

    - #060664 - Admin UI: "Alpha-3 Code" column is not showing in the exported file under the countries section.
    - #061063 - Admin UI: 'Type' text is missing with the 'Select' under the "Image Attributes" section.
    - #061092 - Admin UI: "Clear" functionality is not working for the "Product details" listing under the 'Meta tags management' section.
    - #061058 - Admin UI: Getting an error while clicking on the 'edit' option under the Image attributes section.
    - #061133 - Error coming while editing blogs image attributes in image attributes section.
    - #061109 - Admin UI: "NEW" button design is not correct for the 'Advanced settings' under the "Meta Tag Management" section.
    - #061107 - Admin UI: "Clear" design is not correct under the "Meta Tag Management" section.
    - #061059 - Admin UI: 'Default' option is not selected after editing the records.
    - #061113 - Admin UI: Not able to delete the records from the "Advanced setting meta tags listing" under the Meta tags section.
    - #060672 - Admin UI: "Export Data Range" is not working according to 'By Id' and 'By Batches' while exporting the user's file.
    - #061106 - Admin UI: Admin navigates to the "English" page while clicking on the RESET button on the Arabic page under the "Meta Tag Management" section.
    - #061024 - Admin UI: 'Language data' is also updated while adding the 'General Data' and language data' title is also not the same under the Testimonial section.
    - #061101 - Admin UI: Search(Keyword and Dropdown) is not working properly under the "Meta tags Management" section.
    - #061018 - Admin UI: 'Language data' is also updated while updating the 'General Data' under the FAQ section.
    - #060822 - Admin UI: 'cpc' and 'ppc' is not capital under the promotion section.
    - #060825 - Admin UI: Getting multiple issues under the 'rewards on purchase' section.
    - #060830 - Admin UI: In the table, "N" is not capital for the serial number's abbreviation on the whole system.
    - #060833 - Admin UI: "recomended" spelling is not correct under the Manage weightages section.
    - #060861 - Admin UI: Watermark's text is not showing completely in the search fields under the "Blog Contributions" section.
    - #060873 - Admin UI: Different data is showing under the 'Language data' section while editing and adding the pages under the content pages section.
    - #060874 - Admin UI: Added data is not showing under the 'language data' section while editing the records under the content pages section.
    - #060885 - Admin UI: Getting multiple issues while editing the content blocks section.
    - #061020 - Admin UI: Admin is not able to 'copy' the text in the table if there is re-arrange functionality on the whole system
    - #061017 - Admin UI: Design is not aligned when the session is expired under the FAQ section
    - #061013 - Admin UI: Status is 'in-active' by default while adding the record on the whole system
    - #060886 - Admin UI: 'Background Image' title design is not matched with the other titles under the content blocks section
    - #060877 - Admin UI: Layout Instruction is not showing under the content pages section
    - #060876 - Admin UI: Session is expired message is not showing on some of the pages on the whole system
    - #060871 - Admin UI: Reset and Save buttons position is not aligned on the slide pages
    - #060750 - Admin UI: Double validations messages for the "confirm password" field is showing while changing the password under the admin user section
    - #060543 - Admin UI: In the pagination, the extreme right and left arrows icon is not showing on the whole system
    - #060536 - Admin UI: View comments moved in popup view from listing.
    - #060594 - Admin UI: Suggestion to show the "tax category" of the rules for the better understanding.
    - #060505 - Admin UI: Suggestion to give some indication to admin i.e. how "Order Status Color Class" will appear at the front-end
    - #061431 - Special Price and Volume discount listing design row issue while editing    
    - #060820 - On order subscription getting error
    - #060772 - Admin UI: Admin is not able to edit the 'Minimum Purchase Quantity' and 'Discount (%)' fields under the Volume Discount section
    - #060775 - Admin UI: Product's listing is not showing while adding the 'related products and facing some UI issue under the "Related Products" section
    - #061094 - Admin UI: Titles are not showing in the table and it is a mandatory field
    - #061073 - Admin UI: Heading is missing for the search's dropdown under the "meta tags management" section 
    - #061115 - commission going negative when refund the product [RV-9.3.1]

```sh 
TV-9.4.0.20210107
```

    - #060478 - Admin UI: Suggestion to change the errors messages while trying to add the new record by using the same name on the whole system 
    - #061012 - Admin UI: "Row's Re-arrange" functionality is not working properly on the whole system
    - #060863 - Admin UI: Getting multiple issues under the side's menu section
    - #060835 - Admin UI: Inconsistency: Design is not the same for the edit fields in the table under the Manage weightages section
    - #060770 - Admin UI: Table's alignment is not correct under the special price section
    - #060538 - Admin UI: Validation's design is not consistent for the User's dropdown under the rewards section
    - #060587 - Admin UI: Suggestion removed the scroller if "no record found" in the list
    - #061099 - Admin UI: Breadcrumb is also gets blurred while selecting the options under the "Meta tags Management" section
    - #061441 - Admin UI: Search is not working while trying to search the record according to 'added by' under the Options' section.
    - #061445 - Admin UI: Admin is not able to add more than one option's value.
    - #061097 - Admin UI: Loading is not working properly while sorting the columns of the table under the "Meta tags Management" section
    - #060375 - Admin UI: Changes made to the requested brand media file by admin are not visible until the admin does not reload/refresh the page.    
    - #061057 - Admin UI: 'URL Rewriting' is not working for the SEARCH
    - #061025 - Admin UI: Loader is not showing while uploading the media on the whole system

```sh 
TV-9.4.0.20220112
```

    - #061594 - Admin UI: Search is not working according to "username and email address" under the Order Cancellation Requests section.
    - #061591 - Admin UI: Field's headings are missing under the 'advanced search' section under the "Withdrawal requests" section.
    - #061584 - Admin UI: Double options are selected while selecting the "cancellation requests" option in the side menu.
    - #061596 - Admin UI: All records are not showing on the table after updating the status of the withdrawal request.
    - #060758 - Admin UI: The whole table is not getting blurred while sorting the columns if the table contains more columns & the admin needs to scroll it horizontally
    - #060847 - Admin UI: Random behavior is showing while re-arranging the fields under the Blog post categories section
    - #060839 - Admin UI: Getting multiple issues under the "Blog Post Categories" section
    - #061660 - Admin UI: Titles, shop rating, and images are missing on the product reviews page
    - #061658 - Admin UI: "Invalid Request" error is showing while clicking on the "New" button on the product`s review page
    - #061657 - Admin UI: Search is not working properly on the "Product Reviews" page
    - #061650 - Admin UI: Admin is not able to update the "shipping" status of the orders and the updated status is also not showing on the order details page
    - #061639 - Admin UI: Comments are also showing on the wrong side on the order details page
    - #061638 - Admin UI: Admin is not able to update the payment more than one-time if payment is not complete under the order details page
    - #061587 - Admin UI: Multiple issues are faced under the "cancellation requests" option
    - #061583 - Admin UI: Clear functionality is not working properly under the "Order return requests" section
    - #061577 - Admin UI: Options text of the "Transfer refund" field is larger than the sub-titles and comments are also not showing on the orders details page
    - #061651 - Admin: 'Subscription period' and 'payment status' are not showing on the subscription order details page and the Seller's phone number is also missing

```sh 
TV-9.4.0.20220120
```

    - #061669 - Sr. No is not correct, default-sorting is not showing, and the search's watermark is also not showing completely on the Discount Coupons page.
    - #061665 - Admin UI: 'Search icon' is not showing in the search field and the 'search' watermark is also missing on the Abandoned cart page.
    - #061677 - Admin UI: Default-sorting is not showing in the table and the character limit is also missing for the Arabic's name while adding the badges.
    - #061857 - Admin UI: The 'wrong status' is showing for the inactive rating types while editing the same.
    - #061870 - Admin UI: Search is not working under the setting section at the admin's end
    - #061855 - Admin UI: Admin is not able to add the new rating types and able to active/inactive the by-default Rating types.
    - #061848 - Admin UI: Getting multiple UI issues on the 'Custom products' page.
    - #061837 - Admin UI: Watermark is missing for the advanced search fields and cross icon is also missing for the search field.
    - #061828 - Admin UI: Text cursor is not showing while searching the record from the drop-down on the whole system.
    - #061858 - Processing and confirmation message is not showing while changing the status of the Maintenance Mode under the setting section.
    - #061812 - Admin UI: "No Record found" message is not showing while trying to search the un-exist records on the Product listing page
    - #061770 - Admin UI: Pagination is not working properly while trying to see the records more than the actual records on the whole system
    - #061767 - Admin UI: The wrong options are showing in the "Shipping profile" dropdown under the advanced-search section on the Shipped Products page
    - #061761 - Admin UI: Unit is not showing with the Dimensions on the table under the Shipping package section
    - #061756 - Admin UI: Validation is missing for the 'State' field while adding and editing the pickup address
    - #061754 - Admin UI: The drawer design is not consistent while adding, editing, and resting the pickup addresses
    - #061748 - Admin UI: Rate name is not showing while editing the default rate under the shipping profile section.
    - #061968 - Fatal error: Uncaught TypeError: Argument 1 passed is invalid, expected string
    - #061742 - Admin UI: 'Reset' and 'Search' functionality is not working while adding & editing the new zones under the shipping profile section
    - #061741 - Admin UI: The 'Edit' and 'Add' actions are not working properly for the zones and their rules under the shipping profile section
    - #061738 - Admin UI: Product's listing is showing while binding the product with the shipping profile
    - #061736 - Admin UI: Facing multiple UI issues while adding the shipping profile
    - #061735 - Admin UI: Information is missing for the search i.e. according to what criteria admin can search the record on the shipping profile page
    - #061733 - Admin UI: 'No Record Found' design is not correct on the shipping company and shipping profile page
    - #061732 - Admin UI: The 'whole word' is not showing on the transaction history's drawer on the Shipping Company users' page
    - #061729 - Admin UI: Sorting is not working and the Drawer design is also not consistent on the Shipping Company Users page
    - #061726 - Admin UI: Getting multiple UI issues while adding the shipping companies name
    - #061670 - Admin UI: Expired status is not showing for the expired discount coupons
    - #061671 - Admin UI: Upload image option is not showing in discount coupon form
    - #061673 - Admin UI: Checkbox is not selected on the table after editing the record on the whole system
    - #061680 - Admin UI: Time selection functionality should be there while adding badge link condition.
    - #061687 - Admin UI: Design is not consistent while adding and editing the ribbons
    - #061717 - Admin UI: Previous added links are not showing while adding the new links under the navigation section
    - #061711 - Admin UI: Images are not aligned in the table of the banners    
    - #061710 - Admin UI: Search is not working according to 'type', disabled status is also changing and the whole page is loading while changing the media on the Banners page

```sh 
TV-9.4.0.20220201
```

    - #061691 - Admin UI: Multiple-delete functionality is not working for the links of the badges and ribbons
    - #061690 - Admin UI: Added details are still showing after adding the links of the badges and ribbons
    - #061700 - Admin UI: The 'cross' and ' drop-down' icons is not aligned under the advanced search section on the whole system.
    - #061776 - Admin UI: Side men's icons, languages drop-down, and select default product variant options are missing while adding the product
    - #061780 - Admin UI: Tag section is not working properly and the "Approved Status & Languages drop-down" is not showing while adding the product in the English language
    - #061798 - Admin UI: UI design is not correct for uploaded images under the 'advanced media' section and for the country's dropdown under the tax/shipping section while adding the product
    - #061695 - Admin UI: Spacing issue between the 'checkbox' and 'drag-drop icon' on the Home slides Management page
    - #061632 - Admin UI: There are multiple UI issues on the order details page
    - #060572 - Admin UI: "Spacing" and "text size" issue for the Combined Tax option under the tax structure section
    - #061810 - Admin UI: Search icon is missing in the search field, Images are not clickable on the table, and initially Save button is disabled while adding the product 
    - #061818 - Admin UI: Category's media is not clickable, brands' uploaded media is not showing and getting an 'invalid request' error while removing the rating types while adding the category & brands on the product's page
    - #062159 - Undefined index: order_id in case of Wallet pay from mobile
    - #061649 - Admin UI: Validation is showing for the 'Self shipping' fields while updating the order's status on the order's details page
    - #061801 - Coupen not displaying to other user once put on pending order by other user
    - #062174 - Undefined index tag identifier { aslo need to add languae dropdown to show as per language}
    - #062174 - Product tags page, binding tag issue
    - #062213 - View order from application order total amount is wrong on change currency (9.3.1)
    - #062225 - on seller product form copy function only working on first feild(9.3.1)
    - #062183 - Admin UI: Getting multiple issues on the "Payment Methods" table while accessing the 'Getting Started' section
    - #062171 - Admin UI: Getting multiple UI issues on the "Email Configuration" page while accessing the 'Getting Started' section 
    - #062114 - Admin UI: "Delete multiple records" functionality is not working on the Seller's Inventory page at the admin's end.
    - #062146 - Admin UI: The guest user's name is not showing in the table and search is also not working for some users.
    - #062142 - Admin UI: Username's search is not working properly on the notification's page at the admin's end.
    - #062259 - Admin UI: "View Details" icon is not correct on the "Withdrawal Requests" page.
    - #062140 - Admin UI: "No Record Found" design is not correct and the loader is also not aligned while clicking on the "Clear" button on the notification page at the admin's end.
    - #062178 - Admin UI: Getting multiple issues on the "Payment Methods" page while accessing the 'Getting Started' section
    - #062124 - Admin UI: Admin is not able to disable the "Publish Inventory" option while editing the seller inventory at the admin's end.
    - #062118 - Admin UI: "Active and Inactive" option is not showing in the table and while searching on the Seller Inventory page at the admin end.
    - #062116 - Admin UI: Placeholder is missing for the "Seller name or email" field while searching and the whole table is not getting blurred while loading on the Seller Inventory page at the admin's end.
    - #062221 - Admin UI: Pagination is not working properly while admin selecting the different page numbers on the last page of the table on the whole system 
    - #062275 - Admin UI: "Action button" label is missing under the language label section.
    - #062167 - Admin UI: Hint text is not showing for the "getting started" and "search" while hovering on it at the admin's end
    - #062210 - Admin UI: Warning message is showing while editing and adding the category and '+' icon is not showing in the correct position under the categories section in the Arabic language.
    - #062281 - Admin UI: By default, the search's placeholder is removed while clicking on the "Clear" button under the Order statuses section.
    - #062119 - Admin UI: Multiple issues are faced while editing the seller's inventory at the admin's end
    - #062121 - Admin UI: Multiple issues while viewing the "download files and links" on the Seller Inventory at the admin's end
    - #062133 - Admin UI: Multiple UI issues while clicking on the Notification icon at the admin's panel
    - #062134 - Admin UI: Wrong navigation while clicking on the notification and notification's details are showing under the logs section at the admin's end
    - #062350 - Admin UI: Messages' format is not the same as the buyer sent it from the front-end.
    - #062363 - Admin UI: 2 options are selected while selecting buyer OR seller and the heading is also the same for both options.
    - #062374 - Admin UI: Parse Error is showing while trying to sort the table according to the "affiliate link" under the Affiliate table.
    - #062271 - Admin UI: "Undefined offset" error is showing while viewing the subscription order's details.
    - #062325 - Admin UI: Arabic Language: Records are not showing on the Recommended tag products Weightages page.
    - #062354 - Admin UI: Search by Keyword is not working under the messages section and search fields UI is also not correct 
    - #062335 - Admin UI: The product's listing is not showing after adding the one product on the "Related products" page
    - #062352 - Admin UI: Address details of the buyer are not showing under the messages section and shop details are also missing(Receiver details)
    - #062371 - Admin UI: Admin navigates to the other reports while clicking on the sorting on the seller's page
    - #062397 - Admin UI: Search is not working using "Username" and "Phone number" on the Blog Contribution page.
    - #062398 - Admin UI: "Contribution status" font is not correct and there is a spacing issue while editing the blog contribution details on the Blog Contributions page.
    - #062411 - Admin UI: Sorting is not working and display Order is showing zero in the table on the "Collection" pages.    
    - #060542 - Admin UI: Suggestion to show the "items per page" option if the records listing contains less than 20 records on the whole system
    - #062416 - Admin UI: Arabic Language: Instructions are not showing in the Arabic language and the admin navigates to the export section while trying to download the N/A file 
    - #060565 - Admin UI: In the search, Address's title is also deleted while deleting the Users under the Users address
    - #062440 - Admin UI: Images are not aligned with the Image title and the "reset and save" button is not showing in the footer section while editing the Image attributes under the SEO section
    - #062456 - Admin UI: "Language Data" option is showing while editing the advanced setting on the meta-tag management page under the SEO section
    - #062454 - Admin UI: Columns alignment is changing while admin clicks on the sorting option under the meta-tag section and double options are selected on the side menu while clicking on the View HTML and XML option
    - #062458 - Admin UI: Profile image and email address is not updated while clicking on the "My Profile" option
    - #062459 - Admin UI: "Double validation" messages are showing for the confirm password field while changing the admin's password
    - #062498 - Admin UI: Spacing issue while editing the shop details under the Manage Shop section.
    - #062510 - Admin UI: "Parse error" is showing while trying to sort the table according to the User Type column under the deleted users' table.
    - #062336 - iOS: When the user tries to remove the reward points, Incorrect message is coming. [APP]
    - #062606 - on checkout app page base payment current amount not coming [9.3.1]
    - #062668 - Stripe pay won't charge correctly if payment amount belongs to Zero Decimal currency
    - #062400	Admin UI: Admin is not able to switch between languages smoothly
    - #061647 - Admin UI: "Approve" order status is showing for the physical order while updating the paid order's status under the order's details section
    - #062782 - Admin UI: Same priority is showing for the different order's status and rearrangement of the order status is also not working properly.
    - #062795 - Admin UI: "Search icon" is not showing if the admin select the keyword from the suggestion under the shipping profile.
    - #061905 - Admin UI: Toggles are not aligned and location selection is not working properly on the 'Product' page under the settings section
    - #061685 - Admin UI: 'Search icon' is not showing in the search field on the automatic badges page
    - #062659 - Admin UI: "Placeholder image" is not showing after deleting the uploaded file and pagination is also not working properly under the collection management
    - #062521 - Admin UI: "Buy Together products" is not saving under the Buy Together Products section 
    - #062523 - Admin UI: Admin needs to scroll the side menu to see the selected option
    - #062851 -	Admin UI: "card-body" is refreshing while clicking on the dropdown option on the dashboard and while clicking on the shop's name admin is navigating to the same page
    - #062610 - Admin UI: Unavailable pointer is not showing on the banner listing section and sr. no. is not showing correctly on the import instruction page
    - #062603 - Admin UI: Spacing is not consistent between the footer section and last field while opening the drawer
    - #062881 - Admin UI: Admin is not able to update the commission amount of the default commission, the search is not working according to the product, and the "view log" icon is not showing on the "Commission management" section
    - #062570 - Admin UI: "Metaballs menu" is not working while clicking on it for the password field on the login page
    - #062879 - Admin UI: Getting an error while editing the records on the "social platform" section
    - #062876 - Admin UI: Getting an error while adding the new record under the "seller approval" section and caption name is also not showing while editing the record
    - #062873 - Admin UI: Pagination is not working on the admin user's permission page
    - #062678 - Admin UI: The "Remove File" option is not showing properly while trying to upload the large file while adding the Media to server under the Import/Export section
    - #062816 - Admin UI: Admin is not able to select the dropdown-item of the "product warranty type" field while adding the product
    - #062468 - Admin UI: Upload image's placeholder is not showing while adding the banners and "Invalid Request" messages is showing while changing the status of the banner on the collection's page under the CMS section
    - #062864 - Admin UI: Admin is not able to edit the records under the "Categories request" section
    - #062862 - Admin UI: The buyer's image is not showing properly under the messages' section on the 'order return request' page
    - #062899 - Admin UI: Getting a UI design issue on the following modules

```sh
TV-9.4.0.20220304
```
    - #062926 - Seller UI: The header's background color is not visible and the "view order" option is not working for the recent orders
    - #062930 - Admin UI: The processing message is showing while filling the bank address and press "enter" to go to the next line while adding the seller 
    - #062932 - Admin UI: UI is not correct if open the other seller in the same browser
    - #062927 - Seller UI: Product images are not showing while viewing the information of the marketplace products and the "add inventory" icon is not showing while hovering on it and the table column size is also changing while changing the status of the seller shipping
    - #062853 - Admin UI: Fatal error is showing while clicking on the "SEO Friendly URL" of the brands and URL is not getting highlighted while having on it
    - #062860 - Admin UI: Font size and color are not correct of the titles and their data while viewing the seller approval's request
    - #062906 - Admin UI: Getting a UI issue on the Special price and volume discount
    - #062852 - Admin UI: The size of the "options" and "specification" section is changing according to the data while adding the product
    - #062966 - Unable to login via social account
    - #062822 - Admin UI: The rating type's name is not showing in the table
    - #062652 - Admin UI: Admin is not navigating to the "link record" tab after adding the language data and the drop-down design is also not correct while adding the brands under the collection section 
    - #062467 - Admin UI: Tooltip is showing while adding and editing the records on the Collections page under the CMS section
    - #062652 - Admin UI: Admin is not navigating to the "link record" tab after adding the language data and the drop-down design is also not correct while adding the brands under the collection section
    - #062783 - Admin UI: "Invalid Order" error is showing while changing the order's status to shipped and using self-shipping(in case of shipping plugin is ON) under the Orders section
    - #062440 - Admin UI: Images are not aligned with the Image title and the "reset and save" button is not showing in the footer section while editing the Image attributes under the SEO section.
    - #062970 - Seller UI: Delete media functionality is not working while adding the product.
    - #061671 - Admin UI: Upload image option is not showing and getting a UI issue while selecting a Date while adding and editing the discount coupons
    - #062440 - Admin UI: Images are not aligned with the Image title and the "reset and save" button is not showing in the footer section while editing the Image attributes under the SEO section
    - #062994 - unable to set shipment method incase of shipping plugin
    - #062601 - Admin UI: Page's design is not aligned while clicking on the '+' icon in the blog post categories page, processing and successful messages shows simultaneously and placeholder label is also missing for the whole blog section
    - #062592 - Admin UI: Double products are selected while binding the products with the discount coupons and UI is also not aligned
    - #062595 - Admin UI: Approval's sorting is not working on the badges page and getting multiple Ui issues on the same page
    - #062955 - Seller UI: Error is not showing while seller trying to add the already deleted collection under the manage shop section
    - #062857 - Admin UI: Getting multiple issues on the product's tag page
    - #062790 - Admin UI: "Fetch Shipping Rates" functionality is not working and its UI design is also not aligned
    - #062962 - Seller UI: "Ctrl+F" is opening the browser search even if this option is unselected and the drop-down listing is not aligned while switching between the user-type
    - #062991 - Seller UI: Drop-down is not showing for the "Select Badge" field while sending the badges' request.
    - #062946 - Seller UI: Character's count validation is not showing while adding the phone number on the whole seller's dashboard
    - #062969 - Seller UI: Getting multiple issues while adding the product at the seller's end
    - #063006 - Seller UI: Fatal error is showing while clicking on the Badges and Ribbons options
    - #062987 - Seller UI: Records are not showing properly while Drag-drop it under the option's value section and "delete icon" is not showing while hovering on it
    - #062920 - Seller UI: Getting an error while submitting the "Seller Approval Form"
    - #062989 - Seller UI: Not able to go to the language data and media section while adding the brands and uploaded media is also not showing in the table
    - #062988 - Seller UI: "View Tax rates" option is not showing under the Tax category page
    - #062950 - Seller UI: Loader is not showing while uploading the media and pickup's drawer is showing after uploading the media under the manage shop section
    - #062967 - Seller UI: Drop-down icon is not showing correctly, the Save button is disabled initially, the tooltip is not showing and the Product warranty field size is changing while selecting the duration while adding the product
    - #062974 - Seller UI: The product's image is not showing while viewing the details of the seller's product and the seller's shipping is not working for the marketplace products.
    - #062986 - Seller UI: "Invalid error" is showing under the language data section while adding the options value, the continuous loader is showing while adding/editing the options and their values and previously added data is showing while adding the new options
    - #062975 - Seller UI: "No Record Found" message is not showing if the seller trying to search the wrong record and the "invalid request" error is showing while trying to add the product's tags. 
    - #063079 - Admin UI: Json error is showing while uploading the banner under the collection section
    - #063178 - Admin UI: The "recent requests" is not showing on the top of the table under the cancellation request and the "update status" design is not the same on the "return request and cancel request page".
    - #063180 - Seller UI: Search icon is not showing if seller select the keyword from the suggestions, canceled label design is also not correct and placeholder color is not same for all the fields under the "advanced search".
    - #063105 - Seller UI: Double fields are showing even if it is not a "combined tax" while editing the tax at the seller's end
    - #063126 - Affiliate UI: Nothing happens when the user clicks on Notifications icon.
    - #063159 - Admin UI: "Shipping Packages" information is not showing under the order's details page at the admin's end.
    - #063106 - Seller UI: Updated records are not showing correctly while editing the tax category rules at the seller's end
    - #063188 - Seller UI: The spacing issue between "special price and discount percentage" in the table and edit date is also not working under the special price section.
    - #063125 - Affiliate UI: Getting multiple issue on the Account tab.
    - #063124 - Affiliate UI: Email section is not clickable on home page.
    - #063122 - Affiliate UI: Getting multiple issue on the Home page.
    - #063106 - Seller UI: Updated records are not showing correctly while editing the tax category rules at the seller's end 
    - #063185 - Seller UI: Blank screen is showing with some random message while clicking on the "Approval Refund " button under the return request section
    - #063158 - Seller UI: "Net Amount" calculation is not correct in the order's details page, order's quantity is missing, and address's format is also not correct at the seller's end
    - #063153 - Seller UI: The dropdown icon is not correct while selecting a zone and getting UI issues while adding/editing the shipping profile
    - #063104 - Seller UI: Suggestion to give the option to upload the media while sending the category request
    - #063186 - Seller UI: Spacing issue between the search field and advanced search icon at the seller's end.
    - #063103 - Seller UI: Badges request option is not showing if the "record" is linked with the badge and error is showing while clicking on the "request" icon on the badges page.
    - #063101 - Seller UI: Badges functionality is not working properly at the seller's end.
    - #063191 - Seller UI: "Dropdown icon and cross icon" is not aligned while binding the product and the "successful message" is not showing while editing the details under the special price and volume discount section
    - #063188 - Seller UI: The spacing issue between "special price and discount percentage" in the table and edit date is also not working under the special price section
    - #062521 - Admin UI: "Buy Together products" is not saving under the Buy Together Products section
    - #063323 - Advertiser UI: Request Withdrawal: Reset button is not working.
    - #063331 - Affiliate UI: The user is not able to update/change the email address.
    - #063314 - Advertiser UI: Getting multiple issue on My Promotions Page.
    - #063352 - Seller UI: Warning message is showing while clicking on the "badges" on the breadcrumb on the "Bind Condition" page under the badges section at the seller's end.
    - #063362 - Seller UI: Seller navigates to the dashboard while clicking on the 'reports' on the breadcrumb under the Sales Report section.
    - #063462 - Buyer and Seller UI: Navigating to the same page while clicking on the email address under the My Profile section on the top-header.
    - #063451 - Buyer UI: The alignment of the "No Record Found" is not correct under the Wishlist section and Page Not Found is showing while clicking on the Shop under the Shop's Wishlist section.
    - #063463 - Buyer UI: "Save Changes" and "Save" button is showing for the same functionality (Request My Data) and the confirmation message design is not correct while requesting to Remove My Data.
    - #063459 - Buyer UI: Spacing issue between the country code and phone number field while adding/editing the addresses and deleting address functionality is not working under the profile section at the buyer's end.
    - #063448 - Buyer UI: A validation message is showing after sending the email on the "Share And Earn" page and transaction IDs are showing in the 2-lines under the My Credits section.
    - #063439 - Buyer UI: Proper information is not showing for the "search" field under the Order's section.
    - #063433 - Seller UI: "Copy Link" functionality is not working in the case of Digital products and delete button is also not aligned.
    - #063461 - Seller UI: Getting multiple issues on Tax category page.
    - #063440 - Buyer UI: Different icon is used for the "feedback" functionality on the dashboard and on the order's page AND the wrong order ID is showing under the Rewards Points section Assigned.
    - #063408 - Buyer UI: "Delivery and Billing Address" format is not correct on the order's details page at the buyer's end.
    - #063398 - Seller UI: The subscription coupon's image is not showing under the subscription offer section and recently purchased plan information is not showing under the "My Subscription" section at the seller's end.
    - #063508 - Seller UI: Getting multiple issues on Shipping services page.
    - #063491 - Seller UI: On hovering on the screen unnecessary tooltip 'Click here for edit' is coming.
    - #063490 - Seller UI: 'Related Products' label is showing instead of 'Buy together products'.
    - #063450 - Buyer UI: "Unexpected token" error is showing when clicking on the "View Items" button on the Wishlist page and the Wishlist's cards size is not the same.
    - #063393 - Seller: JSON error is showing while adding sub-user trying to buy the subscription
    - #063392 - Admin UI: Sub-Users are showing while adding the transaction at the admin's end
    - #063367 - Seller UI: Order ID is not showing on the Transaction report and search by comment is not working under the Financial report.
    - #063471 - Admin UI: Same rating type options are showing while binding it with the category at the admin's end.
    - #063489 - Seller UI: Buy together Products: New Added records are not showing in listing.
    - #063284 - Affiliate UI: Home Page > Search: The background screen moves/dragged along when the user clicks on the dropdown icon on the popup screen
    - #063272 - Affiliate UI: Home page: Search is not working.
    - #063312 - Advertiser UI: Home page: Search is not working.
    - #063313 - Advertiser UI: Home page: Search: The background screen moves/dragged along when the user clicks on the dropdown icon on the popup screen.
    - #063164 - Seller UI: "Shipping's Tracking URL" is not showing under the order's details page
    - #063355 - Seller UI: Alignment is not proper while binding the products with the badges at the seller's end
    - #063384 - Suggestion to change the functionality of the uploading profile images on the seller's, buyer's advertiser's, and affiliate's dashboard and make it similar to the admin's dashboard
    - #063533 - Buyer: After registration, the confirmation message is not aligned at the front-end.
    - #063476 - Seller UI: Infinite loader is coming when user tries to upload the profile picture.
    - #063465 - Seller UI: Reset button is not working on Tax categories.
    - #063348 - Seller UI: Some icon is not showing while hovering on it and the calendar icon is also missing for the date field while adding the "bind condition" for the manual badges under the Badges section at the seller's end.
    - #063401 - Seller UI: Not able to upload the file under the "Upload Bulk Media" section under the Import/Export section at the seller's end.
    - #063534 - Admin: Multiple delete functionality is not working while deleting the "Home Page Slides" under the CMS section at the admin's end.
    - #063531 - Admin: Suggestion to show a default sorting of the user's table according to the "Reg. Date" at the admin's end.
    - #063348 - Seller UI: Some icon is not showing while hovering on it and the calendar icon is also missing for the date field while adding the "bind condition" for the manual badges under the Badges section at the seller's end.
    - #063579 - Issue coming on shop contact form.

```sh
TV-9.4.0.20220406
```

    - #063504 - Seller UI: Getting multiple issues on sub users page. 
    - #063427 - Seller UI: Dropdown is closing and opening while clicking on the "Digital files and Digital Links" option, the CSV file is not uploading, double delete options are showing, and the table width is not fixed in the case of digital file while adding the Digi
    - #063605 - Buyer: "404 PAGE NOT FOUND" error is showing after a new user's registration if the auto-login is enabled at the front-end.
    - #063621 - Admin: "Undefined variable" error is showing at the footer(Pagination) on the admin user's permission page
    - #063576 - Buyer: On the header, options are showing highlighted continuously after clicking on it, and the search icon is not aligned when "No record Found" at the front-end.
    - #063622 - Buyer: "Forgot Password" functionality is not showing while login at the front-end
    - #063619 - Seller: "Page not found." is showing while the admin clicks on the attached file under the seller approval request section
    - #063620 - Seller: Proper error message is not showing at the seller's end if their form is rejected by admin and the rejection limit is greater than the "Max seller request attempts
    - #063629 - Buyer: "Page not found" is showing while the buyer verifying the "change email" and email address is also not updating.
    - #063493 - Badges listing is not shown as per search filters.
    - #062957 - Seller UI: The product's listing is not showing while linking the product under the collection section
    - #063616 - Buyer: "Calendar" icon is not showing for the date field in the seller approval form at the front end and an error is not showing while uploading the wrong file in the same form.
    - #063560 - Admin: The tooltip is not showing correctly after clicking on the Action button under the user's section
    - #063537 - Admin: The whole page is not getting blurred while the loader is showing on the page at the admin's end
    - #063599 - Buyer: Error is showing while verifying the email while registering as a new user at the front-end 
    - #063638 - Advertiser: Auto-login is not working after registering as an Advertiser and the advertiser's company information is not showing at the admin's end
    - #063647 - Buyer: "Invalid Form submitted" error is showing while trying to register with a Phone number
    - #063679 - Buyer: Seller's name is not showing with the product while adding the product into the cart and while proceeding with the payment at the front-end
    - #063678 - Buyer: Shop > Shop top products: Clear button is not working
    - #063674 - Seller: "Invalid Request" error is showing while adding the media for the product at the seller's end
    - #063672 - Buyer: Getting an error on shop reviews page.
    - #063671 - Seller: "Translate to other languages" functionality is not working while adding the Inventory at the seller's end
    - #063669 - Admin: "Order cancellation age (Days) and Return age" information is not showing under the shop details section andat the admin's end
    - #063444 - Advertiser UI: Some of the labels are not showing in Arabic
    - #063630 - Admin: UI is not correct after sending the email to the user from the admin's end
    - #063749 - Admin: While adding a product, drop down and auto suggestions both are showing for the country field.
    - #063742 - Buyer: When the user clicks on the view button of the discount coupon 'Please configure your location' is coming
    - #063733 - Buyer: Geo Location: Suggestion to add a clear all button
    - #063695 - Buyer: Product is still showing under 'Save for later' section even though the buyer has added it to the cart.
    - #063694 - Admin: Suggestion to don't show the sorting according to the Brand's name by default and recently added brands should show on the top of the table
    - #063690 - Admin: Loader is not showing while uploading the media under the category section
    - #063686 - Admin: The admin is able to delete the categories if their associated products are deactivated
    - #063666 - Admin: Navigate to the wrong link while clicking on the "Click to Login" option in the Password reset successfully email at the admin's end
    - #063675 - Buyer: Products are not showing on the Map and the "Undefined variable" & "Warning" message is showing on the Map view Page
    - #063766 - Buyer: Print functionality is not working after placing an order at the front-end
    - #063794 - Seller: Getting fatal error on language data page
    - #063776 - Admin: Asterisk sign is missing for the comments section.
    - #063819 - Seller: User is unable to place request for new Category and Brand.
    - #063843 - Buyer: Expired OTP code is working while placing an order using COD at the front-end
    - #063842 - Seller: Getting an error when the user tries to bind the conditions with the ribbons.
    - #063821 - Seller: The User is not able to add products.
    - #063801 - Admin: The order status timeline is not showing correctly according to the date on the order details page at the admin's end and the timeline design is also not matched with the seller's side
    - #063423 - Seller UI: Scrolling is not working properly when the seller awaiting the admin's approval and charts values are also not showing properly on the Dashboard
    - #063840 - Admin >> Orders >> View detail: UI is not correct.
    - #063810 - Seller: Cross button is not showing on Cancel order request
    - #063818 - Admin: Sorting is changed after performing an action on the product review's request at the admin's end
    - #063383 - Seller UI: Not properly defined " search by what?" on the search field under the My Credit section and "Transaction ID" is shown in the 2-lines in the My Credits table
    - #063812 - Seller : When the Seller adds a pickup address it is showing twice.
    - #063825 - Buyer: 404 error page is showing while the buyer clicking on the "Write A Review" option on the product details page
    - #063808 - Seller: Shipping charges are showing on the order details page at the seller's end if shipping is provided by the admin
    - #063922 - Seller/Buyer/Affiliate/Advertiser: Sign In page design is not aligned/correct while clicking on the "Withdraw" option under the My credit section if the session is expired
    - #063920 - Seller: "Fulfilled By: Admin" is showing for the digital products on the order listing page at the seller's end
    - #063688 - Admin: Placeholder text is not proper for the Rating types field.
    - #063907 - Buyer: The user is not able to send the invitation for Share and Earn
    - #063668 - Buyer: Map view button is not working.
    - #063348 - Seller UI: Some icon is not showing while hovering on it and the calendar icon is also missing for the date field while adding the "bind condition" for the manual badges under the Badges section at the seller's end
    - #063942 - Admin: Commission amount is not showing while viewing the order details at the admin's end
    - #063434 - Seller UI: "Field 'selprod_id' not found" error is showing while adding the inventory if "Digital files and Digital Links" is added while adding the digital product at the seller's end
    - #063928 - Buyer: Sellers address is not showing aligned/correctly on the "Return Request" at the buyer's end and a different label is used for the same functionality i.e. Seller and Vendor
    - #063751 - Seller: The product's images are not showing properly while viewing the "Marketplace Products" at the seller's end
    - #063981 - Buyer: The product's price is also increasing with the quantity on the checkout page at the buyer's end
    - #063888 - Buyer: Shop's options are not showing on detail page
    - #063829 - Buyer: Getting multiple issues under the rating section at the front-end
    - #063890 - The "Payment Pending" status is showing for the COD Order at the admin's, seller's and buyer's end
    - #063889 - Buyer: When the buyer adds the shop in Wishlist, the Wishlist icon does not get highlighted.
    - #063910 - iOS Web: Buyer: The user is not able to place an order
    - #063943 - iOS Web: Getting an error when the user clicks on Dashboard.
    - #063946 - iOS web: Getting a multiple issues when the user adds a product
    - #063959 - Admin: Cart total amount is not showing correctly on the order details page at the admin's end
    - #063958 - The special price is not showing properly at the buyer's and seller's end and the "Print" option is not working after placing an order fr the special price product
    - #063957 - Buyer: The special price percentage is not showing correctly at the buyer's end
    - #063954 - Buyer: Discount calculation is not correct on the order details at the buyer's end
    - #063970 - OS web: Seller : Getting multiple issues under Promotions section.
    - #063963 - Admin: Undefined Index error is showing while opening the withdrawal requests' notification and default sorting is not showing according to the date in the withdrawal requests' table
    - #063992 - Seller: An error is showing while the seller's trying to self-ship in case of Shipping Plugin is ON and the error is not showing while the seller clicks on the "Fetch Shipping Rates" on the order details in case plugins keys are missing 
    - #063752 - Seller: Digital files and digital links of the product are not showing while viewing the marketplace details and adding the inventory at the seller's end, if those are added while adding the product at the admin's end
    - #064045 - Admin: Adjusted amount's details are not showing on the subscription order's details at the admin's end, in case of the admin enabled the "adjust amount" option for the subscription from the settings section
    - #063931 - Admin: Return amount is not showing correctly on the "return order request" page at the admin's end
    - #064084 - Seller: Net amount is not showing correctly on the order details at the seller's end
    - #064065 - Admin >> Reports >> Product variants: Advanced search button is not working.
    - #064051 - Admin: Pagination is not working properly on the product listing page at the admin's end
    - #063936 - Suggestion to redesign the download file option on the return request detail page at the seller's and buyer's end
    - #063891 - Admin: The "Approved" status is showing for the COD orders at the admin's end
    - #064105 - Buyer: Duplicate records are creating while the admin edits the existing blog post.
    - #064106 - Admin UI : Home page : UI is distorted    
    - #063991 - The fields' arrangement is not correct under the Order Summary on the Order details page at the admin's, seller's, and buyer's end
    - #063993 - Seller and Buyer: Return/Cancelled status is not showing in the timeline on the order details page at the seller's and buyer's end 
    - #064015 - Buyer: Volume discount should be shown in different color
    - #064017 - Admin: Product's name is not visible.
    - #064116 - Advertiser UI: UI is distorted under promotions section.
    - #064008 - Admin: The same functionality works differently on the different pages in the search field at the admin's end
    - #064013 - Admin: Getting an error when the user edit the categories.
    - #064033 - Seller: The subscription's order summary is not correct on the confirmation page after buying t
    - #064100 - Buyer: Getting an error under blog post section.
    - #064096 - Buyer: Blogs: Getting a wrong error message, When the user clicks on any blog category
    - #064109 - Buyer: UI is not correct under blogs section
    - #064064 - Admin: Search button is missing for filters under report section.
    - #064055 - Admin: States listing is not showing while enabling the default Geo-Location option under the Product's settings
    - #064054 - Admin: No Record Found message is not showing
    - #064142 - Buyer: Continue button is showing twice on checkout page.
    - #063950 - Seller: Upload media is not working while adding the digital product at the seller's end
    - #063714 - Buyer: Geo Location: Locations drop down overlaps with the Delivery locations section. 
    - #064140 - Buyer: The user is unable to remove the items from the 'Save for later' section.
    - #064030 - Suggestion to remove the "Delete" button on the subscription-checkout page and give a "Back button" on the same page
    - #064038 - Admin: Commission is not updating at the admin's end, If the seller buying a different package plan with a different commission
    - #064041 - Admin: Subscription Orders : View button is clickable but it's now working under Order Payments.
    - #064035 - Seller: 404 error page is showing while the seller clicks on the "My Account" and "My Subscription" option after buying the subscription package
    - #064136 - Addition of Products under "Buy Together Products List" on the Product Detail Page
    - #064081 - Seller: "Link to" option is showing if the record type is "Shop" and dropdown listing is not showing properly while linking the record under the Badges section at the seller's end 
    - #064041 - Admin: Subscription Orders : View button is clickable but it's now working under Order Payments. 
    - #064042 - Admin: Wrong Payment Mode is showing and commission rates* are not showing while viewing the subscription order details at the admin's end
    - #064049 - Admin: User is unable add a admin user.
    - #064113 - Seller: Digital files and links are not uploading while adding the digital product at the seller's end
    - #064091 - Blogs: Blogs categories are showing on the front -end even no blog post is linked with it.
    - #064058 - Admin: Page's title is not showing correctly while selecting some of the options under the Getting settings section
    - #063969 - The "Total Saving" option is not consistent in the order summary of the admin's, seller's, and buyer's end while placing an order for the special price product
    - #063896 - Admin: Digital's product file and links are not showing on the order details page at the admin's end
    - #063965 - Admin: Transaction details are not showing correctly at the seller's/buyer's/affiliat's/advertiser's end while sending the withdrawal request to the admin 
    - #063900 - Order ID is not showing with the transaction details at the admin's and seller's end 
    - #063909 - "Quantity" and "Combined tax's value" are not shown after placing the order at the buyer's end and seller's end and different terms are used for the same functionality i.e. Shipping charges and Delivery Charges
    - #063815 - Getting a UI design issue for the "shipping tracking link" at the admin's, seller's, and buyer's end
    - #060863 - Admin UI: Getting multiple issues under the side's menu section
    - #064218 - Buyer: There should be placeholder image for blogs
    - #064051 - Admin: Pagination is not working properly on the product listing page at the admin's end
    - #063901 - iOS Web > Buyer :Orders: Getting multiple issues on Order detail page.
    - #063898 - The "In Process" status is showing after "Approved" while changing the status for the digital orders at the admin's end and the "In Process" status is showing in the timeline of the seller and buyer 
    - #064342 - Admin: The user is unable to delete products under product catalog section.
    - #064321 - Paid amount's details are showing incorrect on the view-subscription-order at the seller's end, in case the admin enabled the "adjust amount" option for the subscription from the settings section. 
    - #064325 - Admin: Incorrect message is showing when the user removes the tag under product form section.
    - #064332 - Admin: UI is distorted under specifications section
    - #064359 - Banner images are not showing under category section
    - #064386 - Seller: Display order field is missing at seller's end under 'Option values for seller option' section.
    - #064382 - Seller: Getting multiple issues under Marketplace Products Requests section
    - #064412 - Suggestion: To add a new menu or button on the buyer end to view the 'Saved for later products
    - #064410 - Admin: Getting multiple issues under category collection section
    - #064409 - Admin: CMS: There should be a successful message after deletion of the records under collection section
    - #064432 - Suggestion: Admin: Disabled records should be shown greyed out
    - #064451 - Admin >> CMS: 'Update other languages data' is not working under FAQs section.
    - #064457 - The order amount does not get credited to the buyer's wallet on order cancellation.
    - #064461 - The buyer is able to place the return request by uploading the invalid files in the upload media field.
    - #064459 - Buyer: FAQ Category collection is not displaying at the front-end.
    - #064466 - Suggestion: Records should be displayed in listing according to the display order.
    - #064470 - Admin: Unable to change the status when the session expires or the user is logged out
    - #064464 - Inconsistency issue in special price on admin and seller end
    - #064400 - Undefined Index Notice appears on the seller registration page
    - #064466 - Suggestion: Records should be displayed in listing according to the display order. 
    - #064465 - Admin: Accordion icon is not displaying when the user adds new links under 'Quick links' section
    - #064469 - The previously selected zones do not appear when the admin tries to edit any combined tax rule.
    - #064403 - Admin >> CMS: Brands are showing multiple times under 'Brand layout2 setup' section.
    - #064467 - The tax amount appears wrong on the order details page.
    - #064550 - Admin: Getting an error when the user clicks on save button under Banner setup section.
    - #064501 - A syntax error occurs when the user tries to place an order refund request.
    - #064576 - The user profile image is missing in the commission history popup
    - #064573 - Undefined Index Notice appears on the buyer dashboard.
    - #064571 - An error occurs when the admin tries to add the commission for any category or user
    - #064563 - Admin: Total record's count is not showing under FAQs section.
    - #064558 - Suggestion: A icon or button should be present to go to the commission settings page from the commission setup page.
    - #064556 - The product name appears twice on the order details page on buyer and seller end
    - #064582 - The tax structure name appears on the checkout page at the buyer's end in case of a single tax structure.
    - #064583 - The admin is able to add a tax rate of more than 100%.
    - #064596 - Admin: Unwanted 'Slider' text is showing for the searched users
    - #064583 - The admin is able to add a tax rate of more than 100%. 
    - #064585 - success message URL is appearing even without making a purchase
    - #064594 - Admin: Suggestion to show the latest added records on the top of the listing page.
    - #064591 - Suggestion: Please add placeholder image for 'Banner Layout2'
    - #064593 - An error occurs when the admin tries to edit any commission in which product and seller are added.
    - #064612 - Continue button get disappears if new address added on billing address selection, checkout.
    - #064601 - Search is not working under FAQs section.
    - #064597 - Suggestion to add 'No records found' template under FAQs section
    - #064637 - Buyer: Review's like and dislike links are not clickable
    - #064629 - Buyer >> Orders >> Nothing happens when the user clicks on the product's name
    - #064640 - The wrong alert message appears when the admin tries to delete the tax structure.
    - #064622 - Include and exclude states options should not appear when the admin selected the 'Rest of the world' in the 'To country' field while adding tax rule
    - #064666 - Admin: Getting multiple issues under threshold product section.
    - #064651 - Suggestion: To show the dimensions of the shipping package with the package name while adding a product from the seller or admin end.
    - #064679 - Buyer: Favourite label is showing instead of Wishlist under dashboard section.
    - #064681 - Buyer: Invalid request is coming when the user clicks on the 'View more' button under Cancellation Requests section
    - #064505 - The refund calculations appear wrong on the seller's end.
    - #64697 - Admin >> Add product: Images are uploaded multiple times on multiple clicks under the media section
    - #064704 - Radio buttons are not properly aligned with the text in the shipping rates setup popup.
    - #064703 - Shipping rates added with price and weight conditions are also visible on the front end even if the conditions does not match
    - #064712 - Undefined Index notice appears on the order return request details page at the buyer end.
    - #An error occurs on the checkout page when the buyer tries to buy the product for which the available stock quantity is the same as the minimum purchase quantity. 
    - #064745 - A broken image appears on the product section in the shipping profile menu if no image is added to the product catalog
    - #064739 - The shipping profile field is missing on the product setup page when the shipping plugin is enabled.
    - #064803 - Shops Reports >> Blank space appears in some fields if there is no data available in the field
    - #064802 - Shop Details Page >> Notice Undefined variable appears when the user clicks on the permalink button on the shop details page
    - #064813 - The 'Invite through email' popup gets opened up at the end of the page when the user clicks on the 'Invite through email' button
    - #064796 - The update status button appears on the order details page at the admin end even if the order is marked as completed.
    - #064795 - Buyer: 'Attach with existing' orders functionality is not working for digital files
    - #064765 - Buyer: Default image is not showing properly under product detail page.
    - #064790 - Buyer: Infinite loader is coming when the user enters invalid/past expiry month.
    - #064815 - Suggestion: To show the texts underlined which are clickable
    - #064812 - The view log button is not visible on the affiliate commission page.
    - #064810 - Affiliate Dashboard >> UI issue on the payment info page on the Affiliate dashboard
    - #064785 - Less count of downloadable attachments when the file title's name is same
    - #064780 - "Something went wrong, please try it later' is coming when the user clicks on the pay button at the buyer's end
    - #064764 - 'Zero' quantity is coming when the product is out of stock under the cart section at buyer's end
    - #064506 - Suggestion: There should be limit while linking pages under Top header section
    - #064809 - Shop Details Page >> Multiple UI issues in the filters section on the shop details page. 
    - #064808 - Shop Details Page >>Multiple issues on the reviews section on the shop details page
    - #064791 - Suggestion: To add a tooltip icon in the date field that the user can view all the orders for specific dates by clicking on that date
    - #064818 - Shop Inventory >> UI issue on the product info popup at the seller end. 
    - #064819 - The previously selected brand does not appear when the seller tries to edit any product.
    - #064826 - The product specification group added to the product is not visible on the front end.
    - #064820 - The shipping profile does not appears on the product setup page on the admin end.
    - #064824 - Suggestion: To show the filters on the category page at the front end.
    - #064505 - The refund calculations appear wrong on the seller's end.
    - #064840 - Admin (Cancellation requests)>> The order cancellation reason selected by the buyer does not appear in the extra info popup on the admin end. 
    - #064855 - Suggestion: To add the order number column in the transaction reports listing. 
    - #064861 - The error occurs when the user seller clicks on the product missing info icon on the shop inventory page.
    - #063377 - Seller UI: Messages' count is still showing after reading all the messages at the seller's end and buyer's end.
    - #063631 - Seller UI: Spacing issue on seller registration page.
    - #063632 - Advertiser: Double background images are showing while registering as an advertiser at the front-end and getting a UI issue while editing the content block of the advertiser at the admin's end.
    - #063813 - Seller: Shop Inventory >> Add product: UI is distorted.
    - #064034 - Web iOS: Admin: Comment popup is not opened when the user clicks on the 'view comment' icon under subscription order section.
    - #064828 - The admin is not able to add a coupon code for the current date
    - #064827 - Product Details Page>> Notice Undefined offset error appears on the product details page
    - #064432 - Suggestion: Admin: Disabled records should be shown greyed out
    - #064823 - The UI of the option name field is not correct on the seller options listing
    - #064209 - iOS web: Applied filters values are not showing under filter by section
    - #064838 - Suggestion: To add Yes/No text instead of the 0/1 in the 'Is seller' field on the advertiser reports listing
    - #064835 - The currency symbol appears with the total promotions count on advertiser dashboard.
    - #064863 - Double entries of discount coupon appears for the single order when payment method is COD.
    - #064860 - UI issue on the request withdrawal popup on the affiliate end. 
    - #064853 - Buyer Dashboard >> The credit stats appear wrong on the buyer dashboard.
    - #064839 - Seller Dashboard >> Multiple issues related to stats on the seller dashboard.
    - #064865 - Suggestion: To show the current active subscription highlighted on My subscription page
    - #064868 - The admin is redirected to the add product page when clicks on the product inventory count that appears with any category on the category listing page.
    - #064872 - The color code do not linked with the color option added by the seller.
    - #064873 - Error occurs in the price setup field on the inventory setup page on the seller end.
    - #064899 - The products added by the seller also appear when the admin exports the master products to an excel sheet.
    - #064894 - The category thumb media field is missing in the exported media file of the categories.
    - #064893 - The categories which has some products associated with it also get deleted when the admin changes the deleted status of the category to YES in the import CSV sheet.
    - #064892 - A success message appears when the admin imports the options value CSV with invalid details
    - #064854 - The coupon discount value appears wrong in the payout reports
    - #064914 - Suggestion: To add the edit button to update any logo in the business logo section
    - #064909 - Notice appears in the variants and options section when admin tries to edit the product details in the master product request
    - #064937 -	permissions issue for sub admin 
    - #064936 - Permission issue for sub-admin user
    - #064928 - Sub-admin shipping and pickup module won't disapear permission if permission restricted.
    - #064920 - Sub-admin didn't logout if permission revoke.
    - #064927 - Go to top button on the payment success page also appears in the invoice print
    - #064925 - No option available to add the billing address if the user close the add billing address popup once without selecting any address.
    - #064919 - The site logo image in the footer of the homepage is not clearly visible
    - #064901 - The seller is not able to update the postal code on the shop setup page.
    - #064905 - Error message appears when the buyer tries to switch to the seller account from the top of the dashboard. 
    - #064907 - Validation message do not get disappeared even if the user has selected the valid file type
    - #064908 - Watermark image added in the admin end is not visible on the products in the front end.
    - #064910 - Only success message appears but the specification does not get linked to the product when the admin imports any product specification.
    - #064884 - The upload file popup does not get opened by clicking on the image icon.
    - #064982 - When admin use "mark as buyer " functionality for affiliate user.
    - #064981 - Mark as buyer Warning popup message is not correct
    - #064957 - The seller gets directed to the catalog page after adding the inventory from marketplace products.
    - #064940 - Plugins edit permissions not working.
    - #064996 - The payment page does not get displayed when the buyer clicks on the 'Continue' button after selecting the shipping method on the checkout page
    - #064886 - Suggestion(Import / Export): To show the allowed file type extension on the media upload section
    - #065012 - The fetch shipping rates button should appears when the shipping plugin is on from the admin side and the manual shipping rates of seller is applicable.
    - #065012 - The fetch shipping rates button should appears when the shipping plugin is on from the admin side and the manual shipping rates of seller is applicable.
    - #065007 - The admin commission is not applicable on the shipping charges if the shipping plugin is on.
    - #065049 - Multiple issues on the 'Pickup addresses' setup page    
    - #065026 - Option name not coming same on frontend and backend .
    - #064985 - sent to email address when we credit or debit reward points from admin .
    - #065038 - it show that otp veriication email has been sent on screen before we click on get otp
    - #065039 - The quantity decrease button should be disabled on the shipment page if the selected quantity is same as the minimum purchase quantity.
    - #065096 - Sellers Dashboard - When we click on any date from the table to view all the sales made on that date, a page display error. 
    - #064967 - Unappropriate Data used to appear in "profit by products" on seller end
    - #065098 - Multiple issues on the advertiser end
    - #065044 - The tax category of the tax plugin bounded with the product does not get removed even if the admin disable the tax plugin.
    - #065094 - 'Invalid account' error occurs when the user tries to forget the password using the phone number.
    - #065048 - Notice appears on the checkout page when user clicks on the shipping tab without adding any address.
    - #065116 - Issue with the calculations of order calculations.
    - #065101 - The admin is able to update the wrong values in the maximum and minimum cod order total field
    - #065104 - The 'Minimum wallet balance' setting in the checkout settings is not working.
    - #065054 - Preview label button icon is missing on the order details page on the admin end.
    - #065056 - Fatal error occurs when the admin clicks on the view order icon on the order listing page.
    - #065064 - when user click on reviews count , it shows wrong information .
    - #065065 - when user click on count in report section , it redirects the user to wrong page . 
    - #065067 - 'use manual shipping rates instead of third party' settings appears on the manage shop page on the seller end even if the 'Shipped by admin only' setting and shipping plugin is both on.
    - #065070 - Order details does not appears on the payment success page in case of the guest checkout.
    - #065072 - Tax category rule button appears on the tax category listing page when the tax plugin is on.
    - #065076 - Inconsistency issue in the tax section on order details page at admin and buyer / seller end.
    - #065123 - Infinite loader appears when the user clicks on the login button without adding any details in the email and password field.
    - #065125 - Add to wishlist option used to appear in case when option "Add products to wishlist or favorite?" is changes to favourite
    - #065077 - Category counts are not proper .
    - #065082 - During product creation , while adding media for the product , Product brand setup form used to occur automatically .
    - #065099 - The banners on the product details page are not properly aligned.
    - #065112 - sent Discount count functionality for abandoned cart not working properly . 
    - #065157 - Suggestion: To change the validation label on the sign-in page on admin and front end.
    - #065121 - The COD order transaction does not get approved automatically even if the admin marked the order delivered.
    - #065117 - The refund summary appears wrong on the return request page on the seller's end in case of a partial refund
    - #065138 - When user selects discount type as flat. Max discount field should got hidden.
    - #065121 - The COD order transaction does not get approved automatically even if the admin marked the order delivered
    - #065024 - when user click on Dropdown icon in add brand field during product creation
    - #065113 - Notice Undefined index appears on the top of the order cancellation page on the admin end.
    - #065034 - product type (new) or (used) is not coming on product detail page .
    - #065120 - The order details page gets distorted when the buyer clicks on the tracking URL on the order details page.
    - #065195 - Undefined Offset notice appears in the currency section on the footer of the homepage
    - #065202 - Error message appears as 'Record already exists' when the admin tries
    - #065154 - NO email sent to seller about feedback/review regarding his shop or product .
    - #065179 - Multiple transactions appear for the COD transaction on the order details page on the admin end.
    - #065180 - When the seller/admin made changes in the multiple specifications of the product then some changes do not reflect on the product setup page and front end as well.
    - #065176 - Undefined Index Notice appears on the seller registration page. 
    - #065190 - The comments field is missing in the general tab on the 'Seller approval form setup' popup.
    - 065189 - UI issue on the 'User Details' popup on the seller approval request page
    - #064043 - Seller: Alignment is not correct under Subscription packages section
    - #065174 - The buyer is able to place an order of the product with a quantity less than the minimum purchase quantity.
    - #065081 - When user request a brand , option to add banner image is not coming .
    - #065242 - it used to show error at the place of content block , when we disble a content block .
    - #065245 - It shows error when user tries to edit an inactive collection .
    - #065185 - The spacing issue between the content and icons of the social platform on the footer of the page.   
    - #065192 - The error occurs when the user is trying to log in with the phone number.
    - #065254 - Issue while state selection .
    - #065262 - buyer is able to request for refund when order return age is 0 on the seller end . 
    - #065031 - UI issue on the order return requests listing page. 
    - #065270 - The verification link is missing in the verification email received for the email change request.
    - #065277 - The deleted product counts also appear in the product count on the category listing page.
    - #065280 - An error occurs when the admin tries to export the Master products. 
    - #065317 - The notice appears on the order cancellations requests page on the admin end.
    - #065318 - Multiple issues in the subscription package on the seller end.
    - #065316 - Double entries appear in the commission history popup for any change on the commission setup page.
    - #065307 - The error occurs as 'Product not available for shipping on the checkout page for the seller added product when the admin shipping plugin is on.
    - #065273 - UI issue on the order details popup on the order details page on the admin end.
    - #65366 - The placeholder text appears as an option in the listing on the bind product popup on the buyer-together products page
    - #065377 - Category banner images are not visible in the image attributes section.
    - #065398 - Error message appears as 'Invalid access' after user login on the dashboard.
    - #065386 -	The notice appears on the inventory setup page.
    - #065417 - Multiple issues on the downloads tab in the inventory setup page for digital products.
    - #065376 - The image attributes added by the admin are not visible on the front end.
    - #065394 - The default meta tags are missing on the default meta tag listing page.
    - #065431 - The buyer registered with a phone number redirected to the email configuration page when trying to access the seller dashboard.
    - #065485 - On shipping rate setup at seller end rate name should come insted of identifier 
    - #065490 - The default content is not added for some of the content blocks.
    - #065488 - No option to add media for the ribbon
    - #065489 - Checkboxes are not properly aligned with the text in the Payment Method field on the affiliate registration pag
    - #065494 - Spacing issue between the heading and the content on the seller registration page.
    - #065484 - A warning message appears on the top of the order details page
    - #065482 - The order cancels reason listing appears blank if no data is added in the language data field.
    - #065453 - image preview is not proper .
    - #065402 - The content under the dd preview field is not properly aligned on the Digital links setup popup on the seller end
    -#065407 - The seller is able to set the value of the 'Max Download TIme' and validity fields as zero while adding the inventory for the digital products.
    - #065429 - Multiple issues on the Phone number verification popup. 
    - #065486 - 404 page appears when the user tries to log in. 
    - #065484 - A warning message appears on the top of the order details page. 
    - #065436 - UI issues on the reset password page.
```sh 
TV-9.4.0.20220719
```
    - #065554 - Shows fatal error when user clicks on blog post or view all icon 
    - #065574 - The parse error occurs when the admin tries to edit any category banner image attribute.
    - #065599 - User is unable to sort product listing 
    - #065598 - The admin is not able to bind the Child categories of sub-child categories to the product categories collection for the homepage.
    - #065597 - Random brand names appear on the top of the brand listing page
    - #065603 - The preferred dimension value is wrong in the media upload section for the banner field in the brand setup popup.
    - #065172 - Suggestion: To show the pickup slots on the order details page on the admin, seller, and buyer end
    - #065600 - The validation message in the SEO URL field on the category setup popup does not get disappeared even if the user added the valid details to it.
    - #065631 - Two view more icons are displaying.
    - #065586 - Newsletter form is not getting submitted.
    - #065641 - No validation message appears for the warning message field in the "Page language data update" popup.
    - #065640 - When user click on chat profiles . nothing seems to happend.
    - #065620 - Scroller does not appear in the Font-Family drop-down listing.
    - #065680 - Refund icon update on buyer order listing.
    - #065661 - Update show more and show less comments in credits listing buyer.
    - #065660 - Remove newsletter content from order success page in print section.
    - #065659 - Update offer listing with current date.
    - #065638 - Show comments for cancelled requested product in admin and seller end.
    - #065529 - Update seller approval request information headings.
    - #065472 - Multiple image issue for selecting one by one resolved.
    - #065470 - The Update order status field gets disappeared from the order details page when the admin approved the COD request.
    - #065468 - no validation in Badge setup form 
    - #065698 - The admin is able to add the discount coupon with more than 100% value.
    - #065704 - Order status is missing in the under status field on the order listing page on the buyer end.
    - #065701 - The notice appears when the seller tries to change the order status
    - #065700 - Nothing used to happend when user clicks on save icon .
    - #065665 - Order status color update on seller and buyer order view.
    - #065438 - Infinite loader appears when the admin tries to add a new rating type.
    - #065657 - Ribbons set default background color to theme color.
    - #065437 - Resolved issue of added diuplicate shipping company user.
    - #065415 - Resolved special price issue of greater amount in seller and admin.
    - #065702 - Resolved issue of tag listing on input field.
    - #065507 - The seller is again redirected to the supplier approval form even if the seller already placed a seller approval request.
    - #065499 - Payment gateway response data doesn't appears properly.
    - #065496 - Unable to edit date of ribbons bound with shop type.
    - #065495 - The user is redirected to the email configuration page after the admin approves the user truncate data request and the user is logged in.
    - #065434 - 'Resend OTP' button is missing on the 'Verify your phone number' page
    - #065308 - it shows an error while admin tries to approve badge request
    - #065733 - A blank error message appears if the user uploads the invalid file type in the media section for the brand import
    - #065762 - Parse error occurs when the admin tries to generate the label for the order.
    - #065750 - The coupon status tag should appear with the end date that it is active or expired
    - #065772 - Read and write permission for seller sub user for request module.
    - #065770 - An invalid request error occurs when the user clicks on the tax categories rules module when the tax plugin is on.
    - #065763 - it shows deleted products in listing while linking
    - #065752 - Random year value appears for the expiration year for a discount coupon when the admin creates a discount coupon without selecting the start and end date.
    - #065737 - Nothing happens by clicking on the increase and decrease quantity button on the product details page if the available stock and minimum purchase quantity both are the same
    - #065734 - Admin is not able to add media files to a server in the import/export module.
    - #065783 - The sort by rating option appears in the sorting filter but the rating of the product is not visible on the listing page.
    - #065779 - The content under the FAQ does not get changed when the user switches between the faqs
    - #065623 - Ui got distorted on View order return request page .
    - #065672 - content does not appears properly .
    - #065729 - The image description added for any content page is not properly aligned on the front end. 
    - #065730 - Blank space on the front end if no content is added in any content block in the content page layout 1.
    - #065781 - Product count is mismatching with the original count    
    - #065790 - No success popup when user clicks on save icon.
    - #065767 - 404 page should appear when the user makes any unauthorized change in the URL.
    - #065773 - Preferred Dimensions value appears wrong when the admin opens the email templated setting for the first time. 
    - #065777 - Multiple issues on the Products listing page.
    - #065427 - Multiple UI issues on the Phone number verification popup.
    - #065715 - The 'Government notice' added by the seller for the order invoice is not properly aligned on the order invoice.  
    - #065427 - Multiple UI issues on the Phone number verification popup.    
    - #065694 - The location suggestion listing popup gets scrolled over the field when the user scrolls the page by opening the location field.
    - #065186 - Nothing happens on clicking on the today button on the Date field on the seller activation page. 
    - #065615 - Dashboard button is not clickable .
    - #065849 - Revert reward button got removed after first revert process.
    - #065847 - Double reward points got cut when we revert the reward points
    - #065811 - The admin/seller is able to create the shipping profile without selecting any shipping zone
    - #065838 - The wrong error message gets displayed when the admin tries to add a new shipping zone without adding the zone name in the zone name field
    - #064779 - UI is not correct under Product form section for digital links/attachments.   
    - #065804 - Content is not proper for send reset password email . 
    - #065747 - The disclaimer is not added in the media upload section for the preferred dimension or file size.
    - #060593 - Admin UI: Suggestion to auto-select the ALL option for the "to state" and from state" if REST OF THE WORLD option is selected in the "from country" and "to country" field while adding the tax rules
    - #065876 - Suggestion: To remove the tab collapse icon from the product details page if there is only one detail tab is present
    - #065365 - Subscription Price should got update when user selects a different price from the dropdown
    - #065112 - sent Discount count functionality for abandoned cart not working properly . 
    - #065836 - Multiple issues on the Submit Feedback form and reviews section on the product details page.
    - #065897 - The tax structure submodule should not be visible under the tax module when the tax plugin is on
    - #060654 - Admin UI: Suggestion to give a "search" field for the category module
    - #065917 - advance search icon is on wrong side
    - #065921 - The subject of the emails received is not correct for any email. 
    - #065418 - UX issue on the downloads section on the digital product inventory setup page.
    - #065974 - Clear cart option is not working for guest user . 
    - #066007 - Extra options used to appear in search field
    - #066004 - Ribbon preview is not proper in sample image .
    - #065989 - The new rating type gets created even if the user clicks on the cancel button in the 'Add new rating type' popup
    - #065978 - The content in the 'Digital Files listing' on the inventory setup page is not properly aligned.
    - #066035 - The content on the invoice page appears distorted.
    - #066018 - Nothing happens on clicking on the back icon on the order details page on the buyer end
    - #066019 - User didn't got the idea that subscription offer is for which plan
    - #066034 - The payment status appears as pending even if the order is marked as completed.
    - #065992 - A fatal error occurs when the user tries to increase the product quantity on the cart page.
    - #065947 - Buyer is not able to download all the digital files attached with any order.
    - #066066 - Special price not appearing on product listing page .
    - #065983 - The download icons are not visible on the 'Prev files' section on the digital products details page. 
    - #065994 - Impressions count didn't increased for a product promotion
    - #066031 - Blank text appears for the fields for which no data is available in the reports. 
    - #066086 - The digital files added by the admin are visible on the Digital links setup page even if the admin enabled the add attachment at the inventory level settings.
    - #065950 - The download count does not get increased if the admin / seller attach any file with existing digital product order
    - #066106 - The product is visible on the front end even if the tax category is not bound with the product.
    - #066101 - Nothing happens on clicking on the 'Write A Review' button on the reviews permalink page
    - #066017 - Record not appearing in subscription report by seller
    - #066015 - Mutiple issues in report for SUbscription
    - #066073 - The search field on the categories listing page is not working properly
    - #066132 - Parse error occurs when the admin tries to delete the category thumb.
     - #066089 - Nothing happens on clicking on the 'Refill stock' button in the email received for the threshold products.
    - #066100 - UI issue in the tooltip info in the 'Available Quantity field' on the shop inventory page. 
    - #066115 - Suggestion: To remove the notifications from the search field which are not in use and those that appear multiple times.
    - #066113 - Suggestion: To remove the Logos which are not in use from the business logos section.
    - #065712 - Desktop banner cropper appears while admin tries adding a banner for iPad or mobile for any category
    - #066163 - UI issue in the sponsored products collection on the homepage
    - #066137 - The header mega menu is not visible on the front end if the admin deletes all the cms pages from the header navigation.
    - #066172 - The category's names do not appear correct.
    - #066171 - First name field is non editable in blog contribution form.
    - #066194 - Threshold email refill icon redirection.
    - #066190 - The search field in the FAQs section on the seller registration page is not properly aligned
    - #066189 - Blank spacing appears when there is no faq available on the FAQ's listing page
    - #066150 - Multiple issues in email template for mesage regarding return request
    - #066152 - Extra blank spacing appears between the testimonials when the user clicks on the load more button
    - #066158 - The testimonials images are not clearly visible.
    - #066207 - NO email used to come when a seller request for a brand
    - #066213 - Country phone code appears in the General query section even if the phone number is not added
    - #066227 - No email used to come for discount coupon after first purchase 
    - #066229 - Social platform icon is not visible on the shop details page (Pinterest Icon missing)

## UAT points:

    - #Admin dashboard sales stats > set tabs priority, Move Affiliate tab to the last
    - #Admin dashboard > drop-down for today, this week should not display when the API keys are not configured 
    - #Admin dashboard? Top search keywords > No records found message should be displayed
    - #Admin dashboard (Top referrers)? Verify the %age should be displayed or not. We can remove it when it's not required.
    - #Top Search Items replaced with Top Search Keywords
    - #Labels search issue when we have data with type 0
    - #Admin listing pages: logo/image should get enlarged on mouse hover/click (examples brand/badge listing page)
    - #Change label active to activate and in-active to deactivate for all the listing pages.
    - #S.no can be removed from the listing page. Total page record count should be displayed as the footer
    - #Displayed record count with plus sign (10+) in the left navigation section under requests.
    - #Listing pages>> Search Filter --- Add Submit button prior to Clear Button.
    - #Make the Search Button on the Listing Pages fixed when the dropdown gets clicked. It should not fluctuate.
    - #Threshold Products under Product Management or In Reports depending upon the team discussion 
    - #Order cancellation Page – details related to the cancellation (May be under drawer or) , Order Status niche lelo → taaki Order ka status directly ptaa chll jaaye
    - #Amount to be replaced with (Strike out option for the Withdrawn amount) under the Withdrawal Request section, Addition of one more column like Before Withdrawal and After Withdrawal, Balance section renaming, In queue refund request ki info v aani chahiye, Real time balance to be shown…. (Aliegnment of the )
    - #Manage Funds withdrawal requests - label Subtitle , Consideration over the Export option to be introduced under the Withdrawal Request Section (CSV download option) which is currently not placed into the system

```sh 
TV-9.4.0.20220406
```

## Known Issues and Problems :

    - #82248 : Renaming existing DPO Payment Gateway to Paygate as it belongs to South Africa linked with Dpo Group.
    - #93129 : In custom product request form view specification and EAN/UPC code will not come as old data is incorrect
    - #062190 - Admin UI: "Mark as default" font is not correct and the 'default' tag is showing with the plugin even after inactive and disabling the default status on the "Tax Services, and Shipping Services" pages while accessing the 'Getting Started' section.
    - #062521 - Admin UI: "Buy Together products" is not saving under the Buy Together Products section  [old tagify reopen when unfocus ]
    - Following is a list of known errors that don’t have a workaround. These issues will be fixed in the subsequent release. 
        - Change in minimum selling price when reconfigured by Admin
        - Safari and IE 11 do not support our CSS. More info can be found at https://developer.microsoft.com/en-us/microsoft-edge/platform/status/csslevel3attrfunction/
        - System does not support Zero decimal currency while checking out with stripe

## Installation steps:

    - Download the files and configured with your development/production environment.
    - You can get all the files mentioned in .gitignore file from git-ignored-files directory.
    - Renamed -.htaccess file to .htaccess from {document root} and {document root}/public directory
    - Upload Fatbit library and licence files under {document root}/library.
    - Define DB configuration under {document root}/public/settings.php
    - Update basic configuration as per your system requirements under {document root}/conf directory.

## Notes:

    - Procedures : 
        - Execute "{siteurl}/admin/admin-users/create-procedures" is mandatory.
        
    - Composer :
        - Composer should be installed on server to run the stripe connect module: composer.json on root of the project has details to download the required libraries in root's vendor folder.
        - Run command "composer update" at root of the project to update composer and fetch all dependennt libraries: 

    - Configuration :
        - Please configure Ready For Pickup Order Statuses.

    - Stripe Connect Installation :
        - Required to configure callback url as "{domain-name}/public/index.php?url=stripe-connect/callback" inside stripe's web master's account under https://dashboard.stripe.com/settings/applications under "Integration" -> "Redirects"
        -  Setup webhook Stripe Connect  https://dashboard.stripe.com/test/webhooks . 
            - Add Webhook url under "Endpoints receiving events from your account" 
            - "Webhook Detail" > Url as "{domain-name}/stripe-connect-pay/payment-status" bind events "payment_intent.payment_failed", "payment_intent.succeeded".
   
    - Default Shipping profile setup:       
        - To Bind Products and Zones To Default Shipping Profile, Open <site-url>/admin/patch-update/update-shipping-profiles
        - To Bind Zero Tax category as default if "Rest Of The World" country is not bind,Open <site-url>/admin/patch-update/update-tax-rules
        - To Update state code which for only state which is present in old database state table, execute update_state_codes.sql  (Mostly done when upgrading form V9.2 to 9.3 )       

    - Please replace tbl_countries, tbl_states from db_withdata.sql.

    - Please hit <site-url>/admin/patch-update/update-category-relations to update all parent to child level relations in case of updating db.

    - s3 bucket notes for bulk media:
        - Create a Lambda function.
        - Add trigers and upload zip file from  git-ignored-files/user-uploads/lib-files/fatbit-s3-zip-extractor.zip
        - Set permission and update Resource based on function created by you.
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

    - 2Checkout Payment Gateway:
        - To Test Sandbox Payment Refer This: https://knowledgecenter.2checkout.com/Documentation/09Test_ordering_system/01Test_payment_methods


    - ShipRocket : No sandbox environment available need to test live.