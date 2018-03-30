<div class="container p-0 contact-page">
  <div class="row">
    <div class="intro-wrap text-center">
      <?php if ( get_field('main_heading') ) : ?>
        <h1><?php echo get_field('main_heading'); ?></h1>
      <?php else: ?>
        <h1>{{ get_the_title() }}</h1>
      <?php endif; ?>

      <?php if ( get_field('content') ) : ?>
        <p><?php echo get_field('content'); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="contact-form-wrap row" style="background: linear-gradient(rgba(7,5,0,0.75), rgba(7,5,0,0.75)), url(<?php the_field('form_background_image'); ?>) no-repeat fixed;">

    <?php if ( get_field('contact_form_shortcode') ):
      $shortcode = get_field('contact_form_shortcode'); ?>
      <?php echo do_shortcode($shortcode); ?>
    <?php endif; ?>

  </div>
</div>

