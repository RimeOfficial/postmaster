<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>Labels <span><a href="<?php echo base_url('transaction/label/create'); ?>" class="btn btn-primary pull-right">New</a></span></h1>

<?php // var_dump($label_list); ?>

<?php if (!empty($label_list)): ?>
<table class="table">
  <!-- <caption>List</caption> -->
  <thead>
    <tr>
      <th>Name</th>
      <!-- <th>Reply-to Name</th> -->
      <!-- <th>Reply-to Email</th> -->
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($label_list as $key => $label): ?>
    <tr>
      <th scope="row"><?php echo anchor('transaction/label/modify/'.$label['label_id'], $label['name']); ?></th>
      <td><a href="<?php echo base_url('transaction/label/modify/'.$label['label_id']); ?>"><span class="glyphicon glyphicon-edit"></span></a></td>
      <td><a href="#<?php echo base_url('/'.$label['label_id']); ?>"
        data-toggle="modal"
        data-target="#label-delete-modal"
        data-label-id="<?php echo $label['label_id']; ?>"
        data-label-name="<?php echo $label['name']; ?>"
        href="#"><span class="glyphicon glyphicon-trash"></span>
      </a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>


<div class="modal fade" id="label-delete-modal" tabindex="-1" role="dialog" aria-labelledby="label-delete-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="label-delete-modal-label">Delete Label</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to delete <code></code>?<br>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-sm-5">
            <a type="button" class="btn btn-danger btn-block" href="#">Delete</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#label-delete-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var label_name = button.data('label-name') // Extract info from data-* attributes
    var label_id = button.data('label-id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body code').text(label_name)
    modal.find('.modal-footer a').attr("href", '<?php echo base_url('transaction/label/delete'); ?>' + '/' + label_id)
  });
</script>