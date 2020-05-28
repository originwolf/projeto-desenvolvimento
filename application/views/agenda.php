<?php $this->load->view('header'); ?>
<script>
    window.onload = function(){
      carregar_fonte()
    }
  </script>
<!--//====================================================================================================-->
<?php switch($pagina):
//====================================================================================================
	case 'listar': ?>
	<section id="listar" class="bg-cinza">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mx-auto bg-light rounded shadow p-3">
					<div class="border rounded my-3 shadow bg-success text-white">
						<h5 class="text-center my-2"><?php echo $titulo ?></h5>
					</div>
					<div class="border rounded my-3 shadow bg-white">
						<p class="text-center my-2"><?php echo 'Evento: ' . $evento->evento ?></p>
					</div>
					<div class="border rounded my-3 shadow bg-white">
						<p class="text-center my-2"><?php echo 'Atividade: ' . $atividade->atividade ?></p>
					</div>					
					<?php $this->load->view('mensagem'); ?>					
					<div class="container my-3 border bg-white rounded shadow">
						<div class="row">
							<div class="container col-6 text-left py-2">
								<div>
									<a href="<?php echo base_url('agenda/cadastrar/') . $evento->id_evento . '/' . $atividade->id_atividade ?>" class="text-secondary">Nova Agenda</a>
								</div>
							</div>
							<div class="container col-6 text-right py-1">
								<div>
									<a href="<?php echo base_url('agenda/cadastrar/') . $evento->id_evento . '/' . $atividade->id_atividade ?>" class="btn btn-success btn-sm shadow"><i class="fas fa-plus-square"></i> Cadastrar</a>
								</div>
							</div>
						</div>
					</div>
					<?php if(isset($agendas) && sizeof($agendas) > 0): ?>
					<div class="table-responsive-md">
						<table class="table rounded shadow" align="center" id="tabela">
							<thead class="bg-success text-white" align="center">
								<tr class="rotulo-tabela">
									<th class="text-left">Dia</th>
									<th class="text-left">Início</th>
									<th class="text-left">Término</th>									
								</tr>
							</thead>
							<tbody class="bg-white">
								<?php foreach ($agendas as $agenda): ?>
									<tr>
										<td align="left" id="dia"><a href="<?php echo base_url('agenda/exibir/' . $evento->id_evento . '/' . $atividade->id_atividade . '/' . $agenda->id_agenda) ?>" class="text-dark"><?php echo date('d/m/Y', strtotime($agenda->dia)) ?></a></td>		
										<td align="left" id="hora_inicio"><a href="<?php echo base_url('agenda/exibir/' . $evento->id_evento . '/' . $atividade->id_atividade . '/' . $agenda->id_agenda) ?>" class="text-dark"><?php echo date('H:i', strtotime($agenda->hora_inicio)) ?></a></td>
										<td align="left" id="hora_termino"><a href="<?php echo base_url('agenda/exibir/' . $evento->id_evento . '/' . $atividade->id_atividade . '/' . $agenda->id_agenda) ?>" class="text-dark"><?php echo date('H:i', strtotime($agenda->hora_termino)) ?></a></td>						
									</tr>   
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			<div class="form-group pt-3 text-center">			
				<a href="<?php echo base_url('atividade/listar/'.$evento->id_evento)?>" class="btn btn-danger shadow botao">Voltar</a>
			</div>
			<?php echo form_close(); ?>
			</div>
		</div>
	</div> 
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'cadastrar': ?>
<section id="cadastrar" class="bg-cinza">
	<div class="container">
		<div class="row">
			<div class="col-md-8 mx-auto bg-light rounded shadow p-4">
				<div class="border rounded my-3 shadow bg-success text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo 'Evento: ' . $evento->evento ?></p>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo 'Atividade: ' . $atividade->atividade ?></p>
				</div>
				<?php $this->load->view('mensagem'); ?>

				<?php echo form_open('agenda/cadastrar/' . $evento->id_evento . '/' . $atividade->id_atividade); ?>	
				<div class="form-row">
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Dia', 'dia', array('class' => 'text-secondary')); ?>
					<?php echo form_input('dia', set_value('dia'), array('autofocus' => 'autofocus', 'class' => 'data form-control shadow', 'placeholder' => '__/__/____')); ?><i class="fas fa-calendar-check"></i>
				</div>
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Hora início', 'hora_inicio', array('class' => 'text-secondary')); ?>
					<?php echo form_input('hora_inicio', set_value('hora_inicio'), array('class' => 'hora form-control shadow', 'placeholder' => '__:__')); ?><i class="fas fa-clock"></i>
				</div>
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Hora término', 'hora_termino', array('class' => 'text-secondary')); ?>
					<?php echo form_input('hora_termino', set_value('hora_termino'), array('class' => 'hora form-control shadow', 'placeholder' => '__:__')); ?><i class="fas fa-clock"></i>
				</div>				
				</div>
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-success shadow botao')); ?>
				<a href="<?php echo base_url('agenda/listar/'.$atividade->id_atividade)?>" class="btn btn-danger shadow botao">Cancelar</a>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'exibir': ?>
