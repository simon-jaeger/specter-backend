<?php

namespace App\Http\Controllers;
use App\Models\Side;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Storage;

class SideVideoController extends Controller {
  public function show(Request $request, Side $side) {
    $cube = $side->cube;
    if ($cube->private && !$cube->owned()) return abort(404);
    if ($side->video === null) return abort(404);
    if ($request->boolean('html'))
      return $side->toHtmlVideo();
    else
      return Storage::response($side->video);
  }

  public function create(Request $request, FileReceiver $receiver, Side $side) {
    $cube = $side->cube;
    if (!$cube->owned()) return abort(404);
    $request->validate([
      Side::video => Side::rules(Side::video)
    ]);

    // start chunk uploading
    if ($receiver->isUploaded() === false) throw new UploadMissingFileException();
    $upload = $receiver->receive();

    // on final chunk
    if ($upload->isFinished()) {
      $side->video = Storage::putFile('', $upload->getFile());
      $side->save();
      $cube->duration = FFMpeg::open($side->video)->getDurationInSeconds();
      $cube->save();
      return '[ok] video duration: ' . $cube->duration . ' seconds';
    }

    // on progress
    /** @var AbstractHandler $handler */
    $handler = $upload->handler();
    return response()->json([
      "done" => $handler->getPercentageDone()
    ]);
  }

  public function destroy(Side $side) {
    $cube = $side->cube;
    if (!$cube->owned()) return abort(404);
    $side->video = null;
    $side->save();
    return 'ok';
  }
}
