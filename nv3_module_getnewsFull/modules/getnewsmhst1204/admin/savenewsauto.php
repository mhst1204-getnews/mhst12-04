<?php

/**
 * @author CUONG
 * @copyright 2012
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Loc_Noi_Dung.php");
include(NV_ROOTDIR . "/includes/class/upload.class.php" );
$contents="NO_";
$chuyenmuc=$nv_Request->get_string('catid','post','');
$ma=$nv_Request->get_string('listid','post','');
global $db;
if($ma!="")
{
    $idma=split(",",$ma);
    foreach($idma as $idm)
    {
        if($idm!="")
        {
            $ketqua=$db->sql_query("select link from auto_news where id='".$idm."'");
            list($link)=$db->sql_fetchrow($ketqua);
            if($link!="")
            {
                global $db,$global_config;
                $local=array("uploads/news/","files/news/thumb/","files/news/block/");
                $error=array();
                $temp=parse_url($link);
                $host=$temp['host'];$host=str_replace("www.","",$host);
                $chucnang=$nv_Request->get_string('option','post',"");
                $sql="select * from nv_xpath_new where site='".$host."'";
                $result=$db->sql_query($sql);
                list($site,$titleLink,$descripLink,$contentLink)=$db->sql_fetchrow($result);
                if($site!="" || $site!=null)
                {
                    $arr=InsertNews::GetValue($link,$titleLink,$descripLink,$contentLink);
                    $title=strpos($arr['tieude'],"'")>=0?str_replace("'","",$arr['tieude']):str_replace("\"","",$arr['tieude']);
                    $alias=change_alias($title);
                    $sql="select id from `" . NV_PREFIXLANG . "_news_rows` where alias='".$alias."'";
                    $numselect=$db->sql_numrows($db->sql_query($sql));
                    if($numselect<1)
                    {
                        $des=strpos($arr['mota'],"'")>=0?str_replace("'","",$arr['mota']):str_replace("\"","",$arr['mota']);
                        $source=strpos($arr['noidung'],"'")>=0?str_replace("'","",$arr['noidung']):str_replace("\"","",$arr['noidung']);$kq.=$arr['noidung'];
                        $linkImg="";$filename="";$kq="";
                        $arrImg=InsertNews::GetImage($source);
                        if(count($arrImg)>0)
                        {
                            for($j=0;$j<count($arrImg);$j++)
                            {
                                if(!nv_is_url($arrImg[$j]))
                                {
                                    $linkImg="http://www.".$host.str_replace(" ","%20",$arrImg[$j]);
                                }
                                else $linkImg=str_replace(" ","%20",$arrImg[$j]);
                                $kq=$linkImg;
                                for($z=0;$z<3;$z++)
                                {
                                    $upload = new upload( 'images', $global_config['forbid_extensions'], $global_config['forbid_mimes'],NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT );
                                    $upload ->save_urlfile( $linkImg, NV_ROOTDIR."/".$local[$z], $replace_if_exists = true );
                                    $kq.=NV_ROOTDIR."/".$local[$z]."<br>";
                                }
                                $source=str_replace($arrImg[$j],NV_BASE_SITEURL.$local[0].str_replace("%","",basename($linkImg)),$source);
                                if($j==0){$filename=str_replace("%","",basename($linkImg));}
                            }
                            $filename=basename($arrImg[0]);
                        }
                        //$insert_catid=implode(",",$catid);
                        $db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news_rows` VALUES (NULL ,'".$chuyenmuc."','".$chuyenmuc."', '0', '0', '', '0', '".NV_CURRENTTIME."', '0', '1', '".NV_CURRENTTIME."', '0', '2', '".$title."', '".$alias."', '".$des."', '".$filename."', '', 'thumb/".$filename."|block/".$filename."', '1', '0', '0', '0', '0', '0', '0','')");
                        $id=mysql_insert_id();
                        
                        if($id>0)
                        {
                            $ct_query = array();
                            $tbhtml = NV_PREFIXLANG . "_news_bodyhtml_" . ceil($id /2000);
                            $db->sql_query("CREATE TABLE IF NOT EXISTS `" . $tbhtml .
                                "` (`id` int(11) unsigned NOT NULL, `bodyhtml` longtext NOT NULL, `sourcetext` varchar(255) NOT NULL default '', `imgposition` tinyint(1) NOT NULL default '1', `copyright` tinyint(1) NOT NULL default '0', `allowed_send` tinyint(1) NOT NULL default '0', `allowed_print` tinyint(1) NOT NULL default '0', `allowed_save` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`)) ENGINE=MyISAM");
                            $ct_query[] = (int)$db->sql_query("INSERT INTO `" . $tbhtml . "` VALUES \n\t\t\t\t\t(" .
                                $id . ", \n\t\t\t\t\t" . $db->dbescape_string($source) .
                                ", \n\t                " . $db->dbescape_string('') . ",\n\t\t\t\t\t" .
                                intval(1) . ",\n\t                " . intval(0) .
                                ",  \n\t                " . intval(0) . ",  \n\t                " .
                                intval(0) . ",  \n\t                " . intval(0) .
                                "\t\t\t\t\t\n\t\t\t\t\t)");
                            
                            $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news".
                                "_" . $chuyenmuc . "` SELECT * FROM `" . NV_PREFIXLANG . "_news".
                                "_rows` WHERE `id`=" .$id. "");
                            $ct_query[] = (int)$db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_news".
                            "_bodytext` VALUES (" . $id . ", " . $db->dbescape_string($source) .
                            ")"); 
                            
                            $db->sql_query("INSERT INTO `nv_new_temp` VALUES ('".$host."', '" . $link ."')");
                            $db->sql_query("delete from auto_news where id='".$idm."'");
                            $contents="OK_".$host;
                            $db->sql_freeresult();
                        }
                        else
                        {
                            $contents="NO_".$lang_module['content_saveerror'];
                        }
                    }
                    else
                    {
                        $contents="NO_".$lang_module['tontai'];
                    }
                }
            }
        }
    }
}
include (NV_ROOTDIR . "/includes/header.php");
echo $contents;
include (NV_ROOTDIR . "/includes/footer.php");
?>