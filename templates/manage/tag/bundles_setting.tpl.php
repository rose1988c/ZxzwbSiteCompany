<?php
	$tpl->add_stylesheet ( 'plugins/zTree/zTreeStyle/zTreeStyle.css', 'zTree' );
	$tpl->add_javascript ( 'plugins/zTree/jquery.ztree.core-3.5.js', 'zTree' );
	$tpl->add_javascript ( 'plugins/zTree/jquery.ztree.exedit-3.5.js', 'zTree' );
?>
<SCRIPT type="text/javascript">
	<!--
	var MoveTest = {
		errorMsg: "放错了...请选择正确的类别！",
		istype: false,
		curTarget: null,
		curTmpTarget: null,
		noSel: function() {
			try {
				window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty();
			} catch(e){}
		},
		dragTree2Dom: function(treeId, treeNodes) {
			return !treeNodes[0].isParent;
		},
		prevTree: function(treeId, treeNodes, targetNode) {
			return !targetNode.isParent && targetNode.parentTId == treeNodes[0].parentTId;
		},
		nextTree: function(treeId, treeNodes, targetNode) {
			return !targetNode.isParent && targetNode.parentTId == treeNodes[0].parentTId;
		},
		innerTree: function(treeId, treeNodes, targetNode) {
			return targetNode!=null && targetNode.isParent && targetNode.tId == treeNodes[0].parentTId;
		},
		dropTree2Dom: function(e, treeId, treeNodes, targetNode, moveType) {
			var domId = "dom_" + treeNodes[0].getParentNode().id;
			if (moveType == null ) {
				var zTree = $.fn.zTree.getZTreeObj("treeDemo");
				zTree.removeNode(treeNodes[0]);

				var newDom = $("span[domId=" + treeNodes[0].id + "]");
				if (newDom.length > 0) {
					newDom.removeClass("domBtn_Disabled");
					newDom.addClass("domBtn");

					//移除
				    $.post('/manage/bundles/ajax_remove_treepath',{
				    	tag_bundle_id : treeNodes[0].pId,
				    	tag_id : treeNodes[0].id
	    			},function(data){
	    			},'json');
				} else {
					$("#" + domId).append("<span class='domBtn' domId='" + treeNodes[0].id + "'>" + treeNodes[0].name + "</span>");
				}
				MoveTest.updateType();
			} else if ( $(e.target).parents(".domBtnDiv").length > 0) {
				alert(MoveTest.errorMsg);
			}
		},
		dom2Tree: function(e, treeId, treeNode) {
			var target = MoveTest.curTarget, tmpTarget = MoveTest.curTmpTarget;
			if (!target) return;
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"), parentNode;
			if (treeNode != null && treeNode.isParent ) {
				parentNode = treeNode;
			} else if (treeNode != null && !treeNode.isParent ) {
				parentNode = treeNode.getParentNode();
			}

			if (tmpTarget) tmpTarget.remove();
			if (parentNode) {
				var nodes = zTree.addNodes(parentNode, {id:target.attr("domId"), name: target.text()});
			    //{{{
			    $.post('/manage/bundles/ajax_save_treepath',{
			    	tag_bundle_id : nodes[0].pId,
			    	tag_id : nodes[0].id
    			},function(data){
			        if (data == "true") {
			            zTree.selectNode(nodes[0]);
			        }
    			},'json');
			    //}}}
			} else {
				target.removeClass("domBtn_Disabled");
				target.addClass("domBtn");
				alert(MoveTest.errorMsg);
			}
			MoveTest.updateType();
			MoveTest.curTarget = null;
			MoveTest.curTmpTarget = null;
		},
		updateType: function() {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			nodes = zTree.getNodes();
			for (var i=0, l=nodes.length; i<l; i++) {
				var num = nodes[i].children ? nodes[i].children.length : 0;
				nodes[i].name = nodes[i].name.replace(/ \(.*\)/gi, "") + " (" + num + ")";
				zTree.updateNode(nodes[i]);
			}
		},
		bindDom: function() {
			$(".domBtnDiv").bind("mousedown", MoveTest.bindMouseDown);
		},
		bindMouseDown: function(e) {
			var target = e.target;
			if (target!=null && target.className=="domBtn") {
				var doc = $(document), target = $(target),
				docScrollTop = doc.scrollTop(),
				docScrollLeft = doc.scrollLeft();
				target.addClass("domBtn_Disabled");
				target.removeClass("domBtn");
				curDom = $("<span class='dom_tmp domBtn'>" + target.text() + "</span>");
				curDom.appendTo("body");

				curDom.css({
					"top": (e.clientY + docScrollTop + 3) + "px",
					"left": (e.clientX + docScrollLeft + 3) + "px"
				});
				MoveTest.curTarget = target;
				MoveTest.curTmpTarget = curDom;

				doc.bind("mousemove", MoveTest.bindMouseMove);
				doc.bind("mouseup", MoveTest.bindMouseUp);
				doc.bind("selectstart", MoveTest.docSelect);
			}
			if(e.preventDefault) {
				e.preventDefault();
			}
		},
		bindMouseMove: function(e) {
			MoveTest.noSel();
			var doc = $(document), 
			docScrollTop = doc.scrollTop(),
			docScrollLeft = doc.scrollLeft(),
			tmpTarget = MoveTest.curTmpTarget;
			if (tmpTarget) {
				tmpTarget.css({
					"top": (e.clientY + docScrollTop + 3) + "px",
					"left": (e.clientX + docScrollLeft + 3) + "px"
				});
			}
			return false;
		},
		bindMouseUp: function(e) {
			var doc = $(document);
			doc.unbind("mousemove", MoveTest.bindMouseMove);
			doc.unbind("mouseup", MoveTest.bindMouseUp);
			doc.unbind("selectstart", MoveTest.docSelect);

			var target = MoveTest.curTarget, tmpTarget = MoveTest.curTmpTarget;
			if (tmpTarget) tmpTarget.remove();

			if ($(e.target).parents("#treeDemo").length == 0) {
				if (target) {
					target.removeClass("domBtn_Disabled");
					target.addClass("domBtn");
				}
				MoveTest.curTarget = null;
				MoveTest.curTmpTarget = null;
			}
		},
		bindSelect: function() {
			return false;
		}
	};

	var setting = {
		edit: {
			enable: true,
			showRemoveBtn: false,
			showRenameBtn: false,
			drag: {
				prev: MoveTest.prevTree,
				next: MoveTest.nextTree,
				inner: MoveTest.innerTree
			}
		},
		data: {
			keep: {
				parent: true,
				leaf: true
			},
			simpleData: {
				enable: true
			}
		},
		callback: {
			beforeDrag: MoveTest.dragTree2Dom,
			onDrop: MoveTest.dropTree2Dom,
			onMouseUp: MoveTest.dom2Tree
		},
		view: {
			selectedMulti: false
		}
	};

	var zNodes =<?php echo json_encode($trees);?>;

	$(document).ready(function(){
		$.fn.zTree.init($("#treeDemo"), setting, zNodes);
		MoveTest.updateType();
		MoveTest.bindDom();
	});
	//-->
