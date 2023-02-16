<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\APIAnswerValidation;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ValidateSearchRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

/**
 * @method sendResponse(LengthAwarePaginator $answers, string $string)
 * @method sendError(string $string)
 */
class AnswerAPIController extends APIBaseController
{
    /**
     * Display a list of answers to questions in the API
     *
     * @group AnswerAPI
     * @request GET
     * @urlParam http://localhost/api/answers/
     * @bodyParam page integer Example: 1
     * @bodyParam per_page integer Example: 4
     *
     * @reponse {
     *      "success": true,
     *      "data": {
     *          "current_page": 1,
     *          "data": [{
     *              "id": 1,
     *              "answer_text": "OOP stands for Object-Oriented Programming",
     *              "is_correct": 1,
     *              "created_at": "2023-01-06T06:43:16.000000Z",
     *              "updated_at": "2023-01-06T06:43:16.000000Z",
     *              "deleted_at": null
     *           },
     *           {
     *              "id": 2,
     *              "answer_text": "MetaverseQL",
     *              "is_correct": 0,
     *              "created_at": "2023-01-06T06:43:16.000000Z",
     *              "updated_at": "2023-01-06T06:43:16.000000Z",
     *              "deleted_at": null
     *           },
     *           {
     *              "id": 3,
     *              "answer_text": "The domain is the core business of the client",
     *              "is_correct": 1,
     *              "created_at": "2023-01-06T06:43:16.000000Z",
     *              "updated_at": "2023-01-06T06:43:16.000000Z",
     *              "deleted_at": null
     *           },
     *           {
     *              "id": 4,
     *              "answer_text": "OOP places heavy emphasis on modularised coding",
     *              "is_correct": 1,
     *              "created_at": "2023-01-06T06:43:16.000000Z",
     *              "updated_at": "2023-01-06T06:43:16.000000Z",
     *              "deleted_at": null
     *           }],
     *        }
     *  "message": "Total of 4 Answers retrieved"
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

        $answers = Answer::paginate($validated["per_page"]);

        if (!is_null($answers) && $answers->count() == 1) {
            return $this->sendResponse(
                $answers,
                "{$answers->count()} Answer retrieved",
            );
        } else {
            if (!is_null($answers) && $answers->count() > 1) {
                return $this->sendResponse(
                    $answers,
                    "Total of {$answers->count()} Answers retrieved",
                );
            }
        }

        return $this->sendError("No Answers found");
    }

    /**
     * Display data on an answer in the API
     *
     * @group AnswerAPI
     * @request GET
     * @urlParam http://localhost/api/answers/8
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 8,
     *          "answer_text": "Heavy Traffic Transport Packaging System",
     *          "is_correct": 0,
     *          "created_at": "2023-01-06T23:12:08.000000Z",
     *          "updated_at": "2023-01-06T23:12:08.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Answer #8 retrieved"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $answer = Answer::query()
            ->where('id', $id)
            ->find($id);

        if (!is_null($answer) && $answer->count() > 0) {
            return $this->sendResponse(
                $answer,
                "Answer #$id retrieved",
            );
        }

        return $this->sendError("Answer #$id not found");
    }

    /**
     * Create a new answer in the API
     *
     * @group AnswerAPI
     * @request POST
     * @urlParam http://localhost/api/answers/
     * @bodyParam ??? integer Example:
     * @bodyParam answer_text string Example: Forty-two
     * @bodyParam is_correct boolean Example: 1
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "answer_text": "Forty-four",
     *          "is_correct": "1",
     *          "updated_at": "2023-01-11T08:47:45.000000Z",
     *          "created_at": "2023-01-11T08:47:45.000000Z",
     *          "id": 31
     *      },
     *  "message": "New Answer #31 created successfully"
     * }
     *
     * @param APIAnswerValidation $request
     * @return JsonResponse
     */
    public function store(APIAnswerValidation $request): JsonResponse
    {
        $validated = $request->validated();
        $answer = Answer::create($validated);

        return $this->sendResponse(
            $answer,
            "New Answer #$answer->id created successfully",
        );
    }

