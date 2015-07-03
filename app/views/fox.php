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
    </div>

    <div class="fox-footer">
        <a data-query="click(logout)">Logout</a>
    </div>
</div>
