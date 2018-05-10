<?php

namespace app\index\model;

use think\exception\DbException;
use think\Model;

class Playgrounds extends Model
{
    //
    public static $AVAILABLE = 0;
    public static $CONFLICT = 8;
    protected $pk = 'pgid';
    protected $table = 'playgrounds';
    /**
     * 获取可用的场地信息
     * @return array object
     * @throws DbException
     * fixme
     * */
    public static function getAvailable() {
        return self::all(['pstate' => self::$AVAILABLE]);
    }
    /**
     * 获取可用场地的pgid
     * @return array int 类型
     * @author voidliududu
     * fixme
     * */
    public static function getAvailablePgid() {
        return (new Playgrounds())->where('pstate',self::$AVAILABLE)->column('pgid');
    }
    /**
     * 通过pgid获取timeslice
     * @param $pgid
     * @return array or -1
     * @throws DbException
     * */
    public static function getSameTimeSlicePgid($pgid) {
        $playground = self::get($pgid);
        if ($playground == NULL)
            return -1;
        else{
            $timeslice = $playground->timeslice;
            return (new Playgrounds())->where('pstate',self::$AVAILABLE)->where('timeslice',$timeslice)->column('pgid');
        }
    }
}
