<?php $start = strtotime($start)?>
<?php $end = strtotime($end)?>

<h4 style="text-align: center;"> List of All Contributions </h4>
<h5 style="text-align: center;">From date: <?= date('F d,Y', $start)?> - <?= date('F d,Y',$end)?></h5>
<br>
<table cellspacing="0" cellpadding="5" border="1" style="margin-left: auto; margin-right: auto; margin-top: 5px;">
  <tr style="text-align: center;">
    <td width="5%"> <b>#</b> </td>
    <td width="30%"> <b>Contribution</b> </td>
    <td width="20%"> <b>Cost</b> </td>
    <td width="20%"> <b>Total Paid Amount</b> </td>
    <td width="25%"> <b>Date started</b> </td>
  </tr>
  <?php if (empty($contri)): ?>
    <tr>
      <td colspan="5" style="text-align: center;"> No Available Data </td>
    </tr>
  <?php else: ?>
    <?php $ctr = 1; ?>
    <?php foreach ($contri as $cont): ?>
      <tr style="text-align: justify;">
        <td style="text-align: center; vertical-align: middle;"> <?=$ctr?> </td>
        <td style="text-align: center; vertical-align: middle;"> <?=$cont['name']?> </td>
        <td style="text-align: center; vertical-align: middle;"> <?=$cont['cost']?> </td>
        <td style="text-align: center; vertical-align: middle;"> <?=$cont['amount']?> </td>
        <td style="text-align: center; vertical-align: middle;"> <?=$cont['created_at']?> </td>
        </tr>
      <?php $ctr++; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</table>
