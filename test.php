<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collatz Conjecture</title>
</head>
<body>
    <h1>Collatz Conjecture</h1>
    <form action="test.php" method="get">
        <label for="start">Start Number:</label>
        <input type="number" id="start" name="start" min="10" max="1000000" required>
        <br>
        <label for="end">End Number:</label>
        <input type="number" id="end" name="end" min="10" max="1000000" required>
        <br>
        <button type="submit">Calculate</button>
    </form>

    <div class="results">
    <?php
        if (isset($_GET['start']) && isset($_GET['end'])) {
            require_once 'function.php';

            $start = (int)$_GET['start'];
            $end = (int)$_GET['end'];

            if ($start >= 10 && $start <= 1000000 && $end >= 10 && $end <= 1000000 && $start < $end) {
                $collatzHistogram = new CollatzHistogram($start);
                $results = $collatzHistogram->collatzRange($start, $end);

                foreach ($results as $result) {
                    echo "<p>Number: {$result[0]}, Max Value: {$result[1]}, Iterations: {$result[2]}</p>";
                }

                list($max_iter, $min_iter, $max_val) = $collatzHistogram->statistics($start, $end);

                if ($max_iter && $min_iter && $max_val) {
                    echo "<p><strong>Max Iterations:</strong> Number {$max_iter[0]} with {$max_iter[2]} iterations.</p>";
                    echo "<p><strong>Min Iterations:</strong> Number {$min_iter[0]} with {$min_iter[2]} iterations.</p>";
                    echo "<p><strong>Highest Value:</strong> Number {$max_val[0]} reached value {$max_val[1]}.</p>";
                }

                echo "<h3>Histogram of Iterations:</h3>";
                $histogram = $collatzHistogram->calculateHistogram($start, $end);
                foreach ($histogram as $iterations => $count) {
                    echo "<p>Iterations: $iterations, Count: $count</p>";
                }
            } else {
                echo "<h3>Please enter valid numbers between 10 and 1000000, with Start < End.</h3>";
            }
        }
    ?>
    </div>
</body>
</html>