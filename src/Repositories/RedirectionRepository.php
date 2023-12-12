<?php

namespace Pardalsalcap\LinterRedirections\Repositories;

use Pardalsalcap\LinterRedirections\Models\Redirection;
use Illuminate\Support\Facades\Validator;

class RedirectionRepository
{
    protected ?Redirection $redirection = null;

    public function check($url):Redirection|null
    {
        return Redirection::where('hash', $this->hash($url))
            ->whereNotNull('fix')
            ->whereNotNull('http_status')
            ->where('fix', '!=', '')
            ->first();
    }

    public function status():array
    {
        return [
            '301' => __('linter-redirections::redirections.http_status_301'),
            '302' => __('linter-redirections::redirections.http_status_302'),
            '404' => __('linter-redirections::redirections.http_status_404'),
            '500' => __('linter-redirections::redirections.http_status_500'),
        ];
    }

    public function hash($url):string
    {
        return md5($url);
    }

    public function logError($url, $http_status = 404, $fix = null):void
    {
        $arr = [
            'url' => $url,
            'http_status' => $http_status,
            'hash' => $this->hash($url),
            'fix' => $fix,
        ];
        $v = Validator::make($arr, [
            'hash' => 'required|unique:redirections',
        ]);

        if (! $v->fails()) {
            Redirection::create($arr);
        }
    }
}