</SCRIPT>
<style type="text/css">
	.domTreeDiv{ float:left; width:250px; }
	.domBtnDiv{ float:left; width:auto;}
	.dom_line {margin:2px;border-bottom:1px gray dotted;height:1px}
	.domBtnDiv {display:block;padding:2px;border:1px gray dotted;background-color:powderblue}
	.categoryDiv {display:inline-block; width:auto;}
	.domBtn {display:inline-block;cursor:pointer;padding:2px;margin:5px 10px;border:1px gray solid;background-color:#FFE6B0}
	.domBtn_Disabled {display:inline-block;cursor:default;padding:2px;margin:2px 10px;border:1px gray solid;background-color:#DFDFDF;color:#999999}
	.dom_tmp {position:absolute;font-size:12px;}
</style>
    
<div class="row-fluid">
	<div class="contentbox">
		<div class="box">
			<div class="box-content">
			
			    <div class="domTreeDiv">
    			    <ul id="treeDemo" class="ztree"></ul>
			    </div>
			    
				<div class="domBtnDiv">
					<div id="dom_10" class="categoryDiv">
					    <?php foreach ($tags as $key => $tag) {?>
					        <?php if ($key!= 0 && $key%7 == 0) {?>
            					<div class="dom_line"></div>
					        <?php }?>
					        <?php 
					        	$dombtnClass = in_array($tag->tag_id, $exitsTreeNodes) ? 'domBtn_Disabled' : 'domBtn';
					        ?>
    					    <span class="<?php echo $dombtnClass;?>" domId="<?php echo $tag->tag_id;?>"><?php echo$tag->name;?></span>
					    <?php }?>
					 </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
	});
</script>