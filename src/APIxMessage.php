<?php

namespace AbdulmatinSanni\APIx;

class APIxMessage
{
    /**
     * Notification sender.
     *
     * @var string
     */
    public $from;

    /**
     * Notification message.
     *
     * @var string
     */
    public $message;

    /**
     * APIxMessage constructor.
     * @param string $message
     */
    public function __construct($message = '')
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the sender name.
     *
     * @param string $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the message.
     *
     * @param string $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message as array.
     *
     * @return array
     */
    public function toArray()
    {
        $message = [
            'from' => $this->from,
            'message' => $this->message,
        ];

        return $message;
    }
}
