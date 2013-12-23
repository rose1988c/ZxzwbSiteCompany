<div class="row-fluid">
	<!-- left menu starts -->
	<?php include (DOC_ROOT . '/templates/manage/scaffolds/left.inc.php');?>
	<div class="contentbox">
	
		<div class="site-map" >
				当前位置：<a href="<?php echo urls::manage();?>">后台</a> > <a href="<?php echo urls::manage('/user_urls/');?>">用戶链接列表</a>
		</div>
	
		<!-- user -->
		<div class="box">
			<div class="box-content">

				<table class="table table-striped">
					<thead>
						<tr role="row">
							<th>用户</th>
							<th>链接</th>
							<th>标题</th>
							<th>标签</th>
							<th>时间</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php 
						    foreach ($urls as $url) { 
						?>
						<tr>
							<td><?php echo $url->user->nickname;?></td>
							<td><a target="_blank" href="<?php echo $url->url;?>"><?php echo $url->url;?></a></td>
							<td><abbr title="<?php echo $url->description;?>"><?php echo $url->title;?></abbr></td>
							<td><?php echo $url->tags; ?></td>
							<td><?php echo format_date($url->created_at);?></td>
							<td class="center ">
							<td class="center ">
								<a href="javascript:void(0);" rel="<?php echo $url->url_id;?>" class="btn btn-info url-user-edit"> <i class="icon-edit icon-white"></i> Edit </a>
								<a href="javascript:void(0);" rel="<?php echo $url->url_id;?>" class="btn btn-danger url-delete"> <i class="icon-trash icon-white"></i> Delete </a>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>

				<div class="row-fluid">
					<div class="span12 center">
						<div class="dataTables_paginate paging_bootstrap pagination">
							<?php echo $pager->fav_output("/manage/page%{page}/");?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	$(document).ready(function(){

		$(".url-user-edit").click(function(){
			var thiz = $(this);
			var url_id = thiz.attr("rel");
			mcc_link.layer.load_edit_user_link(url_id);
		});
		
		$(".url-delete").click(function(){
			var thiz = $(this);
			var url_id = thiz.attr("rel");
			mcc_link.layer.remove_user_link(url_id);
		});

	});
</script>