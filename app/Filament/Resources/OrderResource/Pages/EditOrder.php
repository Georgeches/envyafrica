<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Mail\OrderNotes;
use App\Models\Customer;
use App\Enums\OrderStatusEnum;
use App\Mail\OrderStatusDelivered;
use App\Mail\OrderStatusDelivering;
use App\Mail\OrderStatusProcessing;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\OrderResource;
use App\Models\OrderItem;
use App\Models\Product;

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
        if($previousStatus !== $data['status'] && $data['status'] === 'processing'){
            $newMail = (new OrderStatusProcessing($data, $customer))
                ->to($customer['email']);
            Mail::send($newMail);

            $this->sendSMS(OrderStatusEnum::PROCESSING);
        }
        if($previousStatus !== $data['status'] && $data['status'] === 'dispatched'){
            $newMail = (new OrderStatusDelivering($data, $customer))
                ->to($customer['email']);
            Mail::send($newMail);

            $this->sendSMS(OrderStatusEnum::DISPATCHED);
        }
        if($previousStatus !== $data['status'] && $data['status'] === 'completed'){
            $order_items = OrderItem::all()->toArray();
            $items = array_filter($order_items, function($item){
                return $item['order_id'] == $this->record->id;
            });
            foreach($items as $item){
                $product = Product::find($item['product_id']);
                if($product){
                    if($product->quantity <= 0){
                        $product->delete();
                    }
                }
            }

            $newMail = (new OrderStatusDelivered($data, $customer))
                ->to($customer['email']);
            Mail::send($newMail);

            $this->sendSMS(OrderStatusEnum::COMPLETED);
        }
        if($this->record->notes != $data['notes']){
            $newMail = (new OrderNotes($data, $customer))
                ->to($customer['email']);
            Mail::send($newMail);
        }
        return $data;
    }

    private function sendSMS($status){
        $message = '';
        if($status === OrderStatusEnum::PROCESSING){
            $message = 'Your order #' . $this->record->number . ' is now being processed.';
        } else if($status === OrderStatusEnum::DISPATCHED){
            $message = 'Your order #' . $this->record->number . ' has been dispatched.';
        } else if($status === OrderStatusEnum::COMPLETED){
            $message = 'Your order #' . $this->record->number . ' has been delivered.';
        }
        $response = Http::post('https://sms.textsms.co.ke/api/services/sendsms/', [
            'apikey' => env('SMS_API_KEY'),
            'partnerID' => env('SMS_PARTNER_ID'),
            'message' => $message,
            'shortcode' => env('SMS_SHORT_CODE'),
            'mobile' => env('SMS_MOBILE')
        ]);

        dd($response);
    }
}
