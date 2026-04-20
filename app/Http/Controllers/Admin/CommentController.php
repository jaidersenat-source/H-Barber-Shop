<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    /**
     * Listado de comentarios para moderación
     */
    public function index(Request $request)
    {
        $query = Comment::with(['article', 'user.persona', 'parent'])
            ->latest();

        // Filtrar por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Por defecto mostrar pendientes primero
            $query->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')");
        }

        // Filtrar por artículo
        if ($request->filled('article_id')) {
            $query->where('article_id', $request->article_id);
        }

        $comments = $query->paginate(20);
        $articles = Article::select('id', 'title')->orderBy('title')->get();
        
        // Contar pendientes
        $pendingCount = Comment::pending()->count();

        return view('admin.comments.index', compact('comments', 'articles', 'pendingCount'));
    }

    /**
     * Aprobar comentario
     */
    public function approve(Comment $comment)
    {
        $comment->approve();
        Cache::forget('comments.pending_count');

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comentario aprobado',
            ]);
        }

        return back()->with('success', 'Comentario aprobado exitosamente.');
    }

    /**
     * Rechazar comentario
     */
    public function reject(Comment $comment)
    {
        $comment->reject();
        Cache::forget('comments.pending_count');

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comentario rechazado',
            ]);
        }

        return back()->with('success', 'Comentario rechazado.');
    }

    /**
     * Eliminar comentario
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        Cache::forget('comments.pending_count');

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comentario eliminado',
            ]);
        }

        return back()->with('success', 'Comentario eliminado.');
    }

    /**
     * Aprobar múltiples comentarios
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:comments,id',
        ]);

        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return back()->with('error', 'No se seleccionaron comentarios.');
        }

        Comment::whereIn('id', $ids)->update(['status' => 'approved']);
        Cache::forget('comments.pending_count');

        return back()->with('success', count($ids) . ' comentarios aprobados.');
    }

    /**
     * Rechazar múltiples comentarios
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:comments,id',
        ]);

        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return back()->with('error', 'No se seleccionaron comentarios.');
        }

        Comment::whereIn('id', $ids)->update(['status' => 'rejected']);
        Cache::forget('comments.pending_count');

        return back()->with('success', count($ids) . ' comentarios rechazados.');
    }

    /**
     * Eliminar múltiples comentarios
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:comments,id',
        ]);

        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return back()->with('error', 'No se seleccionaron comentarios.');
        }

        Comment::whereIn('id', $ids)->delete();
        Cache::forget('comments.pending_count');

        return back()->with('success', count($ids) . ' comentarios eliminados.');
    }
}
