<?php
function getConfig($name){
    return $GLOBALS['config'][$name] ? : '';
}