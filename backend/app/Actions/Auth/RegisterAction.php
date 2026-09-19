<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class RegisterUser
{
    use AsAction;

    public function handle(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    public function asController(RegisterRequest $request): JsonResponse
    {
        /**
        * @property App\Models\User $user
        */
        $user = $this->handle($request->validated);
        return response()->json([
            'token' => $user->createToken('api-token')->plainText(),
            'user' => new UserResource($user)
        ]);
    }
}
