<?php
$dir = __DIR__ . '/compiled_views';
if (!is_dir($dir)) mkdir($dir, 0777, true);
$tmp = $dir . '/abc.tmp';
$dest = $dir . '/abc.php';
file_put_contents($tmp, 'test');
var_dump(file_exists($tmp));
var_dump(@rename($tmp, $dest));
var_dump(error_get_last());
