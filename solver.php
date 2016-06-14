<?php
    if (!isset($_GET['group1']) || !isset($_GET['group2']) || !isset($_GET['group3'])) {
        print "Must specify group1, group2, and group3.";
        return;
    }

    $group1 = $_GET['group1'];
    $group2 = $_GET['group2'];
    $group3 = $_GET['group3'];
    $multiplier1 = 2;
    $multiplier2 = 1;
    $multiplier3 = 0;

    if (isset($_GET['multiplier1']) && isset($_GET['multiplier2']) && isset($_GET['multiplier3'])) {
        $multiplier1 = $_GET['multiplier1'];
        $multiplier2 = $_GET['multiplier2'];
        $multiplier3 = $_GET['multiplier3'];
    }

    $command = "echo > words.txt; ./Letterpress --group1 $group1 --group2 $group2 --group3 $group3 --multiplier1 $multiplier1 --multiplier2 $multiplier2 --multiplier3 $multiplier3 > /dev/null";
    system($command);
    $words = fopen('words.txt', 'r');
    $mapping = array();

    while (($line = fgets($words, 1000)) !== false) {
        list($word, $score) = explode(' ', $line);
        $word = trim($word);
        $score = intval(trim($score));

        if (!empty($word)) {
            $mapping[$word] = $score;
        }
    }

    print json_encode($mapping);
?>