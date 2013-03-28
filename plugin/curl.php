<?php

# Collectd CURL plugin

require_once 'conf/common.inc.php';
require_once 'type/GenericIO.class.php';
require_once 'inc/collectd.inc.php';

## LAYOUT
# curl-XXXX/response_time.rrd

$obj = new Type_Default($CONFIG);
$obj->data_sources = array('value');
$obj->ds_names = array(
        'value' => 'Response time',
);
$obj->colors = array(
        'value' => '0000f0',
);
$obj->width = $width;
$obj->heigth = $heigth;
$obj->rrd_title = $obj->args['pinstance'];
$obj->rrd_vertical = 'ms';
$obj->rrd_format = '%2.3lf';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
