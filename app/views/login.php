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
            $('.submit-button').addClass('active');
            login();
        }
    }

    var register = function() {
        alert("Registration is not enabled yet.");
    }

    var infoPage = function() {
        window.location = 'info';
    }
</script>

<div class="login-form">
    <input class="login-input" type="text" placeholder="username" data-query="val(username).keyup(loginProxy)" />
    <input class="login-input" type="password" placeholder="password" data-query="val(password).keyup(loginProxy)" />
    <button class="submit-button" data-query="click(login).on('touchend', login)">Login</button>
    <p class="form-error hidden">Login failed!</p>

    <div class="row small-row">
        <div class="col-xs-6" style="padding-left: 0;">
            <button class="submit-button large-row" data-query="click(register).on('touchend', register)">Register</button>
        </div>
        <div class="col-xs-6" style="padding-right: 0;">
            <button class="submit-button large-row" data-query="click(infoPage).on('touchend', infoPage)">Info?</button>
        </div>
    </div>
</div>