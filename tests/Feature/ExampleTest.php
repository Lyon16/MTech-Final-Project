<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_guests_cannot_access_management_pages(): void
    {
        $pages = [
            '/products',
            '/customers',
            '/staff',
            '/sales',
            '/sales/create',
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);

            $response->assertRedirect(route('login'));
        }
    }
}
