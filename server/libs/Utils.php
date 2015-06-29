<?php

function response($callback, $data){

    header('content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    die($callback."(".json_encode($data).");");

}