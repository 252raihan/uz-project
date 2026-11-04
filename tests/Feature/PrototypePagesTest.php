<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PrototypePagesTest extends TestCase
{
    public function test_public_landing_page_is_available(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Phulbaria Upazila Service Platform')
            ->assertSee('Independent prototype')
            ->assertSee('not an official website')
            ->assertSee('Blood donors')
            ->assertSee('Public problem reporting');
    }

    public function test_login_prototype_is_available_and_disabled(): void
    {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSee('Sign in to your account')
            ->assertSee('This form is not connected yet')
            ->assertSee('Sign-in is disabled in this prototype');
    }

    public function test_registration_prototype_is_available_and_does_not_collect_real_nid(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSee('Nothing will be submitted')
            ->assertSee('Do not enter a real NID number in this prototype')
            ->assertSee('Phulbaria Municipality')
            ->assertSee('Ward 9');
    }

    public function test_citizen_dashboard_placeholder_is_available(): void
    {
        $response = $this->get('/dashboard');

        $response
            ->assertOk()
            ->assertSee('Placeholder dashboard')
            ->assertSee('Demo Citizen')
            ->assertSee('Ward 3 (demo)')
            ->assertSee('No real data');
    }

    public function test_admin_dashboard_placeholder_is_available_and_clearly_labelled(): void
    {
        $response = $this->get('/admin');

        $response
            ->assertOk()
            ->assertSee('Admin placeholder')
            ->assertSee('Authorization not active')
            ->assertSee('Do not use this screen to manage real users or data');
    }

    public function test_prototype_has_no_post_routes_for_login_or_registration(): void
    {
        $postRoutes = collect(Route::getRoutes()->getRoutesByMethod()['POST'] ?? []);

        $this->assertFalse($postRoutes->contains(
            fn ($route): bool => in_array($route->uri(), ['login', 'register', 'dashboard', 'admin'], true)
        ));
    }

    public function test_route_names_follow_the_documented_naming_convention(): void
    {
        foreach (['home', 'prototype.login', 'prototype.register', 'prototype.citizen.dashboard', 'prototype.admin.dashboard'] as $name) {
            $this->assertTrue(Route::has($name), "Route name [{$name}] is missing.");
        }

        $this->assertFalse(Route::has('login'), 'The prototype must not claim the framework "login" route name.');
        $this->assertFalse(Route::has('register'), 'The prototype must not claim the framework "register" route name.');
    }
}
