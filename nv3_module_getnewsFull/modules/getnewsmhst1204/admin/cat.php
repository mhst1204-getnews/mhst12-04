<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
global $db;
$xtpl = new XTemplate( "cat.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);

$query="select distinct host from chuyenmuc";
$ket=$db->sql_query($query);$web="";
$che=$nv_Request->get_string('web','post','vnexpress.net');
while(list($website)=$db->sql_fetchrow($ket))
{
    $web.="<option value='".$website."'".($che==$website?"selected='selected'":'').">".$website."</option>";
}
$row=array();

$k=$db->sql_query("select * from chuyenmuc where host='".$che."'");
while(list($idcm1,$tencm1,$link1,$host1,$rss1)=$db->sql_fetchrow($k))
{
    $rs=$rss1==1?$lang_module['co']:$lang_module['khong'];
    $admin_funcs = array();
    $admin_funcs[] = suacm($idcm1);
    $admin_funcs[] = xoacm($idcm1);
    $row[]=array("id"=>$idcm1,"chuyenmuc"=>$tencm1,"linkchuyenmuc"=>$link1,"linksite"=>$host1,"isrss"=>$rs,"feature"=>implode("&nbsp;-&nbsp;", $admin_funcs));
    
}
foreach($row as $r)
{
    $xtpl->assign('ROW',$r);
    $xtpl->parse('main.quantri.loop');
}
$array_list_action = array('delete' => $lang_global['delete']);
$action = array();
while (list($catid_i, $title_i) = each($array_list_action))
{
    $action[] = array("value" => $catid_i, "title" => $title_i);
}
foreach ($action as $action1)
{
    $xtpl->assign('ACTION', $action1);
    $xtpl->parse('main.quantri.action');
}
$xtpl->assign("website",$web);
$xtpl->parse('main.quantri');
$xtpl->parse( 'main' );
$page_title = $lang_module['quantricm'];
$contents=$xtpl->text('main');


include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>