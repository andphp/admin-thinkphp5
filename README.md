AndPHP.admin 主要针对PHP入门级程序员开发适用，主要特点集成了AUTH多对多权限管理控制，
比较细分明确了 权限控制=》权限节点 、角色=》角色权限、管理员=》角色 的管理结构。

后台布局主要应用了Layuid的简明小清新，还支持5种风格切换、全屏浏览、锁屏等炫酷功能。

相信AndPHP.admin 能让你的后台开发也能舒爽起来，另外补充一点，对于目前大多的共享后台都集成封装了如表单、
列表等主要构件方法，说是为了方便快速布置后台，当对于入门来说，学习成本也是有的，阅读性也有牺牲，仁者见仁吧，
就是想告诉大家AndPHP.admin没有这样做，主要好处，多查阅ThinkPHP5.1及Layui2.x文档根据已有文件基本就能活学应用啦！！
( 打脸了，admin2.0对于FORM\LIST进行了方法集成，但保留了1.0的部分硬编输出，你可以更好的应对，快速的开发！)


//=============
 AndPHP内容管理系统基于ThinkPHP、结合Layui等优秀开源项目开发;
 将包含系统设置，权限管理，模型管理，数据库管理，栏目管理，会员管理，网站功能，模版管理，微信管理等相关模块。


官网在线演示:
 http://andphp.com
 测试账号：test
 测试密码：123456


admin2.0纯净版发布了

ThinkPHP核心框架更新至5.1.12,
精简后台功能模块，极简方便开发者
=）基于后台管理员登录/AUTH权限管理/系统配置及后台FORM、LIST公共方法
=）基于前台用户登录/AUTH权限管理/会员中心（集成积分管理、签到等）基本用户操作属性
=) 集成一键安装，localhost/install/index.php

轻度强迫症的我对代码规范有这一定的要求，所以一定程度上做好了备注标示，目前文档整理中，有问题请进QQ群交流学习！



About，

AndPHP采用ThinkPHP5.15开发，ThinkPHP5.15采用全新的目录结构、架构思想，引入了 很多 的PHP新特性，优化了核心，减少了依赖，实现了真正的惰性加载。 正因为ThinkPHP的 这些新特性， 从而使得ANDPHP的执行速度成倍提高。 UI方面，AndPHP采用了最受欢迎的Layui，Layui用于开发响应式布局、移动设备优先的 WEB 项目。 简洁、直观、强悍的前端开发框架，让ANDPHP的后台界面更加美观，前台布局 更加爽快，开发更迅速、简单。

Tell U,

我们的目标：致力于为个人和中小型企业打造全方位的PHP企业级开发解决方案。 AndPHP,一款基于ThinkPHP5研发的开源免费基础架构，基于AndPHP可以快速的研发各 类应用。 我们的宗旨是给你提供一套持久更新、功能全面、操作便捷供大众使用的内容管理系统 我们希望我们的产品能够让你从繁琐的、复杂的、低效的网站建设和维护中解脱出来！


欢迎加入QQ群聊，让我们一起学习一起成长。

141585583


----

### 版本要求

* php >= 5.6
* Thinkphp 5.1.15

###  nginx 配置

```
server {
        listen        80;
        server_name  admin-thinkphp5.test;   #项目域名
        root   ".../admin-thinkphp5/public"; #项目目录
        #配置PHP的重写规则
        location / {
            #开启目录浏览功能
            #autoindex on;
            #关闭详细文件大小统计，让文件大小显示MB，GB单位，默认为b
            #autoindex_exact_size on;
            #开启以服务器本地时区显示文件修改日期
            #autoindex_localtime on;
            if ( !-e $request_filename) {
                rewrite ^/(.*)$ /index.php/$1 last;
                break;
            } 
        }
        location ~ \.php(.*)$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_param  PATH_INFO  $fastcgi_path_info;
            fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
            include        fastcgi_params;
        }
}

```

### 添加layui分页模板

> ./thinkphp/library/think/paginator/driver/Layui.php

