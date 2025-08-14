<?php

require_once __DIR__ . '/../vendor/autoload.php';

// php -S 0.0.0.0:80 -t /var/www/tests/fixtures/app/html /var/www/tests/fixtures/app/router.php
// 
// $cmd = sprintf(
//     '%s -S %s:%d -t %s %s',
//     escapeshellarg(PHP_BINARY),
//     $host,
//     $port,
//     escapeshellarg($docroot),
//     escapeshellarg($router)
// );
// 
// $proc = proc_open($cmd, $descriptorSpec, $pipes, dirname(__DIR__));
// if (!is_resource($proc)) {
//     fwrite(STDERR, "Failed to start PHP built-in server.\n");
//     exit(1);
// }
// 
// $deadline = microtime(true) + 5.0; // 5s timeout
// $connected = false;
// do {
//     $fp = @fsockopen($host, $port, $errno, $errstr, 0.2);
//     if ($fp) {
//         fclose($fp);
//         $connected = true;
//         break;
//     }
//     usleep(100_000);
// } while (microtime(true) < $deadline);
// 
// if (!$connected) {
//     fwrite(
//         STDERR,
//         sprintf("PHP server did not start on %s:%d (last error: %s)\n", $host, $port, $errstr ?? 'n/a')
//     );
//     proc_terminate($proc);
//     exit(1);
// }
// 
