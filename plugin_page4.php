<?php
    echo '<div class="wrap">';
    echo '<h1>Kontroller från DB</h1>';

    echo '<h2 class="nav-tab-wrapper">';
    echo '<a class="nav-tab nav-tab-active" href="#tab1">Steg 0</a>';
    echo '<a class="nav-tab" href="#tab2">Steg 1: dev-tools</a>';
    echo '<a class="nav-tab" href="#tab3">Steg 2: inför</a>';
    echo '<a class="nav-tab" href="#tab4">Steg 3: ompekning</a>';
    echo '</h2>';

    echo '<div id="tab-content">';
    echo '<div id="tab1" class="tab-panel">';
    echo '<h2>Tab 1 Content</h2>';
    global $wpdb;

// Define database table names
$table_questions = $wpdb->prefix.'smode_questions';
$table_categories = $wpdb->prefix.'smode_categories';
$table_answers = $wpdb->prefix.'smode_answers';

// Fetch the data from the database
$sql = 
    "SELECT 
    c.title AS category_title, 
    q.id AS question_id, 
    q.title AS question_title, 
    q.controlType, a.control_value
    FROM $table_questions AS q
    JOIN $table_categories AS c ON q.categoryId = c.id 
    LEFT JOIN $table_answers AS a ON q.id = a.questionId
    WHERE c.id BETWEEN 1 AND 9
    ORDER BY c.id, q.id";

$result = $wpdb->get_results($sql);



// Initialize variables to keep track of the current category
$current_category = "";
$category_heading_displayed = false;


// Start HTML table
?>
<div class="container">
    <table> 
    <?php

    // Iterate over results and display
    foreach ($result as $row) {
        $category_title = $row->category_title;
        $question_id = $row->question_id;
        $question_title = $row->question_title;
        $control_type = $row->controlType;
        $control_value = $row->control_value;
        
        // Display category heading if it changes
        if ($category_title != $current_category) {
            if ($category_heading_displayed) {
                ?>
                </tbody>
                </table>
                <?php
            }
            ?>
            
            <h2><?php echo $category_title; ?></h2>
            <table>
            <thead>
                <tr>
                    <th>Fråga</th>
                    <th>Control</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $category_heading_displayed = true;
            $current_category = $category_title;
        }
        
        // Display question and corresponding control type
        ?>
        <tr>
            <td><?php echo $question_title; ?></td>
            <td>
            <?php
            if ($control_type == 'checkbox') {
                ?>
                <input type="checkbox" class="my-checkbox" name="<?php echo $question_title; ?>" data-question-id="<?php echo $question_id; ?>" <?php echo $control_value ? 'checked' : ''; ?>>
                <?php
            } elseif ($control_type == 'text') {
                ?>
                <input type="text" name="<?php echo $question_title; ?>">
                <?php
            } elseif ($control_type == 'button') {
                ?>
                <button>Kontrollera</button>
                <?php
            } else {
                ?>
                <span>Ingen kontroll definierat för denna fråga.</span>
                <?php
            }
            ?>
            </td>
        </tr>
    
        <?php
    }


    if ($category_heading_displayed) {
        ?>
        </tbody>
        </table>
        <?php
    }

    ?>

    </table>
</div>
<?php
    echo '</div>';


    echo '<div id="tab2" class="tab-panel" style="display:none;">';
    echo '<h2>Tab 2 Content</h2>';
    // Fetch the data from the database
$sql = 
    "SELECT 
    c.title AS category_title, 
    q.id AS question_id, 
    q.title AS question_title, 
    q.controlType, a.control_value
    FROM $table_questions AS q
    JOIN $table_categories AS c ON q.categoryId = c.id 
    LEFT JOIN $table_answers AS a ON q.id = a.questionId
    WHERE c.id = 10
    ORDER BY c.id, q.id";

$result = $wpdb->get_results($sql);



// Initialize variables to keep track of the current category
$current_category = "";
$category_heading_displayed = false;


// Start HTML table
?>
<div class="container">
    <table> 
    <?php

    // Iterate over results and display
    foreach ($result as $row) {
        $category_title = $row->category_title;
        $question_id = $row->question_id;
        $question_title = $row->question_title;
        $control_type = $row->controlType;
        $control_value = $row->control_value;
        
        // Display category heading if it changes
        if ($category_title != $current_category) {
            if ($category_heading_displayed) {
                ?>
                </tbody>
                </table>
                <?php
            }
            ?>
            
            <h2><?php echo $category_title; ?></h2>
            <table>
            <thead>
                <tr>
                    <th>Fråga</th>
                    <th>Control</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $category_heading_displayed = true;
            $current_category = $category_title;
        }
        
        // Display question and corresponding control type
        ?>
        <tr>
            <td><?php echo $question_title; ?></td>
            <td>
            <?php
            if ($control_type == 'checkbox') {
                ?>
                <input type="checkbox" class="my-checkbox" name="<?php echo $question_title; ?>" data-question-id="<?php echo $question_id; ?>" <?php echo $control_value ? 'checked' : ''; ?>>
                <?php
            } elseif ($control_type == 'text') {
                ?>
                <input type="text" name="<?php echo $question_title; ?>">
                <?php
            } elseif ($control_type == 'button') {
                ?>
                <button>Kontrollera</button>
                <?php
            } else {
                ?>
                <span>Ingen kontroll definierat för denna fråga.</span>
                <?php
            }
            ?>
            </td>
        </tr>
    
        <?php
    }


    if ($category_heading_displayed) {
        ?>
        </tbody>
        </table>
        <?php
    }

    ?>

    </table>
