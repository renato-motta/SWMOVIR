<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions'=>'nullable|array',
        ]);

        $role = Role::create(['name' => $data['name']]);

        if(isset($data['permissions'])){
            // $role->syncPermissions($data['permissions']);
            //manera tradicional asignar los permisos 
            $role->permissions()->sync($data['permissions']);
        }

        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡¡Bien hecho!!',
            'text' =>  'El Rol ha sido creado exitosamente'
        ]);

        return redirect()->route('admin.roles.edit', $role);    
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$role->id,
            'permissions'=>'nullable|array',
        ]);

        $role ->update(['name' => $data['name']]);

        if(isset($data['permissions'])){
            $role->permissions()->sync($data['permissions']);
        }else{
            $role->permissions()->detach();
        }

        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡¡Bien hecho!!',
            'text' =>  'El Rol ha sido actualizado exitosamente'
        ]);

        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // if($role->name="Admin"){
        //     session()->flash('swal',[
        //     'icon' => 'error',
        //     'title' => '¡¡Error!!',
        //     'text' =>  'no se puede eliminar el rol admin'
        //     ]);
        //     return redirect()->route('admin.roles.index');    
        // }
        $role->delete();
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡¡Bien hecho!!',
            'text' =>  'El Rol se ha eliminado exitosamente'
        ]);
        return redirect()->route('admin.roles.index');
    }
}
