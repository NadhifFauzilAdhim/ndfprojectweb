<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Services\ApiServices;

class LinkService
{
    public function __construct(private ApiServices $apiServices){}
    public function createLink(array $data, int $userId): Link
    {
        $data['target_url'] = filter_var($data['target_url'], FILTER_SANITIZE_URL);
        $data['user_id'] = $userId;
        $data['title'] = $this->apiServices->fetchWebsiteTitle($data['target_url']);

        return Link::create($data);
    }
    

    public function updateLink(array $data, Link $link, Request $request): Link
    {
        $data['target_url'] = filter_var($data['target_url'], FILTER_SANITIZE_URL);
        $data['password_protected'] = $request->has('password_protected') ? 1 : 0;
        $data['password'] = $data['password_protected']
            ? bcrypt($request->input('password', $link->password))
            : null;
        $data['active'] = $request['visibility'] ? 1 : 0;
        if($link->target_url !== $data['target_url'] && !$data['title']){
            $websiteTitle = $this->apiServices->fetchWebsiteTitle($data['target_url']);
            $data['title'] = $websiteTitle ?? null;
        }
         $link->update($data);
         return $link;
    }

    public function quickUpdate(array $data, Link $link, Request $request): Link
    {
        $data['target_url'] = filter_var($data['target_url'], FILTER_SANITIZE_URL);
        $data['active'] = $request['visibility'] ? 1 : 0;
        if($link->target_url !== $data['target_url']){
            $websiteTitle = $this->apiServices->fetchWebsiteTitle($data['target_url']);
            $data['title'] = $websiteTitle ?? null;
        }
        $link->update($data);
        return $link;
    }

}