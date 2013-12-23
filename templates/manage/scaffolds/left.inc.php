<?php
$manage_left = isset ( $manage_left ) ? $manage_left : 'index';
?>
<div class="main-left" style="margin-left: 0px;">
	<ul class="side-tag" id="leftbar" style="position: fixed; top: 100px;width:240px;">
		<li><i class="dot c9" style="height: 6px;"></i>
			<h2 class="title">管理</h2>
			<a href="<?php echo urls::manage();?>">用户</a>
		</li>
		<li class="nav-FSLF"><i class="dot c1" style="height: 6px;"></i>
			<h2 class="title">链接</h2>
			<a href="<?php echo urls::manage('/urls/');?>">链接列表</a>
			
		</li>
		<li class="nav-ETLS"><i class="dot c2" style="height: 6px;"></i>
			<h2 class="title">标签</h2>
			<a href="<?php echo urls::manage('/tag_bundles/');?>">标签集</a>
			<a href="<?php echo urls::manage('/tags/');?>">标签列表</a>
			<a href="<?php echo urls::manage('/tag_bundles/config/');?>">配置标签集</a>
		</li>
		<li class="nav-BSFN"><i class="dot c3" style="height: 6px;"></i>
			<h2 class="title">其他</h2>
			<a href="<?php echo urls::manage('/');?>">标签相关性</a>
			</li>
	</ul>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#leftbar > li").hover(function(){
			var thiz = $(this);
			thiz.find(".dot").css({"height" : thiz.height()+12});
        },function() {
    		var thiz = $(this);
    		thiz.find(".dot").css({"height" : 6});
    	});
    });
</script>