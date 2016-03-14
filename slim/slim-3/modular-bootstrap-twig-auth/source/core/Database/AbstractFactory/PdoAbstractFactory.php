<?php
namespace Spectre\Database\AbstractFactory;

use PDO;
use Spectre\Database\AbstractDatabase;
use Spectre\Strategy\AdapterStrategy;
use Spectre\Strategy\QueryStrategy;

class PdoAbstractFactory extends AbstractDatabase implements AdapterStrategy
{
    protected $PDO = null;
    protected $dsn = 'mysql:host=localhost;dbname=Spectre', $username = 'root', $password = 'tklau';

    /*
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

    /*
     * Fetch a multiple rows of result as a nested array (= multi-dimensional array).
     * @param string $query
     * @param array $params
     * @return array
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

    /*
     * Insert, or update, or delete data.
     * @param string $query
     * @param array $params
     * @return boolean
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

    /*
     * Get the last insert id.
     * @return number
     */
    public function fetchLastInsertId()
    {
        return $this->PDO->lastInsertId();
    }

    /*
     * Truncate a table.
     * @return null
     */
    public function truncateTable($table)
    {
        $sql = "TRUNCATE TABLE $table";
        $stmt = $this->PDO->prepare($sql);
        $stmt->execute();
    }
}
