<?= $this->extend("layouts/document") ?>

<?= $this->section("content") ?>

<div class="containerlogin">
    <div class="incontainlogin">
        <div class="row m-0">
            <div class="col-12 col-md-6 p-0 px-4 pb-2 logoleftlogin">
                <img src="<?= $logo ?>">
            </div>
            <div id="forgot_box" class="col-12 col-md-6 p-0 pt-4 px-4">
                <div>
                    <div class="headerlogin">
                        <h2><?= lang('Lang.forgot.forgot') ?></h2>
                    </div>
                    <div class="stepregister">
                        <div class="stepregis headstep1 active">1</div>
                        <div class="stepregis headstep2">2</div>
                        <div class="stepregis headstep3"><i class="far fa-check" style="margin-top: 4px;"></i></div>
                    </div>

                    <!-- ---------------------step1--------------------- -->
                    <div class="stepre01 slideto">
                        <form @submit="verifyPhone">
                            <div class=" form-group">
                                <div>
                                    <label><?= lang('Lang.register.mobile_number') ?></label>
                                    <div class="el-input mt-1">
                                        <input type="text" v-model="form.username" placeholder="<?= lang('Lang.register.mobile_number') ?>" class="inputstyle">
                                        <p v-if="errors.username" class="error">{{errors.username}}</p>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="loginbtn" id="btn-step1">
                                Request OTP
                            </button>
                        </form>
                    </div>
                    <!-- ---------------------End step1--------------------- -->

                    <!-- ---------------------step2--------------------- -->
                    <div class="regisstep stepre02 slideto">
                        <form @submit="submitForgotPass">
                            <div class="form-group">
                                <div>
                                    <label id="otp_code"><?= lang('Lang.forgot.otp_code') ?></label>
                                    <div class="el-input mt-1">
                                        <div class="flex-row-gap">
                                            <input type="text" v-model="form.otpcode" placeholder="<?= lang('Lang.forgot.otp_code') ?>" class="inputstyle">
                                            <div v-if="form.otpref"><?= lang('Lang.forgot.otp_ref') ?> {{form.otpref}}</div>
                                        </div>
                                        <p v-if="errors.otpcode" class="error">{{errors.otpcode}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-group">
                                <div>
                                    <label><?= lang('Lang.forgot.new_password') ?></label>
                                    <div class="el-input mt-1">
                                        <input type="password" v-model="form.password" placeholder="<?= lang('Lang.forgot.new_password') ?>" class="inputstyle">
                                        <p v-if="errors.password" class="error">{{errors.password}}</p>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="loginbtn" id="btn-step2">
                                <?= lang('Lang.forgot.confirm') ?>
                            </button>

                            <p style="margin-top: 20px;margin-bottom: 0;font-size: 12px;"><?= lang('Lang.forgot.otp_note') ?></p>
                            <a href="<?= $line_link ?>" target="_blank" rel="noreferrer" class="backbtn" style="display:block; text-align: center;text-decoration: none;margin-top: 0;color: #c2bfbf;"><?= lang('Lang.forgot.contact_us') ?></a>

                        </form>
                    </div>
                    <!-- ---------------------End step2--------------------- -->

                    <!-- ---------------------step3--------------------- -->
                    <div class="regisstep stepre03 slideto finishcontain">
                        <?= lang('Lang.forgot.reset_password_is_succeed') ?>
                    </div>
                    <!-- ---------------------End step3--------------------- -->
                    <div class="wantregister"><?= lang('Lang.register.have_account') ?> <a href="<?= site_url('login') ?>"><?= lang('Lang.register.login_now') ?></a></div>
                </div>
                <div class="lang-pos">
                    <a href="<?= site_url('lang/th') ?>"><img src="<?= base_url() ?>assets/images/th.png" class="lang"></a>
                    <a href="<?= site_url('lang/en') ?>"><img src="<?= base_url() ?>assets/images/en.png" class="lang"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var x

    Vue.createApp({
        data() {
            return {
                errors: {
                    username: '',
                    password: '',
                    otpcode: '',
                },
                form: {
                    username: '',
                    password: '',
                    otpref: '',
                    otpcode: '',
                },
            }
        },
        methods: {
            async verifyPhone(e) {
                e?.preventDefault()
                this.errors.username = ''
                this.errors.username = this.validatorPhoneNumber(this.form.username)
                if (!this.errors.username) {
                    let {
                        status,
                        message,
                        data
                    } = await post(`forgot/request-otp`, this.form)
                    if (!status) return showAlert.warning(message)
                    if (data) {
                        this.form.otpref = data
                        stepOneToTwo()
                    }
                }
            },
            async submitForgotPass(e) {
                e?.preventDefault()
                this.errors.otpcode = ''
                this.errors.password = ''
                if (!this.form.otpcode) this.errors.otpcode = `<?= lang('Lang.forgot.otp_is_required') ?>`
                this.errors.password = this.validatorPassword(this.form.password)
                if (!this.errors.otpcode && !this.errors.password) {
                    let {
                        status,
                        message,
                        data
                    } = await post(`forgot/submit`, this.form)
                    if (!status) return showAlert.warning(message)
                    return stepTwoToThree()
                }
            },
            validatorPhoneNumber(str) {
                // required 
                if (!str) return `<?= lang('Lang.register.username_is_required') ?>`
                // digits 
                if (!str.match(/^[0-9]+$/)) return `<?= lang('Lang.register.username_is_numeric') ?>`
                return ''
            },
            validatorPassword(str) {
                // required 
                if (!str) return `<?= lang('Lang.forgot.password_is_required') ?>`
                // alpha numeric 
                if (!str.match(/^[0-9a-zA-Z]+$/)) return `<?= lang('Lang.forgot.password_is_alpha_numeric') ?>`
                // range length
                if (str.length < 6 || str.length > 20) return `<?= lang('Lang.forgot.password_is_min_length') ?>`
                return ''
            }
        }
    }).mount('#forgot_box')

    // go step1 to step2
    function stepOneToTwo() {
        $(".stepre01").hide();
        $(".stepre02").show();
        $(".headstep1").removeClass("active");
        $(".headstep2").addClass("active");

        const timer = localStorage.getItem('kCountdown') ? Number(localStorage.getItem('kCountdown')) : 1000 * 60 * 9.5
        let second = 1000 // 1 second
        // Update the count down every 1 second
        x = setInterval(function() {
            // Find the distance between second and the timer
            const distance = timer - second
            second += 1000
            // Time calculations for minutes and seconds
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
            const seconds = Math.floor((distance % (1000 * 60)) / 1000)
            $('#otp_code').html(`<?= lang('Lang.forgot.otp_code') ?> (${minutes}m ${seconds}s)`)
            // If the count down is finished, redirect forgot page.
            if (distance < 0) {
                backToStep1()
            }
        }, 1000)
    }

    // go step2 to step3
    function stepTwoToThree() {
        $(".stepre02").hide();
        $(".stepre03").show();
        $(".headstep2").removeClass("active");
        $(".headstep3").addClass("active");

        setTimeout(function() {
            open_link('<?= site_url('login') ?>')
        }, 2000)
    }

    // Back step 1
    function backToStep1() {
        clearInterval(x)
        $(".stepre02").hide();
        $(".stepre01").show();
        $(".headstep2").removeClass("active");
        $(".headstep1").addClass("active");
    }

    $(".stepre02").hide();
    $(".stepre03").hide();
</script>

<?= $this->endSection() ?>