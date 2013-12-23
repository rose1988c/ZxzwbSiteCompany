<!-- MESSAGES -->
<?php if ($msg->has_error()) { ?>
<div id="errors" class="infoBar-error" style="text-align:left;">
    <ul class="msg">
    	<?php echo $msg->flush_error('li', false); ?>
    </ul>
</div>
<script type="text/javascript">
	setTimeout(function(){$("#errors").fadeOut('fast');}, 5000);
</script>
<?php } ?>
<?php if ($msg->has_msg()) { ?>
<div id="messages" class="infoBar-succeed" style="text-align:left;">
    <ul class="msg">
    	<?php echo $msg->flush_msg('li', false); ?>
    </ul>
</div>
<script type="text/javascript">
	setTimeout(function(){$("#messages").fadeOut("fast");}, 10000);
</script>
<?php } ?>
<!-- END MESSAGES -->