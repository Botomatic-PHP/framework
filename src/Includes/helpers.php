<?php

const BOTOMATIC_VERSION = '1.6';

/**
 * @return \Botomatic\Engine\Facebook\Localization\Localizator
 */
function localizator() : \Botomatic\Engine\Facebook\Localization\Localizator
{
    return app('botomatic-translator');
}