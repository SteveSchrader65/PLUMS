<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestLevelValidation;
use App\Http\Requests\UpdateLevelRequest;
use App\Models\Level;
use Illuminate\Http\Response;

class LevelController extends Controller
{
    /**
     * Display a list of the AQF levels in the application
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Create a new AQF Level record in the application
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created AQF Level in the database
     *
     * @param RequestLevelValidation $request
     * @return Response
     */
    public function store(RequestLevelValidation $request): Response
    {
        //
    }

    /**
     * Display data on an AQF Level record in the application
     *
     * @param Level $level
     * @return Response
     */
    public function show(Level $level): Response
    {
        //
    }

    /**
     * Show the form for modifying the specified AQF Level
     *
     * @param Level $level
     * @return Response
     */
    public function edit(Level $level): Response
    {
        //
    }

    /**
     * Update attributes of an AQF Level in the application
     *
     * @param RequestLevelValidation $request
     * @param Level $level
     * @return Response
     */
    public function update(RequestLevelValidation $request, Level $level): Response
    {
        //
    }

    /**
     * Search for AQF Levels where text field matches search term
     *
     * @param $search_term
     * @return Response
     */
    public function search($search_term): Response
    {

    }

    /**
     * Mark an AQFLevel record for deletion from storage (soft delete)
     *
     * @param Level $level
     * @return Response
     */
    public function delete(Level $level): Response
    {
        //
    }

    /** Delete specified AQFLevel from database (hard delete)
     *
     * @param Level $level
     * @return Response
     */
    public function destroy(Level $level): Response
    {

    }
}
