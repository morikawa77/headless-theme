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
