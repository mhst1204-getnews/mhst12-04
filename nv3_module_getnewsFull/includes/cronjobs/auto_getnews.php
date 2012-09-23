<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');
if (!defined('NV_IS_CRON'))
    die('Stop!!!');

function cron_autogetnews($module_name)
{   global $db;
    include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Loc_Noi_Dung.php");
    include(NV_ROOTDIR."/modules/".$module_name."/admin/Library/Lay_RSS.php");
    $check=true;
    
    $result=$db->sql_query("select idcm,link,host,lastlink,type,rss from chuyenmuc where auto='1' and nexttime<='".NV_CURRENTTIME."'");
    while(list($idcm,$link,$host,$lastlink,$type,$rss)=$db->sql_fetchrow($result))
    {
        if($rss==0)
        {
            $kq=$db->sql_query("select path,titlepath,despath,articleleftpath,articlerightpath from article_path where host='".$host."'");
            list($path,$titlepath,$despath,$articleleftpath,$articlerightpath)=$db->sql_fetchrow($kq);
            $arrleft=GetArticle::GetValueMain($link,$articleleftpath);
            $arrright=GetArticle::GetValueMain($link,$articlerightpath);
            $arrTemp=array_merge($arrleft,$arrright);
            $arr1=GetArticle::GetValue($link,$path,$titlepath,$despath);
            $arr=array_merge($arrTemp,$arr1);$tim=-1;
            if($lastlink!="")
            {
                foreach($arr as $a)
                {
                    $tim=$tim+1;
                    if($a['link']==$lastlink) break;
                }
            }
            else $tim=count($arr);
            
            $tam=$db->sql_query("select title from nv_xpath_new where site='".$host."'");
            list($title)=$db->sql_fetchrow($tam);$last="";$sotinmoi=0;
            for($i=0;$i<$tim;$i++)
            {
                $duongdan=$arr[$i]['link'];
                if($i==0)
                {
                    $last=$duongdan;
                }
                $mota="";$content="";
                $mang=InsertNews::GetValue($duongdan,$title,$mota,$content);
                $tieude=str_replace("'","",$mang['tieude']);
                if($mota!="" && $content!="")
                {
                    $mota=str_replace("'","",$mang['mota']);
                    $noidung=str_replace("'","",$mang['noidung']);
                }
                if($tieude!="")
                {
                    $id=$db->sql_query_insert_id("insert into auto_news values(NULL,'".$idcm."','".$tieude."','".$duongdan."')");
                    if($id>0)$sotinmoi=$sotinmoi+1;
    
                }
                unset($mang);
                $db->sql_freeresult();
            }
            $tg=$db->sql_query("select chose,news from config,chuyenmuc where config.action=chuyenmuc.type and chuyenmuc.type='".$type."' and host='".$host."'");
            list($chose,$news)=$db->sql_fetchrow($tg);
            $nextime=NV_CURRENTTIME+$chose*60;
            $sotinmoi=$sotinmoi+$news;
            if($last!="")
            {
                $db->sql_query("update chuyenmuc set lastlink='".$last."',lasttime='".NV_CURRENTTIME."',nexttime='".$nextime."',news='".$sotinmoi."' where idcm='".$idcm."'");
            }
            else
            {
                $db->sql_query("update chuyenmuc set lasttime='".NV_CURRENTTIME."',nexttime='".$nextime."',news='".$sotinmoi."' where idcm='".$idcm."'");
            }
            unset($arr);
        }
        else
        {
            $tim1=-1;
            $arr1=GetRSS::GetLink($link);
            if($lastlink!="")
            {
                foreach($arr1 as $a)
                {
                    $tim1=$tim1+1;
                    if($a==$lastlink) break;
                }
            }
            else $tim1=count($arr1);
            $tam1=$db->sql_query("select title from nv_xpath_new where site='".$host."'");
            list($title1)=$db->sql_fetchrow($tam1);$last1="";$sotinmoi1=0;
            
            for($i=0;$i<$tim1;$i++)
            {
                $duongdan1=$arr1[$i];
                if($i==0)
                {
                    $last1=$duongdan1;
                }
                $mota1="";$noidung1="";
                $mang1=InsertNews::GetValue($duongdan1,$title1,$mota1,$noidung1);
                $tieude1=str_replace("\"","'",$mang1['tieude']);
                if($mota1!="" && $noidung1!="")
                {
                    $mota1=strpos($mang1['mota'],'\'')>=0?str_replace('\'',"",$mang1['mota']):str_replace('"','',$mang1['mota']);
                    $noidung1=strpos($mang1['noidung'],'"')>=0?str_replace('"',"",$mang1['noidung']):str_replace('\'','',$mang1['noidung']);
                }
                
                //$db->sql_query('insert into test values(NULL,"'.$mota1.'","'.$noidung1.'")');
                
    
                if($tieude1!="")
                {
                    $id1=$db->sql_query_insert_id('insert into auto_news values(NULL,"'.$idcm.'","'.$tieude1.'","'.$duongdan1.'")');
                    if($id1>0)$sotinmoi1=$sotinmoi1+1;
    
                }
                unset($mang1);
                //$db->sql_freeresult();
            }
            $tg1=$db->sql_query("select chose,news from config,chuyenmuc where config.action=chuyenmuc.type and chuyenmuc.type='".$type."' and host='".$host."'");
            list($chose1,$news1)=$db->sql_fetchrow($tg1);
            $nextime1=NV_CURRENTTIME+$chose1*60;
            $sotinmoi1=$sotinmoi1+$news1;
            if($last1!="")
            {
                $db->sql_query("update chuyenmuc set lastlink='".$last1."',lasttime='".NV_CURRENTTIME."',nexttime='".$nextime1."',news='".$sotinmoi1."' where idcm='".$idcm."'");
            }
            else
            {
                $db->sql_query("update chuyenmuc set lasttime='".NV_CURRENTTIME."',nexttime='".$nextime1."',news='".$sotinmoi1."' where idcm='".$idcm."'");
            }
            unset($arr1);
        }
    }
    nv_del_moduleCache($module_name);
    return $check;
}   
?>