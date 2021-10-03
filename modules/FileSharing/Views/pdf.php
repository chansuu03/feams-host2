<!DOCTYPE html>
<html>
  <head>
    <title>Monthly File Reports FEAMS</title>
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
    <h2>File downloads for the month of <?= date('F')?></h2>
    <ul>
      <li>Total number of files upload: <?= $files['totalFiles'][0]['totalCount']?></li>
      <li>Total number of downloads initated: <?= $files['totalDownloads'][0]['downloads']?></li>
    </ul>
    <table>
      <tr>
        <th>File Name</th>
        <th>Number of Downloads</th>
      </tr>
      <?php foreach($files['files'] as $file):?>
        <tr>
          <td style="text-align: center;"><?= esc($file['file_name'])?></td>
          <td style="text-align: center;"><?= esc($file['downloads'])?></td>
        </tr>
      <?php endforeach;?>
    </table>
  </body>
</html>
