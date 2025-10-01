<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Posts\Actions;

use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;

final class BulkPinAction extends BulkAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Fixar Posts Selecionados');
        $this->icon('heroicon-m-pin');
        $this->color('warning');
        $this->requiresConfirmation();
        $this->modalHeading('Fixar Posts');
        $this->modalDescription('Os posts selecionados serão fixados no topo de suas respectivas comunidades.');
        $this->modalSubmitActionLabel('Fixar Posts');

        $this->action(function (): void {
            $this->process(function (): void {
                $records = $this->getRecords();

                foreach ($records as $record) {
                    // Desfixar outros posts da mesma comunidade
                    $record->subreddit->posts()
                        ->where('id', '!=', $record->id)
                        ->update(['is_pinned' => false]);

                    // Fixar o post atual
                    $record->update(['is_pinned' => true]);
                }
            });

            $count = $this->getRecords()->count();

            Notification::make()
                ->title($count . ' posts fixados com sucesso!')
                ->success()
                ->send();
        });
    }

    public static function getDefaultName(): string
    {
        return 'bulk_pin';
    }
}
