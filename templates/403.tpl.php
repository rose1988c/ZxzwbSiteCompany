<?php
$tpl->add_stylesheet('common/404.css', 'global');
$tpl->output_stylesheets();

$tpl->add_javascript('jquery/jquery-1.9.1.js', 'global');
$tpl->add_javascript('common/404.js', 'global');
$tpl->output_javascripts();
?>

<!-- Showing the image clouds, stars, and moon -->
<div id="clouds"></div>
<div id="stars"></div>
<div id="moon"></div>

<!-- BEGIN CONTENT -->
<div class="wrap_content">
	<h1>404</h1>
	<h2>Uh Oh, It's Dark <?php echo $error_message;?></h2>
	<br />
	<p>Sorry we are not sure what you looking for.</p>
	<p>
		Try returning to the <a href="/">front page</a> and starting over.
	</p>
</div>
<!-- End div content -->
<!-- END CONTENT -->

<!-- BEGIN BOTTOM -->
<div class="wrap_bottom">
	<div id="tumbleweed"></div>
	<div class="image_wrapper">
		<div id="house"></div>
	</div>
</div>
<!-- End div content -->
<!-- END CONTENT -->

<!-- BEGIN FOOTER -->
<div class="wrap_footer">
	<div class="content_footer">
		<div class="left">
			<a href="#"><img src="images/bug.png"> REPORT A BUG</a>
		</div>
	</div>
</div>
<!-- End div footer -->
<!-- END FOOTER -->
