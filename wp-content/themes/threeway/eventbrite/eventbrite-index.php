<?php $custom_events_args = array (
  'post_type' => 'event',
  'posts_per_page' => -1,
); ?>

<div class="container">
  <div class="row">
    <div class="tmg-events col-12 col-md-10 offset-md-1 text-center">
      <h1 class="page-title"><?php the_title(); ?></h1>
      <?php
        $the_query = new WP_Query( $custom_events_args );
        $event_posts = $the_query->posts; ?>

      <?php if ( class_exists('Eventbrite_Query') ) : ?>
        <?php if ( $the_query->have_posts() ) : ?>
          <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php
              $date = strtotime(get_field('event_date') . get_field('event_start_time'));
              // if current time is greater than the time of the event + 12 hours, skip it
              if (time() > ($date + (12 * 60 * 60))) {
                continue;
              }
            ;?>
            <article class="my-4" data-eventTime="<?php echo $date; ?>">
              <header class="graphic-header">
                <div class="row no-gutters">
                  <div class="eventbrite-event-photo">
                    <img src="<?php the_field('event_featured_image'); ?>" alt="">
                  </div>
                  <div class="col bg-blue px-4 py-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="entry-meta">
                          <span class="event-time"> <?php the_field('event_date'); ?>, <?php the_field('event_start_time'); ?> - <?php the_field('event_end_time') ; ?> </span>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <h2><?php the_title(); ?></h2>
                      </div>
                      <div class="col-sm-12 description">
                      <?php the_field('event_description_short'); ?>
                      </div>
                      <a href="<?php the_permalink(); ?>">See More</a>
                    </div>
                  </div>
                </div>
              </header>
            </article>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>

    <?php
      // Set up and call our Eventbrite query.
      $events = new Eventbrite_Query( apply_filters( 'eventbrite_query_args', array(
        'display_private' => true, // boolean
        'status' => 'live',         // string (only available for display_private true)
        'nopaging' => false,        // boolean
        'limit' => 4,            // integer
        // 'organizer_id' => null,     // integer
        // 'p' => null,                // integer
        // 'post__not_in' => null,     // array of integers
        // 'venue_id' => null,         // integer
        // 'category_id' => null,      // integer
        // 'subcategory_id' => null,   // integer
        // 'format_id' => null,        // integer
      ) ) );

      if ( $events->have_posts() ) :
        while ( $events->have_posts() ) : $events->the_post();
          $eventbrite = eventbrite_event_time();
          $eventbrite_start = explode('-', $eventbrite);
          $eventbrite_date = strtotime($eventbrite_start[0]);
        ?>
        <article id="event-<?php the_ID(); ?>" <?php post_class("tmg-event"); ?> data-eventTime="<?php $eventbrite_date; ?>">
          <header class="graphic-header">
            <div class="row no-gutters">
              <div class="eventbrite-event-photo d-none d-lg-block" ><?php the_post_thumbnail(); ?></div>
              <div class="col bg-blue px-4 py-3">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="entry-meta">
                      <?php eventbrite_event_meta(); ?>
                    </div><!-- .entry-meta -->
                  </div>
                  <div class="col-sm-12">
                    <h2><?php the_title(); ?></h2>
                  </div>
                  <div class="col-sm-12 description">
                    <?php the_content(); ?>
                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">See More</a>
                  </div>
                </div>
              </div>
            </div>

          </header><!-- .entry-header -->

          <div class="entry-content">
            <?php eventbrite_ticket_form_widget(); ?>
          </div><!-- .entry-content -->

          <footer class="entry-footer">
            <?php eventbrite_edit_post_link( __( 'Edit', 'eventbrite_api' ), '<span class="edit-link">', '</span>' ); ?>
          </footer><!-- .entry-footer -->
        </article><!-- #post-## -->

      <?php endwhile;

      // Previous/next post navigation.
        eventbrite_paging_nav( $events );

      endif;

      // Return $post to its rightful owner.
      wp_reset_postdata();
    ?>
    <?php endif; ?>

    <?php if ( get_field('eventbrite_profile', 'option') ) : ?>
      <a href="<?php echo get_field('eventbrite_profile', 'option'); ?>" class="btn btn-secondary mb-4" target="_blank">See All Our Events</a>
    <?php endif; ?>

    </div>
  </div>
</div>
