<?php

namespace V2dmIM\Http\utils;

use Kafka\Producer;
use Kafka\ProducerConfig;

class PRC
{

    private ProducerConfig $config;

    private Producer $producer;

    //创建静态私有的变量保存该类对象
    static private $instance;

    //防止使用new直接创建对象
    private function __construct()
    {
        $this->config = ProducerConfig::getInstance();
        $this->config->setMetadataRefreshIntervalMs(config('kafka.metadata_refresh_interval_ms'));
        $this->config->setMetadataBrokerList(config('kafka.metadata_broker_list'));
        $this->config->setBrokerVersion(config('kafka.broker_version'));
        $this->config->setRequiredAck(config('kafka.required_ack'));
        $this->config->setIsAsyn(config('kafka.is_asyn'));
        $this->config->setProduceInterval(config('kafka.produce_interval'));
        $this->producer = new Producer();
    }

    //防止使用clone克隆对象
    private function __clone()
    {
    }

    static public function instance(): PRC
    {
        //判断$instance是否是Singleton的对象，不是则创建
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function send(string $topic, mixed $value): ?array
    {
        return $this->producer->send(array(
            array(
                'topic' => $topic,
                'value' => serialize($value),
                'key' => '',
            ),
        ));
    }
}