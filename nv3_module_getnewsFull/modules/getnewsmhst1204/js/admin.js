function nv_chang_cat(a,b){nv_settimeout_disable("id_"+b+"_"+a,5E3);var c=document.getElementById("id_"+b+"_"+a).options[document.getElementById("id_"+b+"_"+a).selectedIndex].value;nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=change_cat&catid="+a+"&mod="+b+"&new_vid="+c+"&num="+nv_randomPassword(8),"","nv_chang_cat_result")}
function nv_chang_cat_result(a){a=a.split("_");"OK"!=a[0]&&alert(nv_is_change_act_confirm[2]);clearTimeout(nv_timer);a=parseInt(a[1]);nv_show_list_cat(a)}function nv_show_list_cat(a){document.getElementById("module_show_list")&&nv_ajax("get",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=list_cat&parentid="+a+"&num="+nv_randomPassword(8),"module_show_list")}
function nv_del_cat(a){nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_cat&catid="+a,"","nv_del_cat_result");return!1}
function nv_del_cat_result(a){var b=a.split("_");"OK"==b[0]?(a=parseInt(b[1]),nv_show_list_cat(a)):"CONFIRM"==b[0]?confirm(nv_is_del_confirm[0])&&(a=b[1],b=b[2],nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_cat&catid="+a+"&delallcheckss="+b,"","nv_del_cat_result")):"ERR"==b[0]&&"CAT"==b[1]?alert(b[2]):"ERR"==b[0]&&"ROWS"==b[1]?confirm(b[4])&&(a=b[2],b=b[3],nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_cat&catid="+
a+"&delallcheckss="+b,"edit",""),parent.location="#edit"):alert(nv_is_del_confirm[2]);return!1}function nv_chang_topic(a,b){nv_settimeout_disable("id_"+b+"_"+a,5E3);var c=document.getElementById("id_"+b+"_"+a).options[document.getElementById("id_"+b+"_"+a).selectedIndex].value;nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=change_topic&topicid="+a+"&mod="+b+"&new_vid="+c+"&num="+nv_randomPassword(8),"","nv_chang_topic_result")}
function nv_chang_topic_result(a){"OK"!=a.split("_")[0]&&alert(nv_is_change_act_confirm[2]);clearTimeout(nv_timer);nv_show_list_topic()}function nv_show_list_topic(){document.getElementById("module_show_list")&&nv_ajax("get",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=list_topic&num="+nv_randomPassword(8),"module_show_list")}
function nv_del_topic(a){nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_topic&topicid="+a,"","nv_del_topic_result")}function nv_del_topic_result(a){a=a.split("_");"OK"==a[0]?nv_show_list_topic():"ERR"==a[0]?"ROWS"==a[1]?confirm(a[4])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_topic&topicid="+a[2]+"&checkss="+a[3],"","nv_del_topic_result"):alert(a[1]):alert(nv_is_del_confirm[2]);return!1}
function nv_chang_sources(a,b){nv_settimeout_disable("id_"+b+"_"+a,5E3);var c=document.getElementById("id_"+b+"_"+a).options[document.getElementById("id_"+b+"_"+a).selectedIndex].value;nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=change_source&sourceid="+a+"&mod="+b+"&new_vid="+c+"&num="+nv_randomPassword(8),"","nv_chang_sources_result")}
function nv_chang_sources_result(a){"OK"!=a.split("_")[0]&&alert(nv_is_change_act_confirm[2]);clearTimeout(nv_timer);nv_show_list_source()}function nv_show_list_source(){document.getElementById("module_show_list")&&nv_ajax("get",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=list_source&num="+nv_randomPassword(8),"module_show_list")}

function nv_del_source(a){confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_source&sourceid="+a,"","nv_del_source_result");return!1}function nv_del_source_result(a){a=a.split("_");"OK"==a[0]?nv_show_list_source():"ERR"==a[0]?alert(a[1]):alert(nv_is_del_confirm[2]);return!1}

function nv_del_block_cat(a){confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_block_cat&bid="+a,"","nv_del_block_cat_result");return!1}function nv_del_block_cat_result(a){a=a.split("_");"OK"==a[0]?nv_show_list_block_cat():"ERR"==a[0]?alert(a[1]):alert(nv_is_del_confirm[2]);return!1}
function nv_chang_block_cat(a,b){nv_settimeout_disable("id_"+b+"_"+a,5E3);var c=document.getElementById("id_"+b+"_"+a).options[document.getElementById("id_"+b+"_"+a).selectedIndex].value;nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=chang_block_cat&bid="+a+"&mod="+b+"&new_vid="+c+"&num="+nv_randomPassword(8),"","nv_chang_block_cat_result")}
function nv_chang_block_cat_result(a){"OK"!=a.split("_")[0]&&alert(nv_is_change_act_confirm[2]);clearTimeout(nv_timer);nv_show_list_block_cat()}function nv_show_list_block_cat(){document.getElementById("module_show_list")&&nv_ajax("get",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=list_block_cat&num="+nv_randomPassword(8),"module_show_list")}
function nv_chang_block(a,b,c){nv_settimeout_disable("id_weight_"+b,5E3);var d=document.getElementById("id_weight_"+b).options[document.getElementById("id_weight_"+b).selectedIndex].value;nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=change_block&id="+b+"&bid="+a+"&&mod="+c+"&new_vid="+d+"&num="+nv_randomPassword(8),"","nv_chang_block_result")}
function nv_chang_block_result(a){a=a.split("_");"OK"!=a[0]&&alert(nv_is_change_act_confirm[2]);a=parseInt(a[1]);nv_show_list_block(a)}function nv_show_list_block(a){document.getElementById("module_show_list")&&nv_ajax("get",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=list_block&bid="+a+"&num="+nv_randomPassword(8),"module_show_list")}
function nv_del_block_list(a,b){var c="",d=a["idcheck[]"];if(d.length)for(var e=0;e<d.length;e++)d[e].checked&&(c=c+","+d[e].value);else d.checked&&(c=c+","+d.value);""!=c&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=change_block&del_list="+c+"&bid="+b+"&num="+nv_randomPassword(8),"","nv_chang_block_result")}

function nv_main_action(a,b,c){var d=a["idcheck[]"],a="";if(d.length)for(var e=0;e<d.length;e++)d[e].checked&&(a=a+d[e].value+",");else d.checked&&(a=a+d.value+",");""!=a?(c=document.getElementById("action").value,"delete"==c?confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_content&listid="+a+"&checkss="+b,"","nv_del_content_result"):window.location.href="addtoblock"==c?script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+
"=block&listid="+a+"#add":"publtime"==c?script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=publtime&listid="+a+"&checkss="+b:"exptime"==c?script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=exptime&listid="+a+"&checkss="+b:script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=addtotopics&listid="+a):alert(c)}

function nv_main_action1(a,b,c)
{
    var d=a["idcheck[]"],a="";
    if(d.length)
        for(var e=0;e<d.length;e++)d[e].checked&&(a=a+d[e].value+",");
    else d.checked&&(a=a+d.value+",");
    ""!=a?nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_chuyenmuc&listid="+a,"","nv_del_content_result1"):alert(c)
}
function nv_main_action2(a,b,c){
        var d=a["idcheck[]"],a="";
        if(d.length)
            for(var e=0;e<d.length;e++)d[e].checked&&(a=a+d[e].value+",");
        else d.checked&&(a=a+d.value+",");
        if(""!=a)
        {
            c=document.getElementById("action").value;
            if(c=="lientuc" || c=="binhthuong"|| c=="it")
            {
                nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=changestatus&listid="+a+"&type="+c,"","nv_result1");
            }
            else if(c=="tudong" || c=="khongtudong")
            {
                nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=auto&listid="+a+"&auto="+c,"","nv_result1");
            }
            else
            {}
        }
        else
        {
            alert(c);
        }
} 

function nv_main_action_auto(a,b,c)
{
    var d=a['idcheck[]'],a="";
    if(d.length)
            for(var e=0;e<d.length;e++)d[e].checked&&(a=a+d[e].value+",");
        else d.checked&&(a=a+d.value+",");
        if(""!=a)
        {
            c=document.getElementById("action1").value;
            e=document.getElementById("web").value;
            if(c=="delete" )
            {
                nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_content&auto=1&listid="+a+"&web="+e,"","nv_result1");
            }
            else if(c=="publtime")
            {
                f=document.getElementById('catid').value;
                $("#thongbao").text("Đang lấy tin...");
                nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=savenewsauto&listid="+a+"&act="+c+"&catid="+f,"","nv_result2");
            }
            else
            {}
        }
        else
        {
            alert(c);
        }
}       
function nv_result1(a){
    a=a.split("_");
    //if(a[0]=="OK") $("#thongbao").text();
    "OK"==a[0]?window.location.href=script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=nklaytintudong&web="+a[1]:alert("Không thực hiện được!");
    return!1}
function nv_result2(a){
    a=a.split("_");
    "OK"==a[0]?window.location.href=script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=nklaytintudong&web="+a[1]:alert(a[1]);
    window.location.href=script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=nklaytintudong&web="+a[1];
    return!1}    
function nv_del_content(a,b){
    confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_content&id="+a+"&checkss="+b,"","nv_del_content_result");
    return!1
}function nv_del_content1(a){
    confirm(nv_is_del_confirm[0])&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=del_chuyenmuc&idcm="+a,"","nv_del_content_result1");
    return!1
}
function nv_del_content_result1(a){
    a=a.split("_");
    "OK"==a[0]?window.location.href=script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=cat":"ERR"==a[0]?alert(a[1]):alert(nv_is_del_confirm[2]);return!1}
function nv_check_movecat(a,b){if(0==a.catidnews.value)return alert(b),!1}
function nv_del_content_result(a){
    a=a.split("_");
    "OK"==a[0]?window.location.href=script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=main":"ERR"==a[0]?alert(a[1]):alert(nv_is_del_confirm[2]);return!1}
function create_keywords(){var a=strip_tags(document.getElementById("keywords").value);""!=a&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=keywords&content="+encodeURIComponent(a),"","res_keywords");return!1}function res_keywords(a){"n/a"!=a?document.getElementById("keywords").value=a:document.getElementById("keywords").value="";return!1}
function get_alias(a,b){var c=strip_tags(document.getElementById("idtitle").value);""!=c&&nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=alias&title="+encodeURIComponent(c)+"&mod="+a+"&id="+b,"","res_get_alias");return!1}function res_get_alias(a){""!=a?document.getElementById("idalias").value=a:document.getElementById("idalias").value="";return!1}
function findValue(a){return null==a?alert("No match!"):a.extra?a.extra[0]:a.selectValue}function selectItem(a){sValue=findValue(a)}function formatItem(a){return a[0]+" ("+a[1]+")"}

function savelttd(idcm)
{
    var a1=$("#chonloai"+idcm).val();
    var a2=$("#auto"+idcm).val();
    confirm("Lưu chỉnh sửa?")&& nv_ajax("post",script_name,nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=saveconfignktt&idcm="+idcm+"&chonloai="+a1+"&auto="+a2,"","savelttd1");
}

function savelttd1(a)
{
    a=a.split("_");
    "OK"==a[0]?window.location.href=script_name+"?"+nv_name_variable+"="+nv_module_name+"&"+nv_fc_variable+"=nklaytintudong":alert("Cập nhật tin tức không thành công!");return!1;
}
$(document).ready(function(){$(".message_list .message_body:gt(1)").hide();$(".message_list li:gt(5)").hide();$(".message_head").click(function(){$(this).next(".message_body").slideToggle(500);return!1});$(".collpase_all_message").click(function(){$(".message_body").slideUp(500);return!1});$(".show_all_message").click(function(){$(".message_body").slideDown(1E3);return!1})});

