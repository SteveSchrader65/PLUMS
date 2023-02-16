<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Requests\APIFieldValidation;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ValidateSearchRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

// THIS CONTROLLER WILL REQUIRE SPECIFIC METHODS FOR EVENTS SUCH AS
//                a) EACH ANSWER BEING SUBMITTED
//                b) QUIZ IS COMPLETED (ALL QUESTIONS ANSWERED)
//                c) SESSION IS TERMINATED IN THE PROCESS OF A QUIZ ATTEMPT
//                d) WHEN USER RETURNS AFTER c)
//                e) GRADING SUBMITTED QUIZ
//                f) RESULTS OF COMPLETED QUIZZES NEED TO BE STORED (ATTEMPTS TABLE,
//                   OR CREATE NEW RESULTS TABLE)

class AttemptAPIController extends APIBaseController
{
    /**
     * Display a listing of quiz attempts in the API
     *
     * @group AttemptAPI
     * @request GET
     * @urlParam http://localhost/api/attempts/
     * @bodyParam page integer Example: 1
     * @bodyParam per_page integer Example: 5
     *
     * @reponse {
     *
     * }
     *
     * @return Response
     */
    public function index(): Response

    {
        //
    }

    /**
     * Display data on a quiz attempt record
     *
     * @group AttemptAPI
     * @request GET
     * @urlParam http://localhost/api/attempts/2
     *
     * @response {
     *
     * }
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        //
    }

    /**
     * Create a new quiz attempt in the API
     * .
     * @group AttemptAPI
     * @request POST
     * @urlParam http://localhost/api/attempts/2
     *
     * @response {
     *
     * }
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $attempt = Attempt::create($request);

        // CHECK THAT QUIZ IS AVAILABLE FOR USAGE ...
        // Increment 'times_attempted' counter for this quiz
        $quiz = Quiz::query()->where('id', $attempt['quiz_id'])->find($attempt['quiz_id']);
        $quiz['times_attempted'] += 1;
        $quiz->save();

        // METHOD/ROUTING NEEDED FOR WHEN A QUIZ IS COMPLETED (ie: All questions answered)
        // CHECK ANSWERS
        // INCREMENT CORRECT/INCORRECT COUNTERS FOR EACH QUESTION
        // COLLATE SCORE
    }

    /**
     * Update attributes of a quiz attempt record in the API
     *
     * @group AttemptAPI
     * @request PUT
     * @urlParam http://localhost/api/attempts/3
     * @bodyParam ??? int Example: 3
     * @bodyParam ??? string Example:
     * @bodyParam ??? string Example:
     *
     * @response {
     *
     *  }
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        //
    }
}
