<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Compiler;

use GuzzleHttp\ClientInterface;

/**
 * Compiles a MJML file to an HTML file
 */
class RestMjmlCompiler implements MjmlCompilerInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function compile(string $input, string $output)
    {
        $response = $this->client->request('post', '/', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'mjml' => file_get_contents($input)
            ]
        ]);

        $json = json_decode($response->getBody()->getContents(), true);

        file_put_contents($output, $json['html']);
    }
}
