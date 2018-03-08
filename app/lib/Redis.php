<?php

namespace Lib;

use Phalcon\Di;
use Phalcon\Http\Response\Exception;

class Redis
{
    private $auth;
    private $authLogger;
    private $apiLogger;
    private $config;
    private $errorLogger;
    private $redis;

    public function __construct($auth = null, $redis = null)
    {
        $this->auth = $auth;
        $this->authLogger = Di::getDefault()->getService("authLogger")->resolve();
        $this->errorLogger = Di::getDefault()->getService("errorLogger")->resolve();
        $this->apiLogger = Di::getDefault()->getService("apiLogger")->resolve();
        $this->config = Di::getDefault()->getService("config")->resolve();
        if(is_null($redis))
        {
            $this->redis = Di::getDefault()->getService("redis")->resolve();
        } else {
            $this->redis = $redis;
        }
    }

    /*
     * @codeCoverageIgnore
     */
    public function set($key, $value, $ex, $ttl)
    {
        try
        {
            $this->redis->set($key, $value, $ex, $ttl);

            return true;
        }
        catch(\Exception $e)
        {
            $this->errorLogger->error("[". $_SERVER['REMOTE_ADDR'] ."] Error while setting $key : {$e->getMessage()}");
            throw new Exception($e->getMessage(), 500);
        }
    }

    /*
     * @codeCoverageIgnore
     */
    public function exists($key)
    {
        try
        {
            return $this->redis->exists($key);
        }
        catch(\Exception $e)
        {
            $this->errorLogger->error("[". $_SERVER['REMOTE_ADDR'] ."] Error while checking if $key exists : {$e->getMessage()}");
            throw new Exception($e->getMessage(), 500);
        }
    }
}
