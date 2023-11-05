<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package qtwp
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 */

get_header();
?>

<section class="page-404">
    <div class="container">
        <div class="wrapper">
            <div class="img-wrapper"><?php print_img('404.png'); ?></div>
            <h1>Looks like the page is on vacation!</h1>
            <div class="btn-grp">
                <a href="<?php echo site_url('/') ?>" class="btn secondary">Back to Home</a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();

