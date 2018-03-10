<?php
namespace app\home\controller;

use app\common\controller\IndexBase;
use app\common\model\Module;

class Index extends IndexBase
{
    public function index()
    {
        return $this->fetch();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
