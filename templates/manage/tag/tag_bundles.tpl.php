<div class="row-fluid">
	<div class="contentbox">
		<a href="javascript:void(0);"  class="bundles-add btn btn-primary"> Add </a>
		<!-- user -->
		<div class="box">
			<div class="box-content">
				<table class="table table-striped table-hover">
					<thead>
						<tr role="row">
							<th>id</th>
							<th>标题</th>
							<th>Level</th>
							<th>时间</th>
							<th >Actions</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php 
						    foreach ($tag_bundles as $tag) { 
						?>
						<tr>
							<td width="5%"><?php echo $tag->tag_bundle_id;?></td>
							<td width="15%"><?php echo $tag->name;?></td>
							<td width="10%"><?php echo $tag->level;?></td>
							<td width="25%"><?php echo format_date($tag->created_at);?></td>
							<td class=" ">
								<a href="javascript:void(0);" rel="<?php echo $tag->tag_bundle_id;?>" class="bundles-edit btn btn-info tag-edit"> <i class="icon-edit icon-white tag-edit"></i> Edit </a>
								<a href="javascript:void(0);" rel="<?php echo $tag->tag_bundle_id;?>" class=" bundles-del btn btn-danger tag-delete" > <i class="icon-trash icon-white tag-delete"></i> Delete </a>
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

		$(".bundles-add").click(function(){
			mcc_link.layer.load_add_bundles();
		});
		

		$(".bundles-edit").click(function(){
			var thiz = $(this);
			var tag_bundle_id = thiz.attr("rel");
			mcc_link.layer.load_edit_bundles(tag_bundle_id);
		});
		
		$(".bundles-del").click(function(){
			var thiz = $(this);
			var tag_bundle_id = thiz.attr("rel");
			mcc_link.layer.remove_bundles(tag_bundle_id);
		});

	});
</script>