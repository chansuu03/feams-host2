<table class="table table-hover" id="discussions">
    <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 10%">#</th>
          <th scope="col" style="width: 30%">Title</th>
          <th scope="col" style="width: 25%">Creator</th>
          <th scope="col" style="width: 20%">Created at</th>
          <th scope="col" style="width: 20%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $ctr = 1?>
        <?php foreach($threads as $thread):?>
          <tr>
            <th><?= esc($ctr)?></th>
            <td><?= esc($thread['subject'])?></td>
            <td><?= esc($thread['first_name'])?> <?= esc($thread['last_name'])?></td>
            <td><?= esc(date('F d,Y', strtotime($thread['created_at'])))?></td>
            <td class="d-flex justify-content-center">
              <a class="btn btn-info btn-sm" href="<?= base_url('discussions/manage')?>/<?= esc($thread['id'])?>" role="button" data-toggle="tooltip" data-placement="bottom" title="View discussion"><i class="fas fa-bars"></i></a>
            </td>
          </tr>
          <?php $ctr++;?>
        <?php endforeach?>
    </tbody>
</table>

<script>
  // DataTables
  $(function () {
    $('#discussions').DataTable({
        "responsive": true,
        "autoWidth": false,
      });
  });
</script>