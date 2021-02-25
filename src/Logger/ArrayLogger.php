<?php


namespace User\Logger;


use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class ArrayLogger implements LoggerInterface
{
    use LoggerTrait;

    private array $log = [];

    public function log($level, $message, array $context = array())
    {
        $logLine = sprintf("%s: %s [%s]\n", $level, $message, json_encode($context));
        array_push($this->log, $logLine);
    }

    public function showLog(): array
    {
        return $this->log;
    }
}
