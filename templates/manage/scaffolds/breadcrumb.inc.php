<h3 class="page-title">
    <?php 
        $subtitle = isset($subtitle) ? $subtitle : BaseUtils::FAV_CLASSIC_QUOTATION();
    ?>
	<?php echo $title;?> <?php if (!empty($subtitle)){?><small><?php echo $subtitle;?></small><?php }?>
</h3>
<ul class="breadcrumb">
	<li><i class="icon-home"></i> <a href="/manage/">主页</a> <i
		class="icon-angle-right"></i></li>
	<li><a href="<?php echo $_SERVER['REQUEST_URI'];?>"><?php echo $title;?></a></li>
	
	<?php 
	    if ( $_SERVER['REQUEST_URI'] == '/manage/') {
	?>
	<li class="pull-right no-text-shadow">
		<div id="dashboard-report-range"
			class="dashboard-date-range tooltips no-tooltip-on-touch-device responsive"
			data-tablet="" data-desktop="tooltips" data-placement="top"
			data-original-title="Change dashboard date range">
			<i class="icon-calendar"></i> <span></span> <i
				class="icon-angle-down"></i>
		</div>
	</li>
	<?php }?>
</ul>
