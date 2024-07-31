<?= $this->extend('layouts/lobby'); ?>

<?= $this->section('content'); ?>

<!-- lotto section -->
<link href="https://fontawesome.com/v4/assets/font-awesome/css/font-awesome.css" />
<div id="lotto" class="tabcontent">
    <div class="headertab">
        <h2><?= lang('Lang.lotto.title') ?> {{ info?.type ? `${info.type}` : `` }}</h2>
    </div>
    <div v-if="info?.period" class="containprocess " style="margin-top: 10px;">
        <h4 class="text-center"><small class="text-warning"><?= lang('Lang.lotto.period') ?>:</small> {{ info.period ? date_th(info.period) : `-` }}</h4>
        <div class="d-flex" style="justify-content: space-evenly;">
            <h5 v-if="!is_expired(info) && !info.bingo"><small class="text-warning"><?= lang('Lang.lotto.close') ?>:</small> {{ info.expire ? datetime_th(info.expire) : `-` }}</h5>
            <h5 v-else><small class="text-warning"><?= lang('Lang.lotto.bingo') ?>:</small> <span v-if="info.bingo" class="badge bg-success fs-4 p-2">{{ info.bingo }}</span><span v-else class="text-warning"><?= lang('Lang.lotto.wait') ?></span></h5>
            <h5><small class="text-warning"><?= lang('Lang.lotto.point') ?>:</small> {{ parseInt(info.point) || `0` }} <small style="font-size: 12px;"> {{ replace(`<?= lang('Lang.lotto.remark') ?>`, parseInt(info.price)) }}</small></h5>
        </div>
        <div class="p-2"></div>
        <div class="d-flex justify-content-center" v-if="list.length > 1">
            <div class="btn-group">
                <template v-for="(l, i) in list">
                    <button class="btn btn-sm btn-warning active" disabled v-if="l.id == info.id">{{ i + 1 }}</button>
                    <button class="btn btn-dark btn-sm" :disabled="loading" @click="setup_lotto_info(l.id)" v-else>{{ i + 1 }}</button>
                </template>
            </div>
        </div>
        <div class="p-2"></div>
        <div class="d-flex justify-content-center flex-wrap m-0 p-0" style="gap: .5rem;" v-if="info.numbers?.length">
            <template v-for="(n, i) in info.numbers">
                <div class="icon-48px">
                    <button v-if="n.sold == `0`" class="btn btn-dark h-100 w-100" :disabled="loading" @click="number_buy(info.id, n.no)">
                        <b class="m-0">{{ n.no }}</b>
                    </button>
                    <button v-else-if="n.owner == `0`" class="btn bg-transpand d-flex justify-content-center align-items-center h-100 w-100" disabled>
                        <b class="m-0 text-white">{{ n.no }}</b>
                    </button>
                    <button v-else class="btn bg-warning text-dark d-flex justify-content-center align-items-center h-100 w-100 position-relative">
                        <i v-if="info.bingo && info.bingo == n.no" class="fa fa-check-circle position-absolute text-success m-1" style="top: 0; right: 0;"></i>
                        <i v-else-if="info.bingo && info.bingo != n.no" class="fa fa-times-circle position-absolute text-danger m-1" style="top: 0; right: 0;"></i>
                        <b class="m-0">{{ n.no }}</b>
                    </button>
                </div>
            </template>
        </div>
        <div class="p-2"></div>
        <div class="d-flex justify-content-center" v-if="list.length > 1">
            <div class="btn-group">
                <template v-for="(l, i) in list">
                    <button class="btn btn-sm btn-warning active" disabled v-if="l.id == info.id">{{ i + 1 }}</button>
                    <button class="btn btn-dark btn-sm" :disabled="loading" @click="setup_lotto_info(l.id)" v-else>{{ i + 1 }}</button>
                </template>
            </div>
        </div>
        <div class="p-2"></div>
    </div>
    <div v-else-if="loading">
        <h3 class="text-center" style="text-align:center;margin-top: 5rem;font-size: 24px;text-shadow: 3px 3px 10px #000, 0 0 5px #fff, 0 0 10px #fff, 0 0 20px #fff;">Loading...</h3>
    </div>
    <div v-else>
        <h3 class="text-center" style="text-align:center;margin-top: 5rem;font-size: 24px;text-shadow: 3px 3px 10px #000, 0 0 5px #fff, 0 0 10px #fff, 0 0 20px #fff;"><?= lang('Lang.lotto.disable') ?></h3>
    </div>
    <div class="p-1"></div>
    <center><i class="fal fa-history"></i> <?= lang('Lang.lotto.history') ?></center>
    <div class="p-1"></div>
    <div class="containhis">
        <div class="containhislist">
            <div class="containerhis" v-if="history.length">
                <template v-for="h in history">
                    <div class="listht">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="50%" style="padding-top: 7px;">
                                        <div>{{ h.period ? date_th(h.period) : `` }}</div>
                                        <div class="spanofbankhis">{{ h.type }}</div>
                                    </td>
                                    <td width="50%" style="text-align: right; line-height: 20px;">
                                        <div class="statushistory">
                                            <span v-if="!h.bingo" class="badge bg-warning text-dark"><?= lang('Lang.lotto.wait') ?></span>
                                            <span v-else-if="h.bingo == h.no" class="badge bg-success"><?= lang('Lang.lotto.win') ?></span>
                                            <span v-else class="badge bg-danger"><?= lang('Lang.lotto.lose') ?></span>
                                        </div>
                                        <div class="moneyhisdps">
                                            <h5 class="m-0"><small><?= lang('Lang.lotto.number') ?>:</small> <b>{{ h.no }}</b></h5>
                                        </div>
                                        <small style="font-size: 11px;">{{ datetime_th(h.sold_date) }}</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
            </div>
            <div v-else>
                <div style="text-align:center;margin-top: 5rem;font-size: 24px;text-shadow: 3px 3px 10px #000, 0 0 5px #fff, 0 0 10px #fff, 0 0 20px #fff;"><?= lang('Lang.history.no_history') ?></div>
            </div>
            <!-- End Loop หน้าฝากเงิน -------------------------------------------------------------- -->
        </div>
    </div>
