<?php
/**
 * fnsql.php
 * Makes PHP's PDO a little easier.
 * @author Eugene
 * http://fncombo.me
 * @fncombo
 */

class fnsql {

    private $connection = null;
    private $defaultFetchMode = PDO::FETCH_ASSOC;
    private $credentials = array();

    /**
     * Constructor.
     * @constructor
     * @param $host {string} Database server.
     * @param $user {string} Username.
     * @param $password {string} Password.
     * @param $database {string} Database.
     * @param $type {string} Database type.
     */
    public function __construct($host, $user, $password, $database, $type = 'mysql') {

        $vars = array('host', 'user', 'password', 'database', 'type');

        foreach ($vars as $var) {
            $this->credentials[$var] = $$var;
        };

    }

    /**
     * Connects to a MySQL database if no connection is yet established.
     */
    public function connect() {

        if ($this->connection) {
            return;
        };

        try {
            $this->connection = new PDO(
                $this->credentials['type'] . ":host=" . $this->credentials['host'] . ";dbname=" . $this->credentials['database'],
                $this->credentials['user'],
                $this->credentials['password'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $e) {
            exit($e->getMessage());
        };

    }

    /**
     * Executes a query and returns the result if it was a SELECT.
     * @param $queryString {string} Query string.
     * @param $parameters {string|variable|array} Parameters to bind to the string, if any.
     *      If there is only 1 parameter bound, a string or a variable can be used for $parameters.
     *      If there are 2 or more parameters bound, they must be put into an array in the order bound.
     * @param $fetchMode {PDO::FETCH_*} PDO fetch mode constant.
     */
    public function query($queryString, $parameters = null, $fetchMode = false) {

        $this->connect();

        try {
            $query = $this->connection->prepare($queryString);
        } catch (PDOException $e) {
            exit($e->getMessage());
        };

        if ($parameters && !is_array($parameters)) {
            $parameters = array($parameters);
        };

        try {
            $execute = $query->execute($parameters);
        } catch (PDOException $e) {
            exit($e->getMessage());
        };

        if (!$fetchMode) {
            $fetchMode = $this->defaultFetchMode;
        };

        if (strpos($queryString, 'SELECT') !== false) {
            return $query->fetchAll($fetchMode);
        } else {
            return $execute ? true : false;
        };

    }

    /**
     * Changes the default fetch mode.
     * @param $fetchMode {PDO::FETCH_*} PDO fetch mode constant.
     * Ref: http://www.php.net/manual/en/pdostatement.fetch.php
     */
    public function setDefaultFetchMode($fetchMode) {

        $this->defaultFetchMode = $fetchMode;

    }

};

?>
