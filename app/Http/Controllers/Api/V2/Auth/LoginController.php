<?php

namespace App\Http\Controllers\Api\V2\Auth;

use App\Http\Requests\Api\V2\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends JsonApiController
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\Api\V2\Auth\LoginRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response|\LaravelJsonApi\Core\Document\Error
     * @throws \Exception
     */
    public function __invoke(LoginRequest $request): Response|Error
    {
        $client = DB::table('oauth_clients')->where('password_client', 1)->first();

        $request = Request::create(config('app.url') . '/oauth/token', 'POST', [
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $request->email,
            'password'      => $request->password,
            'profile_image' => $request->profile_image,
            'scope'         => '',
        ]);

        // console_log("    ");
        // console_log("Default Notification email address = "); 

        /** @var \Illuminate\Http\Response $response */
        $response = app()->handle($request);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            return Error::fromArray([
                'title'  => Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                'detail' => $response->exception->getMessage(),
                'status' => Response::HTTP_BAD_REQUEST,
            ]);
        }

        return $response;
    }
}
