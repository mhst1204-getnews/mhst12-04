<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="quote" style="width:780px;">
    <blockquote class="error"><span>{ERROR}</span></blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->

<div style="width:100%; height:400px; overflow: auto;" id="div_contents">
    {noidung}
</div>
<input  type="hidden" value="{xpath}" id="xpath" name="xpath"/>
<!-- BEGIN: receive -->
<form id="form1" action="{NV_BASE_SITEURL}admin/index.php?nv={MODULE_NAME}&op=getcontent" method="post">
    <table summary="" class="tab1">
		<caption>{LANG.config_receive_article}</caption>
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.title}: </strong></td>
				<td><input style="width: 650px" name="title" type="text" value="" id="tpath" maxlength="255" /></td>
			</tr>
            <tr>
                <td align="right"><strong>{LANG.head}</strong></td>
                <td>
                    <input style="width: 650px" name="title" type="text" value="" id="hpath" maxlength="255" />
                </td>
            </tr>
            <tr>
                <td align="right" style="width:60px;"><strong>{LANG.content}</strong></td>
                <td>
                    
                    <input style="width: 650px" name="title" type="text" value="" id="contentpath" maxlength="255" />
                </td>
            </tr>
		</tbody>
	</table>
    <br>
    <div align="center">
        
        <input  type="hidden" value="{site}" name="site" id="site"/>
        <input name="saveConfig" id="saveConfig" type="button" value="{LANG.saveconfig}" />
        <input name="exit" type="button" value="{LANG.exitconfig}" onclick="javascript:history.go(-1)" />
    </div>
</form>
<!-- END: receive -->

<script type="text/javascript">
$(document).ready(function(){
    var arr=new Array("tiêu đề","mô tả","nội dung");
    var arrID=new Array("tpath","hpath","contentpath");
    var arrColor=new Array("red","blue","green");
    var i=0;var g=0;var oldcolor="";
    $("#div_contents").bind('mouseout mouseover',function(event){
      var $tgt = $(event.target);
      var $z=event.target.nodeName;
      if ($tgt.closest($z).length) {
          $tgt.toggleClass('outline-element');
      }
    }).click(function(event){
            oldcolor=$(this).css("color");
            if($(event.target).attr("check")==null)
            {
                var childnodes=$(event.target).children().length;
                if(childnodes<5)
                {
                    $(event.target).attr("id","mark"+i+g).attr("check","true").css("color",arrColor[i]);
                    g=g+1;
                }
            }
            
            
    }).dblclick(function(event){
            var arrresul=new Array();
            var kq=confirm("Chọn làm "+arr[i]+" :");
            if(kq)
            {
                var xpath="{xpath}";
                for(var k=0;k<g;k++)
                {
                    var path=getXPath(document.getElementById("mark"+i+k));
                    var kq="";
                    for(var r=1;r<path.length;r++)
                    {
                        if(path[r]!=null)
                        {
                            kq=kq+path[r]+"/"; 
                        }
                           
                    }
                    arrresul[k]=kq.substring(0,kq.length-1);
                }
                for(var u=0;u<arrresul.length;u++)
                {
                    xpath=xpath+arrresul[u]+"@";
                }
                $("#"+arrID[i]).val(xpath);
                i=i+1;g=0;
            }
            else
            {
                $(event.target).removeAttr("id").removeAttr("check").css("color",oldcolor);
                g=g-1;
            }
        });
})
function getXPath(node, path) {
      path = path || [];
      if (node.parentNode && node.getAttribute("id")!="div_contents") {
          path = getXPath(node.parentNode, path);
      }
        
      if (node.previousSibling) {
          var count = 0;
          var sibling = node.previousSibling
          do {
              if (sibling.nodeType == 1) { count++; }
              sibling = sibling.previousSibling;
          }while (sibling);
      }
      if (node.nodeType == 1) {
          path.push(count);
      }
      
      return path;
  }

</script>
 <!--END: main -->