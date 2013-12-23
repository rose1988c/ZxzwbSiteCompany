<?php
/**
 * weixin_client.php
 * 客户端
 * 
 * @author: Cyw
 * @email: chenyunwen01@bianfeng.com
 * @created: 2013-11-5
 * @logs: 
 *     微信公共平台的私有接口
 *     思路: 模拟登录, 再去调用私有web api
 *
 *     功能: 发送信息, 批量发送(未测试), 得到用户信息, 得到最近信息, 解析用户信息(fakeId)
 *
 * @author
 *     life lifephp@gmail.com https://github.com/lealife/WeiXin-Private-API
 *
 *     参考了gitHub微信的api: https://github.com/zscorpio/weChat, 在此基础上作了修改和完善
 * 
 */
class weixin_client {
    /* - - */
    private $token; // 公共平台申请时填写的token
    private $account;
    private $password;
    
    // 每次登录后将cookie, webToken缓存起来, 调用其它api时直接使用
    // 注: webToken与token不一样, webToken是指每次登录后动态生成的token, 供难证用户是否登录而用
    private $cookiePath; // 保存cookie的文件路径
    private $webTokenPath; // 保存webToken的文路径
    
    // 缓存的值
    private $webToken; // 登录后每个链接后都要加token
    private $cookie;
    
    // 构造函数
    public function __construct() {
        // 配置初始化
        $this->account = config_get('weixin.account');
        $this->password = config_get('weixin.password');
        $this->cookiePath = config_get('weixin.cookiePath');
        $this->webTokenPath = config_get('weixin.webTokenPath');
    
        // 读取cookie, webToken
        $this->getCookieAndWebToken();
    }
    
    /**
     * 从缓存中得到cookie和webToken
     * @return [type]
     */
    public function getCookieAndWebToken() {
        $this->cookie = file_get_contents($this->cookiePath);
        $this->webToken = file_get_contents($this->webTokenPath);
    
        // 如果有缓存信息, 则验证下有没有过时, 此时只需要访问一个api即可判断
        if($this->cookie && $this->webToken) {
            $re = $this->getUserInfo(1);
            if(is_array($re)) {
                return true;
            }
        } else {
            return $this->login();
        }
    }
    

    /**
     * 模拟登录获取cookie和webToken
     */
    public function login() {
        $url = "https://mp.weixin.qq.com/cgi-bin/login?lang=zh_CN";
        $post["username"] = $this->account;
        $post["pwd"] = md5($this->password);
        $post["f"] = "json";
        $re = $this->submit($url, $post);
    
        // 保存cookie
        $this->cookie = $re['cookie'];
        file_put_contents($this->cookiePath, $this->cookie);
    
        // 得到token
        $this->getWebToken($re['body']);
    
        return true;
    }
    
    /**
     * 登录后从结果中解析出webToken
     * @param  [String] $logonRet
     * @return [Boolen]
     */
    private function getWebToken($logonRet) {
        $logonRet = json_decode($logonRet, true);
        $msg = $logonRet["ErrMsg"]; // /cgi-bin/indexpage?t=wxm-index&lang=zh_CN&token=1455899896
        $msgArr = explode("&token=", $msg);
        if(count($msgArr) != 2) {
            return false;
        } else {
            $this->webToken = $msgArr[1];
            file_put_contents($this->webTokenPath, $this->webToken);
            return true;
        }
    }
    
    // 其它API, 发送, 获取用户信息
    
    /**
     * 主动发消息
     * @param  string $id      用户的fakeid
     * @param  string $content 发送的内容
     * @return [type]          [description]
     */
    public function send($id, $content)
    {
        $post = array();
        $post['tofakeid'] = $id;
        $post['type'] = 1;
        $post['content'] = $content;
        $post['ajax'] = 1;
        $url = "https://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response&token={$this->webToken}";
        $re = $this->submit($url, $post, $this->cookie);
        return json_decode($re['body']);
    }
    
    /**
     * 批量发送
     * @param  [array] $ids     用户的fakeid集合
     * @param  [type] $content [description]
     * @return [type]          [description]
     */
    public function batSend($ids, $content)
    {
        $result = array();
        foreach($ids as $id) {
            $result[$id] = $this->send($id, $content);
        }
        return $result;
    }
    
    /**
     * 发送图片
     * @param  int $fakeId [description]
     * @param  int $fileId 图片ID
     * @return [type]         [description]
     */
    public function sendImage($fakeId, $fileId) {
        $post = array();
        $post['tofakeid'] = $fakeId;
        $post['type'] = 2;
        $post['fid'] = $post['fileId'] = $fileId; // 图片ID
        $post['error'] = false;
        $post['ajax'] = 1;
        $post['token'] = $this->webToken;
    
        $url = "https://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response&lang=zh_CN";
        $re = $this->submit($url, $post, $this->cookie);
    
        return json_decode($re['body']);
    }
    
