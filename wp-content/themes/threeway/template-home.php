<?php
/**
 * Template Name: Home
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content-home', 'page'); ?>
<?php endwhile; ?>
