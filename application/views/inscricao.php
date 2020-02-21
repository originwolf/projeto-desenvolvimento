<?php $this->load->view('header'); ?>
<!--//====================================================================================================-->
<?php switch($pagina):
//====================================================================================================
case 'listar': ?>
<section id="listar" class="bg-cinza">
	<div class="container">
		<div class="row">
			<div class="col-md-12 mx-auto bg-light rounded shadow p-3">
				<div class="border rounded my-3 shadow bg-primary text-white">
					<h5 class="text-center my-2"><?php echo $titulo ?></h5>
				</div>
				<div class="border rounded my-3 shadow bg-white">
					<p class="text-center my-2"><?php echo 'Evento: ' . $evento->evento ?></p>
				</div>
				<div class="border rounded my-3 shadow bg-white">
            		<p class="text-center my-2"><?php echo 'Atividade: ' . $atividade->atividade ?></p>
        		</div>
        		<div class="container my-2 border bg-white rounded shadow">
					<div class="py-1">    
						<div class="icone_campo form-group">
							<label for="filtro" class="text-secondary">Filtrar Participante</label>
							<input type="text" class="form-control shadow" id="filtro" onkeyup="filtrar_tabela()" placeholder="Digite o nome do Participante"><i class="fa fa-filter fa-lg fa-fw"></i>
						</div>
					</div>
				</div>
        		<?php $this->load->view('mensagem'); ?>			
				<?php if(isset($inscricoes) && sizeof($inscricoes) > 0): ?>
				    <div class="table-responsive-md">
				        <table class="table rounded shadow" align="center" id="tabela">
				            <thead class="bg-primary text-white" align="center">
				                <tr class="rotulo-tabela">
				                    <th class="text-left">Participante&nbsp&nbsp&nbsp<small>{ <?php echo sizeof($inscricoes) ?> registro(s) }</small></th>
				                    <th class="text-left">Categoria</th>	                   	                   
				                </tr>
			                </thead>
			                <tbody class="bg-white">
			                	<?php $acesso = $this->session->dados_participante['acesso']; ?>
			                	<?php if(recupera_permissao($acesso, PARTICIPANTES)): ?>
				                    <?php foreach ($inscricoes as $inscricao): ?>
				                        <tr>
				                            <td align="left" id="participante"><a href="<?php echo base_url('participante/exibir/' . $inscricao->participante_id)?>" class="text-dark"><?php echo $inscricao->nome ?></a></td>		
				                            <td align="left" id="categoria"><a href="<?php echo base_url('participante/exibir/' . $inscricao->participante_id) ?>" class="text-dark"><?php echo $inscricao->categoria ?></a></td>                  
				                        </tr>   
				                    <?php endforeach; ?>
			                    <?php else: ?>
			                    	<?php foreach ($inscricoes as $inscricao): ?>
				                        <tr>
				                            <td align="left" id="participante"><?php echo $inscricao->nome ?></td>	
				                            <td align="left" id="categoria"><?php echo $inscricao->categoria ?></td> 
				                        </tr>   
			                    <?php endforeach; ?>
			                <?php endif; ?>
			                </tbody>
			            </table>			            
			            <div class="form-group pt-3 text-center">
			            	<a href="<?php echo base_url('atividade/listar/'.$atividade->evento_id)?>" class="btn btn-secondary shadow botao">Voltar</a>			            	
			            </div>
			            <a href="<?php echo base_url('pdfchamada/pdf/'.$atividade->evento_id.'/'.$atividade->id_atividade)?>" class="">Lista de Chamada pdf</a>
			        </div>
			    <?php else: ?>
			    	<div class="form-group pt-3 text-center">
		            	<a href="<?php echo base_url('atividade/listar/'.$atividade->evento_id)?>" class="btn btn-secondary shadow botao">Voltar</a>		            	
		            </div>
			    <?php endif; ?>
			</div>
		</div>					
	</div>	
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php endswitch; ?>
<?php $this->load->view('footer'); ?>
<!---->