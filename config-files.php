<?php // vim:set ts=4 sw=4 sts=4 et:

function config($name, $default) {
    $value = getenv($name) ?: $default;
    define($name, $value);
}

?>
