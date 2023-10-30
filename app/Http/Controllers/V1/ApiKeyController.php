<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateApiKeyRequest;
use App\Http\Requests\UpdateApiKeyRequest;
use App\Http\Requests\UpdateProxyRequest;
use App\Models\ApiKey;
use App\Services\V1\ApiKeyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{

    public function __construct(
        private ApiKeyService $service,
    ) {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param   CreateApiKeyRequest  $request
     *
     * @return JsonResponse
     * @lrd:start
     * Создание API ключа
     * @lrd:end*
     */
    public function store(CreateApiKeyRequest $request): JsonResponse
    {
        return $this->success($this->service->create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param   \App\Models\ApiKey  $apiKey
     *
     * @return JsonResponse
     * @lrd:start
     * Получние API ключа по ID
     * @lrd:end*
     */
    public function show(ApiKey $apiKey): JsonResponse
    {
        return $this->success($apiKey);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param   UpdateApiKeyRequest  $request
     * @param   \App\Models\ApiKey   $apiKey
     *
     * @return JsonResponse
     *
     * @lrd:start
     * Обновление API ключа
     * @lrd:end*
     */
    public function update(
        UpdateApiKeyRequest $request,
        ApiKey $apiKey
    ): JsonResponse {
        return $this->success(
            $this->service->update($apiKey, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   \App\Models\ApiKey  $apiKey
     *
     * @return JsonResponse
     *
     * @lrd:start
     * Удаление API ключа
     * @lrd:end*
     */
    public function destroy(ApiKey $apiKey): JsonResponse
    {
        return $this->success($apiKey->delete());
    }

}
