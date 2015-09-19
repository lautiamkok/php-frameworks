<?php
/*
 * Common methods.
 */
namespace Barium\Helper;

// droplet - a small drop of liquid
// snippet - a small and often interesting piece of news, information, or conversation
// driblet - a thin stream or small drop of liquid
// flake - a small, thin piece of something, especially if it has come from a surface covered with a layer of something
trait CommonHelpers
{
    /*
     * render html include file.
     * @return string $contents
     */
    public function getIncludeContents($filename, $parameter_1, $parameter_2){

        if (is_file($filename)) {

            //ob_start - Turn on output buffering. It lets you put output into a buffer instead of sending it directly to the client.
            //In computing, a buffer is a region of memory used to temporarily hold data while it is being moved from one place to another.
            ob_start();

            //include the file.
            include $filename;

            //Return the contents of the output buffer.
            $contents = ob_get_contents();

            //Clean (erase) the output buffer and turn off output buffering.
            ob_end_clean();

            //Return the result.
            return $contents;
        }
        return 'error';
    }

    /*
     * buffer html include file.
     * @return string $contents
     */
    public function bufferContent($file = null, $item = [], $authentication = [], $data = []) {

        if (is_file(WEBSITE_DOCROOT.$file)) {

            //ob_start - Turn on output buffering. It lets you put output into a buffer instead of sending it directly to the client.
            //In computing, a buffer is a region of memory used to temporarily hold data while it is being moved from one place to another.
            ob_start();

            //include the file.
            include WEBSITE_DOCROOT . $file;

            //Return the contents of the output buffer.
            $contents = ob_get_contents();

            //Clean (erase) the output buffer and turn off output buffering.
            ob_end_clean();

            //Return the result.
            return $contents;
        }
        return 'error';
    }

    /*
     * Generate an unique code.
     * @return string $code
     *
     */
    public function createUniqueCode() {
        // Prepare query..
        $sql = "
            SELECT*
            FROM person as p
            WHERE p.passcode = ?
        ";

        // Count the result.
        //$total_item = $this->PdoAdapter->countRows($sql, array($string));

        do {
            // Keep looping to generate the code if it is found positive number in the 'while()'.
            $passcode = preg_replace("/[^a-zA-Z0-9]+/", "", generate_unique());
        } while ($this->PdoAdapter->countRows($sql, array($passcode)) > 0);

        if($passcode) return $passcode;
            else return false;
    }

    /*
     * get either a Gravatar URL or complete image tag for a specified email address.
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public function gravatar($options = []) {

        // Set default.
        $defaults = array(
            "email"		=>	null, 
            "s"			=>	50, 
            "d"			=>	"mm", 
            "r"			=>	"g", 
            "img"		=>	false, 
            "atts"		=>	array(// any config item is allowed here when the key is an empty array..
         )
     );

        // Call internal method to process the array.
        $array = self::arrayMergeValues($defaults, $options);

        // Convert array to object.
        $property = self::arrayToObject($array);

        //print_r($property);

        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($property->email)));
        $url .= "?s=$property->s&d=$property->d&r=$property->r";
        if ($property->img) {

            $url = '<img src="' . $url . '"';
            foreach ($property->atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    /*
     * Get the IP address.
     */
    public function getIp() 
    {
        $IP = '';

        if (getenv('HTTP_CLIENT_IP')) 
        {
            $IP =getenv('HTTP_CLIENT_IP');
        } 
        elseif (getenv('HTTP_X_FORWARDED_FOR')) 
        {
            $IP =getenv('HTTP_X_FORWARDED_FOR');
        } 
        elseif (getenv('HTTP_X_FORWARDED')) 
        {
            $IP =getenv('HTTP_X_FORWARDED');
        } 
        elseif (getenv('HTTP_FORWARDED_FOR')) 
        {
            $IP =getenv('HTTP_FORWARDED_FOR');
        } 
        elseif (getenv('HTTP_FORWARDED')) 
        {
            $IP = getenv('HTTP_FORWARDED');
        } 
        else 
        {
            $IP = $_SERVER['REMOTE_ADDR'];
        }

        return $IP;
    }

    /*
     * Get the geo location from an IP address.
     */
    public function getGeoLocation() 
    {
        return file_get_contents('http://freegeoip.net/json/'.$this->getIp());
        //$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json")); 
        //print_r($details); // -> "US"
    }

    /*
     * Get the geo location from an IP address.
     */
    public function getComputerName() 
    {
        return gethostbyaddr($this->getIp());
    }

