<?php


namespace User\Logger;


use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class FileLogger implements LoggerInterface
{
    use LoggerTrait;

    private string $filename = '/tmp/app.log';

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        if (!file_exists($filename)) {
            file_put_contents($filename, '', FILE_APPEND);
        }
    }

    public function log($level, $message, array $context = array())
    {
        file_put_contents(
            $this->filename,
            sprintf("%s: %s [%s]\n", $level, $message, json_encode($context)),
            FILE_APPEND
        );
    }
}
