<?php

/**
 * W³asny system "LockingSession"
 * por. https://github.com/rairlie/laravel-locking-session/blob/master/src/Rairlie/LockingSession/LockingSessionHandler.php
 *
 */
use \Illuminate\Session\FileSessionHandler;
use Illuminate\Filesystem\Filesystem;

class LockingSessionHandler extends FileSessionHandler {
	
    protected $lock;
    
    public function __construct() 
    {
		$path = Config::get('session.files');

        parent::__construct(new Filesystem, $path);
    }
    public function open($savePath, $sessionName) {
        return parent::open($savePath, $sessionName);
    }
    public function close() {
        return parent::close();
    }
    public function read($sessionId) {
        // Lock the session before reading and hold the lock
        $this->acquireLock($sessionId);
        return parent::read($sessionId);
    }
    public function write($sessionId, $data) {
        $this->acquireLock($sessionId);
        $result = parent::write($sessionId,$data);
        $this->releaseLock();
        return $result;
    }
    public function destroy($sessionId) {
        return parent::destroy($sessionId);
    }
    public function gc($lifetime) {
        $dummy = new Lock('dummy');
        $dummy->gcLockDir($lifetime);
        return parent::gc($lifetime);
    }
    
    protected function acquireLock($id)
    {
        if (!$this->lock) {
            $this->lock = new Lock($id);
        }
        $this->lock->acquire();
    }
    protected function releaseLock()
    {
        $this->lock->release();
        $this->lock = null;
    }
}