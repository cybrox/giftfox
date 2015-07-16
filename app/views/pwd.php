<script type="text/javascript">
    var _password = blocks.observable("");
    var _passrept = blocks.observable("");

    blocks.query({
        password: _password,
        passrept: _passrept
    });

    var savepass = function(e) {
        if (_password() !== _passrept()) {
            $('.form-error2').removeClass('hidden');
            return;
        } else {
            $('.form-error2').addClass('hidden');
            $('.submit-button').addClass('active');
        }

        $.ajax({
            method: "POST",
            url: "user/updatepass/",
            data: {
                password: _password(),
            },

            success: function (payload) {
                if (payload.success == true) {
                    window.location = 'fox';
                } else {
                    $('.form-error1').removeClass('hidden');
                }
            }
        });
    }

    var savepassProxy = function(e) {
        if (e.which == 13) {
            savepass();
        }
    }

    var logout = function() {
        $.ajax({
            method: "POST",
            url: "user/logout/",

            success: function (payload) {
                if (payload.success == true) {
                    window.location = './';
                }
            }
        });
    }
</script>

<div class="key-form">
    <h3 class="info-message">
        Changing your Account password...
        (or <a data-query="click(logout)">Logout</a>)
    </h3>
    <input class="key-input" type="password" placeholder="New password" data-query="val(password).keyup(savepassProxy)" />
    <input class="key-input" type="password" placeholder="Repeat password" data-query="val(passrept).keyup(savepassProxy)" />
    <button class="submit-button" data-query="click(savepass).on('touchend', savepass)">submit</button>
    <p class="form-error form-error1 hidden">Something failed!</p>
    <p class="form-error form-error2 hidden">Passwords didn't match!</p>
</div>