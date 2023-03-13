# Multivendor - Released Version : RV-10.0.0

> IOS/Android Buyer APP version : 2.0.1
> System API version : 2.3


## Enhancements:
- Bug-069557 Translate Product Specification

## Bug Fixes:
- Bug-069687 - Displaying invalid request when user tries to update currency language data in different language.
- Bug-069724 - Admin sub-user write permission for metatags and collection management
- Bug-069472 - Android, iOS >> Error occurs and the app stop working when the user deletes his account
- Bug-069442 - Android, iOS >> The Same review appears on all the shop's details pages.
- Bug-069587 - iOS >> User is not able to register again with the apple id if the user account is deleted once previously.
- Bug-069724 - Admin sub-user write permission for metatags and collection management.
- Bug-069726 - order with pickup in store when I am in English I can select the date of pickup but in French and Arabic impossible the pop up does not appear 
- Bug-069874 - Seller dashbaord Google Shoping feed authentication process - use Google branding guidelines 
- Bug-069778 - A success message appears and the product does not get added to the cart when the user clicks on the Reorder button on the order details page.
- Bug-069970 - On product detail page option vaules should be displated as per display order
- Bug-070009 - On deleting seller product, its options are not deleting.
- Bug-070036 - Admin top selling products should be based on completed orders.
- Bug-070110 - User dashboard area breadcrumb labels shall be manageable from admin end
- Bug-070125 - Testimonial image is not rendering incase of other language
- Bug-070173 - shopify data migration not worrking as tag lang table not exisit in current release
- Bug-070827 - Adding special price to batch products in google shopping feed.
- Bug-070881 - Easypost : Unable to validate plugin API keys
- Bug-070882 - Unable to save lang data of Tax category, Add Brand, Add Category from Admin > Add Product.
- Bug-071040 - Currency management form submittion not working at admin end
- Bug-071040 - Currency management form submittion not working at admin end.
- Bug-071057 - Product detail page - Add to cart min length should be remove
# RV-10.0.0.20221123

## Bug Fixes:
- Bug-068701 Invalid return url from Mollie payment gateway
- Bug-068725 Error occurs when the admin tries to add new FAQ caegory
- Bug-068864 Admin - Product catalog form Tag title called statically.
- Bug-069185 Option should be recreated with same name when a user deleted any existing option from the patform
- Bug-069336 Contact Shop email should not allow links.
- Bug-069346 Importing specific lang product specification deleting other lang specifications
# RV-10.0.0.20221109
## Bug Fixes:
- Bug-068381 Bool must be compatible with the function return type.

# RV-10.0.0.20221102

## Enhancements:
- Task-103261 Removed trailing zeros from the product listing page.
- Task-103082-2062129 Parent category listing page added display order updated on in descending order. 
- Task-103198 Added more product and category layout types for Home page collections.
- Task-103094 Sellers shall be able to update their bank details while using stripe connect.
- Task-103016 Included images URLs in the sitemap.
- Bug-068175 Product Id shall be removed from the import/export sheet based on ID configuration at import/export settings.
- Task-103028 Enhanced shipstation API and now shipping label shall be generated based on shipment handling by Seller/Admin.

## Bug Fixes:
- Bug-068127 Pickup address time slots selection validations.
 
# RV-10.0.0

## New Features:

