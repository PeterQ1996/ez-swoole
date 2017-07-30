<?php
include __DIR__ . '/../../../vendor/autoload.php';

$table = new Swoole\Table(10);
$table->column('attr', \Swoole\Table::TYPE_INT,1);
$table->create();

$table->set('one', [
    'attr' => 1
]);
$table->set('two', [
    'attr' => 1
]);
$table->set('three', [
    'attr' => 1
]);
$table->del('two');
foreach ($table as $k => $v){
    dump($k,$v);
}
