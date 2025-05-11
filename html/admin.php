<?php
    include '../php/connectdb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/admin.css">
    <title>OnTheSide Admin</title>
</head>
<body>
    <div class="logo-container">
        <img src="../images/cafeLogo.png" alt="">
    </div>
    <div class="layer-two">
        <div class="l2-left">
            <h1 class="title">Current Menu Display</h1>
            <div class="content-boxes">
                    <?php

                    $query = "SELECT id, item_name, price, availability ,img FROM drinks";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $itemCount = 0;
                        

                        echo '<div class="cb-layer">';
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($itemCount > 0 && $itemCount % 5 === 0) {
                                echo '</div><div class="cb-layer">';
                            }
                            
                            echo '<div class="item-box" onclick="selectItem(this)" data-id="'.htmlspecialchars($row['id']).'">';
                            echo '<img src="data:image/png;base64,'.base64_encode($row['img']).'" alt="'.htmlspecialchars($row['item_name']).'" class="item-img">';
                            echo '<h1>'.htmlspecialchars($row['item_name']).'</h1>';
                            
                            if (!empty($row['price']) && $row['price'] > 0) {
                                echo '<p>P'.htmlspecialchars($row['price']).'</p>';
                            } else {
                                echo '<p>$NULL</p>';
                            }
                            
                            echo '<div class="availableContainer">';
                            echo '<input type="checkbox" name="available_'.$itemCount.'" id="available_'.$itemCount.'"
                            '.($row['availability'] ? 'checked' : '').'>';
                            echo '<label for="available_'.$itemCount.'">Is This Available?</label>';
                            echo '</div>';
                            echo '</div>';
                            
                            $itemCount++;
                        }
                        
                        echo '</div>';
                    } else {
                        echo '<p>No drinks available at the moment.</p>';
                    }


                    
                    ?>
            </div>
        </div>  
        <div class="l2-right">
            <nav>
                <a onclick="createItem()" style="cursor: pointer;">> Create</a>
                <a onclick="deleteSelectedItem()" style="cursor: pointer;">> Delete</a>
                <a onclick="popupOpen()" style="cursor: pointer;">> Edit</a>
            </nav>
        </div>
    </div>

    <div class="create-edit_popup">
        <div class="popup-window">
            <div class="title-popup">
                <h1>EDIT</h1>
            </div>
            <div class="popup-content">
                <div class="preview">

                </div>
                <div class="edit-menu">
                    <div class="edit-top">
                        <div class="form-container">
                            <label for="ProdName">
                                Product Name:
                            </label>
                            <input type="text" name="ProdName" id="" placeholder="name">
                        </div>
                        <div class="form-container">
                            <label for="ProdName">
                                Price:
                            </label>
                            <input type="text" name="ProdName" id="priceInput" placeholder="₱">
                            <p>₱</p>
                        </div>
                        <div class="form-container">
                            <label for="ProdName">
                                Image File: 
                            </label>
                            <input type="file" name="image" id="imageUpload" class="specialInfo">
                        </div>
                        <div class="form-container">
                            <label for="availableCheckbox">
                                Available: 
                            </label>
                            <input type="checkbox" name="availableCheckbox" id="availableCheckbox">
                        </div>
                    </div>
                    <div class="edit-confirm">
                        <button class="goods" onclick="saveItemChanges()">DONE</button>
                        <button class="notgoods" onclick="popupClose()">CANCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>    
        let selectedItem;
        let selectedItemId;

        function popupOpen(){
            if(!selectedItem){
                alert(`Please select an item first`);
                return;
            }

        // get item details
        selectedItemId = selectedItem.getAttribute('data-id');
        const itemName = selectedItem.querySelector('h1').textContent;
        const itemPrice = selectedItem.querySelector('p').textContent;
        const itemImg = selectedItem.querySelector('img').src;
        const isAvailable = selectedItem.querySelector('input[type="checkbox"]').checked;

        //edit form contents
        const nameInput = document.querySelector('.popup-window input[type="text"][placeholder="name"]');
        const priceInput = document.querySelector('#priceInput');
        const fileInput = document.querySelector('.popup-window input[type="file"]');
        const previewDiv = document.querySelector('.preview');

        nameInput.value = itemName;
    
        // Clean price (remove ₱ or $ if present)
        const cleanPrice = itemPrice.replace(/[^\d.]/g, '');
        priceInput.value = cleanPrice;
    
    
        document.querySelector('.create-edit_popup').classList.add('toggled');

        }

