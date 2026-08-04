<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NotaController extends Controller
{
    // 1. Lista as notas com Busca e Paginação
    public function index(Request $request)
    {
        $busca = $request->get('busca');

        $notas = Nota::where('user_id', Auth::id())
            ->when($busca, function ($query, $busca) {
                return $query->where('titulo', 'like', "%{$busca}%");
            })
            ->latest()
            ->paginate(5);

        return view('notas.index', compact('notas', 'busca'));
    }

    public function create()
    {
        return view('notas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'conteudo' => 'required'
        ]);

        Nota::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->route('notas.index')->with('success', 'Nota criada com sucesso!');
    }

    public function show(Nota $nota)
    {
        Gate::authorize('view', $nota); // Usando a Policy para verificação
        return view('notas.show', compact('nota'));
    }

    public function edit(Nota $nota)
    {
        Gate::authorize('update', $nota);
        return view('notas.edit', compact('nota'));
    }

    public function update(Request $request, Nota $nota)
    {
        Gate::authorize('update', $nota);

        $request->validate([
            'titulo' => 'required|max:255',
            'conteudo' => 'required'
        ]);
        
        $nota->update($request->only(['titulo', 'conteudo']));

        return redirect()->route('notas.index')->with('success', 'Nota atualizada com sucesso!');
    }

    public function destroy(Nota $nota)
    {
        Gate::authorize('delete', $nota);
        $nota->delete();
        return redirect()->route('notas.index')->with('success', 'Nota enviada para a lixeira!');
    }

    // ==========================================
    // MÉTODOS DA LIXEIRA (Soft Deletes)
    // ==========================================
    
    public function lixeira()
    {
        $notas = Nota::onlyTrashed()->where('user_id', Auth::id())->latest()->paginate(5);
        return view('notas.lixeira', compact('notas'));
    }

    public function restaurar($id)
    {
        $nota = Nota::onlyTrashed()->findOrFail($id);
        Gate::authorize('restore', $nota);
        
        $nota->restore();
        return redirect()->route('notas.lixeira')->with('success', 'Nota restaurada com sucesso!');
    }

    public function forcarExclusao($id)
    {
        $nota = Nota::onlyTrashed()->findOrFail($id);
        Gate::authorize('forceDelete', $nota);
        
        $nota->forceDelete();
        return redirect()->route('notas.lixeira')->with('success', 'Nota excluída permanentemente!');
    }
}