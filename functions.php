<?php

/**
 * Headless - Theme functions and definitions.
 */

// Adicionar menu de configurações ao painel admin
function headless_theme_add_admin_menu()
{
  add_menu_page(
    __('Configurações do Tema Headless', 'headless-by-wolfpartners'),
    __('Configurações do Tema', 'headless-by-wolfpartners'),
    'manage_options',
    'configuracoes-tema',
    'headless_theme_config_page',
    'dashicons-admin-generic',
    60
  );
}
add_action('admin_menu', 'headless_theme_add_admin_menu');

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
function headless_theme_config_page()
{
  if (!current_user_can('manage_options')) {
    return;
  }
?>
  <div class="wrap">
    <h1><?php esc_html_e('Configurações do Tema Headless', 'headless-by-wolfpartners'); ?></h1>
    <form action="options.php" method="post">
      <?php
      settings_fields('configuracoes-tema-grupo');
      do_settings_sections('configuracoes-tema-grupo');
      ?>
      <table class="form-table">
        <tr>
          <th scope="row"><?php esc_html_e('URL para redirecionamento:', 'headless-by-wolfpartners'); ?></th>
          <td>
            <input type="text"
              name="url_to_redirect"
              value="<?php echo esc_attr(get_option('url_to_redirect')); ?>"
              class="regular-text">
          </td>
        </tr>
      </table>
      <?php submit_button(__('Salvar Configurações', 'headless-by-wolfpartners')); ?>
    </form>
  </div>
<?php
}

function headless_theme_support()
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
    'primary' => __('Menu Principal', 'headless-by-wolfpartners'),
    'footer'  => __('Menu Rodapé', 'headless-by-wolfpartners')
  ));

  load_theme_textdomain('headless-by-wolfpartners', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'headless_theme_support');

// Enfileirar scripts
function headless_theme_scripts()
{
  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'headless_theme_scripts');
