<?php $this->load->view('header'); ?>
<script>
    window.onload = function(){
      carregar_fonte()
    }
</script>
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
        <div class="container my-2 border bg-white rounded shadow">
        <div class="py-1">    
          <div class="icone_campo form-group">
            <label for="filtro" class="text-secondary">Filtrar Participante</label>
            <input type="text" class="form-control shadow" id="filtro" onkeyup="filtrar_tabela()" placeholder="Digite o nome do Participante"><i class="fa fa-filter fa-lg fa-fw"></i>
          </div>
        </div>
      </div>          
        <?php $this->load->view('mensagem'); ?>        
        <?php if (isset($inscritos) && sizeof($inscritos) > 0): ?>
        <?php $acesso = $this->session->dados_participante['acesso'];?>
        <div class="table-responsive-md"> 
          <table class="table rounded shadow" align="center" id="tabela">
            <thead class="bg-success text-white" align="center">
              <tr class="rotulo-tabela">
                <th class="text-left">Chamada&nbsp&nbsp&nbsp<small>{ <?php echo sizeof($inscritos) ?> registro(s) }</small></br>Todos</th>
                <?php foreach ($agenda as $data):
                  echo form_open('chamada/presenca_total/', array('id' => 'todos', 'name' => 'todos'));

                    $data_evento = array('type' => 'hidden', 'name' => 'id_evento', 'id' => 'id_evento', 'value' => $evento->id_evento);
                    echo form_input($data_evento);

                    $data_atividade = array('type' => 'hidden', 'name' => 'id_atividade', 'id' => 'id_atividade', 'value' => $atividade->id_atividade);
                    echo form_input($data_atividade);

                    $data_agenda = array('type' => 'hidden', 'name' => 'id_agenda', 'id' => 'id_agenda', 'value' => $data->id_agenda);
                    echo form_input($data_agenda);                   
                  ?>
                  <th class="text-center"><?php echo date('d/m/y', strtotime($data->dia)) . "</br>" . form_checkbox('total', 'Total', $data->presencas, 'onChange="this.form.submit()"');
                  echo form_close();?>                    
                  </th>
                <?php endforeach; ?>
              </tr>  
            </thead>
            <tbody class="bg-white">                       
               <?php foreach ($inscritos as $inscrito): ?>
                <tr>
                  <?php if(recupera_permissao($acesso, PARTICIPANTES)): ?>
                    <td align="left" id="nome"><a href="<?php echo base_url('participante/exibir/' . $inscrito->participante_id)?>" class="text-dark"><?php echo $inscrito->nome; ?></a></td>
                  <?php else: ?>
                    <td align="left" id="nome"><?php echo $inscrito->nome; ?></td>
                  <?php endif; ?>               
                  <?php foreach ($inscrito->chamada as $chamada): ?>
                    <td class="text-center"><?php
                      echo form_open('chamada/editar/', array('id' => 'chamadas', 'name' => 'chamadas'));
                       
                        $data_atividade = array('type' => 'hidden', 'name' => 'id_atividade', 'id' => 'id_atividade', 'value' => $atividade->id_atividade);
                        echo form_input($data_atividade);

                        echo form_hidden('id_ausencia', $chamada->id_chamada);
                                                
                        $presenca = array('name' => 'id_presenca', 'id' => 'id_presenca', 'value' => $chamada->id_chamada, 'checked' => $chamada->presenca);
                        echo form_checkbox($presenca);                        
                      echo form_close();
                    ?></td>
                  <?php endforeach; ?>
                </tr>  
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>       
        <?php endif; ?>
        <div class="form-group pt-2 text-center">     
          <a href="<?php echo base_url('atividade/listar/' . $evento->id_evento)?>" class="btn btn-danger shadow botao">Voltar</a>
        </div>
        <div class="bg-success text-center rounded">
          <a href="<?php echo base_url('xlsxcertificados/xlsx/'.$atividade->evento_id.'/'.$atividade->id_atividade)?>" class="text-white">Lista participantes certificados xlsx</a>
        </div>        
      </div>      
    </div>
  </div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php endswitch; ?>
<?php $this->load->view('footer'); ?>