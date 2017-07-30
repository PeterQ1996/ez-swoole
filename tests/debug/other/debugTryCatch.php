<?php

include __DIR__ . "/../../../vendor/autoload.php";

(new TestTry())->test();
class TestTry
{
    public function throwError ()
    {
         throw new Exception('hey, i am an error');
    }

    public function test ()
    {
        try {
            $this->throwError();
        }catch (Throwable $exception){
            dump(1);
            throw $exception;
        } finally {
            dump('finnal');
        }
        dump(2);
    }

}