<section id="exibir" class="bg-cinza">
	<div class="container">
		<div class="row">
			<div class="col-md-8 mx-auto bg-light rounded shadow p-4">
				<div class="border rounded my-3 shadow bg-success text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo 'Evento: ' . $evento->evento ?></p>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo 'Atividade: ' . $atividade->atividade ?></p>
				</div>
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open(''); ?>
				<div class="form-row">
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Dia', 'dia', array('class' => 'text-secondary')); ?>
					<?php echo form_input('dia', set_value('dia', date('d/m/Y', strtotime($agenda->dia))), array('class' => 'data form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-calendar-check"></i>
				</div>
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Hora início', 'hora_inicio', array('class' => 'text-secondary')); ?>
					<?php echo form_input('hora_inicio', set_value('hora_inicio', $agenda->hora_inicio), array('class' => 'hora form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-clock"></i>
				</div>
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Hora término', 'hora_termino', array('class' => 'text-secondary')); ?>
					<?php echo form_input('hora_termino', set_value('hora_termino', $agenda->hora_termino), array('class' => 'hora form-control shadow',  'readonly' => 'TRUE')); ?><i class="fas fa-clock"></i>
				</div>				
				</div>
			<div class="form-group pt-3 text-center">				
				<a href="<?php echo base_url('agenda/editar/' . $evento->id_evento . '/' . $atividade->id_atividade . '/' . $agenda->id_agenda) ?>" class="botao btn btn-success shadow">Editar</a>	
				<a href="<?php echo base_url('agenda/excluir/' . $evento->id_evento . '/' . $atividade->id_atividade . '/' . $agenda->id_agenda) ?>" class="botao btn btn-warning shadow">Excluir</a>
				<a href="<?php echo base_url('agenda/listar/'.$atividade->id_atividade)?>" class="btn btn-danger shadow botao">Voltar</a>
				</div>			
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'editar': ?>
<section id="editar" class="bg-cinza">
	<div class="container">
		<div class="row">
			<div class="col-md-8 mx-auto bg-light rounded shadow p-4">
				<div class="border rounded my-3 shadow bg-primary text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo 'Evento: ' . $evento->evento ?></p>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo 'Atividade: ' . $atividade->atividade ?></p>
				</div>
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open(''); ?>				
				<div class="form-row">
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Dia', 'dia', array('class' => 'text-secondary')); ?>
					<?php echo form_input('dia', set_value('dia', date('d/m/Y', strtotime($agenda->dia))), array('autofocus' => 'autofocus', 'class' => 'data form-control shadow')); ?><i class="fas fa-calendar-check"></i>
				</div>
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Hora início', 'hora_inicio', array('class' => 'text-secondary')); ?>
					<?php echo form_input('hora_inicio', set_value('hora_inicio', $agenda->hora_inicio), array('class' => 'hora form-control shadow')); ?><i class="fas fa-clock"></i>
				</div>
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Hora término', 'hora_termino', array('class' => 'text-secondary')); ?>
					<?php echo form_input('hora_termino', set_value('hora_termino', $agenda->hora_termino), array('class' => 'hora form-control shadow')); ?><i class="fas fa-clock"></i>
				</div>				
				</div>
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-primary shadow botao')); ?>
				<a href="<?php echo base_url('agenda/exibir/' . $evento->id_evento . '/' . $atividade->id_atividade . '/' . $agenda->id_agenda)?>" class="btn btn-danger shadow botao">Cancelar</a>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'excluir': ?>
<section id="excluir" class="bg-cinza">
	<div class="container">
		<div class="row">
			<div class="col-md-8 mx-auto bg-light rounded shadow p-4">
				<div class="border rounded my-3 shadow bg-success text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo 'Evento: ' . $evento->evento ?></p>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo 'Atividade: ' . $atividade->atividade ?></p>
				</div>						
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open(''); ?>				
				<div class="form-row">
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Dia', 'dia', array('class' => 'text-secondary')); ?>
					<?php echo form_input('dia', set_value('dia', date('d/m/Y', strtotime($agenda->dia))), array('class' => 'data form-control shadow',  'readonly' => 'TRUE')); ?><i class="fas fa-calendar-check"></i>
				</div>
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Hora início', 'hora_inicio', array('class' => 'text-secondary')); ?>
					<?php echo form_input('hora_inicio', set_value('hora_inicio', $agenda->hora_inicio), array('class' => 'hora form-control shadow',  'readonly' => 'TRUE')); ?><i class="fas fa-clock"></i>
				</div>
				<div class="icone_campo form-group col-md-4">
					<?php echo form_label('Hora término', 'hora_termino', array('class' => 'text-secondary')); ?>
					<?php echo form_input('hora_termino', set_value('hora_termino', $agenda->hora_termino), array('class' => 'hora form-control shadow',  'readonly' => 'TRUE')); ?><i class="fas fa-clock"></i>
				</div>				
				</div>			
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Excluir', array('class' => 'btn btn-success shadow botao')); ?>
				<a href="<?php echo base_url('agenda/exibir/' . $evento->id_evento . '/' . $atividade->id_atividade . '/' . $agenda->id_agenda)?>" class="btn btn-danger shadow botao">Cancelar</a>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php endswitch; ?>
<?php $this->load->view('footer'); ?>
<!---->