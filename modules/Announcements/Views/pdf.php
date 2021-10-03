<!DOCTYPE html>
<html>
  <head>
    <title>Monthly Announcement Reports</title>
    <style>
      table {
        font-family: lato, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin: auto;
        border-radius: 100px;
      }

      h2 {
        text-align: center;
        font-family: lato;
        font-weight: 300;
        /* font-color: white; */
        text-transform: uppercase;
      }

      th{
        border: 1px solid #5DB1D1;
        text-align: center;
        padding-left: 10px;
        padding-top: 10px;
        padding-bottom: 10px;
        background-color:  #5DB1D1;
        color: #fff;
      }

      td{
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
      }

      tr:nth-child(even) {
        background-color: #ccd9d7;
      }
    </style>
  </head>
  <body>
    <h2>Monthly Announcement Reports</h2>
    <table>
      <tr>
        <th>Announcement Title</th>
        <th>Date Posted</th>
      </tr>
      <?php foreach($announcements as $announce):?>
        <tr>
          <td><?= esc($announce['title'])?></td>
          <td><?= esc($announce['date_posted'])?></td>
        </tr>
      <?php endforeach;?>
    </table>
  </body>
</html>
