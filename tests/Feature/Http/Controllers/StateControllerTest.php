<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\StateController
 */
class StateControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $states = State::factory()->count(3)->create();

        $response = $this->get(route('state.index'));

        $response->assertOk();
        $response->assertViewIs('state.index');
        $response->assertViewHas('states');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('state.create'));

        $response->assertOk();
        $response->assertViewIs('state.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StateController::class,
            'store',
            \App\Http\Requests\StateStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $country = Country::factory()->create();
        $name = $this->faker->name;
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->post(route('state.store'), [
            'country_id' => $country->id,
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $states = State::query()
            ->where('country_id', $country->id)
            ->where('name', $name)
            ->where('created_at', $created_at)
            ->where('updated_at', $updated_at)
            ->get();
        $this->assertCount(1, $states);
        $state = $states->first();

        $response->assertRedirect(route('state.index'));
        $response->assertSessionHas('state.id', $state->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $state = State::factory()->create();

        $response = $this->get(route('state.show', $state));

        $response->assertOk();
        $response->assertViewIs('state.show');
        $response->assertViewHas('state');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $state = State::factory()->create();

        $response = $this->get(route('state.edit', $state));

        $response->assertOk();
        $response->assertViewIs('state.edit');
        $response->assertViewHas('state');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StateController::class,
            'update',
            \App\Http\Requests\StateUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $state = State::factory()->create();
        $country = Country::factory()->create();
        $name = $this->faker->name;
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->put(route('state.update', $state), [
            'country_id' => $country->id,
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $state->refresh();

        $response->assertRedirect(route('state.index'));
        $response->assertSessionHas('state.id', $state->id);

        $this->assertEquals($country->id, $state->country_id);
        $this->assertEquals($name, $state->name);
        $this->assertEquals($created_at, $state->created_at);
        $this->assertEquals($updated_at, $state->updated_at);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $state = State::factory()->create();

        $response = $this->delete(route('state.destroy', $state));

        $response->assertRedirect(route('state.index'));

        $this->assertSoftDeleted($state);
    }
}
