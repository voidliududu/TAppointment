<?php

namespace app\index\controller;

use app\common\exception\ConflictAppointmentException;
use app\common\exception\DBException;
use app\common\exception\InsufficientPrivilegesException;
use app\common\exception\TooMuchAppointmentsException;
use app\index\model\Appointments;
use app\index\model\Playgrounds;
use think\Controller;
use think\Request;
use app\common\Auth;

use app\index\model\Users;
use think\Response;
use think\Session;

class Index extends Controller
{
    private $user;

    public function __construct()
    {
        parent::__construct();
        //1.检查session
        //2.获取验证
        if (!$this->checkAuthPhase()) {
            //拿到user信息
            $userAuth = new Auth();
            if ($userAuth->getAuthState() == Auth::$VERIFY_REQUEST_ERR) {
                //易班与服务器通信错误
                die( "你好，你的队友易班服务器已经打出了gg，我们不能为你提供服务啦 :(");
            } else {
                $userinfo = $userAuth->getAuthInfo();
                //检查用户是否已注册
                $userid = $userinfo['visit_user']['userid'];
                $user = Users::checkSignUp($userid);
                if ($user == false) {
                    if ($userinfo['visit_oauth'] == false) {
                        //引导授权
                        $url = config('api_authorize') . '?client_id=' . config('appid') . '&redirect_uri=' . config('entry_url');
                        $this->redirect($url);
                    }
                    //获取用户详细信息
                    $moreUserInfo = $this->getUserInfo($userinfo['visit_oauth']['access_token']);
                    if ($moreUserInfo == NULL) {
                        die( '获取用户信息失败');
                    }
                    //判断是否是中南大学学生
                    if ($moreUserInfo['yb_schoolname'] != config('school_name')) {
                        die('本系统只向中南大学学生开放');
                    }
                    //注册
                    try {
                        $user = new Users();
                        $user->uid = $userid;
                        $user->yb_name = $moreUserInfo['yb_username'];
                        $user->yb_nickname = $moreUserInfo['yb_usernick'];
                        $user->yb_userhead = $moreUserInfo['yb_userhead'];
                        $user->yb_schoolid = $moreUserInfo['yb_schoolid'];
                        $user->yb_schoolname = $moreUserInfo['yb_schoolname'];
                        $user->state = Users::$UNAUTHED;
                        Users::signUp($user);
                        $user = Users::checkSignUp($userid);
                    } catch (DBException $e) {
                        die('注册失败');
                    }
                }
                //set authphase等操作
                $this->setAuthPhase($user, $userinfo['visit_oauth']);
            }
        }
        //初始化user
        if (isset($user)) {
            $this->user = $user;
        } else {
            $this->user = Users::get(Session::get('uid'));
        }
    }
//    public function __construct(Request $request = null)
//    {
//        parent::__construct($request);
//        $this->user = Users::get(10389276);
//
//    }

    /**
     * 显示用户主页
     *
     * */
    public function index(Request $request)
    {
//        if ($this->user->checkImproveInfo()) {
//            return $this->fetch('Index/index');
//        } else{
//            dump($this->user);
//        }
        return $this->fetch('Index/index');
    }

    /**
     * 显示about页面
     * */
    public function about(Request $request, $id)
    {
        if ($id == 1) {
            return $this->fetch("Index/rules");
        } else if ($id == 2) {
            return $this->fetch("Index/about");
        } else if ($id == 3) {
            return $this->fetch("Index/feedback");
        } else if ($id == 4) {
            return $this->fetch("Index/version");
        }
    }

    /**
     * 显示预约页面
     *
     * */
    public function appointment(Request $request)
    {

    }
    /**
     * 返回用户信息
     * */
    public function fetchUserInfo(Request $request) {
        return $this->jsonSuccess($this->user->append(['apcount','history_apcount']));
    }

    /**
     * 获取可用场地列表的接口
     * @method post
     * @param Request $request
     * @return Response
     * todo
     * */
    public function getAvailable(Request $request)
    {
        if ($request->has('date', 'post')) {
            $queryDate = $request->post('date');
            $rawAvaiable = Appointments::getAvailable($this->user, $queryDate);
            if ($rawAvaiable == NULL) {
                return $this->jsonError(2, 'none available');
            }
            return $this->jsonSuccess($rawAvaiable);
        } else {
            return $this->jsonError(1, 'date required');
        }
    }

