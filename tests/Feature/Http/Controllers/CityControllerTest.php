<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CityController
 */
class CityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $cities = City::factory()->count(3)->create();

        $response = $this->get(route('city.index'));

        $response->assertOk();
        $response->assertViewIs('city.index');
        $response->assertViewHas('cities');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('city.create'));

        $response->assertOk();
        $response->assertViewIs('city.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CityController::class,
            'store',
            \App\Http\Requests\CityStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $state = State::factory()->create();
        $name = $this->faker->name;
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->post(route('city.store'), [
            'state_id' => $state->id,
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $cities = City::query()
            ->where('state_id', $state->id)
            ->where('name', $name)
            ->where('created_at', $created_at)
            ->where('updated_at', $updated_at)
            ->get();
        $this->assertCount(1, $cities);
        $city = $cities->first();

        $response->assertRedirect(route('city.index'));
        $response->assertSessionHas('city.id', $city->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $city = City::factory()->create();

        $response = $this->get(route('city.show', $city));

        $response->assertOk();
        $response->assertViewIs('city.show');
        $response->assertViewHas('city');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $city = City::factory()->create();

        $response = $this->get(route('city.edit', $city));

        $response->assertOk();
        $response->assertViewIs('city.edit');
        $response->assertViewHas('city');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CityController::class,
            'update',
            \App\Http\Requests\CityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $city = City::factory()->create();
        $state = State::factory()->create();
        $name = $this->faker->name;
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->put(route('city.update', $city), [
            'state_id' => $state->id,
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $city->refresh();

        $response->assertRedirect(route('city.index'));
        $response->assertSessionHas('city.id', $city->id);

        $this->assertEquals($state->id, $city->state_id);
        $this->assertEquals($name, $city->name);
        $this->assertEquals($created_at, $city->created_at);
        $this->assertEquals($updated_at, $city->updated_at);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $city = City::factory()->create();

        $response = $this->delete(route('city.destroy', $city));

        $response->assertRedirect(route('city.index'));

        $this->assertSoftDeleted($city);
    }
}
