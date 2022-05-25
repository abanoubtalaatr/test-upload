<?php

namespace App\Notification\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Admin\Domain\Models\Admin;
use App\Notification\Domain\Filters\NotificationFilter;
use Illuminate\Notifications\DatabaseNotification;
use App\Notification\Domain\Models\Notification;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ListNotificationsService extends Service
{
    protected $order, $filter, $type;

    public function __construct(Notification $notification, NotificationFilter $filter)
    {
        $this->notification = $notification;
        $this->filter = $filter;
        $this->type = request('type');
    }
    public function handle($data = []) 
    {

//        $query = $this->notification->filter($this->filter);
        $query=Notification::where('type','App\Notification\Domain\Notifications\GeneralNotification')->filter($this->filter)->groupBy('data');
//        if($this->type == "sent"){
//            $query = $query->where('notifiable_type',"App\User\Domain\Models\User")->where('type', 'App\Notification\Domain\Notifications\GeneralNotification')->groupBy('data');
//        }else{
//            $query = $query->where('notifiable_type',"App\Admin\Domain\Models\Admin")->where('type', '!=', 'App\Notification\Domain\Notifications\GeneralNotification');
//        }
//        $notifications = Notification::where('type', 'App\Notification\Domain\Notifications\GeneralNotification')->orderBy('created_at', 'desc')->paginate(10);

        $notifications = $query->orderBy('created_at', 'desc')->paginate(10);

        return new GenericPayload($notifications, Response::HTTP_ACCEPTED);
    }
}
