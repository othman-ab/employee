<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryStoreRequest;
use App\Http\Requests\CountryUpdateRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::all();

        return view('country.index', compact('countries'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('country.create');
    }

    /**
     * @param \App\Http\Requests\CountryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryStoreRequest $request)
    {
        $country = Country::create($request->validated());

        $request->session()->flash('country.id', $country->id);

        return redirect()->route('country.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Country $country)
    {
        return view('country.show', compact('country'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Country $country)
    {
        return view('country.edit', compact('country'));
    }

    /**
     * @param \App\Http\Requests\CountryUpdateRequest $request
     * @param \App\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function update(CountryUpdateRequest $request, Country $country)
    {
        $country->update($request->validated());

        $request->session()->flash('country.id', $country->id);

        return redirect()->route('country.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country)
    {
        $country->delete();

        return redirect()->route('country.index');
    }
}
