<?php

declare(strict_types=1);

namespace AssoConnect\MJMLBundle\Tests\Command;

use Assoconnect\MJMLBundle\Tests\Functional\App\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CompilerCommandTest extends TestCase
{
    protected function getCommand(): Command
    {
        self::bootKernel();

        $application = new Application(self::$kernel);

        return $application->find('mjml:compiler');
    }

    /**
     * Tests that all templates are found and compiled
     */
    public function testCompileAll()
    {
        $command = $this->getCommand();
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();

        $this->helperSuccess();
    }

    /**
     * Tests that a given template is compiled
     */
    public function testCompileOne()
    {
        $command = $this->getCommand();
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'template' => 'custom.mjml.twig'
        ]);

        $output = $commandTester->getDisplay();

        $this->helperSuccess();
    }
}