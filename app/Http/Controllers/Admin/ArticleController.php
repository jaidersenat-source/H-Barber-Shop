<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Listado de artículos en el panel de admin
     */
    public function index(Request $request)
    {
        $query = Article::with(['author.persona'])->latest();

        // Filtrar por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrar por categoría
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Búsqueda
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $articles = $query->paginate(15);
        $categories = Article::CATEGORIES;

        return view('admin.blog.index', compact('articles', 'categories'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $categories = Article::CATEGORIES;
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Almacenar nuevo artículo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'featured_image_alt' => 'nullable|string|max:200',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'category' => 'nullable|string|in:' . implode(',', array_keys(Article::CATEGORIES)),
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ], [
            'title.required' => 'El título es obligatorio.',
            'content.required' => 'El contenido es obligatorio.',
            'featured_image.image' => 'El archivo debe ser una imagen.',
            'featured_image.max' => 'La imagen no puede superar los 2MB.',
        ]);

        // Procesar imagen
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blog', 'public');
        }

        // Asignar autor
        $validated['author_id'] = Auth::guard('usuario')->id();

        // Si se publica y no hay fecha, usar ahora
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article = Article::create($validated);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Artículo creado exitosamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(Article $article)
    {
        $categories = Article::CATEGORIES;
        return view('admin.blog.edit', compact('article', 'categories'));
    }

    /**
     * Actualizar artículo
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:220|unique:articles,slug,' . $article->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'featured_image_alt' => 'nullable|string|max:200',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'category' => 'nullable|string|in:' . implode(',', array_keys(Article::CATEGORIES)),
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        // Procesar nueva imagen
        if ($request->hasFile('featured_image')) {
            // Eliminar imagen anterior
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blog', 'public');
        }

        // Si se publica por primera vez y no hay fecha
        if ($validated['status'] === 'published' && 
            $article->status !== 'published' && 
            empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Generar slug si se proporcionó uno personalizado
        if (!empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        } else {
            unset($validated['slug']); // Dejar que el modelo lo maneje
        }

        $article->update($validated);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Artículo actualizado exitosamente.');
    }

    /**
     * Eliminar artículo
     */
    public function destroy(Article $article)
    {
        // Eliminar imagen
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Artículo eliminado exitosamente.');
    }

    /**
     * Cambiar estado rápido (AJAX)
     */
    public function toggleStatus(Request $request, Article $article)
    {
        $newStatus = $request->input('status', 'draft');
        
        if (!in_array($newStatus, ['draft', 'published', 'archived'])) {
            return response()->json(['error' => 'Estado inválido'], 422);
        }

        $article->status = $newStatus;
        
        if ($newStatus === 'published' && !$article->published_at) {
            $article->published_at = now();
        }

        $article->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado',
            'status' => $article->status,
        ]);
    }

    /**
     * Previsualizar artículo (incluso si es borrador)
     */
    public function preview(Article $article)
    {
        $relatedArticles = $article->relatedArticles(3);
        
        $seo = [
            'title' => $article->meta_title ?: $article->title . ' | H Barber Shop Blog',
            'description' => $article->meta_description ?: $article->excerpt,
            'canonical' => route('blog.show', $article->slug),
        ];

        return view('blog.show', compact('article', 'relatedArticles', 'seo'))
            ->with('isPreview', true);
    }
}
