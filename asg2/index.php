<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ASG1 Winter18 COMP3512 by Tim Barnes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" /> 
    <link rel="stylesheet" href="css/custom.css" /> 

</head>
<body>
    <?php require 'includes/header.inc.php'; ?>
    <main class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="images/misc/home_countries.jpg" alt="Countries">
                    <div class="card-block">
                        <h4 class="card-title">Countries</h4>
                        <p class="card-text">See all countries for which we have images.</p>
                        <hr class="my-4" />
                        <a href="browse-countries.php" class="btn btn-secondary">View Countries</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="images/misc/home_images.jpg" alt="Images">
                    <div class="card-block">
                        <h4 class="card-title">Images</h4>
                        <p class="card-text">See all of our travel images.</p>
                        <hr class="my-4" />
                        <a href="browse-images.php" class="btn btn-secondary">View Images</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="images/misc/home_users.jpg" alt="Users">
                    <div class="card-block">
                        <h4 class="card-title">Users</h4>
                        <p class="card-text">See information about our contributing users.</p>
                        <hr class="my-4" />
                        <a href="browse-users.php" class="btn btn-secondary">View Users</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
      <?php include 'includes/footer.inc.php'; ?>
    </footer>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>