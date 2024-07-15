<?= $this->extend("layouts/lobby") ?>

<?= $this->section("content") ?>

<div id="history" class="tabcontent">
    <div class="headertab">
        <h2>ประวัติธุรกรรม</h2>
    </div>
    <div style="text-align: center;">
        <?= lang('Lang.history.show') ?> <span style="color: #3f6747;"><?= lang('Lang.history.deposit') ?></span>/<span style="color: #794a4a;"><?= lang('Lang.history.withdraw') ?></span> <?= lang('Lang.history.ago') ?>
    </div>
    <div class="containhis pb-5">
        <div class="row m-0 mt-3">
            <div class="col-12 p-0 containhislist">
                <div class="containerhis">
                    <div v-if="historiesData.length">
                        <template v-for="item in historiesData">
                            <!--  Loop list history -->
                            <div :class="`${transactionTypeBackground(item.type)}`">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td v-if="item.type == 'ฝาก'">
                                                {{ bankAccountNumberFormat(item.frombank) }}<br>
                                                <span class="timehis">{{ bankNameFormat(item.frombank) }}</span>
                                            </td>
                                            <td v-else>
                                                {{ bankAccountNumberFormat(item.tobank) }}<br>
                                                <span class="timehis">{{ bankNameFormat(item.tobank) }}</span>
                                            </td>
                                            <td>
                                                {{ thBath.format(item.amount) }} <br>
                                                <span class="timehis">{{ item.date }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--  END Loop list DPS -->
                        </template>
                    </div>
                    <div v-else class="nolist">
                        <div><?= lang('Lang.history.no_history') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        openTab('history')
    })

    Vue.createApp({
        setup() {
            const thBath = new Intl.NumberFormat('th-TH', {
                style: 'currency',
                currency: 'THB',
            })
            return {
                thBath
            }
        },
        data() {
            return {
                historiesData: []
            }
        },
        methods: {
            async getHistory() {
                const {
                    status,
                    message,
                    data
                } = await post(`financial/history`)
                if (!status) return showAlert.warning(message)
                this.historiesData = data;
            },
            transactionTypeBackground(type) {
                switch (type) {
                    case 'ฝาก':
                        return 'listht';
                    case 'ถอน':
                        return 'listhtwd';
                    case 'เพิ่มโบนัส':
                        return 'listht';
                    default:
                        return 'listhtwd';
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
                const splitValue = value.split('-')
                if (splitValue.length < 2 && splitValue.length > 3) return '???'
                const strBankNo = splitValue[1]
                strFirst = strBankNo.substr(0, 3)
                strSecond = strBankNo.substr(3, 1)
                strThird = strBankNo.substr(4, 5)
                strFourth = strBankNo.substr(9, 1)

                return `${strFirst}-${strSecond}-${strThird}-${strFourth}`
            },
            transactionStatus(status) {
                switch (status) {
                    case 'Y':
                        return `<?= lang('Lang.history.successful') ?>`;
                    case 'C':
                        return `<?= lang('Lang.history.cancel') ?>`;
                    default:
                        return `<?= lang('Lang.history.pending') ?>`;
                }
            }
        },
        async mounted() {
            await this.getHistory()
        }
    }).mount('#history')
</script>

<?= $this->endSection() ?>