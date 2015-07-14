<?php

  // request required files
  require_once('./src/Core.class.php');
  require_once('./src/User.class.php');
  require_once('./src/Page.class.php');

  require_once('../app/config.php');


  // prepare global script variables
  $user_list = array();
  $user_self = NULL;
  $user_page = NULL;


  // connect to mysql database
  Core::databaseConnect($__sphpconfig['database']);


  // get all users from the database
  $user_list = Core::databaseQueryGet("SELECT * FROM `gf_user` ORDER BY RAND()");
  $user_list = array_map(function($x){ return new User($x); }, $user_list);


  // get random user to execute task for
  $fix_time = rand(21600, 43200);

  foreach ($user_list as $user) {
    if ($user->last <= $fix_time) {
      $user_self = $user;
      break;
    }
  }

  var_dump($user_self);


?>
