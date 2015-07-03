<?php

    class UserController extends BaseController {
    
        public function login() {
            $username = (Parameters::has('username')) ? Parameters::get('username') : '';
            $password = (Parameters::has('password')) ? Parameters::get('password') : '';

            $user = User::where(array(
                array("username", "=", $username),
                array("password", "=", $password)
            ));

            if ($user->count() == 1) {
                $usermeta = $user->fetch();

                Session::set('user', $username);
                Session::set('sess', $usermeta->token);
                Session::set('phps', $usermeta->sessionid);

                View::render_json(array("success" => true));
            } else {
                View::render_json(array("success" => false));
            }
        }


        public function logout() {
            if (Session::has('sess')) {
                Session::drop('sess');
                Session::drop('user');

                View::render_json(array("success" => true));
            } else {
                View::render_json(array("success" => false));
            }
        }


        public function newkey() {
            if (Session::has('sess')) {
                $sessionid = (Parameters::has('sesskey')) ? Parameters::get('sesskey') : '';
                $user = User::where(array(array("token", "=", Session::get('sess'))));

                $user->update(array(
                    "sessionid" => $sessionid
                ));

                Session::set('phps', $sessionid);
                View::render_json(array("success" => true));
            } else {
                View::render_json(array("success" => false));
            }
        }

    }

?>