    /**
     * Search for answers where text field matches search term
     *
     * @group AnswerAPI
     * @request GET
     * @urlParam http://localhost/api/answers/search
     * @bodyParams search string Example: OOP
     *
     * @response {
     *      "success": true,
     *      "data": [{
     *          "id": 1,
     *          "answer_text": "OOP stands for Object-Oriented Programming",
     *          "is_correct": 1,
     *          "created_at": "2023-01-10T08:25:27.000000Z",
     *          "updated_at": "2023-01-10T08:25:27.000000Z",
     *          "deleted_at": null
     *      },
     *      {
     *          "id": 4,
     *          "answer_text": "OOP places heavy emphasis on modularised coding",
     *          "is_correct": 1,
     *          "created_at": "2023-01-10T08:25:27.000000Z",
     *          "updated_at": "2023-01-10T08:25:27.000000Z",
     *          "deleted_at": null
     *      },
     *      {
     *          "id": 9,
     *          "answer_text": "OOP uses classes, methods and properties",
     *          "is_correct": 1,
     *          "created_at": "2023-01-10T08:25:27.000000Z",
     *          "updated_at": "2023-01-10T08:25:27.000000Z",
     *          "deleted_at": null
     *      },
     *      {
     *          "id": 14,
     *          "answer_text": "OOP places heavy emphasis on functional coding",
     *          "is_correct": 0,
     *          "created_at": "2023-01-10T08:25:27.000000Z",
     *          "updated_at": "2023-01-10T08:25:27.000000Z",
     *          "deleted_at": null
     *      },
     *      {
     *          "id": 16,
     *          "answer_text": "OOP stands for Optional-Object Progression",
     *          "is_correct": 0,
     *          "created_at": "2023-01-10T08:25:27.000000Z",
     *          "updated_at": "2023-01-10T08:25:27.000000Z",
     *          "deleted_at": null
     *      }],
     *    "message": "5 matching Answers retrieved"
     *  }
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

        $matches = Answer::query()
            ->where(Answer::raw('lower(answer_text)'), 'lIKE', "%$search_term%")
            ->get();

        if (!is_null($matches) && $matches->count() == 1) {
            return $this->sendResponse(
                $matches,
                $matches->count() . " matching Answer retrieved",
            );
        } else {
            if (!is_null($matches) && $matches->count() > 1) {
                return $this->sendResponse(
                    $matches,
                    $matches->count() . " matching Answers retrieved",
                );
            }
        }

        return $this->sendError("No matching Answers found");
    }

    /**
     * Attribute-update of the properties of an Answer in the API
     *
     * @group AnswerAPI
     * @request PATCH
     * @urlParam http://localhost/api/answers/32
     * @bodyParam answer_text string Example: Forty-three
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 32,
     *          "answer_text": "Forty-three",
     *          "created_at": "2023-01-14T23:06:21.000000Z",
     *          "updated_at": "2023-01-15T05:21:14.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Answer #32 updated successfully"
     * }
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
    */
    public function update_attribute(Request $request, int $id): JsonResponse
    {
        $answer = Answer::query()->where('id', $id)->first();

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
                    case "answer_text":
                        $rules = [
                            'answer_text' => 'string| min: 5| max: 256',
                        ];

                        $error_messages = [
                            'answer_text.string' => 'A text-string for the Answer is required.',
                            'answer_text.min' => 'Minimum length of a quiz Answer is 5 characters.',
                            'answer_text.max' => 'Maximum length of a quiz Answer is 256 characters.',
                        ];
                        break;
                    case "is_correct":
                        $rules = [
                            'is_correct' => 'boolean',
                        ];

                        $error_messages = [
                            'is_correct.boolean' => 'A Boolean value is required to indicate if this answer is correct.',
                        ];
                        break;
                }

                // Validate input against rules relevant to the field
                $validated = Validator::make($data, $rules, $error_messages);

                if ($validated->fails()) {
                    return $this->sendError("Validation Errors");
                }

                // Update current field with validated data
                $answer[$key] = $data[$key];
            }
        }

        $answer['updated_at'] = Carbon::now();
        $answer->save();

        return $this->sendResponse(
            $answer,
            "Answer #$id updated successfully",
        );
    }

    /**
     * Block-update of all attributes of an answer in the API
     *
     * @group AnswerAPI
     * @request PUT
     * @urlParam http://localhost/api/answers/32
     * @bodyParam answer_text string Example: Forty-three
     * @bodyParam is_correct boolean Example: 0
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 32,
     *          "answer_text": "Forty-two",
     *          "is_correct": "1",
     *          "created_at": "2023-01-13T13:04:31.000000Z",
     *          "updated_at": "2023-01-13T15:50:00.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Answer #32 updated successfully"
     * }
     *
     * @param APIAnswerValidation $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_all(APIAnswerValidation $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        $answer = Answer::query()->where('id', $id)->first();

        if (!is_null($answer) && $answer->count() > 0) {
            $answer['answer_text'] = $validated['answer_text'];
            $answer['is_correct'] = $validated['is_correct'];
            $answer['updated_at'] = Carbon::now();
            $answer->save();

            return $this->sendResponse(
                $answer,
                "Answer #$id updated successfully",
            );
        }

        return $this->sendError("Unable to update: Answer #$id not found");
    }

    /**
     * Mark an answer record for deletion from storage (soft delete)
     *
     * @group AnswerAPI
     * @request DELETE
     * @urlParam http://localhost/api/answers/3
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 3,
     *          "answer_text": "The domain is the core business of the client",
     *          "is_correct": 1,
     *          "created_at": "2023-01-12T07:52:18.000000Z",
     *          "updated_at": "2023-01-12T08:36:22.000000Z",
     *          "deleted_at": "2023-01-12T08:36:22.000000Z"
     *      },
     *  "message": "Answer #3 has been marked for deletion"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $answer = Answer::query()->where('id', $id)->first();
        $destroyedAnswer = $answer;
        $answer_exists = false;
        $questions = Question::all();

        // Check if answer exists in any quizzes before deletion
        foreach ($questions as $question) {
            $existing = explode(",", $question['answer_set']);

             foreach ($existing as $selected) {

                 if ($answer->id == (int)$selected) {
                     $answer_exists = true;
                     break(2);
                 }
             }
        }

        if ($answer_exists) {
            return $this->sendError("Unable to delete: Answer #$id is being used in a Quiz");
        } else {
            if (!is_null($answer) && $answer->count() > 0) {
                $answer->delete();

                return $this->sendResponse(
                    $destroyedAnswer,
                    "Answer #$id has been marked for deletion",
                );
            }

            return $this->sendError("Unable to delete: Answer #$id not found");
        }
    }
}
