<?php
/**
 * Created by PhpStorm.
 * User: yw
 * Date: 2020/8/25
 * Time: 15:24
 */

namespace Verification;

/**
 *
 * PHP将数字ID转化为唯一字符串
 * Class hashids
 * @package Verification
 */

class hashids
{
    public  $salt = "wow_game";
    public  $length = 10;
    /**
     * 加密
     * @param $value
     */
    public function encode($value)
    {
        $hashids = new \Hashids\Hashids($this->salt,$this->length);
        return $hashids->encode($value);

    }

    /**
     * 根据ID产生固定的盐值
     * @param $value
     * @return string
     */
    public function salt($value)
    {
        $hashids = new \Hashids\Hashids($this->salt);
        return md5($hashids->encode($value));
    }

    /**
     * 解密
     * @param $value
     */
    public function decode($value)
    {
        try{
            $hashids = new \Hashids\Hashids($this->salt,$this->length);
            $hashids = $hashids->decode($value);
            if(isset($hashids[0]) && $hashids[0]){
                return $hashids[0];
            }else{
                echo "解密错误";
            }

        }catch (\Exception $e){
            echo '解密错误';
        }
        exit();


    }
}