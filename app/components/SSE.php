<?php

namespace app\components;

/**
 * Description of SSE
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SSE
{
    /**
     *
     * @var boolean
     */
    private $_headerSent;

    private function sendHeader()
    {
        if (!$this->_headerSent && !headers_sent()) {
            $this->_headerSent = true;
            header("Content-Type: text/event-stream");
            header('Cache-Control: no-cache');
        }
    }

    public function event($name, $data = null)
    {
        $this->sendHeader();
        echo "event: {$name}\n";
        if ($data !== null) {
            $this->sendData($data);
        }
        echo "\n";
    }

    protected function sendData($data)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }
        $messages = explode("\n", $data);
        foreach ($messages as $message) {
            echo "data: {$message}\n";
        }
    }

    public function message($data)
    {
        $this->sendHeader();
        $this->sendData($data);
        echo "\n";
    }

    public function id($id, $data = '')
    {
        $this->sendHeader();
        echo "id: {$id}\n";
        $this->sendData($data);
        echo "\n";
    }

    public function retry($time)
    {
        $this->sendHeader();
        echo "retry: {$time}\n\n";
    }

    public function flush()
    {
        $this->sendHeader();
        ob_flush();
        flush();
    }
}