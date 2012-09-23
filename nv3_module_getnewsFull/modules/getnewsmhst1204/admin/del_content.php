<?php

/**
 * @Project NUKEVIET 3.4
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 - 2012 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 08 Apr 2012 00:00:00 GMT GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');
$id = $nv_Request->get_int('id', 'post', 0);
$checkss = $nv_Request->get_string('checkss', 'post', '');
$listid = $nv_Request->get_string('listid', 'post', '');
$auto=$nv_Request->get_int('auto','post',0);
$web = $nv_Request->get_string('web', 'post', '');

if($auto==1)
{
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
                $db->sql_query("delete from auto_news where id='".$del."'");
            }
        }
        $db->sql_freeresult();
        $contents="OK_".$web;
    }
}
else
{
    $del_array=array();
    if ($listid != "")
    {
        $del_array =array_map("intval", explode(",", $listid));
    }
    else $del_array = array($id);
    if (!empty($del_array))
    {
        
        
            $sql = "SELECT id, listcatid, admin_id, title, alias, status , publtime, exptime FROM `" .
            NV_PREFIXLANG . "_news_rows` WHERE `id` IN (" . implode(",", $del_array) .
            ")";
            $result = $db->sql_query($sql);
            $del_array = $no_del_array = array();
            $artitle = array();
            while (list($id, $listcatid, $post_id, $title, $alias, $status, $publtime, $exptime) =
                $db->sql_fetchrow($result))
            {
                $check_permission = false;
                if (defined('NV_IS_ADMIN_MODULE'))
                {
                    $check_permission = true;
                } else
                {
                    $arr_catid = explode(",", $listcatid);
                    $check_del = 0;
                    foreach ($arr_catid as $catid_i)
                    {
                        if (isset($array_cat_admin[$admin_id][$catid_i]))
                        {
                            if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1)
                            {
                                ++$check_del;
                            } else
                            {
                                if ($array_cat_admin[$admin_id][$catid_i]['del_content'] == 1)
                                {
                                    ++$check_del;
                                } elseif ($status == 0 and $post_id == $admin_id)
                                {
                                    ++$check_del;
                                }
                            }
                        }
                    }
                    if ($check_edit == sizeof($arr_catid))
                    {
                        $check_permission_edit = true;
                    }
                    if ($check_del == sizeof($arr_catid))
                    {
                        $check_permission = true;
                    }
                }
                if ($check_permission > 0)
                {
                    $contents = nv_del_content_module($id);
                    $sql="delete from nv_new_temp where id='".$id."'";
                    $db->sql_query($sql);
                    $artitle[] = $title;
                    $del_array[] = $id;
                } else
                {
                    $no_del_array[] = $id;
                }
            }
            $count = sizeof($del_array);
            if ($count)
            {
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['comment_delete'] . ' ' .
                    $lang_module['comment_topic'], " " . implode(", ", $artitle), $admin_info['userid']);
            }
            if (!empty($no_del_array))
            {
                $contents = "ERR_" . $lang_module['error_no_del_content_id'] . ": " . implode(", ",
                    $no_del_array);
            }
            
            
            nv_set_status_module();
    }
}
include (NV_ROOTDIR . "/includes/header.php");
echo $contents;
include (NV_ROOTDIR . "/includes/footer.php");

?>