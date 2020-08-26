<?php
/**
 * Created by PhpStorm.
 * User: yw
 * Date: 2020/8/25
 * Time: 14:35
 */

include_once 'vendor/autoload.php';


use Verification\signature;

/**
 * 签名
 */

$data = [
    'user_id'=>12,
    'nickname' => '张三',
    'age' => '18',
];
$user_id = 12;
unset($data['user_id']);


$signature = new signature();

$data = array_merge($data,$signature->encode($user_id));

echo '<pre>';

$data['price'] = 10;
$data=array (
    'nickname' => '张三',
    'age' => '18',
    'primary_key' => 'O0qZ8N1Rdb',
    'salt' => '8a99edb331d3dafb153ba1d39a5243b9',
    'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3cueHh4eHh4eHgubmV0IiwiYXVkIjoiaHR0cDpcL1wvd3d3Lnh4eHh4eHh4Lm5ldCIsImlhdCI6MTU5ODM0NTg5NiwiZGF0YSI6eyJwcmltYXJ5X2tleSI6Ik8wcVo4TjFSZGIifX0.gYK3P8LUnQR5I5YXSJToWBByHfAUqk3PyPzCNgRsXnM',
    'price' => 10,
    'cvfr'=>'bd43b54721adaa941e91e53c7d44d173',
);

 $data=$signature->decode($data,'49546');

 var_dump($data);
