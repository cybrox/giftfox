<script type="text/javascript">

    var App = blocks.Application();

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
                    <input type="checkbox" id="gfSet_wishlist" class="mod-checkbox" name="">
                    <label for="gfSet_wishlist"></label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6"><span class="fox-title">Auto-Join Promoted</span></div>
            <div class="col-xs-6">
                <div class="fancyCheckbox">
                    <input type="checkbox" id="gfSet_promoted" class="mod-checkbox" name="">
                    <label for="gfSet_promoted"></label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6"><span class="fox-title">Auto-Join Random</span></div>
            <div class="col-xs-6">
                <div class="fancyCheckbox">
                    <input type="checkbox" id="gfSet_random" class="mod-checkbox" name="">
                    <label for="gfSet_random"></label>
                </div>
            </div>
        </div>
    </div>

    <div class="fox-footer">
        <a data-query="click(logout)">Logout</a>
    </div>
</div>
