<div id="tags">
	<div class="clearfix"></div>
	<div class="row-fluid">
		<!-- tags -->
		<a href="javascript:void(0);"  class=" tags-add btn btn-primary"> Add </a>
		<div class="box ">
			<div class="box-content">
				<table class="table table-striped table-hover">
					<thead>
						<tr role="row">
							<th>id</th>
							<th>type</th>
							<th>right</th>
							<th>标题</th>
							<th>时间</th>
							<th class="">Actions</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php 
						    foreach ($tags as $tag) { 
						?>
						<tr>
							<td width="5%"><?php echo $tag->tag_id;?></td>
							<td width="15%"><?php echo $tag->type;?></td>
							<td width="5%"><?php echo $tag->right;?></td>
							<td width="15%"><?php echo $tag->name;?></td>
							<td width="25%"><?php echo format_date($tag->created_at);?></td>
							<td class="" >
								<a href="javascript:void(0);" rel="<?php echo $tag->tag_id;?>" class=" tags-edit btn btn-info tag-edit"> <i class="icon-edit icon-white tag-edit"></i> Edit </a>
								<a href="javascript:void(0);" rel="<?php echo $tag->tag_id;?>" class=" tags-del btn btn-danger tag-delete" > <i class="icon-trash icon-white tag-delete"></i> Delete </a>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>

				<div class="row-fluid">
					<div class="span12 center">
						<div class="dataTables_paginate paging_bootstrap pagination">
							<?php echo $pager->fav_output("/manage/tags/page%{page}/");?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end tags -->
	</div>
	<div class="clearfix"></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$(".tags-add").click(function(){
			mcc_link.layer.load_add_tags();
		});

		$(".tags-edit").click(function(){
			var thiz = $(this);
			var tags_id = thiz.attr("rel");
			mcc_link.layer.load_edit_tags(tags_id);
		});
		
		$(".tags-del").click(function(){
			var thiz = $(this);
			var tags_id = thiz.attr("rel");
			mcc_link.layer.remove_tags(tags_id);
		});
	});
</script>