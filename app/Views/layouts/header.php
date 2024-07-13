<nav class="header-dashboard">
    <div class="bandleft">
        <img src="<?= $logo ?>">
    </div>

    <div id="header_lobby" class="menuright">
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
    </div>
</nav>