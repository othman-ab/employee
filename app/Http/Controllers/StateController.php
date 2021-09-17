<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateStoreRequest;
use App\Http\Requests\StateUpdateRequest;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $states = State::all();

        return view('state.index', compact('states'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('state.create');
    }

    /**
     * @param \App\Http\Requests\StateStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateStoreRequest $request)
    {
        $state = State::create($request->validated());

        $request->session()->flash('state.id', $state->id);

        return redirect()->route('state.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, State $state)
    {
        return view('state.show', compact('state'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, State $state)
    {
        return view('state.edit', compact('state'));
    }

    /**
     * @param \App\Http\Requests\StateUpdateRequest $request
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function update(StateUpdateRequest $request, State $state)
    {
        $state->update($request->validated());

        $request->session()->flash('state.id', $state->id);

        return redirect()->route('state.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, State $state)
    {
        $state->delete();

        return redirect()->route('state.index');
    }
}
