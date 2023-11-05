<?php
    /**
     * The template for displaying the footer
     *
     * Contains the closing of the #content div and all content after.
     *
     * @package qtwp
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     */

    use qtwp\lib\HTML;
    use qtwp\Theme;
?>
<footer>
    <div class="container">
        <div class="wrapper">
            <div class="upper">
                <div class="fcol footer-text"><?php echo Theme::get_settings( 'footer text' ) ?></div>
                <div class="fcol">
                    <?php echo HTML::button_group( ['buttons' => Theme::get_settings( 'footer buttons' )] ) ?></div>
            </div>
            <div class="bottom">
                <div class="wrapper1">
                    <div class="fcol"><?php echo HTML::render_contacts( Theme::get_settings( 'footer contacts' ) ) ?>
                    </div>
                    <div class="fcol"><?php echo HTML::nav_menu( 'footer' ) ?></div>
                </div>
                <div class="wrapper2">
                    <?php echo HTML::render_socials( Theme::get_settings( 'social icons' ) ) ?>
                    <p class="copyright"><?php echo Theme::get_settings( 'copyright' ) ?></p>
                </div>
            </div>
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->


<script>
    window.Userback = window.Userback || {};
    Userback.access_token = '9670|85192|Gw5qPv96AfBgPO1y8PxUO0QkGEDhs01IdajajYQcjg3QabbjNp';
    (function(d) {
        var s = d.createElement('script');s.async = true;
        s.src = 'https://static.userback.io/widget/v1.js';
        (d.head || d.body).appendChild(s);
    })(document);
</script>
</body>


<?php wp_footer()?>

</html>