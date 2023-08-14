<?php

namespace testassignment;

/*
    This interface contains the functions that need to be implemented by an Http response message 
*/

interface HttpResponseInterface
{
    public function getHeader();

    public function setResponseHeader();

    public function getBody();

    public function setResponseBody();

    public function setBody($body);

    public function getProtocol();

    public function setProtocol();
}

/*
    This contains the methods used by all the http response types
    The class gets the used protocol, creates the header string and sends the header alongside the supplied body
*/

class HttpResponse implements HttpResponseInterface
{
    protected $header;
    private $protocol;
    private $body;

    public function __construct($body)
    {
        $this->setResponseHeader();
        $this->setBody($body);
        
        $this->setResponseBody();
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setProtocol()
    {
        $this->protocol = $_SERVER["SERVER_PROTOCOL"];
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function setResponseHeader()
    {
        header($this->getHeader());
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setResponseBody(){
        echo json_encode($this->body);
    }
}

class HttpOkResponse extends HttpResponse
{
    protected $header = "HTTP/1.1 200 OK";
}

class HttpCreatedResponse extends HttpResponse
{
    protected $header = "HTTP/1.1 201 Created";
}

class HttpUnprocessableResponse extends HttpResponse
{
    protected $header = "HTTP/1.1 422 Unprocessable entity";
}

class HttpNotImplementedResponse extends HttpResponse
{
    protected $header = "HTTP/1.1 501 Not Implemented";
}

class HttpNotFoundResponse extends HttpResponse
{
    protected $header = "HTTP/1.1 404 Not Found";
}

?>