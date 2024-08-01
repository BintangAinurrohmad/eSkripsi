<?php
if (!function_exists('format_tgl')) {
    function format_tgl($tanggal)
    {
        setlocale(LC_TIME, 'id_ID.UTF-8');
        $date = strftime("%A, %d %B %Y", strtotime($tanggal));
        return $date;
    }
}
