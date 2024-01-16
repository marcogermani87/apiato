<?php

namespace App\Containers\AppSection\SocialAuth\UI\API\Controllers;

use Apiato\Core\Abstracts\Controllers\ApiController;
use App\Containers\AppSection\SocialAuth\Actions\SignupByCodeAction;
use App\Containers\AppSection\SocialAuth\UI\API\Requests\SignupByCodeRequest;
use App\Containers\AppSection\SocialAuth\Values\PersonalAccessTokenResponse;
use App\Containers\AppSection\SocialAuth\Values\SocialAuthOutcome;

final class SignupByCodeController extends ApiController
{
    public function __construct(
        private readonly SignupByCodeAction $signupByCodeAction,
    ) {
    }

    public function __invoke(SignupByCodeRequest $request, string $provider)
    {
        /* @var SocialAuthOutcome $result */
        $result = $this->signupByCodeAction->transactionalRun($provider);

        return $this->withMeta(
            PersonalAccessTokenResponse::from($result->token)->toArray(),
        )->transform($result->user, config('vendor-socialAuth.user.transformer'));
    }
}
