<?php

use App\Http\Controllers\CubeThumbnailController;
use App\Http\Controllers\UserAvatarController;
use App\Models\Cube;
use App\Models\Side;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('clean', function () {
  /** @var Command $this */
  $this->newLine();

  $toKeep = collect([
    UserAvatarController::fallback,
    CubeThumbnailController::fallback,
  ]);

  $this->line('registering user avatars...');
  $this->withProgressBar(User::all(), function (User $user) use ($toKeep) {
    if ($user->avatar) $toKeep->push($user->avatar);
  });
  $this->newLine(2);

  $this->line('registering cube thumbnails...');
  $this->withProgressBar(Cube::all(), function (Cube $cube) use ($toKeep) {
    if ($cube->thumbnail) $toKeep->push($cube->thumbnail);
  });
  $this->newLine(2);

  $this->line('registering side videos...');
  $this->withProgressBar(Side::all(), function (Side $side) use ($toKeep) {
    if ($side->video) $toKeep->push($side->video);
  });
  $this->newLine(2);

  $this->line('deleting unused files...');
  $toDelete = collect(Storage::files())->diff($toKeep);
  $this->withProgressBar($toDelete, function ($file) {
    Storage::delete($file);
  });
  $this->newLine(2);
  $this->info('done');
})->purpose('clean up unused files');
