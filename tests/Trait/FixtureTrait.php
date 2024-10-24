<?php

namespace App\Tests\Trait;

use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

trait FixtureTrait
{

    protected AbstractDatabaseTool $databaseTool;
    protected array $fixtures;

    public function initFixtures(): void
    {
        dd("makato");
        $container = static::getContainer();
        $path_fixture = $container->getParameter("root_path_fixtures");

        $this->databaseTool = $container->get(DatabaseToolCollection::class)->get();
        $this->fixtures = $this->databaseTool->loadAliceFixture([
            $path_fixture . '/user.yaml'
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