```
<?php
namespace think\paginator\driver;
use think\Paginator;
class Layui extends Paginator
{
  /**
   * 上一页按钮
   * @param string $text
   * @return string
   */
  protected function getPreviousButton($text = "上一页")
  {
    if ($this->currentPage() <= 1) {
      return $this->getDisabledTextWrapper($text);
    }
    $url = $this->url(
      $this->currentPage() - 1
    );
    return $this->getPageLinkWrapper($url, $text);
  }
  /**
   * 下一页按钮
   * @param string $text
   * @return string
   */
  protected function getNextButton($text = '下一页')
  {
    if (!$this->hasMore) {
      return $this->getDisabledTextWrapper($text);
    }
    $url = $this->url($this->currentPage() + 1);
    return $this->getPageLinkWrapper($url, $text);
  }
  /**
   * 页码按钮
   * @return string
   */
  protected function getLinks()
  {
    if ($this->simple)
      return '';
    $block = [
      'first' => null,
      'slider' => null,
      'last'  => null
    ];
    $side  = 3;
    $window = $side * 2;
    if ($this->lastPage < $window + 6) {
      $block['first'] = $this->getUrlRange(1, $this->lastPage);
    } elseif ($this->currentPage <= $window) {
      $block['first'] = $this->getUrlRange(1, $window + 2);
      $block['last'] = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
    } elseif ($this->currentPage > ($this->lastPage - $window)) {
      $block['first'] = $this->getUrlRange(1, 2);
      $block['last'] = $this->getUrlRange($this->lastPage - ($window + 2), $this->lastPage);
    } else {
      $block['first'] = $this->getUrlRange(1, 2);
      $block['slider'] = $this->getUrlRange($this->currentPage - $side, $this->currentPage + $side);
      $block['last']  = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
    }
    $html = '';
    if (is_array($block['first'])) {
      $html .= $this->getUrlLinks($block['first']);
    }
    if (is_array($block['slider'])) {
      $html .= $this->getDots();
      $html .= $this->getUrlLinks($block['slider']);
    }
    if (is_array($block['last'])) {
      $html .= $this->getDots();
      $html .= $this->getUrlLinks($block['last']);
    }
    return $html;
  }
  /**
   * 渲染分页html
   * @return mixed
   */
  public function render()
  {
    if ($this->hasPages()) {
      if ($this->simple) {
        return sprintf(
          '<ul class="pager">%s %s</ul>',
          $this->getPreviousButton(),
          $this->getNextButton()
        );
      } else {
        return sprintf(
          '%s %s %s',
          $this->getPreviousButton(),
          $this->getLinks(),
          $this->getNextButton()
        );
      }
    }
  }
  /**
   * 生成一个可点击的按钮
   *
   * @param string $url
   * @param int  $page
   * @return string
   */
  protected function getAvailablePageWrapper($url, $page)
  {
    return '<a href="' . htmlentities($url) . '" rel="external nofollow" >' . $page . '</a>';
  }
  /**
   * 生成一个禁用的按钮
   *
   * @param string $text
   * @return string
   */
  protected function getDisabledTextWrapper($text)
  {
    return '<a class="layui-laypage-prev" >' . $text . '</a>';
  }
  /**
   * 生成一个激活的按钮
   *
   * @param string $text
   * @return string
   */
  protected function getActivePageWrapper($text)
  {
    return '<span class="layui-laypage-curr"> <em class="layui-laypage-em"></em><em>' . $text . '</em></span>';
  }
  /**
   * 生成省略号按钮
   *
   * @return string
   */
  protected function getDots()
  {
    return $this->getDisabledTextWrapper('...');
  }
  /**
   * 批量生成页码按钮.
   *
   * @param array $urls
   * @return string
   */
  protected function getUrlLinks(array $urls)
  {
    $html = '';
    foreach ($urls as $page => $url) {
      $html .= $this->getPageLinkWrapper($url, $page);
    }
    return $html;
  }
  /**
   * 生成普通页码按钮
   *
   * @param string $url
   * @param int  $page
   * @return string
   */
  protected function getPageLinkWrapper($url, $page)
  {
    if ($page == $this->currentPage()) {
      return $this->getActivePageWrapper($page);
    }
    return $this->getAvailablePageWrapper($url, $page);
  }
}
```