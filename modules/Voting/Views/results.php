<div class="card">
    <div class="card-body">
        <ul class="list-group">
            <?php foreach($positions as $position):?>
                <li class="list-group-item">
                    <?php foreach($votes as $vote):?>
                        <?php if($vote['position_id'] == $position['id']):?>
                            <?= $position['name']?>: <?= $vote['candidate_id']==0 ? 'Abstain' : $vote['first_name'].' '.$vote['last_name']?>
                        <?php endif;?>
                    <?php endforeach;?>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>