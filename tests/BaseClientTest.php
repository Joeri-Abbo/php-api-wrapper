<?php

namespace Joeriabbo\ApiWrapper\Tests;

use Joeriabbo\ApiWrapper\BaseClient;
use PHPUnit\Framework\TestCase;

class ConcreteClient extends BaseClient
{
    public static function getBaseApi(): string
    {
        return 'https://api.example.com';
    }

    public function getHeader(): array
    {
        return ['Accept' => 'application/json'];
    }

    public function getSearchUrl(): string
    {
        return static::getBaseApi() . '/search';
    }

    public function getProductSingleUrl(string $id): string
    {
        return static::getBaseApi() . '/products/' . $id;
    }
}

class BaseClientTest extends TestCase
{
    private ConcreteClient $client;

    protected function setUp(): void
    {
        $this->client = new ConcreteClient();
    }

    public function testDefaultPageSize(): void
    {
        $this->assertSame(10, $this->client->getPageSize());
    }

    public function testSetPageSize(): void
    {
        $result = $this->client->setPageSize(25);
        $this->assertSame($this->client, $result);
        $this->assertSame(25, $this->client->getPageSize());
    }

    public function testDefaultPage(): void
    {
        $this->assertSame(0, $this->client->getPage());
    }

    public function testSetPage(): void
    {
        $result = $this->client->setPage(3);
        $this->assertSame($this->client, $result);
        $this->assertSame(3, $this->client->getPage());
    }

    public function testSetBearerToken(): void
    {
        $result = $this->client->setBearerToken('my-token');
        $this->assertSame($this->client, $result);
        $this->assertSame('my-token', $this->client->getBearerToken());
    }

    public function testSetSearch(): void
    {
        $result = $this->client->setSearch('foo');
        $this->assertSame($this->client, $result);
        $this->assertSame('foo', $this->client->getSearch());
    }

    public function testGetBaseApi(): void
    {
        $this->assertSame('https://api.example.com', ConcreteClient::getBaseApi());
    }

    public function testGetSearchUrl(): void
    {
        $this->assertSame('https://api.example.com/search', $this->client->getSearchUrl());
    }

    public function testGetProductSingleUrl(): void
    {
        $this->assertSame('https://api.example.com/products/42', $this->client->getProductSingleUrl('42'));
    }
}