    /**
     * 显示当前预约列表
     *
     * */
    public function getAppointmentList(Request $request)
    {
        $result = $this->user->getAppointments();
        if ($result != NULL) {
            return $this->jsonSuccess($result);
        } else {
            return $this->jsonError(1, '列表为空');
        }
    }

    /**
     * 显示历史预约列表
     * */
    public function getHistoryAppointmentList(Request $request)
    {
        $result = $this->user->getHistoryAppointments();
        if ($result != NULL) {
            return $this->jsonSuccess($result);
        } else {
            return $this->jsonError(1, '列表为空');
        }
    }

    /**
     * 完善信息的接口
     * */
    public function improveInfo(Request $request)
    {
        if (!$request->post('schoolnumber') || !$request->post('name')) {
            return $this->jsonError(1, "shool number or name required");
        } else {
            $this->user->improveInfo($request->post('schoolnumber'), $request->post('name'));
            return $this->jsonSuccess([]);
        }
    }

    /**
     * 预约的接口
     * @method post
     * @post pgid
     * @post date
     *
     * */
    public function doAppointment(Request $request)
    {
        if (!$request->has('pgid') || !$request->has('date')) {
            return $this->jsonError(1, 'pgid required');
        } else {
            $pgid = $request->post('pgid');
            $date = $request->post(('date'));
            $playground = Playgrounds::get($pgid);
            if ($playground == NULL) {
                return $this->jsonError(2, 'no playground found');
            }
            $ap = new Appointments();
            $ap->uid = $this->user->uid;
            $ap->pgid = $playground->pgid;
            $ap->adate = $date;
            $ap->timeslice = $playground->timeslice;
            try {
                $aid = Appointments::signAppointment($this->user, $ap);
//                $appointment = Appointments::get($aid);
//                return $appointment;
                return $this->jsonSuccess([]);
            } catch (TooMuchAppointmentsException $e) {
                return $this->jsonError(3, '用户预约数已满');
            } catch (ConflictAppointmentException $e) {
                return $this->jsonError(4, '预约冲突');
            } catch (\think\exception\DbException $e) {
                return $this->jsonError(5, '数据库异常');
            }

        }
    }

    /**
     * 取消预约的接口
     * */
    public function withdrawAppointment(Request $request)
    {
        if ($request->has('aid', 'post')) {
            try {
                $appointment = Appointments::get($request->post('aid'));
                Appointments::signoutAppointment($this->user,$appointment);
                return $this->jsonSuccess([]);
            } catch (InsufficientPrivilegesException $e){
                return $this->jsonError(1,'权限不足');
            } catch (\think\exception\DbException $e) {
                return $this->jsonError(2,'取消失败');
            }
        }else{
            return $this->jsonError(3,'aid required');
        }
    }
    /**
     * 获取预约的详细信息
     *
     * */
    public function getApInfo(Request $request) {
        if (!$request->has("aid",'post')) {
            return $this->jsonError(1,"aid required");
        }
        $info = Appointments::getApInfo($this->user,$request->post('aid'));
        if ($info == NULL) {
            return $this->jsonError(2,'权限不足');
        }
        return $this->jsonSuccess($info);
    }

    /**
     * json成功响应
     *
     * */
    private function jsonSuccess($result)
    {
        return json([
            'status' => 0,
            'data' => $result
        ]);
    }

    /**
     * json错误响应的封装
     *
     * */
    private function jsonError($error_code, $error_msg)
    {
        return json([
            'status' => $error_code,
            'msg' => $error_msg
        ]);
    }

    /**
     * 设置session
     * @param Users $user 用户
     * @param array $visit_oauth 用户oauth凭证
     * @author voidliududu
     * */
    private function setAuthPhase($user, $visit_oauth)
    {
        Session::set('uid', $user->uid);
        Session::set('access_token', $visit_oauth['access_token']);
        Session::set('token_expires', $visit_oauth['token_expires']);
    }

    /**
     * 检查AuthPhase
     * @return bool
     * @author voidliududu
     * */
    private function checkAuthPhase()
    {
//        return Session::has('uid') && Session::has('access_token') && Session::has('token_expires');
        return Session::has('uid');
    }

    /**
     * 获取用户详细信息
     * @param string $accessToken
     * @return array
     * @author voidliududu
     * */
    private function getUserInfo($accessToken)
    {
        $ch = curl_init();
        $url = config('api_userinfo') . '?access_token=' . $accessToken;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($statusCode == 200) {
            $res = json_decode($result,true);
            if ($res['status'] == 'success') {
                return $res['info'];
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
}
