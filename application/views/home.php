<!--//CARREGA CABEÇALHO-->
<?php $this->load->view('header'); ?>
<?php switch($pagina):
//====================================================================================================
case 'home': ?>
    <header class="cabecalho">
      <div class="bg-titulo container text-center">
        <h1 class="titulo"><?php echo $titulo ?></h1>
        <?php $this->load->view('mensagem') ?>
      </div>
    </header>  
    <?php if(isset($eventos) && sizeof($eventos) > 0): ?>
    <section id="eventos"  class="bg-light">
       <div class="container">
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <h2 class="text-center mb-5">PRÓXIMOS EVENTOS</h2>             
            </div>            
              <?php foreach ($eventos as $evento): ?>       
            <div class="card w-75 mx-auto mb-3 shadow">
              <h5 class="card-header"><a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-dark"><?php echo $evento->evento ?></a></h5>
              <div class="card-body">
                <?php if(isset($evento->descricao) && $evento->descricao != ""): ?>
                <div class="icone_campo form-group">
                  <p><small><a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-secondary"><?php echo mysql_texto($evento->descricao) ?></a></small></p>                
                </div>
                <?php endif; ?>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <p><small>Início: <a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-dark"><?php echo date('d/m/Y', strtotime($evento->data_inicio)) ?></a></small></p>
                  </div>
                  <div class="form-group col-md-4">
                    <p><small>Término: <a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-dark"><?php echo date('d/m/Y', strtotime($evento->data_termino)) ?></a></small></p>
                  </div>
                  <div class="form-group col-md-4">
                    <p><small>Área: <a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-dark"><?php echo $evento->area ?></a></small></p>
                  </div>                  
                </div>
                <div>                  
                   <a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento)?>" class="btn btn-primary shadow">Ver Atividades</a>
                </div>                
              </div>
            </div>
            <?php endforeach; ?>                         
          </div>
        </div>                              
        
    </section>
    <?php endif; ?>
    <section id="sobre">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 mx-auto"> 
          <section id="SobreNos" class="row">
          <div class="col-12 mb-3" style="border-bottom: 10px solid rgb(34,139,34)"></div>
				<div class="col-md-5 text-center">
						<img src="<?php echo base_url('/assets/images/logoSisconeve.jpg') ?>" alt="Logo do ifsuldeminas" class="py-2" style="width:300; height:317px;">
				</div>
				<div class="col-md-7">
        <h1 class="mt-4 mb-3 pl-4">SOBRE O SISCONEVE</h1>
					<p class="text-justify col-12 pl-4">Este sistema foi projetado para atender as demandas dos eventos realizados dentro do IFSULDEMINAS - Campus Machado. 
            A plataforma permite a automatização de processos que simplificam a forma de administrar todas as etapas do eventos. 
            O SISCONEVE foi desenvolvido para facilitar a organização de inscrições, palestras, minicursos, workshops, cursos, entre outras 
            atividades de eventos técnicos e científicos.</p>
				</div>
        <div class="col-12 mb-3" style="border-bottom: 10px solid rgb(34,139,34)"></div>        
          </div>
        </div>
      </div>
    </section>
    
			
    <section id="contato" class="bg-light">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 mx-auto">
          <div class="col-12 mb-3" style="border-bottom: 10px solid rgb(34,139,34)"></div>
            <h2 class="text-center mb-5">ENTRE EM CONTATO</h2>
            
            <div class="row">
              <div class="col-sm-6">
                <div class="card mt-4 mb-4 shadow">
                  <div class="card-header">
                    Denis Antonio Rocha
                  </div>
                  <div class="card-body">               
                    <p class="card-text"><i class="fab fa-whatsapp-square"></i>&nbsp;&nbsp;&nbsp;<a href="https://api.whatsapp.com/send?phone=5535988751516&text=Oi%20Denis%2C%20estou%20enfrentando%20alguns%20problemas%20com%20o%20SISCONEVE%2C%20voc%C3%AA%20poderia%20me%20ajudar%3F" class="text-dark">(35) 9 8875-1516</a></p>
                    <p class="card-text"><i class="fas fa-envelope"></i>&nbsp;&nbsp;&nbsp;denisantoniorocha@gmail.com</p>
                    <p class="card-text"><i class="fab fa-facebook-square"></i>&nbsp;&nbsp;&nbsp;<a href="https://www.facebook.com/denisantonio.rocha" class="text-dark">www.facebook.com/denisantonio.rocha</a></p>                
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="card mt-4 mb-4 shadow">
                  <div class="card-header">
                    Jéssica Alves de Lima Venâncio
                  </div>
                  <div class="card-body">               
                    <p class="card-text"><i class="fab fa-whatsapp-square"></i>&nbsp;&nbsp;&nbsp; <a href="https://api.whatsapp.com/send?phone=5535997473184&text=Oi%20J%C3%A9ssica%2C%20estou%20enfrentando%20alguns%20problemas%20com%20o%20SISCONEVE%2C%20voc%C3%AA%20poderia%20me%20ajudar%3F" class="text-dark">(35) 9 9747-3184</a></p>
                    <p class="card-text"><i class="fas fa-envelope"></i>&nbsp;&nbsp;&nbsp;jlimavenancio@outlook.com</p>
                    <p class="card-text"><i class="fab fa-facebook-square"></i>&nbsp;&nbsp;&nbsp;<a href="https://www.facebook.com/jessica.venancio.399" class="text-dark">www.facebook.com/jessica.venancio.399</a></p>                
                  </div>
                </div>           
              </div>
            </div>
            <p class="lead my-5">ATENÇÃO: O SISCONEVE está em desenvolvimento. Qualquer erro entre em contato conosco, se possível com o(s) print(s) do(s) erro(s).</p>
            <div class="col-12 mb-3" style="border-bottom: 10px solid rgb(34,139,34)"></div>
          </div>
        </div>
      </div>
    </section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'listar_eventos': ?>
  <section id="listar_eventos" class="bg-cinza">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
          <div class="border rounded my-3 shadow bg-primary text-white">
            <h5 class="text-center my-2"><?php echo $titulo ?></h5>
          </div>
          <?php $this->load->view('mensagem'); ?>
          <?php if(isset($eventos) && sizeof($eventos) > 0): ?>
            <?php foreach ($eventos as $evento): ?>
              <div class="card mb-3 shadow">
                <h5 class="card-header"><a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-dark"><?php echo $evento->evento ?></a></h5>
                <div class="card-body">
                  <?php if(isset($evento->descricao) && $evento->descricao != ""): ?>
                  <div class="icone_campo form-group">
                    <p><small><a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-secondary"><?php echo mysql_texto($evento->descricao) ?></a></small></p>                
                  </div>
                  <?php endif; ?>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <p><small>Início: <a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-dark"><?php echo date('d/m/Y', strtotime($evento->data_inicio)) ?></a></small></p>
                    </div>
                    <div class="form-group col-md-4">
                      <p><small>Término: <a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-dark"><?php echo date('d/m/Y', strtotime($evento->data_termino)) ?></a></small></p>
                    </div>
                    <div class="form-group col-md-4">
                      <p><small>Área: <a href="<?php echo base_url('home/listar_atividades/' . $evento->id_evento) ?>" class="text-dark"><?php echo $evento->area ?></a></small></p>
                    </div>
                  </div>                 
                </div>
              </div>                            
            <?php endforeach; ?>
          <?php endif; ?>
        </div>        
      </div>
    </div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'listar_atividades': ?>
  <section id="listar_atividades" class="bg-cinza">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
          <div class="border rounded my-3 shadow bg-primary text-white">
            <h5 class="text-center my-2"><?php echo $titulo ?></h5>
          </div>
          <div class="border rounded my-3 shadow bg-white">
            <p class="text-center my-2"><?php echo $evento->evento ?></p>
          </div>
          <?php $this->load->view('mensagem'); ?>
          <?php if(isset($atividades) && sizeof($atividades) > 0): ?>         
          <?php foreach ($atividades as $atividade): ?>
            <?php $acesso = $this->session->dados_participante['acesso']; ?>
            <div class="card mb-3 shadow">
              <h5 class="card-header"><?php echo $atividade->atividade ?></h5>
              <div class="card-body">
                <?php if(isset($atividade->descricao) && $atividade->descricao != ""): ?>
                <div class="form-group text-secondary">
                  <p><small><?php echo mysql_texto($atividade->descricao) ?></small></p>                
                </div>
                <?php endif; ?>
                <div class="form-row">
                  <div class="form-group col-md-5">
                    <p><small>LOCAL:</br><?php echo $atividade->local ?></small></p>
                  </div>
                  <div class="form-group col-md-4">
                    <p><small>AGENDA:</br><?php
                      if(isset($atividade->agenda) && sizeof($atividade->agenda) > 0):
                        foreach ($atividade->agenda as $dia_hora):                          
                            echo date('d/m', strtotime($dia_hora->dia)) . '&nbsp&nbsp&nbsp' .
                            date('H:i', strtotime($dia_hora->hora_inicio)) .'-' . 
                            date('H:i', strtotime($dia_hora->hora_termino)) . '</br>';                
                        endforeach;
                      else:
                        echo "Sem agenda";
                      endif; 
                      ?></small></p>
                  </div>
                  <div class="form-group col-md-3">
                    <p><small>VAGAS:</br><?php echo isset($atividade->inscritos)? $atividade->vagas - $atividade->inscritos :  $atividade->vagas; ?></small></p>
                  </div>                  
                </div>
                <?php if(isset($atividade->inscrito) && $atividade->inscrito == TRUE): ?>                  
                  <div class="btn btn-success shadow botao">Inscrito</div>
                  <a href="<?php echo base_url('home/desinscrever/' . $inscricao->participante_id . '/' . $inscricao->id_inscricao) ?>" class="btn btn-primary shadow botao">Desinscrever</a>
                <?php else: ?>
                  <?php echo form_open('home/inscrever/' . $evento->id_evento . '/' . $atividade->id_atividade); ?>      
                    <div class="form-group">
                      <?php echo form_submit('enviar', 'Inscrever-se', array('class' => 'btn btn-primary shadow botao')); ?>   
                      </div>
                    <?php echo form_close(); ?>
                <?php endif; ?>
              </div>
            </div>                 
            <?php endforeach; ?>          
            <?php endif; ?>           
            <div class="form-group pt-3 text-center">     
              <a href="<?php echo base_url('home/listar_eventos')?>" class="btn btn-secondary shadow botao">Voltar</a>
            </div>
          </div>        
        </div>
      </div>
  </div> 
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'listar_inscricoes': ?>
<section id="listar_inscricoes" class="bg-cinza">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
                <div class="border rounded my-3 shadow bg-primary text-white">
                    <h5 class="text-center my-2"><?php echo $titulo ?></h5>
                </div>
                <?php $this->load->view('mensagem'); ?>
                <?php if(isset($inscricoes) && sizeof($inscricoes) > 0): ?>
                <?php foreach($inscricoes as $inscricao): ?>
                <div class="card mb-3 shadow">
                    <h5 class="card-header"> <?php echo $inscricao->atividade->atividade; ?></h5>
                    <div class="card-body">                 
                        <div class="icone_campo form-group text-secondary">
                            <p><small><?php echo $inscricao->evento->evento; ?></small></p>              
                        </div>                 
                        <div class="form-row">
                            <div class="form-group col-md-6 text-secondary">
                                <p><small>
                                <?php foreach ($inscricao->atividade->agenda as $agenda):
                                    echo date('d/m', strtotime($agenda->dia)) . '&nbsp&nbsp&nbsp' .
                                    date('H:i', strtotime($agenda->hora_inicio)) .'-' . 
                                    date('H:i', strtotime($agenda->hora_termino)) . '</br>';
                                endforeach;?>                       
                                </small></p>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <a href="<?php echo base_url('home/desinscrever/' . $id_participante . '/' . $inscricao->id_inscricao) ?>" class="btn btn-primary shadow botao">Desinscrever</a>
                            </div>
                        </div>                 
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'desinscrever': ?>
<section id="desinscrever" class="bg-cinza">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
                <div class="border rounded my-3 shadow bg-primary text-white">
                    <h5 class="text-center my-2"><?php echo $titulo ?></h5>
                </div>
                <?php $this->load->view('mensagem'); ?>               
                <div class="card mb-3 shadow">
                    <h5 class="card-header"> <?php echo $inscricao->atividade->atividade; ?></h5>
                    <div class="card-body">                 
                        
                        <div class="form-row">
                            <div class="form-group col-md-6 text-secondary">
                              <p><small><?php echo $inscricao->evento->evento; ?></small></p>   
                            </div>
                            <div class="form-group col-md-6 text-right text-secondary">
                              <p><small>
                                <?php foreach ($inscricao->atividade->agenda as $agenda):
                                    echo date('d/m', strtotime($agenda->dia)) . '&nbsp&nbsp&nbsp' .
                                    date('H:i', strtotime($agenda->hora_inicio)) .'-' . 
                                    date('H:i', strtotime($agenda->hora_termino)) . '</br>';
                                endforeach;?>                       
                                </small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_open();?>
                <div class="form-group pt-3 text-center">                  
                    <?php echo form_submit('enviar', 'Desinscrever', array('class' => 'btn btn-primary shadow botao'));?>                
                    <a href="<?php echo base_url('home/listar_inscricoes/' . $id_participante) ?>" class="btn btn-danger shadow botao">Cancelar</a>
                </div>
                <?php echo form_close();?>              
            </div>
        </div>
    </div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php endswitch; ?>
<!--//====================================================================================================-->
<?php $this->load->view('footer'); ?>