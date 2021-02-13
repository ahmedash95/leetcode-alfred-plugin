<?php

use Alfred\Workflows\Workflow;

require __DIR__ . '/vendor/autoload.php';

if(count($argv) > 0) array_shift($argv);
$query = strtolower(implode(' ', $argv));

$workflow = new Workflow;

$dailyChallengeLink = sprintf("https://leetcode.com/explore/challenge/card/%s-leetcoding-challenge-%s/", strtolower(date('F')), date('Y'));
$workflow->result()
    ->icon('favicon.png')
        ->title(sprintf("%s challenge %s", date('F'), date('Y')))
        ->autocomplete("da")
        ->subtitle("Leetcode monthly challenge")
        ->arg($dailyChallengeLink)
       ->valid(true);

$dataStructures = collect(json_decode(file_get_contents('https://leetcode.com/problems/api/tags/'), true)['topics'])->mapWithKeys(function($item){
    return [
        $item['name'] => [
            "title" => $item["name"],
            "slug" => sprintf("/tag/%s/", $item["slug"]),
            "type" => "Category"
        ],
    ];
});



$problems = collect(json_decode(file_get_contents('https://leetcode.com/api/problems/all/'), true)['stat_status_pairs'])->mapWithKeys(function($item){
    return [
        $item['stat']['question__title'] => [
            "title" => $item['stat']['question__title'],
            "slug" => sprintf("/problems/%s/", $item['stat']['question__title_slug']),
            "type" => "Problem",
        ],
    ];
});

foreach(array_merge(array_contains_key($dataStructures->toArray(), $query), array_contains_key($problems->toArray(), $query)) as $item) {
    $workflow->result()
        ->icon('favicon.png')
        ->title($item['title'])
        ->subtitle($item["type"])
        ->arg(sprintf("https://leetcode.com%s", $item['slug']))
       ->valid(true);
}




echo $workflow->output();


function array_contains_key( array $input_array, $search_value)
{
    $preg_match = '/'.$search_value.'/i';

    $return_array = array();
    $keys = array_keys( $input_array );
    foreach ( $keys as $k ) {
        if ( preg_match($preg_match, $k) )
            $return_array[$k] = $input_array[$k];
    }
    return $return_array;
}