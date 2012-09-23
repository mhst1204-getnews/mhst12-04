<?php

/**
 * @author CUONG
 * @copyright 2012
 */
 if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
 global $db;
$idcm=$nv_Request->get_int('idcm','post',0);
$tye=$nv_Request->get_string('chonloai','post','');
$at=$nv_Request->get_int('auto','post',-1);
$z=$db->sql_query("select chose from config where action='".$tye."'");
list($nextime)=$db->sql_fetchrow($z);
$kq="OK_";
$starttime=NV_CURRENTTIME;
$inteve=$nextime*60;
$next=$starttime +$inteve;
$resultkq=$db->sql_query("update chuyenmuc set lasttime='".$starttime."',nexttime='".$next."',type='".$tye."',auto='".$at."' where idcm='".$idcm."'");
$db->sql_freeresult();
include ( NV_ROOTDIR . "/includes/header.php" );
echo $kq.$idcm.$tye.$at.$starttime.$next;
include ( NV_ROOTDIR . "/includes/footer.php" );
?>