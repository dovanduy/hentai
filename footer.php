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
</body>
</html>