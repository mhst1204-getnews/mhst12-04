<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Loc_Noi_Dung.php");
global $db;$kq="";$id=0;
if(isset($_REQUEST['id']))
{
    $id=$_REQUEST['id'];
}
$thongbao="";
$tenchuyenmuc="";$link="";$isrss="";
$temp="";


if($id>0)
{
    $kq1=$db->sql_query("select tencm,link,rss from chuyenmuc where idcm='".$id."'");
    list($tencm,$linkcm,$rss)=$db->sql_fetchrow($kq1);
    $tenchuyenmuc='<input style="width: 200px" name="tencm" id="tencm" type="text" value="'.$tencm.'" maxlength="100" />';
    $tenchuyenmuc.='<input  style="width:500px;" name="linkcm" id="linkcm" type="text" value="'.$linkcm.'"/>';
    $tenchuyenmuc.='<input name="ma" type="hidden" value="2"/>';
    
    
    if(isset($_REQUEST['isrss']))
    {
        $isrs=$_REQUEST['isrss'];$link="";
        if($linkcm!="" && $isrs==0)
        {
            if(!nv_is_url($linkcm))$link.="http:www.".$linkcm;
            else {$link=$linkcm;}
            $temp.="<div><iframe src=\"".$link."\" width=\"100%\" height=\"300\" id=\"frame\" frameborder=\"1\" scrolling=\"auto\"></iframe></div>";
            $temp.="<dir style=\"height:10px;\"></dir>";
            $temp.="<p><strong>".$lang_module['cauhinhtrangtin']."</strong></p>";
            $temp.="<div class=\"my_wrapper\"><div class=\"my_left_box\">";
            $temp.="<p><strong>".$lang_module['tintdt']."</p><input type=\"text\" value=\"tiêu đề\" name=\"tieudetdt\" id=\"tieudetdt\" style=\"width:410px;\"/></div>";
            $temp.="<div class=\"my_right_box\"><p>".$lang_module['tintdp']."</strong></p>";
            $temp.="<input type=\"text\" value=\"tiêu đề\" name=\"tieudetdp\" id=\"tieudetdp\" style=\"width:410px;\"/></div>";
            $temp.="<div class=\"my_footer\"><p><strong>".$lang_module['tink']."</strong></p>";
            $temp.="<input type=\"text\" value=\"tiêu đề\" name=\"tieudek\" id=\"tieudek\" style=\"width:880px;\"/><br /><br/>";
            $temp.="<input type=\"text\" value=\"mô tả\" name=\"motak\" id=\"motak\" style=\"width:880px;\"/></div></div>";
            
            
        }
        $isrss="<option value=\"-1\">" .$lang_module['isrss'] . "</option>\n";
        for($j=0;$j<2;$j++)
        {
            $z=$j==1?$lang_module['co']:$lang_module['khong'];
            $isrss.="<option value=\"" . $j . "\"" . (($j == $isrs) ? " selected=\"selected\"" : "") . ">" . $z . "</option>\n";
        }
    }
    else
    {
        $isrss="<option value=\"-1\">" .$lang_module['isrss'] . "</option>\n";
        for($i=0;$i<2;$i++)
        {
            $z=$i==1?$lang_module['co']:$lang_module['khong'];
            $isrss.="<option value=\"" . $i . "\"" . (($i == $rss) ? " selected=\"selected\"" : "") . ">" . $z . "</option>\n";
        }
    }
}
else
{
    $tenchuyenmuc="";$linkcm="";$tencm="";$temp="";
    if(isset($_REQUEST['tencm']))
    {
        $tencm=$_REQUEST['tencm'];
        $tenchuyenmuc.='<input style="width: 200px" name="tencm" id="tencm" type="text" value="'.$tencm.'" maxlength="100" />';
    }
    else $tenchuyenmuc.='<input style="width: 200px" name="tencm" id="tencm" type="text" value="'.$lang_module["chuyenmuc"].'" maxlength="100" />';
    
    if(isset($_REQUEST['linkcm']))
    {
        $linkcm=$_REQUEST['linkcm'];
        $tenchuyenmuc.='<input  style="width:500px;" name="linkcm" id="linkcm" type="text" value="'.$linkcm.'"/>';
    }
    else $tenchuyenmuc.='<input  style="width:500px;" name="linkcm" id="linkcm" type="text" value="'.$lang_module["linkchuyenmuc"].'"/>';
    $isrs=0;
    if(isset($_REQUEST['isrss']))
    {
        $isrs=$_REQUEST['isrss'];$link="";
        if($linkcm!="" && $isrs==0)
        {
            if(!nv_is_url($linkcm))$link.="http:www.".$linkcm;
            else $link=$linkcm;
            $temp.="<div><iframe src=\"".$link."\" width=\"100%\" height=\"300\" id=\"frame\" frameborder=\"1\" scrolling=\"auto\"></iframe></div>";
            $temp.="<dir style=\"height:10px;\"></dir>";
            $temp.="<p><strong>".$lang_module['cauhinhtrangtin']."</strong></p>";
            $temp.="<div class=\"my_wrapper\"><div class=\"my_left_box\">";
            $temp.="<p><strong>".$lang_module['tintdt']."</p><input type=\"text\" value=\"tiêu đề\" name=\"tieudetdt\" id=\"tieudetdt\" style=\"width:410px;\"/></div>";
            $temp.="<div class=\"my_right_box\"><p>".$lang_module['tintdp']."</strong></p>";
            $temp.="<input type=\"text\" value=\"tiêu đề\" name=\"tieudetdp\" id=\"tieudetdp\" style=\"width:410px;\"/></div>";
            $temp.="<div class=\"my_footer\"><p><strong>".$lang_module['tink']."</strong></p>";
            $temp.="<input type=\"text\" value=\"tiêu đề\" name=\"tieudek\" id=\"tieudek\" style=\"width:880px;\"/><br /><br/>";
            $temp.="<input type=\"text\" value=\"mô tả\" name=\"motak\" id=\"motak\" style=\"width:880px;\"/></div></div>";
        }
        $isrss="<option value=\"-1\">" .$lang_module['isrss'] . "</option>\n";
        for($i=0;$i<2;$i++)
        {
            $z=$i==1?$lang_module['co']:$lang_module['khong'];
            $isrss.="<option value=\"" . $i . "\"" . (($i == $isrs) ? " selected=\"selected\"" : "") . ">" . $z . "</option>\n";
        }
    }
    else
    {
        $isrss="<option value=\"-1\" selected=\"selected\">" .$lang_module['isrss'] . "</option>\n";
        for($i=0;$i<2;$i++)
        {
            $z=$i==1?$lang_module['co']:$lang_module['khong'];
            $isrss.="<option value=\"" . $i . "\">" . $z . "</option>\n";
        }
    }
}

