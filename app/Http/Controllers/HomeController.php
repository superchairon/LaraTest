<?php

namespace App\Http\Controllers;

use App\Counter;
use Illuminate\Http\Request;
use MongoDB\Client;

class HomeController extends Controller
{
    public function index()
    {
        $mongoMessage = $this->getMongoMessage();
        $postgresMessage = $this->getPostgresMessage();
        return view('welcome')
            ->with('mongoMessage', $mongoMessage)
            ->with('postgresMessage', $postgresMessage);
    }

    private function getMongoMessage()
    {
        $mongoClient = new Client(env('MONGO_URL'));
        if (!$mongoClient) {
            $msg = 'Mongo Not Found';
        } else {
            $query = ['exists' => ['counter' => true]];
            $collection = $mongoClient->{env('MONGO_DATABASE')}->counter;
            $document = $collection->findOne($query);
            $counter = $document ? $document['counter'] : 0;
            $counter = $counter + 1;
            $msg = 'This page has been registered in mongo ' . $counter . ' times';
            $collection->updateOne($query, ['$set' => ['counter' => ($counter)]], ['upsert' => true]);
        }
        return $msg;
    }

    private function getPostgresMessage()
    {
        $counter = Counter::where('key', 'counter')->first();
        $counter = $counter ? $counter->value : 0;
        $counter = $counter + 1;
        $msg = 'This page has been registered in postgres ' . $counter . ' times';
        Counter::updateOrCreate(['key' => 'counter'], ['value' => $counter]);
        return $msg;
    }
}
