@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <article id="event-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="graphic-header my-5">
          <div class="row no-gutters">
            <div class="eventbrite-event-photo">{{the_field('event_featured_image')}}</div>
            <div class="col bg-blue px-4 py-3">
              <div class="row">
                <div class="col-sm-12">
                  <div class="entry-meta">
                    {{the_field('event_date')}}, {{the_field('event_start_time')}} - {{the_field('event_end_time')}}
                  </div>
                </div>
                <div class="col-sm-12">
                  <h2><?php the_title(); ?></h2>
                </div>
                <div class="col-sm-12 description">
                </div>
                <div class="col-sm-12 description">
                  {!!the_field('event_description_short')!!}
                </div>
              </div>
            </div>
          </div>
        </header>
        {!!the_field('event_description_full')!!}
      </article>
    </div>
  </div>
</div>
@endsection