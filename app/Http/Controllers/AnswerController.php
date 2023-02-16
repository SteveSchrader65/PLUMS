<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAnswerValidation;
use App\Models\Answer;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    /**
     * Display a listing of question answers in the application
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form to create a new question answer in the application
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created answer in the database
     *
     * @param RequestAnswerValidation $request
     * @return Response
     */
    public function store(RequestAnswerValidation $request): Response
    {
        //
    }

    /**
     * Display data on the specified answer in the application
     *
     * @param Answer $answer
     * @return Response
     */
    public function show(Answer $answer): Response
    {
        //
    }

    /**
     * Show the form for modifying the specified answer
     *
     * @param Answer $answer
     * @return Response
     */
    public function edit(Answer $answer): Response
    {
        //
    }

    /**
     * Update attributes of the specified answer in the database
     *
     * @param RequestAnswerValidation $request
     * @param Answer $answer
     * @return Response
     */
    public function update(RequestAnswerValidation $request, Answer $answer): Response
    {
        //
    }

    /**
     * Search for answers where text field matches search term
     *
     * @param $search_term
     * @return Response
     */
    public function search($search_term): Response
    {

    }

    /**
     * Mark an answer record for deletion from storage (soft delete)
     *
     * @param Answer $answer
     * @return Response
     */
    public function delete(Answer $answer): Response
    {
        //
    }

    /** Delete specified answer from the database (hard delete)
     *
     * @param Answer $answer
     * @return Response
     */
    public function destroy(Answer $answer): Response
    {

    }
}
