<?= $this->extend("layouts/document") ?>

<?= $this->section("content") ?>

<div class="containerlogin">
    <div class="incontainlogin">
        <div class="row m-0">
            <div class="col-12 col-md-6 p-0 px-4 pb-2 logoleftlogin">
                <img src="<?= $logo ?>">
            </div>
            <div id="register_box" class="col-12 col-md-6 p-0 pt-4 px-4">
                <div>
                    <div class="headerlogin">
                        <h2><?= lang('Lang.register.register') ?></h2>
                    </div>
                    <div class="stepregister">
                        <div class="stepregis headstep1 active">1</div>
                        <div class="stepregis headstep2">2</div>
                        <div class="stepregis headstep3">3</div>
                        <div class="stepregis headstep4"><i class="far fa-check"></i></div>
                    </div>

                    <!-- ---------------------step1--------------------- -->
                    <div class="stepre01 slideto">
                        <form @submit="validatePhone">
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
                                <?= lang('Lang.register.next') ?>
                            </button>
                        </form>
                    </div>
                    <!-- ---------------------End step1--------------------- -->

                    <!-- ---------------------step2--------------------- -->
                    <div class="regisstep stepre02 slideto">
                        <form @submit="validatePassword">
                            <div class=" form-group">
                                <div>
                                    <label><?= lang('Lang.register.password') ?></label>
                                    <div class="el-input mt-1">
                                        <input type="password" v-model="form.password" placeholder="<?= lang('Lang.register.password') ?>" class="inputstyle">
                                        <p v-if="errors.password" class="error">{{errors.password}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class=" form-group">
                                <div>
                                    <label><?= lang('Lang.register.confirm_password') ?></label>
                                    <div class="el-input mt-1">
                                        <input type="password" v-model="form.confirm_password" placeholder="<?= lang('Lang.register.confirm_password') ?>" class="inputstyle">
                                        <p v-if="errors.confirm_password" class="error">{{errors.confirm_password}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-row-gap">
                                <button type="button" class="backbtn" id="btn-back1">
                                    <?= lang('Lang.register.back') ?>
                                </button>
                                <button type="submit" class="loginbtn" id="btn-step2">
                                    <?= lang('Lang.register.next') ?>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- ---------------------End step2--------------------- -->

                    <!-- ---------------------step3--------------------- -->
                    <div class="regisstep stepre03 slideto">
                        <form @submit="verifyBank">
                            <div class=" form-group">
                                <div>
                                    <label><?= lang('Lang.register.bank') ?></label>
                                    <div class="x-bank-choices-type mt-1 mb-2">
                                        <div class="-outer-wrapper">
                                            <input type="radio" class="-input-radio" id="bank-acc-51620499644" name="bank_code" value="BBL" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-51620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/bbl.svg" alt="BBL">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-61620499644" name="bank_code" value="KBANK" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-61620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/kbank.svg" alt="KBANK">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-71620499644" name="bank_code" value="KTB" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-71620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/ktb.svg" alt="KTB">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-81620499644" name="bank_code" value="TTB" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-81620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/ttb.svg" alt="TTB">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-91620499644" name="bank_code" value="SCB" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-91620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/scb.svg" alt="SCB">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-101620499644" name="bank_code" value="CIMB" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-101620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/cimb.svg" alt="CIMB">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-111620499644" name="bank_code" value="UOB" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-111620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/uobt.svg" alt="UOB">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-121620499644" name="bank_code" value="BAY" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-121620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/bay.svg" alt="BAY">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-131620499644" name="bank_code" value="GSB" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-131620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/gsb.svg" alt="GSB">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-141620499644" name="bank_code" value="BAAC" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-141620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/baac.svg" alt="BAAC">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-151620499644" name="bank_code" value="TISCO" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-151620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/tisco.svg" alt="TISCO">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-161620499644" name="bank_code" value="KKP" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-161620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/kkp.svg" alt="KKP">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <input type="radio" class="-input-radio" id="bank-acc-171620499644" name="bank_code" value="LHFG" v-model="form.financial_id">
                                            <label class="-label" for="bank-acc-171620499644">
                                                <img class="-logo" src="<?= base_url() ?>assets/images/bank/lhfg.svg" alt="LHFG">
                                                <i class="fas fa-check"></i>
                                            </label>
                                        </div>
                                        <p v-if="errors.financial_id" class="error">{{errors.financial_id}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class=" form-group">
                                <div>
                                    <label><?= lang('Lang.register.bank_account_no') ?></label>
                                    <div class="el-input mt-1">
                                        <div class="flex-row-gap">
                                            <input type="text" v-model="form.account_number" placeholder="<?= lang('Lang.register.bank_account_no_note') ?>" class="inputstyle">
                                            <button :disabled="verified" type="submit" id="btn-verify" :class="!verified ? 'verifybtn' : 'disabledbtn'" style="width: 30%;height: 46px;padding: 0;margin-top:0"><?= lang('Lang.register.verrify') ?></button>
                                        </div>
                                        <p v-if="errors.account_number" class="error">{{errors.account_number}}</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form @submit="submitRegister">
                            <div class=" form-group">
                                <div>
                                    <label><?= lang('Lang.register.bank_account_name') ?></label>
                                    <div class="el-input mt-1">
                                        <input type="text" v-model="form.account_name" placeholder="<?= lang('Lang.register.bank_account_name') ?>" class="inputstyle" :readonly="!manuan_account_name">
                                        <p v-if="errors.account_name" class="error">{{errors.account_name}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-row-gap">
                                <button type="button" class="backbtn" id="btn-back2">
                                    <?= lang('Lang.register.back') ?>
                                </button>
                                <button :disabled="!verified" type="submit" id="btn-step3" :class="verified ? 'loginbtn' : 'disabledbtn'"><?= lang('Lang.register.confirm') ?></button>
                            </div>
                        </form>
                    </div>
                    <!-- ---------------------End step3--------------------- -->

                    <!-- ---------------------step4--------------------- -->
                    <div class="regisstep stepre04 slideto finishcontain">
                        <?= lang('Lang.register.register_is_succeed') ?>
                    </div>
                    <!-- ---------------------End step4--------------------- -->
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
    // NOTE: Get refference from url.
    const urlParams = new URLSearchParams(window.location.search);
    const reference = urlParams.get('ref') || '';

    const {
        createApp,
        ref
    } = Vue

    createApp({
        data() {
            return {
                loading: false,
                verified: false,
                manuan_account_name: false,
                errors: {
                    username: '',
                    password: '',
                    confirm_password: '',
                    financial_id: '',
                    account_number: '',
                    account_name: '',
                },
                form: {
                    username: '',
                    password: '',
                    confirm_password: '',
                    financial_id: '',
                    account_number: '',
                    account_name: '',
                    web_username: '',
                    web_password: '',
                    web_agent: '',
                    reference: '',
                },
            }
        },
        methods: {
            async validatePhone(e) {
                e?.preventDefault()
                this.errors.username = ''
                // NOTE: validatate.
                this.errors.username = this.validatorPhoneNumber(this.form.username)
                if (!this.errors.username) {
                    let {
                        status,
                        message,
                        data
                    } = await post(`register/validate-phone`, this.form)
                    if (!status) return showAlert.warning(message)

                    return stepOneToTwo()
                }
            },
            async validatePassword(e) {
                e?.preventDefault()
                this.errors.password = ''
                this.errors.confirm_password = ''
                // NOTE: validatate.
                this.errors.password = this.validatorPassword(this.form.password)
                // equalTo
                if (this.form.password != this.form.confirm_password) this.errors.confirm_password = `<?= lang('Lang.register.confrim_password_is_matches') ?>`
                if (!this.errors.password && !this.errors.confirm_password) {
                    return stepTwoToThree()
                }
            },
            async verifyBank(e) {
                e?.preventDefault()
                this.errors.financial_id = ''
                this.errors.account_number = ''
                // NOTE: validatate.
                if (!this.form.financial_id) this.errors.financial_id = `<?= lang('Lang.register.bank_is_select') ?>`
                this.errors.account_number = this.validatorAccountNumber(this.form.account_number)

                if (!this.errors.financial_id && !this.errors.account_number) {
                    let {
                        status,
                        message,
                        data
                    } = await post(`register/verify-bank`, this.form)
                    if (!status) {
                        if (message == 'เลขที่บัญชีรับเงินไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง' || message == 'บัญชีมีการลงทะเบียนในระบบแล้ว !!') {
                            return showAlert.warning(message)
                        } else {
                            this.manuan_account_name = true
                            this.verified = true
                            this.errors.account_name = `<?= lang('Lang.register.verify_bank_account_name') ?>`
                            return showAlert.warning(`<?= lang('Lang.register.verify_bank_account_name') ?>`)
                        }
                    }
                    if (data) {
                        this.verified = true
                        this.form.account_name = data.accName
                    }
                }
            },
            async submitRegister(e) {
                e?.preventDefault()
                if (this.loading) return
                this.errors.account_name = ''
                if (!this.form.account_name) this.errors.account_name = this.validatorAccountName(this.form.account_name)
                if (!this.errors.account_name) {
                    this.loading = true
                    let validatedPhone = await post(`register/validate-phone`, this.form)
                    this.loading = false
                    if (!validatedPhone.status) {
                        if (validatedPhone.message == 'รหัสผู้ใช้งาน 0930208780 ซ้ำ !!!') return showAlert.warning('มีผู้ใช้งานนี้ในระบแล้ว')
                        return showAlert.warning(validatedPhone.message)
                    }
                    // this.form.web_username = ''
                    // this.form.web_password = ''
                    // this.form.web_agent = ''
                    // // get webuser
                    // let response = await post(`register/webuser`, this.form)
                    // if (response.status) {
                    //     let { web_username, web_password, web_agent } = response.data
                    //     this.form.web_username = web_username
                    //     this.form.web_password = web_password
                    //     this.form.web_agent = web_agent
                    // }
                    this.form.reference = reference
                    this.loading = true
                    let {
                        status,
                        message,
                        data
                    } = await post(`register/submit`, this.form)
                    this.loading = false
                    if (!status) {
                        // unlink webuser
                        // if (this.form.web_username) await post(`register/unlink-webuser`, this.form)
                        return showAlert.warning(message)
                    }
                    stepThreeToFour()
                }
            },
            validatorPhoneNumber(str) {
                // required 
                if (!str) return `<?= lang('Lang.register.username_is_required') ?>`
                // digits 
                if (!str.match(/^[0-9]+$/)) return `<?= lang('Lang.register.username_is_numeric') ?>`
                // minlength
                if (str.length < 10) return `<?= lang('Lang.register.username_is_required') ?>`
                return ''
            },
            validatorPassword(str) {
                // required 
                if (!str) return `<?= lang('Lang.register.password_is_required') ?>`
                // alpha numeric 
                if (!str.match(/^[0-9a-zA-Z]+$/)) return `<?= lang('Lang.register.password_is_alpha_numeric') ?>`
                // range length
                if (str.length < 6 || str.length > 20) return `<?= lang('Lang.register.password_is_min_length') ?>`
                return ''
            },
            validatorAccountNumber(str) {
                // required 
                if (!str) return `<?= lang('Lang.register.bankno_is_required') ?>`
                // digits 
                if (!str.match(/^[0-9]+$/)) return `<?= lang('Lang.register.bankno_is_numeric') ?>`
                return ''
            },
            validatorAccountName(str) {
                // required 
                if (!str) return `<?= lang('Lang.register.verify_bank_account_name') ?>`
                return ''
            }
        }
    }).mount('#register_box')

    // go step1 to step2
    function stepOneToTwo() {
        $(".stepre01").hide();
        $(".stepre02").show();
        $(".headstep1").removeClass("active");
        $(".headstep2").addClass("active");
    }

    // go step2 to step3
    function stepTwoToThree() {
        $(".stepre02").hide();
        $(".stepre03").show();
        $(".headstep2").removeClass("active");
        $(".headstep3").addClass("active");
    }

    // go step3 to step4
    function stepThreeToFour() {
        $(".stepre03").hide();
        $(".stepre04").show();
        $(".headstep3").removeClass("active");
        $(".headstep4").addClass("active");
        setTimeout(function() {
                open_link('<?= site_url('login') ?>')
            },
            2000)
    }

    // back step2 to step1
    document.getElementById("btn-back1").onclick = function() {
        $(".stepre02").hide();
        $(".stepre01").show();
        $(".headstep2").removeClass("active");
        $(".headstep1").addClass("active");
    };

    // back step3 to step2
    document.getElementById("btn-back2").onclick = function() {
        $(".stepre03").hide();
        $(".stepre02").show();
        $(".headstep3").removeClass("active");
        $(".headstep2").addClass("active");
    };

    $('.btnclosebankselect').click(function() {
        $('.inbankselectpopup').addClass("closeanimationselectbank");
        setTimeout(function() {
            $('.bankselectpopup').hide();
        }, 400);
    });

    $('.open_select_bank').click(function() {
        $('.inbankselectpopup').removeClass("closeanimationselectbank");
        $('.bankselectpopup').show();
    });

    $('.bankselectpopup').hide();
</script>

<?= $this->endSection() ?>