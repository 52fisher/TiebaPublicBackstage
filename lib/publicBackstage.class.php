<?php
/**
 *
 * @authors fisher (i@qnmlgb.trade)
 * @date    2019-02-12
 * @version 2.0
 */

class publicBackstage
{
    protected $config = '';
    protected $cookies = '';
    protected $data = '';
    const INDEX = 'http://tieba.baidu.com/bawu2/platform/index?word=';
    const POST = 'http://tieba.baidu.com/bawu2/platform/listPostLog?word=';
    const USER = 'http://tieba.baidu.com/bawu2/platform/listUserLog?word=';
    const DATA = 'http://tieba.baidu.com/bawu2/platform/data?word=';
    const BAWU = 'http://tieba.baidu.com/bawu2/platform/listBawuLog?word=';
    const EXCEL = 'http://tieba.baidu.com/bawu2/platform/dataExcel?word=';

    public function __construct($config)
    {
        $this->config = $config;
        $this->cookies = 'BDUSS=' . $config['bduss'] . ';';
    }
    protected function verify()
    {
        //此处处理公开账号的隐私保护以及账号验权操作

        //处理当前账号担任多吧吧务时的跨吧安全问题
        $querylist = [];
        isset($_SERVER['REQUEST_URI']['query']) ? parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $querylist) : null;
        if (isset($querylist['word']) && $querylist['word'] != $this->config['kw']) {
            $this->showerr();
            die;
        }
        //验证吧务后台口令
        if (!empty($this->config['pwd']) && !$this->verifyToken()) {
            header("Location: /login");
            die;
        }
    }
    protected function showPages()
    {
        $r = $this->data;
        header("Content-type:text/html;charset=GBK");
        if (empty($r)) {
            die('<h2>COOKIE失效或无权限</h2>');
        }
        $this->verify();
        //净化规则
        $replace = [
            '/<div class="user_info">.+?<\/div><nav/' => '<div class="user_info"><div class="user_info"><h2 style="color:white;">吧务公开后台</h2><p style="color:white;">所在吧：' . $this->config['kw'] . '吧<br> Powered By 投江的鱼</p></div></div><nav', //吧标题栏
            '/href="\/(p|home)/' => 'href="http://tieba.baidu.com/\1', //跳转帖子详情页
            '/<img src="\/([^\/])/' => '<img referrerpolicy="no-referrer" src="//tieba.baidu.com/\1', //图片链接
        ];
        //$r = str_replace('<div class="bazhu">', '<div class="bazhu" style="display:none">', $r); //吧主app广告已下线无需净化
        $r = str_replace('/bawu2/platform/', './', $r);
        $r = str_replace('/bawu2/postappeal/', './', $r);
        //路由规则
        if ($this->config['hideopt']) {
            // var_dump("隐藏面板生效");
            $replace['/<label><input.*?value="op_uname"\/>\s*操作人<\/label>/'] = '';
            // 操作人按钮
            $replace['/<a href="#" class="ui_text_normal">[^<]+<\/a>/'] = '<span class="ui_text_normal"><strong>Hidden</strong></span>';
            //操作人列表
            $replace['/操作人<\/strong><\/div><div class="menu_options_list"><div class="options_up_btn j_up disabled">[\w\W]+?<\/div>[\w\W]+?<\/div>[\w\W]+?<\/div>/'] = '操作人</strong></div>';
            //操作人面板
        }
        if($this->config['newNav']){
            $replace['/<aside [\s\S]+<\/aside>/'] = require_once ROOT.'/lib/nav.tpl.php';
        }
        if ($this->config['hidetext']) {
            $replace['/<div\s*class="post_text">.*?<\/div>/'] = '<div class="post_text">根据贴吧相关规定，内容暂不开放查看</div>';
            $replace['/<div\s*class="post_media">.*?<\/div>/'] = '<div class="post_media"></div>';
        } else if ($this->config['showpic']) {
            $replace['/<img src="[^"]+" original="(http:\/\/imgsrc.baidu.com[^"]+)/'] = '<img referrerpolicy="no-referrer" src="\1" style="max-height:75px;"';
            $replace['/<img src="[^"]+" original="(http:\/\/tiebapic.baidu.com[^"]+)/'] = '<img referrerpolicy="no-referrer" src="\1" style="max-height:75px;"';
        }
        foreach ($replace as $k => $v) {
            $r = preg_replace($k, $v, $r);
        }
        echo $r;
    }
    public function urlRoute($path = 'index')
    {
        //功能列表，不需要的功能请直接在数组中注释掉
        $data = ['index', 'data', 'listBawuLog', 'listPostLog', 'listUserLog', 'getpic', 'dataExcel','login'];
        if (!in_array($path, $data)) {
            $this->showerr();
            return;
        }
        $this->$path();
    }
    protected function showerr()
    {
        header("Content-type:text/html;charset=GBK");
        echo '<div  style="margin:15% auto;text-align:center;width:100%"><h1>404.NOT FOUND</h1><h3>你来到了未知领域</h3></div>';
    }
    protected function index()
    {
        $this->cget($this::INDEX . $this->config['kw']);
        $this->showPages();
    }
    protected function dataExcel()
    {
        $this->cget($this::EXCEL . $this->config['kw']);
        header("Content-Type:application/vnd.ms-excel; charset=GBK");
        echo $this->data;
    }
    protected function listBawuLog()
    {
        $this->cget($this::BAWU . $this->config['kw'] . '&' . parse_url($_SERVER['REQUEST_URI'])['query']);
        $this->showPages();
    }
    protected function listPostLog()
    {
        $this->cget($this::POST . $this->config['kw'] . '&' . parse_url($_SERVER['REQUEST_URI'])['query']);
        $this->showPages();
    }
    protected function listUserLog()
    {
        $this->cget($this::USER . $this->config['kw'] . '&' . parse_url($_SERVER['REQUEST_URI'])['query']);
        $this->showPages();
    }
    protected function data()
    {
        $this->cget($this::DATA . $this->config['kw']);
        $this->showPages();
    }
    protected function getpic()
    {
        header("Content-type: image/png");
        preg_match('/url=(.*)/', $_SERVER['REQUEST_URI'], $url);
        $url = empty($url[1]) ? 'http://tb1.bdstatic.com/tb/zt/tengfei/404-error.png' : $url[1];
        $this->cget($url);
        echo $this->data;
    }

    public function verifyPwd($pwd)
    {
        $token = password_hash($pwd,PASSWORD_DEFAULT);
        if (password_verify($this->config['pwd'], $token)) {
            $this->setToken($token);
            return true;
        }
        return false;
    }
    private function setToken($token)
    {
        setcookie('_usertoken', $token, time() + 3600 * 24, '', '', '', true);
    }
    public function verifyToken()
    {
        if (!isset($_COOKIE['_usertoken'])) {
            return false;
        }
        $token = addslashes(trim($_COOKIE['_usertoken']));
        if (password_verify($this->config['pwd'], $token)) {
            return true;
        }
        return false;

    }
    private function login(){
        header("Content-type:text/html;charset=GBK");
        if($this->verifyToken()){
            header("Location: /index");
        }
        require_once ROOT."/lib/login.php";
    }
    protected function cget($url, $cookie = null)
    {
        $cookie = isset($cookie) ? $cookie : $this->cookies;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0', 'Connection:keep-alive', 'Referer:http://wapp.baidu.com/'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        $r = curl_exec($ch);
        curl_close($ch);
        $this->data = $r;
    }
    public function __call($name, $args)
    {
        die('Sorry~');
    }
}
