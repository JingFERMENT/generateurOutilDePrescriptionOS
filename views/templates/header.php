<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/img/favicon_cabp.png">
    <title>
        <?php if(isset($addApporteurController)) {
            echo $addApporteurController->getTitle() ?? '';
        } elseif(isset($title)){
            echo $title;
        } elseif(isset($addCampagneController)) {
            echo $addCampagneController->getTitle() ?? '';
        }elseif(isset($formController)){
            echo $formController->getTitle() ?? '';
        } elseif(isset($modifyApporteurController)){
            echo $modifyApporteurController->getTitle() ?? '';
        }elseif(isset($modifyCampagneController)){
            echo $modifyCampagneController->getTitle() ?? '';
        }elseif(isset($signupController)){
            echo $signupController->getTitle() ?? '';
        } else {
            echo 'Erreur 404';
        }?>
        | Généralisation outil de prescription</title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- mon fichier css -->
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>

<body>
    <header>
        <?php include __DIR__ . '/navbar.php'?>
    </header>
    
    <main class="container-fluid my-3">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-lg-8">
                <div class="bg-light rounded-3 p-4">