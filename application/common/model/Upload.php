<?php
namespace app\common\model;

use app\common\model\SystemConfig as SystemModel;
use org\Http;
use org\Upload as Uploadext;
use think\facade\Cache;
use think\Db;
use think\facade\Request;
use think\Log;
use think\Model;

class Upload extends ModelBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function upfile($type, $filename = 'file', $isthumb = false, $is_water = false,$id=0,$module='admin',$use='admin_thumb')
    {

        // 获取表单上传文件
        $file = request()->file($filename);
        if (!$file) {
            return array('code' => 0, 'msg' => '文件大小超出服务器限制，管理员需要在php.ini中设置post_max_size和upload_max_filesize的值');
        }

        //$filemode = new FileModel();
        $filemode = new Attachment();
        $md5 = $file->hash('md5');
        $n = $filemode->where('md5', $md5)->find();
        if (empty($n)) {
            //本地上传判断条件
            $validate['size'] = 15 * 1024 * 1024;
            $validate['ext'] = 'jpg,gif,png,bmp,rar,zip';

            $sysconfig = Cache::get('site_config');
            if ($sysconfig['open_7niu']) {
                $sys_mode = new SystemModel();

                $q = $sys_mode->where('name', 'qiniu')->find();
                $config = unserialize($q['value']);
                if ($config['allowExt']) {
                    $setting['exts'] = explode(',', $config['allowExt']);
                }
                $setting['maxSize'] = eval("return {$config['maxSize']};");
                $setting['rootPath'] = './';
                $setting['saveName'] = array('uniqid', '');
                $setting['hash'] = true;

                $driverConfig = array(
                    'secrectKey' => $config['SecretKey'],
                    'accessKey' => $config['AccessKey'],
                    'domain' => $config['domain'],
                    'bucket' => $config['bucket'],
                );

                $File = $file->getInfo();
                $Upload = new Uploadext($setting, 'Qiniu', $driverConfig);
                $info = $Upload->uploadOne($File);
                if ($info) {
                    $data['sha1'] = $info['sha1'];
                    $data['md5'] = $info['md5'];
                    $data['create_time'] = time();
                    $data['size'] = $info['size'];
                    $data['name'] = $info['name'];
                    $data['ext'] = $info['ext'];
                    $data['savepath'] = $info['url'];
                    $data['savename'] = $info['savename'];
                    $data['mime'] = $info['type'];
                    $map['md5'] = $info['md5'];
                    $data['location'] = 0;
                    $mmn = $filemode->where($map)->find();
                    if (empty($mmn)) {
                        $filemode->insert($data);
                        $res = $filemode->getLastInsID();
                        if ($res > 0) {
                            return array('code' => 200, 'msg' => '上传成功', 'ext' => $data['ext'], 'id' => $res, 'path' => $data['savepath'], 'headpath' => $data['savepath'], 'md5' => $data['md5'], 'savename' => $data['savename'], 'filename' => $data['name'], 'info' => $info);
                        } else {
                            return array('code' => 0, 'msg' => '上传失败');
                        }
                    } else {
                        return array('code' => 200, 'msg' => '上传成功', 'ext' => $mmn['ext'], 'id' => $mmn['id'], 'path' => $mmn['savepath'], 'headpath' => $mmn['savepath'], 'md5' => $mmn['md5'], 'savename' => $mmn['savename'], 'filename' => $mmn['name'], 'info' => $mmn);
                    }
                } else {
                    return array('code' => 0, 'msg' => $Upload->getError());
                }

            } else {
                $pathname='uploads'. "/" . $module . "/" . $use;
                $info = $file->validate($validate)->rule('date')->move(ROOT_PATH . $pathname);

                if ($info) {


                   // Log::record('savename ' . $info->getSaveName(), 'info');
                    // if($type=='images' && $isthumb = true){
                    //     $path_arr= explode(DS,$info->getSaveName());
                    //     $tmpdir=ROOT_PATH . 'uploads' . DS .'thumb';
                    //     $datedir=$tmpdir.DS.$path_arr[0];
                    //     Log::record('目录 ' . $datedir, 'info');
                    //     if(!is_dir($datedir))
                    //     {
                    //         @mkdir($datedir);
                    //     }
                    //     $smallway=$tmpdir.DS.$info->getSaveName();

                    //     $image=Image::open(request()->file($filename));// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
                    //     $image->thumb(150, 150)->save($smallway);
                    //     $path = DS .'uploads' . DS .'thumb'.DS.$info->getSaveName();
                    // }

                    $path =  input('server.REQUEST_SCHEME') . '://' . input('server.SERVER_NAME').'/'.$pathname .'/'. $info->getSaveName();
                    $realpath =$path;
                    $data['sha1'] = $info->sha1();
                    $data['md5'] = $info->md5();
                    $data['create_time'] = time(); //;

                    $data['ext'] = $info->getExtension();
                    $data['size'] = $info->getSize();
                    $data['savepath'] = $pathname.'/'. $info->getSaveName();//文件路径
                    $data['user_id'] = $id;
                    $data['use'] = $use;
                    if($data['module'] = 'admin') {
                        //通过后台上传的文件直接审核通过
                        $data['status'] = 1;
                        $data['admin_id'] = $data['user_id'];
                        $data['audit_time'] = time();
                    }
                    $data['savename'] = $info->getFilename();
                    $data['download'] = 0;
                    $fileinfo = $info->getInfo();
                    $data['name'] = $fileinfo['name'];
                    $data['mime'] = $fileinfo['type'];
                    $data['uploadip'] = Request::ip();//IP
                    $filemode->insert($data);
                    $res = $filemode->getLastInsID();
                    if ($res > 0) {
                        return array('code' => 200, 'msg' => '上传成功', 'hasscore' => 0, 'ext' => $data['ext'], 'id' => $res, 'path' => $path, 'headpath' => $realpath, 'md5' => $data['md5'], 'savename' => $info->getSaveName(), 'filename' => $info->getFilename(), 'info' => $info->getInfo());
                    } else {
                        return array('code' => 0, 'msg' => '上传失败');
                    }
                } else {
                    return array('code' => 0, 'msg' => $file->getError());
                }
            }

        } else {
            if($n['location']==0){
                $domain = \think\facade\Request::instance()->domain();
                $path=$domain.'/'.$n['savepath'];
            }else{
                $path = $n['savepath'];
            }
            $realpath = $path;
            return array('code' => 200, 'msg' => '上传成功', 'hasscore' => 1, 'ext' => $n['ext'], 'id' => $n['id'], 'path' => $path, 'headpath' => $realpath, 'md5' => $md5, 'savename' => $n['savename'], 'filename' => $n['name'], 'info' => $n);
        }

    }

