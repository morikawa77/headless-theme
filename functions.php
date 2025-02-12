<?php

/**
 * Headless - Theme functions and definitions.
 */

// Adicionar menu de configurações ao painel admin
function tema_adicionar_menu_admin()
{
  add_menu_page(
    'Configurações do Tema Headless', // Título da página
    'Configurações do Tema Headless',        // Título do menu
    'manage_options',        // Capacidade necessária
    'configuracoes-tema',    // Slug do menu
    'tema_pagina_config',    // Função que renderiza a página
    'dashicons-admin-generic', // Ícone
    60                        // Posição no menu
  );
}
add_action('admin_menu', 'tema_adicionar_menu_admin');

// Registrar as configurações
function tema_registrar_configuracoes()
{
  register_setting(
    'configuracoes-tema-grupo', // Grupo de opções
    'url_to_redirect'        // Nome da opção
  );
}
add_action('admin_init', 'tema_registrar_configuracoes');

// Renderizar a página de configurações
function tema_pagina_config()
{
  // Verificar permissões
  if (!current_user_can('manage_options')) {
    return;
  }
?>
  <div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
      <?php
      settings_fields('configuracoes-tema-grupo');
      do_settings_sections('configuracoes-tema-grupo');
      ?>
      <table class="form-table">
        <tr>
          <th scope="row">Digite aqui a URL para o redirecionamento:</th>
          <td>
            <input type="text"
              name="url_to_redirect"
              value="<?php echo esc_attr(get_option('url_to_redirect')); ?>"
              class="regular-text">
          </td>
        </tr>
      </table>
      <?php submit_button('Salvar Configurações'); ?>
    </form>
  </div>
<?php
}

function meu_tema_setup()
{
  // Suporte básico
  add_theme_support('title-tag');
  add_theme_support('automatic-feed-links');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', array(
    'comment-list',
    'comment-form',
    'search-form',
    'gallery',
    'caption',
    'style',
    'script'
  ));

  // Suporte para blocos
  add_theme_support('wp-block-styles');
  add_theme_support('align-wide');
  add_theme_support('responsive-embeds');

  // Customização
  add_theme_support('custom-logo');
  add_theme_support('custom-header');
  add_theme_support('custom-background');

  // Estilos do editor
  add_editor_style('editor-style.css');

  // Registrar menus
  register_nav_menus(array(
    'primary' => __('Menu Principal', 'meu-tema'),
    'footer'  => __('Menu Rodapé', 'meu-tema')
  ));
}
add_action('after_setup_theme', 'meu_tema_setup');

// Enfileirar scripts
function meu_tema_scripts()
{
  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'meu_tema_scripts');
