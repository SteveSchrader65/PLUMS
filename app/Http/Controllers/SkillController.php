<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestSkillValidation;
use App\Http\Requests\StoreSpecializationRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Http\Requests\UpdateSpecializationRequest;
use App\Models\Skill;
use App\Models\Specialization;
use Illuminate\Http\Response;

class SkillController extends Controller
{
    /**
     * Display a list of skills in the application
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new skill
     *
     * @return Response
     */
    public function create(): Response
    {
        //
    }

    /**
     * /**
     * Store a newly created skill in the database
     *
     * @param RequestSkillValidation $request
     * @return Response
     */
    public function store(RequestSkillValidation $request): Response
    {
        //
    }

    /**
     * Display data on a Skill record in the application
     *
     * @param Skill $skill
     * @return Response
     */
    public function show(Skill $skill): Response
    {
        //
    }

    /**
     * Show the form for editing the specified Skill record
     *
     * @param Skill $skill
     * @return Response
     */
    public function edit(Skill $skill): Response
    {
        //
    }

    /**
     * Search for skills where search-term matches name or description
     *
     * @param $search_term
     * @return Response
     */
    public function search($search_term): Response
    {

    }

    /**
     * Update attributes of a Skill in the database
     *
     * @param UpdateSkillRequest $request
     * @param Skill $skill
     * @return Response
     */
    public function update(UpdateSkillRequest $request, Skill $skill): Response
    {
        //
    }

    /**
     * Mark a skill record for deletion from storage (soft delete)
     *
     * @param Skill $skill
     * @return Response
     */
    public function delete(Skill $skill): Response
    {
        //
    }

    /** Delete specified skill record from database (hard delete)
     *
     * @param Skill $skill
     * @return Response
     */
    public function destroy(Skill $skill): Response
    {

    }
}
