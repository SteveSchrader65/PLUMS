<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Requests\APIUserValidation;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ValidateSearchRequest;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @method sendResponse(LengthAwarePaginator $users, string $string)
 * @method sendError(string $string)
 */

class UserAPIController extends APIBaseController
{
    /**
     * Display a list of the user records in the API
     *
     * @group UserAPI
     * @request GET
     * @urlParam http://localhost/api/users/
     * @bodyParam page integer Example: 1
     * @bodyParam per_page integer Example: 4
     *
     * @reponse {
     *      "success": true,
     *      "data": {
     *          "current_page": 1,
     *          "data": [{
     *              "id": 1,
     *              "email": "admin@plums.com",
     *              "email_verified_at": null,
     *              "profile": {
     *                      "given_name": "Adrian",
     *                      "family_name": "Smith",
     *                      "city": "Birmingham",
     *                      "country": "GBR"
     *                  },
     *                  "created_at": "2023-01-29T05:00:38.000000Z",
     *                  "updated_at": "2023-01-29T05:00:38.000000Z"
     *              },
     *              {
     *              "id": 2,
     *              "email": "lsd@plums.com",
     *              "email_verified_at": null,
     *              "profile": {
     *                      "given_name": "Alice",
     *                      "family_name": "Dee",
     *                      "city": "Sacramento",
     *                      "country": "USA"
     *                  },
     *                  "created_at": "2023-01-29T05:00:38.000000Z",
     *                  "updated_at": "2023-01-29T05:00:38.000000Z"
     *              },
     *              {
     *              "id": 3,
     *              "email": "jd@plums.com",
     *              "email_verified_at": null,
     *              "profile": {
     *                      "given_name": "John",
     *                      "family_name": "Doe",
     *                      "city": "Perth",
     *                      "country": "AUS"
     *                  },
     *                  "created_at": "2023-01-29T05:00:38.000000Z",
     *                  "updated_at": "2023-01-29T05:00:38.000000Z"
     *              },
     *              {
     *              "id": 4,
     *              "email": "peter123@example.com",
     *              "email_verified_at": null,
     *              "profile": {
     *                      "given_name": "Peter",
     *                      "family_name": "Smith",
     *                      "city": "Miami",
     *                      "country": "USA"
     *                  },
     *                  "created_at": "2023-01-29T05:00:38.000000Z",
     *                  "updated_at": "2023-01-29T05:00:38.000000Z"
     *              },
     *          }],
     *     },
     * "message": "Total of 4 Users retrieved"
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

        $users = User::paginate($validated["per_page"]);

        if (!is_null($users) && $users->count() == 1) {
            return $this->sendResponse(
                $users,
                "{$users->count()} User retrieved",
            );
        } else {
            if (!is_null($users) && $users->count() > 1) {
                return $this->sendResponse(
                    $users,
                    "Total of {$users->count()} Users retrieved",
                );
            }
        }

        return $this->sendError("No Users found");
    }

    /**
     * Display a user record
     *
     * @group UserAPI
     * @request GET
     * @urlParam http://localhost/api/users/2
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 2,
     *          "email": "lsd@plums.com",
     *          "email_verified_at": null,
     *          "profile": {
     *              "given_name": "Alice",
     *              "family_name": "Dee",
     *              "city": "Sacramento",
     *              "country": "USA",
     *              "created_at": "2023-01-07T12:59:56.000000Z",
     *              "updated_at": "2023-01-07T12:59:56.000000Z"
     *          }
     *      },
     *  "message": "User #2 retrieved"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = User::query()
            ->where('id', $id)
            //->with('country')
            //->with('attempts')
            //->with('roles')
            //->with('permissions')
            ->find($id);

        if (!is_null($user) && $user->count() > 0) {
            return $this->sendResponse(
                $user,
                "User #$id retrieved",
            );
        }

        return $this->sendError("User #$id not found");
    }

    /**
     * Search for user records where email or profile field matches search term
     *
     * @group UserAPI
     * @request GET
     * @urlParam http://localhost/api/users/search
     * @bodyParams search string Example: USA
     *
     * @response {
     *      "success": true,
     *      "data": [{
     *          "id": 2,
     *          "email": "lsd@plums.com",
     *          "email_verified_at": null,
     *          "profile": {
     *              "given_name": "Alice",
     *              "family_name": "Dee",
     *              "city": "Sacramento",
     *              "country": "USA"
     *          },
     *          "created_at": "2023-01-29T05:00:38.000000Z",
     *          "updated_at": "2023-01-29T05:00:38.000000Z"
     *      },
     *      {
     *          "id": 4,
     *          "email": "peter123@example.com",
     *          "email_verified_at": null,
     *          "profile": {
     *              "given_name": "Peter",
     *              "family_name": "Smith",
     *              "city": "Miami",
     *              "country": "USA"
     *          },
     *          "created_at": "2023-01-29T05:00:38.000000Z",
     *          "updated_at": "2023-01-29T05:00:38.000000Z"
     *      }],
     *  "message": "2 matching Users retrieved"
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

        $matches = User::query()
            //->with('roles')
            //->with('permissions')
            ->where(User::raw('lower(email)'), 'lIKE', "%$search_term%")
            ->orWhere(User::raw('lower(profile)'),  'LIKE', "%$search_term%")
            ->get();

        if (!is_null($matches) && $matches->count() == 1) {
            return $this->sendResponse(
                $matches,
                $matches->count() . " matching User retrieved",
            );
        } else {
            if (!is_null($matches) && $matches->count() > 1) {
                return $this->sendResponse(
                    $matches,
                    $matches->count() . " matching Users retrieved",
                );
            }
        }

        return $this->sendError("No matching Users found");
    }

    /**
     * Attribute-update of the properties of a User in the API
     *
     * @group UserAPI
     * @request PATCH
     * @urlParam http://localhost/api/users/7
     * @bodyParam email string Example: alex@georgemail.com
     * @bodyParam password string Example: secure1234
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 7,
     *          "email": "alex@georgemail.com",
     *          "email_verified_at": null,
     *          "profile": {
     *              "country": "AUS",
     *              "updated_at": "2023-01-29T05:37:13.000000Z",
     *              "created_at": "2023-01-29T05:37:13.000000Z"
     *              },
     *          "created_at": "2023-01-29T05:07:15.000000Z",
     *          "updated_at": "2023-01-29T05:37:13.000000Z"
     *      },
     *  "message": "User #7 updated successfully"
     * }
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_attribute(Request $request, int $id): JsonResponse
    {
        $user = User::query()->where('id', $id)->first();
        $profile = UserProfile::query()->where('id', $user->id)->exists();
        $data = $request->input();
        $keyz = array_keys($data);

        if (!$profile) {
            // Create empty user profile
            $profile = UserProfile::create(['id' => $user['id']]);
        }

        if (empty($keyz)) {
            return $this->sendError("No field-keys entered");
        }

        extract($data);

        foreach ($keyz as $key) {
            if (isset($data[$key])) {

                // Allocate validation rules and messages for this field
                switch ($key) {
                    case "given_name":
                        $rules = [
                            'given_name' => 'min: 2|max: 32',
                        ];

                        $error_messages = [
                            'given_name.min' => 'Minimum length for given name is 2 characters.',
                            'given_name.max' => 'Maximum length for given name is 32 characters.',
                        ];
                        break;
                    case "family_name":
                        $rules = [
                            'family_name' => 'min: 2|max: 64',
                        ];

                        $error_messages = [
                            'family_name.min' => 'Minimum length for a family name is 2 characters.',
                            'family_name.max' => 'Maximum length for a family name is 64 characters.',
                        ];
                        break;
                    case "city":
                        $rules = [
                            'city' => 'min: 3|max: 32',
                        ];

                        $error_messages = [
                            'city.min' => 'The minimum length for a city name is 3 characters.',
                            'city.max' => "The maximum value for city name is 32 characters.",
                        ];
                        break;
                    case "country":
                        $rules = [
                            'country' => 'size: 3',
                        ];

                        $error_messages = [
                            'country.size' => 'A 3-letter country code is required for this field.',
                        ];
                        break;
                    case "email":
                        $rules = [
                            'email' => 'email: rfc, dns',
                            'unique:users',
                        ];

                        $error_messages = [
                            'email.email' => 'A valid e-mail address is required.',
                            'email.unique' => 'A unique e-mail address is required',
                        ];
                        break;
                    case "password":
                        $rules = [
                            'password' => 'required|min: 8',
                        ];

                        $error_messages = [
                            'password.required' => 'A password is required.',
                            'password.min' => 'Password must be a minimum of 8 characters in length.',
                        ];
                        break;
                }

                // Validate input against rules relevant to the field
                $validated = Validator::make($data, $rules, $error_messages);

                if ($validated->fails()) {
                    return $this->sendError("Validation Errors");
                }

                // Update current field with validated data
                if ($key == 'email') {
                    $user[$key] = $data[$key];
                } elseif ($key == 'password') {
                    $user[$key] = Hash::make($data[$key]);
                } else {
                    $profile[$key] = $data[$key];
                }
            }
        }

        $user['profile'] = $profile;
        $user['updated_at'] = Carbon::now();
        $profile['updated_at'] = Carbon::now();
        $user->save();
        $profile->save();

        return $this->sendResponse(
            $user,
            "User #$id updated successfully",
        );
    }

    /**
     * Block-update of all attributes in a user record
     *
     * @group UserAPI
     * @request PUT
     * @urlParam http://localhost/api/users/3
     * @bodyParam given_name string Example: Stevie
     * @bodyParam family_name string Example: Wonderful
     * @bodyParam city string Example: London
     * @bodyParam country string Example: GBR
     * @bodyParam email string Example: stevelives@home.com
     * @bodyParam password string Example: password1234
     *
     * @response {
     *      "success": true,
     *      "data": {
     *          "id": 3,
     *          "email": "stevelives@home.com",
     *          "email_verified_at": null,
     *          "profile": {
     *              "country": "GBR",
     *              "updated_at": "2023-01-29T05:43:17.000000Z",
     *              "created_at": "2023-01-29T05:43:17.000000Z",
     *              "given_name": "Stevie",
     *              "family_name": "Wonderful",
     *              "city": "London"
     *          },
     *          "created_at": "2023-01-29T05:00:38.000000Z",
     *          "updated_at": "2023-01-29T05:43:17.000000Z"
     *      },
     *  "message": "User #3 updated successfully"
     * }
     *
     * @param APIUserValidation $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_all(APIUserValidation $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        $user = User::query()->where('id', $id)->first();
        $profile = UserProfile::query()->where('id', $id)->first();

        if (!is_null($user) && $user->count() > 0) {

            if (!$profile) {
                // Create empty user profile
                $profile = UserProfile::create(['id' => $user['id']]);
            }

            $profile['given_name'] = $validated['given_name'];
            $profile['family_name'] = $validated['family_name'];
            $profile['city'] = $validated['city'];
            $profile['country'] = $validated['country'];
            $user['email'] = $validated['email'];
            $user['password'] = Hash::make($validated['password']);
            $user['profile'] = $profile;
            $user['updated_at'] = Carbon::now();
            $profile['updated_at'] = Carbon::now();
            $profile->save();
            $user->save();

            return $this->sendResponse(
                $user,
                "User #{$user['id']} updated successfully",
            );
        }

        return $this->sendError("Unable to update: User #$id not found");
    }
}