### Shipping API Integrations (New) 
  - Ship Rocket (https://www.shiprocket.in/)
  - EasyPost (https://www.easypost.com/) 
  - Ship Engine 

### Data migration from Shopify to Yo!Kart
 - Admin Dashboard
     - Multivendor migration supported on the ‘Multi-Vendor Marketplace’ plugin by Webkul Software.(https://apps.shopify.com/multi-vendor-marketplace).
     - Admin can import Users, Sellers, Products, and Orders.
     - API token used to fetch data (Users, Sellers, Products, and Orders) from the Shopify store will have the Read-access permission.
     - API token shall be configured under the data migration plugin keys settings at Yo!Kart.
  
 - Seller Dashboard
     - Sellers shall be able to migrate only the products to their dashboard.
     - Data migration (Single vendor) is supported by Shopify open API’s.
     - The seller has to create a private app from their Shopify store for data sync.

### Admin shipped products listing page
- Admin can see the list of the Sellers who have shipped the Master Products (Admin Products) themselves so that Admin shall have the proper details of Sellers who chose themselves to ship the Master Products.
- On this listing Page, the Admin can view the Master products (Products added by Admin) for which shipping is done by the Seller or the Admin.
- In the list, the Admin can view the Shipping Profiles linked with the Master products.

### Preview module for the digital files/links
   - Now Sellers/Admin has an option to add a preview/sample for all the digital files (Product/Inventory level) where the Buyers can check a digital file sample like a small video or document for the Product Variant.
   - For eg. If the product is an ebook, the Admin/Seller can add the epilogue (summary) about the book for the user to read the quick content.
   - JW player has been integrated for audio file types preview.

### Adding files options for the delivered digital orders Whose orders were placed in the past. 
   - Sellers and Admin both have an option/feature i.e. “Attach with existing Orders” to make the latest digital updates available to the existing Buyers. If Sellers/Admin chose “Yes” for this option then such an update will be available to the older orders as well. If Admin/Seller does not want to do so then they can simply choose “NO” for this option.
   - For eg. If there is any E-book (Part-1) and Seller/Admin has a new version or updated content related to the same E-book (i.e. Part-2) then that specific Seller or Admin will have an option to make this latest version/update available to the Buyers who had already purchased that digital file in the past or they may keep this new version/update available only for the fresh Buyers.

### Ribbons
This module provides authority to the Admin to configure the Ribbons and a facility to the Admin and Sellers of Yo!kart Platform to link products with those Ribbons.

   - Can only be created by Admin (Important)
   - Will be available to all the sellers for an indefinite period of time unless the Admin deletes or Deactivates a specific Ribbon.
   - Linkage of a Ribbon at Shop/Product/Product Variant level is not time bound. (It means defining a time period for a Ribbon is not mandatory). But, Seller/Admin can set a specific duration for a Ribbon to be linked.  It means a particular Ribbon will be displayed depending upon the time period defined for the linked level (i.e. Product Variant/Seller Product/Shop level).
   - All the Ribbons added by Admin will be visible to all the Sellers and the Sellers have the ability to link those Ribbons at different     levels i.e. Shop or Product or Product variant level.
   - The Ribbons can be linked/attached at Product Variant or Product (If that Product is created by that Seller) or Shop level.
   - The linking ability (for these Ribbons) has been provided to both Admin and the Sellers
   - Each Ribbon created can be linked at either Seller Product (variant) or Product or Shop level.
   - One Ribbon can be linked to multiple Shops or Products or Product variants depending upon the Seller chosen to link the Ribbons.
   - Don’t get confused thinking Ribbons as Discount coupons. We have different properties and features associated with the Discount Coupons in the System. Though Ribbon could be intellectually utilized to complement the discounts in a visual manner.

### Badges
- Admin has an option to create Badges by adding an image where Badges are of two types Manual and Automatic.
- All the Badges configured by the system shall be listed under the Seller’s dashboard. 
- Manual badges can be associated manually at Shop/Product/Product variant level. These Shop/Product/Product variants will be shown with that respective Badge to stand out from other Shops/Products.
- Manual Badges can be configured with a date range in case they are promotional.
Seller shall have to place a request for linking a Manual badge at Shop/Product/Product Variant level If the Admin creates a badge which seeks approval from the Admin prior to its linkage by the Seller.
- Seller shall be able to link the Badges directly at the Shops/Products/Products Inventories level If the Admin has created a badge which does not require approval from the Admin.
- Automatic Badges created by Admin will get linked automatically at Shops/Products/Products Inventories level If they fulfill the condition defined by Admin during the creation of Automatic Badges. Conditions will be defined on the basis of parameters such as Average Ratings, Order cancellation age, Order completion age, Return/Refund acceptance rate, order cancellation rate.

### Rating and Reviews
- Added a new option for Admin to define Review parameters based upon the Category of product while creating the Category. (For ex- Fabric Quality for the Apparel)
- Segregated Seller (basically Shop) rating from Product rating. Sellers can be reviewed separately on the platform and not based on the average of all Product ratings.  
- Added option to rate shipping of the Seller. Buyer can independently write a review for Shipping services.

### Product Missing Info
- Introduced at Admin as well as Seller’s side under Product/Inventory Management module.
- This facilitates Admin/Seller to check the missing info related to a Product which prevents that Product to appear at the Front end.
- There are approx. 20 parameters which need to be filled out while creating a product and if any of these will be deleted later then this Product missing info feature helps to figure out the missing details quickly.


### Payment Gateways
- Mollie Payment Gateway
	- Added Mollie payment gateway under regular payment methods in settings.
	- Supported currencies: USD and EUR
	- Reference URL: https://www.mollie.com/en

- Payfast Payment Gateway
	- Added Payfast payment gateway under regular payment methods in settings.
	- Supported currencies: ZAR
	- Reference URL: https://www.payfast.co.za/

- YoCo Payment Gateway
	- Added YoCo payment gateway under regular payment methods in settings.
	- Supported currencies: ZAR
	- Reference URL: https://www.yoco.com/za/yoco-gateway/

- QNB payment gateway

	- Added QNB payment gateway under regular payment methods in settings.
	- Supported currencies JPY, RUB, GBP, USD, TRY and EUR
	- Reference URL: https://www.qnbfinansbank.com/

## Enhancements:

### Performance Updates
- Enhanced/updated cache mechanism of the System.
- Dashboard segregation for the users.
- GULP integration.
- WEBP image support.

### User Experience and Enhancements:
- Register & Login via OTP too. 
- Removed quick view & favorite button from the listing pages.
- UI/UX for Frontend and Admin dashboard.
- Help text section has been added at the Admin side for the majority of the Primary Pages explaining the steps and impacts associated with functionalities. It appears at the right side of a page at the Admin’s end.
- Sorting feature has been introduced at the listing pages to perform bi-directional sorting operations.
- Removed trailing zeros from the product listing page.

### Alert and Suggestion text bar (Admin)
- Alert and Suggestion/Recommendation bar has been introduced at Admin’s end.
- Alert text displays the necessary information to be kept in mind (as a warning) while filling/configuring the details related to that Module or submodule.
- Suggestion text displays the necessary information to be kept in mind (general recommendation) while dealing with filling/configuring the details related to a Module or submodule.
- Management of these have been provided under Settings>Pages Language Data.

### Tax Module and Enhancements
- Introduced the “from” fields while setting up Tax rules in order to handle various “From” and “To” workflows.

### Stripe connect and Enhancements
- Seller onboarding workflow has been updated to a Stripe hosted platform personalized page.
- Added payout delay settings under the Admin. 
- Updated the payment page to the stripe hosted solution.
- Removed the saved card functionality in Yo!Kart.
- Enhanced support for EU countries.

### Product Addition Enhancement 
- Single page flow (Every detail related to a Product can be filled/managed in one go and Admin/Seller does not have to go through multiple tabs)
- Language specific flow
- Product specific Options binding at Inventory level. It means if you have configured Product inventory and linked Options to that specific Product and saved it, You won’t be able to link more options for the same Product though you will be able to link more option values for the already linked Options.

### Inventory Form Enhancements 
- Updated the inventory addition workflow and made it look more logical. 
- Once a Seller configures inventory related details for a Product, System will automatically generate Product Variants listing depending upon the linked Options based permutation and combination for that Product.. But this will be the case when the Product options combinations count is below 20. If this count is greater than 20 then the User has to manually configure the Product inventories.
- The seller can add additional files while completing a digital order.

### Theme & Font Enhancements
- Included Google Font feature in the system facilitating the User experience.  
- Enhanced the color theme module with preview options. 

### Shipping Module Enhancements 
- Option for Sellers to configure his/her own shipping APIs at his/her Dashboard
- Option for Sellers to use manual rates with shipping API (Admin configured/Seller configured)
- Option for Sellers to use preferred API regardless of Admin’s side settings. 

### User Management Module Enhancements
- Admin now can create users in the Platform. 

### GDPR Enhancements
- Users can set their cookie preferences that can be used by the system based upon their consent.
- Guest user data is stored in cookies while registered user data is stored in the database. 
- Added management of functional, statistical, and personalization cookies. 

###Reports Enhancements 
-	Sales 
	- Sales over time
	- Products 
	- Product Variants
	- Shops
	- Customers 
- Users
	-  Buyers
	- Sellers Affiliates 
	- Advertisers 
- Financials 
	- Earnings
	- Profit by-products
	- Preferred payment methodsPayout
	- Transactions 
- Subscription
	- By plan
	- By seller 
-	Discount coupons

### Listing page Enhancements 
- Added maps listing view for Products containing the Shop details and Price details corresponding to the Products available in this Shop.
- Added map view for all Shops listing page.
- Option to increase the price of a product based on dates (Price Surge - Managed under the Admin>Promotions>Special Price Module).

### UI Related Enhancements
- Enhancements done for All Categories page UI.
- Seller’s Shop page. 
- Front End: Intensified the use of SVG sprite images (Vector - based) and grouped its management in a more easy way.
- Increase the number of layouts for Categories, Products, Banner, Brands etc.
- Updated the Product details for the Seller comparison section on the Product Detail Page.
- Introduced modal type pop up instead of Facebox on the front end.
- Added alpha color provision which is reflected on the Collection specific screens . 
- W3C validator enhancements (compatibility-wise).
- General improvements to workflows and user experience. 
- Removed redundant JS code. 
- Removed the unwanted CSS
- WCAG compatible.
- SCSS enhancements.
- Changed the sign up & sign in flow design wise.

### General Enhancements
- Country code picker/selector on all phone type fields has been added. 
- Added page in the admin console where a listing of products shipped by Admin are displayed.
- The added column on the order listing page to display who is fulfilling the order. 
- Added the Total savings label/field on the checkout. 
- Introduced the options to switch between ‘.’ & ‘,’ separator for currency.
- Added status for pick up orders.
- Enhanced Google Analytics with ecommerce events. (Advance level tracking is now implemented on orders).
- Admin has the authority to mark the Sellers as a Buyer.
- Admin can set the default location for the system. This will have default City, State and Country so that Products have a certain location by default.
- Created System log page at the Admin’s end.
- At Shop level pickup interval option given: Seller can add a pickup interval when the fulfillment method has Pickup.

## Bug Fixes:
- Instagram login not working after configuration.
- SMS trigger for buyer user type when order status is changed.
- Invoice issues when tax is collected by Admin and commission is inclusive of tax
- Product condition filter on listing page Search highlights for FAQ section
- Negative value on checkout when a subscription is downgraded and applying a coupon. 
- SKU mandatory setting error.
- Incorrect tax amount while generating slip when tax is zero.
- Listing of products when a seller has a pending subscription.
- AfterShip tracking links.
- PayPal payout API issues.
- Paytm payment method deprecated API
- Error received on marking an order as completed from admin when tax is queried from Alavara and order cancellation request is declined.
- Enhanced Google Feed API code 

## Known Issues and Problems :

    - Following is a list of known errors that don’t have a workaround. These issues will be fixed in the subsequent release. 
        - Change in minimum selling price when reconfigured by Admin
        - Safari and IE 11 do not support our CSS. More info can be found at https://developer.microsoft.com/en-us/microsoft-edge/platform/status/csslevel3attrfunction/
        - System does not support Zero decimal currency while checking out with stripe
