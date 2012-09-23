<!-- BEGIN: main -->
<!-- BEGIN:getinfomation -->
<form id="form1" action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=rss" method="post">
    {LANG.laytintheo}
    <select name="loaitin" id="loaitin">
        <option value="-1">{LANG.luachon}</option>
        {loaitin}
    </select>
    {LANG.linksite}
    <select name="trangtin" id="trangtin">
        <option value="chon">{LANG.luachon}</option>
        {trangtin}
    </select>
    {LANG.chonchuyenmuc}
    <select name="chuyenmuc" id="chuyenmuc">
        <option value="-1">{LANG.luachon}</option>
        {chuyenmuc}
    </select>
    <input  type="hidden" value="{thamso}" name="action" id="action"/>
    
</form>
<!-- END: getinfomation -->
<div>
<!-- BEGIN: receive -->
<form id="formgui" action="" method="post" >
<div id="receive_inf" style="margin-top: 10px; width: 100%; float: left;">
    {source}
</div>
</form>
<!-- END: receive -->
 
<!--BEGIN: Action -->
<div>
<form id="active" action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=savenews&site={linksite}" method="post">
    <!--BEGIN: ListCat -->
    <div style="margin-top:10px; float:left; width:100%;">
    <div style="height:10px"></div>
    {choncm}
    {listcats}
    <!--END: ListCat -->
    {action}
</form>
</div>
</div>
<!--END: Action -->
<style>
#receive_inf
{
    height:500px;
    overflow:scroll;
}
.clearfix:after, .container:after {
    clear: both;
    content: "?020";
    display: block;
    height: 0;
    overflow: hidden;
    visibility: hidden;
}
.box, .box-border, .box-border-shadow, .content-box, .block-signed a, .clearfix, .container, .sideon {
    display: block;
    width:500px;
    float: left;
    margin:5px 5px;
    border:1px solid white;
    padding-top: 5px;
}
.folder-bottom {
    background: url(../../themes/admin_default/images/getnews/bg_vne.gif) repeat-x scroll 0 -73px #F5F5F6;
}
img.s-border {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #D8D8D8;
    padding: 4px;
}
.fl {
    float: left;
}
.left {
    margin-right: 0.875em !important;
}
a
{
    text-decoration: none;
}
.check
{
    border:1px solid black;
}
p
{
    padding-top:5px;
    text-align: justify;
    padding-right:5px;
}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#loaitin").change(function(){
            var a=$("#loaitin").val();
            if(a>=0)$("#form1").submit();
        })
        
        $("#trangtin").change(function(){
            var b=$("#trangtin").val();
            if(b!="chon")$("#form1").submit();
        })
        
        $("#chuyenmuc").change(function(){
            var c=$("#chuyenmuc").val();
            var d=$("#loaitin").val();
            $("#action").val(Number(d)+1);
            if(c>=0)$("#form1").submit();
        })
        
        var count='{count}';
        var arrLink=new Array();
        for(var i=0;i<count;i++)
        {
            $("#content"+i).click(function(){
                $(this).toggleClass('check');
            })
        }
        
        $("#getNews").click(function(){
            var t=$("input[name='catids[]']:checked").length;
            for(var i=0;i<count;i++)
            {
                var check=$("#content"+i).hasClass('check');
                if(check)
                {
                    var link=$("#link"+i).val();
                    arrLink.push(link);
                }
            }
            if(arrLink!=null && t>0)
            {
                $("#getLink").val(arrLink);
                $("#chucnang").val("1");
                $("#active").submit();
            }
            else alert("Chưa chọn đủ thông tin");
        })
        
        $("#wait").click(function(){
            var y=$("input[name='catids[]']:checked").length;
            for(var i=0;i<count;i++)
            {
                var checky=$("#content"+i).hasClass('check');
                if(checky)
                {
                    var linky=$("#link"+i).val();
                    arrLink.push(linky);
                }
            }
            if(arrLink!=null && t>0)
            {
                $("#getLink").val(arrLink);
                $("#chucnang").val("0");
                $("#active").submit();
            }
            else alert("Chưa chọn đủ thông tin");            
        })
        
        $("#gettintuc").click(function(){
            var z=$("input[name='catids[]']:checked").length;
            var g=$("input[name='idcheck[]']:checked").length;
            if(z>0 && g>0)
            {
                $("#chucnang").val("1");
                var arr=[];
                $("input[name='idcheck[]']:checked").each(function() {
                    var tep=$(this).val();
                    arr.push(tep);
                });
                
                $("#getLink").val(arr);
                $("#active").submit();
            }
            else alert("Chưa chọn đủ thông tin");
        })
        $("#back").click(function(){
            var h=$("input[name='catids[]']:checked").length;
            var k=$("input[name='idcheck[]']:checked").length;
            if(h>0 && k>0)
            {
                $("#chucnang").val("0");
                var arr=[];
                $("input[name='idcheck[]']:checked").each(function() {
                    var tep=$(this).val();
                    arr.push(tep);
                });
                
                $("#getLink").val(arr);
                $("#active").submit();
            }
            else alert("Chưa chọn đủ thông tin");
        })
    })
    function laytin(a,b,c)
    {alert("OK");
        var d=a["idcheck[]"],a="";
        if(d.length)
            for(var e=0;e<d.length;e++)
                d[e].checked&&(a=a+d[e].value+",");
        else d.checked&&(a=a+d.value+",");
        alert(a);
    }
</script>
<!--END: main -->

