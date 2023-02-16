<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\APIUpdateQuizValidation;
use App\Models\Question;
use App\Models\Quiz;
use App\Http\Requests\APIStoreQuizValidation;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ValidateSearchRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @method sendError(string $string)
 * @method sendResponse(LengthAwarePaginator $quizzes, string $string)
 */
class QuizAPIController extends APIBaseController
{
    /**
     * Display a list of available quizzes for the API
     *
     * @group QuizAPI
     * @request GET
     * @urlParam http://localhost/api/quizzes/
     * @bodyParam page integer Example: 1
     * @bodyParam per_page integer Example: 6
     *
     * @reponse {
     *      "success": true,
     *      "data": {
     *          "current_page": 1,
     *          "data": [{
     *                   "id": 1,
     *              "title": "Quiz One",
     *              "description": "BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES",
     *              "question_set": "[1, 4, 7, 9]",
     *              "level_id": 1,
     *              "field_id": 2,
     *              "skill_id": 11,
     *              "is_available": 1,
     *              "prepared_by": 1,
     *              "times_attempted": 9,
     *              "fastest_time": "00:03:45",
     *              "average_time": "00:05:00",
     *              "questions": null,
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 2,
     *              "title": "Quiz Two",
     *              "description": "BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES",
     *              "question_set": "[1, 3, 5, 6]",
     *              "level_id": 1,
     *              "field_id": 7,
     *              "skill_id": 5,
     *              "is_available": 1,
     *              "prepared_by": 1,
     *              "times_attempted": 12,
     *              "fastest_time": "00:03:45",
     *              "average_time": "00:05:00",
     *              "questions": null,
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 3,
     *              "title": "Quiz Three",
     *              "description": "BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES",
     *              "question_set": "[2, 3, 7, 8]",
     *              "level_id": 5,
     *              "field_id": 4,
     *              "skill_id": 11,
     *              "is_available": 1,
     *              "prepared_by": 1,
     *              "times_attempted": 4,
     *              "fastest_time": "00:03:45",
     *              "average_time": "00:05:00",
     *              "questions": null,
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *         }],
     *      },
     *   "message": "Total of 3 Quizzes retrieved"
     *  }
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

        $quizzes = Quiz::paginate($validated["per_page"]);

        if (!is_null($quizzes) && $quizzes->count() == 1) {
            return $this->sendResponse(
                $quizzes,
                "{$quizzes->count()} Quiz retrieved",
            );
        } else {
            if (!is_null($quizzes) && $quizzes->count() > 1) {
                json_encode($quizzes['answers']);

                return $this->sendResponse(
                    $quizzes,
                    "Total of {$quizzes->count()} Quizzes retrieved",
                );
            }
        }

        return $this->sendError("No Quizzes found");
    }

    /**
     * Display data on a quiz record
     *
     * @group QuizAPI
     * @request GET
     * @urlParam http://localhost/api/quizzes/3
     *
     * @response {
     *      "success": true,
     *      "data": [{
     *          "id": 3,
     *          "title": "Quiz Three",
     *          "description": "BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES",
     *          "question_set": "[2, 3, 7, 8]",
     *          "level_id": 5,
     *          "field_id": 4,
     *          "skill_id": 11,
     *          "is_available": 1,
     *          "prepared_by": 1,
     *          "times_attempted": 0,
     *          "fastest_time": "00:03:45",
     *          "average_time": "00:05:00",
     *          "questions": [
     *          {
     *              "id": 2,
     *              "question_text": "Which of the following statements apply to SQL?",
     *              "answer_set": "[7, 12, 15, 20]",
     *              "points_value": 5,
     *              "is_available": 1,
     *              "written_by": 1,
     *              "times_used": 0,
     *              "times_answered_correctly": 0,
     *              "times_answered_incorrectly": 0,
     *              "answers": null,
     *              "created_at": "2023-01-09T10:46:59.000000Z",
     *              "updated_at": "2023-01-09T10:46:59.000000Z",
     *              "deleted_at": null
     *              },
     *              {
     *              "id": 3,
     *              "question_text": "Which of the following statements are true of the term "Client Business Domain"?",
     *              "answer_set": "[3, 5, 10, 13, 17, 22]",
     *              "points_value": 2.5,
     *              "is_available": 1,
     *              "written_by": 1,
     *              "times_used": 0,
     *              "times_answered_correctly": 0,
     *              "times_answered_incorrectly": 0,
     *              "answers": null,
     *              "created_at": "2023-01-09T10:46:59.000000Z",
     *              "updated_at": "2023-01-09T10:46:59.000000Z",
     *              "deleted_at": null
     *              },
     *              {
     *              "id": 7,
     *              "question_text": "There are many terms relating to security with regards to the Web. Which of the following statements are most appropriate to define Authentication?",
     *              "answer_set": "[11, 19, 25]",
     *              "points_value": 0.5,
     *              "is_available": 1,
     *              "written_by": 1,
     *              "times_used": 0,
     *              "times_answered_correctly": 0,
     *              "times_answered_incorrectly": 0,
     *              "answers": null,
     *              "created_at": "2023-01-09T10:46:59.000000Z",
     *              "updated_at": "2023-01-09T10:46:59.000000Z",
     *              "deleted_at": null
     *              },
     *              {
     *              "id": 8,
     *              "question_text": "When the data contained in a database is mainly used for read-based processes, which of the following may be used to improve performance?",
     *              "answer_set": "[23, 24]",
     *              "points_value": 5,
     *              "is_available": 1,
     *              "written_by": 1,
     *              "times_used": 0,
     *              "times_answered_correctly": 0,
     *              "times_answered_incorrectly": 0,
     *              "answers": null,
     *              "created_at": "2023-01-09T10:46:59.000000Z",
     *              "updated_at": "2023-01-09T10:46:59.000000Z",
     *              "deleted_at": null
     *              }]
     *          "created_at": "2023-01-09T10:46:59.000000Z",
     *          "updated_at": "2023-01-09T10:46:59.000000Z",
     *          "deleted_at": null
     *        ],
     *    "message": "Quiz #3 retrieved"
     *  }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $quiz = Quiz::query()
            ->where('id', $id)
            //->with('questions') // NOTE: content-makers and above
            //->with('answers')->where('is_correct', True) // NOTE: content-makers and above
            //->with('attempts')
            ->find($id);

        if (!is_null($quiz) && $quiz->count() > 0) {
            $question_list = [];
            $questions = json_decode($quiz['question_set'], true);

            // Attach questions for this quiz
            foreach ($questions as $question) {
                if ((int)$question) {
                    $this_question = Question::query()
                        ->where('id', (int)$question)
                        ->find((int)$question);

                    array_push($question_list, $this_question);
                }
            }

            $quiz['questions'] = $question_list;
            return $this->sendResponse($quiz, "Quiz #$id retrieved");
        }

        return $this->sendError("Quiz #$id not found");
    }

    /**
     * Create a new quiz in the API
     *
     * @group QuizAPI
     * @request POST
     * @urlParam http://localhost/api/quizzes/
     * @bodyParam title string Example: Yet Another Quiz
     * @bodyParam description string Example: This multiple-choice quiz will test your current knowledge about popular literature.
     * @bodyParam question_set array Example: [4, 5, 10, 11]
     * @bodyParam level_id int Example: 3
     * @bodyParam field_id int Example: 5
     * @bodyParam skill_id int Example: 4
     * @bodyParam is_available boolean Example: 1
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "title": "Yet Another Quiz",
     *          "description": "This multiple-choice quiz will test your current knowledge about popular literature.",
     *          "question_set": "[4, 5, 10, 11]",
     *          "level_id": "3",
     *          "field_id": "5",
     *          "skill_id": "4",
     *          "is_available": "0",
     *          "updated_at": "2023-01-12T07:53:46.000000Z",
     *          "created_at": "2023-01-12T07:53:46.000000Z",
     *          "id": 5,
     *          "prepared_by": 5
     *      },
     *  "message": "New Quiz #5 created successfully"
     * }
     *
     * @param APIStoreQuizValidation $request
     * @return JsonResponse
     */
    public function store(APIStoreQuizValidation $request): JsonResponse
    {
        $validated = $request->validated();
        $quiz = Quiz::create($validated);

        // Validate questions entered to question_set
        $quiz['question_set'] = $this->validate_questions($quiz['question_set']);

        // Get ID of currently logged-in User and set as AuthorID of this Quiz
        $quiz['prepared_by'] = Auth::user()['id'];

        // Initialize operational variables
        $quiz['times_attempted'] = 0;
        $quiz['fastest_time'] = "00:00:00";
        $quiz['average_time'] = "00:00:00";
        $quiz->save();

        return $this->sendResponse(
            $quiz,
            "New Quiz #$quiz->id created successfully",
        );
    }

