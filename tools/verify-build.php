<?php

declare(strict_types=1);

$artifact = $argv[1] ?? '';
$metadataPath = $argv[2] ?? '';
if (!is_file($artifact) || !is_file($metadataPath)) {
	throw new RuntimeException('Expected a PHAR and DevTools build metadata');
}

$metadata = json_decode((string) file_get_contents($metadataPath), true, 512, JSON_THROW_ON_ERROR);
if (!is_array($metadata) || ($metadata['success'] ?? false) !== true || ($metadata['tool']['version'] ?? null) !== '1.0.15') {
	throw new RuntimeException('Unexpected DevTools build result');
}
if (($metadata['data']['plugin']['name'] ?? null) !== 'AnonChat' || ($metadata['data']['plugin']['version'] ?? null) !== '1.0.3') {
	throw new RuntimeException('Unexpected plugin identity or version');
}
if (($metadata['data']['dependencies'] ?? null) !== []) {
	throw new RuntimeException('AnonChat must not bundle runtime dependencies');
}
if (hash_file('sha256', $artifact) !== ($metadata['data']['sha256'] ?? null)) {
	throw new RuntimeException('PHAR digest does not match build metadata');
}

$phar = new Phar($artifact);
foreach (['plugin.yml', 'LICENSE', 'src/Main.php', 'resources/config.yml'] as $path) {
	if (!$phar->offsetExists($path)) {
		throw new RuntimeException("Missing PHAR entry: {$path}");
	}
}
$manifest = $phar['plugin.yml']->getContent();
if (preg_match('/^api:[ \t]*5\.0\.0\r?$/m', $manifest) !== 1 || preg_match('/^version:[ \t]*1\.0\.3\r?$/m', $manifest) !== 1) {
	throw new RuntimeException('Unexpected API or plugin version in PHAR');
}
echo "AnonChat PHAR verified\n";
