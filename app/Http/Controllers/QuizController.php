<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestQuizValidation;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;
use Illuminate\Http\Response;

class QuizController extends Controller
{
    /**
     * Display a list of available quizzes in the application
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form to create a new quiz
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created quiz in the database
     *
     * @param RequestQuizValidation $request
     * @return Response
     */
    public function store(RequestQuizValidation $request): Response
    {
        //
    }

    /**
     * Display data on a Quiz record in the application
     *
     * @param Quiz $quiz
     * @return Response
     */
    public function show(Quiz $quiz): Response
    {
        //
    }

    /**
     * Show the form for editing the specified quiz record.
     *
     * @param Quiz $quiz
     * @return Response
     */
    public function edit(Quiz $quiz): Response
    {
        //
    }

    /**
     * Update attributes of the specified quiz in the database
     *
     * @param RequestQuizValidation $request
     * @param Quiz $quiz
     * @return Response
     */
    public function update(RequestQuizValidation $request, Quiz $quiz): Response
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
     * Mark a quiz record for deletion from storage (soft delete)
     *
     * @param Quiz $quiz
     * @return Response
     */
    public function delete(Quiz $quiz): Response
    {
        //
    }

    /** Delete specified quiz record from database (hard delete)
     *
     * @param Quiz $quiz
     * @return Response
     */
    public function destroy(Quiz $quiz): Response
    {

    }
}
