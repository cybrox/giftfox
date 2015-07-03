<?php


  /**
   * This is the sloth-php router.
   * You may want to define all routes that your app will use in here.
   * The route will determine what controller and what action to call
   * when the server needs to render the page.
   *
   * For example, if we map GET '/' to home#index, sloth-php will call
   * the method 'index' in the 'Home' controller (app/controllers.Home.php)
   * when somebody accesses the path '/' via http get.
   *
   * You can use the following notations:
   * Router::route("GET", "/", "home#index");
   * Router::route("GET", "/", "home#index", function(){}, function(){});
   * Router::route_before("GET", "/", function(){ echo 'I will be run before rendering home#index'; });
   * Router::route_after("GET", "/", function(){ echo 'I will be run after rendering home#index'; });
   *
   */


  Router::route('GET', '/', 'home#login');
  Router::route('GET', '/fox', 'home#fox');
  Router::route('GET', '/key', 'home#key');

  Router::route_before('GET', '/', function(){ if (Session::has('sess')) Router::redirect('./fox'); });
  Router::route_before('GET', '/fox', function(){ if (!Session::has('sess')) Router::redirect('./'); });
  Router::route_before('GET', '/key', function(){ if (!Session::has('sess')) Router::redirect('./'); });


  Router::route('POST', '/user/login', 'user#login');
  Router::route('POST', '/user/logout', 'user#logout');
  Router::route('POST', '/user/updatekey', 'user#newkey');


  Router::route('GET', '/data/wishlist', 'data#wishlist');
  Router::route('GET', '/data/giveaway', 'data#giveaway');
  Router::route('GET', '/data/giveaways', 'data#giveaways');
?>