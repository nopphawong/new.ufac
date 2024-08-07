<?= $this->extend("layouts/document") ?>

<?= $this->section("content") ?>

<!-- Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" style="background:none;">
            <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="incontainlogin">
                    <div class="row m-0">
                        <div id="login_box" class="col-12 col-md-12 p-0 pt-4 px-4">
                            <div>
                                <div class="headerlogin">
                                    <h2><?= lang('Lang.login.login') ?></h2>
                                </div>
                                <form id="login_form" @submit="submit">
                                    <div>

                                        <div class=" form-group">
                                            <div>
                                                <label><?= lang('Lang.login.username') ?></label>
                                                <div class="el-input mt-1">
                                                    <input type="text" v-model="form.username" placeholder="<?= lang('Lang.login.username') ?>" class="inputstyle">
                                                    <p v-if="errors.username" class="error">{{errors.username}}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div>
                                                <label><?= lang('Lang.login.password') ?></label>
                                                <div class="el-input mt-1">
                                                    <input type="password" v-model="form.password" placeholder="<?= lang('Lang.login.password') ?>" class="inputstyle">
                                                    <p v-if="errors.password" class="error">{{errors.password}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="loginbtn">
                                        <span>
                                            <?= lang('Lang.login.login') ?>
                                        </span>
                                    </button>
                                </form>

                                <div class="flex-row-gap justify-content-between">
                                    <div class="wantregister" style="cursor: pointer;" onclick="openForgotModal()"><?= lang('Lang.forgot.forgot') ?></div>
                                    <div class="wantregister"><?= lang('Lang.register.have_account_yet') ?> <a onclick="openRegisterModal()" style="cursor: pointer;"><?= lang('Lang.register.register_now') ?></a></div>
                                </div>

                            </div>
                            <div class="lang-pos">
                                <a href="<?= site_url('lang/th') ?>"><img src="<?= base_url() ?>assets/images/th.png" class="lang"></a>
                                <a href="<?= site_url('lang/en') ?>"><img src="<?= base_url() ?>assets/images/en.png" class="lang"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    Vue.createApp({
        data() {
            return {
                errors: {
                    username: '',
                    password: '',
                },
                form: {
                    username: '',
                    password: '',
                },
            }
        },
        methods: {
            async submit(e) {
                e?.preventDefault()
                this.errors.username = ''
                this.errors.password = ''
                // NOTE: required.
                if (!this.form.username) this.errors.username = `<?= lang('Lang.login.username_is_required') ?>`
                if (!this.form.password) this.errors.password = `<?= lang('Lang.login.password_is_required') ?>`
                if (!this.errors.username && !this.errors.password) {
                    let {
                        status,
                        message,
                        data
                    } = await post(`auth/login`, this.form)
                    if (!status) return showAlert.warning(message)
                    return showAlert.success(message, () => {
                        location.reload();
                    }, 1000)
                }
            }
        }
    }).mount('#login_box')
</script>

<?= $this->endSection() ?>