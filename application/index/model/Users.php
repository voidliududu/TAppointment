<?php

namespace app\index\model;

use think\Exception;
use think\Model;

use app\common\exception\DBException;
class Users extends Model
{
    //
    public static $AUTHED = 0;
    public static $UNAUTHED = 1;

    protected $table = 'users';
    protected $pk = 'uid';

    private $historyApcount;
    private $apcount;

    public function __construct($data = [])
    {
        parent::__construct($data);
        //预约次数统计
        //fixme 在0：00时刻有概率出现bug
        $this->apcount = $this->appointments()->where('adate','>=',date('Y-m-d'))->count();
        $this->historyApcount =  $this->appointments()->where('adate','<',date('Y-m-d'))->count();
    }

    /**
     * 关联appointments表
     * */
    public function appointments() {
        return $this->hasMany("Appointments","uid","uid");
    }
    /**
     * 检查是否注册
     * @param int $userid
     * @return bool false or object user
     * @throws \think\exception\DbException
     * */
    public static function checkSignUp($userid) {
        $user = Users::get($userid);
        if ($user == NULL){
            return false;
        }else{
            return $user;
        }
    }
    /**
     * 注册
     * @param Users
     * */
    public static function signUp($user) {
        $user->state = Users::$UNAUTHED;
        $time = date('Y-m-d h:i:s');
        $user->create_at = $time;
        $user->update_at = $time;
        try {
            $user->save();
        }catch (\Exception $e) {
            throw new DBException('用户已注册');
        }
    }
    /**
     * 完善学生信息
     * @param string $school_number  学号
     * @param string $name  姓名
     * @return bool  成功或失败
     * @author voidliududu
     * */
    public function improveInfo($school_number,$name) {
        $this->school_number = $school_number;
        $this->real_name = $name;
        $this->state = self::$AUTHED;
        $result = $this->save();
        if ($result !== false)
            return true;
        else
            return false;
    }

    /**
     * 检查是否已完善信息
     * @return bool 是或否
     * @author voidliududu
     * */
    public function checkImproveInfo() {
        return $this->state == self::$AUTHED;
    }

    /**
     * 检查是否是中南大学学生
     * @return bool
     * @author voidliududu
     * */
    public function is_CSU() {
        return $this->yb_schoolid == config("school_id");
    }
    /**
     * 查询当前预约数
     * @return int
     * @author voidliududu
     * */
    public function countAppointments() {
        return $this->apcount;
    }
    /**
     * 查询历史预约数
     * @return int
     * @author voidliududu
     * */
    public function countHistoryAppointments() {
        return $this->historyApcount;
    }
    /**
     * 查询历史预约信息
     * @return array
     * */
    public function getHistoryAppointments() {
        return $this->appointments()->where('adate','<',date('Y-m-d'))->select();
    }
    /**
     * 查询当前预约信息
     * @return array
     * */
    public function getAppointments() {
        return $this->appointments()->where('adate','>=',date('Y-m-d'))->select();
    }

    /**
     * 获取器
     * */
    public function getApcountAttr() {
        return $this->apcount;
    }
    public function getHistoryApcountAttr() {
        return $this->historyApcount;
    }
}
