<?php
namespace Spectre\Database\Driver\Pdo;

use PDO;
use Spectre\Database\AbstractDatabase;
use Spectre\Strategy\AdapterStrategy;
use Spectre\Strategy\QueryStrategy;

class PdoDatabase extends AbstractDatabase implements AdapterStrategy
{
    /**
     * [$PDO description]
     * @var null
     */
    protected $PDO = null;

    /**
     * [$dsn description]
     * @var [type]
     */
    protected $dsn, $username, $password;

    /**
     * [__construct description]
     * @param [type] $databaseConfig [description]
     */
    public function __construct($databaseConfig)
    {
        $this->dsn = $databaseConfig['dsn'];
        $this->username = $databaseConfig['username'];
        $this->password = $databaseConfig['password'];
    }

    /**
     * Make the pdo connection.
     * @return object $PDO
     */
    public function connect()
    {
        try {
            // MySQL with PDO_MYSQL
            // To deal with special characters and Chinese character, add charset=UTF-8 in $dsn and array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8").
            // @source: http://stackoverflow.com/questions/10209777/php-pdo-with-special-characters
            $this->PDO = new PDO($this->dsn, $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Unset props.
            unset($this->dsn);
            unset($this->username);
            unset($this->password);
        } catch (PDOException $error) {
            // Call the getError function
            $this->getError($error);
        }
    }

    /**
     * Fetch a single row of result as an array (=  one dimensional array).
     * @param  QueryStrategy $query [description]
     * @return [array]               [description]
     */
    public function fetch(QueryStrategy $query)
    {
        try {
            // Prepare query.
            $stmt = $this->PDO->prepare($query->getQuery());

            // Execute the query
            $stmt->execute($query->getParams());

            // Return the result
            return $stmt->fetch();
        } catch (PDOException $error) {
            // Call the getError function.
            $this->getError($error);
        }
    }

    /**
     * Fetch a multiple rows of result as a nested array (= multi-dimensional array).
     * @param  QueryStrategy $query [description]
     * @return [array]               [description]
     */
    public function fetchAll(QueryStrategy $query)
    {
        try {
            // Prepare query.
            $stmt = $this->PDO->prepare($query->getQuery());

            // Execute the query
            $stmt->execute($query->getParams());

            // Return the result
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            // Call the getError function
            $this->getError($error);
        }
    }

    /**
     * Insert, or update, or delete data.
     * @param  QueryStrategy $query [description]
     * @return [boolean]               [description]
     */
    public function execute(QueryStrategy $query)
    {
        try {
            $stmt = $this->PDO->prepare($query->getQuery());
            $stmt->execute($query->getParams());

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $error) {
            // Call the getError function
            $this->getError($error);
        }
    }

    /**
     * Get the last insert id.
     * @return [number] [description]
     */
    public function fetchLastInsertId()
    {
        return $this->PDO->lastInsertId();
    }

   /**
     * Truncate a table.
     * @param  [string] $table [description]
     * @return [null]        [description]
     */
    public function truncateTable($table)
    {
        $sql = "TRUNCATE TABLE $table";
        $stmt = $this->PDO->prepare($sql);
        $stmt->execute();
    }
}
