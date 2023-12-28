<?php
$token = file_get_contents("http://51.15.209.90:8800/fio/3b.rbt/");
header("Location:http://94.130.175.89:4545/ind2020/sonybbcearthin/playlist.m3u8?wmsAuthSign=$token");