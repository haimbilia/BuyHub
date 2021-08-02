
Multivendor - Released Version : RV-9.3.1
    => IOS/Android Buyer APP version : 2.0.1
    => System API version : 2.3

New Feature :     
    => 82892 : Easypost Shipping API Integration
    => Shopify sync module for SV seller
    => 85399 : QNB payment gateway 

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
   => Webp image support
    
Known Issues and Problems :
    => 82248 : Renaming existing DPO Payment Gateway to Paygate as it belongs to South Africa linked with Dpo Group.

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