/**
 * 获得content里的外部资源
 *
 * @access    public
 * @param     string  $content  文档内容
 * @return    string
 */
    public function getCurContent($content)
    {
        //匹配图片地址
        preg_match_all('/((http|https):\/\/)+(\w+\.)+(\w+)[\w\/\.\-]*(jpg|gif|png)/', $content, $img_array);
        //移除重复的Url
        $img_array = array_unique($img_array[0]);
        if ($img_array != '') {
            $imgUrl =  'uploads/' . date("Ymd") . '/';
            $imgPath = ROOT_PATH . $imgUrl;
            $htd = new Http();
            foreach ($img_array as $key => $value) {

                //获取hash
                $md5 = strtolower($htd->getHash($value, true));
                $filemode = Db::name('file');
                $n = $filemode->where('md5', $md5)->find();
                $realpath = '';
                if (empty($n)) {
                    $itype = substr(strrchr($value, '.'), 1);
                    $milliSecondN = md5(microtime(true));

                    $rndFileName = $imgPath . $milliSecondN . '.' . $itype;
                    $fileurl = $imgUrl . $milliSecondN . '.' . $itype;

                    $rs = $htd->http_down($value, $rndFileName);
                    //抓取成功
                    if ($rs) {
                        $path = str_replace("\\", "/", $fileurl);
                        $realpath = WEB_URL . $path;
                        //写入数据库
                        $data['sha1'] = sha1($rndFileName);
                        $data['md5'] = md5($rndFileName);
                        $data['create_time'] = time();
                        $data['size'] = filesize($rndFileName);
                        $data['name'] = $milliSecondN . '.' . $itype;
                        $data['ext'] = $itype;
                        $data['savepath'] = $realpath;
                        $data['savename'] = $milliSecondN . '.' . $itype;
                        $data['mime'] = mime_content_type($rndFileName);

                        Db::name('file')->insert($data);
                    }
                } else {
                    $realpath = $n['savepath'];
                }
                $content = str_replace($value, $realpath, $content);
            }
        }
        return $content;
    }

}
