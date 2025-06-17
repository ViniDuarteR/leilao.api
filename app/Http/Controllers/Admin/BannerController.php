<?php
/*
|--------------------------------------------------------------------------
| Informações do Arquivo
|--------------------------------------------------------------------------
|
| Projeto: Leiloeira Fernanda Freire
| Autor: Vinicius Duarte
| Email: viniciusduarterosa@icloud.com
| Data: Junho de 2025
|
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Mostra a lista de banners.
     */
    public function index()
    {
        $banners = \App\Models\Banner::orderBy('display_order')->get();
        return view('admin.banners.index', ['banners' => $banners]);
    }

    /**
     * Mostra o formulário para criar um novo banner.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Salva o novo banner no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image_path' => 'required|image|max:2048',
            'link_url' => 'nullable|url',
            'display_order' => 'required|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('banners', 'public');
            $data['image_path'] = $path;
        }

        Banner::create($data);

        // CORREÇÃO AQUI
        return redirect()->route('painel.banners.index')->with('success', 'Banner criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um banner existente.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', ['banner' => $banner]);
    }

    /**
     * Atualiza o banner no banco de dados.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image_path' => 'sometimes|image|max:2048',
            'link_url' => 'nullable|url',
            'display_order' => 'required|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image_path')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $path = $request->file('image_path')->store('banners', 'public');
            $data['image_path'] = $path;
        }

        $banner->update($data);

        // CORREÇÃO AQUI
        return redirect()->route('painel.banners.index')->with('success', 'Banner atualizado com sucesso!');
    }

    /**
     * Remove o banner do banco de dados.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();

        // CORREÇÃO AQUI
        return redirect()->route('painel.banners.index')->with('success', 'Banner apagado com sucesso!');
    }
}
