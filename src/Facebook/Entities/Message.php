<?php

namespace Botomatic\Engine\Facebook\Entities;

/**
 * Class Message
 * @package Botomatic\Engine\Facebook\Entities
 */
class Message
{

    /*------------------------------------------------------------------------------------------------------------------
     *
     * Each webhook callback is represented using a different type
     *
     * https://developers.facebook.com/docs/messenger-platform/webhook-reference
     *
     -----------------------------------------------------------------------------------------------------------------*/
    /**
     * "message" Callback
     */
    const TYPE_MESSAGE = 1;

    /**
     * "postback" Callback
     */
    const TYPE_POSTBACK = 2;

    /**
     * "postback" Callback
     */
    const TYPE_ACCOUNT_LINKING = 3;

    /**
     * "referral" Callback
     */
    const TYPE_REFERRAL = 4;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $quick_reply = '';

    /**
     * @var \Botomatic\Engine\Core\Entities\Location
     */
    protected $location = null;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Callbacks\Postback
     */
    protected $postback;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Callbacks\AccountLinking
     */
    protected $account_linking;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Callbacks\Referral
     */
    protected $referral;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Message\Attachment
     */
    protected $attachment = null;

    /**
     * @var array
     */
    protected $nlp = [];

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param array $nlp
     */
    public function setNlp(array $nlp)
    {
        $this->nlp = $nlp;
    }

    /**
     * @return array
     */
    public function getNlp() : array
    {
        return $this->nlp;
    }

    /**
     * @return bool
     */
    public function hasNlp() : bool
    {
        return count($this->nlp) > 0;
    }

    /**
     * @return string
     */
    public function getQuickReply() : string
    {
        return $this->quick_reply;
    }

    /**
     * @param string $quick_reply
     */
    public function setQuickReply(string $quick_reply)
    {
        $this->quick_reply = $quick_reply;
    }

    /**
     * @return \Botomatic\Engine\Core\Entities\Location
     */
    public function location() : \Botomatic\Engine\Core\Entities\Location
    {
        if (is_null($this->location))
        {
            $this->location = new \Botomatic\Engine\Core\Entities\Location();
        }
        return $this->location;
    }

    /**
     * @return \Botomatic\Engine\Facebook\Entities\Callbacks\Postback
     */
    public function postback() : \Botomatic\Engine\Facebook\Entities\Callbacks\Postback
    {
        if (is_null($this->postback))
        {
            $this->postback = new \Botomatic\Engine\Facebook\Entities\Callbacks\Postback();
        }

        return $this->postback;
    }

    /**
     * @return \Botomatic\Engine\Facebook\Entities\Callbacks\AccountLinking
     */
    public function account_linking() : \Botomatic\Engine\Facebook\Entities\Callbacks\AccountLinking
    {
        if (is_null($this->account_linking))
        {
            $this->account_linking = new \Botomatic\Engine\Facebook\Entities\Callbacks\AccountLinking();
        }

        return $this->account_linking;
    }

    /**
     * @return \Botomatic\Engine\Facebook\Entities\Callbacks\Referral
     */
    public function referral() : \Botomatic\Engine\Facebook\Entities\Callbacks\Referral
    {
        if (is_null($this->referral))
        {
            $this->referral = new \Botomatic\Engine\Facebook\Entities\Callbacks\Referral();
        }

        return $this->referral;
    }

    /**
     * @return bool
     */
    public function hasLocation() : bool
    {
        return !is_null($this->location);
    }

    /**
     * @param Message\Attachment $attachment
     */
    public function setAttachment(Message\Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @return Message\Attachment
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @return bool
     */
    public function hasAttachment() : bool
    {
        return !is_null($this->attachment);
    }

    /**
     * @return bool
     */
    public function hasQuickReply() : bool
    {
        return !is_null($this->quick_reply);
    }

    /*------------------------------------------------------------------------------------------------------------------
     *
     * Types
     *
     -----------------------------------------------------------------------------------------------------------------*/
    public function isCallbackMessage() : bool
    {
        return $this->type == self::TYPE_MESSAGE;
    }

    public function setTypeMessage()
    {
        $this->type = self::TYPE_MESSAGE;
    }

    public function isCallbackPostback() : bool
    {
        return $this->type == self::TYPE_POSTBACK;
    }

    public function setTypePostback()
    {
        $this->type = self::TYPE_POSTBACK;
    }

    public function isCallbackAccountLinking() : bool
    {
        return $this->type == self::TYPE_ACCOUNT_LINKING;
    }

    public function setTypeAccountLinking()
    {
        $this->type = self::TYPE_ACCOUNT_LINKING;
    }

    public function isCallbackReferral() : bool
    {
        return $this->type == self::TYPE_REFERRAL;
    }

    public function setTypeReferral()
    {
        $this->type = self::TYPE_REFERRAL;
    }
}
