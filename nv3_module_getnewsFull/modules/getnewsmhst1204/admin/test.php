<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
//include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/simple_html_dom.php");

global $db;
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Loc_Noi_Dung.php");
include(NV_ROOTDIR . "/includes/class/upload.class.php" );
    $kq="";
    $ketqua=$db->sql_query("select title,description,link from auto_news where id='15'");
            list($tt,$des,$link)=$db->sql_fetchrow($ketqua);$kq.=$nd;
            if($tt!="")
            {
                $alias=change_alias($tt);
                $sql="select id from `" . NV_PREFIXLANG . "_news_rows` where alias='".$alias."'";
                $numselect=$db->sql_numrows($db->sql_query($sql));
                if($numselect<1)
                {
                    
                    $temp=parse_url($link);
                    $host=$temp['host'];$host=str_replace("www.","",$host);
                    $linkImg="";$filename="";$kq="";
                    $nd=strpos($nd,"'")>=0?str_replace("'","",$nd):str_replace("\"","",$nd);
                    $arrImg=InsertNews::GetImage($nd);
                    $local=array("uploads/news/","files/news/thumb/","files/news/block/");
                    if(count($arrImg)>0)
                    {
                        for($j=0;$j<count($arrImg);$j++)
                        {$kq.=$arrImg[$j]."<BR>";
                            if(!nv_is_url($arrImg[$j]))
                            {
                                $linkImg="http://www.".$host.$arrImg[$j];
                            }
                            else $linkImg=$arrImg[$j];
                            for($z=0;$z<3;$z++)
                            {
                                $upload = new upload( 'images', $global_config['forbid_extensions'], $global_config['forbid_mimes'],NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT );
                                $upload ->save_urlfile( $linkImg, NV_ROOTDIR."/".$local[$z], $replace_if_exists = true );
                                $kq.=NV_ROOTDIR."/".$local[$z]."<br>";
                            }
                            $nd=str_replace($arrImg[$j],NV_BASE_SITEURL.$local[0].basename($linkImg),$nd);
                            if(basename($linkImg)!="")$filename=basename($linkImg);
                            //if($j==0){$filename=str_replace("%","",basename($linkImg));}
                        }
                        
                    }
                    //$filename="sadj";
                    //$insert_catid=implode(",",$chuyenmuc);
//                    $id=$db->sql_query_insert_id("INSERT INTO `" . NV_PREFIXLANG . "_news_rows` VALUES (NULL ,'".$chuyenmuc[0]."','".$insert_catid."', '0', '0', '', '0', '".NV_CURRENTTIME."', '0', '1',
//                     '".NV_CURRENTTIME."', '0', '2', '".$tt."', '".$alias."', '".$des."', '".$filename."', '', 'thumb/".$filename."|block/".$filename."', '1', '0', '0', '0', '0', '0', '0','')");
//                    $contents="OK_".$kq;
//                    if($id>0)
//                    {
//                        $ct_query = array();
//                        $tbhtml = NV_PREFIXLANG . "_news_bodyhtml_" . ceil($id /2000);
//                        $db->sql_query("CREATE TABLE IF NOT EXISTS `" . $tbhtml .
//                            "` (`id` int(11) unsigned NOT NULL, `bodyhtml` longtext NOT NULL, `sourcetext` varchar(255) NOT NULL default '', `imgposition` tinyint(1) NOT NULL default '1', `copyright` tinyint(1) NOT NULL default '0', `allowed_send` tinyint(1) NOT NULL default '0', `allowed_print` tinyint(1) NOT NULL default '0', `allowed_save` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`)) ENGINE=MyISAM");
//                        $ct_query[] = (int)$db->sql_query("INSERT INTO `" . $tbhtml . "` VALUES \n\t\t\t\t\t(" .
//                            $id . ", \n\t\t\t\t\t" . $db->dbescape_string($nd) .
//                            ", \n\t                " . $db->dbescape_string('') . ",\n\t\t\t\t\t" .
//                            intval(1) . ",\n\t                " . intval(0) .
//                            ",  \n\t                " . intval(0) . ",  \n\t                " .
//                            intval(0) . ",  \n\t                " . intval(0) .
//                            "\t\t\t\t\t\n\t\t\t\t\t)");
//                            
//                            $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news".
//                            "_" . $chuyenmuc . "` SELECT * FROM `" . NV_PREFIXLANG . "_news".
//                            "_rows` WHERE `id`=" .$id. "");
//                        $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news".
//                        "_bodytext` VALUES (" . $id . ", " . $db->dbescape_string($nd) .
//                        ")"); 
//                        
//                        $db->sql_query("INSERT INTO `nv_new_temp` VALUES ('".$host."', '" . $duongdan ."')");
//                        $db->sql_freeresult();
                        
                   // }
//                    else {$error[]=$lang_module['error_save_new_id'].$tt;}
                }
                else
                {
                    $error[]=$lang_module['error_sametitle'];
                }
           }

$xtpl = new XTemplate( "test.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign('bien',$kq);
$xtpl->parse( 'main' );
$page_title = $lang_module['config'];
$contents=$xtpl->text('main');
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>