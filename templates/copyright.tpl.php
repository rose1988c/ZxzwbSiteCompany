<?php
/*
 * mcc - copyright.tpl.php
 * 
 * Created on Jul 4, 2011 4:35:52 PM
 * Created by bill
 * 
 */
?>
    <?php 
        $friends_link_menus = array('f_link_index', 'f_link_group', 'f_link_stock', 'f_link_legend', 'f_link_stock_news');
        if(isset($friends_link_menu) && in_array($friends_link_menu, $friends_link_menus)) { 
    ?>
    <?php if(!empty($friends_links) || count($friends_icon_links) > 0) { ?>
 	<div class="friendLinks" style="width:958px;margin:0;">
        <?php if(count($friends_icon_links) > 0) {?>
        <div class="imgLinksBar">
        	<?php foreach ($friends_icon_links as $friends_icon_link) { ?>
        	<?php 
        	    $alt = strip_tags_attributes($friends_icon_link->description);
        		$url = $friends_icon_link->link_url;
        		$nofollow = $friends_icon_link ->nofollow;
        	?>
       		<a href="<?php echo $url; ?>" target="_blank" <?php if($nofollow ==1){echo 'rel="nofollow"';}?>><img width="88" height="31" alt="<?php echo $alt;?>" src="<?php echo $friends_icon_link->logo_url; ?>"></a>
       		<?php  } ?>
  		</div>
  		<?php }  ?>
        <ul class="a-C666">
            <?php foreach ($friends_links as $friends_link) {?>
            <?php 
            	$url = $friends_link->link_url;
            	$nofollow = $friends_link ->nofollow;
            ?>
            <li>
            	<a href="<?php echo $url; ?>" target="_blank" title="<?php echo $friends_link->link_name; ?>" <?php if($nofollow ==1){echo 'rel="nofollow"';}?>><?php echo trim($friends_link->link_name); ?></a>
            </li>
            <?php } ?>
            <li><a target="_blank" href="<?php echo urls::about('/weblink/');?>" >更多...</a></li>
        </ul> 
    </div>
    <?php } }?>
    
    <div class="copyright">
        <ul class="list-r1 a-C666 clearfix">
            <li><a target="_blank" href="<?php echo urls::about();?>" rel="nofollow">关于我们</a></li>
            <li><a target="_blank" href="<?php echo urls::about('/sitemap/');?>">网站地图</a></li>
            <li><a target="_blank" href="<?php echo urls::absolute('/ask/');?>">股票问答</a></li>
            <li><a target="_blank" href="<?php echo urls::absolute();?>">模拟炒股</a></li>
            <li><a target="_blank" href="<?php echo urls::absolute('/match/');?>">炒股大赛</a></li>
            <li><a target="_blank" href="<?php echo urls::helps();?>">帮助中心</a></li>
            <li><a target="_blank" href="<?php echo urls::about('/serviceinfo/');?>" rel="nofollow">服务条款</a></li>
            <li><a target="_blank" href="<?php echo urls::about('/jobs/');?>" rel="nofollow">招贤纳士</a></li>
            <li class="a-C666-line"><a target="_blank" href="<?php echo urls::about('/suggest/');?>">提建议</a></li>
            <li>广告、商务联系QQ：149762741</li>
        </ul>
    	<div class="copyright-body a-Cccc">
			<SCRIPT LANGUAGE="JavaScript" >document.writeln("<a href='http://www.sgs.gov.cn/lz/licenseLink.do?method=licenceView&entyId=20120302172227981'><img src='/img/global/sgs.gif' border=0></a>")</SCRIPT>
        	Copyright &copy;2011 7878.com 资本魔方,版权所有<br />
            <a href="http://www.miibeian.gov.cn/" target="_blank" rel="nofollow">沪ICP备11008036号</a>
        </div>
        <span class="gototop a-Cccc"><a href="#top">返回顶部</a></span>
        <span class="stockInfo-love7878"></span>
        
    </div>

	