<?php

# Collectd CURL_JSON plugin

require_once 'conf/common.inc.php';
require_once 'type/GenericIO.class.php';
require_once 'inc/collectd.inc.php';

## LAYOUT
# curl_json-rabbitmq/
# curl_json-rabbitmq/derive-message_stats-publish.rrd
# curl_json-rabbitmq/derive-message_stats-deliver_get.rrd
# curl_json-rabbitmq/derive-message_stats-deliver_no_ack.rrd
# curl_json-rabbitmq/gauge-queue_totals-messages.rrd
# curl_json-rabbitmq/gauge-queue_totals-messages_ready.rrd
# curl_json-rabbitmq/gauge-queue_totals-messages_unacknowledged.rrd

$obj = new Type_Default($CONFIG);
$obj->width = $width;
$obj->heigth = $heigth;
$obj->rrd_format = '%5.1lf';


switch($obj->args['type'])
{
    case 'gauge':
        # $obj->data_sources = array('queue_totals-messages','queue_totals-messages_ready','queue_totals-messages_unacknowledged');
        $obj->ds_names = array(
            'queue_totals-messages'                => 'Total',
            'queue_totals-messages_ready'          => 'Ready',
            'queue_totals-messages_unacknowledged' => 'Unack',
        );      
        $obj->colors = array(
			'queue_totals-messages' => '00e000',
			'queue_totals-messages_ready' => 'ffb000',
			'queue_totals-messages_unacknowledged' => '0000ff',
			'value' => 'f0a000',
        );
        $obj->rrd_title = 'Queued messages';
        $obj->rrd_vertical = 'Messages';
    break;
    
    case 'derive':
        # $obj->data_sources = array('queue_totals-messages','queue_totals-messages_ready','queue_totals-messages_unacknowledged');
        $obj->ds_names = array(
            'message_stats-publish'         => 'Publish',
            'message_stats-deliver_get'     => 'Deliver (ack)',
            'message_stats-deliver_no_ack'  => 'Deliver (noack)',
        );      
        $obj->colors = array(
            'message_stats-publish'         => '00e000',
            'message_stats-deliver_get'     => 'ffb000',
            'message_stats-deliver_no_ack'  => '0000ff',
			'value' => 'f0a000',
        );
        $obj->rrd_title = 'Message Rates';
        $obj->rrd_vertical = 'Msg/s';
    break;
}

collectd_flush($obj->identifiers);
$obj->rrd_graph();
