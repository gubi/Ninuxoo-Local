<?php
header("Content-type: text/plain");

require_once("../../classes/manage_conf_file.class.php");

$conf = new manage_conf_file();
$conf->conf_replace("use_editor_always", ($output["allow_editor_always"] == "on") ? "true" : "false", "../../conf/user/" . sha1($output["user_username"]) . "/user.conf");
$conf->conf_replace("allow_user_registration", ($output["allow_user_registration"] == "on") ? "true" : "false", "../../conf/general_settings.ini");
$conf->conf_replace("session_length", $output["session_length"], "../../conf/general_settings.ini");

$conf->conf_replace("station_active", $output["station_active"], "../../conf/config.ini");
$conf->conf_replace("station_name", $output["station_name"], "../../conf/config.ini");
$conf->conf_replace("show_ninux_nodes", ($output["show_ninux_nodes"] == "on") ? "true" : "false", "../../conf/config.ini");
$conf->conf_replace("show_region_area", ($output["show_region_area"] == "on") ? "true" : "false", "../../conf/config.ini");
$conf->conf_replace("refresh_interval", ($output["meteo_refresh"]*1000), "../../conf/config.ini");

$conf->conf_replace("station_city", $output["meteo_city"], "../../conf/config.ini");
$conf->conf_replace("station_region", $output["meteo_region"], "../../conf/config.ini");
$conf->conf_replace("station_country", $output["meteo_country"], "../../conf/config.ini");

$conf->conf_replace("OpenWeatherID", $output["meteo_owid"], "../../conf/config.ini");
$conf->conf_replace("altitude_mt", $output["meteo_altitude_mt"], "../../conf/config.ini");
$conf->conf_replace("altitude_ft", $output["meteo_altitude_ft"], "../../conf/config.ini");
$conf->conf_replace("default_altitude_unit", $output["meteo_altitude_unit"], "../../conf/config.ini");
$conf->conf_replace("latitude", $output["meteo_lat"], "../../conf/config.ini");
$conf->conf_replace("longitude", $output["meteo_lng"], "../../conf/config.ini");

print json_encode(array("data" => "ok"));
?>