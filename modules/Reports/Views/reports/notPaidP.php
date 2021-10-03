<h4 style="text-align: center;"> List of Not Paid for the Contribution </h4>
<h5 style="text-align: center;">Members who need to pay for: <?= esc($contriDetails['name'])?></h5>
<br>
<table cellspacing="0" cellpadding="5" style="border: 1px solid black; margin-left: auto; margin-right: auto; margin-top: 5px;">
  <tr style="text-align: center;">
    <td width="10%" style="border: 1px solid black;"> <b>#</b> </td>
    <td width="90%" style="border: 1px solid black;"> <b>Name</b> </td>
  </tr>
  <?php if (empty($notPaid)): ?>
    <tr>
      <td colspan="5" style="text-align: center;" style='border: 1px solid black;'> No Available Data </td>
    </tr>
  <?php else: ?>
    <?php $ctr = 1; ?>
    <?php foreach ($notPaid as $not): ?>
      <tr style="text-align: justify; border: 1px solid black;">
        <td style="text-align: center; vertical-align: middle; border: 1px solid black;"> <?=$ctr?> </td>
        <td style="text-align: center; vertical-align: middle; border: 1px solid black;"> <?=esc($not)?> </td>
      </tr>
      <?php $ctr++; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</table>
