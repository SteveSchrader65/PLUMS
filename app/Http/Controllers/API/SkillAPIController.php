<?php

namespace App\Http\Controllers\API;

use App\Models\Quiz;
use App\Models\Skill;
use App\Http\Requests\APISkillValidation;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ValidateSearchRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

/**
 * @method sendResponse(LengthAwarePaginator $skills, string $string)
 * @method sendError(string $string)
 */
class SkillAPIController extends APIBaseController
{
    /**
     * Display a list of skills in the API
     *
     * @group SkillAPI
     * @request GET
     * @urlParam http://localhost/api/skills/
     * @bodyParam page integer Example: 2
     * @bodyParam per_page integer Example: 3
     *
     * @reponse {
     *      "success": true,
     *      "data": {
     *          "current_page": 2,
     *          "data": [{
     *              "id": 4,
     *              "name": "Counselling",
     *              "description": "ENTER DESCRIPTION HERE",
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 5,
     *              "name": "Auslan",
     *              "description": "ENTER DESCRIPTION HERE",
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 6,
     *              "name": "Fashion Design",
     *              "description": "ENTER DESCRIPTION HERE",
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *           }],
     *       },
     *    message": "Total of 3 Skills retrieved"
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

        $skills = Skill::paginate($validated["per_page"]);

        if (!is_null($skills) && $skills->count() == 1) {
            return $this->sendResponse(
                $skills,
                "{$skills->count()} Skill retrieved",
            );
        } else {
            if (!is_null($skills) && $skills->count() > 1) {
                return $this->sendResponse(
                    $skills,
                    "Total of {$skills->count()} Skills retrieved",
                );
            }
        }

        return $this->sendError("No Skills found");
    }

    /**
     * Display data on a skill record
     *
     * @group SkillAPI
     * @request GET
     * @urlParam http://localhost/api/skills/11
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 11,
     *          "name": "Business Management",
     *          "description": "ENTER DESCRIPTION HERE",
     *          "created_at": "2023-01-06T23:12:08.000000Z",
     *          "updated_at": "2023-01-06T23:12:08.000000Z",
     *          "deleted_at": null,
     *          "field": null,
     *          "quiz": [{
     *              "id": 1,
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
     *              "created_at": "2023-01-06T23:12:08.000000Z",
     *              "updated_at": "2023-01-06T23:12:08.000000Z",
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
     *              "created_at": "2023-01-06T23:12:08.000000Z",
     *              "updated_at": "2023-01-06T23:12:08.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 4,
     *              "title": "Quiz Four",
     *              "description": "BRIEF DESCRIPTION OF QUIZ TOPIC AND RULES",
     *              "question_set": "[3, 4, 6, 10]",
     *              "level_id": 4,
     *              "field_id": 5,
     *              "skill_id": 11,
     *              "is_available": 1,
     *              "prepared_by": 1,
     *              "times_attempted": 4,
     *              "fastest_time": "00:03:45",
     *              "average_time": "00:05:00",
     *              "created_at": "2023-01-06T23:12:08.000000Z",
     *              "updated_at": "2023-01-06T23:12:08.000000Z",
     *              "deleted_at": null
     *          }
     *       ]},
     *   "message": "Skill #11 retrieved"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $skill = Skill::query()
            ->where('id', $id)
            ->with('quizzes')
            ->find($id);

        if (!is_null($skill) && $skill->count() > 0) {
            return $this->sendResponse(
                $skill,
                "Skill #$id retrieved",
            );
        }

        return $this->sendError("Skill #$id not found");
    }

    /**
     * Create a new skill area in the API
     *
     * @group SkillAPI
     * @request POST
     * @urlParam http://localhost/api/skills/
     * @bodyParam name string Example: Robotics
     * @bodyParam description string Example: Studies in Robotics incorporates engineering skills and computing.
     * @bodyParam field_id integer Example: 4
     * @response {
     *      "success": true,
     *      "data": {
     *          "name": "Robotics",
     *          "description": "Studies in Robotics incorporates engineering and computing skills.",
     *          "field_id": "4",
     *          "updated_at": "2023-01-29T12:29:01.000000Z",
     *          "created_at": "2023-01-29T12:29:01.000000Z",
     *          "id": 13
     *      },
     *  "message": "New Skill #13 created successfully"
     * }
     *
     * @param APISkillValidation $request
     * @return JsonResponse
     */
    public function store(APISkillValidation $request): JsonResponse
    {
        $validated = $request->validated();
        $skill = Skill::create($validated);

        return $this->sendResponse(
            $skill,
            "New Skill #$skill->id created successfully",
        );
    }

