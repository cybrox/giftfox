<script type="text/javascript">
    var _sesskey = blocks.observable("");

    blocks.query({
        sesskey: _sesskey,
    });

    var savekey = function(e) {
        if (_sesskey().length < 20) {
            $('.form-error2').removeClass('hidden');
            return;
        } else {
            $('.form-error2').addClass('hidden');
            $('.submit-button').addClass('active');
        }

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
                    $('.form-error1').removeClass('hidden');
                }
            }
        });
    }

    var savekeyProxy = function(e) {
        if (e.which == 13) {
            savekey();
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
        <a>steamgifts.com</a> session has expired!
        Copy new session key
        (<a data-query="click(logout)">Logout</a>)
    </h3>
    <input class="key-input" type="text" placeholder="sessionkey" data-query="val(sesskey).keyup(savekeyProxy)" />
    <button class="submit-button" data-query="click(savekey).on('touchend', savekey)">submit</button>
    <p class="form-error form-error1 hidden">Something failed!</p>
    <p class="form-error form-error2 hidden">Key too short!</p>
    <div class="small-row">
        <h3 class="info-message info-large">
            In order to retreive your session key, open steamgifts.com, open your browsers javascript console 
            (most browsers allow using <a>ctrl + shift + J</a> or <a>F12 and the select the 'Console' tab</a>), 
            copy the following string, hit enter and copy the string that the console gives you into here.<br />
            <em class="very-small">
                ((document.cookie.split(/;\s*/).filter(function(x){return ((x.split('='))[0])=='PHPSESSID'}))[0].split('=')[1]);
            </em> 
        </h3>
        <h3 class="info-message info-large">
            The session id you get should look something like this:<br />
            <em class="very-small">
                2bb806680fab36879eeb2a182c599ba1edd660059177640faa49528564d4f5345eeb82093ed356d4a0172e85aa7aac8a740b01b97d03b587d25d9606c4d8b447
            </em> 
        </h3>
    </div>
</div>