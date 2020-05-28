<?php $this->load->view('header'); ?>
<script>
   window.onload = function(){
   carregar_fonte()
   }
</script>
<?php switch($pagina):
//====================================================================================================
case 'listar': ?>
<?php if (defined('LISTAR_AREAS') == false) define('LISTAR_AREAS', 1);?>
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
      <a href="<?php echo base_url('area/cadastrar/')?>" class="text-secondary">Nova Área</a>
      </div>
   <div class="container col-6 text-right py-1">
      <div><a href="<?php echo base_url('area/cadastrar')?>" class="btn btn-success btn-sm shadow"><i class="fas fa-plus-square"></i> Cadastrar</a>
      </div>
   </div>
</div>
</div>
<div class="container my-3 border bg-white rounded shadow">
<div class="py-1">    
   <div class="icone_campo form-group">
      <label for="filtro" class="text-secondary">Filtrar Área</label>
      <input type="text" class="form-control shadow" id="filtro" onkeyup="filtrar_tabela()" placeholder="Digite a area"><i class="fa fa-filter fa-lg fa-fw"></i>
   </div>
</div>
</div>
<?php if(isset($areas) && sizeof($areas) > 0): ?>
<div class="table-responsive-md"> 
   <table class="table rounded shadow" align="center" id="tabela">
     <thead class="bg-success text-white" align="center">
     <tr class="rotulo-tabela">
      <th class="text-left">Área&nbsp&nbsp&nbsp<small>{ <?php echo sizeof($areas) ?> registro(s) }</small></th>    
   </tr>   
</thead>
<tbody class="bg-white">
   <?php foreach ($areas as $area): ?>
    <tr>
      <td align="left" id="nome"><a href="<?php echo base_url('area/exibir/' . $area->id_area) ?>" class="text-dark"><?php echo $area->area ?></td>      
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
<?php if (defined('CADASTRAR_AREAS') == false) define('CADASTRAR_AREAS', 2);?>
<section id="cadastrar" class="bg-cinza">
   <div class="container">
    <div class="row">
     <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
       <div class="border rounded my-3 shadow bg-success text-white">
         <h5 class="text-center my-2"><?php echo $titulo ?></h5>
      </div>
      <?php $this->load->view('mensagem'); ?>
      <?php echo form_open('area/cadastrar'); ?>
      <div class="icone_campo form-group">
         <?php echo form_label('Criar Área', 'area', array('class' => 'text-secondary')); ?>
         <?php echo form_input('area', set_value('area'), array('autofocus' => 'autofocus', 'class' => 'form-control shadow', 'placeholder' => 'Digite a área')); ?><i class="fas fa-plus"></i>
      </div>
      <div class="form-group pt-3 text-center">         
         <?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-success shadow botao')); ?>
         <a href="<?php echo base_url('area/listar')?>" class="btn btn-danger shadow botao">Cancelar</a>
      </div>
      <?php echo form_close(); ?>
   </div>
</div>
</div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'exibir': ?>
<?php if (defined('EXIBIR_AREAS') == false) define('EXIBIR_AREAS', 3);?>
<section id="exibir" class="bg-cinza">
   <div class="container">
    <div class="row">
     <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
       <div class="border rounded my-3 shadow bg-success text-white">
         <h5 class="text-center my-2"><?php echo $titulo ?></h5>
      </div>
      <?php $this->load->view('mensagem'); ?>
      <?php echo form_open(''); ?>
      <div class="icone_campo form-group">
         <?php echo form_label('Editar Área', 'area', array('class' => 'text-secondary')); ?>
         <?php echo form_input('area',set_value('area', $area->area), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-edit"></i>
      </div>
      <div class="form-group pt-3 text-center">        
        <a href="<?php echo base_url('area/editar/'  . $area->id_area) ?>" class="botao btn btn-success shadow">Editar</a>     
        <a href="<?php echo base_url('area/excluir/'  . $area->id_area) ?>" class=" botao btn btn-warning shadow">Excluir</a>
        <a href="<?php echo base_url('area/listar')?>" class="btn btn-danger shadow botao">Voltar</a>
      </div>
      <?php echo form_close(); ?>
   </div>
</div>
</div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'editar': ?>
<?php if (defined('EDITAR_AREAS') == false) define('EDITAR_AREAS', 3);?>
<section id="editar" class="bg-cinza">
   <div class="container">
    <div class="row">
     <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
       <div class="border rounded my-3 shadow bg-success text-white">
         <h5 class="text-center my-2"><?php echo $titulo ?></h5>
      </div>
      <?php $this->load->view('mensagem'); ?>

      <?php echo form_open(''); ?>
      <div class="icone_campo form-group">
         <?php echo form_label('Editar Área', 'area', array('class' => 'text-secondary')); ?>
         <?php echo form_input('area',set_value('area', $area->area), array('autofocus' => 'autofocus', 'class' => 'form-control shadow')); ?><i class="fas fa-edit"></i>
      </div>
      <div class="form-group pt-3 text-center">         
         <?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-success shadow botao')); ?>
         <a href="<?php echo base_url('area/exibir/'  . $area->id_area)?>" class="btn btn-danger shadow botao">Cancelar</a>
      </div>
      <?php echo form_close(); ?>
   </div>
</div>
</div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php case 'excluir': ?>
<?php if (defined('EXCLUIR_AREAS') == false) define('EXCLUIR_AREAS', 4);?>
<section id="excluir" class="bg-cinza">
   <div class="container">
    <div class="row">
     <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
       <div class="border rounded my-3 shadow bg-success text-white">
         <h5 class="text-center my-2"><?php echo $titulo ?></h5>
      </div>
      <?php $this->load->view('mensagem'); ?>
      <?php echo form_open(''); ?>
      <div class="icone_campo form-group">
         <?php echo form_label('Excluir Área', 'area', array('class' => 'text-secondary')); ?>
         <?php echo form_input('area',"$area->area", array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-edit"></i>
      </div>
      <div class="form-group pt-3 text-center">         
         <?php echo form_submit('enviar', 'Excluir', array('class' => 'btn btn-success shadow botao')); ?>
         <a href="<?php echo base_url('area/exibir/'  . $area->id_area)?>" class="btn btn-danger shadow botao">Cancelar</a>
      </div>
      <?php echo form_close(); ?>
   </div>
</div>
</div>
</section>
<?php break; ?>
<!--//====================================================================================================-->
<?php endswitch; ?>
<!--//====================================================================================================-->
<?php $this->load->view('footer');?>