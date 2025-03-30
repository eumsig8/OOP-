<?php
class Collatz {
    private $start;

    // Constructor to initialize the start number
    public function __construct($start) {
        $this->start = $start;
    }

    // Method to calculate the Collatz sequence for a single number
    public function collatzConjecture($n) {
        $con_seq = [];
        while ($n != 1) {
            $con_seq[] = $n;
            if ($n % 2 == 0) {
                $n = $n / 2;
            } else {
                $n = 3 * $n + 1;
            }
        }
        $con_seq[] = 1;
        return $con_seq;
    }

    // Method to calculate the max value and iteration count for a single number
    public function collatzMax($n) {
        $con_seq = $this->collatzConjecture($n);
        $max_val = max($con_seq);
        $iter = count($con_seq) - 1; 
        return [$max_val, $iter];
    }

    // Method to perform calculations for a given interval
    public function collatzRange($start, $end) {
        $results = [];
        for ($n = $start; $n <= $end; $n++) {
            list($max_val, $iter) = $this->collatzMax($n);
            $results[] = [$n, $max_val, $iter];
        }
        return $results;
    }

    // Method to calculate statistics
    public function statistics($start, $end) {
        $results = $this->collatzRange($start, $end);

        if (empty($results)) {
            return [null, null, null];
        }

        $max_iter = $results[0];
        $min_iter = $results[0];
        $max_val = $results[0];

        foreach ($results as $result) {
            if ($result[2] > $max_iter[2]) {
                $max_iter = $result;
            }
            if ($result[2] < $min_iter[2]) {
                $min_iter = $result;
            }
            if ($result[1] > $max_val[1]) {
                $max_val = $result;
            }
        }
        return [$max_iter, $min_iter, $max_val];
    }
}
?>
