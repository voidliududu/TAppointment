<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    'mock' => 'test/ModelTest/createMockData',
    'clear' => 'test/ModelTest/dropdata',
    'test' => 'test/ModelTest/test',
    'indextest' => 'test/ModelTest/index',
    'testimproveinfo' => ['test/ModelTest/improveInfo',['method' => 'post']],
    'testsignapp' => 'test/ModelTest/makeAppointment',




    'index' => 'index/Index/index',
    'improveinfo' => ['index/Index/improveInfo',['method' => 'post']],
    'getuserinfo' => ['index/Index/fetchUserInfo',['method' => 'get']],
    'getAppointmentInfo' => ['index/Index/getAppointmentList',['method' => 'get']],
    'getHistoryAppointmentInfo' => ['index/Index/getHistoryAppointmentList',['method' => 'get']],
    'appointment' => ['index/Index/doAppointment',['method' => 'post']],
    'getAvaiable' => ['index/Index/getAvailable',['method' => 'post']],
    'getApinfo' => ['index/Index/getApinfo',['method' => 'post']],
    'withdrawAp' => ['index/Index/withdrawAppointment',['method' => 'post']]
];
