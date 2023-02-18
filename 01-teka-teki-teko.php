<?php
/**
 * @throws Exception
 */
function tekaTekiTeko(int $batas) {
    if ($batas < 20) {
        throw new \RuntimeException('Error! Nilai minimum batas adalah 20!');
        exit();
    }

    for ($i = 1; $i <= $batas; $i++) {
        $modifyTwo = $i % 2;
        $modifyThree = $i % 3;
        $modifyFive = $i % 5;

        if ($modifyTwo === 0 && $modifyThree === 0 && $modifyFive === 0) {
            echo "TekaTekiTeko" . PHP_EOL;
        } else if ($modifyTwo !== 0 && $modifyThree === 0 && $modifyFive === 0) {
            echo "TekiTeko" . PHP_EOL;
        } else if ($modifyTwo === 0 && $modifyThree !== 0 && $modifyFive === 0) {
            echo "TekaTeko" . PHP_EOL;
        } else if ($modifyTwo === 0 && $modifyThree === 0 && $modifyFive !== 0) {
            echo "TekaTeki" . PHP_EOL;
        } else if ($modifyTwo !== 0 && $modifyThree !== 0 && $modifyFive === 0) {
            echo "Teko" . PHP_EOL;
        } else if ($modifyTwo !== 0 && $modifyThree === 0 && $modifyFive !== 0) {
            echo "Teki" . PHP_EOL;
        } else if ($modifyTwo === 0 && $modifyThree !== 0 && $modifyFive !== 0) {
            echo "Teka" . PHP_EOL;
        } else {
            echo $i . PHP_EOL;
        }
    }
}

// tekaTekiTeko(30); // should get exception
tekaTekiTeko(30);
