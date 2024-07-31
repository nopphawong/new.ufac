<?= $this->extend("layouts/lobby") ?>

<?= $this->section("content") ?>

<div id="promotion" class="tabcontent" style="display: block;">
    <div class="headertab">
        <h2>โปรโมชั่น</h2>
    </div>
    <!-- Swiper -->
    <div class="swiper-container-2">
        <div class="swiper-wrapper">
            <?php if (empty($banners)) : ?>
                <div class="swiper-slide">
                    <img src="<?= site_url("assets/images/default/banner_default.png") ?>">
                </div>
            <?php else : ?>
                <?php foreach ($banners as $banner) : ?>
                    <div class="swiper-slide">
                        <img src="<?= $banner->image ?>" alt="<?= $banner->name ?>" title="<?= $banner->detail ?>">
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev swiper-button-white"></div>
        <div class="swiper-button-next swiper-button-white"></div>
    </div>

</div>

<!-- swiper js -->
<script src="/assets/js/swiper-bundle.min.js"></script>

<script>
    $(function() {
        openTab('promotion')
    })

    var swiper2 = new Swiper('.swiper-container-2', {
        slidesPerView: 'auto',
        centeredSlides: true,
        spaceBetween: 50,
        initialSlide: 1,
        observer: true,
        observeParents: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            dynamicBullets: true,
        },
    })
</script>

<?= $this->endSection() ?>