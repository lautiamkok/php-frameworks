# PHPUNIT TESTING

1. Create two files at your root directory.

    * composer.json

    * phpunit.xml

2. navigate to your project,

    `cd path-to-your-project`

3. fetch the PHPUnit with Composer,

    `composer update`

4. files being downloaded and placed into a new vendors/ folder within the root of your application. This logic can be changed, using the following configuration option:

```
{
    "require": {
     },
    "config" : {
        "vendor-dir" : "packages"
    }
}
```


# References:

http://jes.st/2011/phpunit-bootstrap-and-autoloading-classes/

http://code.tutsplus.com/tutorials/easy-package-management-with-composer--net-25530

http://stackoverflow.com/questions/25219764/phpunit-autoload-classes-within-tests

