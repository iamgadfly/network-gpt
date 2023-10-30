<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProxyRequest;
use App\Http\Requests\CreateRelationRequest;
use App\Http\Requests\UpdateProxyRequest;
use App\Models\Proxy;
use App\Services\V1\ProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProxyController extends Controller
{

    public function __construct(
        private ProxyService $service,
    ) {
    }

    /**
     * @lrd:start
     * Создание связи между ключом и прокси
     * @lrd:end*
     */
    public function makeRelation(CreateRelationRequest $request)
    {
        $this->success($this->service->makeRelation($request->validated()));
    }

    /**
     * @param   \App\Http\Requests\CreateProxyRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Создание прокси
     * @lrd:end*
     */
    public function store(CreateProxyRequest $request): JsonResponse
    {
        return $this->success($this->service->create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param   \App\Models\Proxy  $proxy
     *
     * @return JsonResponse
     *
     * @lrd:start
     * Получение прокси
     * @lrd:end*
     */
    public function show(Proxy $proxy): JsonResponse
    {
        return $this->success($proxy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   UpdateProxyRequest  $request
     * @param   \App\Models\Proxy   $proxy
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @lrd:start
     * Обновление прокси
     * @lrd:end*
     */
    public function update(
        UpdateProxyRequest $request,
        Proxy $proxy
    ): JsonResponse {
        return $this->success(
            $this->service->update($proxy, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   \App\Models\Proxy  $proxy
     *
     * @return JsonResponse
     * @lrd:start
     * Удаление прокси
     * @lrd:end*
     */
    public function destroy(Proxy $proxy): JsonResponse
    {
        return $this->success($proxy->delete());
    }

}
