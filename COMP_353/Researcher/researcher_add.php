<?php require_once '../database.php';
$db = $conn->prepare('SELECT MAX(artID) FROM testdbms.article');
$db->execute();
$newrow = ($db->fetch())[0] + 1;

if (isset($_POST['articlebtn'])) {
    $summaryList = $conn->prepare('SELECT summary 
                                    FROM testdbms.article');
    $loop = true;
    while ($loop && $row = $summaryList->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        if (strcmp($_POST['summary'], $row['fetchedSummary'])) {
            $loop = false;
        }
    }
    if ($loop) {
        $user = $conn->prepare('INSERT INTO testdbms.article 
                                VALUES(:articleID, :pubDate, :majorTop, :minorTop, :summ, :article, :authid)');
        $date = date("Y-m-d");
        $user->bindParam(':articleID', $newrow);
        $user->bindParam(':pubDate', $date);
        $user->bindParam(':majorTop', $_POST["majorTop"]);
        $user->bindParam(':minorTop', $_POST["minorTop"]);
        $user->bindParam(':summ', $_POST["summ"]);
        $user->bindParam(':article', $_POST["article"]);
        // $user->bindParam(':authtype', $_POST["authtype"]);
        $user->bindParam(':authid', $_POST["authid"]);

        $user->execute();
        header("Location: researcher.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID-19 Pandemic Progress System</title>

    <link rel="stylesheet" href="../style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../Icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Icon/favicon-16x16.png">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand navbar-organization" href="../index.php">COVID-19 Pandemic Progress System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="admin.php">My Articles <i class="bi bi-journal-text"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" style="color: white !important; pointer-events: none;" aria-current="page" href="admin_add.php">Add Articles <i class="bi bi-plus-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="admin_edit.php">Edit Articles <i class="bi bi-pencil-square"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="admin_suspend.php">Delete Articles <i class="bi bi-dash-circle"></i></a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="navbar-name" aria-current="page" href="../login.php">Logout <i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pt-3">
        <h1 class="display-4">ADD ARTICLE</h1>
        <form class="form-inline" action="researcher_add.php" method="POST">
            <div class="row mt-2">
                <label for="majorTop" class="col-form-label">Major Topic:</label>
                <div class="input-group col-lg mt-2 my-md-none">
                    <textarea id="majorTop" name="majorTop" type="text" class="form-control" rows="2" autocomplete="off" required></textarea>
                </div>
            </div>
            <div class="row">
                <label for="minorTop" class="col-form-label">Minor Topic:</label><br />
                <div class="input-group col-lg mt-2 my-md-none">
                    <textarea id="minorTop" name="minorTop" type="text" class="form-control" rows="2" autocomplete="off" required></textarea>
                </div>
            </div>

            <div class="row">
                <label for="summ" class="col-form-label">Summary:</label><br />
                <div class="input-group col-lg mt-2 my-md-none">
                    <textarea id="summ" name="summ" type="text" class="form-control texthover" maxlength="100" rows="3" autocomplete="off" required></textarea>
                </div>
            </div>

            <div class="row">
                <label for="article" class="col-form-label">Article:</label><br />
                <div class="input-group col-lg mt-2 my-md-none">
                    <textarea id="article" name="article" type="text" class="form-control texthover" rows="6" autocomplete="off" required></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-outline-dark mt-3" name="articlebtn" id="submit">
                Add Article!
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>