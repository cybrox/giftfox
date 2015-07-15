<?php

  class User extends Core {
  
    public $id;                                                           /* the uuid of the user */
    public $name;                                          /* the username of the respective user */
    public $mail;                                                      /* the users email address */
    public $sess;                                           /* the remote session id of this user */
    public $last;                                        /* the last login timestamp of this user */
    public $wish;                               /* setting to automatically join wishlist entries */
    public $rand;                                 /* setting to automatically join random entries */
    public $wins;                                                     /* array with won giveaways */

    public $lvls;                                                           /* scanned user level */
    public $pnts;                                        /* scanned number of points the user has */


    /**
     * Create a new instance of the user class
     *
     * @param array $user_data - An array with user data
     */
    public function __construct($user_data) {
      $this->id = $user_data['id'];
      $this->name = $user_data['username'];
      $this->last = $user_data['lastjoin'];
      $this->sess = $user_data['sessionid'];
      $this->mail = $user_data['email'];

      $this->wish = $user_data['autowish'] == 1;
      $this->rand = $user_data['autorand'] == 1;

      $this->wins = explode(";;", $user_data['wins']);
    }


    /**
     * Update the last join time of a user
     *
     * @param $time - The new last join time
     */
    public function updateLastJoin($time) {
      parent::$db->query("UPDATE `gf_user` SET `lastjoin` = '".$time."' WHERE `id` = '".$this->id."'");
    }


    /**
     * Update the number of gifts won
     *
     * @param $wins - The new number of wins
     */
    public function updateWins($wins) {
      $serialized = implode(';;', $wins);
      parent::$db->query("UPDATE `gf_user` SET `wins` = '".$serialized."' WHERE `id` = '".$this->id."'");
    }

  }

?>