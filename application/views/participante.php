
<?php $this->load->view('header'); ?>
<!--//====================================================================================================-->
<?php switch($pagina):
//====================================================================================================
	case 'login': ?>	
	<section id="login" class="bg-cinza">
		<div class="container">
			<div class="row">				
				<div class="col-md-6 mx-auto bg-light rounded shadow p-4">
					<div class="border rounded my-3 shadow bg-success text-white">
						<h5 class="text-center my-2"><?php echo $titulo ?></h5>
					</div>					
					<?php $this->load->view('mensagem'); ?>					
					<?php echo form_open(''); ?>											
					<div class="icone_campo form-group">
						<?php echo form_label('Email', 'email', array('class' => 'text-secondary')); ?>
						<?php echo form_input('email', set_value('email'), array('autofocus' => 'autofocus', 'class' => 'form-control shadow', 'placeholder' => 'Digite o endereço de email')); ?><i class="fa fa-envelope fa-lg fa-fw"></i>
					</div>					
					<div class="icone_campo form-group">
						<?php echo form_label('Senha', 'senha', array('class' => 'text-secondary')); ?>
						<?php echo form_password('senha', '', array('class' => 'form-control shadow', 'placeholder' => 'Digite a senha')); ?><i class="fa fa-key fa-lg fa-fw"></i>
					</div>					
					<div class="form-group pt-3 text-center">					
						<?php echo form_submit('enviar', 'Autenticar', array('class' => 'btn btn-success shadow botao')); ?>
						<a href="<?php echo base_url('home')?>" id="botao_grande" class="btn btn-danger shadow botao">Cancelar</a>
					</div>
					<?php echo form_close(); ?>									
				</div>
			</div>
		</div>
	</section>	
	<?php break; ?>
	<!--//====================================================================================================-->
	<?php case 'listar': ?>	
	<section id="listar" class="bg-cinza">
		<div class="container">
			<div class="row">				
				<div class="col-md-12 mx-auto bg-light rounded shadow p-3">
					<div class="border rounded my-3 shadow bg-success text-white">
						<h5 class="text-center my-2"><?php echo $titulo ?></h5>
					</div>					
					<?php $this->load->view('mensagem'); ?>					
					<div class="container my-2 border bg-white rounded shadow">
						<div class="row">
							<div class="container col-6 text-left py-2">
								<a href="<?php echo base_url('participante/cadastrar')?>" class="text-secondary">Novo Participante</a>
							</div>
							<div class="container col-6 text-right py-1">
								<div>
									<a href="<?php echo base_url('participante/cadastrar')?>" class="btn btn-success btn-sm shadow"><i class="fas fa-plus-square"></i> Cadastrar</a>
								</div>
							</div>
						</div>
					</div>					
					<div class="container my-2 border bg-white rounded shadow">
						<div class="py-1">    
							<div class="icone_campo form-group">
								<label for="filtro" class="text-secondary">Filtrar Participante</label>
								<input type="text" class="form-control shadow" id="filtro" onkeyup="filtrar_tabela()" placeholder="Digite o nome do Participante"><i class="fa fa-filter fa-lg fa-fw"></i>
							</div>
						</div>
					</div>					
					<?php if(isset($participantes) && sizeof($participantes) > 0): ?>
					<?php $acesso = $this->session->dados_participante['acesso']; ?>					
					<div class="table-responsive-md">
						<table class="table rounded shadow" align="center" id="tabela">							
							<thead class="bg-success text-white" align="center">
								<tr class="rotulo-tabela">
									<th class="text-left">Nome&nbsp&nbsp&nbsp<small>{ <?php echo sizeof($participantes) ?> registro(s) }</small></th>									
									<th class="text-left">Email</th>
									<th class="text-left">Celular</th>									
									<th class="text-left">Categoria</th>
									<?php if(recupera_permissao($acesso, PERMISSOES)): ?>
										<th class="text-center">Permissões</th>
									<?php endif; ?>									
								</tr>
							</thead>							
							<tbody class="bg-white">								
								<?php foreach ($participantes as $participante): ?>
									<tr>								
										<td align="left" id="nome"><a href="<?php echo base_url('participante/exibir/') . $participante->id_participante ?>" class="text-dark"><?php echo $participante->nome ?></a></td>								
										<td align="left" id="email"><a href="<?php echo base_url('participante/exibir/') . $participante->id_participante ?>" class="text-dark"><?php echo $participante->email ?></a></td>
										<td align="left" id="celular"><a href="<?php echo base_url('participante/exibir/') . $participante->id_participante ?>" class="text-dark"><?php echo $participante->celular ?></a></td>		
										<td align="left" id="categoria"><a href="<?php echo base_url('participante/exibir/') . $participante->id_participante ?>" class="text-dark"><?php echo $participante->categoria ?></a></td>
										<?php if(recupera_permissao($acesso, PERMISSOES)): ?>
											<td align="center" id="categoria"><a href="<?php echo base_url('participante/permitir/') . $participante->id_participante ?>" class="botao-pequeno btn btn-success btn-sm shadow"><i class="fas fa-unlock-alt"></i></a></td>				
										<?php endif; ?>				
									</tr>   
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif;?>
				<div class="form-group pt-2 text-center">			
					<a href="<?php echo base_url('home')?>" class="btn btn-danger shadow botao">Voltar</a>
				</div>
			</div>			
		</div>
	</div> 
