<?php
include __DIR__ . '/../../../vendor/autoload.php';

class Test {

    protected $data = [
        'y' => 9,
        'z' =>9
    ];

    protected $y =8;

    public $z =10;
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }
    public function returnX(){
        return $this->x;
    }
}

$t = new Test();

$t->x = [1,2];
$t->x[] = 1;
dump($t->x);
dump($t->y);

dump($t->z);

dump($t->returnX());
