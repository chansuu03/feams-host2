<!-- Modal -->
<form action="<?= base_url()?>/payments/feedback" method="post" enctype='multipart/form-data'>
  <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="feedbackLabel">Send feedback to admins</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" id="feedUserID">
          <!-- Subject -->
          <div class="form-group">
            <label for="formGroupExampleInput">Subject</label>
            <input type="text" class="form-control <?=isset(session()->getFlashdata('feedErrors')['subject']) ? 'is-invalid': ''?>" id="subject" placeholder="" name="subject">
            <small id="passwordHelpBlock" class="form-text text-muted">
              Limit subject up to 100 characters only.
            </small>
            <?php if(isset(session()->getFlashdata('feedErrors')['subject'])):?>
                <div class="text-danger" style="font-size: 80%; color: #dc3545; margin-top: .25rem;">
                    <?=esc(session()->getFlashdata('feedErrors')['subject'])?>
                </div>
            <?php endif;?>
          </div>
          <!-- Comment -->
          <div class="form-group">
            <label for="formGroupExampleInput2">Comment</label>
            <textarea class="form-control <?=isset(session()->getFlashdata('feedErrors')['comment']) ? 'is-invalid': ''?>" id="comment" name="comment" rows="3"></textarea>
            <?php if(isset(session()->getFlashdata('feedErrors')['comment'])):?>
                <div class="text-danger" style="font-size: 80%; color: #dc3545; margin-top: .25rem;">
                    <?=esc(session()->getFlashdata('feedErrors')['comment'])?>
                </div>
            <?php endif;?>
          </div>
          <!-- Attachment -->
          <div class="form-group">
            <label for="attachment">Attachment</label>
            <div class="custom-file"> 
                <input type="file" class="custom-file-input <?=isset(session()->getFlashdata('feedErrors')['attachment']) ? 'is-invalid': ''?>" id="attachment" name="attachment">
                <label class="custom-file-label" for="attach">Upload here</label>
            </div>
            <?php if(isset(session()->getFlashdata('feedErrors')['attachment'])):?>
                <div class="text-danger" style="font-size: 80%; color: #dc3545; margin-top: .25rem;">
                    <?=esc(session()->getFlashdata('feedErrors')['attachment'])?>
                </div>
            <?php endif;?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit">Send</button>
        </div>
      </div>
    </div>
  </div>
</form>