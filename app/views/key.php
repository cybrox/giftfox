<script type="text/javascript">
    var _sesskey = blocks.observable("");

    blocks.query({
        sesskey: _sesskey,
    });

    var savekey = function(e) {
        if (e.which == 13) {
            $.ajax({
                method: "POST",
                url: "user/updatekey/",
                data: {
                    sesskey: _sesskey(),
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
    }
</script>

<div class="key-form">
    <h3 class="info-message"><a>steamgifts.com</a> session has expired! Copy new session key.</h3>
    <input class="key-input" type="text" placeholder="sessionkey" data-query="val(sesskey).keyup(savekey)" />
    <p class="form-error hidden">Something failed!</p>
</div>