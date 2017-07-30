<?php

namespace EzSwoole\SwooleBridge\Wrapper;

use Swoole\Lock;

/**
 * Class RWLock
 * used to wrapper the swoole lock, add a count function
 * Warning, you should not use the lock before the process forked, otherwise, the lock status will be shared too.
 * @package SwPusher\Common
 */
class RWLock
{
    /**
     * @var int
     * used to track locked how many times
     */
    protected $lockNumber = 0;
    /**
     * @var Lock
     */
    protected $realLock;
    protected $IsRealLockWrite = false;
    protected $realLocked = false;

    protected $name;
    public function __construct($name = '')
    {
        $this->realLock = new Lock(SWOOLE_RWLOCK);
        $this->name = $name;
    }

    public function lock ()
    {
        $this->lockNumber++;
        if(!$this->realLocked)// do not has the real lock, lock it
            $this->lockReal();
        else if (!$this->IsRealLockWrite)// has real, need to check the type
            $this->transferLockType();
        return true;
    }

    public function lock_read ()
    {
        $this->lockNumber++;
        if(!$this->realLocked) // if not lock real lock it
            $this->lockRealRead();
        return true;
    }

    public function unlock ()
    {
        if($this->lockNumber == 0)
            throw new \Exception('unlock failed');
        if(--$this->lockNumber === 0)
            $this->unlockReal();
    }

    protected function lockReal ()
    {
        // dump('lock real '. $this->name);
        $this->realLock->lock();
        $this->realLocked = true;
        $this->IsRealLockWrite = true;
    }

    public function unlockReal ()
    {
        // dump('unlock real ' . $this->name);
        if(!$this->realLocked) return;
        $this->realLock->unlock();
        $this->realLocked = false;
        $this->lockNumber = 0;
    }

    protected function lockRealRead ()
    {
        // dump('lock real read ' . $this->name);
        $this->realLock->lock_read();
        $this->realLocked = true;
        $this->IsRealLockWrite = false;
    }

    protected function transferLockType ()
    {
        // dump('transfer lock' . $this->name);
        $this->realLock->unlock();
        $this->realLock->lock();
        $this->IsRealLockWrite = true;
    }
}
