<!-- BEGIN: main -->
<!-- BEGIN:getinfomation -->
<form action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=getxml" method="post">
    {LANG.linksite}
    <input size="60" type="text" id="site" value="{linksite}" name="site"/>
    <input  type="submit" value="{LANG.save1}" id="select" name="select"/>
</form>
<!-- END: getinfomation -->
<!-- BEGIN: receive -->
<div id="receive_inf">
    {source}
</div>
<!-- END: receive -->
<!--END: main -->
<script type="text/javascript">
    $(document).ready(function(){
        
    })
</script>