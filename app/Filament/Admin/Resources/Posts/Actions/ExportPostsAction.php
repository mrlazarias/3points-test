<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Posts\Actions;

use App\Models\Post;
use Filament\Actions\Action;

final class ExportPostsAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Exportar Posts');
        $this->icon('heroicon-o-arrow-down-tray');
        $this->color('success');
        $this->requiresConfirmation();
        $this->modalHeading('Exportar Posts');
        $this->modalDescription('Os posts serão exportados em formato CSV.');
        $this->modalSubmitActionLabel('Exportar');

        $this->action(function (): void {
            $this->process(function (): void {
                $posts = Post::with(['user', 'subreddit'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                $filename = 'posts_export_'.now()->format('Y-m-d_H-i-s').'.csv';
                $filepath = storage_path('app/exports/'.$filename);

                // Criar diretório se não existir
                if (! file_exists(dirname($filepath))) {
                    mkdir(dirname($filepath), 0755, true);
                }

                $file = fopen($filepath, 'w');

                // Cabeçalhos CSV
                fputcsv($file, [
                    'ID',
                    'Título',
                    'Tipo',
                    'Autor',
                    'Comunidade',
                    'Score',
                    'Comentários',
                    'Fixado',
                    'Bloqueado',
                    'Data de Criação',
                ],
                    escape: '\\');

                // Dados
                foreach ($posts as $post) {
                    fputcsv($file, [
                        $post->id,
                        $post->title,
                        ucfirst($post->type),
                        $post->user->name,
                        'r/'.$post->subreddit->slug,
                        $post->vote_score,
                        $post->comment_count,
                        $post->is_pinned ? 'Sim' : 'Não',
                        $post->is_locked ? 'Sim' : 'Não',
                        $post->created_at->format('d/m/Y H:i'),
                    ],
                        escape: '\\');
                }

                fclose($file);

                // Força o download
                response()->download($filepath)->deleteFileAfterSend(true);
            });
        });
    }

    public static function getDefaultName(): string
    {
        return 'export';
    }
}
