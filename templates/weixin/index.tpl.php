<html>
<head>
<link rel="stylesheet"
	href="http://cdn.staticfile.org/twitter-bootstrap/3.0.0-rc2/css/bootstrap.css" />
</head>
<body>

	<h2>查询</h2>
	<form class="form-horizontal" method="get" role="form">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<select name="a">
					<option
						<?php if ($_GET['a'] == 'getGroup'){ echo 'selected = selected;';} ?>
						value="getGroup">获得组</option>
					<option
						<?php if ($_GET['a'] == 'getGroupMember'){ echo 'selected = selected;';} ?>
						value="getGroupMember">获得组成员</option>
					<option
						<?php if ($_GET['a'] == 'getNew'){ echo 'selected = selected;';} ?>
						value="getNew">获得最新消息</option>
					<option
						<?php if ($_GET['a'] == 'getMsg'){ echo 'selected = selected;';} ?>
						value="getMsg">获得图文信息</option>
				</select>
				<button type="submit" class="btn btn-default">提交</button>
			</div>
		</div>
	</form>

	<h2>发送</h2>
	<div class="bs-example">
		<form class="form-horizontal" method="get" role="form">
			<div class="form-group">
				<label for="id" class="col-sm-2 control-label">用户id</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="id" placeholder="id">
				</div>
			</div>
			<div class="form-group">
				<label for="content" class="col-sm-2 control-label">内容</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="content"
						placeholder="content">
				</div>
			</div>
			<div class="form-group">
				<label for="msgid" class="col-sm-2 control-label">消息id（可为空）</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="msgid"
						placeholder="msgid">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">发送</button>
					<input type="hidden" name='a' value="send" />
				</div>
			</div>
		</form>
	</div>


	<h2>群发</h2>
	<form class="form-horizontal" method="get" role="form">
		<div class="form-group">
			<label for="groupid" class="col-sm-2 control-label">组id</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="groupid"
					placeholder="groupid">
			</div>
		</div>
		<div class="form-group">
			<label for="content" class="col-sm-2 control-label">内容</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="content"
					placeholder="content">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">发送</button>
				<input type="hidden" name='a' value="sendGroup" />
			</div>
		</div>
	</form>


</body>
</html>

