<?php
    if (!isset($_GET['group1']) || !isset($_GET['group2']) || !isset($_GET['group3'])) {
        print "Must specify group1, group2, and group3.";
        return;
    }

    $group1 = $_GET['group1'];
    $group2 = $_GET['group2'];
    $group3 = $_GET['group3'];
    system("./Letterpress $group1 $group2 $group3 > /dev/null");
    $words = fopen('words.txt', 'r');
    $mapping = array();

    while (($line = fgets($words, 1000)) !== false) {
        list($word, $score) = explode(' ', $line);
        $word = trim($word);
        $score = intval(trim($score));
        $mapping[$word] = $score;
    }

    print json_encode($mapping);
?>