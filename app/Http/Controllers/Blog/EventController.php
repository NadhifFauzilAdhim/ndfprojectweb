<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\ConnectionException;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Fetches all events from the API, caches the result, and enriches the data.
     * Includes a check to see if the API is active.
     */
    public function fetchEvents()
    {
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
                return ['error' => 'Unable to fetch events at the moment. The service might be down.'];
            } catch (ConnectionException $e) {
                return ['error' => 'The event service is currently unavailable. Please try again later.'];
            } catch (\Exception $e) {
                return ['error' => 'Something went wrong: ' . $e->getMessage()];
            }
        });
    }

    /**
     * Calculates the human-readable time remaining until the event ends.
     *
     * @param array $event The event data.
     * @return string
     */
    public function getTimeLeft($event)
    {
        // Use Carbon to parse the end time and get a human-readable difference.
        $endTime = Carbon::parse($event['endTime']);
        return $endTime->diffForHumans();
    }

    /**
     * Checks if an event is still active and has available quota.
     *
     * @param array $event The event data.
     * @return bool
     */
    public function checkIfAvailable($event)
    {
        if (isset($event['endTime'], $event['registrants'], $event['quota'])) {
            $isActive = strtotime($event['endTime']) > time();
            $hasSpace = $event['registrants'] < $event['quota'];
            return $isActive && $hasSpace;
        }
        return false;
    }

    /**
     * Filters the list of events to get only the upcoming ones.
     *
     * @param array $data The full event data from the API.
     * @return array
     */
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

    /**
     * Display a listing of the events.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $eventsData = $this->fetchEvents();

        return view('event', [
            'title' => 'Event',
            'data' => $eventsData,
            'upcoming' => $this->getUpcomingEvents($eventsData)
        ]);
    }

    /**
     * Display the specified event details.
     *
     * @param  string  $id
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
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
        } catch (ConnectionException $e) {
            abort(404, 'The event service is currently unavailable.');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Search for events based on a keyword.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
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
                    'title' => 'Search Results for: ' . htmlspecialchars($keyword),
                    'data' => $searchResults,
                    'upcoming' => $this->getUpcomingEvents($searchResults)
                ]);
            }
            return view('event', [
                'title' => 'Search Error',
                'data' => [],
                'upcoming' => [],
                'error' => 'The search service is currently unavailable.'
            ]);
        } catch (ConnectionException $e) {
            return view('event', [
                'title' => 'Search Error',
                'data' => [],
                'upcoming' => [],
                'error' => 'The event service is currently unavailable. Please try again later.'
            ]);
        } catch (\Exception $e) {
            return view('event', [
                'title' => 'Search Error',
                'data' => [],
                'upcoming' => [],
                'error' => 'Something went wrong during the search: ' . $e->getMessage()
            ]);
        }
    }
}
