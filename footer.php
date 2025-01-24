<!-- Footer -->
<footer id="footer" class="dark border-0 bg-transparent">
    <div class="container">
        <div class="row mt-5 justify-content-center small">
            <div class="col-10">
                <h5 class="text-contrast-500">Copyrights &copy; 2025 All Rights Reserved by Marinos Efthymiou</h5>
                <p class="text-contrast-300">Your ultimate gaming destination. Discover games, merch, codes, and everything you need to level up your experience.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Include JavaScript files -->
<script src="js/plugins.min.js"></script>
<script src="js/functions.bundle.js"></script>

<script>
    window.addEventListener('pluginSwiperReady', () => {
        var swiperParent = new Swiper('.swiper-parent', {
            slidesPerView: "auto",
            centeredSlides: true,
            spaceBetween: 30,
            navigation: {
                nextEl: ".slider-arrow-right",
                prevEl: ".slider-arrow-left",
            },
            breakpoints: {
                640: { slidesPerView: "auto" },
                768: { slidesPerView: "auto" },
                1024: { slidesPerView: "auto" }
            },
        });
    });
</script>

</body>
</html>
