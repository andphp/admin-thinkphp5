<?php
namespace app\common\helper;

class Html
{
    private $root;
    private $absroot;
    public $cssDir = '/static';
    public $jsDir = '/static';
    private $cssFile = [];
    private $jsFile = [];
    

    public function __construct()
    {
        $this->root = (substr(request()->root(), -10) != '/index.php' ? request()->root() : substr(request()->root(), 0, -10));
        $this->absroot = (substr(request()->root(true), -10) != '/index.php' ? request()->root(true) : substr(request()->root(true), 0, -10));
    }

    ##加载css文件
    public function css($css, $abs = false)
    {
        if (!$css) {
            return false;
        }
        if (isset($GLOBALS['controller']->params['plugin'])) {
            $this->cssDir = 'plugin/' .  $GLOBALS['controller']->params['plugin'] . '/css';
        }
        $links = '';
        settype($css, 'array');
        $this->cssDir= config('template._view_path').$this->cssDir;
        foreach ($css as $file) {
            $file = strval($file);
            if (strpos($file, 'http://') === false && strpos($file, 'https://') === false) {
                $file_path = sprintf("%s%s%s%s", $abs ? $this->absroot : $this->root, strpos($file, '/') === 0 ? '' : $this->cssDir . '/', $file, $this->getExt($file) == 'css' ? '' : '.css');
            } else {
                $file_path = sprintf("%s%s", $file, $this->getExt($file) == 'css' ? '' : '.css');
            }

            if (in_array($file_path, $this->cssFile)) {
                continue;
            } 
            $this->cssFile[] = $file_path;            
            $links .= "\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"{$file_path}\" />";
        }
        return $links;
    }

    ##加载js文件
    public function script($js, $abs = false)
    {
        if (!$js) {
            return false;
        }
        if (isset($GLOBALS['controller']->params['plugin'])) {
            $this->jsDir = 'plugin/' .  $GLOBALS['controller']->params['plugin'] . '/js';
        }
        $scripts = '';
        settype($js, 'array');
        $this->jsDir= config('template._view_path').$this->jsDir;
        foreach ($js as $file) {
            $file = strval($file);
            if (strpos($file, 'http://') === false && strpos($file, 'https://') === false) {
                $file_path = sprintf("%s%s%s%s", $abs ? $this->absroot : $this->root, strpos($file, '/') === 0 ? '' : $this->jsDir . '/', $file, $this->getExt($file) == 'js' ? '' : '.js');
            } else {
                $file_path = sprintf("%s%s", $file, $this->getExt($file) == 'js' ? '' : '.js');
            }
            if (in_array($file_path, $this->jsFile)) {
                continue;
            } 
            $this->jsFile[] = $file_path;             
            $scripts .= "\r\n<script type=\"text/javascript\" src=\"{$file_path}\"></script>";
        }
        return $scripts;
    }

    private function getExt($file)
    {
        $fileArr = explode('.', $file) ;
        return strtolower(array_pop($fileArr));
    }
}
