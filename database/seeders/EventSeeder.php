<?php

namespace Database\Seeders;

use App\Repositories\EventRepository;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }


    public function run()
    {
        for ($i = 0; $i < 100; ++$i) {
            $this->createEventIfMissing('Title '.$i);
        }
    }

    protected function createEventIfMissing($title)
    {
        if (empty($this->eventRepository->findBTitle($title))) {
            $eventNeedCreate['title'] = $title;
            $eventNeedCreate['type'] = config('constants.EVENT_TYPE.PARTY');
            $eventNeedCreate['count_need_participate'] = 69;
            $eventNeedCreate['count_participated'] = 69;
            $eventNeedCreate['count_registered'] = 69;
            $eventNeedCreate['start_at'] = Carbon::now();
            $eventNeedCreate['end_at'] = Carbon::now();
            $eventNeedCreate['address'] = "Mong A";
            $eventNeedCreate['description'] = "Mong A";
            $eventNeedCreate['description_participant'] = "Mong A";
            $eventNeedCreate['description_required'] = "Mong A";
            $eventNeedCreate['images_str'] = "Mong A";
            $eventNeedCreate['status'] = config('constants.EVENT_STATUS.INCOMING_EVENT');
            $eventNeedCreate['is_active'] = true;
            $this->eventRepository->store($eventNeedCreate);
        }
    }
}
