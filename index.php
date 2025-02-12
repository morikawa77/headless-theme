<?php

function redirecionar($url)
{
  if (!headers_sent()) {
    header("Location: " . $url, 301);
  } else {
    echo '<script type="text/javascript">';
    echo 'window.location.href = "' . $url . '";';
    echo '</script>';

    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
    echo '</noscript>';
  }

  // Mensagem para casos onde JavaScript está desativado
  echo 'Se você não foi redirecionado, <a href="' . $url . '">clique aqui</a>.';

  // Encerrar a execução do script se necessário
  if ($end) {
    exit();
  }
}

redirecionar(get_option('url_to_redirect'));
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header>
    <?php
    if (has_custom_logo()) {
      the_custom_logo();
    } else {
      echo '<a href="' . home_url() . '">' . get_bloginfo('name') . '</a>';
    }

    wp_nav_menu(array(
      'theme_location' => 'primary',
      'container_class' => 'main-menu'
    )); ?>
  </header>

  <main>
    <?php while (have_posts()) : the_post(); ?>
      <article <?php post_class(); ?>>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
        <?php
        wp_link_pages(array(
          'before' => '<div class="page-links">' . esc_html__('Pages:', 'headless-by-wolfpartners'),
          'after'  => '</div>',
        ));
        ?>
        <?php if (has_tag()) : ?>
          <div class="tags"><?php the_tags('', ' '); ?></div>
        <?php endif; ?>
      </article>

      <?php
      if (comments_open() || get_comments_number()) {
        comments_template();
      }
      ?>

    <?php endwhile; ?>
  </main>

  <?php get_sidebar(); ?>

  <footer>
    <?php
    wp_nav_menu(array(
      'theme_location' => 'footer',
      'container_class' => 'footer-menu'
    ));
    ?>
    <?php wp_footer(); ?>
  </footer>
</body>

</html>