<div class="header-menu">
    <div class="navmenu" onclick="location.href = '<?= site_url('') ?>'" id="navhomepage">
        <img src="<?= base_url() ?>assets/images/icons/icon-home.png"><br>
        หน้าหลัก
    </div>
    <div class="navmenu" onclick="checkLogin('deposit')" id="navdps">
        <img src="<?= base_url() ?>assets/images/icons/icon-deposit.png"><br>
        ฝากเงิน
    </div>
    <div class="navmenu" onclick="checkLogin('withdraw')" id="navwd">
        <img src="<?= base_url() ?>assets/images/icons/icon-withdraw.png"><br>
        ถอนเงิน
    </div>
    <div class="navmenu" onclick="checkLogin('history')" id="navhistory">
        <img src="<?= base_url() ?>assets/images/icons/icon-history.png"><br>
        ประวัติ
    </div>
    <div class="navmenu" onclick="location.href = '<?= site_url('promotion') ?>'" id="navpromotion">
        <img src="<?= base_url() ?>assets/images/icons/icn-hot.png"><br>
        โปรโมชั่น
    </div>
    <div class="navmenu" onclick="checkLogin('profile')" id="navaccount">
        <img src="<?= base_url() ?>assets/images/icons/icn-card-2.png"><br>
        บัญชีของฉัน
    </div>
</div>

<script>
    const logged_in = Boolean('<?= session()->logged_in ?>')
    const checkLogin = (page) => {
        switch (page) {
            case 'deposit':
                if (logged_in) location.href = '<?= site_url('deposit') ?>'
                else openLoginModal()
                break;
            case 'withdraw':
                if (logged_in) location.href = '<?= site_url('withdraw') ?>'
                else openLoginModal()
                break;
            case 'history':
                if (logged_in) location.href = '<?= site_url('history') ?>'
                else openLoginModal()
                break;
            case 'profile':
                if (logged_in) location.href = '<?= site_url('profile') ?>'
                else openLoginModal()
                break;
            default:
                openLoginModal()
                break;
        }
    }

    const openLoginModal = () => {
        $(`#register-modal`).modal('hide')
        $(`#forgot-modal`).modal('hide')
        $(`#login-modal`).modal('show')
    }

    const openRegisterModal = () => {
        $(`#login-modal`).modal('hide')
        $(`#forgot-modal`).modal('hide')
        $(`#register-modal`).modal('show')
    }

    const openForgotModal = () => {
        $(`#login-modal`).modal('hide')
        $(`#register-modal`).modal('hide')
        $(`#forgot-modal`).modal('show')
    }
</script>