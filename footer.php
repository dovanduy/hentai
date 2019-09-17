<div class="footer text-center bg-dark">
        <div class="container-fluid">
            <div class="foot-logo"><img src="./img/foot_logo.png" alt=""></div>
            <div class="foot_nav">
                <a class="text-light nav-link d-inline" href="">Phim mới câp nhật</a>
                <a class="text-light nav-link d-inline" href="">Phim bộ hentai</a>
                <a class="text-light nav-link d-inline" href="">Hentai 3d</a>
                <a class="text-light nav-link d-inline" href="">Kho ảnh hentai</a>
            </div>
            <div class="copy">Copyright ©2019 <a class="nav-link d-inline text-light" href="">HentaiVN.Net</a> . All Rights Reserved.</div>
        </div>
    </div>
    <?php wp_footer();?>
    <script>
        jQuery(".dialog1 .box_list span,.dialog2 .box_list span").each(function() {
            jQuery(this).click(function() {
                if (jQuery(this).hasClass("cur")) {
                    jQuery(this).removeClass("cur")
                } else {
                    jQuery(this).addClass("cur")
                }
            })
        });
        jQuery(".dialog3 ul li").each(function() {
            jQuery(this).click(function() {
                jQuery(this).addClass("cur").siblings().removeClass("cur")
            })
        });
        jQuery(".dialog1 .reset,.dialog2 .reset").click(function() {
            jQuery(".dialog1 .box_list span, .dialog2 .box_list span").removeClass("cur")
        })
        jQuery(".subimit_taget1").click(function() {
            var value = []
            jQuery(".dialog1 .box_list span.cur").each(function() {
                var val = jQuery(this).text()
                value.push({
                    val: val
                });
            })
            console.log(value)
            jQuery("#search_dialog, .dialog1").hide()
        })
        jQuery(".subimit_taget2").click(function() {
            var value = []
            jQuery(".dialog2 .box_list span.cur").each(function() {
                var val = jQuery(this).text()
                value.push({
                    val: val
                });
            })
            console.log(value)
            jQuery("#search_dialog, .dialog2").hide()
        })
        jQuery(".close, .close_1").click(function() {
            jQuery("#search_dialog, .dialog1").hide()
        })
        jQuery("#search_1").click(function() {
            jQuery("#search_dialog, .dialog1").show()
        })
        jQuery(".close, .close_2").click(function() {
            jQuery("#search_dialog, .dialog2").hide()
        })
        jQuery("#search_2").click(function() {
            jQuery("#search_dialog, .dialog2").show()
        })
        jQuery("#search_3").click(function() {
            jQuery(".dialog1 .box_list span, .dialog2 .box_list span").removeClass("cur")
        })
        jQuery("#search_4").click(function() {
            if (jQuery(".dialog3").hasClass("hide")) {
                jQuery(".dialog3").removeClass("hide")
            } else {
                jQuery(".dialog3").addClass("hide")
            }

        })
    </script>

<script>
        var swiper1 = new Swiper('.swiper-container-pic', {
            // initialSlide: 1,
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 1,
            },
            effect: 'slide',
            //滑动速度
            freeMode: true,
            speed: 800,
            //滑动方向
            direction: 'horizontal',
            slidesPerView: 5.3,
            spaceBetween: 30,
            centeredSlides: false,
            breakpoints: { //响应布局设置
                767: { //如果屏幕宽度小于<640
                    slidesPerView: 2, //每页显示1个
                    spaceBetween: 5 //每个间距是10
                }
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
</body>
</html>