<div class="modal-body">
	<label class="pull-left">用戶名</label>
	<input id="username" class="focus" name="username" type="text" placeholder="用戶名" value="" >
	
	<label class="pull-left">昵称</label>
	<input id="nickname" class="focus" name="nickname" type="text" placeholder="昵称" value="" >
	
	<label class="pull-left">用户组</label>
	<br/><br/><br/>
	<select name="roles" id="roles"  class="pull-left">
		<option value="">普通用户</option>
		<option value="admin">管理员</option>
		<option value="vip">VIP</option>
	</select>
	
	<input type="hidden" id="formhash" value="<?php echo get_formhash();?>" />
</div>

<div class="modal-footer">
	<div class="pull-left">
		<p style="margin-top: 10px;"></p>
	</div>
	<button  class="btn btn-primary confirm" type="button">添加</button>
</div>