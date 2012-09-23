<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

global $db;

//Lay thong tin cho phan chuyen muc
$sql="select idcm,tencm,lasttime,nexttime,type,news,auto,host from chuyenmuc";
$result=$db->sql_query($sql);$row=array();
while(list($idcm,$tencm,$lasttime,$nexttime,$type,$news,$auto,$host)=$db->sql_fetchrow($result))
{
    $last=nv_date("l, d/m/Y H:i",$lasttime);
    $loai="";$tudonglay="";
    $tudonglay.="<select name=\"auto\" id=\"auto".$idcm."\">";
    for($i=0;$i<2;$i++)
    {
        $tudong=$i==1?$lang_module['auto']:$lang_module['noauto'];
        $tudonglay.="<option value='".$i."'".(($i==$auto)?"selected='selected'":'').">".$tudong."</option>";
    }
    $tudonglay.="</select>";
    
    $z=$db->sql_query("select chose from config where action='".$type."'");
    $arr=array("lientuc","binhthuong","it");
    $loai.="<select name=\"chonloai\" id=\"chonloai".$idcm."\">";
    for($i=0;$i<count($arr);$i++)
    {
        $loai.="<option value='".$arr[$i]."'".(($arr[$i]==$type)?"selected='selected'":'').">".$lang_module[$arr[$i]]."</option>";
    }
    $loai.="</select>";
    $next=nv_date("l, d/m/Y H:i",$nexttime);
    $feature=luu($idcm);
    $row[]=array("idcm"=>$idcm,"tencm"=>$tencm,"tenhost"=>$host,"lasttime"=>$last,"nexttime"=>$next,"type"=>$loai,"news"=>$news,"auto"=>$tudonglay,"feature"=>$feature);
}
$array_list_action = array('lientuc' => $lang_module['ttlientuc'], 'binhthuong' => $lang_module['ttbinhthuong'],
    'it' => $lang_module['ttit'],'tudong'=>$lang_module['tttudong'],'khongtudong'=>$lang_module['ttkotudong']);
    
$action = array();
while (list($catid_i, $title_i) = each($array_list_action))
{
    $action[] = array("value" => $catid_i, "title" => $title_i);
}


//Het phan thong tin chuyen muc
$che="";
if(isset($_REQUEST['web']))
{
    $che=$_REQUEST['web'];
}
$per_page = 10;
//Lay thong tin cho phan tin tuc
$page=$page = $nv_Request->get_int('page', 'get', 0);
$sql1=$db->sql_query("select id,title,tencm,host,auto_news.link from auto_news,chuyenmuc where auto_news.idcm=chuyenmuc.idcm and chuyenmuc.host='".$che."'");
$num=$db->sql_numrows($sql1);$all_page = ($num > 1) ? $num : 1;
$tintuc=$db->sql_query("select id,title,tencm,host,auto_news.link from auto_news,chuyenmuc where auto_news.idcm=chuyenmuc.idcm and chuyenmuc.host='".$che."' limit ".$page.",".$per_page);
$mang=array();
while(list($id,$tieude,$tenchuyenmuc,$host1,$linksite)=$db->sql_fetchrow($tintuc))
{
    $mang[]=array("id"=>$id,"tieude"=>$tieude,"chuyenmuc"=>$tenchuyenmuc,"host"=>$host1,"linksite"=>$linksite);
}
$action2 = array();
$array_list_action1 = array('delete' => $lang_global['delete'], 'publtime' => $lang_module['publtime']);
while (list($catid_i1, $title_i1) = each($array_list_action1))
{
    $action2[] = array("value" => $catid_i1, "title" => $title_i1);
}
$query="select distinct host from chuyenmuc";
$ket=$db->sql_query($query);$web="";
while(list($website)=$db->sql_fetchrow($ket))
{
    $web.="<option value='".$website."'".($che==$website?"selected='selected'":'').">".$website."</option>";
}
$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_data .
        "&amp;" . NV_OP_VARIABLE . "=nklaytintudong&web=".$che;
$generate_page = nv_generate_page($base_url, $all_page, $per_page, $page);
$val_cat_content = array();$catid=0;
$val_cat_content[] = array("value" => 0, "selected" => ($catid == 0) ?
    " selected=\"selected\"" : "", "title" => $lang_module['search_cat_all']);
$array_cat_view = array();
foreach ($global_array_cat as $catid_i => $array_value)
{
    $lev_i = $array_value['lev'];
    $check_cat = false;
    if (defined('NV_IS_ADMIN_MODULE'))
    {
        $check_cat = true;
    } elseif (isset($array_cat_admin[$admin_id][$catid_i]))
    {
        if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1)
        {
            $check_cat = true;
        } elseif ($array_cat_admin[$admin_id][$catid_i]['add_content'] == 1)
        {
            $check_cat = true;
        } elseif ($array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1)
        {
            $check_cat = true;
        } elseif ($array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1)
        {
            $check_cat = true;
        } elseif ($array_cat_admin[$admin_id][$catid_i]['del_content'] == 1)
        {
            $check_cat = true;
        }
    }
    if ($check_cat)
    {
        $xtitle_i = "";
        if ($lev_i > 0)
        {
            $xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
            for ($i = 1; $i <= $lev_i; ++$i)
            {
                $xtitle_i .= "---";
            }
            $xtitle_i .= ">&nbsp;";
        }
        $xtitle_i .= $array_value['title'];
        $sl = "";
        if ($catid_i == $catid)
        {
            $sl = " selected=\"selected\"";
        }
        $val_cat_content[] = array("value" => $catid_i, "selected" => $sl, "title" => $xtitle_i);
        $array_cat_view[] = $catid_i;
    }
}
//Het thong tin phan tin tuc
$xtpl = new XTemplate("nktintudong.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
foreach ($val_cat_content as $cat_content)
{
    $xtpl->assign('CAT_CONTENT', $cat_content);
    $xtpl->parse('main.cat_content');
}
foreach($row as $rowcontent)
{
    $xtpl->assign('rowcontent',$rowcontent);
    $xtpl->parse('main.chuyenmuc.loop');
}


foreach ($action as $action1)
{
    $xtpl->assign('ACTION', $action1);
    $xtpl->parse('main.chuyenmuc.action');
}
foreach($mang as $mang1)
{
    $xtpl->assign('rowcontent1',$mang1);
    $xtpl->parse('main.loop');
}
foreach ($action2 as $action3)
{
    $xtpl->assign('ACTION1', $action3);
    $xtpl->parse('main.action');
}
if (!empty($generate_page))
{
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
$xtpl->assign("website",$web);
//$xtpl->assign('rowcontent',$rowcontent);
$xtpl->parse('main.chuyenmuc');
$xtpl->parse( 'main' );
$page_title = $lang_module['Nhatkitintudong'];
$contents=$xtpl->text('main');
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents);
include ( NV_ROOTDIR . "/includes/footer.php" );

?>