<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\APIFieldValidation;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ValidateSearchRequest;
use App\Models\Field;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

/**
 * @method sendResponse(LengthAwarePaginator $fields, string $string)
 * @method sendError(string $string)
 */
class FieldAPIController extends APIBaseController
{
    /**
     * Display a list of study-fields in the API
     *
     * @group FieldAPI
     * @request GET
     * @urlParam http://localhost/api/fields/
     * @bodyParam page integer Example: 1
     * @bodyParam per_page integer Example: 5
     *
     * @reponse {
     *      "success": true,
     *      "data": {
     *          "current_page": 1,
     *          "data": [{
     *              "id": 1,
     *              "name": "Aerospace, Maritime and Logistics",
     *              "description": "With the uptake of online shopping, supply chain has become the major conduit to fulfil the transfer of global goods and services. You could become a valuable part in an evolving\n                        industry by gaining the necessary skills for working in the supply chain industry.",
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 2,
     *              "name": "Agricultural Science and the Environment",
     *              "description": "Learn aspects of working in a nursery and with plant propagation. This skill set will give you the skills and knowledge for entry level employment in a nursery centre and covers basic\n                        nursery preparation skills for plant propagation and care for nursery plants. It is suitable for anyone wishing to work in Horticulture industry.",
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 3,
     *              "name": "Automotive",
     *              "description": "Gear up for a career in the automotive industry. This area has courses spanning from our pre-apprenticeship course - where you will gain the skills to become an apprentice mechanic -\n                        through to courses covering the requirements for you to upskill your career into the Airconditioning, Electrical, Servicing and Trimming branches of the industry.",
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              "updated_at": "2023-01-06T08:24:28.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 4,
     *              "name": "Building and Construction",
     *              "description": "Build your career from the ground up with courses from Bricklaying, Plastering, Carpentry and Decorating to the basics of Architectural Design and Construction. Work as a builder or\n                        manager of a small to medium building business dealing with low-rise residential and commercial construction projects. Learn to plan and supervise construction projects and prepare, cost and\n                        schedule contracts.",
     *              "created_at": "2023-01-06T08:24:28.000000Z",
     *              updated_at": "2023-01-06T08:24:28.000000Z",
     *              deleted_at": null
     *           }],
     *       }
     *   "message": "Total of 4 Study-fields retrieved"
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

        $fields = Field::paginate($validated["per_page"]);

        if (!is_null($fields) && $fields->count() == 1) {
            return $this->sendResponse(
                $fields,
                "{$fields->count()} Study-field retrieved",
            );
        } else {
            if (!is_null($fields) && $fields->count() > 1) {
                return $this->sendResponse(
                    $fields,
                    "Total of {$fields->count()} Study-fields retrieved",
                );
            }
        }

        return $this->sendError("No Study-fields found");
    }

    /**
     * Display data on a study-field record
     *
     * @group FieldAPI
     * @request GET
     * @urlParam http://localhost/api/fields/2
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 5,
     *          "name": "Business and Finance",
     *          "description": "Account for your future by gaining the skills necessary to manage your own business; or learn the principles of Bookkeeping, Account Management and Data Analysis to begin your climb of the corporate ladder in a range of industries. You'll learn how to set up and maintain computerised accounts, establish payroll systems, maintain inventory records, prepare financial reports prepare and lodge business and instalment activity statements and provide advice to taxpayers in relation to activity statements.",
     *          "created_at": "2023-01-13T12:17:38.000000Z",
     *          "updated_at": "2023-01-13T12:17:38.000000Z",
     *          "deleted_at": null,
     *          "skills": [{
     *              "id": 8,
     *              "name": "Accountancy",
     *              "description": "ENTER DESCRIPTION HERE",
     *              "field_id": 5,
     *              "created_at": "2023-01-13T12:17:39.000000Z",
     *              "updated_at": "2023-01-13T12:17:39.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 10,
     *              "name": "Finance Management",
     *              "description": "ENTER DESCRIPTION HERE",
     *              "field_id": 5,
     *              "created_at": "2023-01-13T12:17:39.000000Z",
     *              "updated_at": "2023-01-13T12:17:39.000000Z",
     *              "deleted_at": null
     *          },
     *          {
     *              "id": 11,
     *              "name": "Business Management",
     *              "description": "ENTER DESCRIPTION HERE",
     *              "field_id": 5,
     *              "created_at": "2023-01-13T12:17:39.000000Z",
     *              "updated_at": "2023-01-13T12:17:39.000000Z",
     *              "deleted_at": null
     *          }],
     *          "quizzes": [{
     *              "id": 1,
     *              "title": "Quiz One",
     *              "description": "Quiz 1 will test your knowledge of programming at an intermediate level.",
     *              "question_set": "[1, 4, 7, 9]",
     *              "level_id": 1,
     *              "field_id": 2,
     *              "skill_id": 11,
     *              "is_available": 1,
     *              "prepared_by": 1,
     *              "times_attempted": 0,
     *              "fastest_time": "00:00:00",
     *              "average_time": "00:00:00",
     *              "created_at": "2023-01-13T12:17:39.000000Z",
     *              "updated_at": "2023-01-13T12:17:39.000000Z",
     *              "deleted_at": null,
     *              "laravel_through_key": 5
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
     *              "times_attempted": 0,
     *              "fastest_time": "00:00:00",
     *              "average_time": "00:00:00",
     *              "created_at": "2023-01-13T12:17:39.000000Z",
     *              "updated_at": "2023-01-13T12:17:39.000000Z",
     *              "deleted_at": null,
     *              "laravel_through_key": 5
     *          }]
     *      },
     *  "message": "Study-field #5 retrieved"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $field = Field::query()
            ->where('id', $id)
            ->with('skills')
            ->with('quizzes')
            ->find($id);

        if (!is_null($field) && $field->count() > 0) {
            return $this->sendResponse(
                $field,
                "Study-field #$id retrieved",
            );
        }

        return $this->sendError("Study-field #$id not found");
    }

    /**
     * Create a new study-field in the API
     *
     * @group FieldAPI
     * @request POST
     * @urlParam http://localhost/api/fields/
     * @bodyParam name string Example: Astrophysics
     * @bodyParam description string Example: The science dealing with the movement of heavenly bodies.
     *
     * @response {
     *      "success": true,
     *      "data": {
     *      "name": "Astrophysics",
     *      "description": "The science dealing with the movement of heavenly bodies.",
     *      "updated_at": "2023-01-11T09:00:49.000000Z",
     *      "created_at": "2023-01-11T09:00:49.000000Z",
     *      "id": 13
     *    },
     * "message": "New Field #13 created successfully"
     * }
     *
     * @param APIFieldValidation $request
     * @return JsonResponse
     */
    public function store(APIFieldValidation $request): JsonResponse
    {
        $validated = $request->validated();
        $field = Field::create($validated);

        return $this->sendResponse(
            $field,
            "New Field #$field->id created successfully",
        );
    }

