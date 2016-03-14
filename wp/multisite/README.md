# Activating Multisite

1. Install WordPress in the normal way. Download WordPress and use the ‘famous 5 minute install’ to install it on your server or local machine.
2. Open your wp-config.php file which you’ll find in the folder where you installed WordPress. Find the line that reads:

    /* That's all, stop editing! Happy blogging. */

3. Immediately above that line, create a new line that reads as follows:

    define( 'WP_ALLOW_MULTISITE', true );

4. In the WordPress admin, go to Tools > Network Setup. You’ll be prompted to choose subdomains or subdirectories for your installation: choose the one that works for your network.

5. Edit the title of your network and email address of the network administrator when prompted, or leave them as they are.

6. Click the Install button.

7. You will be taken to the Network Install screen, then copy the codes from the screen to wp-config.php and .htaccess:

    wp-config.php

    define('MULTISITE', true);
    define('SUBDOMAIN_INSTALL', false);
    define('DOMAIN_CURRENT_SITE', '127.0.0.1');
    define('PATH_CURRENT_SITE', '/projects/multi/');
    define('SITE_ID_CURRENT_SITE', 1);
    define('BLOG_ID_CURRENT_SITE', 1);

    .htaccess

    RewriteEngine On
    RewriteBase /projects/multi/
    RewriteRule ^index\.php$ - [L]

    # add a trailing slash to /wp-admin
    RewriteRule ^([_0-9a-zA-Z-]+/)?wp-admin$ $1wp-admin/ [R=301,L]

    RewriteCond %{REQUEST_FILENAME} -f [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^ - [L]
    RewriteRule ^([_0-9a-zA-Z-]+/)?(wp-(content|admin|includes).*) $2 [L]
    RewriteRule ^([_0-9a-zA-Z-]+/)?(.*\.php)$ $2 [L]
    RewriteRule . index.php [L]

8. WordPress Multisite will now be installed. You’ll need to log in again.

## Refs:

1. https://premium.wpmudev.org/blog/ultimate-guide-multisite/

# Migrating a Site Into Multisite Manually

1. Backing Up First.
2. Creating a New Site in the Network.
3. Finding the ID of Your New Site in the Multisite Network.

    Find this by going to Network Admin > Sites and then selecting the Edit option for the site you've just created. The URL WordPress takes you to will give you the site's ID. The URL should be in the form http://mynetwork.com/wp-admin/network/site-info.php?id=XX on your browser address bar.

    XX is the ID of your site, and will be the name of the folder containing its files, as well as the prefix for its database table names.

4. Uploading Files to the New Site.

    * Plugins:

    Upload them to wp-content/plugins from the backup you took of your old site.

    * Themes:

    Copy them from your backup to wp-content/themes directory of your network.

    * Uploads:

    Copy them from your backup to wp-content/uploads/sites/xx

5. Exporting Your Old Site's Tables.

    WordPress Multisite uses separate database tables for each site in the network. Instead of storing the posts for your site in wp_posts, for example, it stores it in wp_XX_posts, where XX is your site's ID.

    However it doesn't use separate tables for user data—this is stored in one wp_users and wp_usermeta table for the whole network.

    This means that you'll need to copy all of the tables from your old site across except the two user tables, and you'll need to change the names of the files you're copying. Unfortunately you'll have to create the users manually in the new site using the WordPress admin screens.

    In PhpMyAdmin for your old site, click on the Structure tab. Then select all of the tables except wp_users and wp_usermeta.

    Click on the With selected: dropdown box, select Export and then Go. This will download a sql file to your machine with the contents of those tables.

6. Adding Users

    Before you start to import the tables you've just downloaded, set up the same users in your new site as you had in your old one. Note that they will have different IDs in the Multisite network's database than they did in the old site, which may cause some inaccuracies with assigning posts to authors. You'll need to correct this at the end after importing the database - by re-assigning the posts in bulk to this newly created author.

    But if you plan to change posts author to the multisite default author, you can skip this step.

7. Editing the Database Tables.

    Make a copy of the sql file that's been downloaded to your machine and give it a name that tells you what it is (for example by adding copy to its name). Open it in a code editor.

    Change all instances of the site's domain in the Multisite network to its new Multisite domain. For example if your site was at http://mysite.com, change it to http://network.com/mysite. If your network uses subdomains you'll need to change it to http://mysite.network.com. Save your file.

    The database tables in your new Multisite site will need prefixes for the site ID. In your sql file, replace all instances of wp_ with wp_XX_ , where XX is your site ID.

    NOTES:

    1. replace http://127.0.0.1/projects/oldsite with http://127.0.0.1/projects/network/oldsite (localhost).
    2. replace oldsite/wp-content/uploads/ with oldsite/wp-content/uploads/sites/XX/, where XX is your site ID.
    3. replace wp_ with wp_3_ (**important: not do replace _wp_ with wp_3_**. Images will be missing if you do.)
    4. custom widget might be missing after migrating, so check and add it back if it does.

    Now save the sql file.

8. Importing Tables to the New Database.

    Before you upload the tables from your old site, you'll need to delete the duplicate ones which WordPress has added to your new site.

    In phpMyAdmin, drop any tables which are prefixed with wp_XX_, where XX is your site ID. These will include the following, but may also include tables created by plugins:

    wp_XX_commentmeta
    wp_XX_comments
    wp_XX_links
    wp_XX_options
    wp_XX_postmeta
    wp_XX_posts
    wp_XX_terms
    wp_XX_term_relationships
    wp_XX_term_taxonomy

    Select those tables (plus any wp_XX_ tables created by plugins), click the With selected: dropdown menu, select Drop and then Yes.

## Refs:

1. http://code.tutsplus.com/tutorials/moving-wordpress-moving-a-site-into-a-multisite-network--cms-22773
2. https://codex.wordpress.org/Migrating_Multiple_Blogs_into_WordPress_3.0_Multisite

# Risks/ Impact

1. Time consuming.
2. Migrated sites might break, eg: images not displaying.
3. Database will become bigger and bigger, wp-plugins and wp-themes folders will be full of plugins and themes.
4. Difficult to maintain for admin users and developers, eg: they might delete themes and plugins of other sites by mistake; they might have no idea what to do with the unused and redundant plugins and themes.
5. Difficult to migrate to another server in the future due to its large size of database and wp-plugins and wp-themes folders.
6. Security issues: chances of getting hacked by the plugin creator is higher when you have many plugins that might come with hidden marketing purposes.

# Backup Plans/ Plan B

1. Keep all mini sites as they are. Use the directory structure below and then move these sites into it:

    www/
       network.com/
       network.com.minisite1/
       network.com.minisite2/
       network.com.minisite3/

    network.com/ is the main network.com website where the rest are the mini sites.

2. Log into your domain name manager and point network.com to www/network.com/ and do the same for the mini sites, such as http://network.com/mini1/ points to www/network.com.minisite1/. Or better, use sub domains, such as making http://mini1.network.com points to www/network.com.minisite1/.
