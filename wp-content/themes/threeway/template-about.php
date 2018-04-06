<?php
/**
 * Template Name: About Us
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content-about', 'page'); ?>
<?php endwhile; ?>
