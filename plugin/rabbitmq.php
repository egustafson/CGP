<?php

# Collectd CURL_JSON plugin

require_once 'conf/common.inc.php';
require_once 'type/GenericIO.class.php';
require_once 'inc/collectd.inc.php';

## LAYOUT - collectd 5
# rabbitmq-message_stats/counter-publish.rrd
# rabbitmq-message_stats/counter-deliver_get.rrd
# rabbitmq-message_stats/counter-deliver_no_ack.rrd
# rabbitmq-queue_totals/guage-messages.rrd
# rabbitmq-queue_totals/guage-messages_ready.rrd
# rabbitmq-queue_totals/guage-messages_unacknowledged.rrd
# rabbitmq-object_totals/guage-channels.rrd
# rabbitmq-object_totals/guage-connections.rrd
# rabbitmq-object_totals/guage-consumers.rrd
# rabbitmq-object_totals/guage-exchanges.rrd
# rabbitmq-object_totals/guage-queues.rrd

$obj = new Type_Default($CONFIG);
$obj->width = $width;
$obj->heigth = $heigth;
$obj->rrd_format = '%5.1lf';

$instance = $CONFIG['version'] < 5 ? 'tinstance' : 'pinstance';
switch($obj->args[$instance]) {
    case 'message_stats':
        $obj->rrd_title = 'RabbitMQ Message Rates';
        $obj->rrd_vertical = 'messages per second';
    break;
    case 'queue_totals':
        $obj->rrd_title = 'RabbitMQ Queued Messages';
        $obj->rrd_vertical = 'messages';
    break;
    case 'object_totals':
        $obj->rrd_title = 'RabbitMQ Object Counts';
        $obj->rrd_vertical = 'objects';
    break;
}


switch($obj->args['type'])
{
    case 'gauge':
        $obj->ds_names = array(
            'messages'                => 'Total',
            'messages_ready'          => 'Ready',
            'messages_unacknowledged' => 'Unack',
            'channels'                => 'Channels',
            'connections'             => 'Connections',
            'consumers'               => 'Consumers',
            'exchanges'               => 'Exchanges',
            'queues'                  => 'Queues',
        );      
        $obj->colors = array(
			'messages' => '00e000',
			'messages_ready' => 'ffb000',
			'messages_unacknowledged' => '0000ff',
			'channels' => 'ffb000',
			'connections' => 'ff00ff',
			'exchanges' => 'ff0000',
			'consumers' => '00e000',
			'queues' => '0000ff',
			'value' => 'f0a000',
        );
    break;
    
    case 'counter':
        $obj->ds_names = array(
            'publish'         => 'Publish',
            'deliver_get'     => 'Deliver (ack)',
            'deliver_no_ack'  => 'Deliver (noack)',
        );      
        $obj->colors = array(
            'publish'         => '00e000',
            'deliver_get'     => 'ffb000',
            'deliver_no_ack'  => '0000ff',
			'value' => 'f0a000',
        );
    break;
}

collectd_flush($obj->identifiers);
$obj->rrd_graph();
