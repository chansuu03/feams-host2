<?php $start = strtotime($start)?>
<?php $end = strtotime($end)?>

<h3 style="text-align: center;">Paid for the contributions</h3>
<h4 style="text-align: center;">Dates: <?= date('F d,Y', $start)?> - <?= date('F d,Y',$end)?></h4>

<br>
<div style="width: 100%">
  <table cellspacing="0" cellpadding="5" border="1" style="margin-left: auto; margin-right: auto; margin-top: 5px; width: 100%;">
    <tr style="text-align: center;">
      <td width="5%"> <b>#</b> </td>
      <td width="25%"> <b>Contributor</b> </td>
      <td width="20%"> <b>Contribution</b> </td>
      <td width="20%"> <b>Amount Paid</b> </td>
      <td width="30%"> <b>Date paid</b> </td>
    </tr>
    <?php if (empty($payments)): ?>
      <tr>
        <td colspan="5" style="text-align: center;"> No Available Data </td>
      </tr>
    <?php else: ?>
      <?php $ctr = 1; ?>
      <?php foreach ($payments as $pay): ?>
        <tr style="text-align: justify;">
          <td style="text-align: center; vertical-align: middle;"> <?=$ctr?> </td>
          <td style="text-align: center; vertical-align: middle;"> <?=$pay['name']?> </td>
          <td style="text-align: center; vertical-align: middle;"> <?=$pay['contriName']?> </td>
          <td style="text-align: center; vertical-align: middle;"> <?=$pay['amount']?> </td>
          <td style="text-align: center; vertical-align: middle;"> <?=$pay['created_at']?> </td>
          </tr>
        <?php $ctr++; ?>
      <?php endforeach; ?>
      <tr>
        <td colspan="5"style="text-align: right;">Total: <?= esc($totalPayment)?>.00</td>
      </tr>
    <?php endif; ?>
  </table>
</div>