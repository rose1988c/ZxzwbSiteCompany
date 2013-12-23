<?php
$tpl->add_javascript('camera/jquery.mobile.customized.min.js', 'camera');
$tpl->add_javascript('camera/jquery.easing.1.3.js', 'camera');
$tpl->add_javascript('camera/camera.js', 'camera');

$tpl->add_stylesheet('camera/camera.css', 'camera')?>
<div id="main" style="height: 400px;">
	<div class="camera_wrap camera_magenta_skin" id="camera_wrap_2">
		<div data-src="/www/img/camera/bridge.jpg"
			data-link="http://baidu.com" data-target="_blank">
			<div class="camera_caption fadeFromBottom">风景设计</div>
		</div>
		<div data-src="/www/img/camera/leaf.jpg">
			<div class="camera_caption fadeFromBottom">
				It uses a light version of jQuery mobile, <em>navigate the slides by
					swiping with your fingers</em>
			</div>
		</div>
		<div data-src="/www/img/camera/road.jpg">
			<div class="camera_caption fadeFromBottom">
				<em>It's completely free</em> (even if a donation is appreciated)
			</div>
		</div>
		<div data-src="/www/img/camera/sea.jpg">
			<div class="camera_caption fadeFromBottom">
				Camera slideshow provides many options <em>to customize your project</em>
				as more as possible
			</div>
		</div>
		<div data-src="/www/img/camera/shelter.jpg">
			<div class="camera_caption fadeFromBottom">
				景外设计<em>非常优美</em> (<a href="/" target="_blank">去看看</a>)
			</div>
		</div>
		<div data-src="/www/img/camera/tree.jpg">
			<div class="camera_caption fadeFromBottom">
				Different color skins and layouts available, <em>fullscreen ready
					too</em>
			</div>
		</div>
	</div>
</div>

<div class="clear"></div>

<div class="wrap" id="case">

    <div class="index-group" >
    	<div class="fl-box">
            <div class="hd">
				<h2 style="width: 240px;"><a class="f-Cf63" rel="nofollow" target="_blank" href="/case/">案例/Case</a></h2>
				<em><a target="_blank" rel="nofollow" href="/case/">更多..</a></em>
            </div>
            <div class="bd">
            	<div class="units-row">
            		<ul>
            			<li class="unit-50">
            			    <a href="CaseDetail.aspx?id=684">
            			        <img src="/www/img/zx/1.jpg" >
            				</a>
            			    <blockquote>
            			        <b>北纬22度</b>
            			        <p>北纬22度，是香港在地球上存在的位置。他是“亚洲四北纬22度，是香港在地球上存在的位置。他是“亚洲四 <a style="color: #8d553a" href="/case/355">[详细]</a></p>
            			    </blockquote>
            			</li>
            
            			<li class="unit-50">
            			    <a href="CaseDetail.aspx?id=689"><img src="/www/img/zx/1.jpg" ></a>
            			    <blockquote>
            			        <b>罗马假日</b>
            			        <p>美式风格，顾名思义是来自于美国的装修和装饰风格 。它奢 <a style="color: #8d553a" href="/case/355">[详细]</a></p>
            			    </blockquote>
            			</li>
            
            			<li class="unit-50"><a href="CaseDetail.aspx?id=699"><img
            					src="/www/img/zx/1.jpg" ></a>
            			    <blockquote>
            			        <b>鹿港小镇</b>
            			        <p>台式风格属于现代风格的一个衍生，体现一种大气和对称。香港 <a style="color: #8d553a" href="/case/355">[详细]</a></p>
            			    </blockquote>
            		    </li>
            
            			<li class="unit-50"><a href="CaseDetail.aspx?id=713"><img
            					src="/www/img/zx/1.jpg" ></a>
            			    <blockquote>
            			        <b>研磨时光</b>
            			        <p>“我自己的梦想，我最大的愿望是能够拥有一家咖啡屋，能 安静的研磨时光”</p>
            			    </blockquote>
            		    </li>
            
            			<li class="unit-50"><a href="CaseDetail.aspx?id=660"><img
            					src="/www/img/zx/1.jpg" ></a>
            			    <blockquote>
            			        <b>素锦年华</b>
            			        <p>户型解析：本案例三房两厅。是个难得的南北通透的好户型。</p>
            			    </blockquote>
            			</li>
            
            			<li class="unit-50"><a href="CaseDetail.aspx?id=688"><img
            					src="/www/img/zx/1.jpg" ></a>
            				<blockquote>
            			        <b>蓝色港湾</b>
            			        <p>美国是一个崇尚自由的国家，这也造就了其自在、随意的不羁生</p>
            			    </blockquote>
            		    </li>
            		</ul>
            	</div>
            
            </div>
        </div>
    </div>

    <div class="clear"></div>
    
</div>

<script>
jQuery(function(){
	jQuery('#camera_wrap_2').camera({
        height: '400px',
        loader: 'bar',
        pagination: false,
        thumbnails: false
    });
});
</script>