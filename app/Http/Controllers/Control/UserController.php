<?php
 
namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\UserUpdatePasswordRequest;
use App\Http\Requests\Control\UserUpdatePhotoRequest;
use App\Http\Requests\Control\UserUpdateRequest;
use App\Http\Resources\Control\UserResource;
use Brediweb\ImagemUpload\ImagemUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $photo;

    public function __construct()
    {
        $this->photo = [
            'input_file' => 'photo',
            'destino' => 'users/',
            'resolucao' => [
                'p' => ['h' => 200, 'w' => 200],
                'm' => ['h' => 400, 'w' => 400],
                'g' => ['h' => 800, 'w' => 800],
            ],
        ];
    }

    public function me(): JsonResponse
    {
        $user = auth()->user();

        return apiResponse(false, [], UserResource::make($user));
    }

    public function update(UserUpdateRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $input = $request->validated();

        $user->update($input);

        return apiResponse(false, [], UserResource::make($user));
    }

    public function updatePassword(UserUpdatePasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $input = $request->validated();

        $user->update([
            'password' => Hash::make($input['password'])
        ]);

        return apiResponse(false, []);
    }

    public function updatePhoto(UserUpdatePhotoRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $user->update([
            'profile_photo' => ImagemUpload::salva($this->photo),
        ]);

        return apiResponse(false, [], UserResource::make($user));
    }
}
