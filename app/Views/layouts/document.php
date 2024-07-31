<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="<?= esc($title) ?>" />
    <meta name="description" content="<?= esc($description) ?>" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= base_url() ?>" />
    <meta property="og:title" content="<?= esc($title) ?>" />
    <meta property="og:description" content="<?= esc($description) ?>" />
    <meta property="og:image" content="<?= esc($logo) ?>" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="<?= base_url() ?>" />
    <meta property="twitter:title" content="<?= esc($title) ?>" />
    <meta property="twitter:description" content="<?= esc($description) ?>" />
    <meta property="twitter:image" content="<?= esc($logo) ?>" />

    <?php if ($use_meta_tag) : ?>
        <?= $meta_tag ?>
    <?php endif ?>

    <link rel="shortcut icon" type="image/png" href="/favicon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Our Custom CSS -->
    <?= link_tag('/assets/css/style.css?v=1.2a') ?>

    <!-- Loader -->
    <?= link_tag('/assets/css/loader.css?v=1.1c') ?>

    <!-- Utils -->
    <?= script_tag('/assets/js/utils.js?v=1.1c') ?>

    <!-- jQuery CDN -->
    <?= script_tag('/assets/js/vue.js') ?>

    <!-- Day JS -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

    <?php if (isset($use_winwheel) && $use_winwheel) : ?>
        <?= script_tag('/assets/winwheel/TweenMax.min.js') ?>
        <?= script_tag('/assets/winwheel/Winwheel.min.js') ?>
    <?php endif ?>

</head>
<!-- oncontextmenu="return false" -->

<body class="d-flex flex-column h-100" data-aos-easing="ease" data-aos-duration="400" data-aos-delay="0">
    <!-- Loader -->
    <div id="loader-area">
        <div class="loader"></div>
    </div>


    <div class="wrapper">

        <?= $this->renderSection('content') ?>

    </div>

    <div class="lottobtn <?= session()->logged_in ? 'logined' : 'd-none' ?>">
        <a href="/event/lotto" target="_self" rel="noopener noreferrer">
            <img src="<?= base_url() ?>assets/images/lotto.png">
            <span><?= lang('Lang.lotto.title') ?></span>
        </a>
    </div>
    <div class="linebtn <?= session()->logged_in ? 'logined' : '' ?>">
        <a href="<?= $line_link ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?= base_url() ?>assets/images/line.png">
            <span><?= lang('Lang.home.contact_us') ?></span>
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://unpkg.com/jarallax@1/dist/jarallax.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Sweetalert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Hidden form playgame. -->
    <script src="/assets/js/hidden_form.js"></script>

    <script>
        AOS.init({
            once: true
        });
    </script>

</body>

</html>