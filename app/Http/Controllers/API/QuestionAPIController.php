<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\APIUpdateQuestionValidation;
use App\Models\Answer;
use App\Models\Question;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ValidateSearchRequest;
use App\Http\Requests\APIStoreQuestionValidation;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * @method sendError(string $string)
 * @method sendResponse($questions, string $string)
 */
class QuestionAPIController extends APIBaseController
{
    /**
     * Display a list of available questions to be used within PLUMS quizzes in the API
     *
     * @group QuestionAPI
     * @request GET
     * @urlParam http://localhost/api/questions/
     * @bodyParam page integer Example: 2
     * @bodyParam per_page integer Example: 3
     *
     * @reponse {
     *      "success": true,
     *      "data": {
     *          "current_page": 2,
     *          "data": [{
     *              "id": 4,
     *              "question_text": "Read the following definition carefully: Abstraction is the provision of essential information to the outside world, whilst hiding the details of how that data is stored and manipulated.",
     *              "answer_set": "[27, 30]",
     *              "points_value": 1,
     *              "is_available": 1,
     *              "written_by": 1,
     *              "times_used": 0,
     *              "times_answered_correctly": 0,
     *              "times_answered_incorrectly": 0,
     *              "answers": null,
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 5,
     *              "question_text": "Read the following definition carefully: Modularization is the capability to create a new class based upon the blueprint, or template, provided by an existing class.",
     *              "answer_set": "[28, 29]",
     *              "points_value": 0.5,
     *              "is_available": 1,
     *              "written_by": 1,
     *              "times_used": 0,
     *              "times_answered_correctly": 0,
     *              "times_answered_incorrectly": 0,
     *              "answers": null,
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 6,
     *              "question_text": "What is the commonly known name for the NOSQL language developed by Facebook?",
     *              "answer_set": "[2, 6, 18]",
     *              "points_value": 1,
     *              "is_available": 1,
     *              "written_by": 1,
     *              "times_used": 0,
     *              "times_answered_correctly": 0,
     *              "times_answered_incorrectly": 0,
     *              "answers": null,
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          }],
     *      },
     *  "message": "Total of 3 Questions retrieved"
     * }
     *
     * @param PaginationRequest $request
     * @return JsonResponse
     */
    public function index(PaginationRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!isset($validated['per_page'])) {
            $validated['per_page'] = 10;
        }

        $questions = Question::paginate($validated["per_page"]);

        if (!is_null($questions) && $questions->count() == 1) {
            return $this->sendResponse(
                $questions,
                "{$questions->count()} Question retrieved",
            );
        } else {
            if (!is_null($questions) && $questions->count() > 1) {
                json_encode($questions['answers']);

                return $this->sendResponse(
                    $questions,
                    "Total of {$questions->count()} Questions retrieved",
                );
            }
        }

