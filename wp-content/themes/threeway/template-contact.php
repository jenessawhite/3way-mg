<?php
/**
 * Template Name: Contact Us
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content-contact', 'page'); ?>
<?php endwhile; ?>
