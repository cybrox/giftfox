<?php

    class HomeController extends BaseController {

        public function login() {
            View::render('login');
        }


        public function fox() {
            $c = curl_init('http://www.steamgifts.com/giveaways/entered');

            curl_setopt($c, CURLOPT_VERBOSE, TRUE);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_COOKIE, 'PHPSESSID='.Session::get('phps'));

            session_write_close();
            $page = curl_exec ($c);

            curl_close ($c);
            session_start();

            if (strlen($page) == 0) {
                Router::redirect('./key');
            } else {
                preg_match("/a href\=\"\/user\/([A-z0-9_]+)\" class\=\"/si", $page, $username);
                preg_match("/<div class=\"nav__avatar-inner-wrap\" style\=\"background-image:url\(https\:\/\/steamcdn\-a\.akamaihd\.net\/steamcommunity\/public\/images\/avatars\/([A-z0-9]+\/[A-z0-9]+)_medium.jpg\);\">/si", $page, $useravtr);
                preg_match("/<a class=\"nav__button nav__button--is-dropdown\" href=\"\/account\">Account \(<span class=\"nav__points\">([0-9]+)<\/span>P \/ <span title=\"[0-9_\.]+\">Level ([0-9]{1,2})<\/span>\)/si", $page, $userdata);
                preg_match_all("/<a class\=\"table__column__heading\" href\=\"\/giveaway\/[A-z0-9]+\/[A-z0-9-]+\">[^<]+<\/a>/si", $page, $wishlist);

                $won = preg_match("/Giveaways Won\" class\=\"nav__button\" href=\"\/giveaways\/won\"><i class=\"fa fa-trophy\"><\/i><div class=\"nav__notification\">([0-9]+)<\/div><\/a>/si", $page, $giftswon);

                $user = User::where(array(
                    array("token", "=", Session::get('sess'))
                ));

                if ($won != 0) {
                    $user->update(array(
                        "numwon" => intval($giftswon[1])
                    ));
                    Registry::set('numwon', intval($giftswon[1]));
                } else {
                    Registry::set('numwon', 0);
                }

                $usermeta = $user->fetch();
                Registry::set('lastjoin', Session::get('sess'));
                Session::set('last', $usermeta->lastjoin);
                Session::set('s_wi', ($usermeta->autowish == 1));
                Session::set('s_ra', ($usermeta->autorand == 1));

                Registry::set('s_wi', Session::get('s_wi'));
                Registry::set('s_ra', Session::get('s_ra'));
                Registry::set('lastjoin', $usermeta->lastjoin);

                Registry::set('username', $username[1]);
                Registry::set('useravtr', $useravtr[1]);
                Registry::set('userpnts', $userdata[1]);
                Registry::set('userlvls', $userdata[2]);
                Registry::set('userjoin', str_replace('href="', 'href="http://steamgifts.com', implode(',&nbsp;&nbsp;', $wishlist[0])));

                View::render('fox');
            }
        }


        public function key() {
            View::render('key');
        }

    }

?>
