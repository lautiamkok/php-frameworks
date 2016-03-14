<?php

namespace Foo;

class AdminAuthMiddleware extends \Slim\Middleware
{
    public function __construct()
    {
    }

    public function call()
    {
        // Get reference to application
        $app = $this->app;

        // @ ref: http://help.slimframework.com/discussions/questions/296-middleware-usage-only-on-specific-routes
        if (strpos($this->app->request()->getPathInfo(), '/admin') === 0) {

            // Check for password in the cookie
            if ($app->getEncryptedCookie('my_cookie', false) != 'demo') {
                $app->redirect('login');
            }

            // Set request headers.
            $request = $app->request;
            $request->headers->set('X-User', 'xxxx');

            // Run inner middleware and application
            $this->next->call();

            // Capitalize response body
            $res = $app->response;
            $body = $res->getBody();
            $res->setBody(strtoupper($body));

            return;
        }

        $this->next->call();
        return;
    }
}
