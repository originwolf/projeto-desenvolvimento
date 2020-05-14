<?php $this->load->view('header'); ?>
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
					<?php $this->load->view('mensagem'); ?>
					<div class="container my-3 border bg-white rounded shadow">
						<div class="row">
							<div class="container col-6 text-left py-2">								
								<a href="<?php echo base_url('atividade/cadastrar/') . $evento->id_evento ?>" class="text-secondary">Nova Atividade</a>
							</div>
							<div class="container col-6 text-right py-1">
								<div>
									<a href="<?php echo base_url('atividade/cadastrar/') . $evento->id_evento ?>" class="btn btn-success btn-sm shadow"><i class="fas fa-plus-square"></i> Cadastrar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="container my-3 border bg-white rounded shadow">
						<div class="py-3">    
							<div class="icone_campo form-group">
								<label for="filtro" class="text-secondary">Filtrar Atividade</label>
								<input type="text" class="form-control shadow" id="filtro" onkeyup="filtrar_tabela()" placeholder="Digite o nome do Atividade"><i class="fa fa-filter fa-lg fa-fw"></i>
							</div>
						</div>
					</div>
					<?php if(isset($atividades) && sizeof($atividades) > 0): ?>
					<?php $acesso = $this->session->dados_participante['acesso']; ?>					
					<div class="table-responsive-md">
						<table class="table rounded shadow" align="center" id="tabela">
							<thead class="bg-success text-white" align="center">
								<tr class="rotulo-tabela">
									<th class="text-left">Atividade&nbsp&nbsp&nbsp<small>{ <?php echo sizeof($atividades) ?> registro(s) }</small></th>
									<th class="text-left">Local</th>
									<th class="text-left">Vagas</th>
									<th class="text-left">Agenda</th>
									<?php if(recupera_permissao($acesso, INSCRICOES)): ?>
										<th class="text-center">Inscritos</th>
									<?php endif ?>
									<?php if(recupera_permissao($acesso, CHAMADAS)): ?>
										<th class="text-center">Chamada</th>
									<?php endif ?>									
								</tr>
							</thead>
							<tbody class="bg-white">							
								<?php foreach ($atividades as $atividade): ?>							
									<tr>
										<td align="left" id="nome"><a href="<?php echo base_url('atividade/exibir/' . $atividade->id_atividade) ?>" class="text-dark"><?php echo $atividade->atividade ?></a></td>			
										<td align="left" id="email"><a href="<?php echo base_url('atividade/exibir/' . $atividade->id_atividade) ?>" class="text-dark"><?php echo $atividade->local ?></td>			
										<td align="left" id="categoria"><a href="<?php echo base_url('atividade/exibir/' . $atividade->id_atividade) ?>" class="text-dark"><?php echo $atividade->vagas ?></a></td>
										<?php if(recupera_permissao($acesso, AGENDA)): ?>
											<td align="left" id="agenda"><a href="<?php echo base_url('agenda/listar/') . $atividade->id_atividade ?>" class="text-dark">
											<?php
											if(isset($atividade->agenda) && sizeof($atividade->agenda) > 0):
												foreach ($atividade->agenda as $dia_hora):						
														echo date('d/m/y', strtotime($dia_hora->dia)) . '&nbsp&nbsp&nbsp&nbsp' .
														date('H:i', strtotime($dia_hora->hora_inicio)) .'-' . 
														date('H:i', strtotime($dia_hora->hora_termino)) . '</br>';
												endforeach;
											else:
												echo "Sem agenda";
											endif; 
											?>
											</a></td>
										<?php else: ?>
											<td align="left" id="agenda">
											<?php
											if(isset($atividade->agenda) && sizeof($atividade->agenda) > 0):
												foreach ($atividade->agenda as $dia_hora):										
														echo date('d/m/y', strtotime($dia_hora->dia)) . '&nbsp&nbsp&nbsp' .
														date('H:i', strtotime($dia_hora->hora_inicio)) .'-' . 
														date('H:i', strtotime($dia_hora->hora_termino)) . '</br>';			
												endforeach;
											else:
												echo "Sem agenda";
											endif; 
											?></td>											
										<?php endif; ?>
										<?php if(recupera_permissao($acesso, INSCRICOES)): ?>
											<td align="center"><a href="<?php echo base_url('inscricao/listar/') . $evento->id_evento . '/' . $atividade->id_atividade ?>" class="botao-pequeno btn btn-success btn-sm shadow"><i class="fas fa-pencil-alt"></i></a></td>
										<?php endif; ?>
										<?php if(recupera_permissao($acesso, CHAMADAS)): ?>
											<td align="center"><a href="<?php echo base_url('chamada/listar/') . $evento->id_evento . '/' . $atividade->id_atividade ?>" class="botao-pequeno btn btn-success btn-sm shadow"><i class="fas fa-list-ul"></i></a></td>
										<?php endif; ?>										
									</tr>   
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
				<div class="form-group pt-3 text-center">
					<a href="<?php echo base_url('evento/listar')?>" class="btn btn-danger shadow botao">Voltar</a>
				</div>
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
			<div class="col-md-12 mx-auto bg-light rounded shadow p-4">
				<div class="border rounded my-3 shadow bg-primary text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo $evento->evento ?></p>
				</div>				
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open('atividade/cadastrar/' . $evento->id_evento); ?>				
				<div class="icone_campo form-group">
					<?php echo form_label('Atividade', 'atividade', array('class' => 'text-secondary')); ?>
					<?php echo form_input('atividade', set_value('atividade'), array('autofocus' => 'autofocus', 'class' => 'form-control shadow', 'placeholder' => 'Digite o título da atividade')); ?><i class="fas fa-calendar-check"></i>
				</div>
				<div class="form-row">
				<div class="icone_campo form-group col-md-9">
					<?php echo form_label('Local', 'local', array('class' => 'text-secondary')); ?>
					<?php echo form_input('local', set_value('local'), array('class' => 'form-control shadow', 'placeholder' => 'Digite o local o local da atividade')); ?><i class="fas fa-map-marker"></i>
				</div>
				<div class="icone_campo form-group col-md-3">
					<?php echo form_label('Vagas', 'vagas', array('class' => 'text-secondary')); ?>
					<?php echo form_input('vagas', set_value('vagas'), array('class' => 'form-control shadow', 'placeholder' => 'Nº Vagas')); ?><i class="fas fa-couch"></i>
				</div>
				</div>			
			<div class="form-group">
				<?php echo form_label('Descrição', 'descricao', array('class' => 'text-secondary')); ?>
				<?php echo form_textarea(array('name' => 'descricao', 'value' => set_value(mysql_texto('descricao')),'class' => 'editor_html form-control shadow', 'placeholder' => 'Descreva a atividade'));?>
			</div>
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-primary shadow botao')); ?>
				<a href="<?php echo base_url('atividade/listar/' . $evento->id_evento)?>" class="btn btn-danger shadow botao">Cancelar</a>
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
			<div class="col-md-12 mx-auto bg-light rounded shadow p-4">
				<div class="border rounded my-3 shadow bg-primary text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo $evento->evento ?></p>
				</div>
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open(''); ?>
				<div class="icone_campo form-group">
					<?php echo form_label('Atividade', 'atividade', array('class' => 'text-secondary')); ?>
					<?php echo form_input('atividade', set_value('atividade', $atividade->atividade), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-calendar-check"></i>
				</div>
				<div class="form-row">
				<div class="icone_campo form-group col-md-9">
					<?php echo form_label('Local', 'local', array('class' => 'text-secondary')); ?>
					<?php echo form_input('local', set_value('local', $atividade->local), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-calendar-alt"></i>
				</div>			
				<div class="icone_campo form-group col-md-3">
					<?php echo form_label('Vagas', 'vagas', array('class' => 'text-secondary')); ?>
					<?php echo form_input('vagas', set_value('vagas', $atividade->vagas), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-calendar-alt"></i>
				</div>
			</div>					
			<div class="icone_campo form-group">
				<?php echo form_label('Descrição', 'descricao', array('class' => 'text-secondary')); ?>
				<?php echo form_textarea(array('name' => 'descricao',  'value' => set_value(mysql_texto('descricao')), 'rows' => '3', 'class' => 'form-control shadow','readonly' => 'TRUE'));?>
			</div>
			<div class="form-group pt-3 text-center">         
				<a href="<?php echo base_url('atividade/editar/' . $atividade->id_atividade) ?>" class="botao btn btn-primary shadow">Editar</a>
				<a href="<?php echo base_url('atividade/excluir/' . $atividade->id_atividade) ?>" class="botao btn btn-danger shadow">Excluir</a>
				<a href="<?php echo base_url('atividade/listar/' . $evento->id_evento)?>" class="btn btn-secondary shadow botao">Voltar</a>
			</div>
			<div>
				<?php $acesso = $this->session->dados_participante['acesso']; ?>
				<?php if(recupera_permissao($acesso, AGENDA)): ?>
					<a href="<?php echo base_url('agenda/listar/') . $atividade->id_atividade ?>" class="px-3">Agenda</a>
				<?php endif; ?>
				<?php if(recupera_permissao($acesso, INSCRICOES)): ?>
					<a href="<?php echo base_url('inscricao/listar/') . $atividade->id_atividade ?>" class="px-3">Inscritos</a>
				<?php endif; ?>
				<?php if(recupera_permissao($acesso, CHAMADAS)): ?>
					<a href="<?php echo base_url('chamada/listar/') . $atividade->id_atividade ?>" class="px-3">Chamada</a>
				<?php endif; ?>				
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
			<div class="col-md-12 mx-auto bg-light rounded shadow p-4">
				<div class="border rounded my-3 shadow bg-primary text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo $evento->evento ?></p>
				</div>
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open(''); ?>
				<div class="icone_campo form-group">
					<?php echo form_label('Atividade', 'atividade', array('class' => 'text-secondary')); ?>
					<?php echo form_input('atividade', set_value('atividade', $atividade->atividade), array('autofocus' => 'autofocus', 'class' => 'form-control shadow')); ?><i class="fas fa-calendar-check"></i>
				</div>
				<div class="form-row">
				<div class="icone_campo form-group col-md-9">
					<?php echo form_label('Local', 'local', array('class' => 'text-secondary')); ?>
					<?php echo form_input('local', set_value('local', $atividade->local), array('class' => 'form-control shadow')); ?><i class="fas fa-calendar-alt"></i>
				</div>
				<div class="icone_campo form-group col-md-3">
					<?php echo form_label('Vagas', 'vagas', array('class' => 'text-secondary')); ?>
					<?php echo form_input('vagas', set_value('vagas', $atividade->vagas), array('class' => 'form-control shadow')); ?><i class="fas fa-calendar-alt"></i>
				</div>
			</div>					
			<div class="icone_campo form-group">
				<?php echo form_label('Descrição', 'descricao', array('class' => 'text-secondary')); ?>
				<?php echo form_textarea(array('name' => 'descricao',  'value' => set_value(mysql_texto('descricao')), 'rows' => '3', 'class' => 'editor_html form-control shadow'));?>		
			</div>
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-primary shadow botao')); ?>
				<a href="<?php echo base_url('atividade/exibir/' . $atividade->id_atividade)?>" class="btn btn-danger shadow botao">Cancelar</a>
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
			<div class="col-md-12 mx-auto bg-light rounded shadow p-4">
				<div class="border rounded my-3 shadow bg-primary text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo $evento->evento ?></p>
				</div>
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open(''); ?>
				<div class="icone_campo form-group">
					<?php echo form_label('Atividade', 'atividade', array('class' => 'text-secondary')); ?>
					<?php echo form_input('atividade', set_value('atividade', $atividade->atividade), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-calendar-check"></i>
				</div>
				<div class="form-row">
				<div class="icone_campo form-group col-md-9">
					<?php echo form_label('Local', 'local', array('class' => 'text-secondary')); ?>
					<?php echo form_input('local', set_value('local', $atividade->local), array('class' => 'form-control shadow','readonly' => 'TRUE')); ?><i class="fas fa-calendar-alt"></i>
				</div>
				<div class="icone_campo form-group col-md-3">
					<?php echo form_label('Vagas', 'vagas', array('class' => 'text-secondary')); ?>
					<?php echo form_input('vagas', set_value('vagas', $atividade->vagas), array('class' => 'form-control shadow','readonly' => 'TRUE')); ?><i class="fas fa-calendar-alt"></i>
				</div>
			</div>					
			<div class="icone_campo form-group">
				<?php echo form_label('Descrição', 'descricao', array('class' => 'text-secondary')); ?>
				<?php echo form_textarea('descricao', mysql_texto(set_value('descricao', mysql_texto($atividade->descricao))), array('class' => 'form-control shadow','readonly' => 'TRUE'));?>
			</div>
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Excluir', array('class' => 'btn btn-primary shadow botao')); ?>
				<a href="<?php echo base_url('atividade/exibir/' . $atividade->id_atividade)?>" class="btn btn-danger shadow botao">Cancelar</a>
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