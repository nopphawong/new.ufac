<nav class="header-dashboard">
    <div class="bandleft">
        <img src="<?= $logo ?>">
    </div>
    <div id="header_lobby" class="menuright">
        <?php if (session()->logged_in) : ?>
            <div class="headeruser">
                <button onclick="location.href='<?= site_url('profile') ?>'" class="active active"><i class="fa fa-user"></i> บัญชี</button>
            </div>
            <div class="headercredit">
                <span>
                    <i class="fad fa-user-secret"></i> <?= session()->userid ?>
                </span>
                <i class="fa fa-coins"></i> {{balance}} ฿<i class="fa fa-sync-alt ml-2 text-highlight cursorp" @click="getBalance"></i>
            </div>
            <div class="headerlogout">
                <i class="far fa-sign-out-alt" @click="logout()"></i>
            </div>
        <?php else : ?>
            <div style="padding-right: 15px;">
                <button type="button" class="loginbtn" style="margin-top: 0;" onclick="openLoginModal()"><span><?= lang('Lang.login.login') ?></span></button>
            </div>
            <div>
                <button type="button" class="mcolor colorbtn01" style="padding: 12px 16px;width: 115px;" onclick="openRegisterModal()"><span><?= lang('Lang.register.register') ?></span></button>
            </div>
        <?php endif ?>
    </div>
</nav>