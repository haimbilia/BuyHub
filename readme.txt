Multivendor - Released Version : RV-9.3.0
    => IOS/Android Buyer APP version : 2.0
    => System API version : 2.3

New Feature : 
    => 82248 : DPO Payment Gateway Integration
    => 82892 : Easypost Shipping API Integration
    =>  Shopify sync module for SV seller
    => 85399 : QNB payment gateway 

Updates:
    => Tax Module update
    => Admin can create users 
    => 83842 : Out of stock fixes 
    => Display Total Savings on Checkout page

Fixes:
    => 047746 - Get current location not working
    => 046939 - Add product tag giving error
    => 047306 - On shop collection while linking product remove icon not coming
    => 047899 - Default lang url issue when we enable language specific url
    => 048292 - Handled case insenstive for Admin url.
    => 047929 - When uploading file for 3rd party APIs Google webmaster and Bing, file name is not saved
    => 047992 - on product search page product coming with wrong option while search
    => 048123 - On Buyer Review Status Updated Notification wrong email template passed
    => 048408 - Admin - While creating a new category catcode not updated
    => 048194 - Unable to add alt tag for image with different options
    => 048604 - Fatal error in View Order API.
    => 048534 - Design issue of blank li tag adding in header if single language and single currency 
    => 048605 - getting error while creating shipping profile IN ADMIN
    => 048634 - Users are unable to see products in the favourite list if brand is not selected for the product
    => 048649 - whenever seller/admin edits the catalog/inventory then on updating it updates the url and changes it to id
    => 048457 - on seller credit page unable to edit label BL_Add_Wallet_Credits_[ Br]
    => 049052 - Category icon not displayed in Android and iOS mobile applications
    => 049066 - when admin product is available for pickup only then on buyer end it's listing- price 0 and getting problem on further step
    => 049147 - Digital product details page >> Available for shipping and pickup should be removed.
    => 049029 - when hamburger menu is selected for categories then on web- all categories are listing while on app only categories containing data are listing
    => 049317 - Mpesa Payment Gateway argument type Issue reported with live credentials
    => 049365 - When you order more than one item with only one allowing for COD, it completes the order as so with all the items, even the ones that don’t have COD option eligible 
    => 049364 - About Us image is not getting updated in cms due to cache.
    => 049390 - Shipping is listing twice on front end when cart products from multiple sellers and admin shipping only enabled.
    => 049439 - payment status is not getting updated through paypal
    => 049425 - Seller >> shop >> pickup address tab >> if we click on "pickup address " tab before adding shop details then blank page gets displayed
    => 049682 - unable to save seller inventory if quantity is zero
    => 049811 - While uploading user profile image profile link is wrong in response
    => 049777 - The - button (QUANTITY reducer) is not functional when we order a product through pickup
    => 049919 - labels missing in system
    => 049995 - If order is placed with digital product then unable to cancel the order even if it is allow from admin
    => 049981 - seller/admin> attribute tab> some UI issue while adding product
    => 050083 - On admin dashboard under statistics tab subscription earning data is wrong
    => 050137 - Apart from added components in combined tax,extra Duplicate entry is visible in tax details in ORDERS .(where we have the display of the tax components)
    => 049980 - issue with URL rewetting
    => 050289 - Order email table BG is not updating as per theme
    => 050045 - Signup >> when we enter capital letter in username then it shows some errors. 
    => 050397 - When seller click on "shipping package " then some error gets displayed
    => 050680 - Phone number should allow special symbols like + - (Contact Us and Footer - Site Phone)
    => 050654 - Wrong error message "Cart is empty" is displayed if we increase/decrease quantity of a product available only for pickup and then proceed.
    => 050831 - while adding option to catalog> it got stuck randomly
    => 050810 - issue with price filter when there is single item on seeking bar product disappears and can't reset again
    => 051065 - Fatal error: Uncaught Error: Class 'Libhelper' not found
    => 051068 - Google Shopping Feed > Unable to bind products
    => 050972 - while placing order with guest order error coming email sending
    => 051054 - If only one product is there then condition list not should not come in filter 
    => 051003 - banner image getting repeated as width increases
    => 051070 - admin> cms> import instructions> identifiers are not manageable
    => 051091 - on the category page, google is undefined error coming in browser console
    => 051329 - Tax api isue to fetch tax categories.
    => 051261 - issue with editor> long text is not accepting and some formatting issue
    => 051206 - Signup with otp >> verify your number >> enter wrong otp>> some error message should be there 
    => 051404 - On Contact us & Footer country code should be there with mobile number
    => 051407 - Advertiser account >> update credentials >> selected country code while signup should get displayed on update credentials instead of default country of system
    => 051474 - Invalid Currency & Language symbol displays in pdf
    => 051476 - getting error of duplicate entry on editing meta tags of shops in admin
    => 051573 - Product search is not working when we Activate Geo Location and shipping plugin.
    => 051615 - Sponsered shop doesn't refelect on homepage after being promoted from the advertiser side.
    => 051651 - Top - header menu are not aligned properly
    => 051594 - non verified user (*deleted) is proceeding for checkout and getting error - session expire
    => 051691 - on stripe connect unable to load form loading coming on seller end
    => 051694 - Loader image coming on product images even after it fully loaded
    => 051716 - Shipping by admin - seller is able to change order status
    => 051974 - Showing error while syncing by activating TaxZar plugin. 
    => 051960 - Google shoping feed settings not displaying
    => 051979 - Error Displayed : Undefined index status TaxZar Syncing    
    => 051967 - No category search results show up when parent/subcategory is searched which is not directly linked with the product. Only the category linked with a product shows up in search results    
    => 052015 - Order Id duplicacy issue when multiple user place order with same time frame.
    => 051973 - tax invoice UI got distorted
    => 051994 - Digital product can be linked to shipping profiles
    => 044068 - When an order is placed with Bank transfer as payment method, the Buyer doesn't receive any order placement email notification
    => 052142 - Same order showing multiple times when digital product having multiple links and multiple files
    => 052242 - social login icons changed from admin not reflecting on front end
    => 052110 - when otp is sent over email to buyer then in email> username is not populating
    => 052317	Request For Category- Seller dashboard when only one language activated
    => 052413 - Removed settings for recurring discount in case of subscription.
    => 052352 - getting double loader while making payment 
    => 052450 - Separate Tracking URL and Tracking Courier if Aftership enabled
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
    => 053985 - Stripe connect unable to debit site commission
    => 054023 - admin> settings> ppc management> language> sponsored shops/product headings are not making any sense as they are calling from collections
    => 054137 - Issue in product refund stats
    => 054183 - on admin order cancellation page roundoff error coming      
    => 054242 - paystack gateway not supporting ZAR currency
    => 054262 - some issue with collection 
    => 054255 - Unable to reach location if redirect from notification listing in admin.
    => 054265 - missing sms template on seller end
    => 053744 - when cancellation is approved and amount is not refunded then the amount is not coming under stats
    => 054447 - when product having multiple options then on detail page> options are not listing properly
    => 054613 - Error display on invoice pdf page
    => 054742 - wrong message is populating on button on tooltip


