<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CountryController
 */
class CountryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $countries = Country::factory()->count(3)->create();

        $response = $this->get(route('country.index'));

        $response->assertOk();
        $response->assertViewIs('country.index');
        $response->assertViewHas('countries');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('country.create'));

        $response->assertOk();
        $response->assertViewIs('country.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CountryController::class,
            'store',
            \App\Http\Requests\CountryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $country_code = $this->faker->word;
        $name = $this->faker->name;
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->post(route('country.store'), [
            'country_code' => $country_code,
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $countries = Country::query()
            ->where('country_code', $country_code)
            ->where('name', $name)
            ->where('created_at', $created_at)
            ->where('updated_at', $updated_at)
            ->get();
        $this->assertCount(1, $countries);
        $country = $countries->first();

        $response->assertRedirect(route('country.index'));
        $response->assertSessionHas('country.id', $country->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $country = Country::factory()->create();

        $response = $this->get(route('country.show', $country));

        $response->assertOk();
        $response->assertViewIs('country.show');
        $response->assertViewHas('country');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $country = Country::factory()->create();

        $response = $this->get(route('country.edit', $country));

        $response->assertOk();
        $response->assertViewIs('country.edit');
        $response->assertViewHas('country');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CountryController::class,
            'update',
            \App\Http\Requests\CountryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $country = Country::factory()->create();
        $country_code = $this->faker->word;
        $name = $this->faker->name;
        $created_at = $this->faker->dateTime();
        $updated_at = $this->faker->dateTime();

        $response = $this->put(route('country.update', $country), [
            'country_code' => $country_code,
            'name' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $country->refresh();

        $response->assertRedirect(route('country.index'));
        $response->assertSessionHas('country.id', $country->id);

        $this->assertEquals($country_code, $country->country_code);
        $this->assertEquals($name, $country->name);
        $this->assertEquals($created_at, $country->created_at);
        $this->assertEquals($updated_at, $country->updated_at);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $country = Country::factory()->create();

        $response = $this->delete(route('country.destroy', $country));

        $response->assertRedirect(route('country.index'));

        $this->assertSoftDeleted($country);
    }
}
