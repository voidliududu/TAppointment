<?php

namespace app\test\controller;

use think\Controller;
use think\Request;
use think\Db;

use \app\index\model\Users;
use \app\index\model\Playgrounds;
use \app\index\model\Appointments;


class ModelTest extends Controller
{


    /**
     * 创建测试数据
     * */
    public function createMockData()
    {
//        //创建用户数据
//        $userNumber = 10;
//        for ($i = 1; $i <= $userNumber; $i++) {
//            $user = new Users();
//            $user->uid = $i;
//            $user->yb_name = $this->generate_password(6);
//            $user->yb_schoolid = random_int(3, 9);
//            $user->yb_schoolname = $this->generate_password(8);
//            $user->state = Users::$UNAUTHED;
//            $user->create_at = date('Y-m-d h:i:s');
//            $user->update_at = date('Y-m-d h:i:s');
//            $user->save();
//        }
        //创建playground数据
        $pnumber = 12;
        for ($i = 1; $i < $pnumber; $i++) {
            $playground = new Playgrounds();
            $playground->pgname = floor($i / 4);
            $playground->timeslice = $i % 4;
            $playground->pstate = Playgrounds::$AVAILABLE;
            $playground->create_at = date('Y-m-d h:i:s');
            $playground->update_at = date('Y-m-d h:i:s');
            $playground->save();
        }
        echo "操作完成";
    }

    public function dropdata()
    {
        Db::table('playgrounds')->where('1 = 1')->delete();
        Db::table('users')->where('1 = 1')->delete();
        echo '操作完成';
    }

    public function generate_password($length = 8)
    {
// 密码字符集，可任意添加你需要的字符
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|";
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

    public function test()
    {
//       $result = Playgrounds::getAvailablePgid();
//       dump($result);

//        $result = Appointments::getAvailable(date('2018-05-10'));
//        $result = json_encode($result);
//        dump($result);

//        $result = Playgrounds::getTimeSlice(3);
//        dump($result);

         echo $this->generateVerifyToken();
    }

    /**
     * 生成verify_token
     * */
    public function generateVerifyToken()
    {
        $str = '{
  "visit_time":0,
  "visit_user":{
    "userid":"2"
  },
  "visit_oauth":false
}';
        $token = openssl_encrypt($str,'aes-128-cbc',config('appSecret'),OPENSSL_RAW_DATA,config('appID'));
        return $token;
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
