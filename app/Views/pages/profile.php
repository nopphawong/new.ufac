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
                            <img src="/assets/images/bank/<?= $formatter->bank_icon_format(session()->bankid) ?>.svg">
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
                    <td class="headeraccount"><i class="fad fa-users"></i> </td>
                    <td><?= lang('Lang.profile.web_user') ?> <br> <span>
                            <?php if (session()->webuser) : ?>
                                <?= session()->webuser ?>
                            <?php else : ?>
                                <?= lang('Lang.profile.have_not_user_yet') ?>
                            <?php endif ?>
                        </span>
                    </td>
                    <td class="headeraccount"><i class="fal fa-lock"></i> </td>
                    <td><?= lang('Lang.profile.web_password') ?> <br>
                        <span>
                            <?php if (session()->webpass) : ?>
                                <?= session()->webpass ?>
                            <?php else : ?>
                                <?= lang('Lang.profile.have_not_pass_yet') ?>
                            <?php endif ?>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="text-align: center;">
            <button type="button" class="loginbtn" style="max-width: 280px;" onclick="changepassword()">
                <span>
                    <?= lang('Lang.change_password.change_password') ?>
                </span>
            </button>
        </div>

    </div>
    <div class="containcpass">
        <div class="backaccount cursorp"><i class="far fa-chevron-left"></i> <?= lang('Lang.register.back') ?></div>
        <form @submit="submit">
            <div class="headertab">
                <h2><?= lang('Lang.change_password.change_password') ?></h2>
            </div>
            <div class=" form-group">
                <div>
                    <label><?= lang('Lang.change_password.current_password') ?></label>
                    <div class="el-input mt-1">
                        <input type="password" v-model="form.current_password" placeholder="<?= lang('Lang.change_password.current_password') ?>" class="inputstyle">
                        <p v-if="errors.current_password" class="error">{{errors.current_password}}</p>
                    </div>
                </div>
            </div>
            <div class=" form-group">
                <div>
                    <label><?= lang('Lang.change_password.new_password') ?></label>
                    <div class="el-input mt-1">
                        <input type="password" v-model="form.new_password" placeholder="<?= lang('Lang.change_password.new_password') ?>" class="inputstyle">
                        <p v-if="errors.new_password" class="error">{{errors.new_password}}</p>
                    </div>

                </div>
            </div>
            <div class=" form-group">
                <div>
                    <label><?= lang('Lang.change_password.confirm_password') ?></label>
                    <div class="el-input mt-1">
                        <input type="password" v-model="form.confirm_password" placeholder="<?= lang('Lang.change_password.confirm_password') ?>" class="inputstyle">
                        <p v-if="errors.confirm_password" class="error">{{errors.confirm_password}}</p>
                    </div>
                </div>
            </div>
            <button type="submit" class="loginbtn"><i class="fal fa-sign-in"></i> <?= lang('Lang.change_password.confrim') ?></button>
        </form>
    </div>
</div>

<script>
    $(function() {
        openTab('account')
    })

    Vue.createApp({
        data() {
            return {
                errors: {
                    current_password: '',
                    new_password: '',
                    confirm_password: '',
                },
                form: {
                    current_password: '',
                    new_password: '',
                    confirm_password: '',
                },
            }
        },
        methods: {
            async submit(e) {
                e?.preventDefault()
                this.errors.current_password = ''
                this.errors.new_password = ''
                this.errors.confirm_password = ''
                // NOTE: validatate.
                this.errors.current_password = this.validatorCurrentPassword(this.form.current_password)
                this.errors.new_password = this.validatorPassword(this.form.new_password)
                // equalTo
                if (this.form.new_password != this.form.confirm_password) this.errors.confirm_password = `<?= lang('Lang.change_password.confrim_password_is_matches') ?>`
                if (!this.errors.current_password && !this.errors.new_password && !this.errors.confirm_password) {
                    let {
                        status,
                        message,
                        data
                    } = await post(`lobby/changepass`, this.form)
                    if (!status) return showAlert.warning(message)
                    return showAlert.success(message, () => {
                        open_link('<?= site_url('login') ?>')
                    }, 2000)
                }
            },
            validatorCurrentPassword(str) {
                // required 
                if (!str) return `<?= lang('Lang.change_password.password_is_required') ?>`
                // alpha numeric
                if (!str.match(/^[0-9a-zA-Z]+$/)) return `<?= lang('Lang.change_password.password_is_alpha_numeric') ?>`
                return ''
            },
            validatorPassword(str) {
                // required 
                if (!str) return `<?= lang('Lang.change_password.password_is_required') ?>`
                // alpha numeric
                if (!str.match(/^[0-9a-zA-Z]+$/)) return `<?= lang('Lang.change_password.password_is_alpha_numeric') ?>`
                // range length
                if (str.length < 6 || str.length > 20) return `<?= lang('Lang.change_password.password_is_min_length') ?>`
                return ''
            }
        }
    }).mount('#account')


    // Change Password
    function changepassword() {
        $('.containcpass').show();
        $('.accountdetail').hide();
    }
    $('.backaccount').on('click', function() {
        $('.containcpass').hide();
        $('.accountdetail').show();
    });
    // Change Password
</script>

<?= $this->endSection() ?>