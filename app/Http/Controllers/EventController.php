<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class EventController extends Controller
{
    public function fetchEvents()
    {
        // Cache the event data for 60 minutes (adjust as necessary)
        return Cache::remember('events_data', 60, function () {
            try {
                $response = Http::get('https://event-api.dicoding.dev/events');
                if ($response->successful()) {
                    $eventsData = $response->json();
                    foreach ($eventsData['listEvents'] as &$event) {
                        $event['IsAvailable'] = $this->checkIfAvailable($event);
                        $event['timeLeft'] = $this->getTimeLeft($event);
                    }
    
                    return $eventsData;
                }
                return ['error' => 'Unable to fetch events'];
            } catch (\Exception $e) {
                return ['error' => 'Something went wrong: ' . $e->getMessage()];
            }
        });
    }

    public function getTimeLeft($event)
    {
        $endTime = Carbon::parse($event['endTime']);
        return $endTime->diffForHumans();
    }
    
    public function checkIfAvailable($event)
    {
        if (isset($event['endTime'], $event['registrants'], $event['quota'])) {
            $isActive = strtotime($event['endTime']) > time();
            $hasSpace = $event['registrants'] < $event['quota'];
            return $isActive && $hasSpace;
        }
        return false; 
    }

    public function getUpcomingEvents($data)
    {
        $upcomingEvents = [];
        if (isset($data['listEvents'])) {
            foreach ($data['listEvents'] as $event) {
                if (isset($event['endTime']) && strtotime($event['endTime']) > time()) {
                    $upcomingEvents[] = $event;
                }
            }
        }

        return $upcomingEvents;
    }

    public function index()
    {
        $eventsData = $this->fetchEvents();

        return view('event', [
            'title' => 'Event',
            'data' => $eventsData,
            'upcoming' => $this->getUpcomingEvents($eventsData)
        ]);
        
    }

    public function show($id)
    {
        try {
            $response = Http::get("https://event-api.dicoding.dev/events/{$id}");
            $data = $response->json();
            
            if ($response->successful() && isset($data['event'])) {
                return view('eventdetail', [
                    'title' => 'Event Details',
                    'event' => $data['event']
                ]);
            }

            return abort(404);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function search(Request $request)
{
    $keyword = $request->input('q', ''); 
    if (empty($keyword)) {
        return redirect()->route('event'); 
    }
    try {
        $response = Http::get("https://event-api.dicoding.dev/events", [
            'active' => -1,  
            'q' => $keyword  
        ]);

        if ($response->successful()) {
            $searchResults = $response->json();
            foreach ($searchResults['listEvents'] as &$event) {
                $event['IsAvailable'] = $this->checkIfAvailable($event);
                $event['timeLeft'] = $this->getTimeLeft($event);
            }

            return view('event', [
                'title' => 'Search Results',
                'data' => $searchResults,
                'upcoming' => $this->getUpcomingEvents($searchResults)
            ]);
        }

        return view('event', ['error' => 'No events found for the search keyword']);
    } catch (\Exception $e) {
        return view('event', ['error' => 'Something went wrong: ' . $e->getMessage()]);
    }
}

   
}
