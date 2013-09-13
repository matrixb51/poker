<?php

$poker_feed_url = 'http://winunited.feeds.merge-hosting.com/upcoming_tournaments.xml';

$currency_feed_url = 'http://www.youwin.com/en/connectors/bit8/get-exchange-rates/token/27707b83f34a8ddf455c9a6111b7aab3';

$tournaments_filters = array(
    'INTEGER_VALUES' => array(
            'total_prizepool' => array('min_range' => 1000)
            )   
);