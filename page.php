<?php
get_header();
?>

<main class="conteudo-principal">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_content(); // processa editor e shortcodes ?>
  <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>