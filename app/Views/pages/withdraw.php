<?= $this->extend("layouts/lobby") ?>

<?= $this->section("content") ?>

<div id="wd" class="tabcontent">
    <div class="headertab">
        <h2>แจ้งถอนเงิน</h2>
    </div>
    <div class="containwd  mt-4 p-2 pt-0">
        <div class="row m-0">
            <div class="col-lg-6 col-md-6 col-sm-12 p-0 centerleftct">
                <div class="detailwd">
                    <table align="center">
                        <tbody>
                            <tr>
                                <td>
                                    <img src="<?= base_url() ?>assets/images/bank/<?= $formatter->bank_icon_format(session()->bankid) ?>.svg">
                                </td>
                                <td>
                                    <?= lang('Lang.withdraw.bank_name', [$formatter->bank_name_format(session()->bankid)]) ?> <br>
                                    <span><?= lang('Lang.withdraw.bank_account_number', [session()->bankno]) ?></span><br>
                                    <?= lang('Lang.withdraw.username', [session()->name]) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 p-0">
                <div class="containinputwd">
                    <form @submit="submit">
                        <div class="headerinput"><span>รายละเอียดการถอน</span></div>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="text-align:start;">
                                        <?= lang('Lang.withdraw.withdrawable_amount') ?>
                                    </td>
                                    <td style="text-align: end;">
                                        <?= lang('Lang.withdraw.minimum_withdrawal') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:start;">
                                        <?= number_to_currency(session()->webbalance, 'THB', 'th', 2); ?>
                                    </td>
                                    <td style="text-align: end;">
                                        <?= number_to_currency(50, 'THB', 'th', 2); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="porela" style="margin-top: 15px;">
                                            <label for="exampleInputEmail1"><?= lang('Lang.withdraw.withdraw_amount') ?></label>
                                            <input type="text" name="withdraw_amount" v-model="form.withdraw_amount" class="inputstyle" placeholder="฿ 0.00">
                                            <p v-if="errors.withdraw_amount" class="error">{{errors.withdraw_amount}}</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="btnwd text-center"><button class="loginbtn"><?= lang('Lang.withdraw.confirm') ?></button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        openTab('wd')
    })

    Vue.createApp({
        data() {
            return {
                errors: {
                    withdraw_amount: ''
                },
                form: {
                    withdraw_amount: ''
                }
            }
        },
        methods: {
            async submit(e) {
                e?.preventDefault()
                this.errors.withdraw_amount = ''
                // validate.
                this.errors.withdraw_amount = this.validatorWithdrawAmount(this.form.withdraw_amount)
                if (!this.errors.withdraw_amount) {
                    let {
                        status,
                        message,
                        data
                    } = await post(`financial/withdraw`, this.form)
                    if (!status) return showAlert.warning(message)
                    return showAlert.success(message, () => {
                        open_link('<?= site_url('history') ?>')
                    }, 1000)
                }
            },
            validatorWithdrawAmount(str) {
                // required 
                if (!str) return `<?= lang('Lang.withdraw.amount_is_required') ?>`
                // not comma
                if (str.search(',') > -1) return `<?= lang('Lang.withdraw.amount_is_not_comma') ?>`
                // digits 
                if (!str.match(/^[0-9]+$/)) return `<?= lang('Lang.withdraw.amount_is_digits') ?>`
                // number
                if (!str.match(/^\d+$/)) return `<?= lang('Lang.withdraw.amount_is_digits') ?>`
                // min 1
                if (Number(str) < 1) return `<?= lang('Lang.withdraw.amount_is_min') ?>`
                // check_credit
                if (Number(str) > Number('<?= session()->webbalance ?>')) return `<?= lang('Lang.withdraw.amount_is_less_than_credit') ?>`
                return ''
            }
        }
    }).mount('#wd')
</script>

<?= $this->endSection() ?>