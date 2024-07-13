<?= $this->extend("layouts/lobby") ?>

<?= $this->section("content") ?>

<div id="account" class="tabcontent">
    <div class="accountdetail">
        <div class="headertab">
            <h2><?= lang('Lang.profile.profile') ?></h2>
        </div>
        <div class="detailwd accountct">
            <table align="center">
                <tbody>
                    <tr>
                        <td>
                            <img src="<?= base_url() ?>assets/images/bank/<?= $formatter->bank_icon_format(session()->bankid) ?>.svg">
                        </td>
                        <td>
                            <?= lang('Lang.profile.bank_name') ?>: <?= $formatter->bank_name_format(session()->bankid) ?> <br>
                            <span><?= lang('Lang.profile.bank_account_number') ?><?= session()->bankno ?></span><br>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table align="center" class="accountofuser mt-3">
            <tbody>
                <tr class="trofaccount">
                    <td class="headeraccount"><i class="fad fa-user"></i> </td>
                    <td><?= lang('Lang.profile.name') ?> <br> <span><?= session()->name ?></span></td>
                    <td class="headeraccount"><i class="fad fa-user-circle"></i> </td>
                    <td><?= lang('Lang.profile.username') ?> <br> <span><?= session()->userid ?></span></td>
                </tr>
                <tr class="trofaccount">
                    <td class="headeraccount"><i class="fad fa-lock"></i> </td>
                    <td>รหัสผ่าน <br> <span>1234567890</span></td>
                    <td class="headeraccount"><i class="fal fa-edit"></i> </td>
                    <td class="cursorp" onclick="changepassword()"><span>เปลี่ยนรหัสผ่าน</span></td>
                </tr>
                <tr class="trofaccount">
                    <td class="headeraccount"><i class="fad fa-gift"></i></td>
                    <td>โปรโมชั่น <br> <span>ไม่รับโปรโมชั่น</span></td>
                    <td class="headeraccount"><i class="fad fa-users"></i> </td>
                    <td><?= lang('Lang.profile.web_user') ?> <br> <span>
                            <?php if (session()->webuser) : ?>
                                <?= session()->webuser ?>
                            <?php else : ?>
                                <?= lang('Lang.profile.have_not_user_yet') ?>
                            <?php endif ?>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="containcpass">
        <div class="backaccount cursorp"><i class="far fa-chevron-left"></i> ย้อนกลับ</div>
        <form>
            <div class="headertab">
                <h2>เปลี่ยนรหัสผ่าน</h2>
            </div>
            <div class=" form-group">
                <div>
                    <label> รหัสผ่านใหม่</label>
                    <div class="el-input mt-1">
                        <input type="text" placeholder="รหัสผ่านใหม่" class="inputstyle">
                    </div>

                </div>
            </div>
            <div class=" form-group">
                <div>
                    <label> ยืนยันรหัสผ่านใหม่</label>
                    <div class="el-input mt-1">
                        <input type="text" placeholder="ยืนยันรหัสผ่านใหม่" class="inputstyle">
                    </div>

                </div>
            </div>
        </form>
        <button type="button" class="loginbtn" onclick="">
            <span>
                เปลี่ยนรหัสผ่าน
            </span>
        </button>
    </div>
</div>

<script>
    $(function() {
        openTab('account')
    })
</script>

<?= $this->endSection() ?>