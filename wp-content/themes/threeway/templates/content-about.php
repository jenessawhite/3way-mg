<div class="container p-0 about-page">
  <div class="row intro-banner" style="background: linear-gradient(0deg, rgba(255,254,252,0.75) 0%, rgba(255,254,252,0.75)), url(<?php the_field('main_background_image'); ?>) no-repeat fixed;">
    <div class="intro-wrap text-center">
      <?php if ( get_field('main_heading') ) : ?>
        <h1><?php echo get_field('main_heading'); ?></h1>
      <?php else: ?>
        <h1><?php get_the_title(); ?></h1>
      <?php endif; ?>
      <?php if ( get_field('subheading') ) : ?>
        <h5><?php the_field('subheading'); ?></h5>
      <?php endif; ?>

      <?php if ( get_field('content') ) : ?>
        <p><?php echo get_field('content'); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="row team-wrap">
  <?php if( have_rows('team') ): ?>

    <?php while( have_rows('team') ): the_row();
      $side = get_sub_field('info_side');
      $name = get_sub_field('name');
      $image = get_sub_field('image');
      $subheading = get_sub_field('subheading');
      $bio = get_sub_field('bio', false);
      ?>
      <?php if( have_rows('social_links') ): ?>
        <?php while( have_rows('social_links') ): the_row();
          $facebook = get_sub_field('facebook');
          $twitter = get_sub_field('twitter');
          $instagram = get_sub_field('instagram');
          $snapchat = get_sub_field('snapchat');
        ?>
        <?php endwhile; ?>
      <?php endif; ?>

      <?php if ( $side == "right" ) : ?>
        <div class="team-member row m-0">
          <div class="info-wrap col-md-6 order-2 order-md-1">
            <h3><?php echo $name; ?></h3>
            <p><?php echo $subheading; ?></p>
            <hr>

            <p><?php echo $bio; ?></p>
            <div class="social-links-list p-0 m-0">
              <?php if ( $twitter ) : ?>
                <a class="social-icon-link" href="<?php echo $twitter; ?>" target="_blank">
                  <i class="fab fa-twitter social-icon"></i>
                </a>
              <?php endif; ?>

              <?php if ( $instagram ) : ?>
                <a class="social-icon-link" href="<?php echo $instagram; ?>" target="_blank">
                  <i class="fab fa-instagram social-icon"></i>
                </a>
              <?php endif; ?>

              <?php if ( $facebook ) : ?>
                  <a class="social-icon-link" href="<?php echo $facebook; ?>" target="_blank">
                    <i class="fab fa-facebook-f social-icon"></i>
                  </a>
              <?php endif; ?>

              <?php if ( $snapchat ) : ?>
                  <a class="social-icon-link" href="<?php echo $snapchat; ?>" target="_blank">
                    <i class="fab fa-snapchat-ghost social-icon"></i>
                  </a>
              <?php endif; ?>
            </div>
          </div>

          <div class="headshot col-md-6 px-0 order-1 order-md-2">
            <img src="<?php echo $image; ?>" alt="<?php echo $name ?>" class="img-fluid"/>
          </div>
        </div>

        <?php elseif ( $side == "left" ) : ?>
          <div class="team-member row m-0">
            <div class="headshot col-md-6 px-0">
              <img src="<?php echo $image; ?>" alt="<?php echo $name ?>" class="img-fluid"/>
            </div>

            <div class="info-wrap col-md-6 text-right">
              <h3><?php echo $name; ?></h3>
              <p><?php echo $subheading; ?></p>
              <hr>

              <p><?php echo $bio; ?></p>
              <div class="social-links-list p-0 m-0 justify-content-end">
                <?php if ( $twitter ) : ?>
                  <a class="social-icon-link" href="<?php echo $twitter; ?>" target="_blank">
                    <i class="fab fa-twitter social-icon"></i>
                  </a>
                <?php endif; ?>

                <?php if ( $instagram ) : ?>
                  <a class="social-icon-link" href="<?php echo $instagram; ?>" target="_blank">
                    <i class="fab fa-instagram social-icon"></i>
                  </a>
                <?php endif; ?>

                <?php if ( $facebook ) : ?>
                    <a class="social-icon-link" href="<?php echo $facebook; ?>" target="_blank">
                      <i class="fab fa-facebook-f social-icon"></i>
                    </a>
                <?php endif; ?>

                <?php if ( $snapchat ) : ?>
                    <a class="social-icon-link" href="<?php echo $snapchat; ?>" target="_blank">
                      <i class="fab fa-snapchat-ghost social-icon"></i>
                    </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
      <?php endif; ?>

    <?php endwhile; ?>
  <?php endif; ?>
  </div>

  <div class="row cta" style="background: linear-gradient(0deg, rgba(7,5,0,0.75) 0%, rgba(7,5,0,0.75)), url(<?php the_field('cta_background_image'); ?>) no-repeat fixed;">
    <div class="cta-text col-6">
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
</div>