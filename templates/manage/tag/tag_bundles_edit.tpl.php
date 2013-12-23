<div class="modal-body">

	<label class="pull-left">名称</label>
	<input tabindex="1"  id="name" class="focus" name="name" type="text" placeholder="名称" value="<?php echo $tag_bundle->name;?>"  autofocus  autocomplete="disabled" />

	<label class="pull-left">Level</label>
	<input  tabindex="2"  id="level" class="focus" name="level" type="text" placeholder=" 等级" value="<?php echo $tag_bundle->level;?>"  autocomplete="disabled" />

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