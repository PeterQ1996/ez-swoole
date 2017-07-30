<?php

namespace EzSwoole\Core\EventSystem;

use EzSwoole\Common\Singleton;

class Driver
{
    use Singleton;

    protected $listenerMap = [];

    protected $processing = [];

    protected $innerListenerDir = __DIR__ . DIRECTORY_SEPARATOR . 'Listener';

    public function fire($event,...$data)
    {
        if($event instanceof BaseEvent)
            $class = get_class($event);
        else $class = $event;
        if(!isset($this->listenerMap[$class]))return;
        if(in_array($class, $this->processing))
            throw new \Exception("the event [{$class}] has been already fired, event stack:" .PHP_EOL. implode('->'.PHP_EOL, $this->processing));
        $this->processing[] = $class;
        try {
            foreach ($this->listenerMap[$class] as $listener){
                if($event instanceof BaseEvent)
                    $listener->handle($event);
                else $listener->handle(...$data);
            }
        } catch (\Throwable $e)
        {
            throw $e;
        } finally {
            array_pop($this->processing);
        }
    }


    public function registerListenerDir($baseDir, $namespace)
    {
        $baseDir = realpath($baseDir);
        // register the event and listener
        foreach (getDirFilesGen($baseDir) as $file) {
            if (!strEndWith($file, '.php')) continue;
            $file = substr($file, strlen($baseDir) + 1);
            $file = substr($file, 0, strlen($file) - 4);
            $sub = implode('\\', explode(DIRECTORY_SEPARATOR, $file));
            $cls = $namespace . '\\' . $sub;
            $instance = $cls::getInstance();
            $event = $instance->getEventName();
            if(!$event)
                $event = (new \ReflectionClass($cls))->getMethod('handle')->getParameters()[0]->getClass()->name;
            if (!isset($this->listenerMap[$event]))
                $this->listenerMap[$event] = [$instance];
            else $this->listenerMap[$event][] = $instance;
        }
    }

    protected function init()
    {
        $this->registerListenerDir($this->innerListenerDir, (new \ReflectionClass($this))->getNamespaceName() . '\\Listener');
    }

    public function has($evtName)
    {
        return isset($this->listenerMap[$evtName]);
    }
}
