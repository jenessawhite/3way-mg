<?php $classes = array(
  'container',
  'mb-4',
); ?>
<article @php(post_class($classes))>
  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' );?>

  <?php if ( $image ) : ?>
    <header class="row text-center" style="background-image: url(<?php echo $image[0]; ?>)">
    </header>
  <?php endif; ?>

  <div class="entry-content row">
    <h1 class="entry-title col-12 my-3">{{ get_the_title() }}</h1>
    <div class="col-12">
      @php(the_content())
    </div>

    <?php if ( get_field('eventbrite_embed') ) : ?>
      <div class="col-12">
        <?php echo get_field('eventbrite_embed', false, false); ?>
      </div>
    <?php endif; ?>
  </div>
</article>
