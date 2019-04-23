<?php if (!defined('THINK_PATH')) exit();?>	
	</div><!--.layout-main-->	
</div>

<a id="scrollUp" href="#top" ></a>
<div id="ajaxLoading" style="display:none;"><div class="loading-bar"><img src="__PUBLIC__/Assets/img/waiting.gif"><?php echo lang('loading');?></div></div>
<script type="text/javascript">
$(function(){
$.scrollUp({scrollName: 'scrollUp'});
$(".pinned").pin();
$('.ui-table-body-hover tbody tr').hover(function(){ $(this).addClass('ui-table-row-hover');},function(){ $(this).removeClass('ui-table-row-hover');});
});
</script>
</body>
</html>