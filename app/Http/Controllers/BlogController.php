<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Mostrar listado de artículos públicos (SEO optimizado)
     */
    public function index(Request $request)
    {
        $query = Article::published()
            ->with(['author.persona'])
            ->latest('published_at');

        // Filtrar por categoría
        if ($request->filled('categoria')) {
            $query->byCategory($request->categoria);
        }

        // Búsqueda
        if ($request->filled('buscar')) {
            $query->search($request->buscar);
        }

        $articles = $query->paginate(9);
        $categories = Article::CATEGORIES;

        // SEO meta tags
        $seo = [
            'title' => 'Blog de Barbería - Consejos, Tendencias y Cortes | H Barber Shop',
            'description' => 'Descubre los mejores consejos de barbería, tendencias en cortes de cabello para hombres, cuidado de barba y las últimas novedades de H Barber Shop.',
            'keywords' => 'barbería, cortes de cabello hombre, tendencias, cuidado barba, consejos barbería',
            'canonical' => route('blog.index'),
        ];

        return view('blog.index', compact('articles', 'categories', 'seo'));
    }

    /**
     * Mostrar artículo individual (URL amigable con slug)
     */
    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)
            ->published()
            ->with(['author.persona', 'approvedComments.replies', 'approvedComments.user.persona'])
            ->firstOrFail();

        // Incrementar vistas (evitar contar múltiples veces en la misma sesión)
        $viewedArticles = session()->get('viewed_articles', []);
        if (!in_array($article->id, $viewedArticles)) {
            $article->incrementViews();
            session()->push('viewed_articles', $article->id);
        }

        // Artículos relacionados
        $relatedArticles = $article->relatedArticles(3);

        // SEO meta tags dinámicos
        $seo = [
            'title' => $article->meta_title ?: $article->title . ' | H Barber Shop Blog',
            'description' => $article->meta_description ?: $article->excerpt ?: Str::limit(strip_tags($article->content), 155),
            'keywords' => $article->meta_keywords,
            'canonical' => $article->url,
            'image' => $article->featured_image_url,
            'published_time' => $article->published_at?->toIso8601String(),
            'modified_time' => $article->updated_at?->toIso8601String(),
            'author' => $article->author?->persona?->per_nombres ?? 'H Barber Shop',
        ];

        return view('blog.show', compact('article', 'relatedArticles', 'seo'));
    }

    /**
     * Mostrar artículos por categoría
     */
    public function category(string $category)
    {
        if (!array_key_exists($category, Article::CATEGORIES)) {
            abort(404);
        }

        $articles = Article::published()
            ->byCategory($category)
            ->with(['author.persona'])
            ->latest('published_at')
            ->paginate(9);

        $categoryName = Article::CATEGORIES[$category];
        $categories = Article::CATEGORIES;

        // SEO
        $seo = [
            'title' => "{$categoryName} - Blog de Barbería | H Barber Shop",
            'description' => "Artículos sobre {$categoryName} en nuestra barbería. Consejos, tendencias y novedades para hombres.",
            'canonical' => route('blog.category', $category),
        ];

        return view('blog.index', compact('articles', 'categories', 'categoryName', 'seo'));
    }
}
