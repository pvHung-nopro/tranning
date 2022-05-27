<?php

namespace App\Services\SendMail;

use App\Services\AbstractService;
use App\Services\SendMail\SendMailServiceInterface;
use App\Models\User;
use App\Models\ContextSendMail;
use Illuminate\Support\Collection;
use App\Jobs\SendMailJob;
use App\Exceptions\Server\SystemException;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSale;
use App\Models\HistorySendMail;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Client\NotFoundException;
use Exception;

class SendMailService extends AbstractService implements SendMailServiceInterface
{
    private User $user;
    private ContextSendMail $contextSendMail;
    private HistorySendMail $historySendMail;

    public function __construct(User $user, ContextSendMail $contextSendMail, HistorySendMail $historySendMail)
    {
        $this->user = $user;
        $this->contextSendMail = $contextSendMail;
        $this->historySendMail = $historySendMail;
    }

    public function sendMail(array $data): ?ContextSendMail
    {
        $users = $this->getUserAll();
        try {
            $contextSendMail = $this->createTextSendMail($data);
            SendMailJob::dispatch($users, $contextSendMail);
            return $contextSendMail;
        } catch (Exception $e) {
            report($e);
            return null;
        }
    }

    private function createTextSendMail(array $data): ContextSendMail
    {
        try {
            $this->begin();
            $contextSendMail = $this->contextSendMail->create([
                'context' => $data['context']
            ]);
            $this->commit();
            return $contextSendMail;
        } catch (Exception $e) {
            $this->rollback();
            report($e);
            throw new SystemException('server_error');
        }
    }

    private function getUserAll(): Collection
    {
        return $this->user->all();
    }

    public function postMailAllUsers(Collection $users, ContextSendMail $contextSendMail): void
    {
        $a = $contextSendMail->update(['status' => 2]);
        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new MailSale($user->name, $contextSendMail->context));
                $this->createHistorySendMail($user->id, $contextSendMail->id, true);
            } catch (Exception $e) {
                report($e);
                $this->createHistorySendMail($user->id, $contextSendMail->id, false);
            }
        }
        $contextSendMail->update(['status' => 3]);
    }

    private function createHistorySendMail(int $userId, int $contextId, bool $status): void
    {
        $this->historySendMail->create([
            'user_id' => $userId,
            'context_id' => $contextId,
            'status' => $status
        ]);
    }

    public function history(int $id): array
    {
        $numberSend = $this->historySendMail->where('context_id', $id)->count();
        $numberSuccess = $this->historySendMail->where('context_id', $id)->where('status', true)->count();
        $numberFaild =  $this->historySendMail->where('context_id', $id)->where('status', false)->count();
        return [
            'mail_count' => $numberSend,
            'mail_success' => $numberSuccess,
            'mail_faild' => $numberFaild
        ];
    }

    public function checkMailServerDie(): bool
    {
        $contextSendMails = $this->getRunningContextMail();
        return $contextSendMails;
    }

    private function getRunningContextMail(): bool
    {
        return  $this->contextSendMail->where('status', 2)->update([
            'status' => 4
        ]);
    }

    private function contextSendMailDetail(int $id): ?ContextSendMail
    {
        $detail =  $this->contextSendMail->find($id);
        if (!$detail) {
            throw new NotFoundException('context_send_mail_not_found');
        }
        return $detail;
    }

    public function sendToMail(int $id)
    {
        $contextSendMail = $this->contextSendMailDetail($id);
        if (in_array($contextSendMail->status, [1, 2])) {
            throw new NotFoundException('context_send_mail_status_running');
        }
        dd('ok');
    }
}
