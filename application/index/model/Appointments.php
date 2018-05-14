<?php

namespace app\index\model;

use think\exception\DbException;
use think\Model;

use \app\common\exception\InsufficientPrivilegesException;
use app\common\exception\TooMuchAppointmentsException;
use app\common\exception\ConflictAppointmentException;

class Appointments extends Model
{
    //
    protected $pk = 'aid';
    protected $table = 'appointments';

    public static $AVAILABLE = 0;
    /**
     * 生成随机口令
     *
     * */
    private static function generateToken($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $token= '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $token;
    }
    /**
     * 获取某天空闲场地
     * @param string date
     * @return array object
     * @throws \think\exception\DbException
     * */
    public static function getAvailable($user,$date) {
        $today = date('Y-m-d');
        $flagDay = strtotime("$today + ".config("max_appointments_time")." day");
        $date_timestamp = strtotime($date);
        if ($date_timestamp > $flagDay) return NULL;
        if ($date_timestamp <= $today ) return NULL;
        $signedAppointments = (new Appointments())->where('adate',$date)->column('pgid');
        $allPgid = Playgrounds::getAvailablePgid();
        //fixme diff
        $availablePgid = array_diff($allPgid,$signedAppointments);
        $userSignedAppointmentsTimeslice = $user->appointments()->where('adate',$date)->column('timeslice');
        $availables = (new Playgrounds())->where('pgid','in',$availablePgid)->select();
        //fixme availables为空
        foreach ($availables as &$available) {
            if (in_array($available->timeslice, $userSignedAppointmentsTimeslice)) {
                $available->pstate = Playgrounds::$CONFLICT;
            }
        }
        return $availables;
    }

    /**
     * 登记一个预约
     * @param object $user
     * @param object $appointment
     * @return string token
     * @throws TooMuchAppointmentsException
     * @throws ConflictAppointmentException
     * @author voidliududu
     * */
    public static function signAppointment($user,$appointment) {
        //todo 检查用户是否认证
        //检查用户的预约数
        if ($user->countAppointments() >= config('max_appointments_count')){
            throw new TooMuchAppointmentsException();
        }
        //检查是否有冲突的预约
//        //fixme date
//        $pgids = Playgrounds::getSameTimeSlicePgid($appointment->pgid);
//        $conflictAppointments = $user->appointments()->where('adate',$appointment->adate)->where('pgid','in',$pgids)->select();
        $conflictAppointments = $user->appointments()
            ->where('adate',$appointment->adate)
            ->where('timeslice',$appointment->timeslice)->select();
        //todo check empty
        if (!empty($conflictAppointments)){
            throw new ConflictAppointmentException();
        }
        $token = self::generateToken();
        $appointment->token = $token;
        $appointment->state = self::$AVAILABLE;
        $time = date('Y-m-d h:i:s');
        $appointment->create_at = $time;
        $appointment->update_at = $time;
        $appointment->save();
        //fixme get insert id
        return $appointment->getLastInsID();
    }

    /**
     * 取消一个预约
     * @param object $user
     * @param object $appointment
     * @throws InsufficientPrivilegesException
     * */
    public static function signoutAppointment($user,$appointment) {
        if ($user->uid != $appointment->uid)
            throw new InsufficientPrivilegesException();
        else{
            $appointment->delete();
        }
    }

    /**
     * 获取一个预约的详细信息
     * @param int $aid
     * @return array | NULL
     * @throws DbException
     * */
    public static function getApInfo($me,$aid) {

        //todo 联表优化
        $appointment = Appointments::get($aid);
        $uid = $appointment->uid;
        if ($uid != $me->uid) {
            return NULL;
        }
        $pgid = $appointment->pgid;
        $user = Users::get($uid);
        $playground = Playgrounds::get($pgid);
        return [
            'aid' => $aid,
            'playground' => $playground->pgname,
            'adate' => $appointment->adate,
            'name' => $user->real_name,
            'schoolnumber' => $user->school_number,
            'token' => $appointment->token,
            'signtime' => $appointment->create_at,
            'astate' => $appointment->state
        ];
    }
}