    /**
     * 获取用户的信息
     * @param  string $fakeId 用户的fakeId
     * @return [type]     [description]
     */
    public function getUserInfo($fakeId)
    {
        $url = "https://mp.weixin.qq.com/cgi-bin/getcontactinfo?t=ajax-getcontactinfo&lang=zh_CN&token={$this->webToken}&fakeid=$fakeId";
        $re = $this->submit($url, array(), $this->cookie);
        $result = json_decode($re['body'], 1);
        if(!$result) {
            $this->login();
        }
        return $result;
    }
    
    /*
     得到最近发来的信息
    [0] => Array
    (
            [id] => 189
            [type] => 1
            [fileId] => 0
            [hasReply] => 0
            [fakeId] => 1477341521
            [nickName] => lealife
            [remarkName] =>
            [dateTime] => 1374253963
    )
    [ok]
    */
    public function getLatestMsgs($page = 0) {
        // frommsgid是最新一条的msgid
        $frommsgid = 100000;
        $offset = 50 * $page;
        // $url = "https://mp.weixin.qq.com/cgi-bin/getmessage?t=ajax-message&lang=zh_CN&count=50&timeline=&day=&star=&frommsgid=$frommsgid&cgi=getmessage&offset=$offset";
        $url = "https://mp.weixin.qq.com/cgi-bin/message?t=message/list&count=999999&day=7&offset={$offset}&token={$this->webToken}&lang=zh_CN";
        $re = $this->get($url, $this->cookie);
        // print_r($re['body']);
    
        // 解析得到数据
        // list : ({"msg_item":[{"id":}, {}]})
        $match = array();
        preg_match('/["\' ]msg_item["\' ]:\[{(.+?)}\]/', $re['body'], $match);
        if(count($match) != 2) {
            return "";
        }
    
        $match[1] = "[{". $match[1]. "}]";
    
        return json_decode($match[1], 1);
    }
    
    // 解析用户信息
    // 当有用户发送信息后, 如何得到用户的fakeId?
    // 1. 从web上得到最近发送的信息
    // 2. 将用户发送的信息与web上发送的信息进行对比, 如果内容和时间都正确, 那肯定是该用户
    //                 实践发现, 时间可能会不对, 相隔1-2s或10多秒也有可能, 此时如果内容相同就断定是该用户
    //                 如果用户在时间相隔很短的情况况下输入同样的内容很可能会出错, 此时可以这样解决: 提示用户输入一些随机数.
    
    /**
     * 通过时间 和 内容 双重判断用户
     * @param  [type] $createTime
     * @param  [type] $content
     * @return [type]
     */
    public function getLatestMsgByCreateTimeAndContent($createTime, $content) {
        $lMsgs = $this->getLatestMsgs(0);
    
        // 最先的数据在前面
        $contentMatchedMsg = array();
        foreach($lMsgs as $msg) {
            // 仅仅时间符合
            if($msg['date_time'] == $createTime) {
                // 内容+时间都符合
                if($msg['content'] == $content) {
                    return $msg;
                }
    
                // 仅仅是内容符合
            } else if($msg['content'] == $content) {
                $contentMatchedMsg[] = $msg;
            }
        }
    
        // 最后, 没有匹配到的数据, 内容符合, 而时间不符
        // 返回最新的一条
        if($contentMatchedMsg) {
            return $contentMatchedMsg[0];
        }
    
        return false;
    }
    
    /* - cUrl - */
    function submit($url, $data, $cookie = false) {
        return $this->exec($url, $data, $cookie);
    }

    function get($url, $cookie) {
        return $this->exec($url, false, $cookie, false);
    }

    /**
     * 返回array(cookie=>, body=>)
     * @param  [type] $url    [description]
     * @param  [array] $data   [description]
     * @param  [type] $cookie [description]
     * @return [type]         [description]
     */
    private function exec($url, $data, $cookie = false, $isPost = true) {
        $dataStr = "";
        if($data && is_array($data)) {
            foreach($data as $key => $value) {
                $dataStr .= "$key=$value&";
            }
        }

        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        // curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        // $oldReferer = "https://mp.weixin.qq.com/";
        // $referer = "https://mp.weixin.qq.com/cgi-bin/singlemsgpage";
        // 腾讯接口变化2013-10-30
        $referer = "https://mp.weixin.qq.com/cgi-bin/singlesendpage";
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Referer:$referer"));

        if($isPost) {
            curl_setopt($curl, CURLOPT_POST, 0); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataStr); // Post提交的数据包
        }

        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 1); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        // curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt');
        // curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie.txt');
        // curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); 
        // curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); 

        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }

        // 执行操作
        $tmpInfo = curl_exec($curl); 
        if (curl_errno($curl)) {
           //捕抓异常
           echo 'Errno'. curl_error($curl);

           return;
        }

        // 关闭CURL会话
        curl_close($curl); 

        // 解析HTTP数据流
        list($header, $body) = explode("\r\n\r\n", $tmpInfo);

        // 解析COOKIE
        if(!$cookie) {
            $cookie = "";
            preg_match_all("/set\-cookie: (.*)/i", $header, $matches);
            if(count($matches == 2)) {
                foreach($matches[1] as $each) {
                    $cookie .= trim($each). ";";
                }
            }
        }

        return array("cookie" => $cookie, "body" => trim($body));
    }
    /* - - */
    
    
}