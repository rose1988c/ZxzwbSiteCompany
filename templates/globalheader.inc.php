<?php
/*
 * mcc - globalheader.tpl.php
 * 
 * Created on Aug 26, 2011 5:50:04 PM
 * Created by bill
 * 
 */
?>
<!--header begin...-->
<div id="layer-header" >
    <div class="header" >
        <div class="gheader clearfix"> 
        	<div>
        		<a class="glogo" href="<?php echo urls::absolute(); ?>" title="资本魔方"></a>
        		<div class="gmenu">
        			<ul>
        				<li><span><a href="<?php echo urls::absolute('/'); ?>" title="资本魔方">首&nbsp;&nbsp;&nbsp;&nbsp;页</a></span></li>
        				<li id="header-magic"><span><a href="<?php echo urls::absolute('/account/'); ?>" title="资本魔方" rel="nofollow">我的魔方</a><?php if ($auth->is_logged_in()) {?><span class="header-point"></span><?php } ?></span></li>
        				<li><a href="<?php if ($auth->is_logged_in()) { echo urls::t(); } else { echo urls::t(false, '/news/'); } ?>" target="_blank">&nbsp;魔方微博</a><span class="n-r-b">&nbsp;</span></li>
        				<li id="header-group"><span><a href="<?php echo urls::absolute('/group/'); ?>" title="圈子">圈&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;子</a><?php if ($auth->is_logged_in()) {?><span class="header-point" style="left:494px;"></span><?php } ?></span></li>
        				<li class="last"><span><a href="<?php echo urls::absolute("/charts_user/"); ?>" title="风云榜">风云榜&nbsp;</a></span></li>
        				<li><span><a href="<?php echo urls::absolute("/mingren/"); ?>" title="名人堂">名人堂</a></span></li>
        				<li><span><a href="<?php echo urls::absolute('/legend/'); ?>" title="牛股传说">牛股传说</a></span></li>
        				<li id="header-stock" ><span><a href="<?php echo urls::absolute('/stock/'); ?>" title="模拟炒股">模拟炒股</a><?php if ($auth->is_logged_in()) {?><span class="header-point" style="left:416px;top:38px;"></span><?php } ?></span></li>
        				<li><span class="current"><a style="color:#fff" href="<?php echo urls::absolute('/match/'); ?>" target="_blank">炒股大赛</a></span></li>
        				<li class="last"><span <?php echo $site_menu == 'ask' ? ' class="current"' : ''; ?>><a href="<?php echo urls::absolute('/ask/'); ?>" target="_blank"  <?php echo $site_menu == 'ask' ? ' style="color:#fff"' : ' style="color:red;font-weight:bold;"'; ?>>股票问答</a></span></li>
        			</ul>
        			<?php if ($auth->is_logged_in()) {?>
        			<div class="menu_account_links" id="header-account-dropdown">
        				<div class="level2" style="width:100px;">
        					<ul class="mine clearfix" >
        						<!-- 
        						<li onMouseOver="this.className='mouse-hover'" onMouseOut="this.className='mouse-out'">
        							<span class="mylegend buy_stock"></span>
        							<a href="<?php echo urls::absolute('/account/stock/buy/'); ?>" title="买股票">买股票</a>
        						</li>
        						<li  onMouseOver="this.className='mouse-hover'" onMouseOut="this.className='mouse-out'">
        							<span class="mylegend sall_stock"></span>
        							<a href="<?php echo urls::absolute('/account/stock/sell/'); ?>" title="卖股票">卖股票</a>
        						</li>
        						 -->
        						<li  onMouseOver="this.className='mouse-hover'" onMouseOut="this.className='mouse-out'">
										<span class="ask"></span>
										<a href="<?php echo urls::absolute('/ask/new/'); ?>" title="提问题">提问题</a>
								</li>
        						<li  onMouseOver="this.className='mouse-hover'" onMouseOut="this.className='mouse-out'">
        							<span class="mylegend create_blog"></span>
        							<a href="<?php echo urls::absolute('/account/blog/create/'); ?>" title="写博文">写博文</a>
        						</li>
        					</ul>
        				</div>		
        			</div>
                    <?php 
                    	$menu_groups = mcc_get_related_groups(); 
                    	$owned   = $menu_groups['owned_groups'];
                    	$joined  = $menu_groups['joined_groups'];
                    	$latest  = $menu_groups['latest_groups'];
                    ?>
        			<div class="menu_account_links" id="header-group-dropdown" style="left:448px;">
        				<div class="level2">
        					<ul class="mine clearfix" id="header-group-d">
        						<li class="header-li-line header-group-li">
        							<a href="<?php echo urls::absolute('/account/group/#create'); ?>" title="我创建或是我管理的圈子">我创建/管理的圈子</a>
        							<ul class="clearfix header-li-open header-group-list <?php if (!empty($owned)) { echo "latest-list";}?> " <?php if (empty($owned)) {echo 'style="width:200px;"'; }?>>
        							<?php 
        								if (empty($owned)) { 
        									echo "<li class=\"full a-Cf63\" style=\"text-align:left;text-indent:10px;width:200px;display:inline;overflow:visible;height:30px;\">". '<a href="'.urls::absolute('/account/group/create/').'">您还没创建/管理圈子，马上创建</a></li>';
        								} else { 
        									foreach ($owned as $og) {  
        										echo "<li><a href=\"". urls::group($og) . "\" title=\"{$og->name}\">$og->name</a></li>";
        									}
        									if (count($owned) == 20) {
        										echo "<ul><li style=\"width:80px;padding-left:80px;background:none;border-top:1px dotted #ccc;\"><a style=\"margin-left:8px;\" href=\"". urls::absolute('/account/group/#create') ."\">查看更多&gt;&gt;</a></li></ul>";
        									} 
        								}  
        							?>
        							</ul>
        							<span class="more-point"></span>
        						</li>
        						<li  class="header-li-line header-group-li">
        							<a href="<?php echo urls::absolute('/account/group/#join'); ?>" title="我收藏的圈子">我收藏的圈子</a>
        							<ul class="clearfix header-li-open header-group-list <?php if (!empty($joined)) { echo "latest-list";}?>" style="top:30px;<?php if (empty($joined)) {echo 'width:200px;'; }?>">
        							<?php 
        								if (empty($joined)) {  
        									echo '<li class="full a-Cf63" style="text-align:left;text-indent:10px;width:200px;display:inline;overflow:visible;height:30px;"><a href="'.urls::absolute('/group/').'">您还没收藏圈子，看看已有的圈子</a></li>';
        								} else {
        									foreach ($joined as $jg) {  
        							?>
        								<li><a href="<?php echo urls::group($jg); ?>" title="<?php echo $jg->name; ?>"><?php echo $jg->name; ?></a></li>
        							<?php 
        									}
        									if (count($joined) == 20) {
        									   echo "<li style=\"width:80px;padding-left:80px;background:none;border-top:1px dotted #ccc;\"><a style=\"margin-left:8px;\" href=\"". urls::absolute('/account/group/#create') ."\">查看更多&gt;&gt;</a></li>";
        									} 
        								} 
        							?>
        							</ul>
        							<span class="more-point" style="top:36px;"></span>
        						</li>
        					</ul>
        					<ul class="latest clearfix header-group-list  <?php if (!empty($latest)) { echo "latest-list";}?>">
        					<?php
        						if (empty($latest)) {
        							echo "<li class=\"full\"><a href=\"".urls::group(false)."\">最近没浏览圈子，随便逛逛吧</a></li>";
        						} else {
        							foreach ($latest as $g) {
        								echo "<li><a href=\"". urls::group($g) ."\" title=\"{$g->name}\">$g->name</a></li>"; 
        							}
        						}
        					?>
        					</ul>
        				</div>
        			</div>
        			
        			<?php 
                    	$menu_groups = mcc_get_related_groups(); 
                    	$focused = $menu_groups['focused_groups'];
                    	$mostly  = $menu_groups['mostly_groups'];
                    	$latest_stocks  = $menu_groups['latest_stocks_groups'];
                    ?>
        			<div class="menu_account_links" id="header-stock-dropdown" style="left:368px;_left:367px;top:58px;_top:58px;">
        				<div class="level2">
        					<ul class="mine clearfix" id="header-stock-d">
        						<li class="header-li-line header-stock-li">
        							<a href="<?php echo urls::absolute('/account/stock/focus/'); ?>" title="我的自选股">我的自选股</a>
        							<ul class="clearfix header-li-open header-group-list <?php if (!empty($focused)) { echo "latest-list";}?>" <?php if (empty($focused)) {echo 'style="width:200px;"'; }?>>
        							<?php 
        								if (empty($focused)) {
        									echo '<li class="full a-Cf63"  style="text-align:left;text-indent:10px;width:200px;display:inline;overflow:visible;height:30px;"><a href="'.urls::absolute('/account/stock/focus/').'">您还没加入自选股，马上添加</a></li>';
        								} else {
        									foreach ($focused as $fg) { 
        									    if(is_object($fg)) {
        										    echo "<li><a href=\"". urls::group($fg) ."\" title=\"{$fg->name}\">{$fg->name}</a></li>";
        									    }
        									}
        									if (count($focused)== 20) {
        										echo "<li style=\"width:80px;padding-left:80px;background:none;border-top:1px dotted #ccc;\"><a style=\"margin-left:8px;\" href=\"". urls::absolute('/group/stock/focus/') ."\">查看更多&gt;&gt;</a></li>";
        									}
        								}
        							?>
        							</ul>
        							<span class="more-point"></span>
        						</li>
        						<li class="header-li-line header-stock-li">
        							<a href="<?php echo urls::absolute('/group/attention/'); ?>" title="我关注的股票">我关注的股票</a>
        							<ul class="clearfix header-li-open header-group-list <?php if (!empty($mostly)) { echo "latest-list";}?>"  style="top:30px;<?php if (empty($mostly)) {echo 'width:200px;'; }?>">
        							<?php
        								if (empty($mostly)) {
        									echo '<li class="full a-Cf63"  style="text-align:left;text-indent:10px;width:200px;display:inline;overflow:visible;height:30px;"><a href="'.urls::group(false, '/stocks/').'">您还没有关注股票，点击查看股票</a></li>';
        								} else {
        									foreach ($mostly as $g) {
        										echo "<li><a href=\"". urls::group($g) ."\" title=\"{$g->name}\">$g->name</a></li>"; 
        									}
        									if (count($mostly) == 20) {
        										echo "<li style=\"width:80px;padding-left:80px;background:none;border-top:1px dotted #ccc;\"><a style=\"margin-left:2px;\" href=\"". urls::absolute('/group/attention/') ."\">查看更多&gt;&gt;</a></li>";
        									}
        								}
        								
        							?>
        							</ul>
        							<span class="more-point"  style="top:36px;"></span>
        						</li>
        					</ul>
        					<ul class="latest clearfix header-group-list <?php if (!empty($latest_stocks)) { echo "latest-list";}?>">
        					<?php
        						if (empty($latest_stocks)) {
        							echo "<li class=\"full\"><a href=\"".urls::group(false,'/stocks/')."\">最近没浏览股票，随便逛逛吧</a></li>";
        						} else {
        							foreach ($latest_stocks as $g) {
        								echo "<li><a href=\"". urls::group($g) ."\" title=\"{$g->name}\">$g->name</a></li>"; 
        							}
        						}
        					?>
        					</ul>
        				</div>
        			</div>
        			<?php } ?>
        		</div>
        		<div class="gsearch" id="gsearch_box">
                	 <form id="global_search_form" name="global_search_form" action="<?php echo urls::absolute('/search/'); ?>" target="_blank">
                    		<div id="global_search_tab" class="global_search_tab" style="margin-left:7px;_margin-left:2px;">
                    			<span class="small_current"><a href="javascript:void(0);">搜全站</a></span>
                    			<span><a href="javascript:void(0);">搜个股</a></span>
                    			<span class="small_none">
                    				<a href="<?php echo urls::absolute('/search/'); ?>" target="_blank">更多</a>
                    			</span>
                    		</div>
                    		<div class="clear"></div>
            	            <input type="submit" class="gsearch-submit" value="搜索" />
            	            <input class="gsearch-input" name="q" autocomplete="off"/>
            	            <div class="small_placeholder" style="position:absolute;top:20px;_top:20px;left:20px;color: rgb(153, 153, 153);line-height: 31px; ">用户 / 圈子 / 资讯</div>
                   </form>                     
                </div>
                <?php if ($auth->is_logged_in()) {?>
                <script>
                	$("document").ready(function() {
                    	//account menus
                    	$("#header-magic").mouseover(function(){
                    		$("#header-group-dropdown, #header-stock-dropdown").css("visibility", "hidden");
                    		mcc.open.hidden_layer('header-account-dropdown');
                    	}).mouseout(function(){
                    		mcc.mclosetime();
                    	});
                    	$("#header-account-dropdown").mouseover(function(){
                    		mcc.mcancelclosetime();
                    	}).mouseout(function(){
                    		mcc.mclosetime();
                    	});
        
                    	//group menus
                    	$("#header-group").mouseover(function(){
                    		$("#header-account-dropdown, #header-stock-dropdown").css("visibility", "hidden");
                    		$("#header-group-d").find('.header-group-li > ul').hide();
                    		mcc.open.hidden_layer('header-group-dropdown');
                    	}).mouseout(function(){
                    		mcc.mclosetime();
                    	});
                    	$("#header-group-dropdown").mouseover(function(){
                    		mcc.mcancelclosetime();
                    	}).mouseout(function(){
                    		$("#header-group-d").find('.header-group-li > ul').hide();
                    		mcc.mclosetime();
                    	});
        
                    	var start_menus = function(e) {
                        	$("#header-group-d").find('.header-group-li').each(function(){
                        		var closetimer_group= 0;
                        		var timeout_group   = 100;
                        		$(this).mouseover(function(){
                            		if(closetimer_group){
                            			window.clearTimeout(closetimer_group);
                            			closetimer_group = null;
                            		}
                            		var item = $(this).find('ul');
                            		$(item).show();
                            		$(this).attr('class', 'mouse-hover-line');
                            	}).mouseout(function(e){
                                	var father_item = $(this);
                            		var item = $(this).find('ul');
                            		closetimer_group = window.setTimeout(function(){$(item).hide();$(father_item).attr('class', 'mouse-out-line');}, timeout_group);
                            	});
                        	}); 
                        }  ;
                        start_menus();
        
                        //stock menus
                    	$("#header-stock").mouseover(function(){
                    		$("#header-account-dropdown, #header-group-dropdown").css("visibility", "hidden");
                    		$("#header-stock-d").find('.header-stock-li > ul').hide();
                    		mcc.open.hidden_layer('header-stock-dropdown');
                    	}).mouseout(function(){
                    		mcc.mclosetime();
                    	});
                    	$("#header-stock-dropdown").mouseover(function(){
                    		mcc.mcancelclosetime();
                    	}).mouseout(function(){
                    		$("#header-stock-d").find('.header-stock-li > ul').hide();
                    		mcc.mclosetime();
                    	});
        
                    	var start_stock_menus = function() {
                        	$("#header-stock-d").find('.header-stock-li').each(function(){
                        		var closetimer_stock= 0;
                        		var timeout_stock   = 100;
                        		$(this).mouseover(function(){
                            		if(closetimer_stock){
                            			window.clearTimeout(closetimer_stock);
                            			closetimer_stock = null;
                            		}
                            		var item = $(this).find('ul');
                            		$(item).show();
                            		$(this).attr('class', 'mouse-hover-line');
                            	}).mouseout(function(e){
                            		var father_item = $(this);
                            		var item = $(this).find('ul');
                            		closetimer_stock = window.setTimeout(function(){$(item).hide();$(father_item).attr('class', 'mouse-out-line');}, timeout_stock);
                            	});
                        	}); 
                        }  ;
                        start_stock_menus();
                	});
        		</script>
        		<?php } ?>
        	</div>
        </div>
    </div>
</div>
<!--header end...-->