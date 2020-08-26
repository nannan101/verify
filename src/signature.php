<?php
/**
 * Created by PhpStorm.
 * User: yw
 * Date: 2020/8/25
 * Time: 15:57
 */

namespace Verification;

use Verification\hashids;
use Verification\jwt;

class signature
{
    public $field = "primary_key"; //默认ID,ID必须大于0的数组
    /**
     * 签名
     */
    public function encode($primary_key,$data=null)
    {
        $hashids = new hashids();
        $salt = $hashids->salt($primary_key);
        $primary_key = $hashids->encode($primary_key);
        $data[$this->field] = $primary_key;
        if ($data) {
            $jwt = new jwt();
            $token = $jwt->lssue($data);
        }
        return [
            $this->field => $primary_key,
            'salt' => $salt,
            'token' => $token
        ];

    }

    /**
     * @param $data 数据
     * @param null $salt 前后端约定好的盐值
     */
    public function decode($data, $salt = null)
    {
        try{
            $token = $data['token'];
            if($token){
                $jwt = new jwt();
                $verify = $jwt->verify($token);
                if($verify && is_array($verify))
                {
                    $verify = $verify['data'];
                    $field = $this->field;

                    if(isset($verify->$field) && $primary_key = $verify->$field){
                        $hashids = new hashids();
                        $primary_key = $hashids->decode($primary_key);
                        $primary_key_salt = $hashids->salt($primary_key);
                        $primary_key_result = $hashids->encode($primary_key);
                        if($data['salt'] == $primary_key_salt && $data[$this->field] == $primary_key_result){
                            if($salt){
                                $cvfr = $data['cvfr'];
                                unset($data['cvfr']);
                                $md5veri = md5($primary_key_salt.json_encode($data).$salt);

                                if($md5veri == $cvfr){
                                    return array_merge($data,[$this->field=>$primary_key]);
                                }
                            }else{

                                return array_merge($data,[$this->field=>$primary_key]);
                            }

                        }

                    }

                }
            }
            echo '解密有误';
        }catch (\Exception $e){
            echo '解密错误';
        }

        exit();

    }
}