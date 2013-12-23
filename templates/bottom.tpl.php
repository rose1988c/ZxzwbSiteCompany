<!--footer begin -->
<div class="footer">
	<!--footerMenu begin -->
    <div class="footerMenu">
        <div class="fm-body">
            <ul class="list1 dotCccc a-C666 lineheightH20 fm-body-list">
                <li class="nobg"><h3>炒股高手 </h3></li>
                <li><a href="<?php if($auth->id){ echo Urls::absolute('/i/applyace/');}else{ echo Urls::absolute('/i/regace/'); }?>" target="_blank" rel="nofollow"><span style="color:#AE1900">申请认证</span>，成为认证名人</a></li>
                <li><a href="<?php echo urls::absolute('/account/blog/create/')?>" target="_blank" rel="nofollow">发表观点，解读股市风云</a></li>
                <li><a href="<?php echo urls::absolute('/account/legend/create/')?>" target="_blank" rel="nofollow">发布牛股，验证牛人牛股</a></li>
                <li><a href="<?php echo urls::absolute('/account/group/create/')?>" target="_blank" rel="nofollow">创建圈子，建立影响力</a></li>
            </ul>
            <ul class="list1 dotCccc a-C666 lineheightH20 fm-body-list">
                <li class="nobg"> <h3>普通投资者 </h3></li>
                <li><a target="_blank" href="<?php echo urls::absolute('/mingren/')?>">关注名人堂认证高手</a></li>
                <li><a target="_blank" href="<?php echo urls::absolute('/group/groups/')?>">加入高手圈子</a></li>
                <li><a target="_blank" href="<?php echo urls::absolute('/match/')?>">参加模拟炒股大赛</a></li>
                <li><a target="_blank" href="<?php echo urls::absolute('/search/advanced/?o=y')?>" rel="nofollow">查找实战炒股高手</a></li>
            </ul>
            
            <ul class="list1 dotCccc a-C666 lineheightH20 fm-body-list">
                <li class="nobg"> <h3>特色功能 </h3></li>
                <li><a href="<?php echo urls::absolute('/ask/')?>" target="_blank">股票问答</a></li>
                <li><a target="_blank" href="<?php echo urls::absolute('/legend/'); ?>" rel="nofollow">牛股传说</a></li>
                <li><a target="_blank" href="<?php echo urls::absolute('/match/')?>" rel="nofollow">模拟炒股大赛</a></li>
                <li><a href="<?php echo urls::absolute('/analytic/')?>" target="_blank">投资风格自测</a></li>
            
            </ul>
            
            <ul class="list1 dotCccc a-C666 lineheightH20 fm-body-list" style="margin-right: 30px;">
                <li class="nobg"> <h3>更多</h3></li>
                <li><a href="<?php echo urls::absolute('/service/')?>" target="_blank" rel="nofollow">使用帮助</a></li>
                <li><a style="color:#AE1900;" href="<?php echo urls::absolute('/i/index/');?>" rel="nofollow" target="_blank">邀请好友加入</a></li>
            </ul>
            
            <div class="onlineServiceBar">
            	<a title="点击联系在线客服" target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=130578786&amp;site=qq&amp;menu=yes"><span class="ols-qq"></span></a>
                <a title="关注资本魔方官方新浪微博" target="_blank" href="http://weibo.com/cube7878/"><span class="ols-weibo"></span></a>
                <a title="关注资本魔方官方腾讯微博" target="_blank" href="http://t.qq.com/zbmf7878/"><span class="ols-tqq"></span></a>
                <span class="ols-qqG"></span>
            </div>
        </div>
    </div>
	<!--footerMenu end -->
    <?php include(DOC_ROOT . '/templates/copyright.tpl.php');?>
</div>
<!--footer end -->