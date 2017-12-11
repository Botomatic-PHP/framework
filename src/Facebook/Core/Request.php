<?php

namespace Botomatic\Engine\Facebook\Core;

use Botomatic\Engine\Facebook\Entities\Message\Attachment;

/**
 * Class BuildMessage
 * @package Botomatic\Engine\Entities\Platforms\Facebook
 */
class Request
{
    /**
     * @var string
     */
    protected $page_id;

    /**
     * @var int
     */
    protected $time;

    /**
     * @var string
     */
    protected $sender;

    /**
     * This is the PAGE ID also, not sure why is duplicated in the request or what to do with it
     *
     * @var string
     */
    protected $recipient;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Botomatic\Engine\Facebook\Entities\Message
     */
    protected $message;

    /**
     * @var int
     */
    protected $sequance;

    /**
     * @var string
     */
    protected $payload;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Exception
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->message = new \Botomatic\Engine\Facebook\Entities\Message();

        $request_data = $request->all();

        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Page specific information
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        $this->setPageId($request_data['entry'][0]['id']);
        $this->setSender($request_data['entry'][0]['messaging'][0]['sender']['id']);
        $this->setRecipient($request_data['entry'][0]['messaging'][0]['recipient']['id']);


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Message callback
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if (isset($request_data['entry'][0]['messaging'][0]['message']))
        {
            $this->message->setTypeMessage();

            if (isset($request_data['entry'][0]['messaging'][0]['message']['text']))
            {
                $this->getMessage()->setMessage($request_data['entry'][0]['messaging'][0]['message']['text']);
            }

            /**
             * Optional NLP
             */
            if (isset($request_data['entry'][0]['messaging'][0]['message']['nlp']))
            {
                if (count($request_data['entry'][0]['messaging'][0]['message']['nlp']['entities']) > 0)
                {
                    $this->getMessage()->nlp()->setEntities($request_data['entry'][0]['messaging'][0]['message']['nlp']['entities']);
                }
            }


            /**
             * Optional Quick Replies
             */
            if (isset($request_data['entry'][0]['messaging'][0]['message']['quick_reply']['payload']))
            {
                $this->getMessage()->setQuickReply($request_data['entry'][0]['messaging'][0]['message']['quick_reply']['payload']);
            }

            /**
             * Attachments
             */
            if (isset($request_data['entry'][0]['messaging'][0]['message']['attachments']))
            {
                // image, video, audio, file
                if (in_array($request_data['entry'][0]['messaging'][0]['message']['attachments'][0]['type'], [
                    'file', 'audio', 'image', 'video'
                ]))
                {
                    $attachment = new Attachment();

                    $attachment->setType($request_data['entry'][0]['messaging'][0]['message']['attachments'][0]['type']);
                    $attachment->setUrl($request_data['entry'][0]['messaging'][0]['message']['attachments'][0]['payload']['url']);

                    $this->message->setAttachment($attachment);
                }

                /**
                 * Find location
                 */
                if ($request_data['entry'][0]['messaging'][0]['message']['attachments'][0]['type'] == 'location')
                {
                    $this->getMessage()->location()->setLatitude(
                        $request_data['entry'][0]['messaging'][0]['message']['attachments'][0]['payload']['coordinates']['lat']
                    );

                    $this->getMessage()->location()->setLongitude(
                        $request_data['entry'][0]['messaging'][0]['message']['attachments'][0]['payload']['coordinates']['long']
                    );
                }
            }

            return $this;
        }

        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Postback callback
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if (isset($request_data['entry'][0]['messaging'][0]['postback']))
        {
            $this->message->setTypePostback();

            $this->message->postback()->setPayload($request_data['entry'][0]['messaging'][0]['postback']['payload']);

            /**
             * Do we also have referral data?
             */
            if (isset($request_data['entry'][0]['messaging'][0]['postback']['referral']))
            {
                $this->message->postback()->setReferral($request_data['entry'][0]['messaging'][0]['postback']['referral']);
            }

            return $this;
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Account Linking callback
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if (isset($request_data['entry'][0]['messaging'][0]['account_linking']))
        {
            $this->message->setTypeAccountLinking();

            $this->getMessage()->account_linking()->setData($request_data['entry'][0]['messaging'][0]['account_linking']);

            return $this;
        }


        /*--------------------------------------------------------------------------------------------------------------
         *
         *
         * Referral callback
         *
         *
         -------------------------------------------------------------------------------------------------------------*/
        if (isset($request_data['entry'][0]['messaging'][0]['referral']))
        {
            $this->message->setTypeReferral();

            $this->getMessage()->referral()->setData($request_data['entry'][0]['messaging'][0]['referral']);

            return $this;
        }


        throw new \Exception('Invalid request');
    }

    /**
     * @return string
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * @param string $page_id
     */
    public function setPageId($page_id)
    {
        $this->page_id = $page_id;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return \Botomatic\Engine\Facebook\Entities\Message
     */
    public function getMessage() : \Botomatic\Engine\Facebook\Entities\Message
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getSequance()
    {
        return $this->sequance;
    }

    /**
     * @param int $sequance
     */
    public function setSequance($sequance)
    {
        $this->sequance = $sequance;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload(string $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function generateSessionId()
    {
        return $this->getPageId() . $this->getSender() . $this->getRecipient();
    }
}