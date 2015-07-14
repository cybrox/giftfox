<?php

  class Core {

    protected static $db;


    public static function databaseConnect($dbconfig) {
      self::$db = new mysqli(
        $dbconfig['hostname'],
        $dbconfig['username'],
        $dbconfig['password'],
        $dbconfig['database']
      );

      if (self::$db->connect_errno > 0) {
        die("[E] Connection to database failed (".self::$db->connection_error.")");
      }
    }


    public static function databaseQueryGet($sql) {
      if (!$res = self::$db->query($sql)) {
        die("[E] Fetching data from database failed (".self::$db->error.")");
      }

      $data = array();
      while ($row = $res->fetch_assoc()) {
        array_push($data, $row);
      }

      return $data;
    }


    public static function databaseQuerySet($sql) {
      if (!$res = self::$db->query($sql)) {
        die("[E] Writing data to database failed (".self::$db->error.")");
      }
    }

  }

?>
