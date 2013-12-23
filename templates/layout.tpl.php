<?php
$site_title = 'Design';
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="baidu_union_verify" content="6d69bd61e308b36158a462e8406697d9">
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
	<div class="cover-wrap">
		<div class="wrap">
			<div id="header">
				<div id="logo">
					<a href="/"></a>
				</div>
				<ul id="auth-area">
<!-- 					<li><a href="/login/" id="login-link">Log in</a></li> -->
				</ul>
			</div>
			<div id="content-head">
				<h1>杭州润邦装饰工程有限公司 — 设计新风尚</h1>
<!-- 				<p>设计宣言</p> -->
			</div>
		</div>


		<nav id="subnav" class="nav-g">
			<ul>
				<li <?php if (!isset($nav)) { echo 'class="current"';}?>><a href="/">首页</a></li>
				<li <?php if (isset($nav) && $nav == 'story') { echo 'class="current"';}?>><a href="/story/">品牌故事</a></li>
				<li <?php if (isset($nav) && $nav == 'case') { echo 'class="current"';}?>><a href="/case/">设计</a></li>
				<li <?php if (isset($nav) && $nav == 'about') { echo 'class="current"';}?>><a href="/about/">关于</a></li>
			</ul>
		</nav>
	</div>
	<div id="main">
        <?php echo $body;?>
	</div>

	<div class="clear"></div>

	<div class="cover-wrap">
		<div class="wrap">
			<div id="footer">
				<div class="address unit-push-left">
					<b>杭州润邦装饰工程有限公司</b>
					<p>杭州润邦装饰工程有限公司城南分公司：汽车南站 电话：0571-xxxxx</p>
					<p>©www.zxzwb.com 2009-2013</p>
				</div>
				<div class="unit-push-right">
					<nav class="nav-g">
						<ul>
							<li><a href="/">首页</a></li>
							<li><a href="/story/">品牌故事</a></li>
							<li><a href="/case/">设计</a></li>
							<li><a href="/about/">About</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</body>
</html>