<?php
namespace app\index\controller;

use app\index\model\Users;
use think\Controller;
use think\Db;

class DataTest extends Controller
{
    public function index()
    {
        return 'index';
    }

    // 数据对象的方式，查询数据
    public function getDbData(){
        $data = Db::table('tp_users')->select();
        // $data = Db::name('user')->select();
        return json($data);
    }

    // 数据关系模型的方式(Model)查询数据
    public function getModelData()
    {
        $data = Users::select();
        return json($data);
    }
}
?>