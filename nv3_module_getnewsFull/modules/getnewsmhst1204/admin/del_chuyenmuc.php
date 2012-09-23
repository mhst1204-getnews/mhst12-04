<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$maid=$nv_Request->get_int('idcm','post',0);
$content_del = "NO_" . $maid;
$listid = $nv_Request->get_string('listid', 'post', '');
$del_array=array();
if ($listid != "")
{
    $del_array = split(",",$listid);
}
else $del_array[]=$maid;
if(!empty($del_array))
{
    foreach($del_array as $del)
    {
        if($del!="")
        {
            $db->sql_query("delete from chuyenmuc where idcm='".$del."'");
        }
        $content_del="OK_".$del;
    }
    $db->sql_freeresult();
}
 
include (NV_ROOTDIR . "/includes/header.php");
echo $content_del;
include (NV_ROOTDIR . "/includes/footer.php");

?>