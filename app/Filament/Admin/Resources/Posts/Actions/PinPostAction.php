<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Posts\Actions;

use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Notifications\Notification;

final class PinPostAction extends Action
{
    use CanCustomizeProcess;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Fixar Post');
        $this->icon('heroicon-o-bookmark');
        $this->color('warning');
        $this->requiresConfirmation();
        $this->modalHeading('Fixar Post');
        $this->modalDescription('Este post será fixado no topo da comunidade.');
        $this->modalSubmitActionLabel('Fixar');

        $this->action(function (Post $record): void {
            $this->process(function () use ($record): void {
                // Desfixar todos os outros posts da mesma comunidade
                Post::query()->where('subreddit_id', $record->subreddit_id)
                    ->where('id', '!=', $record->id)
                    ->update(['is_pinned' => false]);

                // Fixar o post atual
                $record->update(['is_pinned' => true]);
            });

            Notification::make()
                ->title('Post fixado com sucesso!')
                ->success()
                ->send();
        });
    }

    public static function getDefaultName(): string
    {
        return 'pin';
    }
}
