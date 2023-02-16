<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttemptController extends Controller
{
    /**
     * Display a listing of quiz attempts in the application
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Store a newly created quiz attempt in the database
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {


    }

    /**
     * Display data on the specified quiz attempt in the application
     *
     * @param Attempt $attempt
     * @return Response
     */
    public function show(Attempt $attempt): Response
    {
        //
    }


    /**
     * Update attributes of the specified quiz attempt in the database
     *
     * @param Request $request
     * @param Attempt $attempt
     * @return Response
     */
    public function update(Request $request, Attempt $attempt): Response
    {

    }
}
