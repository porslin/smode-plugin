<?php

global $wpdb;

// Define database table names
$table_questions = $wpdb->prefix.'smode_questions';
$table_answers = $wpdb->prefix.'smode_answers';

// Fetch the data from the database
$sql = "SELECT a.id, a.questionId, q.title, a.control_value, a.created_at, a.created_by, a.modified_at, a.modified_by
        FROM $table_answers AS a
        JOIN $table_questions AS q ON a.questionId = q.id
        ORDER BY a.id";
$result = $wpdb->get_results($sql);

// Start HTML table
?>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Question ID</th>
      <th>Question Title</th>
      <th>Control Value</th>
      <th>Created At</th>
      <th>Created By</th>
      <th>Modified At</th>
      <th>Modified By</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($result as $row): ?>
      <tr>
        <td><?php echo $row->id; ?></td>
        <td><?php echo $row->questionId; ?></td>
        <td><?php echo $row->title; ?></td>
        <td><?php echo $row->control_value; ?></td>
        <td><?php echo $row->created_at; ?></td>
        <td><?php echo $row->created_by; ?></td>
        <td><?php echo $row->modified_at; ?></td>
        <td><?php echo $row->modified_by; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
