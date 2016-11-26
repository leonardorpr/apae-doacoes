<div class="well">
	<div class="">
		<div class="page-header">
			<h2>Bancos</h2>
			<a class="btn btn-success" href="<?= site_url('banks/add');?>"><span class="glyphicon glyphicon-plus"></span> Cadastrar Banco</a>
		</div>
		<div class="row">
				<div class="form-group col-md-offset-4 col-md-4">
					<?php if($this->session->flashdata("success")): ?>
						<p class="alert alert-success alerts-hide">  <?=  $this->session->flashdata("success") ?>  </p>
					<?php endif ?>
					<?php if($this->session->flashdata("danger")): ?>
						<p class="alert alert-danger alerts-hide">  <?=  $this->session->flashdata("danger")?>  </p>
					<?php endif ?>
				</div>
			</div>
		<table class="table table-responsive table-hover">
			<thead>
				<tr>
					<th>Código</th>
					<th>Nome</th>
					<th>Telefone</th>
					<th>Agência</th>
					<th>DV</th>
					<th>Conta Corrente</th>
					<th>DV</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if(count($banks)>=1){
				foreach($banks as $bank){
			?>
				<tr>
					<td><?= $bank['id_bank'];?> </td>
					<td><?= $bank['name_bank']; ?></td>
					<td><?= $bank['phone_bank']; ?></td>
					<td><?= $bank['agency_number']; ?></td>
					<td><?= $bank['check_digit_agency']; ?></td>
					<td><?= $bank['account_number']; ?></td>
					<td><?= $bank['check_digit_account']; ?></td>
					<td>
						<div class="btn-group">
							<a class="btn btn-primary" href="<?= site_url('banks/edit')."/".$bank['id_bank'];?>"><span class="glyphicon glyphicon-edit"></span></a>
							<a type="button" data-model-id="<?= $bank['id_bank'] ?>" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-danger" ><span class="glyphicon glyphicon-trash"></span></a>
						</div>
					</td>
				</tr>
			<?php
				}
			}
			?>
			</tbody>
		</table>
	</div>
</div>

<div id="delete-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="gridSystemModalLabel">Atenção</h4>
				</div>
				<div class="modal-body">
						<div>Deseja realmente excluir esse banco?</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-success" name="Confirmar" id="Confirmar">Confirmar</button>
				</div>
		</div>
	</div>
</div>
<script type="text/javascript" language="javascript">
	(function() {
		var modelId;
		$("#delete-modal").on('show.bs.modal', function(e) {
			var button = e.relatedTarget;
			console.log(button.data('model-id'));
		})
	})();
	$('#Confirmar').click(function(e) {
				e.preventDefault();

				window.location.href =  '<?= base_url("banks/delete/").$bank["id_bank"] ?>';
	});
</script>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
			$(".alerts-hide").click(function () {
					$('.alerts-hide').hide(500);
			});
	});
</script>
