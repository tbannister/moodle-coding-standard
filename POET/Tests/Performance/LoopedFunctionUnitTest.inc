<?php

// This line should be OK.
$DB->get_records('testing');

foreach([1, 2, 3] as $value) {
    // This line should cause a warning.
    $DB->get_records('testing', ['id' => $value]);
}

$i = true;
while ($i) {
    // This line should cause a warning.
    $DB->get_records('testing');
    $i = false;
}

for ($i = 0; $i < 1; $i++) {
    // This line should cause a warning.
    $DB->get_records('testing', ['id' => $i]);
}

$i = true;
do {
    // This line should cause a warning.
    $DB->get_records('testing');
    $i = false;
} while ($i);