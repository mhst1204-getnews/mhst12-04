<!-- BEGIN: main -->
<!-- BEGIN: getlink -->
<form action="" method="post" id="form1">
   <table summary="" class="tab1">
		<caption>{LANG.taonhomlaytin}</caption>
		<tbody>
            <tr>
				<td>
                    {tencm}
                    <select name="isrss" id="isrss">
                    {isrss}
                    </select>
                    
                </td>
            </tr>
        </tbody>
    </table>
    {frame}
    <div align="center" style="padding-top:10px;">
        <input type="hidden" value="" name="check" id="check"/>
        <input type="button" name="saveconfig" id="saveconfig" value="{LANG.saveconfig}" />
    </div>           
</form>
<br />
<!-- END: getlink -->


<script type="text/javascript">
    $(document).ready(function(){
        $("#isrss").change(function(){
            var a=$("#isrss").val();
            var b=$("#linkcm").val();
            if(a==0 && b!="Đường dẫn tới chuyên mục") $("#form1").submit();
        })
        $("#saveconfig").click(function(){
            var rs=$("#isrss").val();
            var a=$("#tencm").val();
            var b=$("#linkcm").val();
            if(rs<3 && a!='{LANG.chuyenmuc}' && b!='{LANG.linkchuyenmuc}')
            {
                $("#check").val("ok");
                $("#form1").submit();
            }
            else alert('Chưa chọn đủ chức năng');
        })
    })
</script>
<style>
   
div.my_wrapper {
}
div.my_header {
    border: 1px solid gray;
    height: 100px;
    overflow: hidden;
    padding: 10px;
    width: 610px;
}
li.my_nav_link {
    float: right;
    list-style: none outside none;
    padding-left: 15px;
    text-align: right;
}
div.my_left_box {
    border: 1px solid gray;
    float: left;
    padding: 10px;
    width: 40%;
}
div.my_right_box {
    border: 1px solid gray;
    float: left;
    padding: 10px;
    width: 40%;
}
div.my_footer {
    border: 1px solid gray;
    clear: both;
    padding: 10px;
    width: 82%;
}
</style>
<!--END: main -->