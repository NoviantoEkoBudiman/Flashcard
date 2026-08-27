<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthenticationAndLanguageOwnershipTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect(route('login'));
    }

    public function test_user_can_register_login_and_logout(): void
    {
        $email = 'new-user-'.uniqid().'@example.com';

        $this->post(route('register.store'), [
            'name' => 'New User',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('language.index'));

        $this->assertAuthenticated();
        $this->get(route('language.index'))
            ->assertOk()
            ->assertSee('Welcome, New User');

        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();

        $this->post(route('login.attempt'), [
            'email' => $email,
            'password' => 'password123',
        ])->assertRedirect(route('language.index'));

        $this->assertAuthenticated();
    }

    public function test_language_name_is_unique_only_for_its_owner(): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        $firstUser->languages()->create(['languages_name' => 'Jepang']);

        $this->actingAs($firstUser)
            ->post(route('language.store'), ['languages_name' => 'Jepang'])
            ->assertSessionHasErrors('languages_name');

        $this->actingAs($firstUser)
            ->post(route('language.store'), ['languages_name' => 'Bahasa Jepang'])
            ->assertRedirect(route('language_index'));

        $this->actingAs($secondUser)
            ->post(route('language.store'), ['languages_name' => 'Jepang'])
            ->assertRedirect(route('language_index'));

        $this->assertSame(2, Language::where('languages_name', 'Jepang')->count());
        $this->assertDatabaseHas('languages', [
            'user_id' => $firstUser->id,
            'languages_name' => 'Bahasa Jepang',
        ]);
    }

    public function test_user_cannot_open_another_users_language(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $language = $owner->languages()->create([
            'languages_name' => 'Private Language '.uniqid(),
        ]);

        $this->actingAs($otherUser)
            ->get(route('category.show', $language->languages_id))
            ->assertNotFound();
    }

    public function test_user_can_add_a_category_to_their_language(): void
    {
        $user = User::factory()->create();
        $language = $user->languages()->create([
            'languages_name' => 'Japanese '.uniqid(),
        ]);

        $this->actingAs($user)
            ->post(route('category.store'), [
                'categories_languages_id' => $language->languages_id,
                'categories_name' => 'Chapter 1',
                'categories_type' => 1,
            ])
            ->assertRedirect(route('category.show', $language->languages_id));

        $this->assertDatabaseHas('categories', [
            'categories_languages_id' => $language->languages_id,
            'categories_name' => 'Chapter 1',
            'categories_type' => 1,
        ]);
    }
}
