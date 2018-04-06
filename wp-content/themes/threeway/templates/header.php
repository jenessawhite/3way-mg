<header class="container p-0">
  <nav class="navbar row pb-0">
  <!-- navbar-expand-md -->
    <?php
      $image = get_field('nav_logo', 'option');
      if( !empty($image) ): ?>
      <a class="brand" href="<?php echo get_home_url(); ?>">
        <img class="logo img-fluid" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
      </a>
    <?php else: ?>
      <a class="brand" href="<?php echo get_home_url(); ?>"><?php get_bloginfo('name', 'display'); ?></a>
    <?php endif; ?>

    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs4navbar" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->

    <div class="navs-wrap">
      <?php
      wp_nav_menu([
        'menu'            => 'Main Nav',
        'theme_location'  => 'Main Nav',
        'container_id'    => 'bs4navbar',
        // 'container_class' => 'collapse navbar-collapse',
        'menu_id'         => false,
        'menu_class'      => 'navbar-nav',
        'depth'           => 2,
        'fallback_cb'     => 'bs4navwalker::fallback',
        'walker'          => new bs4navwalker()
      ]);
      ?>

      <div class="social-links-list d-none d-lg-inline-flex">
        <?php
          $facebook = get_field('facebook', 'option');
          if( $facebook ): ?>
            <a class="social-icon-link" href="<?php echo $facebook; ?>">
              <i class="fab fa-facebook-f social-icon"></i>
            </a>
        <?php endif; ?>

        <?php
          $instagram = get_field('instagram', 'option');
          if( $instagram ): ?>
            <a class="social-icon-link" href="<?php echo $instagram; ?>">
              <i class="fab fa-instagram social-icon"></i>
            </a>
        <?php endif; ?>

        <?php
          $snapchat = get_field('snapchat', 'option');
          if( $snapchat ): ?>
            <a class="social-icon-link" href="<?php echo $snapchat; ?>">
              <i class="fab fa-snapchat-ghost social-icon"></i>
            </a>
        <?php endif; ?>

        <?php
          $twitter = get_field('twitter', 'option');
          if( $twitter ): ?>
            <a class="social-icon-link" href="<?php echo $twitter; ?>">
              <i class="fab fa-twitter social-icon"></i>
            </a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <hr class="row"/>
</header>
