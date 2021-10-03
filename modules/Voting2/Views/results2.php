<!-- </pre> -->
<div class="container mt-2">
    <div class="row">
        <!-- Full-time -->
        <div class="col-md-4">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center">Full-time employees</li>
                    <?php foreach($voteDetails as $vote):?>
                        <?php if($vote['user_type'] == '1'):?>
                            <li class="list-group-item">
                                <?= esc($vote['first_name'])?> <?= esc($vote['last_name'])?>
                            </li>  
                        <?php endif?>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <!-- Part-time -->
        <div class="col-md-4">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center">Part-time employees</li>
                    <?php foreach($voteDetails as $vote):?>
                        <?php if($vote['user_type'] == '2'):?>
                            <li class="list-group-item">
                                <?= esc($vote['first_name'])?> <?= esc($vote['last_name'])?>
                            </li>  
                        <?php endif?>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <!-- Admin -->
        <div class="col-md-4">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center">Admin employees</li>
                    <?php foreach($voteDetails as $vote):?>
                        <?php if($vote['user_type'] == '3'):?>
                            <li class="list-group-item">
                                <?= esc($vote['first_name'])?> <?= esc($vote['last_name'])?>
                            </li>  
                        <?php endif?>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>