<div class="modal-body">
	<label class="pull-left">用戶名</label>
	<input id="username" class="focus" name="username" type="text" placeholder="用戶名" value="<?php echo $user->username;?>" >
	
	<label class="pull-left">昵称</label>
	<input id="nickname" class="focus" name="nickname" type="text" placeholder="昵称" value="<?php echo $user->nickname;?>" >
	
	<label class="pull-left">用户组</label>
	<br/><br/><br/>
	<select name="roles" id="roles"  class="pull-left">
		<option <?php if ($user->roles == ''){ echo ' selected="selected" ';}?> value="">普通用户</option>
		<option <?php if ($user->roles == 'admin'){ echo ' selected="selected" ';}?> value="admin">管理员</option>
		<option <?php if ($user->roles == 'vip'){ echo ' selected="selected" ';}?> value="vip">VIP</option>
	</select>
</div>

<div class="modal-footer">
	<div class="pull-left">
		<p style="margin-top: 10px;"></p>
	</div>
	<button  class="btn btn-primary confirm" type="button">添加</button>
</div>