    /**
     * Search for skill records where name or description field matches search term
     *
     * @group SkillAPI
     * @request GET
     * @urlParam http://localhost/api/skills/search
     * @bodyParams search string Example: Business
     *
     * @response {
     *      "success": true,
     *      "data": [{
     *          "id": 11,
     *          "name": "Business Management",
     *          "description": "ENTER DESCRIPTION HERE",
     *          "field_id": 5,
     *          "created_at": "2023-01-10T10:26:05.000000Z",
     *          "updated_at": "2023-01-10T10:26:05.000000Z",
     *          "deleted_at": null
     *      }],
     *  "message": "1 matching Skill retrieved"
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

        $matches = Skill::query()
            ->where(Skill::raw('lower(name)'), 'lIKE', "%$search_term%")
            ->orWhere(Skill::raw('lower(description)'),  'LIKE', "%$search_term%")
            ->get();

        if (!is_null($matches) && $matches->count() == 1) {
            return $this->sendResponse(
                $matches,
                $matches->count() . " matching Skill retrieved",
            );
        } else {
            if (!is_null($matches) && $matches->count() > 1) {
                return $this->sendResponse(
                    $matches,
                    $matches->count() . " matching Skills retrieved",
                );
            }
        }

        return $this->sendError("No matching Skills found");
    }

    /**
     * Attribute-update of the properties of a Skill in the API
     *
     * @group SkillAPI
     * @request PATCH
     * @urlParam http://localhost/api/skills/5
     * @bodyParam name string Example:Media Studies
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 5,
     *          "name": "Media Studies",
     *          "description": "ENTER DESCRIPTION HERE",
     *          "field_id": 7,
     *          "created_at": "2023-01-14T22:58:45.000000Z",
     *          "updated_at": "2023-01-15T08:04:42.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Skill #5 updated successfully"
     * }
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_attribute(Request $request, int $id): JsonResponse
    {
        $skill = Skill::query()->where('id', $id)->first();

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
                    case "name":
                        $rules = [
                            'name' => 'min: 3|max: 32',
                        ];

                        $error_messages = [
                            'name.min' => 'Minimum length of a Skill name is 3 characters.',
                            'name.max' => 'Maximum length of a Skill name is 32 characters.',
                        ];
                        break;
                    case "description":
                        $rules = [
                            'description' => 'min: 10|max: 512',
                        ];

                        $error_messages = [
                            'description.min' => 'Minimum length of a Skill description is 10 characters.',
                            'description.max' => 'Maximum length of a Skill description is 512 characters.',
                        ];
                        break;
                    case "field_id":
                        $rules = [
                            'required',
                            'integer',
                            'exists:fields,id',                        ];

                        $error_messages = [
                            'field_id.required' => 'A value to indicate which Field this Skill belongs to is required.',
                            'field_id.integer' => 'The \'field_id\' value must be an integer.',
                            'field_id.exists' => 'The FieldID does not exist.'
                        ];
                        break;
                }

                // Validate input against rules relevant to the field
                $validated = Validator::make($data, $rules, $error_messages);

                if ($validated->fails()) {
                    return $this->sendError("Validation Errors");
                }

                // Update current field with validated data
                $skill[$key] = $data[$key];

            }
        }

        $skill['updated_at'] = Carbon::now();
        $skill->save();

        return $this->sendResponse(
            $skill,
            "Skill #$id updated successfully",
        );
    }

    /**
     * Block-update of all attributes of a skill in the API
     *
     * @group SkillAPI
     * @request PUT
     * @urlParam http://localhost/api/skills/11
     * @bodyParam name string Example: Corporate Skills Management
     * @bodyParam description string Example: Learn the essential skills required to ascend the corporate ladder.
     * @bodyParam field_id integer Example: 5
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 11,
     *          "name": "Corporate Skills Management",
     *          "description": "Learn the essential skills required to ascend the corporate ladder.",
     *          "field_id": 5,
     *          "created_at": "2023-01-13T12:17:39.000000Z",
     *          "updated_at": "2023-01-13T16:03:28.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Skill #11 updated successfully"
     * }
     *
     * @param APISkillValidation $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_all(APISkillValidation $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        $skill = Skill::query()->where('id', $id)->first();

        if (!is_null($skill) && $skill->count() > 0) {
            $skill['name'] = $validated['name'];
            $skill['description'] = $validated['description'];
            $skill['field_id'] = $validated['field_id'];
            $skill['updated_at'] = Carbon::now();
            $skill->save();

            return $this->sendResponse(
                $skill,
                "Skill #$skill->id updated successfully",
            );
        }

        return $this->sendError("Unable to update: skill #$id not found");
    }

    /**
     * Mark a skill record for deletion from storage (soft delete)
     *
     * @group SkillAPI
     * @request DELETE
     * @urlParam http://localhost/api/skills/3
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 3,
     *          "name": "Networking",
     *          "description": "ENTER DESCRIPTION HERE",
     *          "field_id": 11,
     *          "created_at": "2023-01-12T07:52:18.000000Z",
     *          "updated_at": "2023-01-12T08:50:11.000000Z",
     *          "deleted_at": "2023-01-12T08:50:11.000000Z"
     *      },
     *  "message": "Skill #3 has been marked for deletion"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $skill = Skill::query()->where('id', $id)->first();
        $destroyedSkill = $skill;
        $quiz_exists = false;
        $quizzes = Quiz::all();

        // Check if Skill exists in any Quizzes before deletion
        foreach ($quizzes as $quiz) {
            if ($quiz['field_id'] == $skill->id) {
                $quiz_exists = true;
                break;
            }
        }

        if ($quiz_exists) {
            return $this->sendError("Unable to delete: Skill #$id has Quizzes");
        } else {
            if (!is_null($skill) && $skill->count() > 0) {
                $skill->delete();

                return $this->sendResponse(
                    $destroyedSkill,
                    "Skill #$id has been marked for deletion",
                );
            }
        }

        return $this->sendError("Unable to delete: Skill #$id not found");
    }
}
