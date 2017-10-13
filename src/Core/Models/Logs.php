<?php

namespace Botomatic\Engine\Core\Models;

/**
 * Class Logs
 * @package Botomatic\Engine\Core\Models
 */
class Logs extends Base
{

    const TABLE = 'botomatic_users_logs';

    const ID = 'id';

    const USER_ID = 'user_id';
    const PLATFORM = 'platform';
    const SENT = 'sent'; // 1 = sent, 0 = received
    const MESSAGE = 'message';
    const CREATED_AT = 'created_at';


    /**
     * @var array
     */
    protected $fields = [
        self::ID,
        self::USER_ID,
        self::PLATFORM,
        self::SENT,
        self::MESSAGE,
        self::CREATED_AT,
    ];

    /**
     * @param int $user_id
     * @param int $platform
     * @param bool $sent
     * @param string $message
     */
    public static function add(int $user_id, int $platform, bool $sent, string $message)
    {
        \DB::table(self::TABLE)->insert([
            self::USER_ID => $user_id,
            self::PLATFORM => $platform,
            self::SENT => $sent,
            self::MESSAGE => $message,
            self::CREATED_AT => \Carbon\Carbon::now(),
        ]);
    }

}