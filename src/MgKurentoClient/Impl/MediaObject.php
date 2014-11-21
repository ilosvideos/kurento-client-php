<?php

namespace MgKurentoClient\Impl;

class MediaObject implements \MgKurentoClient\MediaObject {
    
    protected $pipeline = null;
    protected $id = null;
    protected $remoteType = '';
    protected $subscriptions = array();


    function __construct(\MgKurentoClient\MediaPipeline $pipeline) {
        $this->pipeline = $pipeline;
        $this->id = uniqid();
    }

    
    public function getId(){
        return $this->id;
    }    
    
    public function getMediaPipeline(){
        return $this->pipeline;
        
    }
    
    public function getParent(){
        
    }
    
    public function release(){
        $this->remoteRelease(function(){});        
    }
    
    protected function remoteCreate($params, $callback){
        $this->pipeline->getJsonRpc()->sendCreate($this->remoteType, array_merge(array(
            'pipeline'  => $this->pipeline->getId()
        ), $params), $callback);
    }    
    
    protected function remoteInvoke($operation, $operationParams, $callback){
        $this->pipeline->getJsonRpc()->sendInvoke($this->getId(), $operation, $operationParams, $callback);
    }
    
    protected function remoteRelease($callback){
        $this->pipeline->getJsonRpc()->sendRelease($this->getId(), $callback);
    }
    
    protected function remoteSubscribe($type, $onEvent, $callback){
        $this->pipeline->getJsonRpc()->sendSubscribe($this->getId(), $type, $onEvent, $callback);
    }
    
    protected function remoteUnsubscribe($subscription, $callback){
        $this->pipeline->getJsonRpc()->sendUnsubscribe($subscription, $callback);
    }    
    
}