async function saveItemChanges() {
    const newName = document.querySelector('.popup-window input[type="text"][placeholder="name"]').value;
    const newPrice = document.querySelector('#priceInput').value;
    const isAvailable = document.querySelector('.popup-window input[type="checkbox"]').checked;
    const fileInput = document.querySelector('.popup-window input[type="file"]');
    
    // Input validation
    if (!newName || !newPrice) {
        alert('Please fill in all fields');
        return;
    }

    // Create FormData to handle file upload
    const formData = new FormData();
    formData.append('id', selectedItemId);
    formData.append('name', newName);
    formData.append('price', newPrice);
    formData.append('availability', isAvailable ? '1' : '0');
    
    if (fileInput.files[0]) {
        formData.append('image', fileInput.files[0]);
    }
    
    try {
        const response = await fetch('../php/updateItem.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Update the item display
            selectedItem.querySelector('h1').textContent = newName;
            selectedItem.querySelector('p').textContent = '₱' + newPrice;
            selectedItem.querySelector('input[type="checkbox"]').checked = isAvailable;
            
            // Update image if a new one was uploaded
            if (result.newImage) {
                selectedItem.querySelector('.item-img').src = result.newImage;
            }
            
            // Clear the file input
            fileInput.value = '';
            
            popupClose();
        } else {
            alert('Error updating item: ' + (result.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while updating the item');
    }
}


        function popupClose(){
            document.querySelector(`.create-edit_popup`).classList.remove(`toggled`);
        }

        async function createItem() {
    try {
        // Create new item in database
        const response = await fetch('../php/createItem.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: 'Edit to Change',
                price: 0,
                availability: 0
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Add the new item to the UI
            const item_containers = document.querySelector('.content-boxes');
            const layers = item_containers.querySelectorAll('.cb-layer');
            const itemsPerLayer = 5;
            
            let currentLayer;
            if(layers.length === 0) {
                currentLayer = document.createElement('div');
                currentLayer.className = 'cb-layer';
                item_containers.appendChild(currentLayer);
            } else {
                currentLayer = layers[layers.length - 1];
            }

            if (currentLayer.querySelectorAll('.item-box').length >= itemsPerLayer) {
                currentLayer = document.createElement('div');
                currentLayer.className = 'cb-layer';
                item_containers.appendChild(currentLayer);
            }

            const itemBoxToAdd = document.createElement('div');
            itemBoxToAdd.className = 'item-box';
            itemBoxToAdd.setAttribute('data-id', result.id);
            itemBoxToAdd.innerHTML = `
                <img src="" alt="Edit to Change" class="item-img">
                <h1>Edit to Change</h1>
                <p>₱0</p>
                <div class="availableContainer">
                    <input type="checkbox" name="" id="" ${result.availability ? 'checked' : ''}>
                    <label for="">Is This Available?</label>
                </div>
            `;
            itemBoxToAdd.addEventListener('click', function() {
                selectItem(this);
            });
            currentLayer.appendChild(itemBoxToAdd);
            
            // Select the newly created item
            selectItem(itemBoxToAdd);
        } else {
            alert('Error creating item: ' + (result.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while creating the item');
    }
}
        
async function deleteSelectedItem() {
    if (!selectedItem) {
        alert('Please select an item first');
        return;
    }

    const itemId = selectedItem.getAttribute('data-id');

    try {
        const response = await fetch('../php/deleteItem.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: itemId })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Remove the item from the UI
            selectedItem.remove();
            selectedItem = null;
            
            // Reorganize items in layers if needed
            reorganizeItems();
        } else {
            alert('Error deleting item: ' + (result.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting the item');
    }
}

function reorganizeItems() {
    const itemContainers = document.querySelector('.content-boxes');
    const layers = itemContainers.querySelectorAll('.cb-layer');
    const allItems = [];
    const itemsPerLayer = 5;
    
    // Collect all items
    layers.forEach(layer => {
        const items = Array.from(layer.querySelectorAll('.item-box'));
        allItems.push(...items);
        layer.remove(); // Remove all layers
    });
    
    // Recreate layers with items
    let currentLayer;
    allItems.forEach((item, index) => {
        if (index % itemsPerLayer === 0) {
            currentLayer = document.createElement('div');
            currentLayer.className = 'cb-layer';
            itemContainers.appendChild(currentLayer);
        }
        currentLayer.appendChild(item);
    });
}

        
        function selectItem(itemElement){
            if(selectedItem){
            selectedItem.classList.remove(`pressed`);
            }

            selectedItem = itemElement;
            selectedItem.classList.add(`pressed`);
        }
    </script>
</body>
</html>