# Getting started: A skeleton application

1. Enable openssl.

    Go to php.ini and look for

    `;extension=php_openssl.dll`
    Remove ;

2. Download the skeleton.

    `composer create-project --stability="dev" zendframework/skeleton-application path/to/install`

3. Update the app and install Zend into the app.

    ```
    composer self-update
    composer install
    ```

4. Run the app

4.1 Using the Apache Web Server

4.2 Using the Built-in PHP CLI Server

    `php -S 0.0.0.0:8080 -t C:\...\public C:\...\public\index.php`

    Then access the app via,

    `http://localhost:8080`

    To test that your routing is working, navigate to `http://localhost:8080/1234`

## Ref:

    * http://framework.zend.com/manual/current/en/user-guide/skeleton-application.html
    * http://framework.zend.com/manual/2.0/en/ref/installation.html
