<?= $this->extend("layouts/lobby") ?>

<?= $this->section("content") ?>

<div id="dps" class="tabcontent">
    <div class="headertab">
        <h2>ฝากอัตโนมัติ</h2>
    </div>
    <div class="containdps pb-5 mt-4">
        <div class="row m-0 mt-3 flex-column align-items-center">
            <template v-if="open_qr_payment">
                <div class="col-10 p-0 topdps">
                    <div class="nav flex-row nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><img class="banktabicon" src="assets/images/icons/bankicon.png"> ธนาคาร</a>
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><img class="banktabicon" src="assets/images/icons/qrcode.png"> QR Code</a>
                    </div>
                </div>
            </template>
            <div class="col-10 p-0">
                <div v-if="accountData && !accountData.tbankid" style="text-align: center; width: 100%; font-size: 13px; padding: 5px;">
                    <a href="<?= $line_link ?>" target="_blank" rel="noreferrer" class="mcolor colorbtn01" style="padding: 12px 16px;text-decoration: unset;color: #fff;"><?= lang('Lang.forgot.contact_us') ?></a>
                </div>
                <div v-else class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="griddps">
                            <div class="ingriddps">
                                <div class="iningriddps copybtn">
                                    <img :src="`<?= base_url() ?>assets/images/bank/${bankIcon(accountData.tbankid)}.svg`"> <br>
                                    {{ bankNameFormat(accountData.tbankid) }} <br>
                                    <span>{{ bankAccountNumberFormat(accountData.tbankno) }}</span> <br>
                                    {{ accountData.tbankname }} <br>
                                    <button @click="copyToClipboard(accountData.tbankno)"><i class="fad fa-copy"></i> คัดลอก </span></button>
                                </div>
                            </div>
                            <div class="ingriddps" style="margin-top: 1em;">
                                <div style="color: #c5c5c5;margin-bottom: 2em;">
                                    <?= lang('Lang.deposit.deposit_note') ?>
                                </div>
                                <form @submit="submitTransfer">
                                    <div class="form-group">
                                        <div>
                                            <label><?= lang('Lang.deposit.deposit_amount') ?></label>
                                            <div class="el-input mt-1">
                                                <input type="text" v-model="form.deposit_amount" placeholder="฿ 0.00" class="inputstyle">
                                                <p v-if="errors.deposit_amount" class="error">{{errors.deposit_amount}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button :disabled="accountData && !accountData.tbankid" type="submit" :class="accountData && !accountData.tbankid ? 'disabledbtn' : 'loginbtn'">
                                        <span>
                                            <?= lang('Lang.deposit.confirm') ?>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="griddps" style="grid-template-columns: 1fr">
                            <div class="ingriddps">
                                <template v-if="!qr_generated">
                                    <form @submit="submitQrCode">
                                        <div class="form-group">
                                            <div>
                                                <label><?= lang('Lang.deposit.deposit_amount') ?></label>
                                                <div class="el-input mt-1">
                                                    <input type="text" v-model="form.deposit_amount" placeholder="฿ 0.00" class="inputstyle">
                                                    <p v-if="errors.deposit_amount" class="error">{{errors.deposit_amount}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <button :disabled="accountData && !accountData.tbankid" type="submit" :class="accountData && !accountData.tbankid ? 'disabledbtn' : 'loginbtn'">
                                            <span>
                                                <?= lang('Lang.deposit.confirm') ?>
                                            </span>
                                        </button>
                                    </form>
                                </template>
                                <div v-if="qr_generated" id="genqr">
                                    <h4><?= lang('Lang.deposit.scan_via_qrcode') ?></h4>
                                    <p id="scan_in"></p>
                                    <img :src="qr_code" alt="qrcode">
                                    <button type="button" class="loginbtn" @click="downloadImg"><?= lang('Lang.deposit.save_qrcode') ?></button>
                                    <div style=" margin-top: 1rem;"><?= lang('Lang.deposit.payment_note_1') ?>
                                    </div>
                                    <div><?= lang('Lang.deposit.payment_note_2') ?></div>
                                    <div><?= lang('Lang.deposit.payment_note_3') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        openTab('dps')
    })

    Vue.createApp({
        data() {
            return {
                accountData: {},
                open_qr_payment: false,
                qr_generated: false,
                qr_code: '',
                xCountdown: {},
                errors: {
                    deposit_amount: ''
                },
                form: {
                    deposit_amount: '',
                    tbankid: '',
                    tbankno: ''
                }
            }
        },
        methods: {
            async getDepositAccount() {
                let {
                    status,
                    message,
                    data
                } = await post(`financial/deposit-account`)
                if (!status) return showAlert.warning(message)
                this.accountData = data
            },
            async submitTransfer(e) {
                e?.preventDefault()
                this.form.tbankid = this.accountData.tbankid
                this.form.tbankno = this.accountData.tbankno
                // Validate.
                this.errors.deposit_amount = ''
                this.errors.deposit_amount = this.validatorDepositAccount(this.form.deposit_amount)
                if (!this.errors.deposit_amount) {
                    let {
                        status,
                        message,
                        data
                    } = await post(`financial/deposit/transfer`, this.form)
                    if (!status) {
                        if (message == 'Waiting') return showAlert.warning(`<?= lang('Lang.deposit.waiting') ?>`)
                        else return showAlert.warning(message)
                    }
                    return showAlert.success(message, () => {
                        open_link('<?= site_url('history') ?>')
                    }, 1000)
                }
            },
            async submitQrCode(e) {
                e?.preventDefault()
                this.qr_code = ''
                this.form.tbankid = this.accountData.tbankid
                this.form.tbankno = this.accountData.tbankno
                // Validate.
                this.errors.deposit_amount = ''
                this.errors.deposit_amount = this.validatorDepositAccount(this.form.deposit_amount)
                if (!this.errors.deposit_amount) {
                    let {
                        status,
                        message,
                        data
                    } = await post(`financial/deposit/qrcode`, this.form)

                    if (!status && message != 'Waiting') return showAlert.warning(message)
                    if (message == 'Waiting' && data.qrpayment) this.qr_code = data.qrpayment
                    else this.qr_code = data.data.qrpayment

                    this.qr_generated = true
                    this.startCountdown()
                }
            },
            bankIcon(value) {
                const splitValue = value.split('-')
                if (splitValue.length < 2 && splitValue.length > 3) return '???'
                return splitValue[0].toLowerCase()
            },
            bankNameFormat(value) {
                const splitValue = value.split('-')
                if (splitValue.length < 2 && splitValue.length > 3) return '???'
                let bankName = ''
                switch (splitValue[0].toLowerCase()) {
                    case 'kbank':
                        bankName = `<?= lang('Lang.bank_list.kbank') ?>`
                        break;
                    case 'bbl':
                        bankName = `<?= lang('Lang.bank_list.bbl') ?>`
                        break;
                    case 'bay':
                        bankName = `<?= lang('Lang.bank_list.bay') ?>`
                        break;
                    case 'scb':
                        bankName = `<?= lang('Lang.bank_list.scb') ?>`
                        break;
                    case 'ktb':
                        bankName = `<?= lang('Lang.bank_list.ktb') ?>`
                        break;
                    case 'scib':
                        bankName = `<?= lang('Lang.bank_list.scib') ?>`
                        break;
                    case 'uobt':
                        bankName = `<?= lang('Lang.bank_list.uobt') ?>`
                        break;
                    case 'tisco':
                        bankName = `<?= lang('Lang.bank_list.tisco') ?>`
                        break;
                    case 'kkp':
                        bankName = `<?= lang('Lang.bank_list.kkp') ?>`
                        break;
                    case 'tbank':
                        bankName = `<?= lang('Lang.bank_list.tbank') ?>`
                        break;
                    case 'ghb':
                        bankName = `<?= lang('Lang.bank_list.ghb') ?>`
                        break;
                    case 'gsb':
                        bankName = `<?= lang('Lang.bank_list.gsb') ?>`
                        break;
                    case 'baac':
                        bankName = `<?= lang('Lang.bank_list.baac') ?>`
                        break;
                    case 'isbt':
                        bankName = `<?= lang('Lang.bank_list.isbt') ?>`
                        break;
                    case 'lhfg':
                        bankName = `<?= lang('Lang.bank_list.lhfg') ?>`
                        break;
                    case 'cimb':
                        bankName = `<?= lang('Lang.bank_list.cimb') ?>`
                        break;
                    case 'ttb':
                        bankName = `<?= lang('Lang.bank_list.ttb') ?>`
                        break;
                    default:
                        bankName = '???'
                        break;
                }

                const lang = '<?= $locale ?>'
                return lang == 'en' ?
                    `${bankName}Bank` : `ธนาคาร${bankName}`
            },
            bankAccountNumberFormat(value) {
                if (!value) return '-'
                strFirst = value.substr(0, 3)
                strSecond = value.substr(3, 1)
                strThird = value.substr(4, 5)
                strFourth = value.substr(9, 1)
                return `${strFirst}-${strSecond}-${strThird}-${strFourth}`
            },
            validatorDepositAccount(str) {
                // required 
                if (!str) return `<?= lang('Lang.deposit.amount_is_required') ?>`
                // digits 
                if (!str.match(/^[0-9]+$/)) return `<?= lang('Lang.deposit.amount_is_digits') ?>`
                // number
                if (!str.match(/^\d+$/)) return `<?= lang('Lang.deposit.amount_is_digits') ?>`
                // min 1
                if (Number(str) < 1) return `<?= lang('Lang.deposit.amount_is_min') ?>`
                return ''
            },
            startCountdown() {
                const timer = 1000 * 60 * 5
                let second = 1000 // 1 second
                // Update the count down every 1 second
                this.xCountdown = setInterval(function() {
                    // Find the distance between second and the timer
                    const distance = timer - second
                    second += 1000
                    // Time calculations for minutes and seconds
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000)
                    $('#scan_in').html(`<?= lang('Lang.deposit.please_pay_in') ?> (${minutes}m ${seconds}s)`)
                    // If the count down is finished, redirect forgot page.
                    if (distance < 0) {
                        this.qr_code = ''
                        clearInterval(this.xCountdown)
                        open_link('<?= site_url('history') ?>')
                    }
                }, 1000)
            },
            downloadImg() {
                if (this.qr_code) {
                    try {
                        let url = this.qr_code;
                        fetch(url)
                            .then((response) => response.blob())
                            .then((blob) => {
                                saveAs(blob, randomName() + '.jpg');
                            });
                    } catch (error) {
                        console.log(error);
                    }
                }
            },
            checkTimeToCloseQrPayment() {
                const start = dayjs(dayjs().format('YYYY-MM-DD') + 'T02:30:00+07:00').valueOf()
                const end = dayjs(dayjs().format('YYYY-MM-DD') + 'T23:00:00+07:00').valueOf()
                const now = dayjs().valueOf()
                this.open_qr_payment = (now > start && now < end)
            },
            copyToClipboard(text) {
                var $tempElement = $("<input>");
                $("body").append($tempElement);
                $tempElement.val(text).select();
                document.execCommand("Copy");
                $tempElement.remove();
                copylink()
            }
        },
        async mounted() {
            await this.getDepositAccount()
            // this.checkTimeToCloseQrPayment()
            $('#qrcodehis').hide()
        }
    }).mount('#dps')
</script>

<?= $this->endSection() ?>