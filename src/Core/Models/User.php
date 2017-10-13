<?php

namespace Botomatic\Engine\Core\Models;

use Botomatic\Engine\Core\Models\Base;

/**
 * Class User
 * @package Botomatic\Engine\Models
 */
class User extends Base
{
    const TABLE = 'botomatic_users';

    const ID = 'id';

    const FACEBOOK = 'facebook_id';
    const FACEBOOK_PAGE = 'facebook_page';

    const WEB_CONNECTOR = 'web_id';
    const ALEXA = 'alexa_id';

    const EMAIL = 'email';

    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';

    const IMAGE = 'image';
    const PHONE = 'phone';
    const CITY = 'city_id';
    const LOCALE = 'locale';
    const TIMEZONE = 'timezone';
    const GENDER = 'gender';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';


    /**
     * @var string
     */
    protected $table = self::TABLE;

    public $id = self::TABLE . '.' . self::ID;

    public $facebook_id = self::TABLE . '.' . self::FACEBOOK;
    public $facebook_page = self::TABLE . '.' . self::FACEBOOK_PAGE;

    public $web_connector_id = self::TABLE . '.' . self::WEB_CONNECTOR;
    public $alexa_id = self::TABLE . '.' . self::ALEXA;

    public $first_name = self::TABLE . '.' . self::FIRST_NAME;
    public $last_name = self::TABLE . '.' . self::LAST_NAME;

    public $email = self::TABLE . '.' . self::EMAIL;
    public $phone = self::TABLE . '.' . self::PHONE;
    public $image = self::TABLE . '.' . self::IMAGE;
    public $city_id = self::TABLE . '.' . self::CITY;
    public $locale = self::TABLE . '.' . self::LOCALE;
    public $timezone = self::TABLE . '.' . self::TIMEZONE;
    public $gender = self::TABLE . '.' . self::GENDER;

    public $created_at = self::TABLE . '.' . self::CREATED_AT;
    public $updated_at = self::TABLE . '.' . self::UPDATED_AT;
    public $deleted_at = self::TABLE . '.' . self::DELETED_AT;

    /**
     * @var array
     */
    protected $fields = [
        self::ID,
        self::FACEBOOK, self::FACEBOOK_PAGE,
        self::WEB_CONNECTOR, self::ALEXA,
        self::EMAIL,
        self::FIRST_NAME, self::LAST_NAME, self::GENDER,
        self::EMAIL, self::PHONE, self::IMAGE,
        self::LOCALE, self::TIMEZONE, self::GENDER,
        self::CREATED_AT, self::UPDATED_AT, self::DELETED_AT
    ];

    /**
     * @param $result
     *
     * @return \Botomatic\Engine\Core\Entities\User
     */
    public function buildEntity($result) : \Botomatic\Engine\Core\Entities\User
    {
        /**
         * If no result
         */
        if (empty($result)) return new \Botomatic\Engine\Core\Entities\User();

        $entity = new \Botomatic\Engine\Core\Entities\User();

        $entity->setId($result->{$this->id});
        $entity->setFacebookId($result->{$this->facebook_id});
        $entity->setFacebookPage($result->{$this->facebook_page});
        $entity->setWebConnectorId($result->{$this->web_connector_id});
        $entity->setAlexaId($result->{$this->alexa_id});

        $entity->setFirstName($result->{$this->first_name});
        $entity->setLastName($result->{$this->last_name});
        $entity->setGender($result->{$this->gender});
        $entity->setEmail($result->{$this->email});
        $entity->setPhone($result->{$this->phone});
        $entity->setImage($result->{$this->image});

        $entity->setLocale($result->{$this->locale});
        $entity->setTimezone($result->{$this->timezone});

        $entity->setCreatedAt(new \Carbon\Carbon($result->{$this->created_at}));
        $entity->setUpdatedAt(new \Carbon\Carbon($result->{$this->updated_at}));

        return $entity;
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\User $user
     *
     * @return array
     */
    public function buildArrayForInsert(\Botomatic\Engine\Core\Entities\User $user) : array
    {
        return [
            self::FACEBOOK => $user->getFacebookId(),
            self::FACEBOOK_PAGE => $user->getFacebookPage(),
            self::WEB_CONNECTOR => $user->getWebConnectorId(),
            self::ALEXA => $user->getAlexaId(),

            self::FIRST_NAME => $user->getFirstName(),
            self::LAST_NAME => $user->getLastName(),
            self::GENDER => $user->getGender(),

            self::EMAIL => $user->getEmail(),
            self::PHONE => $user->getPhone(),
            self::IMAGE => $user->getImage(),

            self::LOCALE => $user->getLocale(),
            self::TIMEZONE => $user->getTimezone(),
        ];
    }
}