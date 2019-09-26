<div class="footer text-center bg-dark">
        <div class="container-fluid">
            <div class="foot-logo"><img src="<?php echo HENTAI_URL.'/img/foot_logo.png';?>" alt="ft-logo"></div>
            <div class="foot_nav">
                <?php
                    $args = [
                        'theme_location'=> 'footer-menu',
                        'container'=>false
                    ];
                    if(has_nav_menu('footer-menu')) {
                        wp_nav_menu($args);
                    }
                   
                ?>
            </div>
            <div class="copy">Copyright ©2019 <a class="nav-link d-inline text-light" href="">HentaiVN.Net</a> . All Rights Reserved.</div>
        </div>
    </div>
    <?php wp_footer();?>
</div>
<?php if(!is_page_template('hentai-search.php')) {?>
    <script>
        jQuery('.btn.my-2.my-sm-0').click(function(e) {
            e.preventDefault();
            var se = jQuery('#s').val();
            if(se.trim() === '') return;
            jQuery('#navbarsExample04 form').submit();
        })
        window.onscroll = function() {
            var offset = window.pageYOffset;
            if(offset > 100) {
                document.querySelector('.header nav.navbar').style.background = '#1d1d1d';
            } else {
                document.querySelector('.header nav.navbar').style.background = 'transparent';
            }
        }
    </script>
<?php } ?>
</body>
</html>