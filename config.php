<?php
/**
 *
 * @authors fisher (i@qnmlgb.trade)
 * @date    2019-02-13
 * @version 2.0
 */
$config = [
	'bduss' => "", //此处输入有后台查看权限吧务的BDUSS
	'kw' => '', //在吧名处填写需要公开吧务后台的贴吧
	'showpic' => true, //boolean值，是否开启图片（不消耗服务器资源），可关闭
	'hideopt' => true, //boolean值，是否隐藏操作人按钮，建议开启（保护操作人隐私）
	'hidetext'=> false, // boolean值，是否展示贴子内容，如果开启则会展示帖子里面的内容
	'newNav'=>false, // 启用新的导航面板，避免暴露接口
	'pwd'=>'',// 进入吧务后台需要验证口令，留空即为不需要口令,可设置动态口令
];
