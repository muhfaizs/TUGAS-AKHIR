<?php
$c = mb_convert_encoding(file_get_contents('old_dashboard.php'), 'UTF-8', 'UTF-16LE');
$start = strpos($c, "view('dashboard.kader"); // Find specific view return
if ($start !== false) {
    echo substr($c, $start - 1000, 1500);
} else {
    echo "NOT FOUND";
}
