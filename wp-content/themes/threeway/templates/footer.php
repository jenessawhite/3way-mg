<!--Footer-->
<footer class="pt-4 container px-0">
  <!--Footer Links-->
  <div class="container-fluid px-5">
    <hr>
    <div class="row">
      <!--First column-->
      <div class="col-md-3 contact-wrap">
          <?php if ( get_field('address', 'option') ) : ?>
            <address>
              <?php echo get_field('address', 'option'); ?>
            </address>
          <?php endif; ?>

          <?php if ( get_field('phone_number', 'option') ) : ?>
            <p>
              <?php echo get_field('phone_number', 'option'); ?>
            </p>
          <?php endif; ?>

      </div>
      <!--/.First column-->

      <!--Second column-->
      <div class="col-md-6 nav-wrap">
        <?php
          $image = get_field('footer_logo', 'option');
          if( !empty($image) ): ?>
          <a class="brand" href="<?php echo get_home_url(); ?>" target="_blank">
            <img class="logo img-fluid" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
          </a>
        <?php else: ?>
          <a class="brand" href="<?php echo get_home_url(); ?>"><?php get_bloginfo('name', 'display'); ?></a target="_blank">
        <?php endif; ?>

        <?php
          wp_nav_menu([
            'menu'            => 'Main Nav',
            'theme_location'  => 'Main Nav',
            'container' => false,
            'menu_id'         => false,
            'menu_class'      => 'footer-nav p-0 m-0',
            'depth'           => 2,
            'fallback_cb'     => 'bs4navwalker::fallback',
            'walker'          => new bs4navwalker()
          ]);
        ?>
      </div>
      <!--/.Second column-->

      <!--Third column-->
      <div class="col-md-3 social-wrap">
        <?php if ( get_field('social_heading', 'option') ) : ?>
          <?php echo get_field('social_heading', 'option'); ?>
        <?php endif; ?>

        <ul class="social-links-list p-0 m-0">
          <?php
            $facebook = get_field('facebook', 'option');
            if( $facebook ): ?>

              <a class="social-icon-link" href="<?php echo $facebook; ?>" target="_blank">
                <i class="fab fa-facebook-f social-icon"></i>
              </a>

          <?php endif; ?>
          <?php
            $instagram = get_field('instagram', 'option');
            if( $instagram ): ?>

              <a class="social-icon-link" href="<?php echo $instagram; ?>" target="_blank">
                <i class="fab fa-instagram social-icon"></i>
              </a>

          <?php endif; ?>
          <?php
            $snapchat = get_field('snapchat', 'option');
            if( $snapchat ): ?>

              <a class="social-icon-link" href="<?php echo $snapchat; ?>" target="_blank">
                <i class="fab fa-snapchat-ghost social-icon"></i>
              </a>

          <?php endif; ?>
          <?php
            $twitter = get_field('twitter', 'option');
            if( $twitter ): ?>

              <a class="social-icon-link" href="<?php echo $twitter; ?>" target="_blank">
                <i class="fab fa-twitter social-icon"></i>
              </a>

          <?php endif; ?>
        </ul>
      </div>
      <!--/.Third column-->
    </div>
  </div>
  <!--/.Footer Links-->

  <!--Copyright-->
  <div class="footer-copyright py-2 text-center">
    <?php if ( get_field('copyright_text', 'option') ) : ?>
      <span><?php echo get_field('copyright_text', 'option'); ?></span>
    <?php else: ?>
     <span>© <?php auto_copyright("2018"); ?> <?php get_bloginfo('name', 'display'); ?></span>
    <?php endif; ?>
  </div>
  <!--/.Copyright-->
</footer>
<!--/.Footer-->
