<?php

require __DIR__ . '/../vendor/autoload.php';

// Folder where the txt files are
$list = $argv[1];
// Folder where the satis.json file will be generated
$satis = $argv[2];
// Url where libs reside, e.g.: ~/Work/Projects/%s/code, https://github.com/%s
$url = $argv[3];

$repos = [];

// Read files in folder
$files = @scandir($list);

if ($files === false) {
    echo "Error reading folder $list\n";
    exit(1);
}

echo sprintf("Will process %s files\n", count($files));

// Loop through files
foreach ($files as $key => $file) {
    // Skip . and ..
    if (in_array($file, ['.', '..'])) {
        continue;
    }

    // Read txt file
    $txt = file_get_contents($list . '/' . $file);
    // Convert content to array
    $lines = explode("\n", $txt);
    // Loop through lines
    foreach ($lines as $name) {
        // Ignore final empty line
        if (empty($name)) {
            continue;
        }

        // Add to repos array
        $repos[] = [
            'name' => $name,
            'url' => sprintf($url, $name)
        ];
    }
}

echo sprintf("Found %s repos\n", count($repos));

// Update last item
$repos[count($repos) - 1]['last'] = true;

$template = file_get_contents(__DIR__ . '/satis.json.mustache');

$m = new Mustache_Engine(array('entity_flags' => ENT_QUOTES));
$content = $m->render($template, [
    'repos' => $repos,
]);

file_put_contents($satis . '/satis.json', $content);