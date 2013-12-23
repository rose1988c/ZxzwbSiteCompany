<div class="page-sidebar nav-collapse collapse">
	<!-- BEGIN SIDEBAR MENU -->
	<ul class="page-sidebar-menu">
		<li>
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
			<div class="sidebar-toggler hidden-phone"></div>
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		</li>
		<li>
			<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
			<form class="sidebar-search">
				<div class="input-box">
					<a href="javascript:;" class="remove"></a>
					<input type="text" 	placeholder="Search..." />
					<input type="button" class="submit"	value=" " />
				</div>
			</form>
			<!-- END RESPONSIVE QUICK SEARCH FORM -->
		</li>
		
		<?php 
		    foreach (Manage::$MenuSidebar as $key => $menu) {
                $active = isset($active) ? $active : false;
                $is_active = isset($menu['active']) ? $menu['active'] == $active : false;
		?>
        		<li class="<?php if ($key == 0) { echo 'start '; } 
	                             if ( $is_active ) { echo 'active'; } ?>">
        		    <a href="<?php echo $menu['url'];?>"> <i class="<?php echo $menu['icon'];?>"></i>
        				<span class="title"><?php echo $menu['name'];?></span> 
        				<span class="<?php if ($key == 0) { echo 'start'; } else { echo 'arrow';} ?>"></span>
        		    </a>
        		    <!-- 子菜单 -->
        		    <?php 
        		        if (isset($menu['sub-menu'])) {
        		    ?>
        			<ul class="sub-menu">
        			    <?php foreach ($menu['sub-menu'] as $submenu) { ?>
        		        <?php 
        		            $sub_active = isset($sub_active) ? $sub_active : false;
        		            $is_active = isset($submenu['sub-active']) ? $submenu['sub-active'] == $sub_active : false;
        		        ?>
        				<li class="<?php if ($is_active) { echo 'active'; }?>"><a href="<?php echo $submenu['url'];?>"><i class="<?php echo $submenu['icon'];?>"></i><?php echo $submenu['name'];?></a></li>
        			    <?php }?>
        			</ul>
        			<?php }?>
        			<!-- end 子菜单 -->
        		</li>
		<?php  } ?>
	</ul>
	<!-- END SIDEBAR MENU -->
</div>