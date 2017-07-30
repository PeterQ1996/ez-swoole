<?php
include __DIR__ . '/../../../vendor/autoload.php';

class Foo {
    public function test () {
        static $_stub = true;
    }
}

$refMethod = new ReflectionMethod(Foo::class, 'test');

dump($refMethod->getStaticVariables());
