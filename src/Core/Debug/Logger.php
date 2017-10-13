<?php

namespace Botomatic\Engine\Core\Debug;

use Botomatic\Engine\Core\Configuration\Platforms;
use \Botomatic\Engine\Core\Models\Logs as LogsModel;

/**
 * Class Logger
 * @package Botomatic\Engine\Core\Debug
 */
class Logger
{
    /**
     * @param \Botomatic\Engine\Core\Entities\User $user
     * @param array $request
     */
    public static function requestFromFacebook(\Botomatic\Engine\Core\Entities\User $user, array $request)
    {
        LogsModel::add($user->getId(), Platforms::FACEBOOK, false, json_encode($request, true));
    }

    /**
     * @param \Botomatic\Engine\Core\Entities\User $user
     * @param array $response
     */
    public static function responseForFacebook(\Botomatic\Engine\Core\Entities\User $user, array $response)
    {
        LogsModel::add($user->getId(), Platforms::FACEBOOK, true, json_encode($response, true));

    }

}