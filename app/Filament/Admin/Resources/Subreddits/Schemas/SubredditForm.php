<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Subreddits\Schemas;

use Filament\Schemas\Schema;

final class SubredditForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
