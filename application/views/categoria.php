
<?php $this->load->view('header'); ?>
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
        <?php $this->load->view('mensagem'); ?>      
      <div class="container my-3 border bg-white rounded shadow">
        <div class="row">
          <div class="container col-6 text-left py-2">
            <a href="<?php echo base_url('categoria/cadastrar')?>" class="text-secondary">Nova Categoria</a>
          </div>
          <div class="container col-6 text-right py-1">
            <div><a href="<?php echo base_url('categoria/cadastrar')?>" class="btn btn-primary btn-sm shadow"><i class="fas fa-plus-square"></i> Cadastrar</a>
            </div>
          </div>
        </div>
      </div>      
      <div class="container my-3 border bg-white rounded shadow">
       <div class="py-1">    
        <div class="icone_campo form-group">
         <label for="filtro" class="text-secondary">Filtrar Categoria</label>
         <input type="text" class="form-control shadow" id="filtro" onkeyup="filtrar_tabela()" placeholder="Digite a categoria"><i class="fa fa-filter fa-lg fa-fw"></i>
       </div>
     </div>
   </div>   
   <?php if(isset($categorias) && sizeof($categorias) > 0): ?>    
    <div class="table-responsive-md"> 
    <table class="table rounded shadow" align="center" id="tabela">     
     <thead class="bg-primary text-white" align="center"> 
      <tr class="rotulo-tabela">
          <th class="text-left">Categoria&nbsp&nbsp&nbsp<small>{ <?php echo sizeof($categorias) ?> registro(s) }</small></th>          
      </tr>       
     </thead>     
     <tbody class="bg-white">       
       <?php foreach ($categorias as $categoria): ?>
         <tr>          
           <td align="left" id="nome"><a href="<?php echo base_url('categoria/exibir/' . $categoria->id_categoria) ?>" class="text-dark"><?php echo $categoria->categoria ?></a>
           </td>           
         </tr>   
       <?php endforeach; ?>
     </tbody>
   </table>
   </div>
 <?php endif; ?>
  <div class="form-group pt-2 text-center">      
    <a href="<?php echo base_url('home')?>" class="btn btn-secondary shadow botao">Voltar</a>
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
     <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
      <div class="border rounded my-3 shadow bg-primary text-white">
       <h5 class="text-center my-2"><?php echo $titulo ?></h5>
     </div>        
        <?php $this->load->view('mensagem'); ?>
  <?php echo form_open('categoria/cadastrar'); ?>
  <div class="icone_campo form-group">
    <?php echo form_label('Criar Categoria', 'categoria', array('class' => 'text-secondary')); ?>
    <?php echo form_input('categoria', set_value('categoria'), array('autofocus' => 'autofocus', 'class' => 'form-control shadow', 'placeholder' => 'Digite a categoria')); ?><i class="fas fa-plus"></i>
  </div>
  <div class="form-group pt-3 text-center">         
    <?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-primary shadow botao')); ?>
    <a href="<?php echo base_url('categoria/listar')?>" class="btn btn-danger shadow botao">Cancelar</a>
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
     <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
      <div class="border rounded my-3 shadow bg-primary text-white">
       <h5 class="text-center my-2"><?php echo $titulo ?></h5>
     </div>        
        <?php $this->load->view('mensagem'); ?>
  <?php echo form_open(''); ?>  
  <div class="icone_campo form-group">
    <?php echo form_label('Editar Categoria', 'categoria', array('class' => 'text-secondary')); ?>
    <?php echo form_input('categoria', set_value('categoria', $categoria->categoria), array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-edit"></i>
  </div>  
  <div class="form-group pt-3 text-center">
      <a href="<?php echo base_url('categoria/editar/') . $categoria->id_categoria ?>" class="botao btn btn-primary shadow">Editar</i></a>
      <a href="<?php echo base_url('categoria/excluir/') . $categoria->id_categoria ?>" class=" botao btn btn-danger shadow">Excluir</a>    
      <a href="<?php echo base_url('categoria/listar')?>" class="btn btn-secondary shadow botao">Voltar</a>
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
     <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
      <div class="border rounded my-3 shadow bg-primary text-white">
       <h5 class="text-center my-2"><?php echo $titulo ?></h5>
     </div>        
        <?php $this->load->view('mensagem'); ?>
  <?php echo form_open(''); ?>  
  <div class="icone_campo form-group">
    <?php echo form_label('Editar Categoria', 'categoria', array('class' => 'text-secondary')); ?>
    <?php echo form_input('categoria', set_value('categoria', $categoria->categoria), array('autofocus' => 'autofocus', 'class' => 'form-control shadow')); ?><i class="fas fa-edit"></i>
  </div>  
  <div class="form-group pt-3 text-center">         
    <?php echo form_submit('enviar', 'Salvar', array('class' => 'btn btn-primary shadow botao')); ?>
    <a href="<?php echo base_url('categoria/listar')?>" class="btn btn-danger shadow botao">Cancelar</a>
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
     <div class="col-md-12 mx-auto bg-light rounded shadow p-3">
      <div class="border rounded my-3 shadow bg-primary text-white">
       <h5 class="text-center my-2"><?php echo $titulo ?></h5>
     </div>        
        <?php $this->load->view('mensagem'); ?>
  <?php echo form_open(''); ?>  
  <div class="icone_campo form-group">
    <?php echo form_label('Excluir Categoria', 'categoria', array('class' => 'text-secondary')); ?>
    <?php echo form_input('categoria',"$categoria->categoria", array('class' => 'form-control shadow', 'readonly' => 'TRUE')); ?><i class="fas fa-edit"></i>
  </div>
  <div class="form-group pt-3 text-center">         
    <?php echo form_submit('enviar', 'Excluir', array('class' => 'btn btn-primary shadow botao')); ?>
    <a href="<?php echo base_url('categoria/exibir/' . $categoria->id_categoria)?>" class="btn btn-danger shadow botao">Cancelar</a>
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
<?php $this->load->view('footer'); ?>