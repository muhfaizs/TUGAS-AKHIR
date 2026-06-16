<?php
$file = 'resources/views/vendor/pagination/tailwind.blade.php';
$content = file_get_contents($file);
$content = preg_replace('/dark:[^\s\"]+/', '', $content);
file_put_contents($file, $content);
echo "Done";