</div>
<!-- End lotto section -->

<script>
    $(function() {
        openTab('lotto')
    })

    Vue.createApp({
        data() {
            return {
                loading: false,
                timer: 0,
                list: [],
                info: {},
                history: [],
            }
        },
        methods: {
            async setup_lotto() {
                this.loading = true
                let {
                    status,
                    message,
                    data
                } = await post(`event/lotto/list`, {}, false)
                this.loading = false
                if (!status) return showAlert.warning(message, () => (this.list = []), 2000)
                this.list = [...data || []]
                if (!Object.keys(this.info).length) this.setup_lotto_info(this.list[0]?.id)
            },
            async setup_lotto_info(id) {
                this.loading = true
                let {
                    status,
                    message,
                    data
                } = await post(`event/lotto/info`, {
                    lotto: id
                }, false)
                this.loading = false
                if (!status) return showAlert.warning(message, () => (this.info = {}), 2000)
                this.info = {
                    ...data || {}
                }
            },
            async number_buy(lotto, no) {
                return showConfirm(`<?= lang('Lang.lotto.confirm') ?> <div class="fa-2x text-success">${no}</div>`, async (_f) => {
                    if (!_f.isConfirmed) return
                    this.loading = true
                    let {
                        status,
                        message,
                        data
                    } = await post(`event/lotto/number/buy`, {
                        lotto,
                        no
                    }, false)
                    this.loading = false
                    if (!status) return showAlert.warning(message, null, 2000)
                    return showAlert.success(message, async () => {
                        await this.setup_lotto_info(lotto)
                        await this.setup_history()
                    }, 1000)
                })
            },
            async setup_history() {
                this.loading = true
                let {
                    status,
                    message,
                    data
                } = await post(`event/lotto/history`, {}, false)
                this.loading = false
                if (!status) return showAlert.warning(message, () => (this.history = []), 2000)
                this.history = [...data || []]
            },
            is_expired(info) {
                if (!info) return true
                if (!info.expire) return true
                return info.expire < getNow()
            },
            date_th(date) {
                return date_th(date)
            },
            datetime_th(date) {
                return datetime_th(date)
            },
            replace(str, ...text) {
                if (!str) return ``
                if (!text) return str
                if (!text.length) return str
                for (let i in text) {
                    str = str.replace(`{${i}}`, text[i])
                }
                return str
            },
        },
        async mounted() {
            await this.setup_lotto()
            await this.setup_history()
        }
    }).mount('#lotto')
</script>
<style>
    .lottobtn {
        display: none;
    }
</style>

<?= $this->endSection(); ?>