    /**
     * Search for study-field records where name or description field matches search term
     *
     * @group FieldAPI
     * @request GET
     * @urlParam http://localhost/api/fields/search
     * @bodyParams search string Example: Design
     *
     * @response {
     *      "success": true,
     *      "data": [{
     *          "id": 4,
     *          "name": "Building and Construction",
     *          "description": "Build your career from the ground up with courses from Bricklaying, Plastering, Carpentry and Decorating to the basics of Architectural Design and Construction. Work as a builder or manager of a small to medium building business dealing with low-rise residential and commercial construction projects. Learn to plan and supervise construction projects and prepare, cost and schedule contracts.",
     *          "created_at": "2023-01-10T08:25:26.000000Z",
     *          "updated_at": "2023-01-10T08:25:26.000000Z",
     *          "deleted_at": null
     *      },
     *      {
     *          "id": 6,
     *          "name": "Creative Industries",
     *          "description": "Design your career in the creative and cultural heart of the city. North Metro TAFE has a well established fashion department offering a stimulating design space that combines creativity with the underpinning practical skills necessary for success in an exciting and challenging industry.",
     *          "created_at": "2023-01-10T08:25:26.000000Z",
     *          "updated_at": "2023-01-10T08:25:26.000000Z",
     *          "deleted_at": null
     *      },
     *      {
     *          "id": 8,
     *          "name": "Engineering",
     *          "description": "Whether you are upskilling or looking for a career change, these courses will give you the drafting skills to work in the Mechanical Engineering and Drafting sector. The Mechanical Engineering Drafting Skill Set will equip you with the skills needed to use AutoCAD to complete mechanical engineering design drawings for CNC processes in manufacturing. Or take our courses in Advanced Welding with specializations in Manual Metal Arc and Gas Tungsten Arc Welding skill sets.",
     *          "created_at": "2023-01-10T08:25:26.000000Z",
     *          "updated_at": "2023-01-10T08:25:26.000000Z",
     *          "deleted_at": null
     *      }],
     *   "message": "3 matching Study-fields retrieved"
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

        $matches = Field::query()
            ->where(Field::raw('lower(name)'), 'lIKE', "%$search_term%")
            ->orWhere(Field::raw('lower(description)'),  'LIKE', "%$search_term%")
            ->get();

        if (!is_null($matches) && $matches->count() == 1) {
            return $this->sendResponse(
                $matches,
                $matches->count() . " matching Study-fields retrieved",
            );
        } else {
            if (!is_null($matches) && $matches->count() > 1) {
                return $this->sendResponse(
                    $matches,
                    $matches->count() . " matching Study-fields retrieved",
                );
            }
        }

        return $this->sendError("No matching Study-fields found");
    }

    /**
     * Attribute-update of the properties of a Field in the API
     *
     * @group FieldAPI
     * @request PATCH
     * @urlParam http://localhost/api/fields/5
     * @bodyParam name string Example: Criminal Services
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 7,
     *          "name": "Criminal Services",
     *          "description": "Just some text that has been made up.",
     *          "created_at": "2023-01-14T22:58:44.000000Z",
     *          "updated_at": "2023-01-15T05:52:20.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Field #7 updated successfully"
     * }
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_attribute(Request $request, int $id): JsonResponse
    {
        $field = Field::query()->where('id', $id)->first();

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
                            'name' => 'min: 3| max: 32',
                        ];

                        $error_messages = [
                            'name.min' => 'Minimum length of a Field name is 3 characters.',
                            'name.max' => 'Maximum length of a Field name is 32 characters.',
                        ];
                        break;
                    case "description":
                        $rules = [
                            'description' => 'min: 10| max: 512',
                        ];

                        $error_messages = [
                            'description.min' => 'Minimum length of a Skill description is 10 characters.',
                            'description.max' => 'Maximum length of a Skill description is 512 characters.',
                        ];
                        break;
                }

                // Validate input against rules relevant to the field
                $validated = Validator::make($data, $rules, $error_messages);

                if ($validated->fails()) {
                    return $this->sendError("Validation Errors");
                }

                // Update current field with validated data
                $field[$key] = $data[$key];
            }
        }

        $field['updated_at'] = Carbon::now();
        $field->save();

        return $this->sendResponse(
            $field,
            "Field #$id updated successfully",
        );
    }

    /**
     * Block-update of all attributes of a study-field record in the API
     *
     * @group FieldAPI
     * @request PUT
     * @urlParam http://localhost/api/fields/7
     * @bodyParam name string Example: Criminal Services
     * @bodyParam description string Example: Just some text that has been made up.
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 7,
     *          "name": "Criminal Services",
     *          "description": "Just some text that has been made up.",
     *          "created_at": "2023-01-13T12:17:38.000000Z",
     *          "updated_at": "2023-01-13T15:55:35.000000Z",
     *          "deleted_at": null
     *      },
     *  "message": "Field #7 updated successfully"
     * }
     *
     * @param APIFieldValidation $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_all(APIFieldValidation $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        $field = Field::query()->where('id', $id)->first();

        if (!is_null($field) && $field->count() > 0) {
            $field['name'] = $validated['name'];
            $field['description'] = $validated['description'];
            $field['updated_at'] = Carbon::now();
            $field->save();

            return $this->sendResponse(
                $field,
                "Field #$id updated successfully",
            );
        }

        return $this->sendError("Unable to update: Field #$id not found");
    }

    /**
     * Mark a study-field record for deletion from storage (soft delete)
     *
     * @group FieldAPI
     * @request DELETE
     * @urlParam http://localhost/api/fields/5
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 5,
     *          "name": "Business and Finance",
     *          "description": "Account for your future by gaining the skills necessary to manage your own business; or learn the principles of Bookkeeping, Account Management and Data Analysis to begin your climb of the corporate ladder in a range of industries. You'll learn how to set up and maintain computerised accounts, establish payroll systems, maintain inventory records, prepare financial reports prepare and lodge business and instalment activity statements and provide advice to taxpayers in relation to activity statements.",
     *          "created_at": "2023-01-12T07:52:18.000000Z",
     *          "updated_at": "2023-01-12T08:39:13.000000Z",
     *          "deleted_at": "2023-01-12T08:39:13.000000Z"
     *      },
     *  "message": "Field #5 has been marked for deletion"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $field = Field::query()->where('id', $id)->first();
        $destroyedField = $field;
        $quiz_exists = false;
        $quizzes = Quiz::all();

        // Check if Field exists is any Quizzes before deletion
        foreach ($quizzes as $quiz) {
            if ($quiz['field_id'] == $field->id) {
                $quiz_exists = true;
                break;
            }
        }

        if ($quiz_exists) {
            return $this->sendError("Unable to delete: Field #$id has Quizzes");
        } else {
            if (!is_null($field) && $field->count() > 0) {
                $field->delete();

                return $this->sendResponse(
                    $destroyedField,
                    "Field #$id has been marked for deletion",
                );
            }
        }

        return $this->sendError("Unable to delete: Field #$id not found");
    }
}