Develop

Fixes:
    => 052651 - on using comma as currency separator it's not impacting in text areas 
    => 052654 - Admin can create seller/buyer/advertiser/affiliate account from back-end - Not working
    => 052664 - admin> users> asterisk marked field shouldn't be mandatory for admin 
    => 052645 - wile adding product specifications> it's not accepting character after &
    => 052781 - When product not attached to brand then getting error while getting coupon list on cart page
    => 052869 - caching directory delete issue for some server
    => 053316 - Import export- product specification export issue in other languges
    => 052895 - when catalogue is approved from admin then no email is there for the same to seller
    => 052912 - front end> product editor> insert image option> upload button is not working in editor 
    => 052985 - when the subscription module is on then the catalog image upload /multiple inventory add limit not working properly
    => 053007 - Stripe Connect Already Have Account Issue 
    => 053057 - When search by keyword on home getting error
    => 053064 - While order product commission not calculated as per subscription
    => 053156 - admin> shipping> order level shipping text is not changing as per language /RTL
    => 053228 - When stripe connect is not configured, uploading banner images gives error 
    => 053197 - mPesa Pament gateway payment not confirmed
    => 053235 - buyer can't cancel the order when status is in process
    => 053365 -	While sharing shop page on whatsapp then meta image not displaying
    => 053276 - shipping is not changing on changing address during checkout
    => 053155 - Button labels are not changing as per language
    => 053430 - While sending SMTP email code crashed in between if unable to send email
    => 052088 - when product having multiple options then on quick view popup> dropdown is affecting popup
    => 053466 - There is no deducted discount amount shown in the printed invoice of admin and seller panel even after the buyer has applied a discount coupon.
    => 053465 - some issue with promotion
    => 053442 - "When a registered user shares any information throught contact us form: - The email is recieved by the site owner, but when the site owner tries to reply the from email i,e user email is not getting fetched. " 
    => 053621 -	commission is not getting charged when tax is collected by seller and shipping is non refundable and whole order is returned and shipping remains with seller
    => 053673  - Allow seller to cancel COD orders.
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
    => 054557 - admin> catalog> categories> count is mismatching
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
    => 055069 - on product detail page undefined index: theprice notice coming
    => 055077 - when cookies policy are turned off from admin then recently viewed items are not listing on detail page of product
    => 055104 - seller dashboard> data migration tab is not highlighting on accessing
    => 055093 - while changing seller approval request if admin declines request without message then on front end it's listing heading- reason for cancellation which is blank
    => 055092 - when cookies are not allowed from admin still then user have option for the same in account
    => 055090 - when truncate request is raised by user then in admin> it's listing- view purpose which is not there on user end

