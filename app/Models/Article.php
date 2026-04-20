<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'author_id',
        'status',
        'published_at',
        'views',
        'category',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    /**
     * Categorías predefinidas para el blog de barbería
     */
    public const CATEGORIES = [
        'cortes' => 'Cortes de Cabello',
        'tendencias' => 'Tendencias',
        'cuidado' => 'Cuidado del Cabello y Barba',
        'promociones' => 'Promociones y Novedades',
        'consejos' => 'Consejos de Estilo',
    ];

    /**
     * Boot del modelo para generar slug automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->title);
            }
            
            // Auto-generar meta_title si está vacío
            if (empty($article->meta_title)) {
                $article->meta_title = Str::limit($article->title, 60);
            }
        });

        static::updating(function ($article) {
            // Si el título cambió y no se proporcionó un nuevo slug, regenerar
            if ($article->isDirty('title') && !$article->isDirty('slug')) {
                $article->slug = static::generateUniqueSlug($article->title, $article->id);
            }
        });
    }

    /**
     * Generar slug único
     */
    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Relación con el autor (Usuario)
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'author_id', 'usuario_id');
    }

    /**
     * Relación con comentarios
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Comentarios aprobados
     */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('status', 'approved')->whereNull('parent_id');
    }

    /**
     * Scope: Solo artículos publicados
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope: Por categoría
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Búsqueda
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('content', 'like', "%{$term}%")
              ->orWhere('excerpt', 'like', "%{$term}%");
        });
    }

    /**
     * Incrementar vistas
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Obtener URL del artículo
     */
    public function getUrlAttribute(): string
    {
        return route('blog.show', $this->slug);
    }

    /**
     * Obtener nombre de categoría legible
     */
    public function getCategoryNameAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category ?? 'Sin categoría';
    }

    /**
     * Obtener imagen destacada o placeholder
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('img/blog-placeholder.jpg');
    }

    /**
     * Tiempo de lectura estimado
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, ceil($wordCount / 200)); // 200 palabras por minuto
    }

    /**
     * Verificar si está publicado
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at->lte(now());
    }

    /**
     * Artículos relacionados (misma categoría)
     */
    public function relatedArticles(int $limit = 3)
    {
        return static::published()
            ->where('id', '!=', $this->id)
            ->when($this->category, fn($q) => $q->where('category', $this->category))
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }
}