</div>
<?php
    echo '</div>';


    echo '<div id="tab3" class="tab-panel" style="display:none;">';
    echo '<h2>Tab 3 Content</h2>';
    // Fetch the data from the database
$sql = 
    "SELECT 
    c.title AS category_title, 
    q.id AS question_id, 
    q.title AS question_title, 
    q.controlType, a.control_value
    FROM $table_questions AS q
    JOIN $table_categories AS c ON q.categoryId = c.id 
    LEFT JOIN $table_answers AS a ON q.id = a.questionId
    WHERE c.id = 12
    ORDER BY c.id, q.id";

$result = $wpdb->get_results($sql);



// Initialize variables to keep track of the current category
$current_category = "";
$category_heading_displayed = false;


// Start HTML table
?>
<div class="container">
    <table> 
    <?php

    // Iterate over results and display
    foreach ($result as $row) {
        $category_title = $row->category_title;
        $question_id = $row->question_id;
        $question_title = $row->question_title;
        $control_type = $row->controlType;
        $control_value = $row->control_value;
        
        // Display category heading if it changes
        if ($category_title != $current_category) {
            if ($category_heading_displayed) {
                ?>
                </tbody>
                </table>
                <?php
            }
            ?>
            
            <h2><?php echo $category_title; ?></h2>
            <table>
            <thead>
                <tr>
                    <th>Fråga</th>
                    <th>Control</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $category_heading_displayed = true;
            $current_category = $category_title;
        }
        
        // Display question and corresponding control type
        ?>
        <tr>
            <td><?php echo $question_title; ?></td>
            <td>
            <?php
            if ($control_type == 'checkbox') {
                ?>
                <input type="checkbox" class="my-checkbox" name="<?php echo $question_title; ?>" data-question-id="<?php echo $question_id; ?>" <?php echo $control_value ? 'checked' : ''; ?>>
                <?php
            } elseif ($control_type == 'text') {
                ?>
                <input type="text" name="<?php echo $question_title; ?>">
                <?php
            } elseif ($control_type == 'button') {
                ?>
                <button>Kontrollera</button>
                <?php
            } else {
                ?>
                <span>Ingen kontroll definierat för denna fråga.</span>
                <?php
            }
            ?>
            </td>
        </tr>
    
        <?php
    }


    if ($category_heading_displayed) {
        ?>
        </tbody>
        </table>
        <?php
    }

    ?>

    </table>
</div>
<?php
    echo '</div>';


    echo '<div id="tab4" class="tab-panel" style="display:none;">';
    echo '<h2>Tab 4 Content</h2>';
    // Fetch the data from the database
$sql = 
    "SELECT 
    c.title AS category_title, 
    q.id AS question_id, 
    q.title AS question_title, 
    q.controlType, a.control_value
    FROM $table_questions AS q
    JOIN $table_categories AS c ON q.categoryId = c.id 
    LEFT JOIN $table_answers AS a ON q.id = a.questionId
    WHERE c.id = 13
    ORDER BY c.id, q.id";

$result = $wpdb->get_results($sql);



// Initialize variables to keep track of the current category
$current_category = "";
$category_heading_displayed = false;


// Start HTML table
?>
<div class="container">
    <table> 
    <?php

    // Iterate over results and display
    foreach ($result as $row) {
        $category_title = $row->category_title;
        $question_id = $row->question_id;
        $question_title = $row->question_title;
        $control_type = $row->controlType;
        $control_value = $row->control_value;
        
        // Display category heading if it changes
        if ($category_title != $current_category) {
            if ($category_heading_displayed) {
                ?>
                </tbody>
                </table>
                <?php
            }
            ?>
            
            <h2><?php echo $category_title; ?></h2>
            <table>
            <thead>
                <tr>
                    <th class="question-col">Fråga</th>
                    <th class="control-col">Control</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $category_heading_displayed = true;
            $current_category = $category_title;
        }
        
        // Display question and corresponding control type
        ?>
        <tr>
            <td><?php echo $question_title; ?></td>
            <td>
            <?php
            if ($control_type == 'checkbox') {
                ?>
                <input type="checkbox" class="my-checkbox" name="<?php echo $question_title; ?>" data-question-id="<?php echo $question_id; ?>" <?php echo $control_value ? 'checked' : ''; ?>>
                <?php
            } elseif ($control_type == 'text') {
                ?>
                <input type="text" name="<?php echo $question_title; ?>">
                <?php
            } elseif ($control_type == 'button') {
                ?>
                <button>Kontrollera</button>
                <?php
            } else {
                ?>
                <span>Ingen kontroll definierat för denna fråga.</span>
                <?php
            }
            ?>
            </td>
        </tr>
    
        <?php
    }


    if ($category_heading_displayed) {
        ?>
        </tbody>
        </table>
        <?php
    }

    ?>

    </table>
</div>
<?php
    echo '</div>';


    echo '</div>';

    echo '</div>';

