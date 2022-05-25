<?php

namespace App\Services\SendMail;

use Illuminate\Support\Collection;
use App\Models\ContextSendMail;

interface SendMailServiceInterface
{
    public function sendMail(array $data): ?ContextSendMail;
    public function history(int $id): array;
    public function postMailAllUsers(Collection $users,  ContextSendMail $contextSendMail);
}