New Features:
    => Admin shipped products listing page
    => 053451 - missing country code plugin with phone number field
    => 053462 - Instagram login not working after configuration, gives error
    => 053757 - when order status is changed then sms are not triggering to buyer for the same
    => 053612 - when tax is collected by admin and commission incl tax then invoice is having some issues
    => 053908 - when admin creates category collection (category layout 1) more than once with same category then in second collection> products are not populating
    => 053978 - Forget password label language issue in admin
    => 054137 - Issue in product refund stats
    => 054183 - on admin order cancellation page roundoff error coming
    => 054242 - paystack gateway not supporting ZAR currency    
    => 054279 - warranty needs to be optional when product is digital         
    => 054644 - Admin > Shipping Company User > Wrong validation message is showing.   
    => 054689 - 404 error page - issue with few produc urls when subscription in enabled
    => 054718 - Categories added are not listing in admin.
    => 054728 -	Aftership order status should be automatically marked delivered.
    => 054698 - on clicking of delete button in shipping profile there needs to be confirmation popup
    => 055010 - SMTP handling - In case of Godaddy email hosting.

Enhancements :
   => At shop level  pickup interval option given
   => Tracking order with Google Analytics ecommerce 
   => W3c validator.
   => Performance optimization
   => Upgrades in GEO location module to configure default location.  
   => Price surge based on special price. 
   => Admin Reports.
    
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


=======================================

Released Version:

Tasks:
    task-84719 Preview module for digital files
    task-85619 Adding files when digital order is delivered

=======================================

Released Version:

bugs:
    #054201	while adding catalog for digital item> only option to add attachment at inventory level is either Yes or No
    #054208 - while uploading files> it's taking too much time to save data and meanwhile loader disappears- seems like process has been aborted
    #054204	while adding catalog> when add attachment is set to No then > download tab is listing for that inventory setup too
    #054206	there needs to be some message on inventory level when attachments are not allowed to add at inventory
    #054212	while adding inventory> when we add link and url is long then UI is not proper
    #055154	digital items> files linked with specific language are listing all on front end in preview
