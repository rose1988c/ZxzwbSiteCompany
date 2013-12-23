<!DOCTYPE html>
<html>
<head>
  <title>Page not found</title>
  <meta charset="utf-8" />

  <?php
    $tpl->add_stylesheet('common/404.css', 'global');
    $tpl->output_stylesheets();
    
    $tpl->add_javascript('jquery/jquery-1.9.1.js', 'global');
    $tpl->add_javascript('common/404.js', 'global');
    $tpl->add_javascript('common/jQueryRotate.js', 'global');
    $tpl->output_javascripts();
   ?>
  
</head>

<body>
    <!-- Showing the image clouds, stars, and moon -->
    <div id="clouds"></div>
    <div id="stars"></div>
    <div id="moon"></div>

    <!-- BEGIN CONTENT -->
    <div class="wrap_content">
      <h1>404</h1>
      <h2>Uh Oh, It's Dark</h2><br/>
      <p>黑夜给了我黑色的眼睛，可我却用它来寻找光明。</p>
      <p>尝试返回<a href="/">首页</a></p>
    </div><!-- End div content -->
    <!-- END CONTENT -->

    <!-- BEGIN BOTTOM -->
    <div class="wrap_bottom">
      <div id="tumbleweed"></div>
      <div class="image_wrapper">
        <div id="house"></div>
      </div>
    </div><!-- End div content -->
    <!-- END CONTENT -->

    <!-- BEGIN FOOTER -->
    <div class="wrap_footer">
      <div class="content_footer">
        <div class="left"><a href="javascript:void(0);"><img src="/www/img/404/bug.png"> REPORT A BUG</a></div>
      </div>
    </div><!-- End div footer -->
    <!-- END FOOTER -->

</body>
</html>