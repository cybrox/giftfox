<html>
<head>
    <?php Autoloader::load_vendor(); ?>
    <?php Autoloader::load_public(); ?>

    <title>Giftfox</title>

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
</head>
<body>

    <header>
        <h1 class="page-logo">
            <span>GIFT</span>
            <span class="page-logo-fox">FOX</span>
        </h1>
    </header>

    <section id="wrapper">
        <div class="login-form">
            <input class="login-input" type="text" placeholder="username" data-query="val(username).keyup(login)" />
            <input class="login-input" type="password" placeholder="password" data-query="val(password).keyup(login)" />
            <p class="login-error hidden">Login failed!</p>
        </div>
    </section>

    <footer>
        <span class="page-info">Built with &hearts; by <a>cybrox</a></span>
    </footer>

</body>
</html>
