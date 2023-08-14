<?php

require_once(__DIR__.'/src/config/endpoints.php');

//API landing page at the root

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Landing</title>
</head>

<body style="text-align: center;">
    <h3>Please use the avalabile api endpoints:</h3>
    <ul>
        <?php

        foreach (array_keys(BASE_ENDPOINTS) as $endpoint) {
            echo "<li>$endpoint</li>";
        }

        ?>
    </ul>

</body>

</html>