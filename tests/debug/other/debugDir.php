<?php
include __DIR__ . '/../../../vendor/autoload.php';

dump(scandir(__DIR__));

dump(getDirFiles(dirname(__DIR__)));

foreach (getDirFilesGen('/home/peterq/dev') as $file)
    dump($file);
