<?php
namespace app\user\controller;

use app\common\controller\UserController;
use app\common\model\UserCount;
use app\common\model\UserSign;
use app\common\model\UserSign as UserSignModel;
use think\Db;

class Sign extends UserController
{

    protected $uid;

    protected function initialize()
    {
        parent::initialize();
        if(!$this->isLogin()){
            $this->error('亲！请登录', url('user/login/index'));
        }
    }

    public function lists()
    {
        //总榜
        $totallist = (new UserSignModel())->alias('s')->join('user u', 's.uid=u.id', 'LEFT')->field('s.uid,s.id,max(s.days) as days,u.username as username,u.userhead as userhead')->group('s.uid')->order('days desc')->limit(20)->select();
        $time = time();
        $start_create_time = strtotime(date('Y-m-d 0:0:0', $time)) - 1;
        $end_create_time = strtotime(date('Y-m-d 23:59:59', $time)) + 1;
        //今日最快
        $fastlist = (new UserSignModel())->alias('s')->join('user u', 's.uid=u.id')->field('s.*,u.username as username,u.userhead as userhead')->where("s.create_time > $start_create_time and s.create_time < $end_create_time")->order('s.id asc')->limit(20)->select();
        //最新
        $newlist = (new UserSignModel())->alias('s')->join('user u', 's.uid=u.id')->field('s.*,u.username as username,u.userhead as userhead')->order('id desc')->limit(20)->select();

        $this->assign('totallist', $totallist);
        $this->assign('fastlist', $fastlist);
        $this->assign('newlist', $newlist);
        return $this->fetch();
    }

    /**
     * 执行当天签到
     * @return json 签到成功返回 {status:1,info:'已签到'}
     */
    public function sign()
    {
        $todayData = $this->sign_data();
        if ($todayData['is_sign'] == 1) {
            exit('{"code":-1,"msg":"你今天已经签过到了"}');
        }
        $data['days'] = $todayData['days']+1;
        // 无今天数据

        $data['user_id'] = $this->uid;
        $data['sign_time'] = time();
        $id = Db::name('user_sign')->insertGetId($data);

        if ($id) {
            $score = $todayData['score'];
            $msg='签到成功！';
            $explodeDate=explode(',',$this->config['user_sign_date']);
            $randNum = 0;
            if(!empty($explodeDate)){
                foreach($explodeDate as $item){
                    $ex=explode('&',$item);
                    if($ex[0]==date('Y-m-d',time())){
                        $randNum=rand(1,$ex[1]);
                        $scoreName=explode(',',$this->config['point']);
                        $msg=$ex[2].'--您额外获得随机奖励'.$randNum.$scoreName[0].'！';
                        break;
                    }
                }
            }

            $score = $score + $randNum;
            if ($score > 0) {
                // 为该用户添加积分
                if((new UserCount())->where(['user_id'=>$this->uid])->setInc('point',$score)){
                    return array('code'=>200,'score'=>$score,'days'=>$data['days'],'msg'=>$msg);
                }
            }
        }
        exit('{"code":-1,"msg":"签到失败，请刷新后重试！"}');
    }

    /**
     * 用户当天签到的数据
     * @return array 签到信息 is_sign,stime 等
     */
    public function sign_data()
    {
        $signModel = new UserSign();
        $sign_today = $signModel->where('user_id',$this->uid)->whereTime('sign_time','today')->find();
        $sign_yesterday = $signModel->where('user_id',$this->uid)->whereTime('sign_time','yesterday')->order('sign_time','desc')->find();
        $is_sign = 0;
        if($sign_today){
            $is_sign = 1;
            $days = $sign_today['days'];
            $score = $this->getTodayScores($days);
        }elseif($sign_yesterday){
            //今天没有签，看昨天
            $days = $sign_yesterday['days'];
            $score = $this->getTodayScores(intval($days)+1);
        }else {
            //今天第一天
            $days = 0;
            $score = $this->getTodayScores(1);
        }

        return array(
            'is_sign' => $is_sign,
            'days' => $days,
            'score' => $score,
        );
    }

    /**
     * 积分规则，返回连续签到的天数对应的积分
     *
     * @param int $days 当天应该得的分数
     * @return int 积分
     */
    protected function getTodayScores($days)
    {
        $return=0;
        $explode=explode(',',$this->config['user_sign_policy']);
        if(!empty($explode)){
            foreach($explode as $item){
                $ex=explode('&',$item);
                $ex1=explode('<',$ex[0]);
                if($ex1[0]<$days and $days<=$ex1[1]){
                    $return = $ex[1];
                    break;
                }
            }
        }
        return $return;
    }
    public function sign_rule()
    {

        $explode=explode(',',$this->config['user_sign_policy']);
        $rules = array();
        if(!empty($explode)){
            foreach($explode as $key => $item){
                $ex=explode('&',$item);
                $ex1=explode('<',$ex[0]);
                $rules[$key]['days'] = $ex1[1];
                $rules[$key]['score'] = $ex[1];

            }
        }
        return json(array('code' => 200, 'msg' => $rules));
    }


}
