<table class="table table-hover" id="login_report">
    <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 10%">#</th>
          <th scope="col">Name</th>
          <th scope="col">Username</th>
          <th scope="col">Role Name</th>
          <th scope="col">Login Date</th>
        </tr>
    </thead>
    <tbody>
        <?php $ctr = 1?>
        <?php foreach($logins as $login):?>
          <tr>
            <td><?= esc($ctr)?></td>
            <td><?= esc($login['first_name'])?> <?= esc($login['last_name'])?></td>
            <td><?= esc($login['username'])?></td>
            <td><?= esc($login['role_name'])?></td>
            <td><?= esc($login['login_date'])?></td>
          </tr>
          <?php $ctr++?>
        <?php endforeach?>
    </tbody>
</table>

<script>
  // DataTables
  $(function () {
    $('#login_report').DataTable({
        "responsive": true,
        "autoWidth": false,
      });
  });
</script>