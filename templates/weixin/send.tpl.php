<div class="bs-callout bs-callout-info">
	<h4>发送</h4>
</div>

<form role="form" action="/api/weixin/send/" method="get">
	<div class="form-group">
		<label for="fid">ID</label> <input type="text" class="form-control"
			id="fid" placeholder="id" name="id">
	</div>
	<div class="form-group">
		<label for="content">content</label> <input type="text"
			class="form-control" id="content" placeholder="content"
			name="content">
	</div>
	<button type="submit" class="btn btn-default">提交</button>
</form>

<?php 
    $msg->print_msg();
?>