</section>
<?php break;?>
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
				<?php echo form_open('participante/cadastrar'); ?>				
				<div class="icone_campo form-group">
					<?php echo form_label('Nome', 'nome', array('class' => 'text-secondary')); ?>
					<?php echo form_input('nome', set_value('nome'), array('autofocus' => 'autofocus', 'class' => 'form-control shadow', 'placeholder' => 'Digite o nome completo')); ?><i class="fas fa-user"></i>
				</div>				
				<div class="icone_campo form-group">
					<?php echo form_label('CPF', 'cpf', array('class' => 'text-secondary')); ?>
					<?php echo form_input('cpf', set_value('cpf'), array('class' => 'cpf form-control shadow', 'placeholder' => 'Digite seu CPF')); ?><i class="fas fa-id-card"></i>
				</div>										
				<div class="icone_campo form-group">
					<?php echo form_label('Email', 'email', array('class' => 'text-secondary')); ?>
					<?php echo form_input('email', set_value('email'), array('class' => 'form-control shadow', 'placeholder' => 'Digite o endereço de email')); ?><i class="fa fa-envelope fa-lg fa-fw"></i>
				</div>				
				<?php $recupera_categorias[NULL]='';?>
				<?php if(isset($categorias) && sizeof($categorias) > 0):	
				foreach ($categorias as $categoria):
					$recupera_categorias[$categoria->id_categoria]=$categoria->categoria;
				endforeach;
			endif;?>														
			<div class="icone_campo form-group">
				<?php echo form_label('Categoria', 'categoria', array('class' => 'text-secondary')); ?>
				<?php echo form_dropdown('categoria', $recupera_categorias,set_value('categoria'),array('class' => 'form-control shadow')); ?><i class="fa fa-list fa-lg fa-fw"></i>
			</div>								
			<div class="icone_campo form-group">
				<?php echo form_label('Celular', 'celular', array('class' => 'text-secondary')); ?>
				<?php echo form_input('celular', set_value('celular'), array('class' => 'celular form-control shadow', 'placeholder' => 'Digite seu celular')); ?><i class="fa fa-mobile-alt fa-lg fa-fw"></i>
			</div>								
			<div class="icone_campo form-group">
				<?php echo form_label('Telefone Fixo', 'telefone', array('class' => 'text-secondary')); ?>
				<?php echo form_input('telefone', set_value('telefone'), array('class' => 'telefone form-control shadow', 'placeholder' => 'Digite seu telefone fixo')); ?><i class="fa fa-phone fa-lg fa-fw"></i>
			</div>			
			<div class="icone_campo form-group">
				<?php echo form_label('Senha', 'senha', array('class' => 'text-secondary')); ?>
				<?php echo form_password('senha', '', array('class' => 'form-control shadow', 'placeholder' => 'Crie a senha')); ?><i class="fa fa-key fa-lg fa-fw"></i>
			</div>			
			<div class="icone_campo form-group">
				<?php echo form_label('Confirmar Senha', 'confirmar_senha', array('class' => 'text-secondary')); ?>
				<?php echo form_password('confirmar_senha', '', array('class' => 'form-control shadow', 'placeholder' => 'Confirme a senha')); ?><i class="fa fa-key fa-lg fa-fw"></i>
			</div>			
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-success shadow botao')); ?>
				<a href="<?php echo base_url('participante/listar')?>" class="btn btn-danger shadow botao">Cancelar</a>
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
					<?php echo form_label('Nome', 'nome', array('class' => 'text-secondary')); ?>
					<?php echo form_input('nome', set_value('nome', $participante->nome), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-user"></i>
				</div>				
				<div class="icone_campo form-group">
					<?php echo form_label('CPF', 'cpf', array('class' => 'text-secondary')); ?>
					<?php echo form_input('cpf', set_value('cpf', $participante->cpf), array('class' => 'cpf form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-id-card"></i>
				</div>										
				<div class="icone_campo form-group">
					<?php echo form_label('Email', 'email', array('class' => 'text-secondary')); ?>
					<?php echo form_input('email', set_value('email', $participante->email), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-envelope fa-lg fa-fw"></i>
				</div>				
				<?php $recupera_categorias[0]='';?>
				<?php if(isset($categorias) && sizeof($categorias) > 0):	
				foreach ($categorias as $categoria):
					$recupera_categorias[$categoria->id_categoria]=$categoria->categoria;
				endforeach;
			endif;?>														
			<div class="icone_campo form-group">
				<?php echo form_label('Categoria', 'categoria', array('class' => 'text-secondary')); ?>
				<?php echo form_dropdown('categoria', $recupera_categorias, set_value('categoria', $participante->categoria_id),array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-list fa-lg fa-fw"></i>
			</div>								
			<div class="icone_campo form-group">
				<?php echo form_label('Celular', 'celular', array('class' => 'text-secondary')); ?>
				<?php echo form_input('celular', set_value('celular', $participante->celular), array('class' => 'celular form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-mobile-alt fa-lg fa-fw"></i>
			</div>								
			<div class="icone_campo form-group">
				<?php echo form_label('Telefone Fixo', 'telefone', array('class' => 'text-secondary')); ?>
				<?php echo form_input('telefone', set_value('telefone', $participante->telefone), array('class' => 'telefone form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-phone fa-lg fa-fw"></i>
			</div>
			<?php $acesso = $this->session->dados_participante['acesso']; ?>			
			<div class="form-group pt-3 text-center">				
				<a href="<?php echo base_url('participante/editar/') . $participante->id_participante ?>" class="botao btn btn-success shadow">Editar</a>
				<?php if(recupera_permissao($acesso, PARTICIPANTES)): ?>
					<a href="<?php echo base_url('participante/excluir/') . $participante->id_participante ?>" class="botao btn btn-warning shadow">Excluir</a>
				<?php endif; ?>
	            <?php if(recupera_permissao($acesso, PARTICIPANTES)): ?>
					<a href="<?php echo base_url('participante/listar')?>" class="btn btn-danger shadow botao">Voltar</a>
				<?php else: ?>
					<a href="<?php echo base_url('home')?>" class="btn btn-danger shadow botao">Voltar</a>
				<?php endif; ?>		
			</div>
			<div class="bg-success text-center rounded">
				<?php if(recupera_permissao($acesso, PERMISSOES)): ?>
	            	<a href="<?php echo base_url('participante/permitir/') . $participante->id_participante ?>" class="px-3 text-white">Permissões</a>
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
				<div class="border rounded my-3 shadow bg-success text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>				
				<?php $this->load->view('mensagem'); ?>				
				<?php echo form_open(''); ?>				
				<div class="icone_campo form-group">
					<?php echo form_label('Nome', 'nome', array('class' => 'text-secondary')); ?>
					<?php echo form_input('nome', set_value('nome', $participante->nome), array('autofocus' => 'autofocus', 'class' => 'form-control shadow')); ?><i class="fas fa-user"></i>
				</div>				
				<div class="icone_campo form-group">
					<?php echo form_label('CPF', 'cpf', array('class' => 'text-secondary')); ?>
					<?php echo form_input('cpf', set_value('cpf', $participante->cpf), array('class' => 'cpf form-control shadow')); ?><i class="fas fa-id-card"></i>
				</div>										
				<div class="icone_campo form-group">
					<?php echo form_label('Email', 'email', array('class' => 'text-secondary')); ?>
					<?php echo form_input('email', set_value('email', $participante->email), array('class' => 'form-control shadow')); ?><i class="fa fa-envelope fa-lg fa-fw"></i>
				</div>				
				<?php $recupera_categorias[0]='';?>
				<?php if(isset($categorias) && sizeof($categorias) > 0):	
				foreach ($categorias as $categoria):
					$recupera_categorias[$categoria->id_categoria]=$categoria->categoria;
				endforeach;
			endif;?>														
			<div class="icone_campo form-group">
				<?php echo form_label('Categoria', 'categoria', array('class' => 'text-secondary')); ?>
				<?php echo form_dropdown('categoria', $recupera_categorias, set_value('categoria', $participante->categoria_id),array('class' => 'form-control shadow')); ?><i class="fa fa-list fa-lg fa-fw"></i>
			</div>								
			<div class="icone_campo form-group">
				<?php echo form_label('Celular', 'celular', array('class' => 'text-secondary')); ?>
				<?php echo form_input('celular', set_value('celular', $participante->celular), array('class' => 'celular form-control shadow')); ?><i class="fa fa-mobile-alt fa-lg fa-fw"></i>
			</div>								
			<div class="icone_campo form-group">
				<?php echo form_label('Telefone Fixo', 'telefone', array('class' => 'text-secondary')); ?>
				<?php echo form_input('telefone', set_value('telefone', $participante->telefone), array('class' => 'telefone form-control shadow')); ?><i class="fa fa-phone fa-lg fa-fw"></i>
			</div>			
			<div class="icone_campo form-group">
				<?php echo form_label('Senha', 'senha', array('class' => 'text-secondary')); ?>
				<?php echo form_password('senha', '', array('class' => 'form-control shadow')); ?><i class="fa fa-key fa-lg fa-fw"></i>
			</div>			
			<div class="icone_campo form-group">
				<?php echo form_label('Confirmar Senha', 'confirmar_senha', array('class' => 'text-secondary')); ?>
				<?php echo form_password('confirmar_senha', '', array('class' => 'form-control shadow')); ?><i class="fa fa-key fa-lg fa-fw"></i>
			</div>			
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-success shadow botao')); ?>
				<a href="<?php echo base_url('participante/exibir/' . $participante->id_participante)?>" class="btn btn-danger shadow botao">Cancelar</a>
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
				<?php echo form_open(''); ?>				
				<div class="icone_campo form-group">
					<?php echo form_label('Nome', 'nome', array('class' => 'text-secondary')); ?>
					<?php echo form_input('nome', set_value('nome', $participante->nome), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-user"></i>
				</div>				
				<div class="icone_campo form-group">
					<?php echo form_label('CPF', 'cpf', array('class' => 'text-secondary')); ?>
					<?php echo form_input('cpf', set_value('cpf', $participante->cpf), array('class' => 'cpf form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-id-card"></i>
				</div>										
				<div class="icone_campo form-group">
					<?php echo form_label('Email', 'email', array('class' => 'text-secondary')); ?>
					<?php echo form_input('email', set_value('email', $participante->email), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-envelope fa-lg fa-fw"></i>
				</div>				
				<?php $recupera_categorias[0]='';?>
				<?php if(isset($categorias) && sizeof($categorias) > 0):	
				foreach ($categorias as $categoria):
					$recupera_categorias[$categoria->id_categoria]=$categoria->categoria;
				endforeach;
			endif;?>														
			<div class="icone_campo form-group">
				<?php echo form_label('Categoria', 'categoria', array('class' => 'text-secondary')); ?>
				<?php echo form_dropdown('categoria', $recupera_categorias, set_value('categoria', $participante->categoria_id),array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-list fa-lg fa-fw"></i>
			</div>								
			<div class="icone_campo form-group">
				<?php echo form_label('Celular', 'celular', array('class' => 'text-secondary')); ?>
				<?php echo form_input('celular', set_value('celular', $participante->celular), array('class' => 'celular form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-mobile-alt fa-lg fa-fw"></i>
			</div>								
			<div class="icone_campo form-group">
				<?php echo form_label('Telefone Fixo', 'telefone', array('class' => 'text-secondary')); ?>
				<?php echo form_input('telefone', set_value('telefone', $participante->telefone), array('class' => 'telefone form-control shadow', 'readonly' => 'TRUE')); ?><i class="fa fa-phone fa-lg fa-fw"></i>
			</div>			
			<div class="form-group pt-3 text-center">         
				<?php echo form_submit('enviar', 'Excluir', array('class' => 'btn btn-success shadow botao')); ?>
				<a href="<?php echo base_url('participante/exibir/' . $participante->id_participante)?>" class="btn btn-danger shadow botao">Cancelar</a>
			</div>
			<?php echo form_close(); ?>			
		</div>
	</div>
</div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'permitir': ?>
<section id="permitir" class="bg-cinza">
	<div class="container">
		<div class="row">			
			<div class="col-md-6 mx-auto bg-light rounded shadow p-3">
				<div class="border rounded my-3 shadow bg-success text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>				
				<?php $this->load->view('mensagem'); ?>
				<div class="border rounded my-2 shadow bg-white text-secondary">
					<p class="text-center my-3"><?php echo $participante->nome ?></p>
				</div>				
				<?php echo form_open(''); ?>
				<div class="container my-3 p-5 border bg-white rounded shadow">
					<div class="row">
						<div class="container m-3 text-secondary">
							<div class="form-check py-2">								
								<?php echo form_checkbox('categorias', CATEGORIAS, recupera_permissao($participante->acesso, CATEGORIAS)); ?>
								<?php echo form_label('Controle de Categorias', 'categorias'); ?>
							</div>
							<div class="form-check py-2">								
								<?php echo form_checkbox('participantes', PARTICIPANTES, recupera_permissao($participante->acesso, PARTICIPANTES)); ?>
								<?php echo form_label('Controle de Participantes', 'participantes'); ?>
							</div>
							<div class="form-check py-2">								
								<?php echo form_checkbox('eventos', EVENTOS, recupera_permissao($participante->acesso, EVENTOS)); ?>
								<?php echo form_label('Controle de Eventos', 'eventos'); ?>
							</div>
							<div class="form-check py-2">								
								<?php echo form_checkbox('atividades', ATIVIDADES, recupera_permissao($participante->acesso, ATIVIDADES)); ?>
								<?php echo form_label('Controle de Atividades', 'atividades'); ?>
							</div>
							<div class="form-check py-2">								
								<?php echo form_checkbox('agenda', AGENDA, recupera_permissao($participante->acesso, AGENDA)); ?>
								<?php echo form_label('Controle de Agenda', 'agenda'); ?>
							</div>
							<div class="form-check py-2">								
								<?php echo form_checkbox('areas', AREAS, recupera_permissao($participante->acesso, AREAS)); ?>
								<?php echo form_label('Controle de Áreas', 'areas'); ?>
							</div>
							<div class="form-check py-2">								
								<?php echo form_checkbox('inscricoes', INSCRICOES, recupera_permissao($participante->acesso, INSCRICOES)); ?>
								<?php echo form_label('Controle de Inscricões', 'inscricoes'); ?>
							</div>
							<div class="form-check py-2">								
								<?php echo form_checkbox('chamadas', CHAMADAS, recupera_permissao($participante->acesso, CHAMADAS)); ?>
								<?php echo form_label('Controle de Chamadas', 'chamadas'); ?>
							</div>
							<div class="form-check py-2">								
								<?php echo form_checkbox('permissoes', PERMISSOES, recupera_permissao($participante->acesso, PERMISSOES)); ?>
								<?php echo form_label('Controle de Permissões', 'permissoes'); ?>
							</div>							
						</div>
					</div>
				</div>				
				<div class="form-group pt-3 text-center">         
					<?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-success shadow botao')); ?>
					<a href="<?php echo base_url('participante/listar/')?>" class="btn btn-danger shadow botao">Cancelar</a>
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