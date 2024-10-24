<?php

declare(strict_types=1);

namespace App\Tests\Functionnal\Web\Controller;

use App\Tests\Trait\FixtureTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class SecurityControllerTest extends WebTestCase
{
    use FixtureTrait;

    protected Crawler $crawler;
    protected KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->crawler = $this->client->request("GET", "/");

        $this->initFixtures();
    }

    /**
     * @return void
     */
    public function testLoginExist(): void
    {
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }

    /**
     * @dataProvider userProviderValidCredentials
     */
    public function testValidCredentials(string $email, string $password): void
    {
        $text_h1 = "home";

        if (str_contains($email, "admin")) {
            $text_h1 = "Admin";
        }

        $form = $this->crawler->selectButton("Sign in")->form([
            "email" => $email,
            "password" => $password,
        ]);

        $this->client->submit($form);

        $this->client->followRedirect();

        $this->assertSelectorTextContains("h1", $text_h1);
    }
    /**
     * @dataProvider userProviderInValidCredentials
     */
    public function testInvalidCredentials(string $email, string $password): void
    {
        $form = $this->crawler->selectButton("Sign in")->form([
            "email" => $email,
            "password" => $password
        ]);

        $this->client->submit($form);

        $this->client->followRedirect();

        $this->assertSelectorExists(".alert-danger");
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function userProviderValidCredentials()
    {
        return [
            "admin" => [
                "email" => "admin@test.mg",
                "password" => "admin"
            ],
            "redac" => [
                "email" => "redac@test.mg",
                "password" => "redac",
            ],
            "user" => [
                "email" => "visiteur@test.mg",
                "password" => "user",
            ]
        ];
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function userProviderInValidCredentials()
    {
        return [
            "admin_password_wrong" => [
                "email" => "admin@test.mg",
                "password" => "admine"
            ],
            "admin_email_wrong" => [
                "email" => "admine@test.mg",
                "password" => "admin"
            ],
            "redac_email_wrong" => [
                "email" => "email@email.mg",
                "password" => "redac"
            ],
            "redac_password_wrong" => [
                "email" => "redac@test.mg",
                "password" => "redacwrong"
            ],
            "user_email_wrong" => [
                "email" => "visiteurs@test.mg",
                "password" => "user"
            ],
            "user_password_wrong" => [
                "email" => "visiteur@test.mg",
                "password" => "users"
            ],
            "credentials_wrong" => [
                "email" => "wrong@wrong.com",
                "password" => "wrong"
            ],
        ];
    }
}
