<?php

/**
 * @author CUONG
 * @copyright 2012
 */
 
 if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
$listid = $nv_Request->get_string('listid', 'post', '');
$type=$nv_Request->get_string('type','post','');
$kq="OK_";global $db;
if($listid!="" && $type!="")
{
    $arr=split(',',$listid);$count=0;
    foreach($arr as $a)
    {
        if($a!="")
        {
            $z=$db->sql_query("select chose from config where action='".$type."'");
            list($nextime)=$db->sql_fetchrow($z);
            $starttime=NV_CURRENTTIME;
            $inteve=$nextime*60;
            $next=$starttime +$inteve;
            $db->sql_query("update chuyenmuc set lasttime='".$starttime."',nexttime='".$next."',type='".$type."' where idcm='".$a."'");
            if ($db->sql_affectedrows() > 0) $count++;
        }
    }
    if($count<(count($arr)-1))
    {
        $kq="NO_";
    }
}
include (NV_ROOTDIR . "/includes/header.php");
echo $kq;
include (NV_ROOTDIR . "/includes/footer.php");

?>