    /*
     * Get the controller from a location and then instantiate the class.
     */
    public function getController($request, $options = []) 
    {
        // Set vars.
        $defaults = array(
            "mode"          =>  "core", 
            "path"          =>  "/controller/", 
            "database"      =>  false
     );

        // Call internal method to process the array.
        $config = self::arrayMergeValues($defaults, $options);

        // Convert array to object.
        $props = self::arrayToObject($config);
        //print_r($props);

        //
        if($props->database === true) {
            $PdoAdapter = new \Barium\Adapter\PdoAdapter(DSN, DB_USER, DB_PASS);
            $PdoAdapter->connect(); 
        }

        // Replace any backslash to '/'.
        $pathnameReplace = str_replace('\\', '/', $request);
        //print_r($pathnameReplace);

        // Explode the folder path.
        $array = explode("/", $pathnameReplace);

        // Get the class name.
        $className = end($array);
        //var_dump($className);

        // When you declare a class more than once in a page, you get 'PHP Fatal error: Cannot redeclare class', 
        // You can fix it by either wrapping that class with an if statement, or you can put it into it's own file and include_once(), instead of include()
        if(class_exists($className) != true)
        {
           // Include the class. 
           include WEBSITE_DOCROOT . $props->mode.$props->path.$request.'.php';
        }
        else
        {
            // Include the class. 
            include_once WEBSITE_DOCROOT.$props->mode.$props->path.$request.'.php';
        }

        // Instantiate the class.
        if($props->database === true) 
        {
            return New $className($PdoAdapter);
        } 
        else 
        {
            return New $className();
        }
    }

    /*
     * Get the model from a location and then instantiate the class.
     */
    public function getModel($request, $options = []) 
    {
        // Set vars.
        $defaults = array(
            "mode"          =>  "core", 
            "path"          =>  "/model/", 
            "database"    =>  false
     );

        // Call internal method to process the array.
        $config = self::arrayMergeValues($defaults, $options);

        // Convert array to object.
        $props = self::arrayToObject($config);
        //print_r($props);

        //
        if($props->database === true) {
            $PdoAdapter = new \Barium\Adapter\PdoAdapter(DSN, DB_USER, DB_PASS);
            $PdoAdapter->connect(); 
        }

        // Replace any backslash to '/'.
        $pathnameReplace = str_replace('\\', '/', $request);
        //print_r($pathnameReplace);

        // Explode the folder path.
        $array = explode("/", $pathnameReplace);

        // Get the class name.
        $className = end($array);
        //var_dump($className);

        // When you declare a class more than once in a page, you get 'PHP Fatal error: Cannot redeclare class', 
        // You can fix it by either wrapping that class with an if statement, or you can put it into it's own file and include_once(), instead of include()
        if(class_exists($className) != true)
        {
           // Include the class. 
           include WEBSITE_DOCROOT . $props->mode.$props->path.$request.'.php';
        }
        else
        {
            // Include the class. 
            include_once WEBSITE_DOCROOT.$props->mode.$props->path.$request.'.php';
        }

        // Instantiate the class.
        if($props->database === true) 
        {
            return New $className($PdoAdapter);
        } 
        else 
        {
            return New $className();
        }
    }

    /*
     * Get the helper from a location and then instantiate the class.
     */
    public function getHelper($request, $options = []) 
    {
        // Set vars.
        $defaults = array(
            "mode"          =>  "core", 
            "path"          =>  "/helper/", 
            "database"    =>  false
     );

        // Call internal method to process the array.
        $config = self::arrayMergeValues($defaults, $options);

        // Convert array to object.
        $props = self::arrayToObject($config);
        //print_r($props);

        //
        if($props->database === true) {
            $PdoAdapter = new \Barium\Adapter\PdoAdapter(DSN, DB_USER, DB_PASS);
            $PdoAdapter->connect(); 
        }

        // Replace any backslash to '/'.
        $pathnameReplace = str_replace('\\', '/', $request);
        //print_r($pathnameReplace);

        // Explode the folder path.
        $array = explode("/", $pathnameReplace);

        // Get the class name.
        $className = end($array);
        //var_dump($className);

        // When you declare a class more than once in a page, you get 'PHP Fatal error: Cannot redeclare class', 
        // You can fix it by either wrapping that class with an if statement, or you can put it into it's own file and include_once(), instead of include()
        if(class_exists($className) != true)
        {
           // Include the class. 
           include WEBSITE_DOCROOT . $props->mode.$props->path.$request.'.php';
        }
        else
        {
            // Include the class. 
            include_once WEBSITE_DOCROOT.$props->mode.$props->path.$request.'.php';
        }

        // Instantiate the class.
        if($props->database === true) 
        {
            return New $className($PdoAdapter);
        } 
        else 
        {
            return New $className();
        }
    }

    /*
     * Convert the data in csv file into an array.
     */
    function csvToArray($filename = null)
    {
        if(!file_exists($filename) || !is_readable($filename))
            return false;

        $data = [];
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            $data = array_map('str_getcsv', file($filename));
            fclose($handle);
        }
        return $data;
    }
}
