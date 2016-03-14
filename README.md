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

# HTTP Messages

All HTTP messages consist of the HTTP protocol version being used, headers, and a message body. A Request builds on the message to include the HTTP method used to make the request, and the URI to which the request is made. A Response includes the HTTP status code and reason phrase.

...

## HTTP Headers

Whether you're a programmer or not, you have seen it everywhere on the web. At this moment your browsers address bar shows something that starts with "http://". Even your first Hello World script sent HTTP headers without you realizing it. In this article we are going to learn about the basics of HTTP headers and how we can use them in our web applications.

The HTTP response that a server sends back to a client contains headers that identify the type of content in the body of the response, the server that sent the response, how many bytes are in the body, when the response was sent, etc. PHP and Apache normally take care of the headers for you, **identifying the document as HTML**, calculating the length of the HTML page, and so on. Most web applications never need to set headers themselves. However, if you want to send back something that's not HTML, set the expiration time for a page, redirect the client's browser, or generate a specific HTTP error, you'll need to use the header( ) function.

    *How to See HTTP Headers*

    * Firebug extensions to analyze HTTP headers.

        1. Turn in Firebug
        2. Click Net
        3. Click Headers

    Ref:

        * http://docstore.mik.ua/orelly/webprog/php/ch07_05.htm
        * http://code.tutsplus.com/tutorials/http-headers-for-dummies--net-8039


    *Headers already sent: Why does it happen?*

    To understand why headers must be sent before output it's necessary to look at a typical HTTP response. PHP scripts mainly generate HTML content, but also pass a set of HTTP/CGI headers to the webserver:

    HTTP/1.1 200 OK
    Powered-By: PHP/5.3.7
    Vary: Accept-Encoding
    Content-Type: text/html; charset=utf-8

    <html><head><title>PHP page output page</title></head>
    <body><h1>Content</h1> <p>Some more output follows...</p>
    and <a href="/"> <img src=internal-icon-delayed> </a>
    The page/output always follows the headers. PHP has to pass the headers to the webserver first. It can only do that once. After the double linebreak it can nevermore amend them.

    When PHP receives the first output (print, echo, <html>) it will flush all collected headers. Afterwards it can send all the output it wants. But sending further HTTP headers is impossible then.

## HTTP Messages in PHP

PHP does not have built-in support for HTTP messages.

...

PHP streams are the most convenient and ubiquitous way to send HTTP requests, but pose a number of limitations with regards to properly configuring SSL support, and provide a cumbersome interface around setting things such as headers. cURL provides a complete and expanded feature-set, but, as it is not a default extension, is often not present. The http extension suffers from the same problem as cURL, as well as the fact that it has traditionally had far fewer examples of usage.

Most modern HTTP client libraries tend to abstract the implementation, to ensure they can work on whatever environment they are executed on, and across any of the above layers.

Notes:

    cURL allows you to connect and communicate to many different types of servers with many different types of protocols.
    (http://php.net/manual/en/intro.curl.php)

## Server-side HTTP Support

PHP uses Server APIs (SAPI) to interpret incoming HTTP requests, marshal input, and pass off handling to scripts. The original SAPI design mirrored Common Gateway Interface, which would marshal request data and push it into environment variables before passing delegation to a script; the script would then pull from the environment variables in order to process the request and return a response.

PHP's SAPI design abstracts common input sources such as cookies, query string arguments, and url-encoded POST content via superglobals ($_COOKIE, $_GET, and $_POST, respectively), providing a layer of convenience for web developers.

...

## Why Bother?

Direct usage of superglobals has a number of concerns. First, these are mutable, which makes it possible for libraries and code to alter the values, and thus alter state for the application. Additionally, superglobals make unit and integration testing difficult and brittle, leading to code quality degradation.

...

Finally, when it comes to server-side responses, PHP gets in its own way: any content emitted before a call to header() will result in that call becoming a no-op; depending on error reporting settings, this can often mean headers and/or response status are not correctly sent. One way to work around this is to use PHP's output buffering features, but nesting of output buffers can become problematic and difficult to debug. Frameworks and applications thus tend to create response abstractions for aggregating headers and content that can be emitted at once - and these abstractions are often incompatible.

    Ref: http://www.php-fig.org/psr/psr-7/meta/

You could use superglobals variables (as $_GET and $_POST), but they are global mutable state. Along with this unit and integration testing of your code becomes hard.

For these reasons many PHP frameworks decided to implement an abstaction to represent HTTP messages (see for example Symfony HttpFoundation or Zend\Http).

This led to a situation where any application was based on a specific implementation of HTTP messages, so that it was hardly usable in projects built using other frameworks.

This is why a common set of interfaces helps abstract HTTP messages and work with them in a framework agnostic way.

    Ref: http://stackoverflow.com/questions/32805681/php-why-http-message-implementations

# What are "Resources"?

HTTP is used to transmit resources, not just files. A resource is some chunk of information that can be identified by a URL (it's the R in URL). The most common kind of resource is a file, but a resource may also be a dynamically-generated query result, the output of a CGI script, a document that is available in several languages, or something else.

Ref:

    * http://www.w3schools.com/tags/ref_httpmessages.asp
    * https://www.jmarshall.com/easy/http/
