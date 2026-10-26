<?php
/** Helper - flash, csrf, e() */

function e($s)
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function csrf_token()
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check()
{
    if (($_POST['csrf'] ?? '') !== (csrf_token() ?? '')) {
        http_response_code(419);
        exit('CSRF token tidak valid.');
    }
}

function flash_set($k, $v)
{
    $_SESSION['flash'][$k] = $v;
}

function flash_get($k)
{
    if (isset($_SESSION['flash'][$k])) {
        $v = $_SESSION['flash'][$k];
        unset($_SESSION['flash'][$k]);
        return $v;
    }
    return null;
}

function redirect($path)
{
    header('Location: ' . BASE_URL . $path);
    exit;
}

/** Format angka luas dengan ribuan */
function fmt($n, $dec = 0)
{
    return number_format((float)$n, $dec, ',', '.');
}
