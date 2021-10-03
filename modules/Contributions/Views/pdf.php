<!DOCTYPE html>
<html>
  <head>
    <style>
      .main {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      .main td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
      }

      .main tr:nth-child(even) {
        background-color: #dddddd;
      }
    </style>
  </head>
  <body>
    <table class="main">
      <tr>
        <th>Name</th>
        <th>Paid</th>
        <th>Status</th>
      </tr>
      <?php
        foreach($users as $user) {
          echo '<tr>';
          if($user['status'] == 'a') {
            $cost = 0;
            foreach($payments as $pay) {
              if($pay['user_id'] == $user['id'] && $pay['is_approved'] == '1') {
                      $cost += $pay['amount'];
                    }
                  }
                  if($cost === 0) {   
                    echo '<td>'.$user['first_name'].' '.$user['last_name'].'</td>';
                    echo '<td>0</td>';
                    echo '<td>Not paid</td>';
                  } elseif($cost < $cont['cost']) {
                    $total = $cont['cost'] - $cost;
                    echo '<td>'.$user['first_name'].' '.$user['last_name'].'</td>';
                    echo '<td>'.$cost.'</td>';
                    echo '<td>Partially paid</td>';
              } elseif($cost == $cont['cost']) {
                    echo '<td>'.$user['first_name'].' '.$user['last_name'].'</td>';
                    echo '<td>'.$cost.'</td>';
                    echo '<td>Fully paid</td>';
              }
          }
        }
        echo '</tr>';
        ?>
    </table>
  </body>
</html>
