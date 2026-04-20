<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
        'guest_name',
        'guest_email',
        'content',
        'status',
        'parent_id',
    ];

    /**
     * Relación con el artículo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Relación con el usuario (si está logueado)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_id', 'usuario_id');
    }

    /**
     * Comentario padre (para respuestas)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Respuestas a este comentario
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('status', 'approved');
    }

    /**
     * Todas las respuestas (para admin)
     */
    public function allReplies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Scope: Comentarios aprobados
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Comentarios pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Solo comentarios principales (no respuestas)
     */
    public function scopeParentComments($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Obtener nombre del autor del comentario
     */
    public function getAuthorNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->persona->per_nombres ?? $this->user->usuario;
        }
        return $this->guest_name ?? 'Anónimo';
    }

    /**
     * Verificar si el comentario es de un usuario registrado
     */
    public function isFromRegisteredUser(): bool
    {
        return !is_null($this->user_id);
    }

    /**
     * Aprobar comentario
     */
    public function approve(): bool
    {
        return $this->update(['status' => 'approved']);
    }

    /**
     * Rechazar comentario
     */
    public function reject(): bool
    {
        return $this->update(['status' => 'rejected']);
    }
}
