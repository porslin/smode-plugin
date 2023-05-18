<?php

//insert data in table for plugin

function SMP_insert_data() {

    if(isset($_POST['save'])) {
        
        global $wpdb;
        $table_name = $wpdb->prefix.'smode_questions';

        $title          = $_POST['title'];
        $categoryId     = $_POST['categoryId'];
        $controlType    = $_POST['controlType'];
        
        echo $title;

    
        $wpdb->insert($table_name,
                    array(
                        'title'=> $title,
                        'categoryId'=> $categoryId,
                        'controlType'=> $controlType
                    ),
                    array(
                        '%s', 
                        '%s', 
                        '%s'
                    )
                );
        }
       
}

?>

<form method="POST">
    <H2>Kontrollfrågor</H2>
    
    <label>Frågan: </label>
    <input type="text" name="title" />
    <br>
    <p>Kategori: </p>
        <input type="radio" id="1" name="categoryId" value="1">
        <label for="1">Webbläsare</label><br>
        <input type="radio" id="2" name="categoryId" value="2">
        <label for="2">Innehåll</label><br>
        <input type="radio" id="3" name="categoryId" value="3">
        <label for="3">Prestanda</label><br>
        <input type="radio" id="4" name="categoryId" value="4">
        <label for="4">Säkerhet & Trovärdighet</label><br>
        <input type="radio" id="5" name="categoryId" value="5">
        <label for="5">Funktionalitet</label><br>
        <input type="radio" id="6" name="categoryId" value="6">
        <label for="6">SEO</label><br>
        <input type="radio" id="7" name="categoryId" value="7">
        <label for="7">Wordpress</label><br>
        <input type="radio" id="8" name="categoryId" value="8">
        <label for="8">Woocommerce</label><br>

    <p>Kontrolltyp: </p>
        <input type="radio" id="checkbox" name="controlType" value="checkbox">
        <label for="checkbox">Checkbox</label><br>
        <input type="radio" id="text" name="controlType" value="text">
        <label for="text">Text</label><br>
        <input type="radio" id="button" name="controlType" value="button">
        <label for="button">Button</label><br><br>

    <button type="submit" name="save">Spara</button>

</form>

