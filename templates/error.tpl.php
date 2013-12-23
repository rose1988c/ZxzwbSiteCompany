<?php
    //$tpl->set('page_heading', '发生错误');
    
    $real_error = '';
    if (strpos($error_message, 'Field') !== false && strpos($error_message, 'not exists in table') !== false) {
    	echo $real_error = $error_message;
    	$error_message = '数据错误';
    } else if ($error_message == 'Connection timed out') {
    	echo '<script type="text/javascript">window.reload();</script>';
    	exit(0);
    }
?>

<?php if(strlen($real_error) > 0) { echo '<!-- ' . $real_error . ' -->'; } ?>