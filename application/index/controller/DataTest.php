<?php

namespace app\index\controller;

use app\index\model\Users;
use think\Controller;
use think\Db;
use think\db\exception\DataNotFoundException;

class DataTest extends Controller
{
    public function index()
    {
        return 'index';
    }

    public function getLastSql()
    {
        // 获取最后一条sql语句
        return Db::getLastSql();
    }

    // 全部字段，一维数组
    public function getOne()
    {
        // 获取1条结果，limit 1
        $data = Db::table('tp_users')->find();
        // 通过where指定条件，并获取1条结果，无数据返回null对象
        $data = Db::table('tp_users')->where('id', 2)->find();
        try {
            // 以异常的形式，处理返回null的情况(DataNotFoundException)
            $data = Db::table('tp_users')->where('id', 2)->findOrFail();
            return json($data);
        } catch (DataNotFoundException $e) {
            return 'No data return';
        }
        // 以返回空数组的形式，处理返回null的情况
        $data = Db::table('tp_users')->where('id', 666)->findOrEmpty();
    }

    // 数据对象的方式，查询数据，二维数组
    public function getMany()
    {
        // 对象数组的方式，返回数据
        $data = Db::table('tp_users')->select();
        // 获取指定条件数据，无数据返回空数组
        $data = Db::table('tp_users')->where(['id' => 1, 'name' => 'xuwenjie'])->select();
        // 以异常的形式，处理空数组的情况(DataNotFoundException)
        $data = Db::table('tp_users')->where(['id' => 3, 'name' => 'xiaoyueyue'])->selectOrFail();
        // $data = Db::name('user')->select();
        return json($data);
    }

    public function getColumn()
    {
        // 获取指定字段值(from 一条记录 一维数组)
        $data = Db::table('tp_users')->value('name');
        return $data;
    }

    public function getColumns()
    {
        // 获取指定字段值(from 多条记录 二维数组)
        // 返回的一维数组key可以指定
        $data = Db::table('tp_users')->column('name', 'id');
        return json($data);
    }


    public function getData()
    {
        // 将对象先加载到内存中，方便反复调用，避免资源浪费
        $userEntity = Db::name('users');
        $data1 = $userEntity->where('id', 1)->order('id', 'desc')->select();
        // 当同一个对象实例第二次查询时，会保留上一次的链式方法
        // 可以清理上一次的链式操作
        $data2 = $userEntity->removeOption('where')->removeOption('order')->select();
        return json($data2);
    }

    // 数据关系模型的方式(Model)查询数据
    public function getModelData()
    {
        $data = Users::select();
        return json($data);
    }
}
