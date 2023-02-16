<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestFieldValidation;
use App\Models\Field;
use Illuminate\http\Response;

class FieldController extends Controller
{
    /**
     * Display a listing of study-fields in the application
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new study-field in the application
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created study-field in the database
     *
     * @param RequestFieldValidation $request
     * @return Response
     */
    public function store(RequestFieldValidation $request): Response
    {
        //
    }

    /**
     * Display data on the specified study-field in the application
     *
     * @param Field $field
     * @return Response
     */
    public function show(Field $field): Response
    {
        //
    }

    /**
     * Show the form for modifying the specified study-field
     *
     * @param Field $field
     * @return Response
     */
    public function edit(Field $field): Response
    {
        //
    }

    /**
     * Update attributes of the specified study-field in the database
     *
     * @param RequestFieldValidation $request
     * @param Field $field
     * @return Response
     */
    public function update(RequestFieldValidation $request, Field $field): Response
    {
        //
    }

    /**
     * Search for study-fields where search-term matches question-text
     *
     * @param $search_term
     * @return Response
     */
    public function search($search_term): Response
    {

    }

    /**
     * Mark a study-field record for deletion from storage (soft delete)
     *
     * @param Field $field
     * @return Response
     */
    public function delete(Field $field): Response
    {
        //
    }

    /** Delete specified study-field from the database (hard delete)
     *
     * @param Field $field
     * @return Response
     */
    public function destroy(Field $field): Response
    {

    }
}
