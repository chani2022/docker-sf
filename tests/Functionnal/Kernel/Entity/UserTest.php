<?php

declare(strict_types=1);

namespace App\Tests\Kernel\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
{
    protected User $user;
    protected ValidatorInterface $validator;

    public function setUp(): void
    {
        parent::setUp();

        static::bootKernel();

        $this->validator = static::getContainer()->get(ValidatorInterface::class);

        $this->user = new User();
    }

    public function testEmailBlank(): void
    {
        $errors = $this->validator->validatePropertyValue($this->user, "email", null);

        $this->assertEquals(1, count($errors));
    }

    public function testEmailNotEmailValid(): void
    {
        $errors = $this->validator->validatePropertyValue($this->user, "email", "test");

        $this->assertEquals(1, count($errors));
    }

    public function testEmailValid(): void
    {
        $errors = $this->validator->validatePropertyValue($this->user, "email", "test@test.com");

        $this->assertEquals(0, count($errors));
    }

    public function testRolesBlank(): void
    {
        $errors = $this->validator->validatePropertyValue($this->user, "roles", null);

        $this->assertEquals(1, count($errors));
    }

    public function testRolesArrayBlank(): void
    {
        $errors = $this->validator->validatePropertyValue($this->user, "roles", []);

        $this->assertEquals(1, count($errors));
    }

    public function testRolesArrayContainsRole(): void
    {
        $errors = $this->validator->validatePropertyValue($this->user, "roles", ["admin"]);

        $this->assertEquals(1, count($errors));
    }

    public function testRoleValid(): void
    {
        $errors = $this->validator->validatePropertyValue($this->user, "roles", ["ROLE_TEST"]);

        $this->assertEquals(0, count($errors));
    }
}
