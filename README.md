# Middleware

Middleware is a general term for software that serves to "glue together" separate, often complex and already existing, programs. Some software components that are frequently connected with middleware include enterprise applications and Web services.

ref :

    * http://searchsoa.techtarget.com/definition/middleware
    * http://www.webopedia.com/TERM/M/middleware.html
    * http://www.softwareag.com/blog/reality_check/index.php/integration-insights/middleware-for-my-mom-or-kids-guide-to-what-i-do/
    * http://www.networkcomputing.com/netdesign/cdmwdef.htm
    * https://en.wikipedia.org/wiki/Middleware

# Middleware in Micro Frameworks

What is middleware?

## Zend

Middleware is code that exists between the request and response, and which can take the incoming request, perform actions based on it, and either complete the response or pass delegation on to the next middleware in the queue.

https://github.com/zendframework/zend-stratigility/blob/master/doc/book/middleware.md

## Lumen

HTTP middleware provide a convenient mechanism for filtering HTTP requests entering your application. For example, Laravel includes a middleware that verifies the user of your application is authenticated. If the user is not authenticated, the middleware will redirect the user to the login screen. However, if the user is authenticated, the middleware will allow the request to proceed further into the application.

http://laravel.com/docs/master/middleware

## Silex

Silex allows you to run code, that changes the default Silex behavior, at different stages during the handling of a request through middlewares:

* Application middlewares are triggered independently of the current handled request;
* Route middlewares are triggered when their associated route is matched.

http://silex.sensiolabs.org/doc/middlewares.html

## Slim

The purpose of middleware is to inspect, analyze, or modify the application environment, request, and response before and/or after the Slim application is invoked.

http://docs.slimframework.com/middleware/overview/

# HTTP Headers

Whether you're a programmer or not, you have seen it everywhere on the web. At this moment your browsers address bar shows something that starts with "http://". Even your first Hello World script sent HTTP headers without you realizing it. In this article we are going to learn about the basics of HTTP headers and how we can use them in our web applications.

The HTTP response that a server sends back to a client contains headers that identify the type of content in the body of the response, the server that sent the response, how many bytes are in the body, when the response was sent, etc. PHP and Apache normally take care of the headers for you, **identifying the document as HTML**, calculating the length of the HTML page, and so on. Most web applications never need to set headers themselves. However, if you want to send back something that's not HTML, set the expiration time for a page, redirect the client's browser, or generate a specific HTTP error, you'll need to use the header( ) function.

## How to See HTTP Headers

* Firebug extensions to analyze HTTP headers.

    1. Turn in Firebug
    2. Click Net
    3. Click Headers

## ref:

    * http://docstore.mik.ua/orelly/webprog/php/ch07_05.htm
    * http://code.tutsplus.com/tutorials/http-headers-for-dummies--net-8039
