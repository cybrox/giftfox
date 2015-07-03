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
                Session::set('user', $username);
                Session::set('sess', $user->fetch()->token);

                View::render_json(array("success" => true));
            } else {
                View::render_json(array("success" => false));
            }
        }


        public function logout() {
            if (Session::has('sess')) {
                Session::drop('sess');
                Session::drop('user');
                Router::redirect('/');
            }
        }

    }

?>
