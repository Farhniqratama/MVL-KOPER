<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DataScience\DataPipelineService;
use App\Services\DataScience\RecommenderService;
use App\Services\DataScience\CustomerSegmentationService;
use App\Services\DataScience\SalesForecastingService;
use App\Services\DataScience\SentimentAnalysisService;

class DataScienceController extends Controller
{
    protected $pipelineService;
    protected $recommenderService;
    protected $segmentationService;
    protected $forecastingService;
    protected $sentimentService;

    public function __construct(
        DataPipelineService $pipelineService,
        RecommenderService $recommenderService,
        CustomerSegmentationService $segmentationService,
        SalesForecastingService $forecastingService,
        SentimentAnalysisService $sentimentService
    ) {
        $this->pipelineService     = $pipelineService;
        $this->recommenderService  = $recommenderService;
        $this->segmentationService = $segmentationService;
        $this->forecastingService  = $forecastingService;
        $this->sentimentService    = $sentimentService;
    }

    /**
     * Data Science Command Center / Overview Dashboard
     */
    public function index()
    {
        $pipelineSummary = $this->pipelineService->getPipelineSummary();
        $segmentation    = $this->segmentationService->getCustomerSegments();
        $forecasting     = $this->forecastingService->getSalesForecast();
        $sentiment       = $this->sentimentService->analyzeAllReviews();
        $recommender     = $this->recommenderService->getMarketBasketRules();

        return view('datascience.dashboard', compact(
            'pipelineSummary',
            'segmentation',
            'forecasting',
            'sentiment',
            'recommender'
        ));
    }

    /**
     * Halaman Analisis Segmentasi Pelanggan (RFM & K-Means)
     */
    public function segmentation()
    {
        $segmentation = $this->segmentationService->getCustomerSegments();
        return view('datascience.segmentation', compact('segmentation'));
    }

    /**
     * Halaman Peramalan Penjualan (Sales Forecasting & Inventory Demand)
     */
    public function forecasting(Request $request)
    {
        $alpha = (float) $request->get('alpha', 0.4);
        $forecasting = $this->forecastingService->getSalesForecast(6, $alpha);
        return view('datascience.forecasting', compact('forecasting', 'alpha'));
    }

    /**
     * Halaman Analisis Sentimen Ulasan Pelanggan (NLP & Text Mining)
     */
    public function sentiment()
    {
        $sentiment = $this->sentimentService->analyzeAllReviews();
        return view('datascience.sentiment', compact('sentiment'));
    }

    /**
     * Halaman Sistem Rekomendasi & Market Basket Analysis
     */
    public function recommender()
    {
        $matrixData = $this->recommenderService->calculateItemSimilarityMatrix();
        $aprioriRules = $this->recommenderService->getMarketBasketRules();
        return view('datascience.recommender', compact('matrixData', 'aprioriRules'));
    }

    /**
     * API Endpoint: Get AI Recommendations for a Product
     */
    public function apiRecommendations($id)
    {
        $recommendations = $this->recommenderService->getRecommendedProductsFor($id, 4);
        return response()->json([
            'status' => 'success',
            'data'   => $recommendations
        ]);
    }
}
