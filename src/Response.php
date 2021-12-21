<?php

namespace Mstnorris\SimpleAnalytics;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Support\Arr;

class Response
{
    private string $reasonPhrase = '';

    private int $statusCode = 200;

    private bool $status = false;

    private mixed $body = null;

    /**
     * Response constructor.
     *
     * @param GuzzleResponse $response
     */
    public function __construct(GuzzleResponse $response)
    {
        $this->statusCode = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();
        $this->body = $this->decodeBody($response);
        $this->status = $this->statusCode === 200;
    }

    /**
     * @param GuzzleResponse $response
     *
     * @return string|array
     */
    private function decodeBody(GuzzleResponse $response)
    {
        return json_decode($response->getBody(), true) ?: (string)$response->getBody();
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * @param bool $status
     *
     * @return Response
     */
    public function setStatus(bool $status): Response
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $body
     *
     * @return Response
     */
    public function setBody($body): Response
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyData()
    {
        return Arr::get($this->body, 'Data', $this->body);
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isFailed()
    {
        return !$this->status;
    }
    
}
