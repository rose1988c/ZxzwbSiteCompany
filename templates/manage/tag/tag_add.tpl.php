<div class="modal-body">
	<label class="pull-left">名称</label>
	<input tabindex="1"  id="name" class="focus" name="name" type="text" placeholder="名称" value=""  autofocus  autocomplete="disabled" />
	
	<label class="pull-left">type</label>
	<input  tabindex="2"  id="type" class="focus" name="type" type="text" placeholder=" type" value=""  autocomplete="disabled" />
	
	<label class="pull-left">权限</label>
	<select id="right" name="right" style="width: 100%;" class="focus">
	    <option value="0">普通</option>
	    <option value="1">只限管理员</option>
	</select>
	
	<input type="hidden" id="formhash" value="<?php echo get_formhash();?>" />
</div>

<div class="modal-footer">
	<div class="pull-left">
		<p style="margin-top: 10px;"></p>
	</div>
	<button  class="btn btn-primary confirm" type="button">添加</button>
</div>
<script>
$(document).ready(function(){
    $('input').keydown(function(e){
    	if( e.keyCode == 13 )
        {
    		$(".confirm").click();
        }
    });
});
</script>