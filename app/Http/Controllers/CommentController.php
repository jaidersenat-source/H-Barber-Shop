<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Almacenar nuevo comentario
     */
    public function store(Request $request, Article $article)
    {
        try {
            Log::info('Comment submission attempt', [
                'article_id' => $article->id,
                'user_id' => Auth::guard('usuario')->id(),
                'request_data' => $request->all()
            ]);

            // Validación diferente si el usuario está logueado o no
            $rules = [
                'content' => 'required|string|min:10|max:1000',
                'parent_id' => 'nullable|exists:comments,id',
            ];

            // Si no está logueado, requerir nombre y email
            if (!Auth::guard('usuario')->check()) {
                $rules['guest_name'] = 'required|string|max:100';
                $rules['guest_email'] = 'required|email|max:150';
            }

        $validated = $request->validate($rules, [
            'content.required' => 'El comentario es obligatorio.',
            'content.min' => 'El comentario debe tener al menos 10 caracteres.',
            'content.max' => 'El comentario no puede superar los 1000 caracteres.',
            'guest_name.required' => 'Tu nombre es obligatorio.',
            'guest_email.required' => 'Tu correo electrónico es obligatorio.',
            'guest_email.email' => 'Ingresa un correo electrónico válido.',
        ]);

        // Verificar que el artículo esté publicado
        if (!$article->isPublished()) {
            return back()->with('error', 'No puedes comentar en este artículo.');
        }

        // Si hay parent_id, verificar que pertenezca al mismo artículo
        if ($request->filled('parent_id')) {
            $parentComment = Comment::find($request->parent_id);
            if (!$parentComment || $parentComment->article_id !== $article->id) {
                return back()->with('error', 'Comentario padre inválido.');
            }
        }

        // Crear comentario
        $comment = new Comment();
        $comment->article_id = $article->id;
        $comment->content = strip_tags($validated['content']); // Sanitizar HTML
        $comment->parent_id = $validated['parent_id'] ?? null;

        if (Auth::guard('usuario')->check()) {
            $comment->user_id = Auth::guard('usuario')->id();
            // Los comentarios de usuarios registrados se aprueban automáticamente
            $comment->status = 'approved';
        } else {
            $comment->guest_name = $validated['guest_name'];
            $comment->guest_email = $validated['guest_email'];
            // Los comentarios de visitantes quedan pendientes de moderación
            $comment->status = 'pending';
        }

        $comment->save();

        Log::info('Comment saved successfully', [
            'comment_id' => $comment->id,
            'article_id' => $article->id,
            'status' => $comment->status
        ]);

        if ($comment->status === 'pending') {
            return back()->with('success', '¡Gracias por tu comentario! Será publicado después de ser revisado.');
        }

        return back()->with('success', '¡Tu comentario ha sido publicado!');
        
        } catch (\Exception $e) {
            Log::error('Error saving comment', [
                'article_id' => $article->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Hubo un error al enviar tu comentario. Por favor, inténtalo de nuevo.');
        }
    }
}
