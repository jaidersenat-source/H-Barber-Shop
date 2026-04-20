<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class SedeController extends Controller
{
    // LISTAR SEDES
    public function index()
    {
        $sedes = Sede::all();
        return view('admin.sedes.index', compact('sedes'));
    }

    // FORM DE CREAR
    public function create()
    {
        return view('admin.sedes.create');
    }

    // GUARDAR NUEVA SEDE
    public function store(Request $request)
{
    $request->validate([
        'sede_nombre' => 'required|string|max:255',
        'sede_direccion' => 'required|string|max:255',
        'sede_lat' => 'nullable|numeric|between:-90,90',
        'sede_lng' => 'nullable|numeric|between:-180,180',
        // Teléfono obligatorio, solo dígitos entre 7 y 10 caracteres
        'sede_telefono' => 'required|digits_between:7,10',
        'sede_slogan' => 'nullable|string|max:255',
        'sede_descripcion' => 'nullable|string',
        'sede_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB máximo
    ], [
        'sede_nombre.required' => 'El nombre de la sede es obligatorio.',
        'sede_direccion.required' => 'La dirección es obligatoria.',
        'sede_telefono.required' => 'El teléfono es obligatorio.',
        'sede_telefono.digits_between' => 'El teléfono debe contener entre 7 y 10 dígitos.',
    ]);

    // Intentar normalizar la dirección mediante geocodificación (si se encuentra, usarla)
    $geo = $this->geocodeAddress($request->sede_direccion);

    $data = $request->only(['sede_nombre', 'sede_direccion', 'sede_telefono', 'sede_slogan', 'sede_descripcion', 'sede_lat', 'sede_lng']);
    if ($geo && is_array($geo)) {
        if (!empty($geo['display_name'])) $data['sede_direccion'] = $geo['display_name'];
        // Solo usar coords geocodificadas si el usuario NO las ingresó manualmente
        if (empty($data['sede_lat']) && !empty($geo['lat'])) $data['sede_lat'] = $geo['lat'];
        if (empty($data['sede_lng']) && !empty($geo['lon'])) $data['sede_lng'] = $geo['lon'];
    }

    // Procesar la imagen
    if ($request->hasFile('sede_logo')) {
        $imagen = $request->file('sede_logo');
        $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
        $ruta = $imagen->storeAs('logos', $nombreArchivo, 'public');
        $data['sede_logo'] = $ruta;
    }

    Sede::create($data);

    return redirect()->route('sedes.index')
        ->with('success', 'Sede creada correctamente.');
}

    // FORM PARA EDITAR
    public function edit($id)
    {
        $sede = Sede::findOrFail($id);
        return view('admin.sedes.edit', compact('sede'));
    }

    // ACTUALIZAR SEDE
   public function update(Request $request, $sede_id)
{
    $sede = Sede::findOrFail($sede_id);
    
        $request->validate([
        'sede_nombre' => 'required|string|max:255',
        'sede_direccion' => 'required|string|max:255',
        'sede_telefono' => 'required|digits_between:7,10',
        'sede_slogan' => 'nullable|string|max:255',
        'sede_lat' => 'nullable|numeric|between:-90,90',
        'sede_lng' => 'nullable|numeric|between:-180,180',
        'sede_descripcion' => 'nullable|string',
        'sede_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ], [
        'sede_nombre.required' => 'El nombre de la sede es obligatorio.',
        'sede_direccion.required' => 'La dirección es obligatoria.',
        'sede_telefono.required' => 'El teléfono es obligatorio.',
        'sede_telefono.digits_between' => 'El teléfono debe contener entre 7 y 10 dígitos.',
    ]);

    // Intentar normalizar la dirección mediante geocodificación (si se encuentra, usarla)
    $geo = $this->geocodeAddress($request->sede_direccion);

    $data = $request->only(['sede_nombre', 'sede_direccion', 'sede_telefono', 'sede_slogan', 'sede_descripcion', 'sede_lat', 'sede_lng']);
    if ($geo && is_array($geo)) {
        if (!empty($geo['display_name'])) $data['sede_direccion'] = $geo['display_name'];
        // Solo usar coords geocodificadas si el usuario NO las ingresó manualmente
        if (empty($data['sede_lat']) && !empty($geo['lat'])) $data['sede_lat'] = $geo['lat'];
        if (empty($data['sede_lng']) && !empty($geo['lon'])) $data['sede_lng'] = $geo['lon'];
    }

    // Procesar la nueva imagen si se subió
    if ($request->hasFile('sede_logo')) {
        // Eliminar el logo anterior si existe
        if ($sede->sede_logo && Storage::disk('public')->exists($sede->sede_logo)) {
            Storage::disk('public')->delete($sede->sede_logo);
        }
        
        // Guardar el nuevo logo
        $imagen = $request->file('sede_logo');
        $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
        $ruta = $imagen->storeAs('logos', $nombreArchivo, 'public');
        $data['sede_logo'] = $ruta;
    }

    $sede->update($data);

    return redirect()->route('sedes.index')
        ->with('success', 'Sede actualizada correctamente.');
}

    // ELIMINAR SEDE
    public function destroy($id)
    {
        try {
            $sede = Sede::findOrFail($id);
            // Eliminar el logo si existe
            if ($sede->sede_logo && Storage::disk('public')->exists($sede->sede_logo)) {
                Storage::disk('public')->delete($sede->sede_logo);
            }
            $sede->delete();
            return redirect()->route('sedes.index')->with('ok', 'Sede eliminada');
        } catch (\Exception $e) {
            return redirect()->route('sedes.index')->with('error', 'No se pudo eliminar la sede. Intente nuevamente o contacte soporte.');
        }
    }

    /**
     * Verifica si una dirección pertenece a Colombia usando Nominatim (OpenStreetMap)
     * Devuelve true si se encuentra al menos un resultado con country_code = 'co'.
     */
    private function verifyAddressInColombia(string $address): bool
    {
        if (trim($address) === '') return false;

        try {
            $resp = Http::withHeaders([
                'User-Agent' => 'HBarberShop/1.0 (+https://yourdomain.example)'
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $address,
                'format' => 'json',
                'addressdetails' => 1,
                'countrycodes' => 'co',
                'limit' => 1,
            ]);

            if ($resp->successful()) {
                $json = $resp->json();
                if (is_array($json) && count($json) > 0) {
                    // Nominatim con countrycodes=co ya filtra por Colombia, pero comprobamos address.country_code
                    $first = $json[0];
                    if (isset($first['address']) && isset($first['address']['country_code'])) {
                        return strtolower($first['address']['country_code']) === 'co';
                    }
                    // Si no hay address details, aceptar si tenemos al menos un resultado
                    return true;
                }
            }
        } catch (\Exception $e) {
            // Si falla la consulta por red, no bloquear la operación, pero retornar false para forzar corrección.
            // Log opcional: \Log::error('Nominatim error: '.$e->getMessage());
            return false;
        }

        return false;
    }

    /**
     * Geocodifica una dirección usando Nominatim y devuelve un arreglo con display_name, lat y lon si se encuentra.
     * Retorna null si no hay resultados o falla la consulta.
     */
    private function geocodeAddress(string $address): ?array
    {
        if (trim($address) === '') return null;

        try {
            $resp = Http::withHeaders([
                'User-Agent' => 'HBarberShop/1.0 (+https://yourdomain.example)'
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $address,
                'format' => 'json',
                'addressdetails' => 1,
                'limit' => 1,
            ]);

            if ($resp->successful()) {
                $json = $resp->json();
                if (is_array($json) && count($json) > 0) {
                    $first = $json[0];
                    return [
                        'display_name' => $first['display_name'] ?? null,
                        'lat' => isset($first['lat']) ? (float)$first['lat'] : null,
                        'lon' => isset($first['lon']) ? (float)$first['lon'] : null,
                        'address' => $first['address'] ?? null,
                    ];
                }
            }
        } catch (\Exception $e) {
            // no bloquear, simplemente devolver null
            return null;
        }

        return null;
    }
}
