<?php
/**
 * simsimi.class.php
 * 韩国小鸡
 * 
 * @author: Cyw
 * @email: chenyunwen01@bianfeng.com
 * @created: 2013-10-31
 * @logs: 
 * 
 */
class simsimi
{
    private $param;
    
    function __construct($keyword)
    {
        $this->param = array (
            'key' => '0787cd29-9de0-4e60-a71b-f62c9c9203e9',
            'lc' => 'ch',
            'ft' => '1.0',
            'text' => $keyword 
        );
    }
    
    public function getMsg()
    {
        $url = 'http://sandbox.api.simsimi.com/request.p?' . http_build_query($this->param);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        
        $message = json_decode($output, true);
        
        $result = '';
        
        if ($message ['result'] == 100) {
            $result = $message ['response'];
        } else {
            $result = $message ['result'] . '-' . $message ['msg'];
        }
        
        return $result;
    }
}