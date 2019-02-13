## TiebaPublicBackstage

贴吧UEG系统日常发疯删帖，吧务整天被骂背锅，说出来大家都不信。眼见为实耳听为虚，我没有亲眼看见怎么知道是不是你在权限我呢？马上吧务换届，权限狗整天只知道水贴不干事，凭什么我要支持？选出来的吧主到底多久没有在线了，到底是哪个吧务一直任劳任怨？一个公开、透明的吧务后台，用事实说话，吧友的眼睛看得见，你的付出都值得，所有的努力都被记录着，最终都会有回报。

稳定运行几年了，最近捡起来重构了一下，不出意外不需要进行太多更新了。

![DEMO](https://github.com/52fisher/TiebaPublicBackstage/blob/master/%7B8D93BF77-4AB3-4F79-ACB7-CE9E514C2773%7D.png.jpg '运行界面详情')

## 基本功能

- 贴子管理日志
- 用户管理日志
- 本吧数据
- 吧务管理日志

## 附加功能
- 本吧数据导出
- 开启贴吧图片（可选，需消耗服务器资源开启转存，因为贴吧存在防盗链）
- 隐藏操作人（可选，避免全公开后台后有人恶意针对报复）
- 账号隐私保护（**需要验权和隐私保护**，*暂时不支持*）
- 去除多余广告内容
- 支持按昵称（+EMOJI表情）和用户名查找用户贴子（仅限发帖人，不允许按操作人查找，**隐私保护**）
- 支持按时间查找用户贴子（日历可用）
## 安装说明
打开 config.php，其他文件勿动。
```php
$config = [
    'bduss'   => "你的BDUSS", //此处输入有后台查看权限吧务的BDUSS
    'kw'      => '吧名', //在吧名处填写需要公开吧务后台的贴吧
    'showpic' => true, //boolean值，是否开启图片（需要消耗服务器资源进行转存），根据服务器情况，可关闭
    'hideopt' => true, //boolean值，是否隐藏操作人按钮，建议开启（保护操作人隐私）
];

```

## FAQ

### 如何获取BDUSS？
以火狐浏览器为例，打开浏览器进入 https://tieba.baidu.com/ ，按下F12  -> 存储 -> cookie -> BDUSS
其他浏览器类似，不理解可以百度

### 我运行时出现了一些问题，如何解决？

建议 php >=5.6，部分分类贴吧配置了https，需要修改publicBackstage.class.php里面的cget方法，在`curl_setopt($ch, CURLOPT_COOKIE, $cookie)`语句后面填上以下内容：
```
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
```

其他问题可以提问