<?php
include "connection.php";
if (isset($_POST['submit'])) {
    $nom = isset($_POST["name"]) ? $_POST["name"] : null;
    $price = isset($_POST["price"]) ? $_POST["price"] : null;
    $category = isset($_POST["category"]) ? $_POST["category"] : null;
    $qanti = isset($_POST["qte"]) ? $_POST["qte"] : null;

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    // if (file_exists($target_file)) {
    //     echo "Sorry, file already exists.";
    //     $uploadOk = 0;
    // }


    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

            $image = "uploads/" . $_FILES["image"]["tmp_name"];
            // $image = $target_file;
            // $sql = "INSERT INTO `produit`( `libelle`, `quantite`, `prix`, `image`, `id-categorieE`) VALUES ($nom,$qanti,$price,$image,$category)";
            // $result = $conn->query($sql);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $sql = "INSERT INTO `produit` (`id-produit`, `libelle`, `quantite`, `prix`, `image`, `id-categorieE`) VALUES (NULL, '$nom', '$qanti', '$price', '$image', '$category');";
    $resultat = $conn->prepare($sql);
    $resultat->execute() or die("Erreur lors de l'execution de la requete: "  );
    // $image = "uploads/" . $_FILES["fileToUpload"]["name"];
    // $result->execute();

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD APP</title>
    <!-- CSS only -->

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <script src="/bootstrap-5.2.2-dist/js/bootstrap.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav>
        <div><a href="#"><img src="images/768px-Magicdelivery_gaming_logo.svg.png" alt=""></a></div>
        <div>
            <ul>
                <li><a href="#">GESTIONNE PAGE</a></li>
            </ul>

        </div>
        <div class="divlog"><a class="login" href="#">logout</a></div>
    </nav>
    <div class="container">
        <div class="text-center mb-4">
            <h3 class="log2">ADD NEW PRODUCT</h3>
        </div>
        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px ;" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <label class="log">Product Name</label>
                        <input type="text" class="form-control" name="name" placeholder="NAME">
                    </div>
                    <div class="col">
                        <label class="log">quantite</label>
                        <input type="text" class="form-control" name="qte" placeholder="NAME">
                    </div>
                    <div class="col">
                        <label class="log">Product Price</label>
                        <input type="text" class="form-control" name="price" placeholder="Price">
                    </div>
                    <div class="col">
                        <label class="log">Images</label>
                        <input type="file" class="form-control" name="image" placeholder="Price">
                    </div>
                    <div class="col">
                        <label class="log">Category</label>
                        <select class="form-control" name="category" id="category" onChange="getSubCat(this.value);" required="">
                            <option value="">Select Category </option>
                            <?php
                            $ret = mysqli_query($conn, "SELECT * FROM `categorie`");
                            foreach ($ret->fetch_all(MYSQLI_ASSOC) as $row) {
                            ?>
                                <option value="<?php echo $row['id-categorie']; ?>"> <?php echo $row['libelle']; ?></option>
                            <?php } ?>

                        </select>

                    </div>
                </div>

                <div class="row">
                    <button type="submit" class="btn btn-success" name="submit">Save</button>
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2
.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>