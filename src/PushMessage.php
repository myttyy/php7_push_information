<?php
namespace myttyy;
use myttyy\Driver\PushDriver;

class PushMessage
{
    private static $link   = null;
    private static $option = [
      // 默认使用企业微信推送
      'driver' => 'WxWork', 
    ];

    /**
     * 获取推送配置
     *
     * @param array|null $option
     */
    public function __construct(?array $option =  []){
      self::$link = new PushDriver();
    
      // 设置配置
      if(function_exists('config')){
        $optionDump = config('push_message');
        if(!empty($optionDump)) {
          self::$option = \array_merge(self::$option,$optionDump);
        }
      }

      if(function_exists('env')){
        $optionDump = env('PUSH_MESSAGE');
        if(!empty($optionDump)) {
          self::$option = \array_merge(self::$option,$optionDump);
        }
      }

      if(!empty($option)){
        self::$option = \array_merge(self::$option,$option);
      }

    }

    public function __call($method, $params)
    {
        if (method_exists(self::$link, $method)) {
            return call_user_func_array([ self::$link, $method ], $params);
        }
    }
    
    /**
     * 允许静态化调用
     *
     * @param [type] $name
     * @param [type] $arguments
     * @return void
     */
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(array(self::$link, $name), $arguments);
    }
}
