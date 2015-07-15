<script type="text/javascript">
    var _username = blocks.observable("");
    var _password = blocks.observable("");

    blocks.query({
        username: _username,
        password: _password
    });

    var login = function(e) {
        $.ajax({
            method: "POST",
            url: "user/login/",
            data: {
                username: _username(),
                password: _password()
            },

            success: function (payload) {
                if (payload.success == true) {
                    window.location = 'fox';
                } else {
                    $('.form-error').removeClass('hidden');
                }
            }
        });
    }

    var loginProxy = function(e) {
        if (e.which == 13) {
            $('.login-button').addClass('active');
            login();
        }
    }
</script>

<div class="login-form">
    <input class="login-input" type="text" placeholder="username" data-query="val(username).keyup(loginProxy)" />
    <input class="login-input" type="password" placeholder="password" data-query="val(password).keyup(loginProxy)" />
    <button class="login-button" data-query="click(login).on('touchend', login)">Login</button>
    <p class="form-error hidden">Login failed!</p>
</div>