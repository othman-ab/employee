<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\usersController
 */
class usersControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $users = users::factory()->count(3)->create();

        $response = $this->get(route('user.index'));

        $response->assertOk();
        $response->assertViewIs('user.index');
        $response->assertViewHas('users');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('user.create'));

        $response->assertOk();
        $response->assertViewIs('user.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\usersController::class,
            'store',
            \App\Http\Requests\usersStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $adress = $this->faker->word;
        $zip_code = $this->faker->word;
        $userable_id = $this->faker->word;
        $userable_type = $this->faker->word;
        $date_hired = $this->faker->dateTime();
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->post(route('user.store'), [
            'name' => $name,
            'adress' => $adress,
            'zip_code' => $zip_code,
            'userable_id' => $userable_id,
            'userable_type' => $userable_type,
            'date_hired' => $date_hired,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $users = User::query()
            ->where('name', $name)
            ->where('adress', $adress)
            ->where('zip_code', $zip_code)
            ->where('userable_id', $userable_id)
            ->where('userable_type', $userable_type)
            ->where('date_hired', $date_hired)
            ->where('created_at', $created_at)
            ->where('updated_at', $updated_at)
            ->get();
        $this->assertCount(1, $users);
        $user = $users->first();

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('user.id', $user->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $user = users::factory()->create();

        $response = $this->get(route('user.show', $user));

        $response->assertOk();
        $response->assertViewIs('user.show');
        $response->assertViewHas('user');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $user = users::factory()->create();

        $response = $this->get(route('user.edit', $user));

        $response->assertOk();
        $response->assertViewIs('user.edit');
        $response->assertViewHas('user');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\usersController::class,
            'update',
            \App\Http\Requests\usersUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $user = users::factory()->create();
        $name = $this->faker->name;
        $adress = $this->faker->word;
        $zip_code = $this->faker->word;
        $userable_id = $this->faker->word;
        $userable_type = $this->faker->word;
        $date_hired = $this->faker->dateTime();
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->put(route('user.update', $user), [
            'name' => $name,
            'adress' => $adress,
            'zip_code' => $zip_code,
            'userable_id' => $userable_id,
            'userable_type' => $userable_type,
            'date_hired' => $date_hired,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $user->refresh();

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('user.id', $user->id);

        $this->assertEquals($name, $user->name);
        $this->assertEquals($adress, $user->adress);
        $this->assertEquals($zip_code, $user->zip_code);
        $this->assertEquals($userable_id, $user->userable_id);
        $this->assertEquals($userable_type, $user->userable_type);
        $this->assertEquals($date_hired, $user->date_hired);
        $this->assertEquals($created_at, $user->created_at);
        $this->assertEquals($updated_at, $user->updated_at);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $user = users::factory()->create();
        $user = User::factory()->create();

        $response = $this->delete(route('user.destroy', $user));

        $response->assertRedirect(route('user.index'));

        $this->assertSoftDeleted($user);
    }
}
