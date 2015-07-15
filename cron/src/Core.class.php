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


    public static function sendMail($target, $wins) {
      $message = file_get_contents('./static/mail.html');
      $message = str_replace("::::", implode("<br />", $wins), $message);
      $headers = 'MIME-Version: 1.0' . "\r\n" .
          'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
          'From: cybrox@cybrox.eu' . "\r\n";

      if (mail($target, "GiftFox Win!", $message, $headers)) {
        echo("[L] Sent win notification to (".$target.")");
      } else {
        die("[E] Failed sending win notification");
      }
    }

  }

?>