    /**
     * Search for quiz records where title or description field matches search term
     *
     * @group QuizAPI
     * @request GET
     * @urlParam http://localhost/api/quizzes/search
     * @bodyParams search string Example: Programming
     *
     * @response {
     *      "success": true,
     *      "data": [
     *      {
     *          "id": 1,
     *          "title": "Quiz One",
     *          "description": "Quiz 1 will test your knowledge of programming at an intermediate level.",
     *          "question_set": "[1, 4, 7, 9]",
     *          "level_id": 1,
     *          "field_id": 2,
     *          "skill_id": 11,
     *          "is_available": 1,
     *          "prepared_by": 1,
     *          "times_attempted": 0,
     *          "fastest_time": "00:03:45",
     *          "average_time": "00:05:00",
     *          "questions": null,
     *          "created_at": "2023-01-10T10:26:06.000000Z",
     *          "updated_at": "2023-01-10T10:26:06.000000Z",
     *          "deleted_at": null
     *      }],
     *  "message": "1 matching Quiz retrieved"
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

        $matches = Quiz::query()
            ->where(Quiz::raw('lower(title)'), 'lIKE', "%$search_term%")
            ->orWhere(Quiz::raw('lower(description)'), 'LIKE', "%$search_term%")
            ->get();

        if (!is_null($matches) && $matches->count() == 1) {
            return $this->sendResponse(
                $matches,
                $matches->count() . " matching Quiz retrieved",
            );
        } else {
            if (!is_null($matches) && $matches->count() > 1) {
                return $this->sendResponse(
                    $matches,
                    $matches->count() . " matching Quizzes retrieved",
                );
            }
        }

        return $this->sendError("No matching Quizzes found");
    }

    /**
     * Attribute-update of the properties of a Quiz in the API
     *
     * @group QuizAPI
     * @request PATCH
     * @urlParam http://localhost/api/quizzes/5
     * @bodyParam title string Example: Programming knowledge-based Quiz.
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 5,
     *          "title": "Programming knowledge-based Quiz",
     *          "description": "This multiple-choice quiz will test your current knowledge about popular literature.",
     *          "question_set": "[4, 5, 10, 11]",
     *          "level_id": 3,
     *          "field_id": 5,
     *          "skill_id": 4,
     *          "is_available": 0,
     *          "prepared_by": 6,
     *          "times_attempted": 0,
     *          "fastest_time": "00:00:00",
     *          "average_time": "00:00:00",
     *          "questions": null,
     *          "created_at": "2023-01-15T02:02:11.000000Z",
     *          "updated_at": "2023-01-15T07:37:42.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Quiz #5 updated successfully"
     * }
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_attribute(Request $request, int $id): JsonResponse
    {
        $quiz = Quiz::query()->where('id', $id)->first();
        $data = $request->input();
        $keyz = array_keys($data);

        $error_list = [];
        $has_errors = False;

        if (empty($keyz)) {
            return $this->sendError("No field-keys entered");
        }

        extract($data);

        foreach ($keyz as $key) {
            if (isset($data[$key])) {

                // Allocate validation rules and messages for this field
                switch ($key) {
                    case "title":
                        $rules = [
                            'required',
                            'unique:quizzes,title',
                            'title' => 'min: 5|max: 128',
                        ];

                        $error_messages = [
                            'title.required' => 'A Quiz title is required.',
                            'title.unique' => 'A unique Quiz title is required',
                            'title.min' => 'Minimum length of a Quiz title is 5 characters.',
                            'title.max' => 'Maximum length of a Quiz title is 128 characters.',
                        ];
                        break;
                    case "description":
                        $rules = [
                            'required',
                            'description' => 'min: 10|max: 512',
                        ];

                        $error_messages = [
                            'description.required' => 'A description of thw Quiz is required.',
                            'description.min' => 'Minimum length of Quiz description is 10 characters.',
                            'description.max' => 'Maximum length of Quiz description is 512 characters.',
                        ];
                        break;
                    case "question_set":
                        $quiz['question_set'] = $this->validate_questions($request['question_set']);
                        //$question_count = $this->validate_questions($request['question_set'], true);

                        $rules = [
                            'question_set' => 'required|min: 4',
                        ];

                        $error_messages = [
                            'question_set.required' => 'Please enter an array of QuestionIDs enclosed in [] brackets.',
                            'question_set.min' => 'A question-set for a Quiz requires at least 4 Questions.',
                        ];
                        break;
                    case "level_id":
                        $rules = [
                            'level_id' => 'exists:levels,id',
                        ];

                        $error_messages = [
                            'level_id.exists' => 'The levelID does not exist.'
                        ];
                        break;
                    case "field_id":
                        $rules = [
                            'field_id' => 'exists:fields,id',
                        ];

                        $error_messages = [
                            'field_id.exists' => 'The FieldID does not exist.'
                        ];
                        break;
                    case "skill_id":
                        $rules = [
                            'skill_id' => 'exists:skills,id',
                        ];

                        $error_messages = [
                            'skill_id.exists' => 'The SkillID does not exist.'
                        ];
                        break;
                }

                // Validate input against rules relevant to the field. Store results in error_list
                $validated = Validator::make($data, $rules, $error_messages);

                if ($validated->fails()) {
                    array_push($error_list, $error_messages);
                    $has_errors = True;
                }

                // Update current field with validated data
                if (!$key == "question_aet") $quiz[$key] = $data[$key];
            }
        }

        if ($has_errors) {
            return $this->sendError($error_list);
        }

        $quiz['updated_at'] = Carbon::now();
        $quiz->save();

        return $this->sendResponse(
            $quiz,
            "Quiz #$id updated successfully",
        );
    }

    /**
     * Block-update of all attributes of a quiz in the API
     *
     * @group QuizAPI
     * @request PUT
     * @urlParam http://localhost/api/quizzes/4
     * @bodyParam title string Example: Some Quiz created for Testing
     * @bodyParam description string Example: BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES
     * @bodyParam question_set array Example: [4, 5, 7, 11]
     * @bodyParam level_id int Example: 3
     * @bodyParam field_id int Example: 7
     * @bodyParam skill_id int Example: 8
     * @bodyParam is_available boolean Example: 0
     * @bodyParam prepared_by int Example: 2
     * @bodyParam times_attempted int Example: 7
     * @bodyParam fastest_time time Example: 00:10:15
     * @bodyParam average_time time Example: 00:15:25
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 4,
     *          "title": "Some Quiz created for Testing",
     *          "description": "BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES",
     *          "question_set": "[4, 5, 7, 11]",
     *          "level_id": "3",
     *          "field_id": "7",
     *          "skill_id": "8",
     *          "is_available": "0",
     *          "prepared_by": "2",
     *          "times_attempted": "7",
     *          "questions": null,
     *          "fastest_time": "00:10:15",
     *          "average_time": "00:15:25",
     *          "created_at": "2023-01-13T20:40:24.000000Z",
     *          "updated_at": "2023-01-14T00:23:51.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Quiz #4 updated successfully"
     * }
     *
     * @param APIUpdateQuizValidation $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_all(APIUpdateQuizValidation $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        $quiz = Quiz::query()->where('id', $id)->first();

        if (!is_null($quiz) && $quiz->count() > 0) {
            $quiz['title'] = $validated['title'];
            $quiz['description'] = $validated['description'];
            $quiz['question_set'] = $this->validate_questions($validated['question_set']);
            $quiz['level_id'] = $validated['level_id'];
            $quiz['field_id'] = $validated['field_id'];
            $quiz['skill_id'] = $validated['skill_id'];
            $quiz['is_available'] = $validated['is_available'];
            $quiz['prepared_by'] = $validated['prepared_by'];
            $quiz['times_attempted'] = $validated['times_attempted'];
            $quiz['fastest_time'] = $validated['fastest_time'];
            $quiz['average_time'] = $validated['average_time'];
            $quiz['updated_at'] = Carbon::now();
            $quiz->save();

            return $this->sendResponse(
                $quiz,
                "Quiz #$quiz->id updated successfully",
            );
        }

        return $this->sendError("Unable to update: Quiz #$id not found");
    }

    /**
     * Mark a quiz record for deletion from storage (soft delete)
     *
     * @group QuizAPI
     * @request DELETE
     * @urlParam http://localhost/api/quizzes/6
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 6,
     *          "title": "Yet Another Quiz",
     *          "description": "This multiple-choice quiz will test your current knowledge about popular literature.",
     *          "question_set": "[4, 5, 10, 11]",
     *          "level_id": 3,
     *          "field_id": 5,
     *          "skill_id": 4,
     *          "is_available": 0,
     *          "prepared_by": null,
     *          "times_attempted": 0,
     *          "fastest_time": null,
     *          "average_time": null,
     *          "questions": null,
     *          "created_at": "2023-01-12T08:23:17.000000Z",
     *          "updated_at": "2023-01-12T08:23:17.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Quiz #6 has been marked for deletion"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $quiz = Quiz::query()->where('id', $id)->first();
        $destroyedQuiz = $quiz;

        if (!is_null($quiz) && $quiz->count() > 0) {
            $quiz->delete();

            return $this->sendResponse(
                $destroyedQuiz,
                "Quiz #$id has been marked for deletion",
            );
        }

        return $this->sendError("Unable to delete: Quiz #$id not found");
    }

    /**
     * Helper function used to validate the availability of the Questions to be used for a Quiz
     * NOTE: Adding a True parameter to the function call returns a count of the question_set
     *
     * @param string $question_set
     * @param bool $flag
     * @return string|int
     */
    public function validate_questions(string $question_set, Bool $flag = False): string|int
    {
        $question_list = json_decode($question_set, true);

        // Check availability of each selected question
        foreach ($question_list as $question_number) {
            $question = Question::query()
                ->where('id', $question_number)
                ->where('is_available', True)
                ->find($question_number);

            if (!$question) {
                // Remove unavailable question from the question_set
                if (($key = array_search($question_number, $question_list)) !== false) {
                    array_splice($question_list, $key, 1);
                } else {
                    // Increment 'question_used' counter for each Question used in this Quiz
                    $question['times_used'] += 1;
                    $question->save();
                }
            }
        }

        // Return count of valid questions
        if ($flag) {
            return count($question_list);
        }

        // Return validated question list
        return json_encode($question_list, true);
    }
}
