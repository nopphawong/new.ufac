<?= $this->extend("layouts/document") ?>

<?= $this->section("content") ?>

<?= $this->include('layouts/header') ?>
<?= $this->renderSection('content') ?>

<div class="myAlert-top alertcopy" style="display: none;">
    <i class="fal fa-check-circle"></i>
    <br>
    <strong>
        คัดลอกเรียบร้อยแล้ว </strong>
</div>

<script type="text/javascript">
    Vue.createApp({
        data() {
            return {
                timer: null,
                balance: '0.00'
            }
        },
        methods: {
            async getLobbyData(preloader = true) {
                let {
                    status,
                    message,
                    data
                } = await post(`lobby`, {}, preloader)
                if (!status) return showAlert.warning(message, (_f) => {
                    if (message == 'token หมดอายุ') {
                        if (!_f.isConfirmed) return
                        location.href = `<?= site_url("logout") ?>`
                    }
                })
                if (data && data.webbalance) {
                    this.balance = data.webbalance
                }
            },
            async getBalance() {
                let {
                    status,
                    message,
                    data
                } = await post(`lobby/balance`)
                if (!status) return showAlert.warning(message)
            },
            async logout(e) {
                e?.preventDefault()
                return showDialog(`<?= lang('Lang.home.confirm_logout') ?>`, `<?= lang('Lang.dialog.confirm_btn') ?>`, `<?= lang('Lang.dialog.cancel_btn') ?>`, 'question', (_f) => {
                    if (!_f.isConfirmed) return
                    location.href = `<?= site_url("logout") ?>`
                })
            },
            async jobDaily() {
                let {
                    status,
                    message
                } = await post(`event/job/daily`, {}, false)
                if (!status) return showAlert.warning(message)
            },
        },
        async mounted() {
            await this.getLobbyData()
            // await this.jobDaily()
            this.timer = setInterval(async () => {
                await this.getLobbyData(false)
                // await this.jobDaily()
            }, 30000)
        },
        async unmounted() {
            this.timer = clearInterval(this.timer)
        }
    }).mount('#header_lobby')

    const openTab = (name) => {
        tabcontent = $('.tabcontent');
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = 'none';
        }
        tablinks = $('.navmenu');
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(' active', '');
        }
        $(`#${name}`).css('display', 'block');
        $(`#nav${name}`).addClass('active');
    }

    function copyClipboard(id) {
        $('.myAlert-top').show()
        const copyText = document.getElementById(id); // Select the text field
        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.innerHTML);
        setTimeout(function() {
            $('.myAlert-top').hide()
        }, 2000)
    }
</script>

<?= $this->include('layouts/nav-menu') ?>
<?= $this->endSection() ?>