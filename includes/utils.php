<?php
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ Việt Nam

function calculate_time_ago($date_created) {
    $now = time();
    $created_at = strtotime($date_created);
    $time_ago = $now - $created_at;

    if ($time_ago < 60) { // Dưới 1 phút
        $time_unit = $time_ago == 1 ? 'sec' : 'secs';
        $due_label = '<strong class="label label-danger">' . $time_ago . ' ' . $time_unit . ' ago</strong>';
    } elseif ($time_ago < 3600) { // Dưới 1 giờ
        $time_ago = floor($time_ago / 60); // Đổi sang phút
        $time_unit = $time_ago == 1 ? 'min' : 'mins';
        $due_label = '<strong class="label label-danger">' . $time_ago . ' ' . $time_unit . ' ago</strong>';
    } elseif ($time_ago < 86400) { // Dưới 1 ngày
        $time_ago = floor($time_ago / 3600); // Đổi sang giờ
        $time_unit = $time_ago == 1 ? 'hr' : 'hrs';
        $due_label = '<strong class="label label-danger">' . $time_ago . ' ' . $time_unit . ' ago</strong>';
    } elseif ($time_ago < 604800) { // Dưới 1 tuần
        $time_ago = floor($time_ago / 86400); // Đổi sang ngày
        $time_unit = $time_ago == 1 ? 'day' : 'days';
        $due_label = '<strong class="label label-warning">' . $time_ago . ' ' . $time_unit . ' ago</strong>';
    } elseif ($time_ago < 2592000) { // Dưới 1 tháng
        $time_ago = floor($time_ago / 604800); // Đổi sang tuần
        $time_unit = $time_ago == 1 ? 'week' : 'weeks';
        $due_label = '<strong class="label label-primary">' . $time_ago . ' ' . $time_unit . ' ago</strong>';
    } elseif ($time_ago < 31536000) { // Dưới 1 năm
        $time_ago = floor($time_ago / 2592000); // Đổi sang tháng
        $time_unit = $time_ago == 1 ? 'month' : 'months';
        $due_label = '<strong class="label label-success">' . $time_ago . ' ' . $time_unit . ' ago</strong>';
    } else { // Từ 1 năm trở lên
        $time_ago = ceil($time_ago / 31536000); // Đổi sang năm
        $time_unit = $time_ago == 1 ? 'year' : 'years';
        $due_label = '<strong class="label label-default">' . $time_ago . ' ' . $time_unit . ' ago</strong>';
    }

    return $due_label;
}
?>
