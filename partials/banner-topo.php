<?php
  while (have_posts()) : the_post();
  
    if (has_post_thumbnail()) : ?>
      <div class="banner-topo">
        <div class="banner-topo-image" style="background-image: url('<?= get_the_post_thumbnail_url(null, 'full'); ?>');">
        </div>
      </div>
    <?php endif;
  endwhile;
  ?>