<?php
/* 
 * Handle PDO connection, preparing SQL, fetching and executing data.
 */

/* 
 * NOTE: PDO always quotes params that aren't null, even when they're integers. 
 * It means that when passing an array of params to execute for a PDO statement, 
 * all values are treated as PDO::PARAM_STR.
 *
 */
namespace Barium\Adapter;

use PDO;

class PdoAdapter
{
    /*
     * Set props.
     */
    protected $PDO = null;
    protected $dsn, $username, $password;

    /*
     * Set the class contructor.
     * @reference: http://us.php.net/manual/en/language.oop5.magic.php//object.sleep
     */
    public function __construct($dsn, $username, $password)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;

        /*
        @ original/ deprecated: 07.06.2012
        try 
        {
            // MySQL with PDO_MYSQL  
            // To deal with special characters and Chinese character, add charset=UTF-8 in $dsn and array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8").
            // @source: http://stackoverflow.com/questions/10209777/php-pdo-with-special-characters
            $this->PDO = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            //$this->PDO = new PDO($dsn, $username, $password);
            //$this->PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
        }
        catch (PDOException $error) 
        {
            // call the getError function
            $this->getError($error);
        }
        */
    }
    
    /*
     * Make the pdo connection.
     * @return object $PDO
     */
    public function connect()
    {
        try
        {
            // MySQL with PDO_MYSQL  
            // To deal with special characters and Chinese character, add charset=UTF-8 in $dsn and array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8").
            // @source: http://stackoverflow.com/questions/10209777/php-pdo-with-special-characters
            $this->PDO = new PDO($this->dsn, $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            
            // Unset props.
            unset($this->dsn);
            unset($this->username);
            unset($this->password);

        } 
        catch (PDOException $error) 
        {
            // Call the getError function
            $this->getError($error);
        }
    }
    
    /*
     * Return the pdo object for custom use.
     * @return object $PDO
     * @usage: 
     * $pdo = $PdoAdapter->fetchPdo();

        $stmt = $pdo->prepare('
            SELECT * FROM article
            WHERE title = :title
            AND url = :url
            ');

        $params = array(':title' => 'Home', ':url' => "home");
        $stmt->execute($params);
        $result = $stmt->fetch();
     */
    public function fetchPdo()
    {
        return $this->PDO;
    }

    /*
     * Get the number of rows in a result as a value string.
     * @param string $query
     * @param array $params
     * @return number
     */
    public function countRows($query, $params = [])
    {
        try
        {
            // Create a prepared statement
            $stmt = $this->PDO->prepare($query);

            // If $params is not an array, let's make it array with one value of former $params
            if (!is_array($params)) $params = array($params);

            // Execute the query
            $stmt->execute($params);

            // Return the result
            return $stmt->rowCount();

        } 
        catch (PDOException $error) 
        {
            // Call the getError function
            $this->getError($error);
        }
    }

    /*
     * Fetch a single row of result as an array (=  one dimensional array).
     * @param string $query
     * @param array $params
     * @return object/ array
     */
    public function fetchRow($query, $params = [])
    {
        try
        {
            // Prepare query.
            $stmt = $this->PDO->prepare($query);

            // If $params is not an array, let's make it array with one value of former $params
            if (!is_array($params)) $params = array($params);

            // The line
            //$params = is_array($params) ? $params : array($params);
            // is simply checking if the $params variable is an array, and if so, it creates an array with the original $params value as its only element, and assigns the array to $params.

            // This would allow you to provide a single variable to the query method, or an array of variables if the query has multiple placeholders.

            // The reason it doesn't use bindParam is because the values are being passed to the execute() method. With PDO you have multiple methods available for binding data to placeholders:

            // BindParam
            // BindValue
            // execute($values)

            // The big advantage for the bindParam method is if you are looping over an array of data, you can call bindParam once, to bind the placeholder to a specific variable name (even if that variable isn't defined yet) and it will get the current value of the specified variable each time the statement is executed.

            // Execute the query
            $stmt->execute($params);

            // Return the result
            return $stmt->fetch();

        } 
        catch (PDOException $error) 
        {
            // Call the getError function.
            $this->getError($error);
        }

        /*
        or, 

        catch (Exception $error)
        {
            // Echo the error or Re-throw it to catch it higher up where you have more
            // information on where it occurred in your program.
            // e.g echo 'Error: ' . $error->getMessage(); 

            throw new Exception(
                __METHOD__ . 'Exception Raised for sql: ' . var_export($sql, true) .
                ' Params: ' . var_export($params, true) .
                ' Error_Info: ' . var_export($this->errorInfo(), true), 
                0, 
                $error);
        }
        */
    }

    /*
     * Fetch a multiple rows of result as a nested array (= multi-dimensional array).
     * @param string $query
     * @param array $params
     * @return object/ array
     */
    public function fetchRows($query, $params = [])
    {
        try
        {
            // Prepare query.
            $stmt = $this->PDO->prepare($query);

            // If $params is not an array, let's make it array with one value of former $params
            if (!is_array($params)) $params = array($params);

            // When passing an array of params to execute for a PDO statement, all values are traitymethoded as PDO::PARAM_STR.
            // use bindParam to tell PDO that you're using INTs
            // wrap the bindParam function in a foreach that scan your parameters array
            // it's $key + 1 because arrays in PHP are zero-indexed, but bindParam wants the 1st parameter to be 1, not 0 (and so on).
            /*
            foreach($params as $key => $param)
            {
              if(is_int($param))
                    {
                            $stmt->bindParam($key + 1, $param, PDO::PARAM_INT);
                    }
              else
                    {
                            $stmt->bindParam($key + 1, $param, PDO::PARAM_STR);
                    }
            }

            // Execute the query
            $stmt->execute();
            */
            
            // Execute the query
            $stmt->execute($params);

            // Return the result
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } 
        catch (PDOException $error) 
        {
            // Call the getError function
            $this->getError($error);
        }
    }

    /*
     * Return the current row of a result set as an object.
     * @param string $query
     * @param array $params
     * @return object
     */
    public function fetchRowObject($query, $params = [])
    {
        try
        {
            // Prepare query.
            $stmt = $this->PDO->prepare($query);

            // if $params is not an array, let's make it array with one value of former $params
            if (!is_array($params)) $params = array($params);

            // Execute the query
            $stmt->execute($params);

            // Return the result
            return $stmt->fetchObject();
            
            // Or:
            //return $stmt->fetch(PDO::FETCH_OBJ);

        } 
        catch (PDOException $error) 
        {
            // Call the getError function
            $this->getError($error);
        }
    }

    /*
     * Insert or update data.
     * @param string $query
     * @param array $params
     * @return boolean - true.
     */
    public function executeSQL($query, $params = [])
    {
        try
        {
            $stmt = $this->PDO->prepare($query);
            $params = is_array($params) ? $params : array($params);
            $stmt->execute($params);
            
            if($stmt->rowCount()>0)
            {
                return true;
            }
            else
            {
                return '0 rows affected';
            }

        } 
        catch (PDOException $error) 
        {
            // Call the getError function
            $this->getError($error);
        }
    }
    
    /*
     * Get the last insert id.
     * @return number
     */
    public function fetchLastInsertId()
    {
        return $this->PDO->lastInsertId();
    }

    /*
     * Display error.
     * @return string
     */
    public function getError($error)
    {
        $this->PDO = null;
        die($error->getMessage());
    }

    /*
     * With __sleep, you return an array of properties you want to serialize. the point is to be able to exclude properties that are not serializable. eg: your connection property.
     * @reference: http://stackoverflow.com/questions/10936636/php-pdo-cannot-serialize-or-unserialize-pdo-instances/
     * @return array
     */
    public function __sleep()
    {
        return array('dsn', 'username', 'password');
    }

    /*
     * The intended use of __wakeup() is to reestablish any database connections that may have been lost during serialization and perform other reinitialization tasks.
     * @reference: http://stackoverflow.com/questions/10936636/php-pdo-cannot-serialize-or-unserialize-pdo-instances/
     */
    public function __wakeup()
    {
        $this->connect();
        //$this->PDO =  new PDO($this->dsn, $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        //$this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /*
     * Close the database connection when object is destroyed.
     */
    public function __destruct()
    {
        // Set the handler to NULL closes the connection propperly
        $this->PDO = null;
    }
    
    /*
     * Connect() gets called when the object is called as a function. 
     * instead of $pdo->connect();
     * do this, 
     * $pdo();
     */
    public function __invoke() 
    {
        $this->connect();
    }
}

