<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Errors\ComicError;
use App\Http\Errors\CommonError;
use App\Http\Requests\V1\Comic\DestroyFormRequest;
use App\Http\Requests\V1\Comic\IndexFormRequest;
use App\Http\Requests\V1\Comic\ShowFormRequest;
use App\Http\Requests\V1\Comic\StoreFormRequest;
use App\Http\Requests\V1\Comic\UpdateFormRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\V1\Comic\DestroyResource;
use App\Http\Resources\V1\Comic\IndexResource;
use App\Http\Resources\V1\Comic\ShowResource;
use App\Http\Resources\V1\Comic\StoreResource;
use App\Http\Resources\V1\Comic\UpdateResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Packages\UseCase\Comic\Destroy\ComicDestroyRequest;
use Packages\UseCase\Comic\Destroy\ComicDestroyUseCaseInterface;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Exception\ComicCannotBeDeletedException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Index\ComicIndexRequest;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;
use Packages\UseCase\Comic\Store\ComicStoreRequest;
use Packages\UseCase\Comic\Store\ComicStoreUseCaseInterface;
use Packages\UseCase\Comic\Update\ComicUpdateRequest;
use Packages\UseCase\Comic\Update\ComicUpdateUseCaseInterface;

class ComicsController extends Controller
{
    public function index(
        ComicIndexUseCaseInterface $interactor,
        IndexFormRequest $formRequest
    ): IndexResource {
        $request = new ComicIndexRequest(
            key: $formRequest->input('key'),
            name: $formRequest->input('name'),
            status: $formRequest->input('status')
        );
        $response = $interactor->handle($request);

        return new IndexResource($response->build());
    }

    public function show(
        ComicShowUseCaseInterface $interactor,
        ShowFormRequest $formRequest,
        mixed $comicId
    ): ShowResource|JsonResponse {
        try {
            $request = new ComicShowRequest(id: (int) $comicId);
            $response = $interactor->handle($request);
        } catch (ComicNotFoundException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicNotFound->code(),
                'message' => ComicError::ComicNotFound->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new ShowResource($response->build());
    }

    public function store(
        ComicStoreUseCaseInterface $interactor,
        StoreFormRequest $formRequest
    ): StoreResource|JsonResponse {
        try {
            $request = new ComicStoreRequest(
                key: $formRequest->input('key'),
                name: $formRequest->input('name'),
                status: $formRequest->input('status')
            );
            $response = $interactor->handle($request);
        } catch (ComicAlreadyExistsException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicAlreadyExists->code(),
                'message' => ComicError::ComicAlreadyExists->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new StoreResource($response->build());
    }

    public function update(
        ComicUpdateUseCaseInterface $interactor,
        UpdateFormRequest $formRequest,
        mixed $comicId
    ): UpdateResource|JsonResponse {
        try {
            $request = new ComicUpdateRequest(
                id: (int) $comicId,
                key: $formRequest->input('key'),
                name: $formRequest->input('name'),
                status: $formRequest->input('status')
            );
            $response = $interactor->handle($request);
        } catch (ComicNotFoundException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicNotFound->code(),
                'message' => ComicError::ComicNotFound->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (ComicAlreadyExistsException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicAlreadyExists->code(),
                'message' => ComicError::ComicAlreadyExists->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new UpdateResource($response->build());
    }

    /**
     * @return DestroyResource
     */
    public function destroy(
        ComicDestroyUseCaseInterface $interactor,
        DestroyFormRequest $formRequest,
        mixed $comicId
    ): DestroyResource|JsonResponse {
        try {
            $request = new ComicDestroyRequest(id: (int) $comicId);
            $response = $interactor->handle($request);
        } catch (ComicNotFoundException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicNotFound->code(),
                'message' => ComicError::ComicNotFound->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (ComicCannotBeDeletedException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicCannotBeDeleted->code(),
                'message' => ComicError::ComicCannotBeDeleted->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new DestroyResource($response->build());
    }
}
