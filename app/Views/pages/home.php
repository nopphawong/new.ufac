<?= $this->extend("layouts/lobby") ?>

<?= $this->section("content") ?>

<div id="homepage" class="tabcontent">
    <div class="headertab">
        <h2>เลือกเล่นเกม</h2>
    </div>
    <div class="row m-0 mt-3">
        <div class="col-3 col-sm-2 p-0 px-1">
            <ul class="customgametab nav nav-pills mb-3 text-center " id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-hit-tab" data-toggle="pill" href="#pills-hit" role="tab" aria-controls="pills-hit" aria-selected="true">
                        <img src="/assets/images/icons/icn-hot-checked.png">
                        ยอดนิยม
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-sport-tab" data-toggle="pill" href="#pills-sport" role="tab" aria-controls="pills-sport" aria-selected="false">
                        <img src="/assets/images/icons/icn-sportsbook-check.png">
                        กีฬา
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-Casino-tab" data-toggle="pill" href="#pills-Casino" role="tab" aria-controls="pills-Casino" aria-selected="false">
                        <img src="/assets/images/icons/icon04.png">
                        คาสิโน
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-slot-tab" data-toggle="pill" href="#pills-slot" role="tab" aria-controls="pills-slot" aria-selected="false">
                        <img src="/assets/images/icons/icon05.png">
                        สลอต
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-itpslot-tab" data-toggle="pill" href="#pills-itpslot" role="tab" aria-controls="pills-itpslot" aria-selected="false">
                        <img src="/assets/images/icons/icon05.png">
                        ITP สลอต
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-card-tab" data-toggle="pill" href="#pills-card" role="tab" aria-controls="pills-card" aria-selected="false">
                        <img src="/assets/images/icons/icn-card-checked.png">
                        ไพ่
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-fish-tab" data-toggle="pill" href="#pills-fish" role="tab" aria-controls="pills-fish" aria-selected="false">
                        <img src="/assets/images/icons/icn-fishing-checked.png">
                        ยิงปลา
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-lotto-tab" data-toggle="pill" href="#pills-lotto" role="tab" aria-controls="pills-lotto" aria-selected="false">
                        <img src="/assets/images/icons/icn-lotto-checked.png">
                        หวย
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-esports-tab" data-toggle="pill" href="#pills-esports" role="tab" aria-controls="pills-esports" aria-selected="false">
                        <img src="/assets/images/icons/icn-esports-checked.png">
                        อีสปอร์ต
                    </a>
                </li>
            </ul>
        </div>
        <div id="play_game" class="col-9 col-sm-10 p-0 px-md-3">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="pills-hit" role="tabpanel" aria-labelledby="pills-hit-tab">
                    <div class="gridgame" @click="submit">
                        <div class="ingridgame second">
                            <div class="iningridgame ">
                                <img src="/assets/images/games/hit/11.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/02.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/03.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/04.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/05.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/06.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/07.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/08.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/09.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/10.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/12.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/13.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/14.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/15.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/hit/16.png">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="pills-sport" role="tabpanel" aria-labelledby="pills-sport-tab">
                    <div class="gridgame" @click="submit">
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/sport/01.png">
                            </div>
                        </div>
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/sport/02.png">
                            </div>
                        </div>
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/sport/03.png">
                            </div>
                        </div>
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/sport/04.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-Casino" role="tabpanel" aria-labelledby="pills-Casino-tab">
                    <div class="gridgame" @click="submit">
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/casino/casino01.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/casino/casino02.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/casino/casino03.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/casino/casino04.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/casino/casino05.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/casino/casino06.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-slot" role="tabpanel" aria-labelledby="pills-slot-tab">
                    <div class="gridgame" @click="submit">
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot01.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot02.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot03.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot04.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot05.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot06.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot07.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot08.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot09.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/slot/slot10.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-itpslot" role="tabpanel" aria-labelledby="pills-itpslot-tab">
                    <div class="gridgame" @click="submit">
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/01.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/02.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/03.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/04.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/05.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/06.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/07.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/08.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/09.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/10.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/itpslot/11.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-card" role="tabpanel" aria-labelledby="pills-card-tab">
                    <div class="gridgame" @click="submit">
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/01.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/02.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/03.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/04.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/05.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/06.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/07.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/08.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/09.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/10.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/11.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/12.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/13.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/card/14.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-fish" role="tabpanel" aria-labelledby="pills-fish-tab">
                    <div class="gridgame" @click="submit">
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/01.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/02.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/03.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/04.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/05.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/06.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/07.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/08.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/09.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/10.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/11.png">
                            </div>
                        </div>
                        <div class="ingridgame">
                            <div class="iningridgame">
                                <img src="/assets/images/games/fish/12.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-lotto" role="tabpanel" aria-labelledby="pills-lotto-tab">
                    <div class="gridgame" @click="submit">
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/lotto/01.png">
                            </div>
                        </div>
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/lotto/02.png">
                            </div>
                        </div>
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/lotto/03.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-esports" role="tabpanel" aria-labelledby="pills-esports-tab">
                    <div class="gridgame" @click="submit">
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/esports/01.png">
                            </div>
                        </div>
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/esports/02.png">
                            </div>
                        </div>
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/esports/03.png">
                            </div>
                        </div>
                        <div class="ingridgame third">
                            <div class="iningridgame">
                                <img src="/assets/images/games/esports/04.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const formAction = document.createElement('form')
    $(function() {
        openTab('homepage')
        createHiddenForm('<?= session()->webuser ?>', '<?= session()->webpass ?>')
    })

    Vue.createApp({
        data() {
            return {
                form: {
                    username: '',
                    password: ''
                },
                event: false,
            }
        },
        methods: {
            async submit(e) {
                e?.preventDefault()
                this.username = $('#txtUserName').val()
                this.password = $('#password').val()
                if (this.username == '' || this.password == '') return showAlert.warning(`<?= lang('Lang.home.have_not_user_yet') ?>`)

                // spinner('show')
                // let token = await request_token(`<?= base_url("lobby/ufatoken") ?>`, $(`#form1`).attr(`action`))
                // spinner('hide')
                // if (!token) return showAlert.warning(`<?= lang('Lang.error.something_went_wrong', ["ufa token fail !"]) ?>`)

                $('#form1').submit()
            }
        },
    }).mount('#play_game')
</script>

<?= $this->endSection() ?>