<?php

namespace NotificationChannels\Cmsms;

use NotificationChannels\Cmsms\Exceptions\InvalidMessage;

class CmsmsMessage
{
    /** @var string */
    protected $body;

    /** @var string */
    protected $originator;

    /** @var string */
    protected $reference;

    /** @var int */
    protected $tariff;

    /**
     * @param string $body
     */
    public function __construct($body = '')
    {
        $this->body($body);
    }

    /**
     * @param string $body
     * @return $this
     */
    public function body($body)
    {
        $this->body = trim($body);

        return $this;
    }

    /**
     * @param string|int $originator
     * @return $this
     * @throws InvalidMessage
     */
    public function originator($originator)
    {
        if (empty($originator) || strlen($originator) > 11) {
            throw InvalidMessage::invalidOriginator($originator);
        }

        $this->originator = (string) $originator;

        return $this;
    }

    /**
     * @param string $reference
     * @return $this
     * @throws InvalidMessage
     */
    public function reference($reference)
    {
        if (empty($reference) || strlen($reference) > 32 || ! ctype_alnum($reference)) {
            throw InvalidMessage::invalidReference($reference);
        }

        $this->reference = $reference;

        return $this;
    }

    /**
     * @param int $tariff Tariff in eurocent
     * @return $this
     * @throws InvalidMessage
     */
    public function tariff($tariff)
    {
        if (empty($tariff) || ! is_int($tariff)) {
            throw InvalidMessage::invalidTariff($tariff);
        }

        $this->tariff = $tariff;

        return $this;
    }

    /**
     * @return array
     */
    public function toXmlArray()
    {
        return array_filter([
            'BODY' => $this->body,
            'FROM' => $this->originator,
            'REFERENCE' => $this->reference,
            'TARIFF' => $this->tariff,
        ]);
    }

    /**
     * @param string $body
     * @return static
     */
    public static function create($body = '')
    {
        return new static($body);
    }
}
