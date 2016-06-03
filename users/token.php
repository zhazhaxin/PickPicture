<?php

/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/5/31
 * Time: 16:58
 */
class token
{
    private $mmc;
    private $cache_time;   //有效时间

    function __construct()
    {
//        $this->cache_time = 60 * 60 * 24;
//
//        //初始化memcache
//
//        if (defined('PICK_PICTURE')) {
//            $this->mmc = memcache_init();
//        } else {
//            $this->mmc = new memcache;
//            $this->mmc->connect("127.0.0.1", 11211);
//        }
//
//        if ($this->mmc == false){
//            echo "缓存初始化错误";
//            die('Memcache Init Failed');
//        }


    }

    /**
     *  缓存用户的Token及UID
     *  key     用户的Token(随机Hash)
     *  value   用户的身份标识
     */

    public function set_user_token($key, $value)
    {
        $time = $this->cache_time;
        $mmc = $this->mmc;

        memcache_set($mmc, $key, $value, 0, $time);
    }

    /**
     *  通过Token获取用户的身份标识
     *  key        用户的Token(随机Hash)
     * @return    用户的身份标识
     */

    public function get_user_uid($key)
    {
        $mmc = $this->mmc;

        $uid = memcache_get($mmc, $key);

        return $uid;
    }

    /**
     *  延长Token的有效期
     *  key   用户的Token(随机Hash)
     */

    public function prolong_user_token($key)
    {
        $mmc = $this->mmc;

        $uid = memcache_get($mmc, $key);

        //删除老的cache
        $this->delete_user_cache($key);

        //新增新的cache
        $this->set_user_token($key, $uid);
    }

    /**
     *  删除用户的Token缓存
     *  key   用户的Token(随机Hash)
     */

    public function delete_user_cache($key)
    {
        $mmc = $this->mmc;

        memcache_delete($mmc, $key);
    }

    /**
     *  生成一个随机Token
     *  string   字符串
     *  salt     撒盐
     */

    public function get_token($string, $salt = '')
    {
        return substr(md5(md5($string) . 'key' . $salt), 0, 30);
    }
}