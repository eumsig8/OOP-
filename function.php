<?php
class Collatz {
    private $start;

    public function __construct($start) {
        $this->start = $start;
    }

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

    public function collatzMax($n) {
        $con_seq = $this->collatzConjecture($n);
        $max_val = max($con_seq);
        $iter = count($con_seq) - 1; 
        return [$max_val, $iter];
    }

    public function collatzRange($start, $end) {
        $results = [];
        for ($n = $start; $n <= $end; $n++) {
            list($max_val, $iter) = $this->collatzMax($n);
            $results[] = [$n, $max_val, $iter];
        }
        return $results;
    }

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

class CollatzHistogram extends Collatz {
    private const DEFAULT_START = 1;    
    private const DEFAULT_END = 100;  

    public function __construct($start = self::DEFAULT_START) {
        parent::__construct($start);
    }

    public function calculateHistogram($start, $end) {
        $results = parent::collatzRange($start, $end); 
        $histogram = [];

        foreach ($results as $result) {
            $iterations = $result[2];
            if (array_key_exists($iterations, $histogram)) {
                $histogram[$iterations]++;
            } else {
                $histogram[$iterations] = 1;
            }
        }

        ksort($histogram);
        return $histogram;
    }

    public function displayHistogram($start, $end) {
        $histogram = $this->calculateHistogram($start, $end);
        foreach ($histogram as $iterations => $count) {
            echo "Iterations: $iterations, Count: $count\n";
        }
    }
}
?>