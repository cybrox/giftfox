<?php

    class HomeController extends BaseController {

        public function login() {
            View::render('login');
        }


        public function fox() {
            $c = curl_init('http://www.steamgifts.com/giveaways/search?type=wishlist');

            curl_setopt($c, CURLOPT_VERBOSE, TRUE);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_COOKIE, 'PHPSESSID='.Session::get('phps'));

            session_write_close();
            $page = curl_exec ($c);

            curl_close ($c);
            session_start();

            if (strlen($page) == 0) {
                Router::redirect('./key');
            }
        }


        public function key() {
            View::render('key');
        }

    }

?>
