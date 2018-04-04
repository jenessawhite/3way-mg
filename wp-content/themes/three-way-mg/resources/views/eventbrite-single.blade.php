@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12 col-md-10 offset-md-1 p-0">
      <h1 class="page-title"><?php the_title(); ?></h1>

      @if( class_exists('Eventbrite_Query') )

      <?php
      // Get our event based on the ID passed by query variable.
      $event = new Eventbrite_Query( array( 'p' => get_query_var( 'eventbrite_id' ) ) );


      if ( $event->have_posts() ) :
        while ( $event->have_posts() ) : $event->the_post(); ?>

        <article id="event-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="graphic-header">
            <div class="row no-gutters">
              <div class="eventbrite-event-photo"><?php the_post_thumbnail(); ?></div>
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

      endif;

        // Return $post to its rightful owner.
      wp_reset_postdata();
      ?>
      @endif

    </div>
  </div>
</div>
@endsection