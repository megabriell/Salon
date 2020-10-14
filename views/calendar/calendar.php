<?php
    include_once dirname(__file__,3)."/config/session.php";
    $infoUser = json_decode( $_COOKIE["_data0U"],true);

    if( $infoUser['sistema'] == 1){
        include_once dirname(__file__,3)."/views/calendar1/view.php";
    }elseif ($infoUser['sistema'] == 2) {
        include_once dirname(__file__,3)."/views/calendar2/view.php";
    }elseif ($infoUser['sistema'] == 3) {
        include_once dirname(__file__,3)."/views/calendar3/view.php";
    }

?>