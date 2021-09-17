<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = Department::all();

        return view('department.index', compact('departments'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('department.create');
    }

    /**
     * @param \App\Http\Requests\DepartmentStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStoreRequest $request)
    {
        $department = Department::create($request->validated());

        $request->session()->flash('department.id', $department->id);

        return redirect()->route('department.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Department $department)
    {
        return view('department.show', compact('department'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Department $department)
    {
        return view('department.edit', compact('department'));
    }

    /**
     * @param \App\Http\Requests\DepartmentUpdateRequest $request
     * @param \App\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        $department->update($request->validated());

        $request->session()->flash('department.id', $department->id);

        return redirect()->route('department.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Department $department)
    {
        $department->delete();

        return redirect()->route('department.index');
    }
}
