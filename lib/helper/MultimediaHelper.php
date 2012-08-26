<?php
/**
 * @author TheCelavi
 */

function _embed($url) {
    return dmContext::getInstance()->getServiceContainer()->getService('embedded_video')->url($url);
}
function _audio($url) {
    return dmContext::getInstance()->getServiceContainer()->getService('audio_player')->url($url);
}
function _video($url) {
    return dmContext::getInstance()->getServiceContainer()->getService('video_player')->url($url);
}
function _flash($url) {
    return dmContext::getInstance()->getServiceContainer()->getService('flash_player')->url($url);
}