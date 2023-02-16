<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestQuestionValidation;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of questions in the application
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form to create a new question in the application
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created question in the database
     *
     * @param RequestQuestionValidation $request
     * @return Response
     */
    public function store(RequestQuestionValidation $request): Response
    {
        //
    }

    /**
     * Display data on a question in the application
     *
     * @param Question $question
     * @return Response
     */
    public function show(Question $question): Response
    {
        //
    }

    /**
     * Show the form for modifying the specified question
     *
     * @param Question $question
     * @return Response
     */
    public function edit(Question $question): Response
    {
        //
    }

    /**
     * Update attributes of the specified question in the database
     *
     * @param RequestQuestionValidation $request
     * @param Question $question
     * @return Response
     */
    public function update(RequestQuestionValidation $request, Question $question): Response
    {
        //
    }

    /**
     * Search for questions where search term matches question text
     *
     * @param $search_term
     * @return Response
     */
    public function search($search_term): Response
    {

    }

    /**
     * Mark a question record for deletion from storage (soft delete)
     *
     * @param Question $question
     * @return Response
     */
    public function delete(Question $question): Response
    {
        // MODIFY BOOLEAN is_available VARIABLE TO FALSE
        // OR USE SOFT DELETIONS
    }

    /** Delete specified QUESTION RECORD from database (hard delete)
     *
     * @param Question $question
     * @return Response
     */
    public function destroy(Question $question): Response
    {

    }
}
