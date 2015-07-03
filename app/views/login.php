<script type="text/javascript">
    var _username = blocks.observable("");
    var _password = blocks.observable("");

    blocks.query({
        username: _username,
        password: _password
    });

    var login = function(e) {
        if (e.which == 13) {
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
                        $('.login-error').removeClass('hidden');
                    }
                }
            });
        }
    }
</script>

<div class="login-form">
    <input class="login-input" type="text" placeholder="username" data-query="val(username).keyup(login)" />
    <input class="login-input" type="password" placeholder="password" data-query="val(password).keyup(login)" />
    <p class="login-error hidden">Login failed!</p>
</div>