        return $this->sendError("No Questions found");
    }

    /**
     * Display data on a PLUMS quiz question in the API
     *
     * @group QuestionAPI
     * @request GET
     * @urlParam http://localhost/api/questions/7
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 7,
     *          "question_text": "There are many terms relating to security with regards to the Web. Which of the following statements are most appropriate to define Authentication?",
     *          "answer_set": "[11, 19, 25]",
     *          "points_value": 0.5,
     *          "is_available": 1,
     *          "written_by": 1,
     *          "times_used": 2,
     *          "times_answered_correctly": 0,
     *          "times_answered_incorrectly": 0,
     *          "answers": [{
     *                  "id": 11,
     *                  "answer_text": "Authentication is the process of 'logging into' a web application",
     *                  "is_correct": 1,
     *                  "created_at": "2023-01-29T05:00:38.000000Z",
     *                  "updated_at": "2023-01-29T05:00:38.000000Z",
     *                  "deleted_at": null
     *              },
     *              {
     *                  "id": 19,
     *                  "answer_text": "Authentication helps the programmer to identify the real elements of an application",
     *                  "is_correct": 0,
     *                  "created_at": "2023-01-29T05:00:38.000000Z",
     *                  "updated_at": "2023-01-29T05:00:38.000000Z",
     *                  "deleted_at": null
     *              },
     *              {
     *                  "id": 25,
     *                  "answer_text": "Authentication often uses recycled passwords to provide a more secure system",
     *                  "is_correct": 0,
     *                  "created_at": "2023-01-29T05:00:38.000000Z",
     *                  "updated_at": "2023-01-29T05:00:38.000000Z",
     *                  "deleted_at": null
     *              }],
     *              "created_at": "2023-01-29T05:00:38.000000Z",
     *              "updated_at": "2023-01-29T05:00:38.000000Z",
     *              "deleted_at": null
     *          },
     *      "message": "Question #7 retrieved"
     *    }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $question = Question::query()
            ->where('id', $id)
            ->find($id);

        if (!is_null($question) && $question->count() > 0) {
            $answer_list = [];
            $answers = json_decode($question['answer_set'], true);

            // Attach answers for this question
            foreach ($answers as $answer) {
                if ((int)$answer) {
                    $this_answer = Answer::query()
                        ->where('id', (int)$answer)
                        ->find((int)$answer);

                    array_push($answer_list, $this_answer);
                }
            }

            $question['answers'] = $answer_list;
            return $this->sendResponse($question, "Question #$id retrieved");
        }

        return $this->sendError("Question #$id not found");
    }

    /**
     * Create a new PLUMS question in the API
     *
     * @group QuestionAPI
     * @request POST
     * @urlParam http://localhost/api/questions/
     * @bodyParam question_text string Example: What is the answer to life, the universe and everything ??
     * @bodyParam answer_set array Example: [31, 32, 33]
     * @bodyParam points_value int Example: 5
     * @bodyParam is_available boolean Example: 1
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "question_text": "What is the answer to life, the universe and everything ??",
     *          "answer_set": "[31, 32, 33]",
     *          "points_value": "5",
     *          "is_available": "1",
     *          "updated_at": "2023-01-12T06:45:52.000000Z",
     *          "created_at": "2023-01-12T06:45:52.000000Z",
     *          "id": 11,
     *          "written_by": 2
     *      },
     *  "message": "New Question #11 created successfully"
     * }
     *
     * @param APIStoreQuestionValidation $request
     * @return JsonResponse
     */
    public function store(APIStoreQuestionValidation $request): JsonResponse
    {
        $validated = $request->validated();
        $question = Question::create($validated);

        // Validate answers entered to answer_set
        $question['answer_set'] = $this->validate_answers($validated['answer_set']);

        // Get ID of currently logged-in User and set as AuthorID of this Question
        $question['written_by'] = Auth::user()['id'];

        // Initialize operational variables
        $question['times_used'] = 0;
        $question['times_answered_correctly'] = 0;
        $question['times_answered_incorrectly'] = 0;
        $question->save();

        return $this->sendResponse(
            $question,
            "New Question #$question->id created successfully",
        );
    }

    /**
     * Search for PLUMS quiz questions where the text field matches search term
     *
     * @group QuestionAPI
     * @request GET
     * @urlParam http://localhost/api/questions/search
     * @bodyParams search string Example: SQL
     *
     * @response {
     *      "success": true,
     *      "data": [{
     *          "id": 2,
     *          "question_text": "Which of the following statements apply to SQL?",
     *          "answer_set": "[7, 12, 15, 20]",
     *          "points_value": 5,
     *          "is_available": 1,
     *          "written_by": 1,
     *          "times_used": 0,
     *          "times_answered_correctly": 0,
     *          "times_answered_incorrectly": 0,
     *          "answers": null,
     *          "created_at": "2023-01-10T08:25:27.000000Z",
     *          "updated_at": "2023-01-10T08:25:27.000000Z",
     *          "deleted_at": null
     *      },
     *      {
     *          "id": 6,
     *          "question_text": "What is the commonly known name for the NOSQL language developed by Facebook?",
     *          "answer_set": "[2, 6, 18]",
     *          "points_value": 1,
     *          "is_available": 1,
     *          "written_by": 1,
     *          "times_used": 0,
     *          "times_answered_correctly": 0,
     *          "times_answered_incorrectly": 0,
     *          "answers": null,
     *          "created_at": "2023-01-10T08:25:27.000000Z",
     *          "updated_at": "2023-01-10T08:25:27.000000Z",
     *          "deleted_at": null
     *      }],
     *  "message": "2 matching Questions retrieved"
     * }
     *
     * @param ValidateSearchRequest $request
     * @return JsonResponse
     */
    public function search(ValidateSearchRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!isset($validated['page'])) {
            $validated['page'] = 1;
        }

        if (!isset($validated['per_page'])) {
            $validated['per_page'] = 5;
        }

        $search_term = strtolower($request->get('search'));

        $matches = Question::query()
            ->where(Question::raw('lower(question_text)'), 'lIKE', "%$search_term%")
            ->get();

        if (!is_null($matches) && $matches->count() == 1) {
            return $this->sendResponse(
                $matches,
                $matches->count() . " matching Question retrieved",
            );
        } else {
            if (!is_null($matches) && $matches->count() > 1) {
                return $this->sendResponse(
                    $matches,
                    $matches->count() . " matching Questions retrieved",
                );
            }
        }

        return $this->sendError("No matching Questions found");
    }

    /**
     * Attribute-update of the properties of a Question in the API
     *
     * @group QuestionAPI
     * @request PATCH
     * @urlParam http://localhost/api/questions/5
     * @bodyParam answer_text string Example: This quiz will determine your knowledge of networks, servers and routers.
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 5,
     *          "question_text": "This quiz will determine your knowledge of networks, servers and routers.",
     *          "answer_set": "[28, 29]",
     *          "points_value": 0.5,
     *          "is_available": 1,
     *          "written_by": 2,
     *          "times_used": 1,
     *          "times_answered_correctly": 0,
     *          "times_answered_incorrectly": 0,
     *          "answers": null,
     *          "created_at": "2023-01-14T22:58:45.000000Z",
     *          "updated_at": "2023-01-15T06:37:46.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Question #5 updated successfully"
     * }
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_attribute(Request $request, int $id): JsonResponse
    {
        $question = Question::query()->where('id', $id)->first();

        $data = $request->input();
        $keyz = array_keys($data);

        if (empty($keyz)) {
            return $this->sendError("No field-keys entered");
        }

        extract($data);

        foreach ($keyz as $key) {
            if (isset($data[$key])) {

                // Allocate validation rules and messages for this field
                switch ($key) {
                    case "question_text":
                        $rules = [
                            'question_text' => 'string|min: 5|max: 512',
                        ];

                        $error_messages = [
                            'question_text.min' => 'Minimum length of a quiz Question is 5 characters.',
                            'question_text.max' => 'Maximum length of a quiz Question is 512 characters.',
                        ];
                        break;
                    case "answer_set":
                        $question['answer_set'] = $this->validate_answers($request['answer_set']);

                        $rules = [
                            'answer_set' => 'required|size: 2',
                        ];

                        $error_messages = [
                            'answer_set.required' => 'Please enter an array of AnswerIDs enclosed in [] brackets.',
                            'answer_set.size' => 'An answer-set for a Question requires at least 2 Answers.',
                        ];
                        break;
                    case "points_value":
                        $rules = [
                            'points_value' => 'min: 0.25',
                        ];

                        $error_messages = [
                            'points_value.min' => 'The \'points_value\' must be at least 0.25 points',
                        ];
                        break;
                    case "is_available":
                        $rules = [
                            'is_available' => 'boolean',
                        ];

                        $error_messages = [
                            'is_available.boolean' => 'A Boolean value is required to indicate if this Question is available for use in quizzes.',
                        ];
                        break;
                }

                // Validate input against rules relevant to the field
                $validated = Validator::make($data, $rules, $error_messages);

                if ($validated->fails()) {
                    return $this->sendError("Validation Errors");
                }

                // Update current field with validated data
                if (!$key == "answer_aet") $question[$key] = $data[$key];
            }
        }

        $question['updated_at'] = Carbon::now();
        $question->save();

        return $this->sendResponse(
            $question,
            "Question #$id updated successfully",
        );
    }

    /**
     * Block-update of all attributes of a PLUMS question in the API
     *
     * @group QuestionAPI
     * @request PUT
     * @urlParam http://localhost/api/questions/3
     * @bodyParam question_text string Example: What is the meaning of Life??
     * @bodyParam answer_set array Example: [1, 8, 9, 15]
     * @bodyParam points_value int Example: 3
     * @bodyParam is_available boolean Example: 1
     * @bodyParam written_by int Example: 2
     * @bodyParam times_used int Example: 4
     * @bodyParam times_answer_correctly int Example: 5
     * @bodyParam times_answer_incorrectly int Example: 15
     *
     * @response {
     *      "success": true,
     *      "data": {
     *      "id": 4,
     *          "question_text": "What is the meaning of Life ??",
     *          "answer_set": "[1, 8, 9, 15]",
     *          "points_value": "3",
     *          "is_available": "1",
     *          "written_by": "2",
     *          "times_used": "4",
     *          "times_answered_correctly": "5",
     *          "times_answered_incorrectly": "15",
     *          "answers": null,
     "          created_at": "2023-01-13T20:40:24.000000Z",
     *          "updated_at": "2023-01-13T23:01:09.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Question #4 updated successfully"
     * }
     *
     * @param APIUpdateQuestionValidation $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_all(APIUpdateQuestionValidation $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        $question = Question::query()->where('id', $id)->first();

        if (!is_null($question) && $question->count() > 0) {
            $question['question_text'] = $validated['question_text'];
            $question['answer_set'] = $this->validate_answers($validated['answer_set']);
            $question['points_value'] = $validated['points_value'];
            $question['is_available'] = $validated['is_available'];
            $question['written_by'] = $validated['written_by'];
            $question['times_used'] = $validated['times_used'];
            $question['times_answered_correctly'] = $validated['times_answered_correctly'];
            $question['times_answered_incorrectly'] = $validated['times_answered_incorrectly'];
            $question['updated_at'] = Carbon::now();
            $question->save();

            return $this->sendResponse(
                $question,
                "Question #$question->id updated successfully",
            );
        }

        return $this->sendError("Unable to update: Question #$id not found");
    }

    /**
     * Mark a PLUMS question record for deletion from storage (soft delete)
     *
     * @group QuestionAPI
     * @request DELETE
     * @urlParam http://localhost/api/questions/11
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 11,
     *          "question_text": "What is the answer to life, the universe and everything ??",
     *          "answer_set": "[31, 32, 33]",
     *          "points_value": 5,
     *          "is_available": 1,
     *          "written_by": null,
     *          "times_used": 0,
     *          "times_answered_correctly": 0,
     *          "times_answered_incorrectly": 0,
     *          "answers": null,
     *          "created_at": "2023-01-12T08:20:02.000000Z",
     *          "updated_at": "2023-01-12T08:44:19.000000Z",
     *          "deleted_at": "2023-01-12T08:44:19.000000Z"
     *      },
     *  "message": "Question #11 has been marked for deletion"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $question = Question::query()->where('id', $id)->first();
        $destroyedQuestion = $question;
        $question_exists = false;
        $quizzes = Quiz::all();

        if (!$question) {
            return $this->sendError("Unable to delete: Question #$id not found");
        }

        // Check if question exists in any quizzes before deletion
        foreach ($quizzes as $quiz) {
            $existing = explode(",", $quiz['question_set']);

            foreach ($existing as $selected) {

                if ($question->id == (int)$selected) {
                    $question_exists = true;
                    break(2);
                }
            }
        }

        if ($question_exists) {
            return $this->sendError("Unable to delete: Question #$id is being used in a Quiz");
        }

        $question->delete();

        return $this->sendResponse(
            $destroyedQuestion,
            "Question #$id has been marked for deletion",
        );
    }

    /**
     * Helper function used to validate the existence of an Answer to be used for a Question
     *
     * @param string $answer_set
     * @return string
     */
    public function validate_answers(String $answer_set): string
    {
        $answer_list = json_decode($answer_set, true);

        // Check availability of each selected question
        foreach ($answer_list as $answer_number) {
            $answer = Answer::query()->where('id', $answer_number)->find($answer_number);

            if (!$answer) {
                // Remove unavailable answer from the answer_set
                if (($key = array_search($answer_number, $answer_list)) !== false) {
                    array_splice($answer_list, $key, 1);
                }
            }
        }

        return json_encode($answer_list, true);
    }
}
