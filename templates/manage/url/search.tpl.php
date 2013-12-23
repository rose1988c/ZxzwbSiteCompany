<div class="row-fluid">
	<div class="contentbox">
		<a href="javascript:void(0);"  class=" url-add btn green"> Add New <i class="icon-plus"></i></a>
		<form action="<?php echo $_SERVER['REQUEST_URI'] . 'search/';?>" class="form-search pull-right">
            <div class="input-append">
                <select class="m-wrap" name="type">
                    <option <?php if ($type == 'tags'){ echo 'selected="selected"';}?> value="tags">tags</option>
                    <option <?php if ($type == 'url_id'){ echo 'selected="selected"';}?> value="url_id">url_id</option>
                    <option <?php if ($type == 'user_id'){ echo 'selected="selected"';}?> value="user_id">user_id</option>
                    <option <?php if ($type == 'url'){ echo 'selected="selected"';}?> value="url">url</option>
                    <option <?php if ($type == 'title'){ echo 'selected="selected"';}?> value="title">title</option>
                    <option <?php if ($type == 'description'){ echo 'selected="selected"';}?> value="description">description</option>
                    <option <?php if ($type == 'hostname'){ echo 'selected="selected"';}?> value="hostname">hostname</option>
                </select>
                <input class="m-wrap" name="q" value="<?php echo $q;?>" type="text" placeholder="Search Url">
                <button class="btn green" type="submit">Search</button>
            </div>
        </form>
		<!-- user -->
		<div class="box">
			<div class="box-content">

				<table class="table table-striped">
					<thead>
						<tr role="row">
							<th>链接</th>
							<th>标题</th>
							<th>标签</th>
							<th>时间</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						foreach ( $urls as $url ) {
							?>
						<tr>
							<td><a target="_blank" href="<?php echo $url->url;?>"><?php echo $url->url;?></a></td>
							<td width="20%"><abbr title="<?php echo $url->description;?>"><?php echo $url->title;?></abbr></td>
							<td><?php echo $url->tags; ?></td>
							<td><?php echo format_date($url->created_at);?></td>
							<td class="center "><a href="javascript:void(0);"
								rel="<?php echo $url->url_id;?>" class="urls-edit btn btn-info url-edit">
									<i class="icon-edit icon-white"></i> Edit
							</a> <a href="javascript:void(0);"
								rel="<?php echo $url->url_id;?>"
								class="btn btn-danger url-del"> <i
									class="icon-trash icon-white"></i> Delete
							</a></td>
						</tr>
						<?php }?>
					</tbody>
				</table>

				<div class="row-fluid">
					<div class="span12 center">
						<div class="dataTables_paginate paging_bootstrap pagination">
							<?php echo $pager->fav_output("/manage/urls/page%{page}/");?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	$(document).ready(function(){

		$(".url-add").click(function(){
			mcc_link.layer.load_add_link();
		});

		$(".url-edit").click(function(){
			var thiz = $(this);
			var url_id = thiz.attr("rel");
			mcc_link.layer.load_edit_link(url_id);
		});

		$(".url-del").click(function(){
			var thiz = $(this);
			var url_id = thiz.attr("rel");
			mcc_link.layer.remove_user_link(url_id);
		});

	});
</script>