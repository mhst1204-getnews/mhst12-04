<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Mon, 23 Jul 2012 02:56:18 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
if(defined('NV_EDITOR')){require_once(NV_ROOTDIR.'/'.NV_EDITORSDIR.'/'.NV_EDITOR.'/nv.php');}

global $db;

$lientuc="";
$reslt=$db->sql_query("select chose from config where action='lientuc'");
list($choselt)=$db->sql_fetchrow($reslt);


$binhthuong="";
$resbt=$db->sql_query("select chose from config where action='binhthuong'");
list($chosebt)=$db->sql_fetchrow($resbt);


$it="";
$resit=$db->sql_query("select chose from config where action='it'");
list($choseit)=$db->sql_fetchrow($resit);


$tinlayve="";
$restinlv=$db->sql_query("select chose from config where action='tinlayve'");
list($chosetinlv)=$db->sql_fetchrow($restinlv);


if($nv_Request ->isset_request('saveedit','post')=="ok")
{
    $arr=array();
    $lt=$nv_Request->get_int('lientuc','post',-1);$arr[]=$lt;$choselt=$lt;
    $bt=$nv_Request->get_int('binhthuong','post',-1);$arr[]=$bt;$chosebt=$bt;
    $it1=$nv_Request->get_int('it','post',-1);$arr[]=$it1;$choseit=$it1;
    $temmlt=$nv_Request->get_int('tinlv','post',-1);$arr[]=$temmlt;$chosetinlv=$temmlt;
    $arr1=array("lientuc","binhthuong","it","tinlayve");
    $error="";
    for($i=0;$i<count($arr);$i++)
    {
        $ket=$db->sql_query("update config set chose='".$arr[$i]."' where action='".$arr1[$i]."'");
    }
}


for($i=1;$i<6;$i++)
{
    $lientuc.="<option value='".$i."'".(($i==$choselt)?"selected='selected'":'').">".$i.$lang_module['phut']."</option>";
}
for($i=6;$i<11;$i++)
{
    $binhthuong.="<option value='".$i."'".(($i==$chosebt)?"selected='selected'":'').">".$i.$lang_module['phut']."</option>";
}
for($i=11;$i<16;$i++)
{
    $it.="<option value='".$i."'".(($i==$choseit)?"selected='selected'":'').">".$i.$lang_module['phut']."</option>";
}
for($i=0;$i<2;$i++)
{
    $z=$i==1?$lang_module['dangluon']:$lang_module['chodang'];
    $tinlayve.="<option value='".$i."'".(($i==$chosetinlv)?"selected='selected'":'').">".$z."</option>";
}
$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
$xtpl->assign('lientuc',$lientuc);
$xtpl->assign('binhthuong',$binhthuong);
$xtpl->assign('it',$it);
$xtpl->assign('tinlv',$tinlayve);
$xtpl->parse('main.sendLink');
$xtpl->parse( 'main' );

$page_title = $lang_module['config'];
$contents=$xtpl->text('main');

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents);
include ( NV_ROOTDIR . "/includes/footer.php" );



?>