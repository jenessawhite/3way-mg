<div class="bannerPhoto intro-wrap row" style="background: linear-gradient(0deg, rgba(18,78,120,0.99) 0%, rgba(255,191,0,0.5) 100%), url(<?php the_field('background_image'); ?>) no-repeat fixed;">
  <div class="intro-text col-md-10">
    <?php if ( get_field('main_heading') ) : ?>
      <h1><?php the_field('main_heading'); ?></h1>
    <?php endif; ?>

    <?php if ( get_field('main_content') ) : ?>
      <h5><?php the_field('main_content'); ?></h5>
    <?php endif; ?>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-12" id="recent-slider">
    <?php if ( get_field('slider_shortcode') ):
      $shortcode = get_field('slider_shortcode'); ?>
      <?php echo do_shortcode($shortcode); ?>
    <?php endif; ?>
  </div>
</div>

<div class="row justify-content-center brands py-4">
  <div class="col-12 text-center">
  <h2>
    <?php if ( get_field('brands_heading') ) : ?>
      <?php echo get_field('brands_heading'); ?>
    <?php endif; ?>
  </h2>

  <p>
    <?php if ( get_field('brands_content') ) : ?>
      <?php echo get_field('brands_content'); ?>
    <?php endif; ?>
  </p>

  <div class="row brands-wrap">
    <?php if ( have_rows('brands_list') ) : ?>
      <?php while( have_rows('brands_list') ) : the_row();
        $logo = get_sub_field('logo');
        $link = get_sub_field('link'); ?>

        <div class="col-md-3 brand p-4">
          <a href="<?php echo $link; ?>" target="_blank">
            <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" class="img-fluid">
          </a>
        </div>

      <?php endwhile; ?>
    <?php endif; ?>
  </div>

  </div>
</div>

<div class="row cta" style="background: linear-gradient(0deg, rgba(7,5,0,0.75) 0%, rgba(7,5,0,0.75)), url(<?php the_field('cta_background_image'); ?>) no-repeat fixed center;">
  <div class="intro-text col-6">
    <?php if ( get_field('cta_heading') ) : ?>
      <h2><?php the_field('cta_heading'); ?></h2>
    <?php endif; ?>

    <?php if ( get_field('cta_button_link') ) : ?>
      <a class="btn btn-primary" href="<?php the_field('cta_button_link'); ?>">
        <?php the_field('cta_button_text'); ?>
      </a>
    <?php endif; ?>
  </div>
</div>
