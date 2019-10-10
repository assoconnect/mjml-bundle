<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\RestCompiler;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Process\Process;

class RestCompilerHandlerStackFactory
{
    /**
     * @var string
     */
    private $temporaryDirectory;

    public function __construct(string $temporaryDirectory)
    {
        $this->temporaryDirectory = $temporaryDirectory;
    }

    public function create(): HandlerStack
    {
        return HandlerStack::create(new MockHandler(array_fill(0, 10, function (Request $a) {
            $temporaryFilename = tempnam($this->temporaryDirectory, 'mjml-rest-') . '.txt';
            $requestBodyObject = json_decode($a->getBody()->getContents(), true);
            file_put_contents($temporaryFilename, $requestBodyObject['mjml']);

            $command = [
                'mjml',
                $temporaryFilename,
                '-o',
                $temporaryFilename,
                '--config.validationLevel=strict',
            ];
            $process = new Process($command);
            $process->mustRun();

            $response = new Response(200, [
                'X-Server' => 'fake-mjml-server'
            ], json_encode([
                'html' => file_get_contents($temporaryFilename)
            ]));
            unlink($temporaryFilename);

            return $response;
        })));
    }
}
