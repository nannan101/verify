<?php
/**
 * Created by PhpStorm.
 * User: yw
 * Date: 2020/8/25
 * Time: 15:02
 */

namespace Verification;

use Firebase\JWT\JWT as FirebaseJWT;

class jwt
{
    public $key = 'wow_game';

    /**
     * @param $data|array
     * @return string
     */
    public function lssue($data)
    {

        $time = time(); //当前时间
        $token = [
            'iss' => 'http://www.xxxxxxxx.net', //签发者 可选
            'aud' => 'http://www.xxxxxxxx.net', //接收该JWT的一方，可选
            'iat' => $time, //签发时间
//        'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
//        'exp' => $time+7200, //过期时间,这里设置2个小时
            'data' =>$data
        ];
        return FirebaseJWT::encode($token,$this->key);
    }
    function verify($jwt)
    {

        try {
//        JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = FirebaseJWT::decode($jwt, $this->key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            return $arr;
        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            echo "签名有误";
        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            echo "签名有误";
        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            echo "签名有误";
        }catch(Exception $e) {  //其他错误
           echo "签名错误";
        }
        exit();
        //Firebase定义了多个 throw new，我们可以捕获多个catch来定义问题，catch加入自己的业务，比如token过期可以用当前Token刷新一个新Token
    }
}