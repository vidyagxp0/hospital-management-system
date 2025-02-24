<?php

namespace App\Repositories;

use App\Models\Accountant;
use App\Models\Expense;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class ExpenseRepository
 */
class ExpenseRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'expense_head',
        'name',
        'invoice_number',
        'date',
        'amount',
        'description',
    ];

    /**
     * @return array|string[]
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Expense::class;
    }

    public function store($input): bool
    {
        try {
            /** @var Expense $expense */
            $expense = $this->create($input);
            if (! empty($input['attachment'])) {
                $expense->addMedia($input['attachment'])->toMediaCollection(Expense::PATH, config('app.media_disc'));
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateExpense(array $input, int $expenseId)
    {
        try {
            /** @var Expense $expense */
            $input['amount'] = removeCommaFromNumbers($input['amount']);
            $expense = $this->update($input, $expenseId);

            if (! empty($input['attachment'])) {
                $expense->clearMediaCollection(Expense::PATH);
                $expense->addMedia($input['attachment'])->toMediaCollection(Expense::PATH, config('app.media_disc'));
            }
            if ($input['avatar_remove'] == 1 && isset($input['avatar_remove']) && ! empty($input['avatar_remove'])) {
                removeFile($expense, Expense::PATH);
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function deleteDocument(int $expenseId)
    {
        try {
            /** @var Expense $expense */
            $expense = $this->find($expenseId);
            $expense->clearMediaCollection(Expense::PATH);
            $this->delete($expenseId);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function createNotification(array $input): bool
    {
        try {
            $userIds =[];
            $accountant = Accountant::pluck('user_id', 'id')->toArray();
            foreach ($accountant as $key => $userId) {
                $userIds[$userId] = Notification::NOTIFICATION_FOR[Notification::ACCOUNTANT];
            }
            $adminUser = User::role('Admin')->first();
            $allUsers = $userIds + [$adminUser->id => Notification::NOTIFICATION_FOR[Notification::ADMIN]];
            $users = getAllNotificationUser($allUsers);

            foreach ($users as $key => $notification) {
                addNotification([
                    Notification::NOTIFICATION_TYPE['Expense'],
                    $key,
                    $notification,
                    Expense::EXPENSE_HEAD[$input['expense_head']].' expense added.',
                ]);
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