if($nv_Request->isset_request('check','post')=="ok")
{
    $irs=$_REQUEST['isrss'];
    if($irs==1)
    {
        $trangtin=$nv_Request->get_string('linkcm','post','');
        if(nv_is_url($trangtin))
        {
            $temp1=parse_url($trangtin);
            $host=$temp1['host'];$host=str_replace("www.","",$host);
            $cmName=$nv_Request->get_string('tencm','post','');
            $k=$db->sql_query("select idcm from chuyenmuc where link='".$trangtin."'");
            if($db->sql_numrows($k)==0)
            {
                $ma=$db->sql_query_insert_id("insert into chuyenmuc values(NULL,'".$cmName."','".$trangtin."','".$host."','".$irs."','','0','0','0','lientuc','1')");
                if($ma>0)
                {
                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=add_cat";
                    $msg1 = $lang_module['content_saveok'];
                    $msg2 = $lang_module['quaylaitruoc'];
                    redriect($msg1, $msg2, $url);
                }
                else
                {
                    $url = "javascript: history.go(-1)";
                    $msg1 = $lang_module['content_saveerror'];
                    $msg2 = $lang_module['content_back'];
                    redriect($msg1, $msg2, $url);
                }
            }
            else
            {
                $ketqua=$db->sql_query("update chuyenmuc set tencm=N'".$cmName."',rss='".$isrs."' where link='".$trangtin."'");
                $nub=$db->sql_affectedrows($ketqua);
                if($nub>0)
                {
                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=add_cat";
                    $msg1 = $lang_module['comment_update_success'];
                    $msg2 = $lang_module['quaylaitruoc'];
                    redriect($msg1, $msg2, $url);
                }
                else
                {
                    $url = "javascript: history.go(-1)";
                    $msg1 = $lang_module['cmdaluu'];
                    $msg2 = $lang_module['content_back'];
                    redriect($msg1, $msg2, $url);
                }
            }
        }
    }
    else if($irs==0)
    {
        $trangtin=$nv_Request->get_string('linkcm','post','');
        if(nv_is_url($trangtin))
        {
            $temp1=parse_url($trangtin);
            $host=$temp1['host'];$host=str_replace("www.","",$host);
            $cmName=$nv_Request->get_string('tencm','post','');
            $noidung=$nv_Request->get_string('tieudek','post','',"");
            $nd=change_alias($noidung);
            $mota=$nv_Request->get_string('motak','post','');$mt=str_replace("\"","",$mota);
            $left=$nv_Request->get_string('tieudetdt','post','');
            $right=$nv_Request->get_string('tieudetdp','post','');
            if($nd!='' && $mt!='')
            {
                $k=$db->sql_query("select idcm from chuyenmuc where link='".$trangtin."'");
                $ma=0;
                if($db->sql_numrows($k)==0)
                {
                    $ma=$db->sql_query_insert_id("insert into chuyenmuc values(NULL,'".$cmName."','".$trangtin."','".$host."','".$irs."')");
                    if($ma>0)
                    {
                        $ketqua=GetContentArtice::FindDiff($trangtin,$nd,$mt);$mainleft='';$mainright='';
                        if($left!='' && $right!='')
                        {
                            $leftmain=change_alias($left);$rightmain=change_alias($right);
                            $mainleft=GetContentArtice::FindDiffMain($trangtin,$leftmain);
                            $mainright=GetContentArtice::FindDiffMain($trangtin,$rightmain);
                        }
                        if(!is_null($ketqua))
                        {
                            global $db;
                            $sql="select id from article_path where host='".$host."'";
                            $resu=$db->sql_query($sql);
                            list($id1)=$db->sql_fetchrow($resu);
                            if($id1==0)
                            {
                                //$del="delete from article_path where id='".$id1."'";
                                //$db->sql_query($del);
                                $sql="insert into article_path values(NULL,'".$host."','".$ketqua[0]."','".$ketqua[1]."','".$ketqua[2]."','".$mainleft."','".$mainright."')";
                                $id=$db->sql_query_insert_id($sql);
                                if($id>0)
                                {
                                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=add_cat";
                                    $msg1 = $lang_module['content_saveok'];
                                    $msg2 = $lang_module['quaylaitruoc'];
                                    redriect($msg1, $msg2, $url);
                                }
                                else
                                {
                                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=config";
                                    $msg1 = $lang_module['content_saveerror'];
                                    $msg2 = $lang_module['quaylaitruoc'];
                                    redriect($msg1, $msg2, $url);
                                }
                            }
                            else
                            {
                                //$sql="insert into article_path values(NULL,'".$host."','".$ketqua[0]."','".$ketqua[1]."','".$ketqua[2]."')";
                                //$id=$db->sql_query_insert_id($sql);
                                $update="update article_path set path='".$ketqua[0]."',titlepath='".$ketqua[1]."',despath='".$ketqua[2]."',articleleftpath='".$mainleft."',articlerightpath='".$mainright."' where id='".$id1."'";
                                $db->sql_query($update);
                                if($db->sql_affectedrows() > 0)
                                {
                                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=config";
                                    $msg1 = $lang_module['content_saveok'];
                                    $msg2 = $lang_module['quaylaitruoc'];
                                    redriect($msg1, $msg2, $url);
                                }
                                else
                                {
                                    $url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name."&op=config";
                                    $msg1 = $lang_module['content_saveerror'];
                                    $msg2 = $lang_module['quaylaitruoc'];
                                    redriect($msg1, $msg2, $url);
                                }
                            }
                        }
                        else
                        {
                            $url = "javascript: history.go(-1)";
                            $msg1 = $lang_module['content_saveerror'];
                            $msg2 = $lang_module['content_back'];
                            redriect($msg1, $msg2, $url);
                        }
                    }
                    else
                    {
                        $url = "javascript: history.go(-1)";
                        $msg1 = $lang_module['content_saveerror'];
                        $msg2 = $lang_module['content_back'];
                        redriect($msg1, $msg2, $url);
                    }
                }
                else
                {
                    $url = "javascript: history.go(-1)";
                    $msg1 = $lang_module['cmdaluu'];
                    $msg2 = $lang_module['content_back'];
                    redriect($msg1, $msg2, $url);
                }
            }
        }
        else
        {
            $url = "javascript: history.go(-1)";
            $msg1 = $lang_module['duongdansai'];
            $msg2 = $lang_module['content_back'];
            redriect($msg1, $msg2, $url);
        }
    }
}
$xtpl = new XTemplate( "add_cat.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign('tencm',$tenchuyenmuc);
$xtpl->assign('isrss',$isrss);
$xtpl->assign( 'OP', $op );
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
$xtpl->assign("frame",$temp);
$xtpl->parse('main.getlink');
$xtpl->parse( 'main' );
$page_title = $lang_module['config'];
$contents=$xtpl->text('main');
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>