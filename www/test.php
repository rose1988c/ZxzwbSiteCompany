<?php 
     function get_josephus2($n, $m, $current = 0 ) {        //$n为总数,$m为剔除步长
         $s = $current;
         for($i = 2; $i <= $n; $i++) {      //依次向后递推,求到共有$n只,剔除步长为$m时的success坐标
             $s = ($s + $m) % $i;           //success坐标递推公式
         }
         return $s + 1;
     }
     
     echo get_josephus2(5, 4, 4);
     echo '<br />';

     //定义函数
    function get_josephus( $totals , $m , $current = 0){
        $number = count($totals);
        $num = 1;
        if(count($totals) == 1){
            echo '<font color="red">'. current($totals) .' success!</font>';
            return;
        }else{
            while($num++ < $m){
                $current++ ;
                $current = $current%$number;
            }
            echo "".$totals[$current]."Killed...<br/>";
            array_splice($totals , $current , 1);
            get_josephus($totals , $m , $current);//递归函数
        }
    }
    $n = 5; //总共数目
    $m = 4; //数到第几只的那被踢出去
    $totals = range(1, $n); //将编号1-$n放入数组中
    get_josephus($totals , $m, 4); //调用函数
    
    

    die();
    //**

    $str = 'abcdefg';
    echo trim($str, 'g');

    echo phpinfo();die();

    $maps = array(
                'jsfx'  =>TOPIC_CATEGORY_SKILL_ANALYSE, 
                'gsyj'  =>TOPIC_CATEGORY_COMPANY_RESEARCH, 
                'rdtx'  =>TOPIC_CATEGORY_HOT_DIALYSIS,
                'dpyc'  =>TOPIC_CATEGORY_LARGECAP_FORECAST, 
                'jhjc'  =>TOPIC_CATEGORY_ESSENCE_COURSE, 
                'other' =>TOPIC_CATEGORY_OTHER, 
                'new'   =>TOPIC_CATEGORY_NOTICE, 
                'match' =>TOPIC_CATEGORY_101,
                'game'  =>TOPIC_CATEGORY_102,
                'fight' =>TOPIC_CATEGORY_103,
        );
        
        var_dump(array_keys($maps, 'ooo'));
        
        die();
        


$str1 = 'bbbc';
$str2 = 'cbbb';
if(count_chars($str1,1) === count_chars($str2,1)){
       //echo 'equal';
    } else {
       //echo 'not equal';
    }
    
    $aa = '3306.';//多个点
    $b = '3306';
    
    echo strcmp($str1, $str2);

if( $aa == $b ){ echo "equal2";}
if( strcmp($str1, $str2) == 0 ){ echo "equal3";}

die();

$rrid = rand(111111111, 999999999); //233129566;
//$url = 'localhost';
$url = 'http://www.chinafacemash.com/signin?inviter=50765ba31d41c8790cbb2fdd';

$argv = array( 'h1' => array('_xsrf' => 'd70657bd4490463ba600375352efc7d3', 'next_page' => '/', 'renren_id' => $rrid, 'cf_passwd' => '123456789', 'inviter_id' => '50765ba31d41c8790cbb2fdd') );
$argv2 = array('_xsrf' => 'd70657bd4490463ba600375352efc7d3', 'next_page' => '/', 'renren_id' => $rrid, 'cf_passwd' => '123456789', 'inviter_id' => '50765ba31d41c8790cbb2fdd');

// foreach($argv['h1'] as $key => $value) {
//     $params[] = $key . '=' . $value;
//  } 
//  $params = implode('&', $params); 
//  $header = "POST /post.php HTTP/1.1\r\n"; 
//  $header .= "Host:localhost\r\n"; 
//  $header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
//  $header .= "Content-Length: " . strlen($params) . "\r\n"; 
//  $header .= "Connection: Close\r\n\r\n"; 
//  $header .= $params; 
//  $fp = fsockopen($url, '80'); 
//  fputs($fp, $header); 
//  while(!feof($fp)) { echo fgets($fp);
//  }
 
//  die("ok");
//  
//  
  echo $rrid . '\n';
  sock_post($url,$argv2);
  echo 'ok';
?>


<!-- stock 模拟 -->
<?php 
function sock_post($url, $data='') {
  $url = parse_url($url);
  $url['scheme'] || $url['scheme'] = 'http';
  $url['host'] || $url['host'] = $_SERVER['HTTP_HOST'];
  $url['path'][0] != '/' && $url['path'] = '/'.$url['path'];

  $query = $data;
  if(is_array($data)) $query = http_build_query($data);

  $fp = @fsockopen($url['host'], $url['port'] ? $url['port'] : 80);
  if (!$fp) return "Failed to open socket to $url[host]";

  fputs($fp, sprintf("POST %s%s%s HTTP/1.0\n", $url['path'], $url['query'] ? "?" : "", $url['query']));
  fputs($fp, "Host: $url[host]\n");
  fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
  fputs($fp, "Content-length: " . strlen($query) . "\n");
  fputs($fp, "Connection: close\n\n");

  fputs($fp, "$query\n");

  $line = fgets($fp,1024);
  if (!eregi("^HTTP/1\.. 200", $line)) return;

  $results = ""; $inheader = 1;
  while(!feof($fp)) {
    $line = fgets($fp,1024);
    if ($inheader && ($line == "\n" || $line == "\r\n")) {
      $inheader = 0;
    }elseif (!$inheader) {
      $results .= $line;
    }
  }
  fclose($fp);

  return $results;
}

?>


<?php die('do'); ?>


<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">

	<input type="text" name="url" style="width: 900px;" value="https://www.99bill.com/gateway/recvMerchantInfoAction.htm?inputCharset=1&bgUrl=http://www.7878.com/account/trade/api/kuaiqian4callbank/&version=v2.0&language=1&signType=1&merchantAcctId=1002136333301&payerName=%E5%A5%A5%E7%89%B9%E6%9B%BC&payerContactType=1&orderId=1209211039418831827&orderAmount=50000&orderTime=20120921103941&productName=500%E4%B8%AA%E9%87%91%E5%B8%81&productNum=1&productId=28&ext1=1827&payType=19&redoFlag=0&signMsg=E2C0997EC67617E9E029F12B284BE7E7"/><br />
	<input type="submit"  />
</form>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $str = parse_url($_POST['url']);
    
    $t = array();
    foreach (explode('&', $str['query']) as $key => $value) {
        $tv = explode('=', $value);
        $t[$tv[0]] = $tv[1];
    }

    echo "<pre>";
    print_r($str['query']);
    echo "</pre>";
    
    $str['query'] = str_replace('&bgUrl=http://www.7878.com/account/trade/api/kuaiqian4callbank/', '', $str['query']);
    
    echo  'http://www.m.com/account/trade/api/kuaiqian4callbank/?' . $str['query'] . '&dealId=729948754&bankDealId=120911435318&dealTime=20120911144918&payResult=10&errCode=&fee=&payAmount=50000&signMsg=EAAE5A99F076040C8A44408CA0F5B2CA';
    
}



?>
