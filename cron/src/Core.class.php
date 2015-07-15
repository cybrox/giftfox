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


    public static function joinGiveaways($user, $page) {
      $security_limit = 20;

      while (--$security_limit > 0) {

        // Ignore promoted giveaways on wishlist page
        if (strstr($page->link, 'wishlist')) {
          $page->data = explode("pinned-giveaways__button", $page->data)[1];
        }

        // Find giveaways on page
        $giveaways = $page->findGiveaways();

        // Loop over giveaways
        foreach ($giveaways as $index => $giveaway) {
          if ($user->pnts >= $giveaway['pnts'] && $user->lvls >= $giveaway['lvls']) {
            if (self::joinGiveaway($user, $giveaway)) {
              $user->pnts = $user->pnts - $giveaway['pnts'];
            }
          }
        }

        // Check user points
        if ($user->pnts < 15) return $user;

        // Go to next page
        $page = new Page($page->followPagination(), $user->sess);
        if ($page == NULL) return $user;
      }

      return $user;
    }


    public static function joinGiveaway($user, $giveaway) {
      $page = new Page($giveaway['link'], $user->sess);
      set_time_limit(300);
      sleep(rand(3, 8));

      if (preg_match('/sidebar__entry-insert\"><i class=\"fa fa-plus-circle\"><\/i> Enter Giveaway/si', $page->data) == 1) {
        preg_match('/<input type=\"hidden\" name=\"xsrf_token\" value=\"([A-z0-9_-]+)\" \/>/si', $data, $xsrf);

        self::joinRequest($giveaway['link'], $user->sess, $xsrf[1]);
        return true;
      }

      return false;
    }


    public static function joinRequest($link, $sess, $xsrf) {
      $headers = array();
      $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
      $headers[] = 'Accept-Encoding: gzip, deflate';
      $headers[] = 'Accept-Language: de,en;q=0.8';
      $headers[] = 'Cache-Control: max-age=0';
      $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.81 Safari/537.36';
      $headers[] = 'Connection: keep-alive';
      $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
      $headers[] = 'X-Requested-With: XMLHttpRequest';
      $headers[] = 'Referer: http://www.steamgifts.com'.$link;
      $headers[] = 'Origin: http://www.steamgifts.com';
      $headers[] = 'Cookie: PHPSESSID=2bb806680fab36879eeb2a182c599ba1edd660059177640faa49528334d4f5345eeb82093ed356d4a0172e85aa7aac8a740b01a57d03b587d25d9606c4d8b447;';

      $fields = array(
        'xsrf_token' => $xsrf,
        'do' => 'entry_insert',
        'code' => explode('/', $link)[1]
      );

      foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
      rtrim($fields_string, '&');

      $c = curl_init('http://www.steamgifts.com/ajax.php');

      curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($c, CURLOPT_VERBOSE, TRUE);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($c, CURLOPT_POST, count($fields));
      curl_setopt($c, CURLOPT_POSTFIELDS, $fields_string);
      session_write_close();
      $data = curl_exec ($c);

      if (strlen($data < 3)) echo "[E] Join request failed (".$link.")\r\n";

      curl_close ($c);
      session_start();

      echo "[L] Joined game (".$link.")\r\n";
    }


    public static function getFakeHeaders() {
      $headers = array();
      $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
      // $headers[] = 'Accept-Encoding: gzip, deflate';
      $headers[] = 'Accept-Language: de,en;q=0.8';
      $headers[] = 'Cache-Control: max-age=0';
      $headers[] = 'Host: www.steamgifts.com';
      $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.81 Safari/537.36';

      return $headers;
    }

  }

?>