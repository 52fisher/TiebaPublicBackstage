<?php
 return $s = <<<EOF
 <style type="text/css">dt.post .nav_icon{ background: url(http://tb2.bdstatic.com/tb/static-bawu/widget/bawu_aside/img/post_76efb7b.png?__sprite) no-repeat 60% top;}
dt.user .nav_icon{ background: url(http://tb2.bdstatic.com/tb/static-bawu/widget/bawu_aside/img/user_683af71.png?__sprite) no-repeat 60% top;}
dt.data .nav_icon{ background: url(http://tb2.bdstatic.com/tb/static-bawu/widget/bawu_aside/img/data_44990bb.png?__sprite) no-repeat 60% top;}
dt.hr .nav_icon{ background: url(http://tb2.bdstatic.com/tb/static-bawu/widget/bawu_aside/img/hr_187524a.png?__sprite) no-repeat 60% top;}
.page_aside .user_info{ background: none;}
.manager_page .container{ background-image: none!important;}
.manager_page .page_aside{ background: none;}
.nav_section dt:hover, .nav_section.active dt{ background:none; border-left:none; padding: none;}
.nav_section.active{ background:none;}
.nav_section a:hover, .nav_section dd.sub_active a{ color: #d1402f; font-weight: 700;}
.nav_icon{ display: inline-block; width: 60px; height: 40px; position: fixed; text-align: center;}
.nav_s{ position: fixed; background:#fff;}
.nav_s dt{ font-size: 13px; line-height: 100px; border: 1px solid rgba(0,0,0,.1); width: 120px; height: 80px; text-align: center; margin: 0 auto;} .nav_s dt:hover{}
.nav_s dt:hover a{ color:#fe3d58;}
</style>
<aside class="page_aside" id="page_aside"><div class="user_info"><div class="user_info"><h2 style="color:white;">吧务公开后台</h2><p style="color:white;">所在吧：{$this->config['kw']}吧<br>Powered By 投江的鱼</p></div></div><nav class="nav"><dl class="nav_s"><dt class="post"><i class="nav_icon">&nbsp;</i><a href="./listPostLog?word={$this->config['kw']}">贴子管理日志</a></dt><dt class="user"><i class="nav_icon">&nbsp;</i><a href="./listUserLog?word={$this->config['kw']}">用户管理日志</a></dt><dt class="data"><i class="nav_icon">&nbsp;</i><a href="./data?word={$this->config['kw']}">本吧数据统计</a></dt><dt class="hr"><i class="nav_icon">&nbsp;</i><a href="./listBawuLog?word={$this->config['kw']}">吧务管理日志</a></dt></dl></nav></aside>
EOF;
?>