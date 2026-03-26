<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$alumnos = \Illuminate\Support\Facades\DB::table('alumnos')->take(5)->get();
file_put_contents(__DIR__ . '/test_alumnos.json', json_encode($alumnos, JSON_PRETTY_PRINT));
