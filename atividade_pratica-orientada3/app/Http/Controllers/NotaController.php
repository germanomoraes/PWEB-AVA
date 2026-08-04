<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaController extends Controller
{
    // 1. Listar apenas as notas do usuário logado
    public function index()
    {
        $notas = Nota::where('user_id', Auth::id())->latest()->get();
        return view('notas.index', compact('notas'));
    }

    // 2. Mostrar o formulário de criação
    public function create()
    {
        return view('notas.create');
    }

    // 3. Salvar a nova nota no banco (já vinculada ao usuário)
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'conteudo' => 'required',
        ]);

        Nota::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->route('notas.index')->with('success', 'Nota criada com sucesso!');
    }

    // 4. Mostrar o formulário de edição (com verificação de segurança)
    public function edit(Nota $nota)
    {
        // Se a nota não pertencer ao usuário logado, bloqueia o acesso
        if ($nota->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('notas.edit', compact('nota'));
    }

    // 5. Atualizar a nota
    public function update(Request $request, Nota $nota)
    {
        if ($nota->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate([
            'titulo' => 'required|max:255',
            'conteudo' => 'required',
        ]);

        $nota->update([
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->route('notas.index')->with('success', 'Nota atualizada com sucesso!');
    }

    // 6. Excluir a nota (Soft Delete)
    public function destroy(Nota $nota)
    {
        if ($nota->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $nota->delete();

        return redirect()->route('notas.index')->with('success', 'Nota excluída com sucesso!');
    }
}