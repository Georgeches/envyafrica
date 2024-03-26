<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Mail\OrderNotes;
use App\Models\Customer;
use App\Mail\OrderStatusDelivering;
use App\Mail\OrderStatusProcessing;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\OrderResource;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $customer = Customer::find($data['customer_id']);
        $previousStatus = $this->record->status;
        if($previousStatus === 'pending' && $data['status'] === 'processing'){
            $newMail = (new OrderStatusProcessing($data, $customer))
                ->to($customer['email']);
            Mail::send($newMail);
        }
        if($previousStatus === 'processing' && $data['status'] === 'delivering'){
            $newMail = (new OrderStatusDelivering($data, $customer))
                ->to($customer['email']);
            Mail::send($newMail);
        }
        if($this->record->notes != $data['notes']){
            $newMail = (new OrderNotes($data, $customer))
                ->to($customer['email']);
            Mail::send($newMail);
        }
        return $data;
    }
}
