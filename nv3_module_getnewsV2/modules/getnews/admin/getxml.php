<?php

/**
 * @author CUONG
 * @copyright 2012
 */

include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Lay_Source_RSS.php");
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$link=$_POST['site'];
if(nv_check_url($link))
{
    $xtpl = new XTemplate( "rss.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
    $xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
    $xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
    $xtpl->assign( 'MODULE_NAME', $module_name );
    $xtpl->assign( 'OP', $op );
    $xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
    
    $xtpl->assign('linksite',$link);
    
    //lay source nguon cua link rss
    $source=GetSource::GetContent($link);
    $xtpl->assign('source',$source);
    $xtpl->parse('main.receive');
    
    $xtpl->parse('main.getinfomation');
    $xtpl->parse( 'main' );
    
    $page_title = $lang_module['config'];
    $contents=$xtpl->text('main');
}



include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>