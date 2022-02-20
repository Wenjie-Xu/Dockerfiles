<?php

namespace app\test\controller;

use think\Controller;

class Before extends Controller
{
    protected $flag = true;

    protected $beforeActionList = [
        'first',
        'second' => ['except' => 'one'], // 除了访问one方法调用
        'third' => ['only' => 'one,three'] // 只有访问one和third方法调用
    ];

    // 用来初始化使用，配合$beforeActionList
    protected function first()
    {
        echo 'first</br>';
    }
    protected function second()
    {
        echo 'second</br>';
    }
    protected function third()
    {
        echo 'third</br>';
    }

    public function index()
    {
        if ($this->flag) {
            // 如果不设置URL，那么返回$_SERVER['HTTP_REFERE']
            // (请求头)浏览器告诉服务器是从哪个URL过来的
            $this->success('访问成功', '../');
        } else {
            // 自动返回上一个链接
            $this->error('访问失败');
        }
    }

    // 用来访问
    public function one()
    {
        return 'one';
    }

    public function two()
    {
        return 'two';
    }

    public function _empty($name)
    {
        return $name . '方法不存在';
    }
}
