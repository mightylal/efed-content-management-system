<?php

namespace Efed\Image;

use Efed\Repositories\ImageRepository;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Upload
{

    /**
     * Upload the image.
     *
     * @param Model $model
     * @param UploadedFile $uploadedFile
     * @param integer $entity_id
     */
    public function handle(Model $model, UploadedFile $uploadedFile, $entity_id)
    {
        $imageRepo = new ImageRepository($model);
        $fileName = bin2hex(openssl_random_pseudo_bytes(16)) . '.' . $uploadedFile->guessExtension();
        $file = $uploadedFile->move(public_path('images'), $fileName);
        $image = [$model->idColumnName => $entity_id, 'mime' => $file->getMimeType(), 'extension' => $file->guessExtension(), 'url' => asset('images/' . $file->getFilename())];
        $imageRepo->updateOrCreate($entity_id, $image);
    }

}