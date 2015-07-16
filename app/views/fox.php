<script type="text/javascript">

    var _autowish = blocks.observable(<?php __('s_wi'); ?>).on('change', function(x){ change('autowish', x); });
    var _autorand = blocks.observable(<?php __('s_ra'); ?>).on('change', function(x){ change('autorand', x); });

    blocks.query({
        autowish: _autowish,
        autorand: _autorand
    });

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

    var change = function(param, value) {
        var frval = (value) ? 1 : 0;

        $.ajax({
            method: "POST",
            url: "user/updateval/",
            data: {
                'param': param,
                'value': frval
            },


            success: function (payload) {
                if (payload.success == false) {
                    alert('Shit happened!');
                }
            }
        });
    }

</script>

<div class="fox-interface">
    <div class="fox-header">
        <div class="fox-user-info">
            <img class="fox-user-avatar" src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/<?php __('useravtr'); ?>_medium.jpg" />
            <span class="fox-user-name"><?php __('username'); ?></span>
        </div>
        <div class="fox-user-data">
            <span class="fox-user-level">
                <span class="fox-user-level-desc">Level</span>
                <?php __('userlvls'); ?>
            </span>
            <span class="fox-bull">&bull;</span>
            <span class="fox-user-points">
                <?php __('userpnts'); ?>
                <span class="fox-user-points-desc">Points</span>
            </span>
        </div>
        <div class="clearfix">&nbsp;</div>
    </div>

    <div class="fox-main">
        <div class="row">
            <div class="col-xs-6"><span class="fox-title">Auto-Join Wishlist</span></div>
            <div class="col-xs-6">
                <div class="fancyCheckbox">
                    <input type="checkbox" id="gfSet_wishlist" class="mod-checkbox" data-query="checked(autowish)">
                    <label for="gfSet_wishlist"></label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6"><span class="fox-title">Auto-Join Random</span></div>
            <div class="col-xs-6">
                <div class="fancyCheckbox">
                    <input type="checkbox" id="gfSet_random" class="mod-checkbox" data-query="checked(autorand)">
                    <label for="gfSet_random"></label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6"><span class="fox-title">Last Auto-Join</span></div>
            <div class="col-xs-6"><span class="fox-title">
                <?php echo (Registry::get('lastjoin') > 0) ? date("d.m.Y - H:i", Registry::get('lastjoin')) : 'never'; ?>
            </span></div>
        </div>
        <div class="row justify fox-waiting">
            <div class="col-xs-12">
                <!--
                Waiting for: <?php __('userjoin'); ?>...
                -->
            </div>
        </div>
    </div>

    <div class="fox-footer">
        <a class="fox-logout" data-query="click(logout)">Logout</a>
        <div class="new-won">
            <a href="http://www.steamgifts.com/giveaways/won" target="_blank">
                <span class="new-won-count"><?php __('numwon'); ?></span>
            </a>
            <span>New gifts won!</span>
        </div>
    </div>
</div>
