<?php

# Collectd CURL plugin

require_once 'conf/common.inc.php';
require_once 'type/GenericIO.class.php';
require_once 'inc/collectd.inc.php';

## LAYOUT
# dbi-XXXX/gauge-consumed-consumed.rrd

$obj = new Type_Default($CONFIG);
$obj->data_sources = array('value');
$obj->ds_names = array(
        'consumed-consumed' => 'Consumed',
);
$obj->colors = array(
        'consumed-consumed' => '0000f0',
);
$obj->width = $width;
$obj->heigth = $heigth;
$obj->rrd_title = $obj->args['pinstance'];
$obj->rrd_vertical = 'ms';
$obj->rrd_format = '%4.0lf';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
