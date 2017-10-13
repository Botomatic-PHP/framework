<?php

namespace Botomatic\Engine\Controllers\Webhook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Facebook extends Controller
{
    /**
     * BusinessModels
     */
    use \Botomatic\Engine\Facebook\Traits\BusinessModels\Session\FindOrCreate;

    /**
     * @var Request
     */
    private $request;

    /**
     * Facebook constructor.
     * @param Request $request
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
    }

    public function __invoke()
    {
        try
        {
            // process the request, extract the message, establish type (message, postback, file etc)
            $request = new \Botomatic\Engine\Facebook\Core\Request($this->request);

            // find or create session
            $session = $this->facebookBusinessModelSessionFindOrCreate()->findOrCreate($request);

            // start the engine
            $engine = new \Botomatic\Engine\Facebook\Core\Engine($session, $request->getMessage());

            // process the message
            $engine->process();

            // log request?
            if (env('BOTOMATIC_FACEBOOK_LOG_REQUESTS', false) == true)
            {
                \Botomatic\Engine\Core\Debug\Logger::requestFromFacebook($session->getUser(), $this->request->toArray());
            }

            // respond
            return $engine->getResponse();
        }
        catch (\Exception $exception)
        {
            /**
             * Log the problem
             */
            logger()->critical($exception);

            /**
             * Locally we output the error
             */
            if (app()->isLocal())
            {
                return response()->json([
                    'error' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]);
            }

            return '';
        }
    }
}
