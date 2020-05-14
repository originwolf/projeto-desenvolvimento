
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
					<?php $this->load->view('mensagem'); ?>
					<div class="container my-3 border bg-white rounded shadow">
						<div class="row">
							<div class="container col-6 text-left py-2">
								<a href="<?php echo base_url('evento/cadastrar')?>" class="text-secondary">Novo Evento</a>
							</div>
							<div class="container col-6 text-right py-1">
								<div>
									<a href="<?php echo base_url('evento/cadastrar')?>" class="btn btn-success btn-sm shadow"><i class="fas fa-plus-square"></i> Cadastrar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="container my-3 border bg-white rounded shadow">
						<div class="py-1">    
							<div class="icone_campo form-group">
								<label for="filtro" class="text-secondary">Filtrar Evento</label>
								<input type="text" class="form-control shadow" id="filtro" onkeyup="filtrar_tabela()" placeholder="Digite o nome do Evento"><i class="fa fa-filter fa-lg fa-fw"></i>
							</div>
						</div>
					</div>
					<?php if(isset($eventos) && sizeof($eventos) > 0): ?>
					<?php $acesso = $this->session->dados_participante['acesso']; ?>
	           		<div class="table-responsive-md">
						<table class="table rounded shadow" align="center" id="tabela">
							<thead class="bg-success text-white" align="center">
								<tr class="rotulo-tabela">
									<th class="text-left">Evento&nbsp&nbsp&nbsp<small>{ <?php echo sizeof($eventos) ?> registro(s) }</small></th>
									<th class="text-left">Início</th>
									<th class="text-left">Término</th>
									<th class="text-left">Área</th>
									<th class="text-center">Publicado</th>
									<?php if(recupera_permissao($acesso, ATIVIDADES)): ?>
										<th class="text-center">Atividades</th>
									<?php endif; ?>								
								</tr>
							</thead>
							<tbody class="bg-white">
								<?php foreach ($eventos as $evento): ?>
									<tr>
										<td align="left" id="nome"><a href="<?php echo base_url('evento/exibir/' . $evento->id_evento) ?>" class="text-dark"><?php echo $evento->evento ?></a></td>
										<td align="left" id="cpf"><a href="<?php echo base_url('evento/exibir/' . $evento->id_evento) ?>" class="text-dark"><?php echo date('d/m/Y', strtotime($evento->data_inicio)) ?></a></td>
										<td align="left" id="email"><a href="<?php echo base_url('evento/exibir/' . $evento->id_evento) ?>" class="text-dark"><?php echo date('d/m/Y', strtotime($evento->data_termino)) ?></a></td>				
										<td align="left" id="categoria"><a href="<?php echo base_url('evento/exibir/' . $evento->id_evento) ?>" class="text-dark"><?php echo $evento->area ?></a></td>
										
										<td align="center" id="categoria"><?php echo form_checkbox('publicado', TRUE, $evento->publicar, 'disabled'); ?></td>
										<?php if(recupera_permissao($acesso, ATIVIDADES)): ?>
											<td align="center"><a href="<?php echo base_url('atividade/listar/') . $evento->id_evento ?>" class="botao-pequeno btn btn-success btn-sm shadow"><i class="fas fa-flask"></i></a></td>
										<?php endif?>									
									</tr>   
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
				<div class="form-group pt-2 text-center">			
					<a href="<?php echo base_url('home')?>" class="btn btn-danger shadow botao">Voltar</a>
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
			<div class="border rounded my-3 shadow bg-success text-white">
				<h5 class="text-center my-2"><?php echo $titulo ?></h5>
			</div>
			<?php $this->load->view('mensagem'); ?>
			<?php echo form_open('evento/cadastrar'); ?>
			<div class="icone_campo form-group">
				<?php echo form_label('Evento', 'evento', array('class' => 'text-secondary')); ?>
				<?php echo form_input('evento', set_value('evento'), array('autofocus' => 'autofocus', 'class' => 'form-control shadow', 'placeholder' => 'Digite o título do evento')); ?><i class="far fa-calendar-check"></i>
			</div>
			<div class="form-row">
				<div class="icone_campo form-group col-md-3">
					<?php echo form_label('Data Início', 'inicio', array('class' => 'text-secondary')); ?>
					<?php echo form_input('inicio', set_value('inicio'), array('class' => 'data form-control shadow', 'placeholder' => '__/__/____')); ?><i class="far fa-calendar-alt"></i>
				</div>
				<div class="icone_campo form-group col-md-3">
					<?php echo form_label('Data Término', 'termino', array('class' => 'text-secondary')); ?>
					<?php echo form_input('termino', set_value('termino'), array('class' => 'data form-control shadow', 'placeholder' => '__/__/____')); ?><i class="far fa-calendar-alt"></i>
				</div>
				<?php $recupera_areas[NULL]='';?>
				<?php if(isset($areas) && sizeof($areas) > 0):	
					foreach ($areas as $area):
						$recupera_areas[$area->id_area]=$area->area;
					endforeach;
				endif;?>
				<div class="icone_campo form-group  col-md-6">
					<?php echo form_label('Área', 'area', array('class' => 'text-secondary')); ?>
					<?php echo form_dropdown('area', $recupera_areas,set_value('area'),array('class' => 'form-control shadow')); ?><i class="fa fa-list fa-lg fa-fw"></i>
				</div>
			</div>
			<div class="icone_campo form-group">
				<?php echo form_label('Descrição', 'descricao', array('class' => 'text-secondary')); ?>
				<?php echo form_textarea(array('name' => 'descricao', 'value' => set_value('descricao'), 'rows' => '3', 'class' => 'editor_html form-control shadow', 'placeholder' => 'Descreva o evento'));?>
			</div>
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-success shadow botao')); ?>
				<a href="<?php echo base_url('evento/listar')?>" class="btn btn-danger shadow botao">Cancelar</a>
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
				<div class="border rounded my-3 shadow bg-success text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open(''); ?>
				<div class="icone_campo form-group">
					<?php echo form_label('Evento', 'evento', array('class' => 'text-secondary')); ?>
					<?php echo form_input('evento', set_value('evento', $evento->evento), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="far fa-calendar-check"></i>
				</div>
				<div class="form-row">
					<div class="icone_campo form-group col-md-3">
						<?php echo form_label('Data Início', 'data_inicio', array('class' => 'text-secondary')); ?>
						<?php echo form_input('data_inicio', set_value('data_inicio', date("d/m/Y", strtotime($evento->data_inicio))), array('class' => 'data form-control shadow', 'readonly' => 'TRUE')); ?><i class="far fa-calendar-alt"></i>
					</div>
					<div class="icone_campo form-group col-md-3">
						<?php echo form_label('Data Término', 'data_termino', array('class' => 'text-secondary')); ?>
						<?php echo form_input('data_termino', set_value('data_termino', date("d/m/Y", strtotime($evento->data_termino))), array('class' => 'data form-control shadow', 'readonly' => 'TRUE')); ?><i class="far fa-calendar-alt"></i>
					</div>
					<?php $recupera_areas[NULL]='';?>
					<?php if(isset($areas) && sizeof($areas) > 0):	
					foreach ($areas as $area):
						$recupera_areas[$area->id_area]=$area->area;
					endforeach;
				endif;?>
				<div class="icone_campo form-group  col-md-6">
					<?php echo form_label('Área', 'area', array('class' => 'text-secondary')); ?>
					<?php echo form_dropdown('area', $recupera_areas, "$evento->area_id", array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-list fa-lg fa-fw"></i>
				</div>
			</div>
			<div class="icone_campo form-group">
				<?php echo form_label('Descrição', 'descricao', array('class' => 'text-secondary')); ?>
				<?php echo form_textarea(array('name' => 'descricao', 'value' => mysql_texto($evento->descricao), 'rows' => '3', 'class' => 'form-control shadow', 'readonly' => 'TRUE'));?>
			</div>
			<div class="form-group pt-3 text-center">
				<a href="<?php echo base_url('evento/publicar/') . $evento->id_evento ?>" class="botao btn btn-success shadow"><?php echo $evento->publicar == TRUE?  "Despublicar" : "Publicar"; ?></a>      
				<a href="<?php echo base_url('evento/editar/') . $evento->id_evento ?>" class="botao btn btn-primary shadow">Editar</a>
				<a href="<?php echo base_url('evento/excluir/') . $evento->id_evento ?>" class="botao btn btn-warning shadow">Excluir</a>
				<a href="<?php echo base_url('evento/listar')?>" class="btn btn-danger shadow botao">Voltar</a>
			</div>
			<div class="bg-success text-center rounded">
				<?php $acesso = $this->session->dados_participante['acesso']; ?>
				<?php if(recupera_permissao($acesso, ATIVIDADES)): ?>
					<a href="<?php echo base_url('atividade/listar/') . $evento->id_evento ?>" class="px-3 text-white">Atividades</a>
				<?php endif ?>				
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
				<div class="border rounded my-3 shadow bg-success text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open(''); ?>
				<div class="icone_campo form-group">
					<?php echo form_label('Evento', 'evento', array('class' => 'text-secondary')); ?>
					<?php echo form_input('evento', set_value('evento', $evento->evento), array('autofocus' => 'autofocus', 'class' => 'form-control shadow')); ?><i class="far fa-calendar-check"></i>
				</div>
				<div class="form-row">
					<div class="icone_campo form-group col-md-3">
						<?php echo form_label('Data Início', 'data_inicio', array('class' => 'text-secondary')); ?>
						<?php echo form_input('data_inicio', set_value('data_inicio', date("d/m/Y", strtotime($evento->data_inicio))), array('class' => 'data form-control shadow')); ?><i class="far fa-calendar-alt"></i>
					</div>
					<div class="icone_campo form-group col-md-3">
						<?php echo form_label('Data Término', 'data_termino', array('class' => 'text-secondary')); ?>
						<?php echo form_input('data_termino', set_value('data_termino', date("d/m/Y", strtotime($evento->data_termino))), array('class' => 'data form-control shadow')); ?><i class="far fa-calendar-alt"></i>
					</div>
					<?php $recupera_areas[NULL]='';?>
					<?php if(isset($areas) && sizeof($areas) > 0):	
					foreach ($areas as $area):
						$recupera_areas[$area->id_area]=$area->area;
					endforeach;
				endif;?>
				<div class="icone_campo form-group  col-md-6">
					<?php echo form_label('Área', 'area', array('class' => 'text-secondary')); ?>
					<?php echo form_dropdown('area', $recupera_areas, "$evento->area_id", array('class' => 'form-control shadow')); ?><i class="fa fa-list fa-lg fa-fw"></i>
				</div>
			</div>
			<div class="icone_campo form-group">
				<?php echo form_label('Descrição', 'descricao', array('class' => 'text-secondary')); ?>
				<?php echo form_textarea(array('name' => 'descricao', 'value' => mysql_texto($evento->descricao), 'rows' => '3', 'class' => 'editor_html form-control shadow'));?>
			</div>
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-success shadow botao')); ?>
				<a href="<?php echo base_url('evento/exibir/' . $evento->id_evento)?>" class="btn btn-danger shadow botao">Cancelar</a>
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
				<div class="border rounded my-3 shadow bg-success text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<?php $this->load->view('mensagem'); ?>
				<?php echo form_open(''); ?>
				<div class="icone_campo form-group">
					<?php echo form_label('Evento', 'evento', array('class' => 'text-secondary')); ?>
					<?php echo form_input('evento', "$evento->evento", array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="far fa-calendar-check"></i>
				</div>
				<div class="form-row">
					<div class="icone_campo form-group col-md-3">
						<?php echo form_label('Data Início', 'data_inicio', array('class' => 'text-secondary')); ?>
						<?php echo form_input('data_inicio',  date("d/m/Y", strtotime("$evento->data_inicio")), array('class' => 'data form-control shadow', 'readonly' => 'TRUE')); ?><i class="far fa-calendar-alt"></i>
					</div>
					<div class="icone_campo form-group col-md-3">
						<?php echo form_label('Data Término', 'data_termino', array('class' => 'text-secondary')); ?>
						<?php echo form_input('data_termino', date("d/m/Y", strtotime("$evento->data_termino")), array('class' => 'data form-control shadow', 'readonly' => 'TRUE')); ?><i class="far fa-calendar-alt"></i>
					</div>
					<?php $recupera_areas[NULL]='';?>
					<?php if(isset($areas) && sizeof($areas) > 0):	
					foreach ($areas as $area):
						$recupera_areas[$area->id_area]=$area->area;
					endforeach;
				endif;?>
				<div class="icone_campo form-group  col-md-6">
					<?php echo form_label('Área', 'area', array('class' => 'text-secondary')); ?>
					<?php echo form_dropdown('area', $recupera_areas, "$evento->area_id", array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-list fa-lg fa-fw"></i>
				</div>
			</div>
			<div class="icone_campo form-group">
				<?php echo form_label('Descrição', 'descricao', array('class' => 'text-secondary')); ?>
				<?php echo form_textarea(array('name' => 'descricao', 'value' => mysql_texto($evento->descricao), 'rows' => '3', 'class' => 'form-control shadow', 'readonly' => 'TRUE'));?>
			</div>
			<div class="form-check py-2 border rounded shadow text-secondary" style="background: #e9ecef">					
				<?php echo form_checkbox(array('name' => 'publicar', 'value' => TRUE, 'checked' => $evento->publicar, 'style' => 'margin:12px;', 'disabled' => TRUE)); ?>
				<?php echo form_label('Publicar', 'publicar', array('style' => 'color: #4e5057;')); ?>
			</div>
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Excluir', array('class' => 'btn btn-success shadow botao')); ?>
				<a href="<?php echo base_url('evento/exibir/' . $evento->id_evento)?>" class="btn btn-danger shadow botao">Cancelar</a>
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