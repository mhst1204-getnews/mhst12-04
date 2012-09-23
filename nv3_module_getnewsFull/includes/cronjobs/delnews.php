<?php

/**
 * @author CUONG
 * @copyright 2012
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');
if (!defined('NV_IS_CRON'))
    die('Stop!!!');
function cron_delnews()
{
    global $db;
    $query = "DELETE FROM `nv_new_temp`";
    $db->sql_query($query);
    return true;
}

?>