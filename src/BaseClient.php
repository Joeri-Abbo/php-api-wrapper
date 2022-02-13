<?php

namespace Joeriabbo\ApiWrapper;


abstract class BaseClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    private \GuzzleHttp\Client $client;
    /**
     * @var int
     */
    private int $pageSize = 10;
    /**
     * @var int
     */
    private int $page = 0;
    /**
     * @var string|null
     */
    private ?string $bearerToken = null;
    /**
     * @var string|null
     */
    private ?string $search = null;

    /**
     * Setup client
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * get base api url
     * @return string
     */
    abstract public static function getBaseApi(): string;

    /**
     * @return array
     */
    abstract public function getHeader(): array;

    /**
     * Set page size
     * @param int $page_size
     * @return $this
     */
    public function setPageSize(int $page_size): self
    {
        $this->pageSize = $page_size;

        return $this;
    }

    /**
     * Get page size
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * Set page
     * @param int $page
     * @return $this
     */
    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Set page
     * @param string $search
     * @return $this
     */
    public function setSearch(string $search): self
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get page
     * @return string
     */
    public function getSearch(): string
    {
        try {
            if (is_null($this->search)) {
                throw new \Exception('search is not set');
            }
            return $this->search;
        } catch (\Exception $e) {
            echo 'ERROR:' . $e->getMessage();
            exit;
        }
    }

    /**
     * Set bearer token
     * @param int $page
     * @return $this
     */
    public function setBearerToken(string $token): self
    {
        $this->bearerToken = $token;

        return $this;
    }

    /**
     * Get bearer token
     * @return string
     */
    public function getBearerToken(): string
    {
        try {
            if (is_null($this->bearerToken)) {
                throw new \Exception('Bearer token is not set');
            }
            return $this->bearerToken;
        } catch (\Exception $e) {
            echo 'ERROR:' . $e->getMessage();
            exit;
        }
    }

    /**
     * @return string
     */
    public abstract function getSearchUrl(): string;

    /**
     * @return string
     */
    public abstract function getProductSingleUrl(string $id): string;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getProduct(string $id): array
    {
        return $this->getRequest($this->getProductSingleUrl($id));
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(): array
    {
        return $this->getRequest($this->getSearchUrl());
    }

    private function getRequest(string $url): array
    {
        return json_decode($this->client->request(
            'GET',
            $url,
            [
                'headers' => $this->getHeader()
            ]
        )->getBody()
            ->getContents(),
            true);
    }
}
