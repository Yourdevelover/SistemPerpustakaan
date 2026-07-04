<?php
/**
 * Laravel - A PHP Framework for Web Artisans
 */

$public = __DIR__.'/public/index.php';

if (!file_exists($public)) {
    http_response_code(500);
    echo 'Unable to locate public/index.php. Please upload the Laravel project with the public folder.';
    exit;
}

require $public;
