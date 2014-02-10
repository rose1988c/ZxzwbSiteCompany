<?php
$site_title = 'Design';
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="baidu_union_verify" content="fe208513ea6e75e5e7e405c3c5b8df28">
<meta name="domain_verify" content="pmrgi33nmfuw4ir2ej5hq6txmixgg33neiwcez3vnfsceorcheydiyjrmrsdqmzwhaydioldmu4timjtgaydqzbwhbqwenjygjsselbcoruw2zktmf3gkir2geztqojygq3dknbzga3tk7i">
<meta http-equiv="imagetoolbar" content="no" />
    <?php
    // 规避 单一的分页 title
    $pager_title = '';
    if (isset($pager) && is_object($pager) && $pager->page > 1) {
        $pager_title = "_第{$pager->page}页";
    }
    if (isset($head_title)) {
        if ($_SERVER ["SCRIPT_NAME"] != '/index.php') {
            $title = $head_title . $pager_title . ' - ' . $site_title;
        } else {
            $title = $head_title . $pager_title;
        }
    } else {
        $title = ! empty($title) ? ($title . $pager_title . ' - ') : '';
        $title = browser_is_search_engine() ? ($title . $site_title) : ($title . $site_title);
    }
    $title = strip_tags_attributes($title);
    ?>
    <meta name="title" content="<?php echo $title;?>" />
<meta name="description"
	content="<?php echo isset($head_description) ? $head_description : $site_title;?>" />
<meta name="keywords"
	content="<?php echo isset($head_keywords) ? $head_keywords : $site_title;?>" />
<meta name="robots"
	content="<?php if (isset($robots)) echo $robots; else echo 'all'; ?>" />
<link rel="shortcut icon" href="<?php echo $media_root;?>/favicon.ico"
	type="image/x-icon" />
<title><?php echo $title;?></title>
    <?php
    $tpl->add_stylesheet('kube.css', 'global');
    $tpl->add_stylesheet('index.css', 'global');
    $tpl->output_stylesheets();
    $tpl->add_javascript('jquery/jquery-1.9.1.js', 'global');
    // $tpl->add_javascript('jquery/jquery.tools.min.js', 'global');
    // $tpl->add_javascript('jquery/jquery.cookies.js', 'jqcookies');
    $tpl->output_javascripts();
    ?>
</head>

<body>
<center>
    <iframe frameborder="0" marginheight="0" marginwidth="0" border="0" id="etgFrm" width="1030" height="3810" src="http://re.paipai.com/tws/etgcl/click?fu=http%3A%2F%2Fte.paipai.com%2Fcps_lady.shtml%3FPTAG%3D10076.7.1&pps=etg.0_60784_20_0"></iframe>
</center>
</body>
</html>
