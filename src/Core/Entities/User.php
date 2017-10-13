<?php

namespace Botomatic\Engine\Core\Entities;

/**
 * Class User
 * @package Botomatic\Engine\Entities
 */
class User
{
    use \Botomatic\Engine\Core\Traits\Entities\Id;
    use \Botomatic\Engine\Core\Traits\Entities\CreatedAt;
    use \Botomatic\Engine\Core\Traits\Entities\UpdatedAt;

    /**
     * @var string
     */
    protected $facebook_id = null;

    /**
     * @var string
     */
    protected $facebook_page = null;

    /**
     * @var string
     */
    protected $web_connector_id = null;

    /**
     * @var string
     */
    protected $alexa_id = null;

    /**
     * @var string
     */
    protected $first_name = '';

    /**
     * @var string
     */
    protected $last_name = '';

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var string
     */
    protected $phone = '';

    /**
     * @var string
     */
    protected $image = '';

    /**
     * @var string
     */
    protected $locale = '';

    /**
     * @var string
     */
    protected $timezone = '';

    /**
     * @var string
     */
    protected $gender = '';

    /**
     * @var \Botomatic\Engine\Core\Entities\City
     */
    protected $city;

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * @param string $facebook_id
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
    }

    /**
     * @return string
     */
    public function getFacebookPage()
    {
        return $this->facebook_page;
    }

    /**
     * @param string $facebook_page
     */
    public function setFacebookPage($facebook_page)
    {
        $this->facebook_page = $facebook_page;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getWebConnectorId()
    {
        return $this->web_connector_id;
    }

    /**
     * @param string $web_connector_id
     */
    public function setWebConnectorId($web_connector_id)
    {
        $this->web_connector_id = $web_connector_id;
    }

    /**
     * @return string
     */
    public function getAlexaId()
    {
        return $this->alexa_id;
    }

    /**
     * @param string $alexa_id
     */
    public function setAlexaId($alexa_id)
    {
        $this->alexa_id = $alexa_id;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /*------------------------------------------------------------------------------------------------------------------
     *
     * Helper methods
     *
     -----------------------------------------------------------------------------------------------------------------*/

    /**
     * @return bool
     */
    public function isMale() : bool
    {
        return $this->gender == 'male';
    }

    /**
     * @return bool
     */
    public function isFemale() : bool
    {
        return $this->gender == 'female';
    }
}