<?php

namespace App\Http\Controllers\API;

use App\Models\Level;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ValidateSearchRequest;
use Illuminate\Http\JsonResponse;

/**
 * @method sendResponse($levels, string $string)
 * @method sendError(string $string)
 */

class LevelAPIController extends APIBaseController
{
    /**
     * Display a list of the AQF levels in the API
     *
     * @group LevelAPI
     * @request GET
     * @urlParam http://localhost/api/levels/
     * @bodyParam page integer Example: 2
     * @bodyParam per_page integer Example: 3
     *
     * @reponse {
     *      "success": true,
     *      "data": {
     *          "current_page": 2,
     *          "data": [{
     *              "id": 4,
     *              "AQF_level": 4,
     *              "title": "Certificate IV",
     *               "description": "Graduates at this level will have a broad range of cognitive, technical and communication skills to select and apply a range of methods, tools, materials and information.",
     *               "created_at": "2023-01-06T08:24:28.000000Z",
     *               "updated_at": "2023-01-06T08:24:28.000000Z",
     *               "deleted_at": null
     *           },
     *           {
     *               "id": 5,
     *               "AQF_level": 5,
     *               "title": "Diploma",
     *               "description": "Graduates at this level will apply knowledge and skills to demonstrate autonomy, judgement and defined responsibility in known or changing contexts and within broad but established parameters.",
     *               "created_at": "2023-01-06T08:24:28.000000Z",
     *               "updated_at": "2023-01-06T08:24:28.000000Z",
     *               "deleted_at": null
     *           },
     *           {
     *               "id": 6,
     *               "AQF_level": 6,
     *               "title": "Advanced Diploma",
     *               "description": "Graduates at this level will have a broad range of cognitive, technical and communication skills to select and apply methods and technologies.",
     *               "created_at": "2023-01-06T08:24:28.000000Z",
     *               "updated_at": "2023-01-06T08:24:28.000000Z",
     *               "deleted_at": null
     *           }],
     *       },
     *   "message": "Total of 3 AQF Levels retrieved"
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

        $levels = Level::paginate($validated["per_page"]);

        if (!is_null($levels) && $levels->count() == 1) {
            return $this->sendResponse(
                $levels,
                "{$levels->count()} Level retrieved"
            );
        } else {
            if (!is_null($levels) && $levels->count() > 1) {
                return $this->sendResponse(
                    $levels,
                    "Total of {$levels->count()} AQF Levels retrieved",

                );
            }
        }

        return $this->sendError("No Levels found");
    }

    /**
     * Display data on an AQF level in the API
     *
     * @group LevelAPI
     * @request GET
     * @urlParam http://localhost/api/levels/6
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 1,
     *          "AQF_level": 1,
     *          "title": "Certificate I",
     *          "description": "Graduates at this level will apply knowledge and skills to demonstrate autonomy in highly structured and stable contexts and within narrow parameters.",
     *          "created_at": "2023-01-06T23:12:08.000000Z",
     *          "updated_at": "2023-01-06T23:12:08.000000Z",
     *          "deleted_at": null,
     *          "quizzes": [{
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
     *              "created_at": "2023-01-06T23:12:08.000000Z",
     *              "updated_at": "2023-01-06T23:12:08.000000Z",
     *              "deleted_at": null
     *          }
     *      ]},
     *   "message": "AQF Level #1 retrieved"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $level = Level::query()
            ->where('id', $id)
            ->with('quizzes')
            ->find($id);

        if (!is_null($level) && $level->count() > 0) {
            return $this->sendResponse(
                $level,
                "AQF Level #$id retrieved",
            );
        }

        return $this->sendError("AQF Level #$id not found");
    }

    /**
     * Search for AQF level records where title or description field matches search term
     *
     * @group LevelAPI
     * @request GET
     * @urlParam http://localhost/api/levels/search
     * @bodyParams search string Example: Diploma
     *
     * @response {
     *      "success": true,
     *      "data": [{
     *          "id": 5,
     *          "AQF_level": 5,
     *          "title": "Diploma",
     *          "description": "Graduates at this level will apply knowledge and skills to demonstrate autonomy, judgement and defined responsibility in known or changing contexts and within broad but established parameters.",
     *          "created_at": "2023-01-10T08:25:27.000000Z",
     *          "updated_at": "2023-01-10T08:25:27.000000Z",
     *          "deleted_at": null
     *      },
     *      {
     *          "id": 6,
     *          "AQF_level": 6,
     *          "title": "Advanced Diploma",
     *          "description": "Graduates at this level will have a broad range of cognitive, technical and communication skills to select and apply methods and technologies.",
     *          "created_at": "2023-01-10T08:25:27.000000Z",
     *          "updated_at": "2023-01-10T08:25:27.000000Z",
     *          "deleted_at": null
     *      }],
     *   "message": "2 matching Levels retrieved"
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

        $matches = Level::query()
            ->where(Level::raw('lower(title)'), 'lIKE', "%$search_term%")
            ->orWhere(Level::raw('lower(description)'),  'LIKE', "%$search_term%")
            ->get();

        if (!is_null($matches) && $matches->count() == 1) {
            return $this->sendResponse(
                $matches,
                "{$matches->count()} matching Levels retrieved",
            );
        } else {
            if (!is_null($matches) && $matches->count() > 1) {
                return $this->sendResponse(
                    $matches,
                    "{$matches->count()} matching Levels retrieved",
                );
            }
        }

        return $this->sendError("No matching Levels found");
    }
}
