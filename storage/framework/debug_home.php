<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
putenv('DB_CONNECTION=mysql');
putenv('DB_HOST=127.0.0.1');
putenv('DB_PORT=3306');
putenv('DB_DATABASE=klinik_gigi');
putenv('DB_USERNAME=root');
putenv('DB_PASSWORD=');
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
echo 'KLINIK_COUNT=' . App\Models\Klinik::query()->count() . PHP_EOL;
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/', 'GET');
$response = $kernel->handle($request);
echo 'STATUS=' . $response->getStatusCode() . PHP_EOL;
echo 'CONTENT_HEAD=' . substr(strip_tags((string) $response->getContent()), 0, 120) . PHP_EOL;
