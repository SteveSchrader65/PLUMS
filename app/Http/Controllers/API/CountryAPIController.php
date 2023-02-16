<?php

namespace App\Http\Controllers\API;

use App\Models\Country;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ValidateSearchRequest;
use Illuminate\Http\JsonResponse;

/**
 * @method sendResponse($country, string $string)
 * @method sendError(string $string)
 */

class CountryAPIController extends APIBaseController
{
    /**
     * Display a list of available countries in the API
     *
     * @group CountryAPI
     * @request GET
     * @urlParam http://localhost/api/countries/
     * @bodyParam page integer Example: 1
     * @bodyParam per_page integer Example: 5
     *
     * @reponse {
     *      "success": true,
     *      "data": {
     *      "current_page": 1,
     *      "data": [{
     *          "id": 4,
     *          "name": "Afghanistan",
     *          "code_2": "AF",
     *          "code_3": "AFG",
     *          "created_at": "2023-01-16T12:13:28.000000Z",
     *          "updated_at": "2023-01-16T12:13:28.000000Z"
     *      },
     *      {
     *          "id": 8,
     *          "name": "Albania",
     *          "code_2": "AL",
     *          "code_3": "ALB",
     *          "created_at": "2023-01-16T12:13:28.000000Z",
     *          "updated_at": "2023-01-16T12:13:28.000000Z"
     *      },
     *      {
     *          "id": 12,
     *          "name": "Algeria",
     *          "code_2": "DZ",
     *          "code_3": "DZA",
     *          "created_at": "2023-01-16T12:13:28.000000Z",
     *          "updated_at": "2023-01-16T12:13:28.000000Z"
     *      },
     *      {
     *          "id": 16,
     *          "name": "American Samoa",
     *          "code_2": "AS",
     *          "code_3": "ASM",
     *          "created_at": "2023-01-16T12:13:28.000000Z",
     *          "updated_at": "2023-01-16T12:13:28.000000Z"
     *      },
     *      {
     *          "id": 20,
     *          "name": "Andorra",
     *          "code_2": "AD",
     *          "code_3": "AND",
     *          "created_at": "2023-01-16T12:13:28.000000Z",
     *          "updated_at": "2023-01-16T12:13:28.000000Z"
     *      }
     *
     *  "message": "Total of 5 Countries retrieved"
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

        $countries = Country::paginate($validated["per_page"]);

        if (!is_null($countries) && $countries->count() == 1) {
            return $this->sendResponse(
                $countries,
                "{$countries->count()} Country retrieved"
            );
        } else {
            if (!is_null($countries) && $countries->count() > 1) {
                return $this->sendResponse(
                    $countries,
                    "Total of {$countries->count()} Countries retrieved",

                );
            }
        }

        return $this->sendError("No Countries found");
    }

    /**
     * Display data on a Country in the API
     *
     * @group CountryAPI
     * @request GET
     * @urlParam http://localhost/api/countries/100
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 100,
     *          "name": "Bulgaria",
     *          "code_2": "BG",
     *          "code_3": "BGR",
     *          "created_at": "2023-01-16T12:13:28.000000Z",
     *          "updated_at": "2023-01-16T12:13:28.000000Z"
     *      },
     *  "message": "Country #100 retrieved"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $country = Country::query()
            ->where('id', $id)
            ->with('users')
            ->find($id);

        if (!is_null($country) && $country->count() > 0) {
            return $this->sendResponse(
                $country,
                "Country #$id retrieved",
            );
        }

        return $this->sendError("Country #$id not found");
    }

    /**
     * Search for Country records where name or country code field matches search term
     *
     * @group CountryAPI
     * @request GET
     * @urlParam http://localhost/api/countries/search
     * @bodyParams search string Example: Aus
     *
     * @response {
     *      "success": true,
     *      "data": [{
     *          "id": 36,
     *          "name": "Australia",
     *          "code_2": "AU",
     *          "code_3": "AUS",
     *          "created_at": "2023-01-16T12:13:28.000000Z",
     *          "updated_at": "2023-01-16T12:13:28.000000Z"
     *      },
     *      {
     *          "id": 40,
     *          "name": "Austria",
     *          "code_2": "AT",
     *          "code_3": "AUT",
     *          "created_at": "2023-01-16T12:13:28.000000Z",
     *          "updated_at": "2023-01-16T12:13:28.000000Z"
     *      }],
     *  "message": "2 matching Countries retrieved"
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

        $matches = Country::query()
            ->where(Country::raw('lower(name)'), 'lIKE', "%$search_term%")
            ->orWhere(Country::raw('lower(code_3)'),  'LIKE', "%$search_term%")
            ->get();

        if (!is_null($matches) && $matches->count() == 1) {
            return $this->sendResponse(
                $matches,
                "{$matches->count()} matching Country retrieved",
            );
        } else {
            if (!is_null($matches) && $matches->count() > 1) {
                return $this->sendResponse(
                    $matches,
                    "{$matches->count()} matching Countries retrieved",
                );
            }
        }

        return $this->sendError("No matching Countries found");
    }
}
