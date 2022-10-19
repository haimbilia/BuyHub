## About Yo!Kart

Yo!Kart is a business-centric online marketplace software designed - for entrepreneurs to start their multi-vendor store quickly, for existing retailers to accelerate their digital transformation, and for thriving businesses to lead the digital commerce landscape. We strive to uphold the highest standards of integrity, quality, and commitment.

## System Requirements
You will require the following server specifications for setting up the Yokart scripts:

- Environment : LAMP (Linux, Apache, MySQL, and PHP)

   - Supported Operating Systems: 
       - Linux x86
       - x86-64
   - Supported Web Servers: 
       - Apache 2.4.x
       - Nginx
   - PHP Compatibility: 7.4
   - Server Hosting :
       - Ability to run scheduled jobs.
       - Ability to override options in .htaccess files
   - Required Extensions:
       - GD with Free Font support
       - Zlib with zip support
       - JSON
       - DOM
       - cURL function should be enabled
       - Mbstring should be enabled
       - Iconv function should be enabled
       - Fileinfo function should be enabled
       - Calendar function should be enabled
       - Ioncube Loader
       - PHP Composer should be installed
       - Memory_limit 64M or more (Some pages with advanced feature may need upto 128M)
   - My SQL:
       - 5.7 or greater
       - sql_mode - strict_trans_tables should be disabled.

## Documentation & Updates

- [Documentation](https://www.yo-kart.com/resource-center.html) Find All The Resources At One Place To Help You Setup Your eCommerce Marketplace Successfully.
- [Server Requirements](https://www.yo-kart.com/yokart-server-requirements.html) Server Requirements.

## Installation Instructions

1. **Prerequisite**

	- You are able to aceess the server using **SSH**.
	- You have installed **Apache** , **MySql** and **PHP** on linux server.
	- You have installed ioncube loader compatible to **Fatbit library v2.3**

1. **Clone Yo!Kart**

    Install git and clone Clone Yo!Kart to your root directory.

		sudo apt install git
		git --version
		cd ./path/to/your/rootdir
		git clone git@github.com:AblySoft268/yokart-marketplace.git .
		
    **Note:** OR if you have script files, Upload script files to the root directory and continue.

2. **Copy setup-files files**

    Copy `conf` `user-uploads` `public` `mbs-errors.log` and everything from `setup-files` to root directory.

		cp -r setup-files/* .

3. **Install Fatbit Library**

    Download and install Fatbit library and unzip to library directory.

		wget http://fatlib.4livedemo.com/download/v2.3/core.zip
		unzip core.zip -d library
		rm core.zip

4. **Install Dependencies**

    It will update versions of packages to be installed with your system.

		composer update

5. **Import Database**

    We have `sample.sql` (with default data) and `blank.sql`(without default data) database in `database` directory. Database can be imported as per requirement.

		mysql -u mysqlUsername -p mysqlDatabase < database/sample.sql
		mysqlPassword

6. **Connect Database**

    Configure MySQL database connection settings in `public/settings.php`

		nano public/settings.php
    `settings.php` file will look like below

		<?php
		define('CONF_WEBROOT_FRONTEND', '/');
		define('CONF_WEBROOT_DASHBOARD', '/dashboard/');
		define('CONF_WEBROOT_BACKEND', '/admin/');
		define('CONF_DB_SERVER', 'localhost');
		define('CONF_DB_USER', 'mysqlUsername');
		define('CONF_DB_PASS', 'mysqlPassword');
		define('CONF_DB_NAME', 'mysqlDatabase');
    Save and Exit (Ctrl+x and Shift+y)

7. **Grant Permissions**

		chmod -R 777 user-uploads
		chmod -R 777 public/cache
		chmod 777 mbs-errors.log
		chmod 777 public/robots.txt

8. **Upload License**
		Upload provided license file "license.txt" to ‘/library/’ in the scripts
		Or
		nano /library/license.txt
    Paste license key and Save and Exit (Ctrl+x and Shift+y)

9. **Setup Cron Job**

		crontab -e
		*/2 * * * * /usr/bin/curl  -s https://yourdomain.com/cron > /dev/null 2>&1
    Save and Exit (Ctrl+x and Shift+y)
    **Note:** The command may vary depending upon the products and their version.

10. **Create Procedure**

    - Login to admin dashboard 
	- Open url https://yourdomain.com/admin/admin-users/createProcedures to create procedures.

11. **Custom Configuration**

    Update `{root}/conf/conf-common.php` as per your requirements
		
		define('CONF_DEVELOPMENT_MODE', false);
		define('CONF_USE_FAT_CACHE', true);
		define('ALLOW_EMAILS', true);

## Notes:

- Stripe Connect Installation :
     - Required to configure callback url as "{domain-name}/public/index.php?url=stripe-connect/callback" inside stripe's web master's account under https://dashboard.stripe.com/settings/applications under "Integration" -> "Redirects"
       -  Setup webhook Stripe Connect  https://dashboard.stripe.com/test/webhooks . 
        - Add Webhook url under "Endpoints receiving events from your account" 
        - "Webhook Detail" > Url as "{domain-name}/stripe-connect-pay/payment-status" bind events "payment_intent.payment_failed", "payment_intent.succeeded".

- S3 bucket notes for bulk media:
	- Create a Lambda function.
	-	 Add trigers and upload zip file from  git-ignored-files/user-uploads/lib-files/fatbit-s3-zip-extractor.zip.
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

## Migration  Instructions

- Upload the latest script files into your root directory and make sure that the changes updated on the setup-files directory files shall be updated with your root script files.
- Execute the updates.sql file which is placed under /path/to/your/rootdir/database direcotry.
- Login to admin account and Open url https://yourdomain.com/admin/patch-update/update-shops-avg-rating to update reviews and ratings.
- Labels table shall be updated from the sample.sql file which is placed under /path/to/your/rootdir/database/ directory 
- user-uploads directory shall be remain same.