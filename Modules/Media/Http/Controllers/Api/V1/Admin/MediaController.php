<?php

namespace Modules\Media\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Modules\Media\Events\FileWasLinked;
use Modules\Media\Events\FileWasUnlinked;
use Modules\Media\Events\FileWasUploaded;
use Modules\Media\Http\Requests\UploadMediaRequest;
use Modules\Media\Http\Requests\UploadRequest;
use Modules\Media\Image\Imagy;
use Modules\Media\Repositories\FileRepository;
use Modules\Media\Services\FileService;

class MediaController extends Controller
{

    /**
     *
     * @var FileService
     */
    private $fileService;

    /**
     *
     * @var FileRepository
     */
    private $file;

    /**
     *
     * @var Imagy
     */
    private $imagy;

    public function __construct(FileService $fileService, FileRepository $file, Imagy $imagy)
    {
        $this->fileService = $fileService;
        $this->file = $file;
        $this->imagy = $imagy;
    }

    public function all()
    {
        $files = $this->file->all();

        return [
            'count' => $files->count(),
            'data' => $files,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UploadMediaRequest $request
     * @return Response
     */
    public function store(UploadMediaRequest $request)
    {

        $savedFile = $this->fileService->store($request->file('file'));

        if (is_string($savedFile)) {
            return Response::json([
                'error' => $savedFile,
            ], 409);
        }

        event(new FileWasUploaded($savedFile));

        return Response::json($savedFile->toArray());
    }

    public function upload(UploadRequest $request)
    {

        $file = $request->file('file');

        // Perform actions with the file, such as storing it
        $path = $file->store('uploads', 'public');

        // You can also access other properties of the uploaded file, e.g., original name, size, etc.
        $originalName = $file->getClientOriginalName();
        $size = $file->getSize();

        // Return a response, redirect, etc.
        return response()->json(['path' => $path, 'original_name' => $originalName, 'size' => $size]);
    }

    /**
     * Link the given entity with a media file
     *
     * @param Request $request
     */
    public function linkMedia(Request $request)
    {
        $mediaId = $request->get('mediaId');
        $entityClass = $request->get('entityClass');
        $entityId = $request->get('entityId');
        $order = $request->get('order');

        $entity = $entityClass::find($entityId);
        $zone = $request->get('zone');
        $entity->files()->attach($mediaId, [
            'imageable_type' => $entityClass,
            'zone' => $zone,
            'order' => $order,
        ]);
        $imageable = DB::table('media__imageables')->whereFileId($mediaId)
            ->whereZone($zone)
            ->whereImageableType($entityClass)
            ->first();
        $file = $this->file->find($imageable->file_id);

        if (str_contains($file->mimetype, 'video')) {
            $thumbnailPath = $file->path->getRelativeUrl();
            $mediaType = 'video';
        } else {
            $thumbnailPath = $this->imagy->getThumbnail($file->path, 'mediumThumb');
            $mediaType = 'image';
        }

        event(new FileWasLinked($file, $entity));

        return Response::json([
            'error' => false,
            'message' => 'The link has been added.',
            'result' => [
                'path' => $thumbnailPath,
                'imageableId' => $imageable->id,
                'mediaType' => $mediaType,
            ],
        ]);
    }

    /**
     * Remove the record in the media__imageables table for the given id
     *
     * @param Request $request
     */
    public function unlinkMedia(Request $request)
    {
        $imageableId = $request->get('imageableId');
        $deleted = DB::table('media__imageables')->whereId($imageableId)->delete();
        if (!$deleted) {
            return Response::json([
                'error' => true,
                'message' => 'The file was not found.',
            ]);
        }

        event(new FileWasUnlinked($imageableId));

        return Response::json([
            'error' => false,
            'message' => 'The link has been removed.',
        ]);
    }

    /**
     * Sort the record in the media__imageables table for the given array
     * @param Request $request
     */
    public function sortMedia(Request $request)
    {
        $imageableIdArray = $request->get('sortable');

        $order = 1;

        foreach ($imageableIdArray as $id) {
            DB::table('media__imageables')->whereId($id)->update(['order' => $order]);
            $order++;
        }

        return Response::json(['error' => false, 'message' => 'The items have been reorder.']);
    }
}
