<?php

  define("BASEURL", "http://www.steamgifts.com/");

  class Page extends Core {
    
    public $link;
    public $sess;
    public $data;


    /**
     * Create a new instance of class page
     *
     * @param string $link - The target link of the site
     * @param string $sess - The user's session string
     */
    public function __construct($link, $sess) {
      $this->sess = $sess;

      if (strlen($link) == 0) return NULL;
      return $this->request($link);
    }


    /**
     * Request a page from the server
     *
     * @param string $url - The url part on the server
     * @return $this - Instance of page class
     */
    private function request($url) {
      $this->link = BASEURL.$url;

      $c = curl_init($this->link);

      curl_setopt($c, CURLOPT_HTTPHEADER, parent::getFakeHeaders());
      curl_setopt($c, CURLOPT_VERBOSE, TRUE);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($c, CURLOPT_COOKIE, 'PHPSESSID='.$this->sess);
      session_write_close();
      $this->data = curl_exec ($c);

      curl_close ($c);
      session_start();
      
      echo "[L] Requested page (".$this->link.")\r\n";
      return $this->data;
    }


    /**
     * Get a users points from the requested data string
     *
     * @return $points - The numerical value of points
     */
    public function getUserPoints() {
      preg_match('/Account \(<span class\=\"nav__points\"\>([0-9]{1,3})<\/span>P/si', $this->data, $match);

      return intval($match[1]);
    }


    /**
     * Get a users level from the requested data string
     *
     * @return $level - The numerical value of the level
     */
    public function getUserLevel() {
      preg_match('/P \/ <span title=\"[0-9\.]+\">Level ([0-9]{1,2})<\/span>\)<\/a>/si', $this->data, $match);

      return intval($match[1]);
    }


    /**
     * Get the array of won gifts for the user
     *
     * @return $wins - The array of gifts won
     */
    public function getUserWins() {
      preg_match_all('/table__column__heading\" href=\"\/giveaway\/[A-z0-9]+\/[A-z0-9\-]+\">([^<]+)<\/a>/si', $this->data, $match);

      return $match[1];
    }


    /**
     * Follow a page pagination
     *
     * @return $link - The new page link
     */
    public function followPagination() {
      preg_match('/href=\"([^"]+)\"><span>Next<\/span> <i class=\"fa fa-angle-right/si', $this->data, $match);
      return (count($match) != 0) ? $match[1] : '';
    }


    /**
     * Find all giveaways on the page
     *
     * @return $giveaways - The array of giveaways
     */
    public function findGiveaways() {
        $giveaways = array();
        $dataparts = explode("giveaway__summary", $this->data);
        foreach ($dataparts as $giveaway) {
          preg_match('/giveaway__heading__name\" href=\"(\/giveaway\/[A-z0-9]+\/[0-9A-z\-_]+)\">([^<]+)<\/a><span class=\"giveaway__heading__thin\">\(([0-9]+)P\)<\/span>/si', $giveaway, $metadata);
          preg_match('/title=\"Contributor Level\">Level ([0-9]+)\+/si', $giveaway, $triggers);

          if (count($metadata) > 0) {
            $level = (count($triggers) > 0) ? intval($triggers[1]) : 0;
            array_push($giveaways, array(
              "link" => substr($metadata[1], 1),
              "name" => $metadata[2],
              "pnts" => $metadata[3],
              "lvls" => $level 
            ));
          }
        }

        return $giveaways;
    }
  }

?>