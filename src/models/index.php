<?php
require_once ANCOMTHOI_REST_API_PATH . '/errors/CustomError.php';
require_once ANCOMTHOI_REST_API_PATH . '/errors/code.php';
class Models
{
    public $table_name;
    public $schema;
    public function __construct($schema, $table_name)
    {
        if ($schema !== null && $table_name !== null) {
            $this->schema = $schema;
            $this->table_name = $table_name;
            global $wpdb;
            if ($wpdb->get_var("SHOW tables like '" . $table_name . "'") != $table_name) {
                $table_query = "CREATE TABLE " . "`$table_name` " . $schema . " ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($table_query);
            }
        }
    }
    public function getName()
    {
        return $this->table_name;
    }
    public function find()
    {
        global $wpdb;
        $table_name = $this->table_name;
        $data = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM `$table_name`"
            )
        );
        return $data;
    }
    public function findLeftJoin($selects = [], $conditions = [], $wheres = [])
    {
        global $wpdb;
        $table_name = $this->table_name;
        $leftJoin = " ";
        $selectQuery = "SELECT ";
        $field = "";
        $whereQuery = " WHERE ";
        if ($selects) {
            foreach ($selects as $select) {
                $selectQuery = $selectQuery . $table_name . "." . $select . " , ";
            }
        }
        foreach ($conditions as $condition) {
            foreach ($condition['select'] as $select) {
                $selectQuery = $selectQuery . $condition['tableName'] . "." . $select . " , ";
            };
            foreach ($condition['field'] as $key => $value) {
                $field = $field . $table_name . "." . $key . " = " . $condition['tableName'] . "." . $value;
            };
            $leftJoin = $leftJoin . "LEFT JOIN " . $condition['tableName'] . " ON " . $field;
        }
        if ($wheres) {
            foreach ($wheres as $key => $value) {
                $whereQuery = $whereQuery . $key . "=" . "'" . $value . "'";
            }
        } else {
            $whereQuery = "";
        }
        $selectQuery = substr($selectQuery, 0, -2);
        $query = $selectQuery . "FROM " . $table_name . $leftJoin . $whereQuery;
        $data = $wpdb->get_results(
            $wpdb->prepare($query)
        );
        return $data;
    }
    public function findById($id)
    {
        global $wpdb;
        $table_name = $this->table_name;
        $data = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM `$table_name` WHERE id=$id"
            )
        );
        if (!$data) {
            return null;
        }
        return $data[0];
    }
    public function findOne($condition = array())
    {
        global $wpdb;
        $table_name = $this->table_name;
        $head = "SELECT *";
        $body = " FROM `$table_name` WHERE";
        foreach ($condition as $key => $value) {
            if ($key !== 'null') {
                $body = $body . " $key = '$value' AND";
            } else {
                foreach ($value as $exclude)
                    $head = $head . ", NULL AS $exclude";
            }
        }
        $str = $head . $body;
        $query = substr($str, 0, -3);
        $data = $wpdb->get_results(
            $wpdb->prepare($query)
        );
        if ($data) {
            return $data[0];
        }
        return null;
    }
    public function findAll($condition = array())
    {
        global $wpdb;
        $table_name = $this->table_name;
        $head = "SELECT *";
        $body = " FROM `$table_name` WHERE";
        foreach ($condition as $key => $value) {
            if ($key !== 'null') {
                $body = $body . " `$key` = '$value' AND";
            } else {
                foreach ($value as $exclude)
                    $head = $head . ", NULL AS $exclude";
            }
        }
        $str = $head . $body;
        $query = substr($str, 0, -3);
        $data = $wpdb->get_results(
            $wpdb->prepare($query)
        );
        return $data;
    }
    public function create($data = [])
    {
        global $wpdb;
        $table_name = $this->table_name;
        $keys = "`created_at`";
        $values = "current_timestamp()";
        foreach ($data as $key => $value) {
            $keys = $keys . ",`$key`";
            $values = $values . ',' . "'$value'";
        }
        $query = "INSERT INTO `$table_name` (" . $keys . ") VALUES (" . $values . ") ";
        $wpdb->get_results(
            $wpdb->prepare("$query")
        );
        $userId = $wpdb->insert_id;
        $res = $this->findById($userId);
        return $res;
    }
    public function findByIdAndUpdate($userId, $data = [])
    {
        global $wpdb;
        $table_name = $this->table_name;
        $set = "SET";
        foreach ($data as $key => $value) {
            if (is_string($value) && $key !== "id") {
                $set = $set . " $key" . "= '$value',";
            }
        }
        $set = substr($set, 0, -1);
        $query = "UPDATE $table_name $set WHERE id = $userId";
        $wpdb->get_results(
            $wpdb->prepare($query)
        );
        $user = $this->findById($userId);
        return $user;
    }
    public function findAndUpdate($condition, $data = [])
    {
        global $wpdb;
        $table_name = $this->table_name;
        $set = "SET";
        $where = "WHERE ";
        foreach ($condition as $key => $value) {
            $where = $where . " `$key` = '$value' AND";
        }
        $where = substr($where, 0, -3);
        foreach ($data as $key => $value) {
            $set = $set . " $key" . "= '$value',";
        }
        $set = substr($set, 0, -1);
        $query = "UPDATE $table_name $set $where";
        $wpdb->get_results(
            $wpdb->prepare($query)
        );
    }
    public function findAndDelete($condition)
    {
        global $wpdb;
        $codes = new Codes();
        $table_name = $this->table_name;
        if (is_array($condition) && $condition !== null) {
            foreach ($condition as $key => $value) {
                $query = "DELETE FROM $table_name WHERE `$key` = $value";
                $wpdb->get_results(
                    $wpdb->prepare($query)
                );
            }
        } else {
            $query = "DELETE FROM $table_name WHERE id='$condition'";
            $wpdb->get_results(
                $wpdb->prepare($query)
            );
        }
        return;
    }
    public function createDatabase()
    {
        $log_directory = dirname(__FILE__);
        $results_array = array();

        if (is_dir($log_directory)) {
            if ($handle = opendir($log_directory)) {
                while (($file = readdir($handle)) !== FALSE) {
                    $results_array[] = $file;
                }
                closedir($handle);
            }
        }
        foreach ($results_array as $value) {
            $fileName = Str_replace(".php", "", $value);
            if ($fileName !== "index") {
                $obj = new stdClass();
                $file = ANCOMTHOI_REST_API_PATH . "/models/" . $fileName . ".php";
                if (file_exists($file)) {
                    require_once $file;
                    $routerName = $fileName . '_Model';
                    $obj = new $routerName();
                    $obj->Schema();
                }
            }
        }
    }
}
