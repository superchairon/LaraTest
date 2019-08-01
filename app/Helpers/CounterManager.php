<?php

namespace App\Helpers;


use App\Counter;
use Illuminate\Support\Facades\Log;
use MongoDB\Client;

class CounterManager
{
    public static function getMongoCounter($counterName)
    {
        $mongoClient = new Client(env('MONGO_URL'));
        $counter = 0;
        if ($mongoClient) {
            $query = ['exists' => [$counterName => true]];
            $collection = $mongoClient->{env('MONGO_DATABASE')}->counter;
            $document = $collection->findOne($query);
            $counter = $document ? $document[$counterName] : 0;
        }
        return $counter;
    }

    public static function incMongoCounter($counterName)
    {
        $mongoClient = new Client(env('MONGO_URL'));
        $counter = 0;
        if ($mongoClient) {
            $query = ['exists' => [$counterName => true]];
            $collection = $mongoClient->{env('MONGO_DATABASE')}->counter;
            $document = $collection->findOne($query);
            $counter = ($document ? $document[$counterName] : 0) + 1;
            $collection->updateOne($query, ['$set' => [$counterName => ($counter)]], ['upsert' => true]);
        }
        return $counter;
    }

    public static function getPostgresCounter($counterName)
    {
        $row = Counter::where('key', $counterName)->first();
        return $row ? $row->value : 0;
    }

    public static function incPostgresCounter($counterName)
    {
        $row = Counter::where('key', $counterName)->first();
        $counter = ($row ? $row->value : 0) + 1;
        Counter::updateOrCreate(['key' => $counterName], ['value' => $counter]);
        return $counter;
    }

}