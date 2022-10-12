<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateTickerAPIRequest;
use App\Http\Requests\API\V1\UpdateTickerAPIRequest;
use App\Models\Ticker;
use App\Repositories\TickerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\API\V1\TickerResource;

/**
 * Class TickerAPIController
 */
class TickerAPIController extends AppBaseController
{
    /** @var  TickerRepository */
    private $tickerRepository;

    public function __construct(TickerRepository $tickerRepo)
    {
        $this->tickerRepository = $tickerRepo;
    }

    /**
     * Display a listing of the Tickers.
     * GET|HEAD /tickers
     */
    public function index(Request $request): JsonResponse
    {
        $tickers = $this->tickerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(TickerResource::collection($tickers), 'Tickers retrieved successfully');
    }

    /**
     * Store a newly created Ticker in storage.
     * POST /tickers
     */
    public function store(CreateTickerAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $ticker = $this->tickerRepository->create($input);

        return $this->sendResponse(new TickerResource($ticker), 'Ticker saved successfully');
    }

    /**
     * Display the specified Ticker.
     * GET|HEAD /tickers/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Ticker $ticker */
        $ticker = $this->tickerRepository->find($id);

        if (empty($ticker)) {
            return $this->sendError('Ticker not found');
        }

        return $this->sendResponse(new TickerResource($ticker), 'Ticker retrieved successfully');
    }

    /**
     * Update the specified Ticker in storage.
     * PUT/PATCH /tickers/{id}
     */
    public function update($id, UpdateTickerAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Ticker $ticker */
        $ticker = $this->tickerRepository->find($id);

        if (empty($ticker)) {
            return $this->sendError('Ticker not found');
        }

        $ticker = $this->tickerRepository->update($input, $id);

        return $this->sendResponse(new TickerResource($ticker), 'Ticker updated successfully');
    }

    /**
     * Remove the specified Ticker from storage.
     * DELETE /tickers/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Ticker $ticker */
        $ticker = $this->tickerRepository->find($id);

        if (empty($ticker)) {
            return $this->sendError('Ticker not found');
        }

        $ticker->delete();

        return $this->sendSuccess('Ticker deleted successfully');
    }
}
