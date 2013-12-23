<div class="row-fluid">
	<div class="contentbox">
		
		<a href="javascript:void(0);"  class="user-add btn btn-primary"> Add </a>

		<!-- user -->
		<div class="box">
			<div class="box-content">

				<table class="table table-striped table-hover ">
					<thead>
						<tr role="row">
							<th>用户id</th>
							<th>用户名</th>
							<th>昵称</th>
							<th>注册时间</th>
							<th>用户组</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						foreach ( $users as $user ) {
							?>
						<tr >
							<td width="5%"><?php echo $user->user_id;?></td>
							<td width="15%"><?php echo $user->username;?></td>
							<td width="15%"><?php echo $user->nickname;?></td>
							<td width="15%"><?php echo format_date($user->created_at);?></td>
							<td width="15%"><?php echo $user->roles; ?></td>
							<td width="25%" class="center ">
								<a href="javascript:void(0);" rel="<?php echo $user->user_id;?>" class="user-edit btn btn-info"> <i class="icon-edit icon-white tag-edit"></i> Edit 	</a> 
								<a href="javascript:void(0);" rel="<?php echo $user->user_id;?>" class="user-del btn btn-danger"> <i class="icon-trash icon-white tag-delete"></i> Delete	</a>
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

		$(".user-add").click(function(){
			mcc_link.layer.load_add_user();
		});
		
		$(".user-edit").click(function(){
			var thiz = $(this);
			var user_id = thiz.attr("rel");
			mcc_link.layer.load_edit_user(user_id);
		});
		
		$(".user-del").click(function(){
			var thiz = $(this);
			var user_id = thiz.attr("rel");
			mcc_link.layer.remove_user(user_id);
		});

	});
</script>