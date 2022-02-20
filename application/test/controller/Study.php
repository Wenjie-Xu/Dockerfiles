<?php

namespace app\test\controller;

use think\Controller;

class Study extends Controller
{
    // 基类中的初始化方法，调用时，必然会执行（构造方法）
    protected function initialize()
    {
        parent::initialize();
        echo "init function\n"; //不支持return
    }

    public function index($food = 'Apple')
    {
        return 'Eating ' . $food;
    }

    // 返回使用echo和return都一样
    public function test()
    {
        return '测试类';
    }

    // 返回一个数组，必须要转化成数组
    public function arr()
    {
        $data = ['a' => 1, 'b' => 2];
        return json($data);
    }

    public function viewAction()
    {
        return view();
    }
}
