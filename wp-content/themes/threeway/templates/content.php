<?php $classes = array(
  'entry',
  'col-12',
  'col-md-10',
  'pb-5',
  'text-center',
  'my-1'
); ?>
<div class="row justify-content-center">
  <article <?php post_class($classes); ?>>
    <header class="graphic-header">
      <div class="row no-gutters">
        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' );?>

        <?php if ( $image ) : ?>
        <div class="col-12 bg-blue px-4 py-3" style="background: linear-gradient(0deg, rgba(18,78,120,.75) 0%, rgba(18,78,120,.75) 100%), url(<?php echo $image[0]; ?>)">
        <?php else : ?>
        <div class="col-12 bg-blue px-4 py-3">
        <?php endif; ?>
          <div class="entry-title">
            <h2><?php the_title(); ?></h2>
          </div>
        </div>
        <div class="col-10 offset-1 mt-2 description">
          <?php the_excerpt(); ?>
        </div>
      </div>
    </header>
  </article>
</div>