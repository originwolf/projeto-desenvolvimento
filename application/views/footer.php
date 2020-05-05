 <!-- Footer -->
 <footer class="py-5 bg-verde text-white">
  <div class="container">
    <p class="m-0 text-center">Copyright &copy; SISCONEVE 2018</p>
</div>     
</footer>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.bundle.min.js')?>"></script>
<!-- Plugin JavaScript -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.easing.min.js')?>"></script>
<!-- JavaScript customizado para este tema -->
<script type="text/javascript" src="<?php echo base_url('assets/js/scrolling-nav.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.3.1.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.mask.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-te-1.4.0.min.js')?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/funcoes.js')?>"></script>
<script type="text/javascript">




  $(document).ready(function(){
    $('.cpf').mask('999.999.999-99');
    $('.celular').mask('(99) 9 9999-9999');
    $('.telefone').mask('(99) 9999-9999');
    $('.data').mask('99/99/9999');
    $('.hora').mask('99:99');
    $('input#id_presenca').change(function() {
      var $this = $(this);
      var evento = document.getElementById("id_evento").value;
      var atividade = document.getElementById("id_atividade").value;
      var ausencia = $this.attr("value");
      var presenca = $this.attr("value");
      if($this.is(":checked")){
        $.ajax({
          url : "<?php echo base_url('chamada/editar'); ?>",
          type : "POST",
          dataType : "json",
          data : {"id_evento" : evento, "id_atividade" : atividade, "id_ausencia" : ausencia, "id_presenca" : presenca}
        });
      }else{  
        $.ajax({
          url : "<?php echo base_url('chamada/editar'); ?>",
          type : "POST",
          dataType : "json",
          data : {"id_evento" : evento, "id_atividade" : atividade, "id_ausencia" : ausencia}
        });
     }      
    });
  });

  $('.editor_html').jqte();
</script>
</html>
