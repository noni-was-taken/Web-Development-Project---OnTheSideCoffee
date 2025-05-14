<!DOCTYPE html>

<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

        <title>
            OnTheSide Cafe &lt3
        </title>
        <link rel="stylesheet" href="../css/menu.css">
    </head>
    <body>
        <div class="cafeBackground">
            
        </div>
            <div class = "menu-flex-container">

                        <div class="sideViewLeft">

                            <div class="logoDisplay">   
                                <img src="../images/cafeLogo.png" alt="logo">
                            </div>

                            <div class="navigationTab">
                                <nav>
                                    <a href="index.html">Home</a>
                                    <a>Gallery</a>
                                    <a>Menu</a>
                                    <a>About Us</a>
                                    <a>Merch</a>
                                </nav>
                            </div>

                            <div class="contrastButton">
                                <a>START SIPPING!</a>
                            </div>

                            <div class="contacts">
                                <p>
                                    P. del Rosario St., Cebu City, 6000, Philippines
                                    <br><br>
                                    Phone: <a href="#">123-4567-89</a> <br>
                                    Email: <a href="#"> ontheside@coffee.ph</a>
                                </p>
                            </div>
                        </div>

                    <div class="sideViewRight">
                        <div class = "titleAndSubMenuSelectionBar">
                            <h1>MENU</h1>
                            <div class = "subSelectionMenuButtonContainer">
                                <button onclick = "changeMenu('drinksMenu')">Drinks</button>
                                <button onclick = "changeMenu('foodMenu')">Food</button>
                                <button onclick = "changeMenu('dessertMenu')">Dessert</button>
                                </div>
                        </div>
                            <div class = "rightMenu">
                            <input id="searchBar" type="text" placeholder="Search..">
                            <hr>

                                    <div id = "drinksMenu">
                                    <?php
                                    include '../php/connectdb.php';

                                    $query = "SELECT id, item_name, price, img FROM drinks WHERE availability = 1";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        echo '<div class="itemBoxContainerHorz">';
                                        $counter = 0;
                                        
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            // Start a new container after every 4 items
                                            if ($counter > 0 && $counter % 4 == 0) {
                                                echo '</div><div class="itemBoxContainerHorz">';
                                            }
                                            
                                            echo '<button id="itemObject">';
                                            echo '<div id="inneritemObjectBorderWhite">';
                                            echo '<h1 id="menuParagraph">' . htmlspecialchars($row['item_name']) . '</h1>';
                                            
                                            if (!empty($row['price']) && $row['price'] > 0) {
                                                echo '<br><br><br><br><br><br><br><br><br><br><h2>₱' . htmlspecialchars($row['price']) . '</h2>';
                                            }
                                            
                                            echo '</div>';
                                            echo '<img id="itemObjImage" src="data:image/png;base64,' . base64_encode($row['img']) . '">';
                                            echo '</button>';
                                            
                                            $counter++;
                                        }
                                        
                                        echo '</div>';
                                    } else {
                                        echo '<p>No drinks available at the moment.</p>';
                                    }
                                    ?>

                                    <div id = "foodMenu" class = "display">
                                        <div class = "itemBoxContainerHorz">
                                                    <button  id = "itemObject">
                                                        <div id = "inneritemObjectBorderWhite"><h1 id = "menuParagraph">FOOD</h1> <h1>NONE</h1></div>
                                                        <!--<img id = "itemObjImage" src = "../images/" >-->
                                                    </button>
                                                    <button  id = "itemObject">
                                                        <div id = "inneritemObjectBorderWhite"><h1 id = "menuParagraph">FOOD</h1> <h1>NONE</h1></div>
                                                       <!--<img id = "itemObjImage" src = "../images/" >-->
                                                    </button>
                                                    <button  id = "itemObject">
                                                        <div id = "inneritemObjectBorderWhite"><h1 id = "menuParagraph">FOOD</h1> <h1>NONE</h1></div>
                                                      <!--<img id = "itemObjImage" src = "../images/" >-->
                                                    </button>
                                                    <button  id = "itemObject">
                                                        <div id = "inneritemObjectBorderWhite"><h1 id = "menuParagraph">FOOD</h1> <h1>NONE</h1></div>
                                                    <!--<img id = "itemObjImage" src = "../images/" >-->
                                                    </button>

                                        </div>
                                    </div>

                                    
                                    <div id = "dessertMenu" class = "display">
                                        <div class = "itemBoxContainerHorz">
                                            <button  id = "itemObject">
                                                <div id = "inneritemObjectBorderWhite"><h1 id = "menuParagraph">DESSERT</h1> <h1>NONE</h1></div>
                                                <!--<img id = "itemObjImage" src = "../images/" >-->
                                            </button>
                                            <button  id = "itemObject">
                                                <div id = "inneritemObjectBorderWhite"><h1 id = "menuParagraph">DESSERT</h1> <h1>NONE</h1></div>
                                               <!--<img id = "itemObjImage" src = "../images/" >-->
                                            </button>
                                            <button  id = "itemObject">
                                                <div id = "inneritemObjectBorderWhite"><h1 id = "menuParagraph">DESSERT</h1> <h1>NONE</h1></div>
                                              <!--<img id = "itemObjImage" src = "../images/" >-->
                                            </button>
                                            <button  id = "itemObject">
                                                <div id = "inneritemObjectBorderWhite"><h1 id = "menuParagraph">DESSERT</h1> <h1>NONE</h1></div>
                                            <!--<img id = "itemObjImage" src = "../images/" >-->
                                            </button>
                                        </div>
                                    </div>

                            </div>

                    </div>
           </div>
       


    <script src = "../javascript/scriptMenu.js"></script>           

    </body>
</html>