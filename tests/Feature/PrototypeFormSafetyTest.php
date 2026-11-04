<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Regression tests guarding the Milestone 1 prototype forms.
 *
 * The login and registration forms must never transmit credentials or personal
 * data. These tests fail if anyone re-introduces an action/method attribute,
 * a submit affordance, or a write route for those pages.
 */
class PrototypeFormSafetyTest extends TestCase
{
    /**
     * Every Blade template shipped by the prototype, including layouts and partials.
     *
     * @return array<int, string>
     */
    private function prototypeTemplates(): array
    {
        return glob(resource_path('views/{layouts,partials,prototype}/*.blade.php'), GLOB_BRACE);
    }

    private function template(string $name): string
    {
        $path = resource_path('views/'.str_replace('.', '/', $name).'.blade.php');

        $this->assertFileExists($path);

        return (string) file_get_contents($path);
    }

    public function test_login_form_has_no_action_and_no_method(): void
    {
        $html = $this->get('/login')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<form\b[^>]*data-prototype="non-functional"/', $html);
        $this->assertDoesNotMatchRegularExpression('/<form\b[^>]*\saction=/i', $html);
        $this->assertDoesNotMatchRegularExpression('/<form\b[^>]*\smethod=/i', $html);
    }

    public function test_registration_form_has_no_action_and_no_method(): void
    {
        $html = $this->get('/register')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<form\b[^>]*data-prototype="non-functional"/', $html);
        $this->assertDoesNotMatchRegularExpression('/<form\b[^>]*\saction=/i', $html);
        $this->assertDoesNotMatchRegularExpression('/<form\b[^>]*\smethod=/i', $html);
    }

    public function test_no_form_in_any_prototype_template_can_submit_data(): void
    {
        $templates = $this->prototypeTemplates();

        $this->assertNotEmpty($templates);

        foreach ($templates as $path) {
            $blade = (string) file_get_contents($path);
            $file = basename($path);

            $this->assertDoesNotMatchRegularExpression(
                '/<form\b[^>]*\s(action|method)=/i',
                $blade,
                "The template [{$file}] contains a form that can submit data."
            );

            $this->assertDoesNotMatchRegularExpression(
                '/<form\b[^>]*method="?get/i',
                $blade,
                "The template [{$file}] contains a GET form."
            );
        }
    }

    public function test_prototype_forms_have_no_enabled_submit_button(): void
    {
        foreach (['prototype.login', 'prototype.register'] as $view) {
            $html = $this->template($view);

            $this->assertMatchesRegularExpression('/<button[^>]*type="submit"/', $html);

            preg_match_all('/<button\b[^>]*type="submit"[^>]*>/i', $html, $matches);

            foreach ($matches[0] as $button) {
                $this->assertStringContainsString(
                    'disabled',
                    $button,
                    "The view [{$view}] contains an enabled submit button."
                );
            }
        }
    }

    public function test_credential_fields_are_disabled(): void
    {
        $html = $this->template('prototype.login').$this->template('prototype.register');

        foreach (['login-password', 'password', 'password-confirmation', 'mobile', 'full-name'] as $id) {
            $this->assertMatchesRegularExpression(
                '/<input\b[^>]*id="'.preg_quote($id, '/').'"[^>]*disabled/i',
                $html,
                "Credential/personal field [{$id}] is not disabled."
            );
        }

        $this->assertStringContainsString('autocomplete="off"', $html);
        $this->assertStringNotContainsString('autocomplete="current-password"', $html);
        $this->assertStringNotContainsString('autocomplete="new-password"', $html);
    }

    public function test_prototype_forms_remain_marked_as_non_functional(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('This form is not connected yet')
            ->assertSee('Sign-in is disabled in this prototype')
            ->assertSee('never sent to the server, by GET or by POST');

        $this->get('/register')
            ->assertOk()
            ->assertSee('Nothing will be submitted')
            ->assertSee('Registration is disabled in this prototype')
            ->assertSee('Nothing typed here is sent to the server, by GET or by POST');
    }

    public function test_no_write_routes_exist_for_credentials_or_personal_data(): void
    {
        $allowedFrameworkWriteRoutes = ['storage/{path}']; // Laravel's local-disk file server.
        $writeMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];
        $routesByMethod = Route::getRoutes()->getRoutesByMethod();

        foreach ($writeMethods as $method) {
            foreach ($routesByMethod[$method] ?? [] as $route) {
                if (in_array($route->uri(), $allowedFrameworkWriteRoutes, true)) {
                    continue;
                }

                $this->fail("Unexpected {$method} route registered in Milestone 1: {$route->uri()}");
            }
        }

        $this->assertTrue(true);
    }

    public function test_credentials_cannot_be_posted_to_the_prototype_pages(): void
    {
        $payload = [
            'email' => 'attacker@example.test',
            'password' => 'super-secret-value',
            'password_confirmation' => 'super-secret-value',
            'full_name' => 'Test Person',
            'mobile' => '01700000000',
        ];

        foreach (['/login', '/register', '/dashboard', '/admin'] as $uri) {
            $this->post($uri, $payload)->assertStatus(405);
        }
    }

    public function test_credentials_cannot_be_sent_to_the_prototype_pages_via_query_string(): void
    {
        foreach (['/login', '/register'] as $uri) {
            $this->get($uri.'?password=super-secret-value&email=a%40b.test')
                ->assertOk()
                ->assertDontSee('super-secret-value');
        }
    }
}
