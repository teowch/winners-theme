<h1 class="slider-comissao-title">Comissão Técnica</h1>
<?php get_template_part('partials/orange-bar'); ?>
<div class="slider-container" id="slider-container">
  <button class="nav-button nav-prev" id="prev">&#10094;</button>
  <div class="slider" id="slider">
    <div class="slide-track" id="slide-track">
      <?php
      $comissao_dir = get_template_directory() . '/assets/images/comissao';
      $comissao_uri = get_template_directory_uri() . '/assets/images/comissao';

      if (is_dir($comissao_dir)) {
        $images = glob($comissao_dir . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
        foreach ($images as $img_path) {
          $img_url = $comissao_uri . '/' . basename($img_path);
          $filename = basename($img_path, '.' . pathinfo($img_path, PATHINFO_EXTENSION));
          
          // Extract name from filename (remove numbers and underscores, format nicely)
          $name = preg_replace('/^\d+_/', '', $filename); // Remove leading numbers and underscore
          $name = str_replace(['-', '_'], ' ', $name); // Replace dashes and underscores with spaces
          $name = ucwords($name); // Capitalize each word
          
          echo '<div class="slide" data-name="' . esc_attr($name) . '"><img src="' . esc_url($img_url) . '" alt="'. esc_attr($name) .'"></div>';
        }
      }
      ?>
    </div>
  </div>
  <button class="nav-button nav-next" id="next">&#10095;</button>
</div>
