<?php
/**
 * Created by PhpStorm.
 * User: liududu
 * Date: 18-5-8
 * Time: 下午12:53
 */

namespace app\common;
use think\Request;
use think\Session;

class Auth
{
    //verify_request 解析错误
    public static $VERIFY_REQUEST_ERR = 0;
    //visit oath 为fasle
    public static $VISIT_OAUTH_FAIL = 1;

    public static $VERIFY_REQUEST_SUCCESS = 2;

    public static $VISIT_OAUTH_SUCCESS = 3;
    //认证信息
    private $authinfo;
    //认证状态
    private $authState;
    //构造函数
    public function __construct()
    {
        $request = Request::instance();
        $this->authState = $this->getVerifiyRequest($request);
    }

    //获取用户验证信息
    private function getVerifiyRequest(Request $request) {
        if ($verify_request = $request->has('verify_request','get')){
            $verify_request = addslashes($verify_request);
            $postStr = pack("H*", $verify_request);
            //$postInfo = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, config("appSecret"), $postStr, MCRYPT_MODE_CBC, config("appID"));
            $postInfo = openssl_decrypt($postStr,'ase-128-cbc',config('appSecret'),OPENSSL_RAW_DATA,config("appID"));
            $postInfo = rtrim($postInfo);
            $this->authinfo = json_decode($postInfo);
            return self::$VERIFY_REQUEST_SUCCESS;
        } else {
            //错误处理
            return self::$VERIFY_REQUEST_ERR;
        }
    }

    //检查用户授权状态
    public function checkOauth() {
        if ($this->authState >= self::$VERIFY_REQUEST_SUCCESS) {
            if($this->authinfo['visit_oauth']) {
                return self::$VISIT_OAUTH_SUCCESS;
            }else{
                return self::$VISIT_OAUTH_FAIL;
            }
        } else{
            return self::$VERIFY_REQUEST_ERR;
        }
    }
    /**
     * 返回认证状态
     * */
    public function getAuthState() {
        return $this->authState;
    }
    /**
     * 返回认证信息
     * @return array
     * */
    public function getAuthInfo() {
        return $this->authinfo;
    }
}