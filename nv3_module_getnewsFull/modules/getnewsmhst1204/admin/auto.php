<?php

/**
 * @author CUONG
 * @copyright 2012
 */
 if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
$listid = $nv_Request->get_string('listid', 'post', '');
$auto=$nv_Request->get_string('auto','post','');
$kq="OK_";global $db;$z=0;
if($listid!="" && $auto!="")
{
    $arr=split(',',$listid);$count=0;
    foreach($arr as $a)
    {
        if($a!="")
        {
            $z=$auto=="tudong"?1:0;
            $db->sql_query("update chuyenmuc set auto='".$z."' where idcm='".$a."'");
            if ($db->sql_affectedrows() > 0) $count++;
        }
    }
    if($count<(count($arr)-1))
    {
        $kq="NO_";
    }
}
include (NV_ROOTDIR . "/includes/header.php");
echo $kq.$z;
include (NV_ROOTDIR . "/includes/footer.php");

?>