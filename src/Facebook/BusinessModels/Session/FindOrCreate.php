<?php 

namespace Botomatic\Engine\Facebook\BusinessModels\Session;

/**
 * Class FindOrCreate
 * @package Botomatic\Engine\BusinessModels\Session\Facebook
 */
class FindOrCreate
{
    /**
     * Repositories
     */
    use \Botomatic\Engine\Core\Traits\Repositories\Sessions;
    use \Botomatic\Engine\Core\Traits\Repositories\Users;

    /**
     * @param \Botomatic\Engine\Facebook\Core\Request $request
     *
     * @return \Botomatic\Engine\Core\Entities\Session
     */
    public function findOrCreate(\Botomatic\Engine\Facebook\Core\Request $request) : \Botomatic\Engine\Core\Entities\Session
    {
        /**
         * Find session
         */
        $session = $this->botomaticRepositorySessions()->findBySessionAndPlatform($request->generateSessionId(), \Botomatic\Engine\Core\Configuration\Platforms::FACEBOOK);

        /**
         * If there's no session build it
         */
        if ($session->isEmpty())
        {
            $session->setSession($request->generateSessionId());
            $session->setPlatform(\Botomatic\Engine\Core\Configuration\Platforms::FACEBOOK);
            $session->setUser($this->findFacebookUser($request));

            $session = $this->botomaticRepositorySessions()->insert($session);
        }

        return $session;
    }

    /**
     * @param \Botomatic\Engine\Facebook\Core\Request $request
     *
     * @return \Botomatic\Engine\Core\Entities\User
     */
    protected function findFacebookUser(\Botomatic\Engine\Facebook\Core\Request $request) : \Botomatic\Engine\Core\Entities\User
    {
        /**
         * Find user
         */
        $user = $this->botomaticRepositoryUser()->findByFacebook($request->getSender());

        /**
         * If the user doesn't exist, create it
         */
        if ($user->isEmpty())
        {
            $user->setFacebookId($request->getSender());
            $user->setFacebookPage($request->getRecipient());

            /**
             * Fetch data from facebook
             */
            try
            {
                $facebook_token = config('botomatic.facebook.pages.' . $user->getFacebookPage());

                $curl = new \Curl\Curl();
                $curl->get('https://graph.facebook.com/' . env('BOTOMATIC_FACEBOOK_GRAPH_VERSION', 'v2.7') . '/' . $request->getSender() .'?access_token=' . $facebook_token);

                $response =  $curl->response;

                /*
                 *    +"first_name": ""
                      +"last_name": ""
                      +"profile_pic": "url"
                      +"locale": "en_US"
                      +"timezone": 1
                      +"gender": "male"
                 */

                $user->setFirstName($response->first_name);
                $user->setLastName($response->last_name);
                $user->setLocale($response->locale);
                $user->setTimezone($response->timezone);
                $user->setImage($response->profile_pic);
                $user->setGender($response->gender);

            }
            catch (\Exception $exception)
            {
                logger()->error('Failed to fetch user profile from facebook: ' . $exception->getMessage());
            }

            /**
             * Save user
             */
            $user = $this->botomaticRepositoryUser()->insert($user);
        }

        return $user;
    }

}