<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use App\Support\StudyPrograms;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'nim' => ['required', 'string', 'max:30', 'unique:users,nim'],
            'program_studi' => ['required', 'string', Rule::in(StudyPrograms::all())],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'nim' => $input['nim'],
            'program_studi' => $input['program_studi'],
            'no_hp' => $input['no_hp'] ?? null,
            'email' => $input['email'],
            'password' => $input['password'],
            'role' => User::ROLE_MAHASISWA,
            'email_verified_at' => now(),
        ]);
    }
}
